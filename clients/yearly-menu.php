<?php
	session_start();
	$page_class = 'yearly_menu_page client';
	$page_title_detail = 'Yearly Menu';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-client.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    // require_once(SERVER_ROOT . "/_classes/Client.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $client_access_level;
	$menu = $menu->get_yearly_menu_page($context);
?>

<?php Messages::render(); ?>

<div class="menu">
	<?php echo $menu; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>