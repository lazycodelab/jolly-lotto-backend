<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyEmailController extends Controller
{
	/**
	 * Mark the authenticated user's email address as verified.
	 *
	 * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function __invoke(EmailVerificationRequest $request)
	{
		if ($request->user()->hasVerifiedEmail()) {
			return redirect()->intended(
				config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
			);
		}

		if ($request->user()->markEmailAsVerified()) {
			event(new Verified($request->user()));
		}

		return redirect()->intended(
			config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
		);
	}

	public function validateHash(Request $request)
	{
		$hash = explode('?p=', $request->fullUrl());
		$response = Http::lotto()->get("/auth/confirmemailaddress/" . $hash[1]);
		// if ($response->status() === 200) {
		// 	$this->updateUserData('verifyEmail');
		// 	return $this->redirectAfterVerification();
		// }
	}

	public function redirectAfterVerification()
	{
		$products = session('products');
		if ($products === null || empty($products)) {
			return redirect()->intended(
				config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
			);
		} else {
			if (count($products) === 1) {
				return redirect()->intended(
					config('app.frontend_url') . '/lotteries/' . $products['productID']
				);
			} else {
				$maxTimestamp = 0;
				foreach ($products as $product) {
					if ($product['time'] > $maxTimestamp) {
						$maxTimestamp = $product['time'];
						$lastProduct = $product;
					}
				}
				if ($lastProduct !== null) {
					return redirect()->intended(
						config('app.frontend_url') . '/lotteries/' . $lastProduct['productID']
					);
				} else {
					return redirect()->intended(
						config('app.frontend_url') . RouteServiceProvider::HOME . '?verified=1'
					);
				}
			}
		}
	}

	public function updateUserData($updateType)
	{
		$userID = session()->get('user.userId');
		$currentSessionDetails = session()->get('user', null);
		$response = Http::lotto()->get("/JL/accounts/$userID/details");
		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
		} else if ($response->status() === 404) {
			return response()->json(['status' => 'error', 'message' => 'No response from server. - ' . $response->status()], 200);
		} else if ($response->status() === 200) {
			$updateData = $response->json();
			if ($updateType === 'removeFunds') {
				$currentSessionDetails['wallet']['available'] = $updateData['wallet']['available'];
				$currentSessionDetails['wallet']['withDrawal'] = $updateData['wallet']['withDrawal'];
				session(['user' => $currentSessionDetails]);
			} else if ($updateType === 'verifyEmail') {
				$currentSessionDetails['status']['isEmailConfirmed'] = $updateData['status']['isEmailConfirmed'];
				session(['user' => $currentSessionDetails]);
			}
			return $currentSessionDetails;
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'], 200);
		}
	}

	public function resendEmail(Request $request)
	{
		$userID = session()->get('user.userId');
		$response = Http::lotto()->get('/auth/resendconfirmemailaddress/' . $userID);
		if ($response->status() === 200) {
			$data = $response->json();
			if ($data['isSuccessStatusCode'] === true || isset($data['isSuccessStatusCode'])) {
				return response()->json(['status' => 'success', 'message' => 'Email sent successfully.'], 200);
			} else {
				return response()->json(['status' => 'error', 'message' => 'Server Error'], 500);
			}
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again later.'], 500);
		}
	}
}
