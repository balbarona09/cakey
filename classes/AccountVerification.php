<?php

	class AccountVerification {
		private $status;
		private $email;
		private $code;
		private $attempts;
		private $sendCodeTime;
		
		private $sendFrom;
		private $sendFromPassword;
		private $sendFromName;
		private $subject;
		
		function __construct($sendFrom, $sendFromPassword, $sendFromName, $subject) {
			$this->status = 'SEND CODE';
			$this->sendFrom = $sendFrom;
			$this->sendFromPassword = $sendFromPassword;
			$this->sendFromName = $sendFromName;
			$this->subject = $subject;
			$this->sendCodeTime = new DateTime('2 minutes ago');
		}
		
		function sendCode($email, $code, $bodyHtml, $body) {
			if(!(isset($email) && !empty($email))) {
				return false;
			}
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return false;
			}
			$interval = $this->sendCodeTime->diff(new DateTime('now'));
			if($interval->format("%i%") < 2) {
				return false;
			}
			if(!sendEmail($email, $this->sendFrom, $this->sendFromPassword, $this->sendFromName, $this->subject, $bodyHtml, $body )) {
				return false;
			}
			$this->email = $email;
			$this->code = password_hash($code, PASSWORD_DEFAULT);
			$this->status = 'VERIFY CODE';
			$this->attempts = 5;
			$this->sendCodeTime = new DateTime('now');
			return true;
		}
		
		function verifyCode($code) {
			if(!(isset($this->email) && !empty($this->email))) {
				return false;
			}
			if(!(isset($this->code) && !empty($this->code))) {
				return false;
			}
			if(!(isset($code) && !empty($code))) {
				return false;
			}
			if(!password_verify($code,$this->code)) {
				$this->attempts -= 1;
				return false;
			}
			$this->status = 'VERIFIED';
			return true;
		}
		
		function changeEmail($sessionName) {
			unset($_SESSION[$sessionName]);
			//session_destroy(unset);
		}
		
		function generateCode() {
			return rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);
		}
		
		function getStatus() {
			return $this->status;
		}
		function getEmail() {
			return $this->email;
		}
		function getAttempts() {
			return $this->attempts;
		}
		function setCode($code) {
			$this->code = $code;
		}
		function setEmail($email) {
			$this->email = $email;
		}
		function setStatus($status) {
			$this->status = $status;
		}
		function setAttempts($attempts) {
			$this->attempts = $attempts;
		}
		function setSendCodeTime($sendCodeTime) {
			$this->sendCodeTime = $sendCodeTime;
		}
	}

?>