<?php
	$page_class = 'create_and_edit_menu edit_menu_page';
	$page_title_detail = 'Edit Menu';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
    require_once(SERVER_ROOT . "/_classes/Servers.php");
    require_once(SERVER_ROOT . "/_classes/Client.php");
	$client_id = $_GET['client-id'];
	$service_date = $_GET['service-date'];
	$meal_id = $_GET['meal-id'];
	$menu = new Menu();
	$menu_form = $menu->get_menu_form($client_id, $service_date, $meal_id);
?>

<?php echo Messages::render(); ?>

<div class="menu_form">
	<?php echo $menu_form; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>