<?php 

session_start();
require_once("../_config/config.php");
require_once(SERVER_ROOT."/_classes/Client.php");
$client = new Client();
$client->update_client();