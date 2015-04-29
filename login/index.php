<?php 
    session_start();
    $page_class = 'login_page';
    require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . '/_classes/Messages.php');
    require_once(SERVER_ROOT . '/_classes/User.php');
    $user = new User();
    echo Messages::render();
	echo $user->get_login_form('client');
    require_once(SERVER_ROOT . "/_includes/global-footer.php");
?>