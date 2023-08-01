<?php
	session_start();
	
	if(!(isset($_SESSION['USER_INFORMATION']['ROLE']) && !empty($_SESSION['USER_INFORMATION']['ROLE']))) {
		header("HTTP/1.1 404 Not Found");
		die();
	}
	if($_SESSION['USER_INFORMATION']['ROLE'] != 1) {
		header("HTTP/1.1 404 Not Found");
		die();
	}

?>