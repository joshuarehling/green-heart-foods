<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/Menu.php");
require_once(SERVER_ROOT."/_classes/Client.php");
$menu = new Menu();
$menu->check_for_duplicate_meal_day_combination();