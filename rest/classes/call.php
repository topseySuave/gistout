<?php
    require_once 'const.php';

	$call_url = 'http://localhost/rest/api.php/';

	function call($method, $url, $data = false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($data) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Content-Length: ' . strlen($data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec($ch);
	}

	?>