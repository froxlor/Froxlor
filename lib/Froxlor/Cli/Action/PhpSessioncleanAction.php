<?php

namespace Froxlor\Cli\Action;

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\Cli\PhpSessioncleanCmd;

class PhpSessioncleanAction extends \Froxlor\Cli\Action
{

	public function __construct($args)
	{
		parent::__construct($args);
	}

	public function run()
	{
		$this->validate();

		if ((int) Settings::Get('phpfpm.enabled') == 1) {
			if (isset($this->_args["max-lifetime"]) && is_numeric($this->_args["max-lifetime"]) && $this->_args["max-lifetime"] > 0) {
				$this->cleanSessionfiles((int)$this->_args["max-lifetime"]);
			} else {
				// use default max-lifetime value
				$this->cleanSessionfiles();
			}
		}
	}

	/**
	 * validates the parsed command line parameters
	 *
	 * @throws \Exception
	 */
	private function validate()
	{
		global $lng;

		$this->checkConfigParam(true);
		$this->parseConfig();

		require FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
	}

	private function cleanSessionfiles(int $maxlifetime = 1440)
	{
		// store paths to clean up
		$paths_to_clean = [];
		// get all pool-config directories configured
		$sel_stmt = Database::prepare("SELECT DISTINCT `config_dir` FROM `" . TABLE_PANEL_FPMDAEMONS . "`");
		Database::pexecute($sel_stmt);
		while ($fpmd = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$poolfiles = glob(\Froxlor\FileDir::makeCorrectFile($fpmd['config_dir'] . '/*.conf'));
			foreach ($poolfiles as $cf) {
				$contents = file_get_contents($cf);
				$pattern = preg_quote('session.save_path', '/');
				$pattern = "/" . $pattern . ".+?\=(.*)/";
				if (preg_match_all($pattern, $contents, $matches)) {
					$paths_to_clean[] = \Froxlor\FileDir::makeCorrectDir(trim($matches[1][0]));
				}
			}
		}

		// every path is just needed once
		$paths_to_clean = array_unique($paths_to_clean);

		if (count($paths_to_clean) > 0) {
			foreach ($paths_to_clean as $ptc) {
				// find all files older then maxlifetime and delete them
				\Froxlor\FileDir::safe_exec("find -O3 \"" . $ptc . "\" -ignore_readdir_race -depth -mindepth 1 -name 'sess_*' -type f -cmin \"+" . $maxlifetime . "\" -delete");
			}
		}
	}
	private function parseConfig()
	{
		define('FROXLOR_INSTALL_DIR', $this->_args['froxlor-dir']);
		if (!class_exists('\\Froxlor\\Database\\Database')) {
			throw new \Exception("Could not find froxlor's Database class. Is froxlor really installed to '" . FROXLOR_INSTALL_DIR . "'?");
		}
		if (!file_exists(FROXLOR_INSTALL_DIR . '/lib/userdata.inc.php')) {
			throw new \Exception("Could not find froxlor's userdata.inc.php file. You should use this script only with a fully installed and setup froxlor system.");
		}
	}

	private function checkConfigParam($needed = false)
	{
		if ($needed) {
			if (!isset($this->_args["froxlor-dir"])) {
				$this->_args["froxlor-dir"] = \Froxlor\Froxlor::getInstallDir();
			} elseif (!is_dir($this->_args["froxlor-dir"])) {
				throw new \Exception("Given --froxlor-dir parameter is not a directory");
			} elseif (!file_exists($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor directory cannot be found ('" . $this->_args["froxlor-dir"] . "')");
			} elseif (!is_readable($this->_args["froxlor-dir"])) {
				throw new \Exception("Given froxlor directory cannot be read ('" . $this->_args["froxlor-dir"] . "')");
			}
		}
	}
}
