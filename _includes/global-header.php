<?php 
	require_once('../_config/config.php');
	require_once(SERVER_ROOT . '/_classes/Client.php');
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

	if(isset($_GET['client-id'])) {
		$client_id = $_GET['client-id'];
		$client = new Client();
		$client_result = $client->get_client($client_id);	
	}

	switch ($page_class) {
		case 'weekly_menu_page':
			$image_path = WEB_ROOT."/_uploads/".$client_result[0]['company_logo_large'];
			$header_style = "style='background-image:url($image_path)'";
			break;
		default:
			$header_style = "";
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
	<header <?php echo $header_style; ?>>
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
								echo "<a href='".WEB_ROOT."/clients/weekly-menu.php?client-id=$client_id'>Menu</a>";
								break;
							case 3:
								echo "<a href='".WEB_ROOT."/clients/weekly-menu.php?client-id=$client_id'>Menu</a>";
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
	<!--<div class="login_status_message">
		<p><?php echo $login_message; ?></p>
	</div>-->