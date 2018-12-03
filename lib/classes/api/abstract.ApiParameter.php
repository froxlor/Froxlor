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
abstract class ApiParameter
{

	/**
	 * array of parameters passed to the command
	 *
	 * @var array
	 */
	private $cmd_params = null;

	/**
	 *
	 * @param array $params
	 *        	optional, array of parameters (var=>value) for the command
	 *        	
	 * @throws Exception
	 */
	public function __construct($params = null)
	{
		if (! is_null($params)) {
			$params = $this->trimArray($params);
		}
		$this->cmd_params = $params;
	}

	/**
	 * get specific parameter from the parameterlist;
	 * check for existence and != empty if needed.
	 * Maybe more in the future
	 *
	 * @param string $param
	 *        	parameter to get out of the request-parameter list
	 * @param bool $optional
	 *        	default: false
	 * @param mixed $default
	 *        	value which is returned if optional=true and param is not set
	 *        	
	 * @throws Exception
	 * @return mixed
	 */
	protected function getParam($param = null, $optional = false, $default = '')
	{
		// does it exist?
		if (! isset($this->cmd_params[$param])) {
			if ($optional === false) {
				// get module + function for better error-messages
				$inmod = $this->getModFunctionString();
				throw new Exception('Requested parameter "' . $param . '" could not be found for "' . $inmod . '"', 404);
			}
			return $default;
		}
		// is it empty? - test really on string, as value 0 is being seen as empty by php
		if ($this->cmd_params[$param] === "") {
			if ($optional === false) {
				// get module + function for better error-messages
				$inmod = $this->getModFunctionString();
				throw new Exception('Requested parameter "' . $param . '" is empty where it should not be for "' . $inmod . '"', 406);
			}
			return '';
		}
		// everything else is fine
		return $this->cmd_params[$param];
	}

	/**
	 * getParam wrapper for boolean parameter
	 *
	 * @param string $param
	 *        	parameter to get out of the request-parameter list
	 * @param bool $optional
	 *        	default: false
	 * @param mixed $default
	 *        	value which is returned if optional=true and param is not set
	 *
	 * @return string
	 */
	protected function getBoolParam($param = null, $optional = false, $default = false)
	{
		$_default = '0';
		if ($default) {
			$_default = '1';
		}
		$param_value = $this->getParam($param, $optional, $_default);
		if ($param_value && intval($param_value) != 0) {
			return '1';
		}
		return '0';
	}

	/**
	 * get specific parameter which also has and unlimited-field
	 *
	 * @param string $param
	 *        	parameter to get out of the request-parameter list
	 * @param string $ul_field
	 *        	parameter to get out of the request-parameter list
	 * @param bool $optional
	 *        	default: false
	 * @param mixed $default
	 *        	value which is returned if optional=true and param is not set
	 *        	
	 * @return mixed
	 * @throws Exception
	 */
	protected function getUlParam($param = null, $ul_field = null, $optional = false, $default = 0)
	{
		$param_value = intval_ressource($this->getParam($param, $optional, $default));
		$ul_field_value = $this->getBoolParam($ul_field, true, 0);
		if ($ul_field_value != '0') {
			$param_value = - 1;
		}
		return $param_value;
	}

	/**
	 * return list of all parameters
	 *
	 * @return array
	 */
	protected function getParamList()
	{
		return $this->cmd_params;
	}

	/**
	 * returns "module::function()" for better error-messages (missing parameter etc.)
	 * makes debugging a whole lot more comfortable
	 *
	 * @param int $level
	 *        	depth of backtrace, default 2
	 *        	
	 * @param int $max_level
	 * @param array|null $trace
	 *
	 * @return string
	 */
	private function getModFunctionString($level = 1, $max_level = 5, $trace = null)
	{
		// which class called us
		$_class = get_called_class();
		if (empty($trace)) {
			// get backtrace
			$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		}
		// check class and function
		$class = $trace[$level]['class'];
		$func = $trace[$level]['function'];
		// is it the one we are looking for?
		if ($class != $_class && $level <= $max_level) {
			// check one level deeper
			return $this->getModFunctionString(++ $level, $max_level, $trace);
		}
		return $class . ':' . $func;
	}

	/**
	 * run 'trim' function on an array recursively
	 *
	 * @param array $input
	 *
	 * @return array
	 */
	private function trimArray($input)
	{
		if (! is_array($input)) {
			return trim($input);
		}
		return array_map(array(
			$this,
			'trimArray'
		), $input);
	}
}
