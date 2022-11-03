<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
	const TYPES = [
		1 => 'Simple Product',
		5 => 'Syndicate'
	];

	public function fetch()
	{
		$apiToken = Cache::get('api_token');

		if ( ! $apiToken ) {
			// @todo: move this to a separate controller.
			// Get auth token.
			$response = Http::lotto()->post('/auth/token', [
				'clientId' => env('API_KEY'),
				'clientSecurity' => env('API_SECRET'),
			]);

			// store cache for a day.
			// @todo: maybe fix this logic.
			$apiToken = Cache::put('api_token', $response->body(), now()->addMinutes(1440));
		}

		// Fetch all products.
		$prods = Http::lotto()->withToken($apiToken)->get('/allproducts/LE');

		// @todo: maybe apply a check to make sure response is not empty.
		$this->bulkStore( $prods->json() );
	}

	public function fetchDetails(Product $product)
	{
		$priceController = new PriceController;
		$lotteryController = new LotteryController;
		$apiToken = Cache::get('api_token');

		$endpoint = "/products/LE/{self::TYPES[$product->typeCode]}/details/{$product->productId}";
		$details = Http::lotto()->withToken($apiToken)->get($endpoint)->json();

		if (isset($details['prices'])) {
			$priceController->bulkStore($product->id, $details['prices']);
		}

		$lotteryData = $details['lottery'];
		$lotteryController->bulkStore($product->id, $lotteryData);

		return $details;
	}

	public function bulkStore($products)
	{
		foreach( $products as $product ) {
			Product::create([
				'productId' => $product['id'],
				'name' => $product['name'],
				'price' => $product['price'],
				'type' => $product['typeCode'],
				'lotteryId' => $product['lotteryId'],
				'lotteryName' => $product['lotteryName'],
				'currencyCode' => $product['currencyCode'],
				'description' => $product['descriptor'],
			]);
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
		//return [
		//	'product' => $product,
		//	'details' => $product->lottery,
		//];
		//return $product::with('lottery')->where('id', $product->id)->get();

		return inertia('LotteryDetails', [
			'product' => $product,
			//'balls' => $product->lottery,
			//'cutOffs' => $product->lottery()->select('cut_offs')->first()->cut_offs,
		]);
	}
}
