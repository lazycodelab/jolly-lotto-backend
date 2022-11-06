<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Illuminate\Http\Request;

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
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
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
}
