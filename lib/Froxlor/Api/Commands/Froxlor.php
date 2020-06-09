<?php
namespace Froxlor\Api\Commands;

use Froxlor\Database\Database;
use Froxlor\Settings;

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
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package API
 * @since 0.10.0
 *       
 */
class Froxlor extends \Froxlor\Api\ApiCommand
{

	/**
	 * checks whether there is a newer version of froxlor available
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function checkUpdate()
	{
		define('UPDATE_URI', "https://version.froxlor.org/Froxlor/api/" . $this->version);

		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			if (function_exists('curl_version')) {
				// log our actions
				$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "[API] checking for updates");

				// check for new version
				try {
					$latestversion = \Froxlor\Http\HttpClient::urlGet(UPDATE_URI, true, 3);
				} catch (\Exception $e) {
					$latestversion = \Froxlor\Froxlor::getVersion() . "|Version-check currently unavailable, please try again later";
				}
				$latestversion = explode('|', $latestversion);

				if (is_array($latestversion) && count($latestversion) >= 1) {
					$_version = $latestversion[0];
					$_message = isset($latestversion[1]) ? $latestversion[1] : '';
					$_link = isset($latestversion[2]) ? $latestversion[2] : '';

					// add the branding so debian guys are not gettings confused
					// about their version-number
					$version_label = $_version . $this->branding;
					$version_link = $_link;
					$message_addinfo = $_message;

					// not numeric -> error-message
					if (! preg_match('/^((\d+\\.)(\d+\\.)(\d+\\.)?(\d+)?(\-(svn|dev|rc)(\d+))?)$/', $_version)) {
						// check for customized version to not output
						// "There is a newer version of froxlor" besides the error-message
						$isnewerversion = - 1;
					} elseif (\Froxlor\Froxlor::versionCompare2($this->version, $_version) == - 1) {
						// there is a newer version - yay
						$isnewerversion = 1;
					} else {
						// nothing new
						$isnewerversion = 0;
					}

					// anzeige über version-status mit ggfls. formular
					// zum update schritt #1 -> download
					if ($isnewerversion == 1) {
						$text = 'There is a newer version available: "' . $_version . '" (Your current version is: ' . $this->version . ')';
						return $this->response(200, "successful", array(
							'isnewerversion' => $isnewerversion,
							'version' => $_version,
							'message' => $text,
							'link' => $version_link,
							'additional_info' => $message_addinfo
						));
					} elseif ($isnewerversion == 0) {
						// all good
						return $this->response(200, "successful", array(
							'isnewerversion' => $isnewerversion,
							'version' => $version_label,
							'message' => "",
							'link' => $version_link,
							'additional_info' => $message_addinfo
						));
					} else {
						\Froxlor\UI\Response::standard_error('customized_version', '', true);
					}
				}
			}
			return $this->response(300, "successful", array(
				'isnewerversion' => 0,
				'version' => $this->version . $this->branding,
				'message' => 'Version-check not available due to missing php-curl extension',
				'link' => UPDATE_URI . '/pretty',
				'additional_info' => ""
			));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * import settings
	 *
	 * @param string $json_str
	 *        	content of exported froxlor-settings json file
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded bool
	 */
	public function importSettings()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$json_str = $this->getParam('json_str');
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "User " . $this->getUserDetail('loginname') . " imported settings");
			try {
				\Froxlor\SImExporter::import($json_str);
				\Froxlor\System\Cronjob::inserttask('1');
				\Froxlor\System\Cronjob::inserttask('10');
				// Using nameserver, insert a task which rebuilds the server config
				\Froxlor\System\Cronjob::inserttask('4');
				// cron.d file
				\Froxlor\System\Cronjob::inserttask('99');
				return $this->response(200, "successful", true);
			} catch (\Exception $e) {
				throw new \Exception($e->getMessage(), 406);
			}
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * export settings
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-string
	 */
	public function exportSettings()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "User " . $this->getUserDetail('loginname') . " exported settings");
			$json_export = \Froxlor\SImExporter::export();
			return $this->response(200, "successful", $json_export);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return a list of all settings
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string json-encoded array count|list
	 */
	public function listSettings()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$sel_stmt = Database::prepare("
				SELECT * FROM `" . TABLE_PANEL_SETTINGS . "` ORDER BY settinggroup ASC, varname ASC
			");
			Database::pexecute($sel_stmt, null, true, true);
			$result = array();
			while ($row = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
				$result[] = array(
					'key' => $row['settinggroup'] . '.' . $row['varname'],
					'value' => $row['value']
				);
			}
			return $this->response(200, "successful", array(
				'count' => count($result),
				'list' => $result
			));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * return a setting by settinggroup.varname couple
	 *
	 * @param string $key
	 *        	settinggroup.varname couple
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string
	 */
	public function getSetting()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$setting = $this->getParam('key');
			return $this->response(200, "successful", Settings::Get($setting));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * updates a setting
	 *
	 * @param string $key
	 *        	settinggroup.varname couple
	 * @param string $value
	 *        	optional the new value, default is ''
	 *        	
	 * @access admin
	 * @throws \Exception
	 * @return string
	 */
	public function updateSetting()
	{
		// currently not implemented as it requires validation too so no wrong settings are being stored via API
		throw new \Exception("Not available yet.", 501);

		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$setting = $this->getParam('key');
			$value = $this->getParam('value', true, '');
			$oldvalue = Settings::Get($setting);
			if (is_null($oldvalue)) {
				throw new \Exception("Setting '" . $setting . "' could not be found");
			}
			$this->logger()->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_WARNING, "[API] Changing setting '" . $setting . "' from '" . $oldvalue . "' to '" . $value . "'");
			return $this->response(200, "successful", Settings::Set($setting, $value, true));
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * returns a random password based on froxlor settings for min-length, included characters, etc.
	 *
	 * @access admin, customer
	 * @return string
	 */
	public function generatePassword()
	{
		return $this->response(200, "successful", \Froxlor\System\Crypt::generatePassword());
	}

	/**
	 * can be used to remotely run the integritiy checks froxlor implements
	 *
	 * @access admin
	 * @throws \Exception
	 * @return string
	 */
	public function integrityCheck()
	{
		if ($this->isAdmin() && $this->getUserDetail('change_serversettings')) {
			$integrity = new \Froxlor\Database\IntegrityCheck();
			$result = $integrity->checkAll();
			if ($result) {
				return $this->response(200, "successful", "OK");
			}
			throw new \Exception("Some checks failed.", 406);
		}
		throw new \Exception("Not allowed to execute given command.", 403);
	}

	/**
	 * returns a list of all available api functions
	 *
	 * @param string $module
	 *        	optional, return list of functions for a specific module
	 *        	
	 * @access admin, customer
	 * @throws \Exception
	 * @return string json-encoded array
	 */
	public function listFunctions()
	{
		$module = $this->getParam('module', true, '');

		$functions = array();
		if ($module != null) {
			// check existence
			$this->requireModules($module);
			// now get all static functions
			$reflection = new \ReflectionClass(__NAMESPACE__ . '\\' . $module);
			$_functions = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($_functions as $func) {
				if ($func->class == __NAMESPACE__ . '\\' . $module && $func->isPublic()) {
					array_push($functions, array_merge(array(
						'module' => $module,
						'function' => $func->name
					), $this->getParamListFromDoc($module, $func->name)));
				}
			}
		} else {
			// check all the modules
			$path = \Froxlor\Froxlor::getInstallDir() . '/lib/Froxlor/Api/Commands/';
			// valid directory?
			if (is_dir($path)) {
				// create RecursiveIteratorIterator
				$its = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
				// check every file
				foreach ($its as $it) {
					// does it match the Filename pattern?
					$matches = array();
					if (preg_match("/^(.+)\.php$/i", $it->getFilename(), $matches)) {
						// check for existence
						try {
							// set the module to be in our namespace
							$mod = $matches[1];
							$this->requireModules($mod);
						} catch (\Exception $e) {
							// @todo log?
							continue;
						}
						// now get all static functions
						$reflection = new \ReflectionClass(__NAMESPACE__ . '\\' . $mod);
						$_functions = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
						foreach ($_functions as $func) {
							if ($func->class == __NAMESPACE__ . '\\' . $mod && $func->isPublic() && ! $func->isStatic()) {
								array_push($functions, array_merge(array(
									'module' => $matches[1],
									'function' => $func->name
								), $this->getParamListFromDoc($matches[1], $func->name)));
							}
						}
					}
				}
			} else {
				// yikes - no valid directory to check
				throw new \Exception("Cannot search directory '" . $path . "'. No such directory.", 500);
			}
		}

		// return the list
		return $this->response(200, "successful", $functions);
	}

	/**
	 * generate an api-response to list all parameters and the return-value of
	 * a given module.function-combination
	 *
	 * @param string $module
	 * @param string $function
	 *
	 * @throws \Exception
	 * @return array|bool
	 */
	private function getParamListFromDoc($module = null, $function = null)
	{
		try {
			// set the module
			$cls = new \ReflectionMethod(__NAMESPACE__ . '\\' . $module, $function);
			$comment = $cls->getDocComment();
			if ($comment == false) {
				return array(
					'head' => 'There is no comment-block for "' . $module . '.' . $function . '"'
				);
			}

			$clines = explode("\n", $comment);
			$result = array();
			$result['params'] = array();
			$param_desc = false;
			$r = array();
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
					$param_desc = true;
				} elseif (strpos($c, '@access')) {
					// check access-section
					preg_match('/^\*\s\@access\s(.*)/', $c, $r);
					if (! isset($r[0]) || empty($r[0])) {
						$r[1] = 'This function has no restrictions';
					}
					$result['access'] = array(
						'groups' => (isset($r[1]) ? trim($r[1]) : '')
					);
				} elseif (strpos($c, '@return')) {
					// check return-section
					preg_match('/^\*\s\@return\s(\w+)(\s.*)?/', $c, $r);
					if (! isset($r[0]) || empty($r[0])) {
						$r[1] = 'null';
						$r[2] = 'This function has no return value given';
					}
					$result['return'] = array(
						'type' => $r[1],
						'desc' => (isset($r[2]) ? trim($r[2]) : '')
					);
				} elseif (! empty($c) && strpos($c, '@throws') === false) {
					// check throws-section
					if (substr($c, 0, 3) == "/**") {
						continue;
					}
					if (substr($c, 0, 2) == "*/") {
						continue;
					}
					if (substr($c, 0, 1) == "*") {
						$c = trim(substr($c, 1));
						if (empty($c)) {
							continue;
						}
						if ($param_desc) {
							$result['params'][count($result['params']) - 1]['desc'] .= $c;
						} else {
							if (! isset($result['head']) || empty($result['head'])) {
								$result['head'] = $c . " ";
							} else {
								$result['head'] .= $c . " ";
							}
						}
					}
				}
			}
			$result['head'] = trim($result['head']);
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
	 * @throws \Exception
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
					$module = __NAMESPACE__ . '\\' . $module;
					// can we use the class?
					if (class_exists($module)) {
						continue;
					} else {
						throw new \Exception('The required class "' . $module . '" could not be found but the module-file exists', 404);
					}
				} catch (\Exception $e) {
					// The autoloader will throw an Exception
					// that the required class could not be found
					// but we want a nicer error-message for this here
					throw new \Exception('The required module "' . $module . '" could not be found', 404);
				}
			}
		}
	}
}
