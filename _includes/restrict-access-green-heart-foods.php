<?php 

session_start();
require_once("../_classes/User.php");
$user = new User();
$green_heart_foods_access_level = $user->get_green_heart_foods_access_level();