<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ResultController extends Controller
{
	public function fetchResults(Request $request, $id)
	{
		//$lotteryID = Product::find($id)->select(['lotteryId', 'start_date'])->first()->lotteryId;
		$lotteryID = 'a745676b-3a66-4ad5-928a-08d7069ba76b';
		$startDate = '2021-04-15';
		$apiToken = Cache::get('api_token');


		$endpoint = "/LotteryResults/GetLotteryResultListByLotteryId/{$lotteryID}/{$startDate}";
		$results = Http::lotto()->withToken($apiToken)->get($endpoint)->json();

		if ( ! empty($results['lotteryResultsList'])) {
			$this->bulkStore($results['lotteryResultsList']);
			return $results['lotteryResultsList'];
		}

		return ["emptyResponse" => true];
	}

	public function bulkStore(array $results)
	{
		foreach( $results as $result ) {
			Result::create([
				'lottery_id' => 1,
				'draw_date' => $result['drawDate'],
				'jackpot' => $result['jackpot'] ?? 0,
				'winners' => $result['winners'] ?? 0,
				'board' => $result['board'] ?? '-',
				'breakdowns' => $result['breakdowns'],
			]);
		}
	}
}
