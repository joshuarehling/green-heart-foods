<?php 

// session_start();
require_once("../_classes/User.php");
$user = new User();
$forward_url = "";
if(isset($_GET['forward-url'])) {
	$forward_url = $_GET['forward-url'];
}
$client_access_level = $user->get_client_access_level($forward_url);