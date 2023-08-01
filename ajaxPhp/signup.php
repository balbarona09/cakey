<?php
	session_start();
	
	require_once '../config/connect.php';
	require_once '../functions/sendEmail.php';
	require_once '../vendor/autoload.php';
	require_once '../classes/AccountVerification.php';
	
	if(!isset($_SESSION['SIGNUP_ACCOUNT_VERIFICATION'])) {
		die('Something Went Wrong!');
	}
	
	$accountVerification = unserialize($_SESSION['SIGNUP_ACCOUNT_VERIFICATION']);
	
	if(isset($_POST['action']) && $_POST['action'] == 'CHANGE EMAIL') {
		$accountVerification->changeEmail('SIGNUP_ACCOUNT_VERIFICATION');
		die("1");
	}
	else if(isset($_POST['action']) && $_POST['action'] == 'RESEND CODE') {
		if($accountVerification->getStatus() != 'VERIFY CODE') {
			die('Something went wrong!');
		}
		$code = $accountVerification->generateCode();
	
		$bodyHtml = "Your verification code is <b>{$code}</b>";
		$body = "Your verification code is {$code}";
			
		if(!$accountVerification->sendCode($accountVerification->getEmail(), $code, $bodyHtml, $body )) {
			die("Code not sent. Please try again!");
		}
			
		$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
		die('1');
	}

	switch($accountVerification->getStatus()) {
		case 'SEND CODE':
			$statement = $database->prepare('SELECT COUNT(user_id) FROM user WHERE email = :email');
			$statement->bindParam(':email', $_POST['email']);
			$statement->execute();
			if($statement->fetch(PDO::FETCH_BOTH)[0] > 0) {
				die('Email is already used');
			}
			
			$code = $accountVerification->generateCode();
			
			$bodyHtml = "Your verification code is <b>{$code}</b>";
			$body = "Your verification code is {$code}";
			
			if(!$accountVerification->sendCode($_POST['email'], $code, $bodyHtml, $body )) {
				die("Code not sent. Please try again!");
			}
			
			$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
			die('1');
			break;
			
		case 'VERIFY CODE':
			if($accountVerification->getAttempts() == 0 ) {
				$accountVerification->setSendCodeTime(new DateTime('now'));
				$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
				die("3");
			}
			$return = $accountVerification->verifyCode($_POST['code']);
			$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
			
			if(!$return) {
				if($accountVerification->getAttempts() == 0 ) {
					$accountVerification->setSendCodeTime(new DateTime('now'));
					$_SESSION['SIGNUP_ACCOUNT_VERIFICATION'] = serialize($accountVerification);
					die("3");
				}
				die("2");
			}
			
			die('1');
			break;
			
		case 'VERIFIED':
			$email = $accountVerification->getEmail();
			if(!(isset($email) && !empty($email))) {
				die("Something went wrong");
			}
	
			if(!(isset($_POST['fullname']) && !empty($_POST['fullname']))) {
				die("Please Enter your fullname");
			}
	
			if(!(isset($_POST['password']) && !empty($_POST['password']))) {
				die("Please Enter your password");
			}
	
			if(!(isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword']))) {
				die("Please Confirm your password");
			}
	
			if($_POST['password'] != $_POST['confirmPassword']) {
				die("Password do not match");
			}
			
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			
			$statement = $database->prepare("INSERT INTO user (name, email, password) VALUES (:fullname, :email, :password)");
			$statement->bindParam(":fullname", $_POST['fullname']);
			$statement->bindParam(":email", $email);
			$statement->bindParam(":password", $password);
			if($statement->execute()) {
				session_destroy();
				die("1");
			}
			
			die('Something went wrong! Please try again!');
			break;
			
		default:
			die('Something went wrong!');
	}
	
?>