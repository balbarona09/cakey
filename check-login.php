<?php

	echo "<script> sessionStorage.setItem('logged_in', 'false'); </script>";
	
	if((isset($_SESSION['USER_INFORMATION']['ROLE']))) {
		switch($_SESSION['USER_INFORMATION']['ROLE']) {
			case 0:
				echo "<script> sessionStorage.setItem('logged_in', 'true'); </script>";
				break;
			case 1: 
				header('Location: admin/');
				die();
				break;
		}
	}
	
	if(isset($_SESSION['PAGE'])) {
		switch($_SESSION['PAGE']) {
			case 'NEED_LOGIN':
				if(!(isset($_SESSION['USER_INFORMATION']['ROLE']) && 
				$_SESSION['USER_INFORMATION']['ROLE'] == 0)) {
					session_destroy();
					header('Location: index.php');
					die();
				}
				break;
		}
	}

?>