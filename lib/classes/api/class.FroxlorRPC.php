<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    API
 * @since      0.10.0
 *
 */
class FroxlorRPC
{

	/**
	 * validate a given request
	 *
	 * @param array $request
	 *
	 * @throws Exception
	 * @return array
	 */
	public static function validateRequest($request)
	{
		// check header
		if (! isset($request['header']) || empty($request['header'])) {
			throw new Exception("Invalid request header", 400);
		}
		
		// check authorization
		if (! isset($request['header']['apikey']) || empty($request['header']['apikey']) || ! isset($request['header']['secret']) || empty($request['header']['secret'])) {
			throw new Exception("No authorization credentials given", 400);
		}
		self::validateAuth($request['header']['apikey'], $request['header']['secret']);
		
		// check command
		return self::validateBody($request);
	}

	/**
	 * validates the given api credentials
	 *
	 * @param string $key
	 * @param string $secret
	 *
	 * @throws Exception
	 * @return boolean
	 */
	private static function validateAuth($key, $secret)
	{
		$sel_stmt = Database::prepare("SELECT * FROM `api_keys` WHERE `apikey` = :ak AND `secret` = :as");
		$result = Database::pexecute_first($sel_stmt, array(
			'ak' => $key,
			'as' => $secret
		), true, true);
		if ($result) {
			if ($result['apikey'] == $key && $result['secret'] == $secret && ($result['valid_until'] == -1 || $result['valid_until'] >= time())) {
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
		throw new Exception("Invalid authorization credentials", 403);
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
		// check body
		if (! isset($request['body']) || empty($request['body'])) {
			throw new Exception("Invalid request body", 400);
		}
		
		// check command exists
		if (! isset($request['body']['command']) || empty($request['body']['command'])) {
			throw new Exception("No command given", 400);
		}
		
		$command = explode(".", $request['body']['command']);
		
		if (count($command) != 2) {
			throw new Exception("Invalid command", 400);
		}
		// simply check for file-existance, as we do not want to use our autoloader because this way
		// it will recognize non-api classes+methods as valid commands
		$apiclass = FROXLOR_INSTALL_DIR . '/lib/classes/api/commands/class.' . $command[0] . '.php';
		if (! file_exists($apiclass) || ! @method_exists($command[0], $command[1])) {
			throw new Exception("Unknown command", 400);
		}
		return array(
			'command' => array(
				'class' => $command[0],
				'method' => $command[1]
			),
			'params' => isset($request['body']['params']) ? $request['body']['params'] : null
		);
	}
}
