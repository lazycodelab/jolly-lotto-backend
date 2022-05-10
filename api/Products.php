<?php
include_once 'BaseAPI.php';

class Products extends BaseAPI {
	protected $endpoint  = 'crow/api/allproducts/LE';
	protected $url;
	public $products = [];

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
	}

	public function getProductsListing() : array
	{
		$headers = array(
		'Content-Type: application/json',
		'Content-Length: 0',
		sprintf('Authorization: Bearer %s', $this->token)
		);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $this->url);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_FAILONERROR,true);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			echo '==>'.$error_msg;
		}
		curl_close($ch);

		return json_decode($result, TRUE);
	}

	public function fetchProductDetails(): array
	{
		$this->endpoint = 'crow/api/allproducts/LE/single/details/c807697d-a66a-46b5-929b-08d7069ba76b';
		$headers = array(
		'Content-Type: application/json',
		'Content-Length: 0',
		sprintf('Authorization: Bearer %s', $this->token)
		);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $this->url);
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_FAILONERROR,true);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			echo '==>'.$error_msg;
		}
		curl_close($ch);

		return json_decode($result, TRUE);
	}
}