<?php

	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	
	switch($_POST['action']) {
		case 'getDashboard': 
			$statement = $database->prepare("SELECT (SELECT COUNT(product_id) FROM product WHERE status = 0) AS products, 
			(SELECT COUNT(user_id) FROM user WHERE role = 0 AND status = 0) AS customers,
			(SELECT COUNT(transaction_id) FROM transaction1 WHERE status = 1) AS pending_orders, 
			(SELECT COUNT(transaction_id) FROM transaction1 WHERE status = 2) AS delivery_orders,
			(SELECT SUM(ordered_amount * quantity) FROM transaction1 WHERE status = 3) AS completed_orders");
			$statement->execute();
			$result = $statement->fetchAll();
			die(json_encode($result));
			break;
	}

?>