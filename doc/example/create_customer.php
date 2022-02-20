<?php

// include FroxlorAPI helper class
require __DIR__ . '/FroxlorAPI.php';

// create object of FroxlorAPI with URL, apikey and apisecret
$fapi = new FroxlorAPI('http://127.0.0.1/api.php', 'your-api-key', 'your-api-secret');

// customer data
$data = [
	'new_loginname' => 'test',
	'email' => 'test@froxlor.org',
	'firstname' => 'Test',
	'name' => 'Testman',
	'customernumber' => 1337,
	'new_customer_password' => 's0mEcRypt1cpassword' . uniqid()
];
// send request
$response = $fapi->request('Customers.add', $data);

// check for error
if ($fapi->getLastStatusCode() != 200) {
	echo "HTTP-STATUS: " . $fapi->getLastStatusCode() . PHP_EOL;
    echo "Description: "  . $response['message'] . PHP_EOL;
    exit();
}

// view response data
var_dump($response);

/*
array(60) {
  ["customerid"]=>
  string(1) "1"
  ["loginname"]=>
  string(4) "test"
  ["password"]=>
  string(63) "$5$asdasdasd.asdasd"
  ["adminid"]=>
  string(1) "1"
  ["name"]=>
  string(7) "Testman"
  ["firstname"]=>
  string(4) "Test"
  [...]
*/