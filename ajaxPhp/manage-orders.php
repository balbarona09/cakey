<?php
	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	
	switch($_POST['action']) {
		case 'getOrders':
			if($_POST['order'] == 'ordered_product' ||
			   $_POST['order'] == 'ordered_amount' ||
			   $_POST['order'] == 'quantity' ||
			   $_POST['order'] == 'total' ||
			   $_POST['order'] == 'fullname' ||
			   $_POST['order'] == 'payment_method' ||
			   $_POST['order'] == 'creation_date' ||
			   $_POST['order'] == 'updation_date') {
				  $order = $_POST['order'];
			}
			else {
				$order = 'user_id';
			}
			$sort = $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';
			
			$statement = $database->prepare("SELECT * FROM transaction1 WHERE status = :status ORDER BY {$order} {$sort} LIMIT :offset, :limit;");
			$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
			$statement->bindParam(':offset', $_POST['offset'], PDO::PARAM_INT);
			$statement->bindParam(':limit', $_POST['limit'], PDO::PARAM_INT);
			if($statement->execute()) {
				$result = $statement->fetchAll();
				$statement = $database->prepare('SELECT COUNT(transaction_id) FROM transaction1 WHERE status = :status LIMIT 1');
				$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
				$statement->execute();
				array_push($result, $statement->fetch(PDO::FETCH_NUM)[0]);
				die(json_encode($result));
			}
			die('other_error');
			
			break;
		case 'confirmOrder':
			$statement = $database->prepare("UPDATE transaction1 SET status = 2, updation_date = NOW() WHERE status = 1 AND transaction_id = :id");
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
			
		case 'cancelOrder':
			$statement = $database->prepare("UPDATE transaction1 SET status = 5, updation_date = NOW() WHERE (status = 1 OR status = 2) AND transaction_id = :id");
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
			
		case 'receiveOrder':
			$statement = $database->prepare("UPDATE transaction1 SET status = 3, updation_date = NOW() WHERE status = 2 AND transaction_id = :id");
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die('error');
			break;
	}
?>