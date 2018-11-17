<?php
require __DIR__ . '/lib/classes/api/api_includes.inc.php';

// check whether API interface is enabled after all
if (Settings::Get('api.enabled') != 1) {
	// not enabled
	header("Status: 404 Not found", 404);
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not found", 404);
	exit();
}

// we're talking json here
header("Content-Type:application/json");

// get our request
$request = @file_get_contents('php://input');

// check if present
if (empty($request)) {
	json_response(400, "Invalid request");
}

// decode json request
$decoded_request = json_decode(stripslashes($request), true);

// is it valid?
if (is_null($decoded_request)) {
	json_response(400, "Invalid JSON");
}

// validate content
try {
	$request = FroxlorRPC::validateRequest($decoded_request);
	// now actually do it
	$cls = $request['command']['class'];
	$method = $request['command']['method'];
	$apiObj = new $cls($decoded_request['header'], $request['params']);
	// call the method with the params if any
	echo $apiObj->$method();
} catch (Exception $e) {
	json_response($e->getCode(), $e->getMessage());
}

exit();

/**
 * output json result
 *
 * @param int $status
 * @param string $status_message
 * @param mixed $data
 *
 * @return void
 */
function json_response($status, $status_message = '', $data = null)
{
	if (isset($_SERVER["SERVER_PROTOCOL"]) && ! empty($_SERVER["SERVER_PROTOCOL"])) {
		$resheader = $_SERVER["SERVER_PROTOCOL"] . " " . $status;
		if (! empty($status_message)) {
			$resheader .= ' ' . str_replace("\n", " ", $status_message);
		}
		header($resheader);
	}
	$response = array();
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	
	$json_response = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	echo $json_response;
	exit();
}
