<?php 
	require_once('../_config/config.php');
	require_once(SERVER_ROOT . '/_classes/Client.php');
	require_once(SERVER_ROOT . '/_classes/User.php');
	if(isset($_SESSION['user_display_name'])) {
		//$login_message = "Hello ".$_SESSION['user_display_name'].", <a href='".WEB_ROOT."/_actions/logout.php'>Sign Out</a>";
		$login_message = "Hello Food Lover, <a href='".WEB_ROOT."/_actions/logout.php'>Sign Out</a>";
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
	if(isset($_GET['client-id'])) {
		$client_id = $_GET['client-id'];
		$client = new Client();
		$client_result = $client->get_client($client_id);	
	}
	$client_header_array = array('daily_menu_page', 'weekly_menu_page', 'create_and_edit_menu create_menu_page', 'create_and_edit_menu edit_menu_page', 'daily_menu_page client');
	$use_client_header = array_search($page_class, $client_header_array);
	if($use_client_header > -1) {
		$image_path = WEB_ROOT."/_uploads/".$client_result[0]['company_logo_large'];
		$header_style = "background-image:url($image_path)";
		$header_class = "background_logo";
	} else {
		$header_style = "";
		$header_class = "";
	}
?>

<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Green Heart Foods<?php echo $page_title_detail; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/normalize.css">
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/main.css">
	<!-- custom select menus -->
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/dropdowns/cs-select.css" /><!-- don't change these -->
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>/_css/dropdowns/cs-skin-border.css" /><!-- sets visual style -->
	<!-- google fonts -->
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:700,400,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<!-- various stuff -->	
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/main.js"></script>
	<!-- custom checkboxes -->
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/checkboxes/checkboxes.js"></script>
	<!-- retina images -->
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/retina/retina.min.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>/_javascript/retina/retina.js"></script>

</head>

<body class="<?php echo $page_class; ?>">
<div class="main_container">
	<header <?php echo "style='$header_style' class='$header_class'"; ?>>
		<div class="green_heart_foods_logo"><a href="http://www.greenheartfoods.com"><img src="../_images/ui/header_ghf_logo.png" /></a></div>
		<ul>
			<li>
				<?php 
					if(isset($_SESSION['user_type_id'])) {
						switch ($_SESSION['user_type_id']) {
							case 1:
								echo "<a href='".WEB_ROOT."/admin/clients.php'>Clients</a>";								
								break;
							case 2:
								echo "<a href='".WEB_ROOT."/clients/weekly-menu.php?client-id=$client_id'>Weekly Menu</a>";
								break;
							case 3:
								echo "<a href='".WEB_ROOT."/clients/weekly-menu.php?client-id=$client_id'>Weekly Menu</a>";
								break;
							default:
								break;
						}
					}
				?>
			</li>
			<li><?php echo $login_message; ?></li>
		</ul>
	</header>