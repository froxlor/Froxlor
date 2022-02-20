<?php

// include FroxlorAPI helper class
require __DIR__ . '/FroxlorAPI.php';

// create object of FroxlorAPI with URL, apikey and apisecret
$fapi = new FroxlorAPI('http://localhost/api.php', 'your-api-key', 'your-api-secret');

// send request
$response = $fapi->request('Froxlor.listFunctions');

// check for error
if ($fapi->getLastStatusCode() != 200) {
    echo "HTTP-STATUS: " . $fapi->getLastStatusCode() . PHP_EOL;
    echo "Description: "  . $response['message'] . PHP_EOL;
    exit();
}

// view response data
var_dump($response);
