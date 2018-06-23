<?php
	$page_class = 'create_and_edit_menu create_menu_page batch_menu';
	$page_title_detail = 'Create Batch Menu';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
	require_once(SERVER_ROOT . "/_classes/Servers.php");
	require_once(SERVER_ROOT . "/_classes/Client.php");
	// $client = new Client();
	// $client_id = $_GET['client-id'];
	$menu = new Menu();
	$menu_form = $menu->get_menu_form($client_id, null, null, "true");
	// $client_result = $client->get_client($client_id);
?>

<div class='page_header'>
	<h2>Create Batch Menu</h2>
</div>

<?php Messages::render(); ?>

<div class="client_form">
	<?php echo $menu_form; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>