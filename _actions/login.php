<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/User.php");
require_once(SERVER_ROOT."/_classes/Messages.php");
$user = new User();
$user->login();