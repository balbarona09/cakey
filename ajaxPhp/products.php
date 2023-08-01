<?php
	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	require_once '../functions/imageValid.php';
	
	switch($_POST['action']) {
		case 'addProduct':
		case 'editProduct':
			if(!(isset($_POST['product_category_id']) && !empty($_POST['product_category_id']))) {
				die('no_product_category');
			}
			if(!(isset($_POST['name']) && !empty($_POST['name']))) {
				die('no_name');
			}
			if(!(isset($_POST['description']) && !empty($_POST['description']))) {
				die('no_description');
			}
			if($_POST['action'] == 'addProduct') {
				$statement = $database->prepare('SELECT COUNT(product_id) FROM product WHERE name = :name');
			}
			else {
				$statement = $database->prepare('SELECT COUNT(product_id) FROM product WHERE name = :name
				AND product_id != :id');
				$statement->bindParam(':id', $_POST['id']);
			}
			$statement->bindParam(':name', $_POST['name']);
			$statement->execute();
			if($statement->fetch(PDO::FETCH_BOTH)[0] > 0) {
				die('already_exist');
			}
			if($_POST['action'] == 'addProduct') {
				if(!imageValid($_FILES['image']['tmp_name'])) {
					die('invalid_image');
				}
				$extension = pathinfo($_FILES['image']['name'])['extension'];
				$statement = $database->prepare('INSERT INTO product (product_category_id, name, amount, description, extension_file) 
				VALUES(:product_category_id, :name, :amount, :description, :extension)');
				$statement->bindParam(':product_category_id', $_POST['product_category_id']);
				$statement->bindParam(':name', $_POST['name']);
				$statement->bindParam(':amount', $_POST['amount']);
				$statement->bindParam(':description', $_POST['description']);
				$statement->bindParam(':extension', $extension);
				if(!$statement->execute()) {
					die();
				}
				$statement = $database->prepare('SELECT LAST_INSERT_ID()');
				$statement->execute();
				$id = $statement->fetch(PDO::FETCH_BOTH)[0];
				move_uploaded_file($_FILES['image']['tmp_name'], "../images/product-images/{$id}.{$extension}");
				die('success');
			}
			else {
				if(!isset($_FILES['image']) || !file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
					$statement = $database->prepare('UPDATE product SET product_category_id = :product_category_id,
					name = :name, amount = :amount, description = :description, updation_date = NOW() WHERE product_id = :id');
					$statement->bindParam(':product_category_id', $_POST['product_category_id']);
					$statement->bindParam(':name', $_POST['name']);
					$statement->bindParam(':amount', $_POST['amount']);
					$statement->bindParam('description', $_POST['description']);
					$statement->bindParam(':id', $_POST['id']);
					if($statement->execute()) {
						die('success');
					}
				}
				else {
					if(!imageValid($_FILES['image']['tmp_name'])) {
						die('invalid_image');
					}
					$extension = pathinfo($_FILES['image']['name'])['extension'];
					$statement = $database->prepare('UPDATE product SET product_category_id = :product_category_id,  
					name = :name, amount = :amount, description = :description, extension_file = :extension, updation_date = NOW()
					WHERE product_id = :id');
					$statement->bindParam(':product_category_id', $_POST['product_category_id']);
					$statement->bindParam(':name', $_POST['name']);
					$statement->bindParam(':amount', $_POST['amount']);
					$statement->bindParam(':description', $_POST['description']);
					$statement->bindParam(':extension', $extension);
					$statement->bindParam(':id', $_POST['id']);
					if(!$statement->execute()) {
						die();
					}
					@unlink("../images/product-images/{$_POST['id']}.{$extension}");
					move_uploaded_file($_FILES['image']['tmp_name'], "../images/product-images/{$_POST['id']}.{$extension}");
					die('success');
				}
				
			}
			die('other_error');
			break;
		case 'getProductCategory':
			$statement = $database->prepare("SELECT product_category_id, name FROM product_category WHERE status = 0 ");
			if($statement->execute()) {
				$result = $statement->fetchAll();
				die(json_encode($result));
			}
			die('other_error');
			break;
		case 'getProduct':
			if($_POST['order'] == 'name' ||
			   $_POST['order'] == 'creation_date' ||
			   $_POST['order'] == 'updation_date' ||
			   $_POST['order'] == 'product_category_name') {
				  $order = $_POST['order'];
			}
			else {
				$order = 'product_id';
			}
			$sort = $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';
			
			$statement = $database->prepare("SELECT p.*, pt.name AS product_category_name FROM product AS p INNER JOIN product_category AS pt 
			ON  p.product_category_id = pt.product_category_id
			WHERE p.status = :status AND pt.status = 0 ORDER BY {$order} {$sort} LIMIT :offset, :limit;");
			$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
			$statement->bindParam(':offset', $_POST['offset'], PDO::PARAM_INT);
			$statement->bindParam(':limit', $_POST['limit'], PDO::PARAM_INT);
			if($statement->execute()) {
				$result = $statement->fetchAll();
				$statement = $database->prepare('SELECT COUNT(product_id) FROM product AS p INNER JOIN product_category AS pt  
				ON p.product_category_id = pt.product_category_id
				WHERE p.status = :status AND pt.status = 0 LIMIT 1');
				$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
				$statement->execute();
				array_push($result, $statement->fetch(PDO::FETCH_NUM)[0]);
				die(json_encode($result));
			}
			die('other_error');
			break;
		case 'archiveProduct':
			$statement = $database->prepare('UPDATE product SET status = :status, updation_date = NOW() WHERE product_id = :id');
			$statement->bindParam(':status', $_POST['status']);
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die("0");
			break;
	}
	
?>