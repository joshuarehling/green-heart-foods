<?php 

	$host = "localhost";
	$user = "root";
	$password = "";

	try {
	    $database_connection = new PDO("mysql:host=$host;dbname=green_heart_foods", $user, $password);
	    $database_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $error) {
	    echo "Database connection failed: " . $error->getMessage();
	}

?>