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

		$response = Http::lotto()->post('/auth/signin', [
			'email'    => $this->email,
			'password' => $this->password
		]);

		// @todo Move this logic to a separate file.
		if ($response->status() !== 200) {
			// The token has expired.
			$token = Http::withoutVerifying()
				->withOptions(
					[
						'verify' => false,
					]
				)->post(
					'http://gateway.cloudandahalf.com/crow/api/auth/token',
					[
						'clientId'       => env('API_KEY'),
						'clientSecurity' => env('API_SECRET'),
					]
				);

			// store cache for a day.
			// @todo: maybe fix this logic.
			Cache::put('api_token', $token->body(), now()->addMinutes(1440));

			$response = Http::lotto()->post('/auth/signin', [
				'email'    => $this->email,
				'password' => $this->password
			]);

			echo '<pre>';
			print_r($response->status());
			echo '</pre>';
			// Again 404? Edge case.
			if ($response->status() !== 200) {
				throw ValidationException::withMessages([
					'email' => trans('This account is not available. Server error.'),
				]);
			}
		} else {
			$user = $response->json();

			echo '<pre>';
			print_r($user);
			echo '</pre>';

			if ($user['statusCode'] === 200) {
				// Now fetch user details.
				//dd($user);

				$userDetails = Http::lotto()->get('/JL/accounts/' . $user['userId'] . '/details');
				if ($userDetails->status() !== 200) {
					$token = Http::withoutVerifying()
						->withOptions(
							[
								'verify' => false,
							]
						)->post(
							'http://gateway.cloudandahalf.com/crow/api/auth/token',
							[
								'clientId'       => env('API_KEY'),
								'clientSecurity' => env('API_SECRET'),
							]
						);

					// store cache for a day.
					// @todo: maybe fix this logic.
					Cache::put('api_token', $token->body(), now()->addMinutes(1440));

					$userDetails = Http::lotto()->get('/JL/accounts/' . $user['userId'] . '/details');
				}

				$userDetails = $userDetails->json();

				if ($userDetails && $userDetails['isSuccess'] === true) {
					$userData = array_merge($user, $userDetails);

					session(['user' => $userData]);

					RateLimiter::clear($this->throttleKey());
				}
			} else {
				throw ValidationException::withMessages([
					'email' => trans($user['message']),
				]);
			}
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
