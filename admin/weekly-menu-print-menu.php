<?php
	$page_class = 'weekly_menu_print_menu_page';
	$page_title_detail = 'Weekly Menu - Print';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Menu.php");
    require_once(SERVER_ROOT . "/_classes/Messages.php");
	$menu = new Menu();
	$context = $green_heart_foods_access_level;
	$weekly_menu_print_menu = $menu->get_weekly_menu_print_menu($context);
?>

<?php Messages::render(); ?>

<div class="weekly_menu_print_menu">
	<?php echo $weekly_menu_print_menu; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>