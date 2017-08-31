<?php
	function create_jwt_token($userId, $username, $password) {
		// key for signature
		$key = "'".$userId."-".$username."-".$password."'";
		// header
		$header = [
			'typ' => 'JWT',
			'alg' => 'HS256'
		];
		$header = json_encode($header);
		$header = base64_encode($header);
		// payload
		$payload = [
			"username" => $username
		];
		$payload = json_encode($payload);
		$payload = base64_encode($payload);
		// signature
		$signature = hash_hmac("sha256", "$header.$payload", $key, true);
		$signature = base64_encode($signature);
		// token
		$token = "$header.$payload.$signature";
		
		return $token;
	}
?>