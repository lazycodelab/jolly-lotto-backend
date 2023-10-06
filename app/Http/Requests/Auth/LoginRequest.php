<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email'    => ['required', 'string', 'email'],
			'password' => ['required', 'string'],
		];
	}

	/**
	 * Attempt to authenticate the request's credentials.
	 *
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function authenticate()
	{
		$this->ensureIsNotRateLimited();

		$this->login($this->email, $this->password);

	}

	private function getAuthToken()
	{
		$token = Cache::get('api_token');
		$tokenResponse = Http::withoutVerifying()->post('http://gateway.cloudandahalf.com/crow/api/auth/token',[
				'clientId'       => env('API_KEY'),
				'clientSecurity' => env('API_SECRET'),
			]
		);
		$token = $tokenResponse->body();
		Cache::put('api_token', $token, now()->addMinutes(60));		
		return $token;
	}

	public function login($email, $password)
	{
		$response = Http::lotto()->post('/auth/signin', [
			'email'    => $email,
			'password' => $password
		]);

		// @todo Move this logic to a separate file.
		if ($response->status() === 401 || $response->status() === 403) {
			// The token has expired.
			$this->getAuthToken();
			$this->login($email, $password);
		} else if($response->status() === 200) {
			$user = $response->json();

			if ($user['statusCode'] === 200) {
				// Now fetch user details.
				$userDetails = Http::lotto()->get('/JL/accounts/' . $user['userId'] . '/details');

				if ($userDetails->status() === 401 || $userDetails->status() === 403) {
					$this->getAuthToken();
					$userDetails = Http::lotto()->get('/JL/accounts/' . $user['userId'] . '/details');
				}

				$userDetails = $userDetails->json();

				if ($userDetails && $userDetails['isSuccess'] === true) {
					$userData = array_merge($user, $userDetails);

					session(['user' => $userData]);

					RateLimiter::clear($this->throttleKey());
				} else {
					throw ValidationException::withMessages([
						'email' => trans($userDetails['error']),
					]);
				}
			} else {
				throw ValidationException::withMessages([
					'email' => trans($user['message']),
				]);
			}
		} else {
			throw ValidationException::withMessages([
				'email' => trans('This account is not available. Server error.'),
			]);
		}
	}

	/**
	 * Ensure the login request is not rate limited.
	 *
	 * @return void
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function ensureIsNotRateLimited()
	{
		if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
			return;
		}

		event(new Lockout($this));

		$seconds = RateLimiter::availableIn($this->throttleKey());

		throw ValidationException::withMessages([
			'email' => trans('auth.throttle', [
				'seconds' => $seconds,
				'minutes' => ceil($seconds / 60),
			]),
		]);
	}

	/**
	 * Get the rate limiting throttle key for the request.
	 *
	 * @return string
	 */
	public function throttleKey()
	{
		return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
	}
}
