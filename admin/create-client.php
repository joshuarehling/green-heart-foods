<?php 
	$page_class = 'create_client_page';
	$page_title_detail = 'Create Client';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
	require_once(SERVER_ROOT . "/_classes/Client.php");
	require_once(SERVER_ROOT . "/_classes/Messages.php");
	$client = new Client();
	$client_form = $client->get_client_form();
?>

<h1>Clients</h1>

<div class='page_header'>
	<h2>Create Client</h2>
</div>

<?php Messages::render(); ?>

<div class="client_form">
	<?php echo $client_form; ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>