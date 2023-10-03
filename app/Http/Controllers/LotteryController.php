<?php

namespace App\Http\Controllers;
use App\Models\Lottery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LotteryController extends Controller
{
	public function bulkStore(int $productID, array $item)
	{
			$balls = [
				'total' => $item['numOfBalls'],
				'min' => $item['minBallNumber'],
				'max' => $item['maxBallNumber'],
			];

			// Has bonus balls data.
			if (!empty($item['bonusBalls'])) {
				$balls['bonus'] = $item['bonusBalls'];

				foreach ($item['bonusBalls'] as $bonusBall) {
					//.
				}
			}

			Lottery::updateOrCreate(
				['product_id' => $productID],
				[
					'start_date' => $item['start_date'],
					'country_code' => $item['countryCode'],
					'currency_code' => $item['currencyCode'],
					'cut_offs' => $item['cutOffs'],
					'draw_dates' => $item['drawDays'],
					'balls' => $balls,
				]
			);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	public function results(Lottery $lottery)
	{
		return $lottery->results;
	}

	public function fetchBetHistory() {
		$userID = session()->get('user.profile.id');
		
		$response = Http::lotto()->post('/JL/accounts/' . $userID . '/orders/search', [
			"transactionNumber" => "",
			"startTime" => "",
			"endTime" => "",
			"transactionTypeCode" => "",
			"transactionStatusCode" => "",
		]);

		if ($response->status() === 200) {
			$data = $response->json();
			if($data['succeeded'] === true || isset($data['succeeded'])) {
				if (count($data['results']) > 0) {
					return response()->json(['status' => 'success', 'data' => $data['results']] , 200);
				} else {
					return response()->json(['status' => 'warning', 'message' => 'Transaction history not found'] , 200);
				}
			} else {
				return response()->json(['status' => 'error', 'message' => 'Something went wrong, Please try again later'] , 200);
			}
		} else if ($response->status() === 401 || $response->status() === 403) {
			$this->getAuthToken();
			$this->fetchBetHistory();
		} else {
			return response()->json(['status' => 'error', 'message' => 'Server Error, Please try again later'] , 200);
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
