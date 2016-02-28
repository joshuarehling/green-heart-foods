<?php
	$page_class = 'edit_client_page';
	$page_title_detail = 'Edit Client';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
    require_once(SERVER_ROOT . "/_classes/Client.php");
	$client = new Client();
	$client_id = $_GET['client-id'];
	$client_form = $client->get_client_form($client_id);
?>

<h1>Clients</h1>

<div class='page_header'>
	<h2>Edit Client</h2>
</div>

<?php echo Messages::render(); ?>

<div class="client_form">
	<?php echo $client_form ?>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>