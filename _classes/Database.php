<?php 

class Database {

	public function __construct() {}

    public function connect(){
    	$host = "localhost";
		$user = "root";
		$password = "";
    	try {
			$database_connection = new PDO("mysql:host=$host;dbname=green_heart_foods", $user, $password);
		    $database_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $database_connection;
		} catch(PDOException $error) {
		    echo "Database connection failed: " . $error->getMessage();
		    return false;
		}	
    }
}