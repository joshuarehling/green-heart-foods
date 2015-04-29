<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_includes/global-configuration.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
require_once(SERVER_ROOT."/_classes/Messages.php");
$menu = new Menu();
$menu_item_id = $_POST['menu_item_id'];
$menu->like_menu_item($menu_item_id);