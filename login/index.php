<?php 
    session_start();
    $page_class = 'login_page';
    require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . '/_classes/Messages.php');
    require_once(SERVER_ROOT . '/_classes/User.php');
    if (isset($_GET['forward-url'])) {
        $forward_url = $_GET['forward-url'];
    } else {
        $forward_url = "";
    }
    $user = new User();
    echo Messages::render();
	echo $user->get_login_form('client', $forward_url);
    require_once(SERVER_ROOT . "/_includes/global-footer.php");
?>