<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'email'           => ['required', 'string', 'email', 'max:255'],
			'firstName'       => ['required', 'string', 'max:255'],
			'lastName'        => ['required', 'string', 'max:255'],
			'password'        => ['required', 'confirmed', Rules\Password::defaults()],
			'minimumLegalAge' => ['required', 'integer', 'gte:18'],
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

		$response = Http::lotto()->post('/auth/register', [
			'firstName'       => $this->firstName,
			'lastName'        => $this->lastName,
			'email'           => $this->email,
			'password'        => $this->password,
			'confirmPassword' => $this->password_confirmation,
			'minimumLegalAge' => 18,
			'birthDate'       => $this->birthDate,
			'billingAddress'  => $this->billingAddress,
			'sitecode'        => 'JL',
		]);

		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			// Retry registration
			$this->authenticate();
		} else if($response->status() === 404) {
			throw ValidationException::withMessages([
				'email' => trans('No response from server. - ' . $response->status()),
			]);
		} else {
			if ($response->status() === 200) {
				$user = $response->json();
	
				if ($user['succeeded'] === false) {
					throw ValidationException::withMessages([
						'email' => trans($user['message']),
					]);
				}
	
				$login = new LoginRequest();
				$login->login($this->email, $this->password);
			} else {
				throw ValidationException::withMessages([
					'email' => trans('No response from server. - ' . $response->status()),
				]);
			}
		}		
	}

	private function getAuthToken()
	{
		$token = Cache::get('api_token');

		$tokenResponse = Http::withoutVerifying()->post('http://gateway.cloudandahalf.com/crow/api/auth/token',[
				'clientId'       => env('API_KEY'),
				'clientSecurity' => env('API_SECRET'),
			]
		);

		if($tokenResponse->body() !== $token) {
			Cache::put('api_token', $tokenResponse->body(), now()->addMinutes(60));
			$token = $tokenResponse->body();
		}

		return $token;
	}
}
