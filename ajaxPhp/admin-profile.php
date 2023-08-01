<?php
	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	
	//For changing email
	require_once '../functions/sendEmail.php';
	require_once '../vendor/autoload.php';
	require_once '../classes/AccountVerification.php';
	
	switch($_POST['action']) {
		case 'getProfile':
			$statement = $database->prepare("SELECT name, email FROM user WHERE role = 1 AND status = 0 AND user_id = :id");
			$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
		case 'editProfile':
			$statement = $database->prepare("UPDATE user SET name = :name WHERE role = 1 AND status = 0 AND user_id = :id");
			$statement->bindParam(':name', $_POST['fullname']);
			$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$_SESSION['USER_INFORMATION']['NAME'] = $_POST['fullname'];
			die('success');
			break;
		case 'editPassword':
			isPasswordCorrect($_POST['currentPassword']);
			
			if(!(isset($_POST['password']) && !empty($_POST['password']))) {
				die('no_password');
			}
			if(!(isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword']))) {
				die('no_confirmPassword');
			}
			if(strlen($_POST['password']) < 8) {
				die('password_less_than_eight');
			}
			if($_POST['password'] != $_POST['confirmPassword']) {
				die('passwords_do_not_match');
			}
			$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$statement = $database->prepare("UPDATE user SET password = :password WHERE role = 1 AND status = 0 AND user_id = :id");
			$statement->bindParam(':password', $_POST['password']);
			$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			die('success');
			break;
		case 'editEmail':
			
			if(!isset($_SESSION['CHANGE_EMAIL_VERIFICATION'])) {
				die('Something Went Wrong!');
			}
	
			$accountVerification = unserialize($_SESSION['CHANGE_EMAIL_VERIFICATION']);
	
			if(isset($_POST['action2']) && $_POST['action2'] == 'CHANGE EMAIL') {
				$accountVerification->changeEmail('CHANGE_EMAIL_VERIFICATION');
				die("1");
			}
			else if(isset($_POST['action2']) && $_POST['action2'] == 'RESEND CODE') {
				if($accountVerification->getStatus() != 'VERIFY CODE') {
					die('Something went wrong!');
				}
				$code = $accountVerification->generateCode();
	
				$bodyHtml = "Your verification code is <b>{$code}</b>";
				$body = "Your verification code is {$code}";
			
				if(!$accountVerification->sendCode($accountVerification->getEmail(), $code, $bodyHtml, $body )) {
					die("Code not sent. Please try again!");
				}
			
				$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
				die('1');
			}
			
			if($accountVerification->getStatus() == 'SEND CODE') {
				isPasswordCorrect($_POST['password']);
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
			
				$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
				die('1');
				break;
			}
			else if($accountVerification->getStatus() == 'VERIFY CODE') {
				if($accountVerification->getAttempts() == 0 ) {
					$accountVerification->setSendCodeTime(new DateTime('now'));
					$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
					die("3");
				}
				$return = $accountVerification->verifyCode($_POST['code']);
				$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
			
				if(!$return) {
					if($accountVerification->getAttempts() == 0 ) {
						$accountVerification->setSendCodeTime(new DateTime('now'));
						$_SESSION['CHANGE_EMAIL_VERIFICATION'] = serialize($accountVerification);
						die("3");
					}
					die("2");
				}
				
				$email = $accountVerification->getEmail();
				$statement = $database->prepare("UPDATE user SET email = :email WHERE role = 1 AND status = 0 AND user_id = :id");
				$statement->bindParam(':email', $email);
				$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
				if(!$statement->execute()) {
					die('error');
				}
				die('1');
				break;
			}
			break;
	}
	
	function isPasswordCorrect($password) {
		global $database;
		$statement = $database->prepare("SELECT password FROM user WHERE role = 1 AND status = 0 AND user_id = :id");
		$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
		if(!$statement->execute()) {
			die('error');
		}
		$currentPassword = $statement->fetch(PDO::FETCH_ASSOC)['password'];
		if(!password_verify($password, $currentPassword)) {
			die('wrong_current_password');
		}
	}
?>