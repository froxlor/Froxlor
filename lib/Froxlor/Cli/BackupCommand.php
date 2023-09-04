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
use Froxlor\Backup\Storages\StorageFactory;
use Froxlor\Database\Database;
use Froxlor\Froxlor;
use Froxlor\Settings;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class BackupCommand extends CliCommand
{

	protected function configure()
	{
		$this->setName('froxlor:backup');
		$this->setDescription('Various backup actions');
		$this->addOption('list', 'L', InputOption::VALUE_OPTIONAL, 'List backups (optionally pass a customer loginname to list backups of a specific user)')
			->addOption('create', 'c', InputOption::VALUE_REQUIRED, 'Manually run a backup task for given customer (loginname)')
			->addOption('delete', 'd', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Remove given backup by id');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$result = $this->validateRequirements($input, $output);

		require Froxlor::getInstallDir() . '/lib/functions.php';

		// set error-handler
		@set_error_handler([
			'\\Froxlor\\Api\\Api',
			'phpErrHandler'
		]);

		if (!Settings::Get('backup.enabled')) {
			$output->writeln('<error>Backup feature not enabled.</>');
			$result = self::INVALID;
		}

		if ($result == self::SUCCESS) {

			try {
				$loginname = "";
				$userinfo = [];
				if ($input->hasArgument('user')) {
					$loginname = $input->getArgument('user');
					$userinfo = $this->getUserByName($loginname, false);
				}

				$do_list = $input->getOption('list');
				$do_create = $input->getOption('create');
				$do_delete = $input->getOption('delete');

				if ($do_list === false && $do_create === false && $do_delete === false) {
					$output->writeln('<error>No option given, nothing to do.</>');
					return self::INVALID;
				}

				// list
				if ($do_list !== false) {
					if ($do_list === null) {
						// all customers
					} elseif ($do_list !== false) {
						// specific customer
					}
				} elseif ($do_create !== false) {
					$stmt = Database::prepare("SELECT
						customerid,
						loginname,
						adminid,
						backup,
						guid,
						documentroot
						FROM `" . TABLE_PANEL_CUSTOMERS . "`
						WHERE `backup` > 0 AND `loginname` = :loginname
					");
					$customer = Database::pexecute_first($stmt, ['loginname' => $do_create]);

					if (empty($customer)) {
						$output->writeln('<error>Given customer not found or customer has backup=off</>');
						return self::INVALID;
					}

					$backupStorage = StorageFactory::fromStorageId($customer['backup'], $customer);
					$output->writeln("Initializing storage");
					$backupStorage->init();
					$output->writeln("Preparing files and folders");
					$backupStorage->prepareFiles();
					$output->writeln("Creating backup file");
					$backupStorage->createFromFiles();
					$output->writeln("Removing older backups by retention");
					$backupStorage->removeOld();
					$output->writeln('<info>Backup created successfully</>');
				}
			} catch (Exception $e) {
				$output->writeln('<error>' . $e->getMessage() . '</>');
				$result = self::FAILURE;
			}
		}

		return $result;
	}
}
