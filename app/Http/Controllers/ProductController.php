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

			$apiToken = Cache::forever('api_token', $response->body());
		}

		// Fetch all products.
		$prods = Http::lotto()->withToken($apiToken)->get('/allproducts/LE');

		// @todo: maybe apply a check to make sure response is not empty.
		$this->bulkStore( $prods->json() );
	}

	public function fetchProductsDetails()
	{
		$priceController = new PriceController;
		$lotteryController = new LotteryController;
		$apiToken = Cache::get('api_token');
		$products = Product::all();

		foreach ( $products as $product ) {
			// maybe use pooling here, loop on all the urls and then make dofferent calls?
			$endpoint = "/products/LE/{self::TYPES[$product->typeCode]}/details/{$product->productId}";
			$details = Http::lotto()->withToken($apiToken)->get($endpoint)->json();

			if (isset($details['prices'])) {
				//$priceController->bulkStore($details['prices']);
			}

			$lotteryData = $details['lottery'];
			//dd($lotteryData);
			$lotteryController->bulkStore($lotteryData);
			dd($details);
		}
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

		return $product;
		//$f = $product->prices()->select('price')->where('currencyCode', $product->currencyCode)->first();

		return inertia('LotteryDetails', [
			'product' => $product,
			'lottery' => $product->lottery,
			//'balls' => $product->lottery()->select('balls')->first()->balls,
			//'cutOffs' => $product->lottery()->select('cut_offs')->first()->cut_offs,
		]);
	}
}
