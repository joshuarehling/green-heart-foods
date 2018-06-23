<?php 
	$page_class = 'presets-modal';
	$page_title_detail = 'Presets';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$client_id = $_GET['client-id'];
	$presets_modal = $menu->get_presets_modal($client_id);
	echo $presets_modal;