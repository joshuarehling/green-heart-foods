<?php 

class Servers {

	private $database_connection = null;

	public function __construct() {
		require_once("../_classes/Database.php");
        require_once("../_classes/Messages.php");
		$database = new Database();
		$this->database_connection = $database->connect();
	}

    public function get_all_servers(){
        $query = $this->database_connection->prepare("SELECT * FROM servers");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($result) > 0) {
            return $result;
        } else {
            Messages::add("Sorry, there was an error retrieving a list of servers.");
        }
    }

}