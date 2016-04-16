<?php
	$page_class = 'daily_menu_print_placards_page print_placards_page';
	$page_title_detail = 'Daily Menu - Placards';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/print-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$daily_menu_print_placards = $menu->get_print_placards_page();
?>

<?php Messages::render(); ?>

<div class="daily_menu_print_placards">
	<?php echo $daily_menu_print_placards; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/print-footer.php"); ?>