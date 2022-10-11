<?php require_once 'ProductSingle.php';

class ProductSingleDetails extends ProductSingle {
	private $_productDetails;
	public $price = 0.0;

	public function __construct()
	{
		// somthing maybe
		parent::__construct();
	}

	public function fetchDetails( string $productID )
	{
		if ( ! $productID ) return;

		$this->endpoint = "crow/api/products/LE/{$this->typeTag}/details/{$productID}";
		$response = $this->doCurl( $this->getURL() );

		// @todo: save this in cache memory.
		$this->_productDetails = json_decode( $response );

		// Check if product has price.
		if ( isset( $this->_productDetails->prices ) ) {
			$prices = $this->_productDetails->prices;

			$_price = current( array_filter( $prices, function ( $var ) {
				// @todo: make the currency dynamic.
				return $var->currencyCode === 'EUR';
			}) )->price;

			$this->setProductPrice( $_price );
		}

		return $this->_productDetails;
	}

	public function getProductPrice(): float
	{
		return $this->price;
	}

	public function setProductPrice( float $price ): void
	{
		// Save the price.
		$this->price = $price;
	}

}