<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
	const TYPES = [
		1 => 'single',
		5 => 'syndicate'
	];

	public function fetch()
	{
		// Fetch all products.
		$prods = Http::lotto()->get('/allproducts/JL');

		// @todo: maybe apply a check to make sure response is not empty.
		$this->bulkStore( $prods->json() );
	}

	public function fetchDetails(Product $product)
	{
		$priceController = new PriceController;
		$lotteryController = new LotteryController;
		$syndicateController = new SyndicateController;

		$endpoint = "/products/JL/" . self::TYPES[$product->type] . "/details/{$product->productId}";
		$details = Http::lotto()->get($endpoint)->json();

		if (isset($details['prices'])) {
			$priceController->bulkStore($product->id, $details['prices']);
		}

		$details['lottery']['start_date'] = $details['product']['startDate'];
		$lotteryData = $details['lottery'];
		$lotteryController->bulkStore($product->id, $lotteryData);

		// Add data for syndicate products.
		if ( isset( $details['syndicateGroups'] ) ) {
			$syndicateData = $details['syndicateGroups'];
			$syndicateController->bulkStore($product->id, $details['product']['isSuperDraw'], $syndicateData);
		}

		return $details;
	}

	public function bulkStore($products)
	{
		foreach( $products as $product ) {
			Product::updateOrCreate(
				['productId' => $product['id']],
				[
					'name' => $product['name'],
					'price' => $product['price'],
					'type' => $product['typeCode'],
					'lotteryId' => $product['lotteryId'],
					'lotteryName' => $product['lotteryName'],
					'currencyCode' => $product['currencyCode'],
					'description' => $product['descriptor'],
				]
			);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$products = Product::all();

		// @todo: Fetch if products are empty.

		return $products;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function show(Product $product)
	{
		$price = $product->prices()->where('currencyCode', 'EUR')->first();
		// @todo: maybe do this a better way.
		$product->prices = $price;

		return $product;
	}

	/**
	 * Undocumented function
	 *
	 * @author Aditya Bhaskar Sharma <adityabhaskarsharma@gmail.com>
	 * @since 0.1.0
	 * @return void
	 */
	public function binChilling()
	{
		$priceController = new PriceController;
		$lotteryController = new LotteryController;

		foreach (Product::all() as $product) {
			$details = $this->update($product);

			if (!empty($details['prices'])) {
				$priceController->bulkStore($product->id, $details['prices']);
			}

			if (!empty($details['lottery'])) {
				$lotteryController->bulkStore($product->id, $details['lottery']);
			}
		}
	}

	/**
	 * Undocumented function
	 *
	 * @author Aditya Bhaskar Sharma <adityabhaskarsharma@gmail.com>
	 * @since 0.1.0
	 * @param \App\Models\Product $product
	 * @return void
	 */
	public function update(Product $product)
	{
		$endpoint = "/products/JL/" . self::TYPES[$product->type] . "/details/{$product->productId}";
		$response = Http::lotto()->get($endpoint)->json();
		$prices = [];
		$lottery = [];

		if (isset($response['product'])) {
			if (isset($response['prices'])) {
				$prices = $response['prices'];
			}

			$lottery = $response['lottery'];
			$lottery['start_date'] = $response['product']['startDate'];
		}

		return [
			'prices' => $prices,
			'lottery' => $lottery,
		];
	}

	public function binChillingResults()
	{
		$resultsController = new ResultController;

		foreach(Product::all() as $product) {
			$lottery = $product->lottery;

			if (! is_null($lottery)) {
				$results = $this->updateResults($lottery, $product);

				if ($results) {
					$resultsController->bulkStore($lottery->id, $results);
				}
			}
		}
	}

	public function updateResults(Lottery $lottery, Product $product)
	{
		$lotteryID = $product->lotteryId;
		$startDate = $lottery->start_date;


		if (! is_null($startDate)) {
			$carbon = new Carbon($startDate);
			$date = $carbon->toDateString();

			$endpoint = "/LotteryResults/GetLotteryResultListByLotteryId/{$lotteryID}/{$date}";
			$results = Http::lotto()->get($endpoint)->json();

			if ( ! empty($results['lotteryResultsList'])) {
				return $results['lotteryResultsList'];
			}
		}
	}
}
