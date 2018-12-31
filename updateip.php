<?php

define('AREA', 'login');
require './lib/init.php';

function response($code, $code_desc, $text) {
	header("HTTP/1.1 $code $code_desc");
	header('Content-Type: text/plain');
	echo $text;
	exit;
}

/**
 * Require authentication.
 */
if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_REQUEST['username']) && !isset($_REQUEST['password'])) {
	header('WWW-Authenticate: Basic realm="Dynamic IP Update"');
	response(401, 'Unauthorized', 'No username and password parameter set, HTTP authentication required.');
}

/**
 * Get username and password.
 */
if (isset($_SERVER['PHP_AUTH_USER'])) {
	$loginname = \Froxlor\Validate\Validate::validate($_SERVER['PHP_AUTH_USER'], 'loginname');
	$password = \Froxlor\Validate\Validate::validate($_SERVER['PHP_AUTH_PW'], 'password');
}
else {
	$loginname = \Froxlor\Validate\Validate::validate($_REQUEST['username'], 'loginname');
	$password = \Froxlor\Validate\Validate::validate($_REQUEST['password'], 'password');
}

/**
 * Retreive user information.
 */
$userinfo_stmt = \Froxlor\Database\Database::prepare("SELECT * FROM `" . TABLE_PANEL_CUSTOMERS . "`
	WHERE `loginname`= :loginname"
);
\Froxlor\Database\Database::pexecute($userinfo_stmt, array("loginname" => $loginname));
$userinfo = $userinfo_stmt->fetch(PDO::FETCH_ASSOC);

/**
 * Validate password.
 */
if (!\Froxlor\System\Crypt::validatePasswordLogin($userinfo, $password)) {
	response(403, 'Forbidden', 'badauth');
}

/**
 * Get domain.
 */
if (!isset($_REQUEST['domain'])) {
	response(400, 'Bad Request', 'nohost');
}

$domains = explode(',', $_REQUEST['domain']);
$domaininfos = array();

foreach ($domains as $domain) {

	/**
	 * Check if domain is dynamically updatable.
	 */
	$domain_stmt = \Froxlor\Database\Database::prepare("SELECT * FROM `" . TABLE_PANEL_DOMAINS . "`
		WHERE `domain`= :domain AND `customerid` = :customerid"
	);
	\Froxlor\Database\Database::pexecute($domain_stmt, array("domain" => $domain, "customerid" => $userinfo["customerid"]));

	if ($domain_stmt->rowCount() != 0) {
		$domaininfo = $domain_stmt->fetch(PDO::FETCH_ASSOC);
		if ($domaininfo['isdynamicdomain']) {
			$domaininfos[$domain] = $domaininfo;
		}
	}
}

$unavailable_domains = array_diff($domains, array_keys($domaininfos));
if (count($unavailable_domains) > 0) {
	response(400, 'Bad Request', 'nohost ' . implode(',', $unavailable_domains));
}


/**
 * Get IP addresses.
 */
$ipv4 = null;
$ipv6 = null;

if (isset($_REQUEST['ipv4'])) {
	$ipv4 = $_REQUEST['ipv4'];
	if (!filter_var($ipv4, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
		response(400, 'Bad Request', 'Invalid IPv4.');
	}
}
if (isset($_REQUEST['ipv6'])) {
	$ipv6 = $_REQUEST['ipv6'];
	if (!filter_var($ipv6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
		response(400, 'Bad Request', 'Invalid IPv6.');
	}
}

if (isset($_REQUEST['detect'])) {
	// No ip provided, detect IP.

	$ip = $_SERVER['REMOTE_ADDR'];
	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
		$ipv4 = $ip;
	else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
		$ipv6 = $ip;
	else {
		response(500, 'Internal Server Error', 'Unable to detect IP. It must be provided.');
	}
}

$changed_ipv4 = false;
$changed_ipv6 = false;

foreach ($domaininfos as $domain => $domaininfo) {
	$perform_update = false;
	if ($ipv4 != $domaininfo['dynamicipv4']) {
		$changed_ipv4 = true;
		$perform_update = true;
	}
	if ($ipv6 != $domaininfo['dynamicipv6']) {
		$changed_ipv6 = true;
		$perform_update = true;
	}

	if ($perform_update) {
		$update_stmt = \Froxlor\Database\Database::prepare("UPDATE `" . TABLE_PANEL_DOMAINS . "`
			SET `dynamicipv4` = :dynamicipv4,
			`dynamicipv6` = :dynamicipv6
			WHERE `domain` = :domain"
		);
		\Froxlor\Database\Database::pexecute($update_stmt, array("dynamicipv4" => $ipv4, "dynamicipv6" => $ipv6, "domain" => $domain));
	}
}

/**
 * Build response.
 */
$messages = array();
if (!$changed_ipv4) {
	$messages[] = "nochg $ipv4";
}
else {
	$messages[] = "good $ipv4";
}

if (!$changed_ipv6) {
	$messages[] ="nochg $ipv6";
}
else {
	$messages[] ="good $ipv6";
}

if ($changed_ipv4 || $changed_ipv6)
{
	/**
	 * Insert a task which rebuilds the server config.
	 */
	\Froxlor\System\Cronjob::inserttask('4');
}

response(200, 'OK', implode($messages, "\n"));
?>
