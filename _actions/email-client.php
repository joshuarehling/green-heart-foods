<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/User.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
require_once(SERVER_ROOT."/_classes/Messages.php");
$menu = new Menu();
$client_id = $_GET['client-id'];
$start_date = $_GET['start-date'];
$menu->send_menu_for_client_review($client_id, $start_date);