<?php

class Froxlor extends ApiCommand
{

	/**
	 * returns a list of all available api functions
	 *
	 * @param string $module optional, return list of functions for a specific module
	 *        	
	 * @throws Exception
	 * @return array
	 */
	public function listFunctions()
	{
		$module = $this->getParam('module');
		
		$functions = array();
		if ($module != null) {
			// check existence
			$this->requireModules($module);
			// now get all static functions
			$reflection = new \ReflectionClass($module);
			$_functions = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($_functions as $func) {
				if ($func->class == $module && $func->isPublic()) {
					array_push($functions, array_merge(array(
						'module' => $module,
						'function' => $func->name
					), $this->_getParamListFromDoc($module, $func->name)));
				}
			}
		} else {
			// check all the modules
			$path = FROXLOR_INSTALL_DIR . '/lib/classes/api/commands/';
			// valid directory?
			if (is_dir($path)) {
				// create RecursiveIteratorIterator
				$its = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
				// check every file
				foreach ($its as $fullFileName => $it) {
					// does it match the Filename pattern?
					$matches = array();
					if (preg_match("/^class\.(.+)\.php$/i", $it->getFilename(), $matches)) {
						// check for existence
						try {
							// set the module to be in our namespace
							$mod = $matches[1];
							$this->requireModules($mod);
						} catch (Exception $e) {
							// @todo log?
							continue;
						}
						// now get all static functions
						$reflection = new \ReflectionClass($mod);
						$_functions = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
						foreach ($_functions as $func) {
							if ($func->class == $mod && $func->isPublic()) {
								array_push($functions, array_merge(array(
									'module' => $matches[1],
									'function' => $func->name
								), $this->_getParamListFromDoc($matches[1], $func->name)));
							}
						}
					}
				}
			} else {
				// yikes - no valid directory to check
				throw new Exception("Cannot search directory '" . $path . "'. No such directory.", 500);
			}
		}
		
		// return the list
		return $this->response(200, "successfull", $functions);
	}

	/**
	 * generate an api-response to list all parameters and the return-value of
	 * a given module.function-combination
	 *
	 * @param string $module
	 * @param string $function
	 *
	 * @throws Exception
	 * @return array|bool
	 */
	private function _getParamListFromDoc($module = null, $function = null)
	{
		try {
			// set the module to be in our namespace
			$cls = new \ReflectionMethod($module, $function);
			$comment = $cls->getDocComment();
			if ($comment == false) {
				return array(
					'head' => 'There is no comment-block for "' . $module . '.' . $function . '"'
				);
			}
			$clines = explode("\n", $comment);
			$result = array();
			$result['params'] = array();
			foreach ($clines as $c) {
				$c = trim($c);
				// check param-section
				if (strpos($c, '@param')) {
					preg_match('/^\*\s\@param\s(.+)\s(\$\w+)(\s.*)?/', $c, $r);
					// cut $ off the parameter-name as it is not wanted in the api-request
					$result['params'][] = array(
						'parameter' => substr($r[2], 1),
						'type' => $r[1],
						'desc' => (isset($r[3]) ? trim($r['3']) : '')
					);
				} // check return-section
				elseif (strpos($c, '@return')) {
					preg_match('/^\*\s\@return\s(\w+)(\s.*)?/', $c, $r);
					if (! isset($r[0]) || empty($r[0])) {
						$r[1] = 'null';
						$r[2] = 'This function has no return value given';
					}
					$result['return'] = array(
						'type' => $r[1],
						'desc' => (isset($r[2]) ? trim($r[2]) : '')
					);
				} else if (! empty($c) && strpos($c, '@throws') === false) {
					if (substr($c, 0, 3) == "/**")
						continue;
					if (substr($c, 0, 2) == "*/")
						continue;
					if (substr($c, 0, 1) == "*")
						$c = trim(substr($c, 1));
					if (empty($c))
						continue;
					if (! isset($result['head']) || empty($result['head'])) {
						$result['head'] = $c . " ";
					} else {
						$result['head'] .= $c . " ";
					}
				}
			}
			return $result;
		} catch (\ReflectionException $e) {
			return array();
		}
	}

	/**
	 * this functions is used to check the availability
	 * of a given list of modules.
	 * If either one of
	 * them are not found, throw an Exception
	 *
	 * @param string|array $modules
	 *
	 * @throws Exception
	 */
	private function requireModules($modules = null)
	{
		if ($modules != null) {
			// no array -> create one
			if (! is_array($modules)) {
				$modules = array(
					$modules
				);
			}
			// check all the modules
			foreach ($modules as $module) {
				try {
					// can we use the class?
					if (class_exists($module)) {
						continue;
					} else {
						throw new Exception('The required class "' . $module . '" could not be found but the module-file exists', 404);
					}
				} catch (Exception $e) {
					// The autoloader will throw an Exception
					// that the required class could not be found
					// but we want a nicer error-message for this here
					throw new Exception('The required module "' . $module . '" could not be found', 404);
				}
			}
		}
	}
}
