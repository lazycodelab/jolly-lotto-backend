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
            'email' => ['required', 'string', 'email', 'max:255'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'email' => $this->email,
			'password' => $this->password,
			'confirmPassword' => $this->password_confirmation,
			'minimumLegalAge' => 18,
			'birthDate' => $this->birthDate,
			'billingAddress' => $this->billingAddress,
		]);

		if ( $response->status() === 404) {
			// The token has expired.
			$token = Http::withoutVerifying()
				->withOptions(
					[
						'verify' => false,
					]
				)->post(
					'http://gateway.cloudandahalf.com/crow/api/auth/token',
					[
						'clientId' => env('API_KEY'),
						'clientSecurity' => env('API_SECRET'),
					]
				);

				// store cache for a day.
				// @todo: maybe fix this logic.
			Cache::put('api_token', $token->body(), now()->addMinutes(1440));

			$response = Http::lotto()->post('/auth/register', [
				'firstName' => $this->firstName,
				'lastName' => $this->lastName,
				'email' => $this->email,
				'password' => $this->password,
				'confirmPassword' => $this->password_confirmation,
				'minimumLegalAge' => 18,
				'birthDate' => $this->birthDate,
				'billingAddress' => $this->billingAddress,
			]);

			// Check if the response is still 404.
			if ($response->status() === 404) {
				throw ValidationException::withMessages([
					'email' => trans('No response from server. - ' . $response->status()),
				]);
			}
		}

		if ( $response->status() === 200) {
			$user = $response->json();

			if ($user['succeeded'] === false) {
				throw ValidationException::withMessages([
					'email' => trans($user['message']),
				]);
			}

			// Login the user.
			$loginReq = Http::lotto()->post('/auth/signin', [
				'email' => $this->email,
				'password' => $this->password
			]);

			$loggedInUser = $loginReq->json();

			if ( $loggedInUser['statusCode'] === 200) {
				session(['user' => $loggedInUser]);
			} else {
				throw ValidationException::withMessages([
					'email' => trans($loggedInUser['message']),
				]);
			}
		} else {
			throw ValidationException::withMessages([
				'email' => trans('No response from server. - ' . $response->status()),
			]);
		}
    }
}
