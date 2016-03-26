<?php 
	$page_class = 'edit_bites_page';
	$page_title_detail = 'Edit Bites';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
	require_once(SERVER_ROOT . "/_classes/Messages.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$edit_bites_page = $menu->get_edit_bites_page($context);
?>

<h1>Edit Bites</h1>

<?php 
	Messages::render(); 
	echo $edit_bites_page;
?>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>