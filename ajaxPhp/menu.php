<?php
	session_start();
	require_once '../config/connect.php';
	switch($_POST['action']) {
		case 'getMenuCategories': 
			$statement = $database->prepare("SELECT * FROM product_category WHERE status = 0");
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
			
		case 'getProducts':
			$statement = $database->prepare("SELECT p.*, pc.name AS product_category FROM product AS p 
			INNER JOIN product_category AS pc ON p.product_category_id = pc.product_category_id 
			WHERE p.product_category_id = :product_category_id AND p.status = 0 AND pc.status = 0");
			$statement->bindParam(':product_category_id', $_POST['product_category_id']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
			
		case 'getProduct':
			$statement = $database->prepare("SELECT p.*, pc.name AS product_category FROM product AS p 
			INNER JOIN product_category AS pc ON p.product_category_id = pc.product_category_id 
			WHERE p.product_id = :id AND p.status = 0 AND pc.status = 0");
			$statement->bindParam(':id', $_POST['id']);
			if(!$statement->execute()) {
				die('error');
			}
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
			
		case 'addToCart':
			if(!isset($_SESSION['USER_INFORMATION']['ID'])) {
				die();
			}
			$statement = $database->prepare("SELECT COUNT(transaction_id) FROM transaction1 WHERE product_id = :product_id AND 
			user_id = :user_id AND status = 0");
			$statement->bindParam(':product_id', $_POST['id']);
			$statement->bindParam('user_id', $_SESSION['USER_INFORMATION']['ID']);
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_BOTH)[0];
			
			if($result == 0) {
				$statement = $database->prepare("INSERT INTO transaction1 (product_id, user_id, quantity) VALUES(:product_id, :user_id, :quantity)");
			}
			else if($result == 1) {
				$statement = $database->prepare("UPDATE transaction1 SET quantity = quantity + :quantity WHERE product_id = :product_id AND 
				user_id = :user_id AND status = 0");
			}
			$statement->bindParam(':product_id', $_POST['id']);
			$statement->bindParam(':user_id', $_SESSION['USER_INFORMATION']['ID']);
			$statement->bindParam(':quantity', $_POST['quantity'], PDO::PARAM_INT);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
	}
?>