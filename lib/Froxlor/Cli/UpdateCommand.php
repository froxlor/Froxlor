<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\Cli;

use Exception;
use Froxlor\Froxlor;
use Froxlor\Settings;
use Froxlor\Install\Update;
use Froxlor\Install\AutoUpdate;
use Froxlor\System\Mailer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class UpdateCommand extends CliCommand
{

	protected function configure()
	{
		$this->setName('froxlor:update');
		$this->setDescription('Check for newer version and update froxlor');
		$this->addOption('check-only', 'c', InputOption::VALUE_NONE, 'Only check for newer version and exit')
			->addOption('mail-notify', 'm', InputOption::VALUE_NONE, 'Additionally inform administrator via email if a newer version was found')
			->addOption('yes-to-all', 'A', InputOption::VALUE_NONE, 'Do not ask for download, extract and database-update, just do it (if not --check-only is set)')
			->addOption('integer-return', 'i', InputOption::VALUE_NONE, 'Return integer whether a new version is available or not (implies --check-only). Useful for programmatic use.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$result = self::SUCCESS;

		$result = $this->validateRequirements($input, $output);

		require Froxlor::getInstallDir() . '/lib/functions.php';

		// version check
		$newversionavail = false;
		if ($result == self::SUCCESS) {
			try {
				$aucheck = AutoUpdate::checkVersion();

				if ($aucheck == 1) {
					$this->mailNotify($input, $output);
					if ($input->getOption('integer-return')) {
						$output->write(1);
						return self::SUCCESS;
					}
					// there is a new version
					if ($input->getOption('check-only')) {
						$text = lng('update.uc_newinfo', [(Settings::Get('system.update_channel') == 'testing' ? 'testing ' : ''), AutoUpdate::getFromResult('version'), Froxlor::VERSION]);
					} else {
						$text = lng('admin.newerversionavailable') . ' ' . lng('admin.newerversiondetails', [AutoUpdate::getFromResult('version'), Froxlor::VERSION]);
					}
					$text = str_replace("<br/>", " ", $text);
					$text = str_replace("<b>", "<info>", $text);
					$text = str_replace("</b>", "</info>", $text);
					$newversionavail = true;
					$output->writeln('<comment>' . $text . '</>');
					$result = self::SUCCESS;
				} else if ($aucheck < 0 || $aucheck > 1) {
					if ($input->getOption('integer-return')) {
						$output->write(-1);
						return self::INVALID;
					}
					// errors
					if ($aucheck < 0) {
						$output->writeln('<error>' . AutoUpdate::getLastError() . '</>');
					} else {
						$errmsg = 'error.autoupdate_' . $aucheck;
						if ($aucheck == 3) {
							$errmsg = 'error.customized_version';
						}
						$output->writeln('<error>' . lng($errmsg) . '</>');
					}
					$result = self::INVALID;
				} else {
					if ($input->getOption('integer-return')) {
						$output->write(0);
						return self::SUCCESS;
					}
					// no new version
					$output->writeln('<info>' . AutoUpdate::getFromResult('info') . '</>');
					$result = self::SUCCESS;
				}
			} catch (Exception $e) {
				if ($input->getOption('integer-return')) {
					$output->write(-1);
					return self::FAILURE;
				}
				$output->writeln('<error>' . $e->getMessage() . '</>');
				$result = self::FAILURE;
			}
		}

		// if there's a newer version, proceed
		if ($result == self::SUCCESS && $newversionavail) {

			// check whether we only wanted to check
			if ($input->getOption('check-only')) {
				//$output->writeln('<comment>Not proceeding as "check-only" is specified</>');
				return $result;
			} else {
				$yestoall = $input->getOption('yes-to-all') !== false;

				$helper = $this->getHelper('question');

				// ask download
				$question = new ConfirmationQuestion('Download newer version? [no] ', false, '/^(y|j)/i');
				if ($yestoall || $helper->ask($input, $output, $question)) {
					// do download
					$output->writeln('Downloading...');
					$audl = AutoUpdate::downloadZip(AutoUpdate::getFromResult('version'));
					if (!is_numeric($audl)) {
						// ask extract
						$question = new ConfirmationQuestion('Extract downloaded archive? [no] ', false, '/^(y|j)/i');
						if ($yestoall || $helper->ask($input, $output, $question)) {
							// do extract
							$output->writeln('Extracting...');
							$auex = AutoUpdate::extractZip(Froxlor::getInstallDir() . '/updates/' . $audl);
							if ($auex == 0) {
								$output->writeln("<info>Froxlor files updated successfully.</>");
								$result = self::SUCCESS;
								$question = new ConfirmationQuestion('Update database? [no] ', false, '/^(y|j)/i');
								if ($yestoall || $helper->ask($input, $output, $question)) {
									$result = $this->updateDatabase();
								}
							} else {
								$errmsg = 'error.autoupdate_' . $auex;
								$output->writeln('<error>' . lng($errmsg) . '</>');
								$result = self::FAILURE;
							}
						}
					} else {
						$errmsg = 'error.autoupdate_' . $audl;
						$output->writeln('<error>' . lng($errmsg) . '</>');
						$result = self::FAILURE;
					}
				}
			}
		}
		return $result;
	}

	private function mailNotify(InputInterface $input, OutputInterface $output)
	{
		if ($input->getOption('mail-notify')) {
			$last_check_version = Settings::Get('system.update_notify_last');
			if (Update::versionInUpdate($last_check_version, AutoUpdate::getFromResult('version'))) {
				$text = lng('update.uc_newinfo', [(Settings::Get('system.update_channel') == 'testing' ? 'testing ' : ''), AutoUpdate::getFromResult('version'), Froxlor::VERSION]);
				$mail = new Mailer(true);
				$mail->Body = $text;
				$mail->Subject = "[froxlor] " . lng('update.notify_subject');
				$mail->AddAddress(Settings::Get('panel.adminmail'), Settings::Get('panel.adminmail_defname'));
				if (!$mail->Send() && $input->getOption('integer-return') == null) {
					$output->writeln('<error>' . $mail->ErrorInfo . '</>');
				}
				Settings::Set('system.update_notify_last', AutoUpdate::getFromResult('version'));
			}
		}
	}

	private function updateDatabase()
	{
		include_once Froxlor::getInstallDir() . '/lib/tables.inc.php';
		define('_CRON_UPDATE', 1);
		ob_start([
			$this,
			'cleanUpdateOutput'
		]);
		include_once Froxlor::getInstallDir() . '/install/updatesql.php';
		ob_end_flush();
		return self::SUCCESS;
	}

	private function cleanUpdateOutput($buffer)
	{
		return strip_tags(preg_replace("/<br\W*?\/>/", "\n", $buffer));
	}
}
