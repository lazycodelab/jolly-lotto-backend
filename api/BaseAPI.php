<?php

abstract class BaseAPI {
	protected $token;
	protected $api = 'https://gateway.cloudandahalf.com/';

	public function __construct()
	{
		$this->token = $this->_getAuthToken();
	}

	private function _getAuthToken()
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
		return $token;
	}
}