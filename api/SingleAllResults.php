<?php
include_once 'BaseAPI.php';
include_once 'SingleProduct.php';
include_once 'SingleResult.php';

class SingleAllResults extends BaseAPI {
	protected $endpoint;
	protected $url;
	public $products = [];

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
	}

	public function fetchDetails()
	{	
		$singleProduct = new SingleProduct;
		$result = new SingleResult;

		$allProducts   = $singleProduct->getProductListing( 'single' );

		$lotteryResults = [];
		foreach ( $allProducts as $val ) {

			if ( !empty( $val['lotteryId'] ) ) {
				$details = $singleProduct->fetchDetails( $val['id'], 'single' );
				if ( isset( $details->product->startDate ) && !empty( $details->product->startDate ) ) {
					$startDate = strtok( $details->product->startDate, 'T');
					$lotteryId = $details->product->lotteryId;
					$lotteryResult = $result->fetchDetails( $val['lotteryId'], $startDate );
					$lotteryResults[] = [ 'name' => $lotteryResult['name'], 'lotteryResultsList' => $lotteryResult[0] ];
				}
			}
			
		}



		return $lotteryResults;
		/*$this->endpoint = "crow/api/LotteryResults/GetLotteryResultListByLotteryId/{$lotteryId}/{$startDate}";

		$response = $this->doCurl($this->getURL());

		return json_decode($response,TRUE);*/
	}
}