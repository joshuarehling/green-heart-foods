<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
require_once(SERVER_ROOT."/_classes/Client.php");
$menu = new Menu();
$menu->approve_menu_from_client();