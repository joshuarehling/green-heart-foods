<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
require_once(SERVER_ROOT."/_classes/Client.php");
$menu = new Menu();
$preset_group_id = $_GET['preset-group-id'];
$menu->delete_preset_menu($preset_group_id);
