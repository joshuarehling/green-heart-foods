<?php
 //    require_once("../_config/config.php");
 //    require_once("../_includes/restrict-access-client.php");
 //    require_once("../_includes/global-header.php");
 //    require_once("../_classes/Client.php");
 //    require_once("../_classes/Messages.php");
	// require_once("../_classes/Menu.php");
	// $menu = new Menu();
	// $context = $client_access_level;
	// return $menu->get_daily_menu_page($context);
?>

<?php
	$page_class = 'daily_menu_page client';
	$page_title_detail = 'Daily Menu';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-client.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Client.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $client_access_level;
	$menu = $menu->get_daily_menu_page($context);
?>

<div class="menu">
	<?php echo $menu; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>