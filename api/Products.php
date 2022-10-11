<?php require_once 'BaseAPI.php';

class Products extends BaseAPI {
	protected $products = [];

	public function __construct()
	{
		parent::__construct();
		$this->url = $this->api . $this->endpoint;
		$this->products = $this->getProductsListing();
	}

	public function getProductsListing() : array
	{
		$data = $this->getCacheData( 'products' );

		if ( null === $data || empty( $data ) ) {
			$data = $this->doCurl( $this->getUrl() );
			// Cache the products.
			$this->setCacheData( $data, 'products' );
		}

		$products = json_decode( $data, true );
		return $products;
	}
}