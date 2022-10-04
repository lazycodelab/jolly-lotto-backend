<?php
include_once 'BaseAPI.php';

class SingleProduct extends BaseAPI {
	protected $endpoint  = 'crow/api/allproducts/LE';
	protected $url;
	public $products = [];

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
	}

	public function fetchDetails(string $id, string $type)
	{
		if ( ! $id || ! $type ) return;

		$type = $type === 'Single Play' ? 'single' : $type;
		$this->endpoint = "crow/api/products/LE/{$type}/details/{$id}";

		$response = $this->doCurl($this->getURL());

		return json_decode($response);
	}

	public function getProductListing( string $type )
	{

		$listing = $this->getProductsListing();
		if ( empty( $listing ) ) {
			return '';
		}

		$type = $type === 'single' ? 'Single Play' : $type;
		$products = array_filter( $listing, function ( $var ) use ( $type ){
		    return ( $var['productType'] == $type && $var['lotteryId'] != '' );
		});

		$products = array_values( $products );

		return $products;
	}

	public function getProductsListing() : array
	{
		$response = $this->doCurl($this->getUrl());

		return json_decode($response, TRUE);
	}
}