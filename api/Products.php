<?php
include_once 'BaseAPI.php';

class Products extends BaseAPI {
	public $products = [];
	protected $endpoint  = 'crow/api/allproducts/LE';

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
		$this->products = $this->getProductsListing();
	}

	public function fetchDetails(string $id, string $type)
	{
		if ( ! $id || ! $type ) return;

		$type = $type === 'Single Play' ? 'single' : $type;
		$this->endpoint = "crow/api/products/LE/{$type}/details/{$id}";

		$response = $this->doCurl($this->getURL());

		return json_decode($response);
	}

	public function getProductsListing() : array
	{
		$data = $this->getCacheData( 'products' );

		echo '<pre>';
		print_r($data);
		echo '</pre>';
		if ( ! $data ) {
			$data = $this->doCurl( $this->getUrl() );
			// Cache the products.
			$this->setCacheData( $data, 'products' );
		}

		$products = json_decode( $data, true );
		return $products;
	}

	public function getSingleProductListing() : array
	{
		$_cachedProducts = $this->products;
		$singleProducts = [];
		$type = 'Single Play';

		if ( null !== $_cachedProducts ) {
			// Filter only "Single Play" lotteries here.
			$singleProducts = array_filter( $_cachedProducts, function ( $var ) use ( $type ){
				return ( $var['productType'] == $type && $var['lotteryId'] != '' );
			});
		}

		return $singleProducts;
	}
}