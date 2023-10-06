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

		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->index();
		} else if($response->status() === 404) {
			throw ValidationException::withMessages([
				'email' => trans('This account is not available. Server error.'),
			]);
		} else {
			return $response->json();
		}
	}

	public function store(Request $request)
	{
		$userID = session()->get('user.profile.id');
		// $userID   = $request->id;
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
		} else {
			return response()->json(['status' => 'success', 'message' => $data['message']] , 200);
		}
	}

	public function storeGateway(Request $request)
	{
		$userID   = session()->get('user.profile.id');
		$response = Http::lotto()->post('/JL/accounts/' . $userID . '/addpaymentmethod', [
			"paymentMethodCode" => 1,
			"cardHolder"        => $request->cardHolder,
			"cardNumber"        => $request->cardNumber,
			"encCardNumber"     => "",
			"cvv"               => $request->cvv,
			"encCvv"            => "",
			"expiryMonth"       => $request->month,
			"expiryYear"        => $request->year
			// This API has Billing Address but it's not working.
			// "billingAddress" => json_encode([
			// 	"street" => isset($request->address) || !empty($request->address) ? $request->address : session()->get('user.profile.billingAddress.street'),
			// 	"city" => isset($request->city) || !empty($request->city) ? $request->city : session()->get('user.profile.billingAddress.city'),
			// 	"postalCode" => isset($request->postalCode) || !empty($request->postalCode) ? $request->postalCode : session()->get('user.profile.billingAddress.postalCode'),
			// 	"state" => isset($request->state) || !empty($request->state) ? $request->state : session()->get('user.profile.billingAddress.state'),
			// 	"country" => isset($request->country) || !empty($request->country) ? $request->country : session()->get('user.profile.billingAddress.country')
			// ])
		]);

		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->storeGateway($request);
		} else if ($response->status() === 404) {
			throw ValidationException::withMessages([
				'email' => trans('This account is not available. Server error.'),
			]);
		} else {
			if ($response->status() === 200) {
				$data = $response->json();
				if (isset($data['success']) && $data['success'] !== true) {
					return response()->json(['status' => 'error', 'message' => $data['message']] , 200);
				} else {
					return response()->json(['status' => 'success', 'message' => $data['message']] , 200);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'] , 200);
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

	public function deleteGateway($id) {
		$userID = session()->get('user.profile.id');
		$response = Http::lotto()->delete("/JL/accounts/$userID/deletepaymentmethod/$id");
		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->deleteGateway($id);
		} else if($response->status() === 404) {
			return response()->json(['status' => 'error', 'message' => 'No response from server. - ' . $response->status()] , 200);
		} else if($response->status() === 200) {
			return response()->json(['status' => 'success', 'message' => 'Payment method deleted successfully!'] , 200);
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'] , 200);
		}
	}

	public function getUserLimit() {
		$userID = session()->get('user.profile.id');
		$response = Http::lotto()->get("/JL/accounts/$userID/limits");
		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->getUserLimit();
		} else if($response->status() === 404) {
			return response()->json(['status' => 'error', 'message' => 'No response from server. - ' . $response->status()] , 200);
		} else if($response->status() === 200) {
			if($response['success'] === true) {
				return response()->json(['status' => 'success', 'data' => $response['limits']] , 200);
			} else {
				return response()->json(['status' => 'warning', 'message' => $response['message']] , 200);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'] , 200);
		}
	}

	public function updateUserLimit(Request $request) {
		$userID = session()->get('user.profile.id');
		$response = Http::lotto()->post("/JL/accounts/adjustLimits",[
			"accountId" => $userID,
			"currencyCode" => "",
			"limits" => [
				[
					"NewLimitAmount" => $request->playLimit['limit'],
					"transactionTypeCode" => 4,
					"durationInDays" => $request->playLimit['duration'],
					"startTime" => NULL
				],
				[
					"NewLimitAmount" => $request->depositLimit['limit'],
					"transactionTypeCode" => 4,
					"durationInDays" => $request->depositLimit['duration'],
					"startTime" => NULL
				]
			]
		]);
		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->updateUserLimit($request);
		} else if($response->status() === 404) {
			return response()->json(['status' => 'error', 'message' => 'No response from server. - ' . $response->status()] , 200);
		} else if($response->status() === 200) {
			if($response['succeeded'] === true) {
				return response()->json(['status' => 'success', 'message' => $response['message']] , 200);
			} else {
				return response()->json(['status' => 'warning', 'message' => $response['message']] , 200);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'] , 200);
		}
	}
}
