<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
	public function fetch()
	{
		$apiToken = Cache::get('api_token');

		if ( ! $apiToken ) {
			// Fetch all the products from api.
			$response = Http::lotto()->post('/auth/token', [
				'clientId' => env('API_KEY'),
				'clientSecurity' => env('API_SECRET'),
			]);

			$apiToken = Cache::forever('api_token', $response->body());
		}

		$prods = Http::lotto()->withToken($apiToken)->get('/allproducts/LE');

		// @todo: maybe apply a check to make sure response is not empty.
		$this->bulkStore( $prods->json() );
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
		dd($product);
	}
}
