<?php 
	$page_class = 'edit_bite_modal';
	$page_title_detail = 'Edit Bite Modal';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
	require_once(SERVER_ROOT . "/_classes/Menu.php");
	$menu = new Menu();
	$bite_group_id = null;
	$bite_id = null;
	$context = $green_heart_foods_access_level;
	$bite_id = $_GET['bite-id'];
	$edit_bite_modal = $menu->get_edit_bite_modal($bite_id, $context);
?>

<?php 
	echo $edit_bite_modal;
?>