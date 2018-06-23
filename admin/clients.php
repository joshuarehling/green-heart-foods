<?php 
	$page_class = 'clients_page';
	$page_title_detail = 'Clients';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
	require_once(SERVER_ROOT . "/_classes/Client.php");
	require_once(SERVER_ROOT . "/_classes/Messages.php");
	$client = new Client();
	$all_clients = $client->get_all_clients();
?>

<h1>Clients</h1>

<?php Messages::render(); ?>

<div class="client_list">
	<?php 
		for ($i=0; $i < count($all_clients); $i++) {
			$client_id = $all_clients[$i]['client_id'];
			$company_name = $all_clients[$i]['company_name'];
			$company_logo = WEB_ROOT . "/_uploads/".$all_clients[$i]['company_logo_small'];
			echo "<div class='client_result'>";
			echo 	"<a class='company_logo' href='yearly-menu.php?client-id=$client_id'><img src='$company_logo' /></a>";
			echo 	"<a class='edit_button' href='edit-client.php?client-id=$client_id'>Edit</a>";
			echo "</div>";
		}
	?>
</div>

<div class="button_container">

	<a class="page_button" href="create-menu.php?client-id=1">Create Preset</a>
	<a class="page_button" href="create-client.php">Add</a>
	<a class="page_button" href="create-batch-menu.php">Create Batch</a>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>