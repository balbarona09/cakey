<?php
	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	
	switch($_POST['action']) {
		case 'addAdmin':
			if(!(isset($_POST['fullname']) && !empty($_POST['fullname']))) {
				die('no_name');
			}
			if(!(isset($_POST['email']) && !empty($_POST['email']))) {
				die('no_email');
			}
			if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				die('invalid_email');
			}
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
			$statement = $database->prepare('SELECT COUNT(user_id) FROM user WHERE email = :email');
			$statement->bindParam(':email', $_POST['email']);
			$statement->execute();
			if($statement->fetch(PDO::FETCH_BOTH)[0] > 0) {
				die('already_exist');
			}
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$statement = $database->prepare('INSERT INTO user (role, name, email, password) VALUES(1, :name, :email, :password)');
			$statement->bindParam(':name', $_POST['fullname']);
			$statement->bindParam(':email', $_POST['email']);
			$statement->bindParam(':password', $password);
			if(!$statement->execute()) {
				die();
			}
			die('success');
			break;
		case 'getAdmin':
			if($_POST['order'] == 'name' ||
			   $_POST['order'] == 'email' ||
			   $_POST['order'] == 'creation_date' ||
			   $_POST['order'] == 'updation_date') {
				  $order = $_POST['order'];
			}
			else {
				$order = 'user_id';
			}
			$sort = $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';
			
			$statement = $database->prepare("SELECT * FROM user WHERE role = 1 AND status = :status ORDER BY {$order} {$sort} LIMIT :offset, :limit;");
			$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
			$statement->bindParam(':offset', $_POST['offset'], PDO::PARAM_INT);
			$statement->bindParam(':limit', $_POST['limit'], PDO::PARAM_INT);
			if($statement->execute()) {
				$result = $statement->fetchAll();
				$statement = $database->prepare('SELECT COUNT(user_id) FROM user WHERE role = 1 AND status = :status LIMIT 1');
				$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
				$statement->execute();
				array_push($result, $statement->fetch(PDO::FETCH_NUM)[0]);
				die(json_encode($result));
			}
			die('other_error');
			break;
		case 'blockCustomer':
			$statement = $database->prepare('UPDATE user SET status = :status, updation_date = NOW() WHERE user_id = :id');
			$statement->bindParam(':status', $_POST['status']);
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die("0");
			break;
	}
	
?>