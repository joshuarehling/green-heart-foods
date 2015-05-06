<?php 
	require_once('../_config/config.php');
	require_once(SERVER_ROOT . '/_classes/User.php');
	if(isset($_SESSION['user_display_name'])) {
		$login_message = "".$_SESSION['user_display_name'].", <a href='".WEB_ROOT."/_actions/logout.php'>Sign Out</a>";
	} else {
		$login_message = "<a href='".WEB_ROOT."/login/'>Login</a>";
	}
	if(!isset($page_class)) {
		$page_class = "";
	}
	if(!isset($page_title_detail)) {
		$page_title_detail = "";
	} else {
		$page_title_detail = " - ".$page_title_detail;
	}
?>

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Green Heart Foods<?php echo $page_title_detail; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/main.css">
	
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:700,400,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/main.js"></script>

	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/checkboxes.js"></script>
	
	<!-- include this to handle high res @2x photos -->
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/retina/retina.min.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/retina/retina.js"></script>

</head>

<body class="<?php echo $page_class; ?>">
<div class="main_container">
	<header>
		<div class="green_heart_foods_logo"><a href="http://www.greenheartfoods.com"><img src="../_images/ui/header_ghf_logo.png" /></a></div>
		<ul>
			<li><a href="<?php echo WEB_ROOT; ?>/clients/">Clients</a></li>
			<li><?php echo $login_message; ?></li>
		</ul>
	</header>
	<!--<div class="login_status_message">
		<p><?php echo $login_message; ?></p>
	</div>-->