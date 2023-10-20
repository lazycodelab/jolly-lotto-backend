<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
	/**
	 * Handle an incoming authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(LoginRequest $request)
	{
		$request->authenticate();

		$request->session()->regenerate();

		return response()->noContent();
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		
		$keysToKeep = ['products']; // Add keys you want to keep here.
		$allSessionKeys = array_keys($request->session()->all());
		$keysToRemove = array_diff($allSessionKeys, $keysToKeep);
		$request->session()->forget($keysToRemove);
		Auth::guard('web')->logout();
		return response()->noContent();
	}

	public function update(Request $request)
	{
		$response = Http::lotto()->post('/JL/accounts/update', [
			'id'             => $request->id,
			'firstName'      => $request->firstName,
			'lastName'       => $request->lastName,
			'email'          => $request->email,
			'birthDate'      => $request->birthDate,
			'billingAddress' => $request->billingAddress,
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
			Cache::put('api_token', $token->body(), now()->addMinutes(60));

			$response = Http::lotto()->post('/JL/accounts/update', [
				'id'             => $request->id,
				'firstName'      => $request->firstName,
				'lastName'       => $request->lastName,
				'email'          => $request->email,
				'birthDate'      => $request->birthDate,
				'billingAddress' => $request->billingAddress,
			]);

			// Again 404? Edge case.
			if ($response->status() === 404) {
				throw ValidationException::withMessages([
					'email' => trans('This account is not available. Server error.'),
				]);
			}
		} else {
			$response = $response->json();

			if ($response['statusCode'] === 200) {
				$userDetails = Http::lotto()->get('/JL/accounts/' . $response['result']['userId'] . '/details')->json();

				if ($userDetails && $userDetails['isSuccess'] === true) {
					$user     = session()->get('user', []);
					$userData = array_merge($user, $userDetails);

					session()->put('user', $userData);
					return ['success' => true];
				}

				throw ValidationException::withMessages([
					'email' => trans($userDetails['error']),
				]);

			} else {
				throw ValidationException::withMessages([
					'email' => trans($response['message']),
				]);
			}
		}
	}
}
