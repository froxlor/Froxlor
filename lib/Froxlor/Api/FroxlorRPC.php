<?php

namespace Froxlor\Api;

use Exception;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.0
 *
 */
class FroxlorRPC
{
	/**
	 * validate a given request
	 *
	 * @param $request
	 * @return array
	 * @throws Exception
	 */
	public static function validateRequest($request): array
	{
		// make basic authentication
		if (!isset($_SERVER['PHP_AUTH_USER']) || !self::validateAuth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
			if (@php_sapi_name() !== 'cli') {
				header('WWW-Authenticate: Basic realm="API"');
			}
			throw new Exception('Unauthenticated. Please provide api user credentials.', 401);
		}

		// check if present
		if (empty($request)) {
			throw new Exception('Empty request body.', 400);
		}

		// decode json request
		$decoded_request = json_decode($request, true);

		// is it valid?
		if (is_null($decoded_request)) {
			throw new Exception('Invalid JSON Format.', 400);
		}

		return self::validateBody($decoded_request);
	}

	/**
	 * validates the given api credentials
	 *
	 * @param string $key
	 * @param string $secret
	 * @return boolean
	 */
	private static function validateAuth(string $key, string $secret): bool
	{
		$sel_stmt = \Froxlor\Database\Database::prepare(
			"
			SELECT ak.*, a.api_allowed as admin_api_allowed, c.api_allowed as cust_api_allowed, c.deactivated
			FROM `api_keys` ak
			LEFT JOIN `panel_admins` a ON a.adminid = ak.adminid
			LEFT JOIN `panel_customers` c ON c.customerid = ak.customerid
			WHERE `apikey` = :ak AND `secret` = :as
		"
		);
		$result = \Froxlor\Database\Database::pexecute_first($sel_stmt, array(
			'ak' => $key,
			'as' => $secret
		), true, true);
		if ($result) {
			if ($result['apikey'] == $key && $result['secret'] == $secret && ($result['valid_until'] == -1 || $result['valid_until'] >= time()) && (($result['customerid'] == 0 && $result['admin_api_allowed'] == 1) || ($result['customerid'] > 0 && $result['cust_api_allowed'] == 1 && $result['deactivated'] == 0))) {
				// get user to check whether api call is allowed
				if (!empty($result['allowed_from'])) {
					// @todo allow specification and validating of whole subnets later
					$ip_list = explode(",", $result['allowed_from']);
					$access_ip = inet_ntop(inet_pton($_SERVER['REMOTE_ADDR']));
					if (in_array($access_ip, $ip_list)) {
						return true;
					}
				} else {
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * validates the given command
	 *
	 * @param array $request
	 *
	 * @return array
	 * @throws Exception
	 */
	private static function validateBody($request)
	{
		// check command exists
		if (empty($request['command'])) {
			throw new Exception("Please provide a command.", 400);
		}

		$command = explode(".", $request['command']);

		if (count($command) != 2) {
			throw new Exception("The given command is invalid.", 400);
		}
		// simply check for file-existance, as we do not want to use our autoloader because this way
		// it will recognize non-api classes+methods as valid commands
		$apiclass = '\\Froxlor\\Api\\Commands\\' . $command[0];
		if (!class_exists($apiclass) || !@method_exists($apiclass, $command[1])) {
			throw new Exception("Unknown command", 400);
		}
		return array(
			'command' => array(
				'class' => $command[0],
				'method' => $command[1]
			),
			'params' => $request['params'] ?? null
		);
	}
}
