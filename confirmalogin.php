<?php
include_once "control/sendrequest.php";

header("Content-type: text/html; charset=utf-8"); 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

ini_set('magic_quotes_runtime', 0);

session_start();

$dadosLogin = getParams();

$_SESSION["usuariologado"] = $dadosLogin["usuario"];
$sucesso["success"] = true;
echo json_encode($sucesso);

?>