<?php
	function create_email($emailDuManager, $titre, $message) {
		$error = '';

		if(empty($error)){
			$to_email = $emailDuManager;
			$from_email = "yu.kaiwen.amelie@gmail.com";

			$email_subject = $titre;

			$email_body = $message;

			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$headers .= "From: $from_email\n";
			$headers .= "Reply-To: $from_email";

			mail($to_email, $email_subject, $email_body, $headers);

			$response_array['status'] = "success";
			$response_array['from'] = $from_email;
			$response_array['message'] = $email_body;

			echo json_encode($response_array);
			echo json_encode($from_email);
			return $from_email;
		}else{
			$response_array['status'] = "error";
			echo json_encode($response_array);
		}
	}
?>