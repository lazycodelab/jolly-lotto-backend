<?php

abstract class BaseAPI {
	private $_cachePath = __DIR__ . '/../_cached';
	protected $token;
	protected $api = 'https://gateway.cloudandahalf.com/';

	public function __construct()
	{
		$this->token = $this->getCacheData( 'token' );

		if ( null === $this->token ) {
			$this->token = $this->_authenticate();
		}
	}

	public function getCurrencySymbol( string $currencyCode )
	{
		if($currencyCode == "EUR"){
			return '&euro;';
		} else if($currencyCode == "GBP"){
			return '&#163;';
		} else if($currencyCode == "USD"){
			return '&dollar;';
		} else if($currencyCode == "CAD"){
			return '&dollar;';
		} else if($currencyCode == "JPY"){
			return '&#165;';
		} else if($currencyCode == "AUD"){
			return 'A&dollar;';
		} else if($currencyCode == "NZD"){
			return 'NZ&dollar;';
		} else if($currencyCode == "ZAR"){
			return 'R';
		} else {
			return '';
		}
	}

	protected function doCurl(string $url, bool $post = false, array $params = [])
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);

		$headers = array(
			'Content-Type: application/json',
			'Content-Length: 0',
			sprintf('Authorization: Bearer %s', $this->token)
		);

		if ( $post ) {
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
		}
		curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_FAILONERROR,true);
		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			return '==>'.$error_msg;
		}
		curl_close($ch);

		// Check of the authentication has expired.
		$_checkResp = json_decode( $response, true );

		if ( array_key_exists('properties', $_checkResp) && null === $_checkResp['properties'] ) {
			// Auth has expired. Let's reauthenticate.
			$this->token = $this->_authenticate();

			// @todo: fix this. Now redo the curl call.
			$this->doCurl( $url );
		} else {
			return $response;
		}
	}

	protected function getURL()
	{
		return $this->api . $this->endpoint;
	}

	protected function setCacheData( $data, string $type )
	{
		// Save the token either in a file or a db.
		file_put_contents( "{$this->_cachePath}/{$type}", $data );
	}

	protected function getCacheData( $type )
	{
		$data = null;

		// Check if the file exists.
		if ( file_exists( "{$this->_cachePath}/{$type}" ) ) {
			$data = file_get_contents( "{$this->_cachePath}/{$type}" );
		}

		return $data;
	}

	private function _authenticate()
	{
		$params = ['clientId'=>'26708f82-d16d-4eea-ba50-4D86DDF7761A', 'clientSecurity'=>'0a5bdf3b-e80e-45c6-8134-419AABA3D2D8'];
		$params = json_encode($params);
		$apiURL = 'crow/api/auth/token';
		$url = 'https://gateway.cloudandahalf.com/' . $apiURL;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch,CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_FAILONERROR,true);
		$token = curl_exec($ch);

		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			return '==>'.$error_msg;
		}

		curl_close($ch);

		// Cache the token value.
		$this->setCacheData( $token, 'token' );

		return $token;
	}
}