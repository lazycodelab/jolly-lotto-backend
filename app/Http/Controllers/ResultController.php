<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ResultController extends Controller
{
	public function bulkStore(int $lotteryID, array $results)
	{
		foreach( $results as $result ) {
			Result::updateOrCreate(
				[
					'lottery_id' => $lotteryID,
					'jackpot' => $result['jackpot'],
				],
				[
					'draw_date' => $result['drawDate'],
					'winners' => $result['winners'],
					'board' => $result['board'],
					'breakdowns' => $result['breakdowns']
				]
			);
		}
	}
}
