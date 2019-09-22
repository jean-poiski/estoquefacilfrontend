<?php
include_once "sendrequest.php";

header("Content-type: text/html; charset=utf-8"); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

ini_set('magic_quotes_runtime', 0);

session_start();

$objParams = getParams();
$eventosWs = curlPost(getDataRequest(), 'http://prontcargo.ws.brudam.com.br/tracking/documentos');
$eventosWs = json_decode($eventosWs, true);

$eventos = array();

if($eventosWs["status"]) {
    $minuta = $objParams["documentos"];
    $eventos = $eventosWs["dados"][$minuta]["eventos"];
}

echo json_encode($eventos);

?>