<?php

namespace Froxlor\Cli;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Froxlor\Froxlor;
use Froxlor\FileDir;
use Froxlor\Settings;
use Froxlor\Database\Database;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2022 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Froxlor team <team@froxlor.org> (2018-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Cron
 *         
 */
final class PhpSessionclean extends Command
{

	protected function configure()
	{
		$this->setName('froxlor:php-sessionclean');
		$this->setDescription('Cleans old php-session files from tmp folder');
		$this->addArgument('max-lifetime', InputArgument::OPTIONAL, 'The number of seconds after which data will be seen as "garbage" and potentially cleaned up. Defaults to "1440"');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if (!file_exists(Froxlor::getInstallDir() . '/lib/userdata.inc.php')) {
			$output->writeln("<error>Could not find froxlor's userdata.inc.php file. You should use this script only with an installed froxlor system.</>");
			return self::INVALID;
		}

		if ((int) Settings::Get('phpfpm.enabled') == 1) {
			if ($input->hasArgument('max-lifetime') &&  is_numeric($input->getArgument('max-lifetime')) && $input->getArgument('max-lifetime') > 0) {
				$this->cleanSessionfiles((int)$input->getArgument('max-lifetime'));
			} else {
				// use default max-lifetime value
				$this->cleanSessionfiles();
			}
			return self::SUCCESS;
		}
		// php-fpm not enabled
		$output->writeln('<comment>PHP-FPM not enabled for this installation.</comment>');
		return self::INVALID;
	}

	private function cleanSessionfiles(int $maxlifetime = 1440)
	{
		// store paths to clean up
		$paths_to_clean = [];
		// get all pool-config directories configured
		$sel_stmt = Database::prepare("SELECT DISTINCT `config_dir` FROM `" . TABLE_PANEL_FPMDAEMONS . "`");
		Database::pexecute($sel_stmt);
		while ($fpmd = $sel_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$poolfiles = glob(FileDir::makeCorrectFile($fpmd['config_dir'] . '/*.conf'));
			foreach ($poolfiles as $cf) {
				$contents = file_get_contents($cf);
				$pattern = preg_quote('session.save_path', '/');
				$pattern = "/" . $pattern . ".+?\=(.*)/";
				if (preg_match_all($pattern, $contents, $matches)) {
					$paths_to_clean[] = FileDir::makeCorrectDir(trim($matches[1][0]));
				}
			}
		}

		// every path is just needed once
		$paths_to_clean = array_unique($paths_to_clean);

		if (count($paths_to_clean) > 0) {
			foreach ($paths_to_clean as $ptc) {
				// find all files older then maxlifetime and delete them
				FileDir::safe_exec("find -O3 \"" . $ptc . "\" -ignore_readdir_race -depth -mindepth 1 -name 'sess_*' -type f -cmin \"+" . $maxlifetime . "\" -delete");
			}
		}
	}
}
