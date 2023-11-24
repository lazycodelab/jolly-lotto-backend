<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function storeShoppingCart(Request $request) {
        $ticketsData = $request->tickets; // Assuming you receive this array from the front end
        $tickets = [];

        foreach ($ticketsData as $ticket) {
            $ticketItem = [
                "numbers" => $ticket['numbers'],
                "bonusNumbers" => $ticket['bonusNumbers']
            ];

            $tickets[] = $ticketItem;
        }
		$response = Http::lotto()->post('/JL/accounts/shoppingcart/save', [
            "contactId"     => $request->contactID,
            "currencyCode"  => "GBP",
            "items" => [
                [
                    "productId"      => $request->productID,
                    "productCode"    => $request->productCode,
                    "itemName"       => $request->itemName,
                    "itemType"       => "SinglePlay",
                    "quantity"       => count($ticketsData),
                    "unitPrice"      => $request->unitPrice,
                    "isAutoRenewal"  => false,
                    "weeksNumber"    => $request->weekNumber,
                    "drawDays"       => $request->drawDays,
                    "wheelId"        => "",
                    "lotteryId"      => $request->lotteryID,
                    "useWheelSystem" => false,
                    "tickets"        => $tickets
                ]
            ]
        ]);

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
			Cache::put('api_token', $token->body(), now()->addMinutes(60));

			$response = Http::lotto()->post('/JL/accounts/shoppingcart/save', [
                "contactId"     => $request->contactID,
                "currencyCode"  => "GBP",
                "items" => [
                    [
                        "productId"      => $request->productID,
                        "productCode"    => $request->productCode,
                        "itemName"       => $request->itemName,
                        "itemType"       => "SinglePlay",
                        "quantity"       => count($ticketsData),
                        "unitPrice"      => $request->unitPrice,
                        "isAutoRenewal"  => false,
                        "weeksNumber"    => $request->weekNumber,
                        "drawDays"       => $request->drawDays,
                        "wheelId"        => "",
                        "lotteryId"      => $request->lotteryID,
                        "useWheelSystem" => false,
                        "tickets"        => $tickets
                    ]
                ]
            ]);

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
            $response = Http::lotto()->post('/JL/accounts/shoppingcart/checkout', [
                "contactId" => $request->contactID,
            ]);
            $data = $response->json();
            if (isset($data)) {
                if (!isset($data['suceess'])) {
                    if ($data['succeeded'] !== false) {
                        $this->updateUserData('removeFunds');
                        return response()->json(['status' => 'success', 'message' => 'Your order has been successfully placed, and here is your order number - '.$data['orderNumber']], 200);
                    } else {
                        return response()->json(['status' => 'error', 'message' => $data['message']] , 200);
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => $data['message']] , 200);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please Try again later!'] , 200);
            }
        }
	}

    public function updateUserData($updateType) {
		$userID = session()->get('user.userId');
		$currentSessionDetails = session()->get('user', null);
		$response = Http::lotto()->get("/JL/accounts/$userID/details");
		if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
		} else if($response->status() === 404) {
			return response()->json(['status' => 'error', 'message' => 'No response from server. - ' . $response->status()] , 200);
		} else if($response->status() === 200) {
			$updateData = $response->json();
			if($updateType === 'removeFunds') {
				$currentSessionDetails['wallet']['available'] = $updateData['wallet']['available'];
				$currentSessionDetails['wallet']['withDrawal'] = $updateData['wallet']['withDrawal'];
				session(['user' => $currentSessionDetails]);
			}
			return $currentSessionDetails;
		} else {
			return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later!'] , 200);
		}
	}
}
