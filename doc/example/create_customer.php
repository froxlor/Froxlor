<?php

// include FroxlorAPI helper class
require __DIR__ . '/FroxlorAPI.php';

// create object of FroxlorAPI with URL, apikey and apisecret
$fapi = new FroxlorAPI('https://froxlor.your-host.tld/api.php', 'your-api-key', 'your-api-secret');

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
$fapi->request('Customers.add', $data);

// check for error
if (! empty($fapi->getLastError())) {
	echo "Error: " . $fapi->getLastError();
	exit();
}

// get response of request
$request = $fapi->getLastResponse();

// view response data
var_dump($request);

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