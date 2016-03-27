<?php 
	$page_class = 'add_bite_modal';
	$page_title_detail = 'Add Bite Modal';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$bite_group_id = null;
	$context = $green_heart_foods_access_level;
	$bite_group_id = $_GET['bite-group-id'];
	$add_bite_modal = $menu->get_add_bite_modal($bite_group_id, $context);
?>

<?php 
	echo $add_bite_modal;
?>