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

use Froxlor\Froxlor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CliCommand extends Command
{

	protected function validateRequirements(InputInterface $input, OutputInterface $output): int
	{
		if (!file_exists(Froxlor::getInstallDir() . '/lib/userdata.inc.php')) {
			$output->writeln("<error>Could not find froxlor's userdata.inc.php file. You should use this script only with an installed froxlor system.</>");
			return self::INVALID;
		}
		if (Froxlor::hasUpdates() || Froxlor::hasDbUpdates()) {
			$output->writeln("<error>It seems that the froxlor files have been updated. Please login and finish the update procedure.</>");
			return self::INVALID;
		}
		return self::SUCCESS;
	}
}
