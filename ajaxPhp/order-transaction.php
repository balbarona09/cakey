<?php

	session_start();
	if(!(isset($_SESSION['USER_INFORMATION']['ID']) && $_SESSION['USER_INFORMATION']['ROLE'] == 0)) {
		header("HTTP/1.1 404 Not Found");
		die();
	}
	require_once '../config/connect.php';
	switch($_POST['action']) {
		case 'getCart':
			$statement = $database->prepare("SELECT t.*, p.name, p.amount, p.product_id, p.extension_file FROM transaction1 AS t 
			INNER JOIN product AS p ON t.product_id = p.product_id WHERE t.user_id = :user_id AND t.status = 0 ORDER BY creation_date DESC");
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
		case 'getPurchases':
			$filter = "t.status != 0";
			$filter .= $_POST['status'] >= 1 && $_POST['status'] <= 5 ? " AND t.status = {$_POST['status']}" : '';
			$statement = $database->prepare("SELECT t.*, p.name, p.amount, p.product_id, p.extension_file FROM transaction1 AS t 
			INNER JOIN product AS p ON t.product_id = p.product_id WHERE t.user_id = :user_id AND {$filter}
			ORDER BY creation_date DESC");
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
		case 'removeCart':
			$statement = $database->prepare("DELETE FROM transaction1 WHERE transaction_id = :id AND status = 0 AND user_id = :user_id");
			$statement->bindParam(':id', $_POST['id']);
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
		case 'cancelOrder':
			$statement = $database->prepare("UPDATE transaction1 SET status = 4 WHERE transaction_id = :id AND status = 1 AND user_id = :user_id");
			$statement->bindParam(':id', $_POST['id']);
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
		case 'getUserAddress': 
			$statement = $database->prepare("SELECT u.name, u.phone, u.region , u.province, u.city, u.barangay, u.postal_code, u.street 
			FROM user As u WHERE u.user_id = :id ");
			$statement->bindParam(':id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
		case 'placeOrder':
			if(!(isset($_POST['fullname']) && !empty($_POST['fullname']))) {
				die('no_fullname');
			}
			if(!(isset($_POST['phone']) && !empty($_POST['phone']))) {
				die('no_phone');
			}
			if(!(isset($_POST['region']) && !empty($_POST['region']))) {
				die('no_region');
			}
			if(!(isset($_POST['province']) && !empty($_POST['province']))) {
				die('no_province');
			}
			if(!(isset($_POST['city']) && !empty($_POST['city']))) {
				die('no_city');
			}
			if(!(isset($_POST['barangay']) && !empty($_POST['barangay']))) {
				die('no_barangay');
			}
			if(!(isset($_POST['postal_code']) && !empty($_POST['postal_code']))) {
				die('no_postal_code');
			}
			if(!(isset($_POST['street']) && !empty($_POST['street']))) {
				die('no_street');
			}
			if(!(isset($_POST['payment_method']) && !empty($_POST['payment_method']))) {
				die('no_payment_method');
			}
			$statement = $database->prepare("UPDATE user AS u SET u.phone = :phone, u.region = :region, 
			u.province = :province, u.city = :city, u.barangay = :barangay, u.postal_code = :postal_code, 
			u.street = :street WHERE u.user_id = :user_id");
			$statement->bindParam(':phone', $_POST['phone']);
			$statement->bindParam(':region', $_POST['region']);
			$statement->bindParam(':province', $_POST['province']);
			$statement->bindParam(':city', $_POST['city']);
			$statement->bindParam(':barangay', $_POST['barangay']);
			$statement->bindParam(':postal_code', $_POST['postal_code']);
			$statement->bindParam(':street', $_POST['street']);
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if(!$statement->execute()) {
				die('error');
			}
			$statement = $database->prepare("UPDATE transaction1 AS t INNER JOIN product AS p 
			ON p.product_id = t.product_id SET t.ordered_product = p.name, t.ordered_amount = p.amount, 
			t.fullname = :fullname, t.phone = :phone, t.region = :region, t.province = :province, 
			t.city = :city, t.barangay = :barangay, t.postal_code = :postal_code, t.street = :street,
			t.payment_method = :payment_method, t.status = 1, t.updation_date = NOW()
			WHERE t.user_id = :user_id AND t.status = 0;");
			$statement->bindParam(':fullname', $_POST['fullname']);
			$statement->bindParam(':phone', $_POST['phone']);
			$statement->bindParam(':region', $_POST['region']);
			$statement->bindParam(':province', $_POST['province']);
			$statement->bindParam(':city', $_POST['city']);
			$statement->bindParam(':barangay', $_POST['barangay']);
			$statement->bindParam(':postal_code', $_POST['postal_code']);
			$statement->bindParam(':street', $_POST['street']);
			$statement->bindParam(':payment_method', $_POST['payment_method']);
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
	}

?>