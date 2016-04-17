<?php 

class Database {

	public function __construct() {}

    public function connect(){

    	switch ($_SERVER['HTTP_HOST']) {
    		case 'localhost':
                $host = "localhost";
                $user = "root";
                $password = "";
                $database_name = 'green_heart_foods';
                break;
            case 'localhost:8888':
    			$host = "localhost";
				$user = "root";
				$password = "root";
                $database_name = 'green_heart_foods';
    			break;
            case 'clients.greenheartfoods.com':
    			$host = "ghfAdmin.db.3683991.hostedresource.com";
				$user = "ghfAdmin";
				$password = "Green1980!";
                $database_name = 'ghfAdmin';
    			break;
    		default:
    			die("Error connecting to database.");
    			break;
    	}
    	try {
			$database_connection = new PDO("mysql:host=$host;dbname=$database_name", $user, $password);
		    $database_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $database_connection;
		} catch(PDOException $error) {
		    echo "Database connection failed: " . $error->getMessage();
		    return false;
		}	
    }
}