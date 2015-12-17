<?php
require("class-Clockwork.php");
$apikey ="6295811828bb3c2a7d04ba6f8bb8b2cda42090f4";
$clockwork = new Clockwork($apikey);

$message = array( 'to' => '924028200','message' => 'A sua encomenda no Restaurante Dom Petisco foi feita com sucesso.');
$done = $clockwork->send($message);
?>