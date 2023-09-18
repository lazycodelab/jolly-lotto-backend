<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
	public function index()
	{
		$userID = session()->get('user.profile.id');

		$response = Http::lotto()->get('/JL/accounts/' . $userID . '/paymentmethods');

		if ($response->status() === 404) {
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

			$response = Http::lotto()->get('/JL/accounts/' . $userID . '/paymentmethods');

			// Again 404? Edge case.
			if ($response->status() === 404) {
				throw ValidationException::withMessages([
					'email' => trans('This account is not available. Server error.'),
				]);
			}
		} else {
			return $response->json();
		}
	}

	public function store(Request $request)
	{
		$userID   = $request->id;
		$response = Http::lotto()->post('/JL/accounts/' . $userID . '/addfund', [
			"amount"        => $request->amount,
			"currencyCode"  => "GBP",
			"paymentMethod" => [
				"cardHolder"        => $request->cardHolder,
				"paymentMethodCode" => $request->paymentMethodCode,
				"cardNumber"        => $request->cardNumber,
				"cvv"             	=> $request->cardCVV,
				"expiryMonth"       => $request->expiryMonth,
				"expiryYear"        => $request->expiryYear
			]
		]
		);

		// @todo Move this logic to a separate file.
		if ($response->status() === 404) {
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

			$response = Http::lotto()->post('/JL/accounts/' . $userID . '/addfund', [
				"amount"        => $request->amount,
				"currencyCode"  => "GBP",
				"paymentMethod" => [
					"cardHolder"        => $request->cardHolder,
					"paymentMethodCode" => $request->paymentMethodCode,
					"cardNumber"        => $request->cardNumber,
					"cvv"               => $request->cardCVV,
					"expiryMonth"       => $request->expiryMonth,
					"expiryYear"        => $request->expiryYear
				]
			]
			);

			// Again 404? Edge case.
			if ($response->status() === 404) {
				throw ValidationException::withMessages([
					'email' => trans('This account is not available. Server error.'),
				]);
			}
		}

		$data = $response->json();
		if (isset($data['successed']) && $data['successed'] !== true) {
			throw ValidationException::withMessages([
				'amount' => trans($data['message']),
			]);
		}
	}

	public function storeGateway(Request $request)
	{
		//$userID   = session()->get('user.profile.id');
		// $userID   = $request->id;
		$userID   = '052199cc-84c3-4e16-3d92-08db198b198f';
		$response = Http::lotto()->post('/JL/accounts/' . $userID . '/addpaymentmethod', [
			"paymentMethodCode" => 1,
			"cardHolder"        => $request->cardHolder,
			"cardNumber"        => $request->cardNumber,
			"encCardNumber"     => "",
			"cvv"               => $request->cvv,
			"encCvv"            => "",
			"expiryMonth"       => $request->month,
			"expiryYear"        => $request->year
		]
		);

		//echo '<pre>';
		//print_r($response->json());
		//echo '</pre>';
		//die();

		// @todo Move this logic to a separate file.
		if ($response->status() === 404) {
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

			$response = Http::lotto()->post('/JL/accounts/' . $userID . '/addpaymentmethod', [
				"paymentMethodCode" => 1,
				"cardHolder"        => $request->cardHolder,
				"cardNumber"        => $request->cardNumber,
				"encCardNumber"     => "",
				"cvv"               => $request->cvv,
				"encCvv"            => "",
				"expiryMonth"       => $request->month,
				"expiryYear"        => $request->year
			]
			);

			// Again 404? Edge case.
			if ($response->status() === 404) {
				throw ValidationException::withMessages([
					'email' => trans('This account is not available. Server error.'),
				]);
			}
		}

		$data = $response->json();
		if (isset($data['success']) && $data['success'] !== true) {
			throw ValidationException::withMessages([
				'method' => trans($data['message']),
			]);
		}
	}
}
