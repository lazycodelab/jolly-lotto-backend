<?php
include_once 'BaseAPI.php';

class SingleResult extends BaseAPI {
	protected $endpoint;
	protected $url;
	public $products = [];

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
	}

	public function fetchDetails(string $lotteryId, string $startDate)
	{
		
		$this->endpoint = "crow/api/LotteryResults/GetLotteryResultListByLotteryId/{$lotteryId}/{$startDate}";

		$response = $this->doCurl($this->getURL());

		return json_decode($response,TRUE);
	}
}