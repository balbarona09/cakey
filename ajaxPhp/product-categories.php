<?php
	require_once('../admin/check-login.php');
	require_once '../config/connect.php';
	require_once '../functions/imageValid.php';
	
	switch($_POST['action']) {
		case 'addProductCategory':
		case 'editProductCategory':
			if(!(isset($_POST['name']) && !empty($_POST['name']))) {
				die('no_name');
			}
			if($_POST['action'] == 'addProductCategory') {
				$statement = $database->prepare('SELECT COUNT(product_category_id) FROM product_category WHERE name = :name');
			}
			else {
				$statement = $database->prepare('SELECT COUNT(product_category_id) FROM product_category WHERE name = :name
				AND product_category_id != :id');
				$statement->bindParam(':id', $_POST['id']);
			}
			$statement->bindParam(':name', $_POST['name']);
			$statement->execute();
			if($statement->fetch(PDO::FETCH_BOTH)[0] > 0) {
				die('already_exist');
			}
			if($_POST['action'] == 'addProductCategory') {
				if(!imageValid($_FILES['image']['tmp_name'])) {
					die('invalid_image');
				}
				$extension = pathinfo($_FILES['image']['name'])['extension'];
				$statement = $database->prepare('INSERT INTO product_category (name, extension_file) VALUES(:name, :extension)');
				$statement->bindParam(':name', $_POST['name']);
				$statement->bindParam(':extension', $extension);
				if(!$statement->execute()) {
					die();
				}
				$statement = $database->prepare('SELECT LAST_INSERT_ID()');
				$statement->execute();
				$id = $statement->fetch(PDO::FETCH_BOTH)[0];
				move_uploaded_file($_FILES['image']['tmp_name'], "../images/product-category-images/{$id}.{$extension}");
				die('success');
			}
			else {
				if(!isset($_FILES['image']) || !file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
					$statement = $database->prepare('UPDATE product_category SET name = :name, updation_date = NOW() WHERE product_category_id = :id');
					$statement->bindParam(':name', $_POST['name']);
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
					$statement = $database->prepare('UPDATE product_category SET name = :name, extension_file = :extension, updation_date = NOW()
					WHERE product_category_id = :id');
					$statement->bindParam(':name', $_POST['name']);
					$statement->bindParam(':extension', $extension);
					$statement->bindParam(':id', $_POST['id']);
					if(!$statement->execute()) {
						die();
					}
					@unlink("../images/product-category-images/{$_POST['id']}.{$extension}");
					move_uploaded_file($_FILES['image']['tmp_name'], "../images/product-category-images/{$_POST['id']}.{$extension}");
					die('success');
				}
				
			}
			die('other_error');
			break;
		case 'getProductCategory':
			if($_POST['order'] == 'name' ||
			   $_POST['order'] == 'creation_date' ||
			   $_POST['order'] == 'updation_date') {
				  $order = $_POST['order'];
			}
			else {
				$order = 'product_category_id';
			}
			$sort = $_POST['sort'] == 'DESC' ? 'DESC' : 'ASC';
			
			$statement = $database->prepare("SELECT * FROM product_category WHERE status = :status ORDER BY {$order} {$sort} LIMIT :offset, :limit;");
			$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
			$statement->bindParam(':offset', $_POST['offset'], PDO::PARAM_INT);
			$statement->bindParam(':limit', $_POST['limit'], PDO::PARAM_INT);
			if($statement->execute()) {
				$result = $statement->fetchAll();
				$statement = $database->prepare('SELECT COUNT(product_category_id) FROM product_category  WHERE status = :status LIMIT 1');
				$statement->bindParam(':status', $_POST['status'], PDO::PARAM_INT);
				$statement->execute();
				array_push($result, $statement->fetch(PDO::FETCH_NUM)[0]);
				die(json_encode($result));
			}
			die('other_error');
			break;
		case 'archiveProductCategory':
			$statement = $database->prepare('UPDATE product_category SET status = :status, updation_date = NOW() WHERE product_category_id = :id');
			$statement->bindParam(':status', $_POST['status']);
			$statement->bindParam(':id', $_POST['id']);
			if($statement->execute()) {
				die('success');
			}
			die("0");
			break;
	}
	
?>