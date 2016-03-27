<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
$menu = new Menu();
$bite_id = $_GET['bite-id'];
$menu->delete_bite($bite_id);