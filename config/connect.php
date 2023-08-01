<?php

	$host = 'localhost';
	$dbname = 'cakey';
	$user = 'root';
	$password = 'admin';

	$database = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);


?>