<?php

include_once "sendrequest.php";

header("Content-type: text/html; charset=utf-8"); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

ini_set('magic_quotes_runtime', 0);

session_start();

echo curlPost(getDataRequest(), 'http://prontcargo.ws.brudam.com.br/tracking/destinatario');
?>