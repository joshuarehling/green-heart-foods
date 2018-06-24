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
	$is_preset_client = ($client_id == 1 ? true : false);
	$menu = new Menu();
	$menu_form = $menu->get_menu_form($client_id);
?>

<div class='page_header'>
	<?php if ($is_preset_client) { ?>
		<ul>
			<li><h2>Create Preset</h2></li>
		</ul>
	<?php } else { ?>
		<ul>
			<li class="left start_with_preset_button" data-client-id="<?php echo $client_id; ?>">
				<a class='launch_preset_modal'>Start with Preset</a>
			</li>
			<li><h2>Menu</h2></li>
			<li class="right"><a class="" href="#">&nbsp;</a></li>
		</ul>
	<?php } ?>
</div>

<?php Messages::render(); ?>

<div class="client_form">
	<?php echo $menu_form; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>