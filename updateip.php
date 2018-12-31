<?php

define('AREA', 'login');
require './lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Api\Commands\DomainZones as DomainZones;
use Froxlor\Api\Commands\SubDomains as SubDomains;


function response($code, $code_desc, $text) {
	header("HTTP/1.1 $code $code_desc");
	header('Content-Type: text/plain');
	echo $text;
	exit;
}

// workaround for DomainZones::get not returning all info
function domainZoneGet($domainid, $type) {
	$sel_stmt = Database::prepare("SELECT * FROM `" . TABLE_DOMAIN_DNS . "` WHERE domain_id = :did AND record = :record AND type = :type");
	Database::pexecute($sel_stmt, array(
		'did' => $domainid,
		'record' => '@',
		'type' => $type
	));
	$entries = $sel_stmt->fetchAll(PDO::FETCH_ASSOC);

	return count($entries) > 0 ? $entries[0] : null;
}

function update_record($domaininfo, $ip, $record, $type, $userinfo) {
	$changed = false;
	$entry = domainZoneGet($domaininfo['id'], $type);

	if ($entry === null || $ip != $entry['content']) {
		$changed = true;

		if ($entry !== null) {
			// Domain zones can't be updated, only deleted and added again.
			$params = array(
				'entry_id' => $entry['id'],
				'id' => $domaininfo['id']
			);
			DomainZones::getLocal($userinfo, $params)->delete();
		}

		$params = array(
			'id' => $domaininfo['id'],
			'type' => $type,
			'record' => $record,
			'content' => $ip
		);
		DomainZones::getLocal($userinfo, $params)->add();
	}

	return $changed;
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

foreach ($domains as $domain_name) {
	/**
	 * Check if domain is dynamically updatable.
	 */
	try {
		$domain = SubDomains::getLocal($userinfo, array(
			'domainname' => $domain_name
		))->get();
		$domain = json_decode($domain, true)['data'];

		if ($domain['isdynamicdomain'] == '1') {
			$domaininfos[$domain_name] = $domain;
		}
	} catch (\Exception $e) {
		// Nonexisting domains raise an exception. Ignore it here.
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

	$domainid = $domaininfo['id'];
	$record = '@';

	// Record must be set on the domain, not on the subdomain.
	if ($domaininfo['parentdomainid'] != 0) {
		$domainid = $domaininfo['parentdomainid'];
		$parentdomain = SubDomains::getLocal($userinfo, array(
			'id' => $domainid
		))->get();
		$record = str_replace('.' . $parentdomain['domain'], '', $domaininfo['domain']);
	}

	if ($ipv4 !== null) {
		$changed_ipv4 = update_record($domaininfo, $ipv4, $record, 'A', $userinfo);
	}
	if ($ipv6 !== null) {
		$changed_ipv6 = update_record($domaininfo, $ipv6, $record, 'AAAA', $userinfo);
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
