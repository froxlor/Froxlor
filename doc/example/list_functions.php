<?php

// include FroxlorAPI helper class
require __DIR__ . '/FroxlorAPI.php';

// create object of FroxlorAPI with URL, apikey and apisecret
$fapi = new FroxlorAPI('https://froxlor.your-host.tld/api.php', 'your-api-key', 'your-api-secret');

// send request
$fapi->request('Froxlor.listFunctions');

// check for error
if (! empty($fapi->getLastError())) {
	echo "Error: " . $fapi->getLastError();
	exit();
}

// get response of request
$request = $fapi->getLastResponse();

// view response data
var_dump($request);
