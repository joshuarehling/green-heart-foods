<?php 

session_start();
require_once("../_classes/User.php");
$user = new User();
$client_access_level = $user->get_client_access_level();