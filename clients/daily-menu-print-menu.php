<?php
	session_start();
	$page_class = 'daily_menu_print_menu_page';
	$page_title_detail = 'Daily Menu - Print';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-client.php");
    require_once(SERVER_ROOT . "/_includes/print-header.php");
    require_once(SERVER_ROOT . "/_classes/Client.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $client_access_level;
	$meal_id = $_GET['meal-id'];
	$client_id = $_GET['client-id'];
	$service_date = $_GET['service-date'];
	$menu_items = $menu->get_daily_menu($client_id, $service_date, $meal_id);
	$print_menu = $menu->get_daily_print_menu($menu_items);
?>

<div class="menu">
	<?php 
		echo $print_menu; 
	?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/print-footer.php"); ?>