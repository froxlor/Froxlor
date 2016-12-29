<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 *
 * @since      0.9.29.1
 *
 */

class phpfpm_restart
{
	
	/*
	 * Froxlor's $cronlog
	 */
	private $logger = array( );
	
	/*
	 * All required run-scripts
	 */
	private $runscripts = array( );
	
	public function __construct($logger) {
		$this->logger = $logger;
	}
	
	public function captureCurrentConfigs() {
		$result_runscripts_stmt = Database::query("
			SELECT `runscript` FROM `" . TABLE_PANEL_PHPCONFIGS . "` phpconfig
			WHERE EXISTS(SELECT * FROM `" . TABLE_PANEL_DOMAINS . "` as domain WHERE domain.phpsettingid = phpconfig.id)
		");
		while ($row = $result_runscripts_stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->runscripts[$row['runscript']] = true;
		}
	}
	
	public function restart() {
		$this->logger->logAction(CRON_ACTION, LOG_NOTICE, 'restarting php-fpm');
		$this->executeRunScripts("stop");
		$this->executeRunScripts("start");
	}
	
	public function executeRunScripts($command) {
		foreach($this->runscripts as $runscript => $useless) {
			$this->logger->logAction(CRON_ACTION, LOG_NOTICE, "Running: {$runscript} {$command}");
			safe_exec("{$runscript} {$command}");
		}
	}
	
}