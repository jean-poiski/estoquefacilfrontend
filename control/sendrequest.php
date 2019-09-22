<?php

function getParams() {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, TRUE);

    return $obj;
}

function getDataRequest() {

    $obj = getParams();

    $obj["token"] = "a52ca3bb56742af0d66377d47a24a456";

    return http_build_query($obj);
}

function curlPost($data, $url) {
    $curl_connection =
    
    //create cURL connection
    $curl_connection = curl_init($url);

    //set options
    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl_connection, CURLOPT_USERAGENT, 
    "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

    //set data to be posted
    curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $data);

    //perform our request
    $result = curl_exec($curl_connection);

    //close the connection
    curl_close($curl_connection);    

    return $result;
}

?>