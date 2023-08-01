<?php
	session_start();

	if(!(isset($_SESSION['USER_INFORMATION']['ROLE']))) {
		header("HTTP/1.1 404 Not Found");
		die();
	}
	switch($_SESSION['USER_INFORMATION']['ROLE']) {
		case 0:
			header('Location: index.php');
			die();
			break;
		case 1: 
			header('Location: admin/');
			die();
			break;
		default:
			header("HTTP/1.1 404 Not Found");
			die();
	}

?>