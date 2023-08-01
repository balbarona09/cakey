<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	function sendEmail($sendTo, $sendFrom, $sendFromPassword, $sendFromName, $subject, $bodyHtml, $body) {
		
		$mail = new PHPMailer(true);

		try {
			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Host	 = 'smtp.gmail.com;';
			$mail->SMTPAuth = true;
			$mail->Username = $sendFrom;
			$mail->Password = $sendFromPassword;
			$mail->SMTPSecure = 'ssl';
			$mail->Port	 = 465;

			$mail->setFrom($sendFrom, $sendFromName);
			$mail->addAddress($sendTo);
	
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->Body = $bodyHtml;
			$mail->AltBody = $body;
			$mail->send();
			return true;
		} catch (Exception $e) {
			return false;
		}

	}

?>