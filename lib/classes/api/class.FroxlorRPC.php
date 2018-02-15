<?php

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
					$ip_list = explode(",", $result['allowed_from']);
					$access_ip = $_SERVER['REMOTE_ADDR'];
					// @fixme finish me
				}
				return true;
			}
		}
		throw new Exception("Invalid authorization credentials", 400);
	}

	/**
	 * validates the given command
	 *
	 * @param array $body
	 *
	 * @throws Exception
	 * @return boolean
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
			// there will be an exception from the autoloader for class_exists hence the try-catch-block
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
