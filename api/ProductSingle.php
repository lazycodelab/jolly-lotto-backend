<?php require_once 'Products.php';

class ProductSingle extends Products {
	protected $endpoint  = 'crow/api/allproducts/LE';
	protected $type = 'Single Play';
	protected $typeTag = 'single';

	public function __construct()
	{
		parent::__construct();
	}

	public function getListing(): array
	{
		$singleProducts = [];

		// Filter only "Single Play" lotteries here.
		$singleProducts = array_filter( $this->products, function ( $var ) {
			return ( $var['productType'] == $this->type && $var['lotteryId'] != '' );
		});

		return $singleProducts;
	}
}