<?php
	session_start();
	require_once '../config/connect.php';
	
	if(!(isset($_POST['email']) && !empty($_POST['email']))) {
		die('Please Enter your email');
	}	
	if(!(isset($_POST['password']) && !empty($_POST['password']))) {
		die('Please Enter your password');
	}
	
	$statement = $database->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
	$statement->bindParam(":email", $_POST['email']);
	$statement->execute();
	if($statement->rowCount() <= 0) {
		die('Wrong Email or Password');
	}
	$row = $statement->fetch(PDO::FETCH_BOTH);
	
	if($row['status'] == 2) {
		die('Your Account has been blocked');
	}
	else if($row['status'] == 1) {
		die('Your Account has been deactivated');
	}
	
	if(password_verify($_POST['password'],$row['password'])) {
		session_destroy();
		session_start();
		$_SESSION['USER_INFORMATION'] = array('ID' => $row['user_id'], 
		'ROLE' => $row['role'], 
		'NAME' => $row['name'], 
		'EMAIL' => $row['email']);
		die('1');
	}
	else {
		die('Wrong Email or Password');
	}
?>