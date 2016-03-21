<?php 
	$page_class = 'edit_bites_page';
	$page_title_detail = 'Edit Bites';
	require_once("../_config/config.php");
    require_once(SERVER_ROOT . "/_includes/restrict-access-green-heart-foods.php");
    require_once(SERVER_ROOT . "/_includes/global-header.php");
	require_once(SERVER_ROOT . "/_classes/Messages.php");
?>

<h1>Edit Bites</h1>

<?php Messages::render(); ?>

<div class="client_form">
	<p>Edit Bites Page</p>
</div>

<?php require_once(SERVER_ROOT . "/_includes/global-footer.php"); ?>