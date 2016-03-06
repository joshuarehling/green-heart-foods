<?php
	$page_class = 'weekly_menu_print_placards_page';
	$page_title_detail = 'Weekly Menu - Placards';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$weekly_menu_print_placards = $menu->get_weekly_menu_print_placrds($context);
?>

<?php Messages::render(); ?>

<div class="weekly_menu_print_placards">
	<?php echo $weekly_menu_print_placards; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>