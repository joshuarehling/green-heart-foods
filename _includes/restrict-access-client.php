<?php 

require_once("../_classes/User.php");
$user = new User();
$forward_url = "";
if(isset($_GET['forward-url'])) {
	$forward_url = $_GET['forward-url'];
}
if(isset($_GET['client-id'])) {
	$client_id_from_url = $_GET['client-id'];
}
$client_access_level = $user->get_client_access_level($forward_url, $client_id_from_url);