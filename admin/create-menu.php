<?php
	$page_class = 'create_and_edit_menu create_menu_page';
	$page_title_detail = 'Create Menu';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
	require_once(SERVER_ROOT . "/_classes/Servers.php");
	require_once(SERVER_ROOT . "/_classes/Client.php");
	$client = new Client();
	$client_id = $_GET['client-id'];
	$menu = new Menu();
	$menu_form = $menu->get_menu_form($client_id);
	$client_result = $client->get_client($client_id);
?>

<div class="client_image">
	<?php
		$image_path = $client_result[0]['company_logo_large'];
		echo "<img src='".WEB_ROOT."/_uploads/".$image_path."' />";
	?>
</div>

<div class='page_header'>
	<h2>Menu</h2>
</div>

<div class="message">
	<?php Messages::render(); ?>
</div>

<div class="client_form">
	<?php echo $menu_form; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>