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
use Froxlor\Install\Install;
use Froxlor\Install\Install\Core;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InstallCommand extends Command
{

	private $io = null;

	private $formfielddata = [];

	protected function configure()
	{
		$this->setName('froxlor:install');
		$this->setDescription('Installation process to use instead of web-ui');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$result = self::SUCCESS;

		if (file_exists(Froxlor::getInstallDir() . '/lib/userdata.inc.php')) {
			$output->writeln("<error>froxlor seems to be installed already.</>");
			return self::INVALID;
		}

		require __DIR__ . '/install.functions.php';

		$this->io = new SymfonyStyle($input, $output);

		$this->io->title('Froxlor installation');

		$extended = $this->io->confirm('Use advanced installation mode?', false);

		// set a few defaults CLI cannot know
		$_SERVER['SERVER_SOFTWARE'] = 'apache';
		$host = [];
		exec('hostname -f', $host);
		$_SERVER['SERVER_NAME'] = $host[0] ?? '';
		$ips = [];
		exec('hostname -I', $ips);
		$ips = explode(" ", $ips[0]);
		// ipv4 address?
		$_SERVER['SERVER_ADDR'] = filter_var($ips[0] ?? "", FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? ($ips[0] ?? '') : '';
		if (empty($_SERVER['SERVER_ADDR'])) {
			// possible ipv6 address?
			$_SERVER['SERVER_ADDR'] = filter_var($ips[0] ?? "", FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? ($ips[0] ?? '') : '';
		}

		$result = $this->showStep(0, $extended);

		return $result;
	}

	private function showStep(int $step = 0, bool $extended = false): int
	{
		$result = self::SUCCESS;
		$inst = new Install(['step' => $step, 'extended' => $extended]);
		switch ($step) {
			case 0:
				$this->io->section(lng('install.preflight'));
				$crresult = $inst->checkRequirements();
				$this->io->info($crresult['text']);
				if (!empty($crresult['criticals'])) {
					foreach ($crresult['criticals'] as $ctype => $critical) {
						if (!empty($ctype) && $ctype == 'wrong_ownership') {
							$this->io->error(lng('install.errors.' . $ctype, [$critical['user'], $critical['group']]));
						} elseif (!empty($ctype) && $ctype == 'missing_extensions') {
							$this->io->error([
								lng('install.errors.' . $ctype),
								implode("\n", $critical)
							]);
						} else {
							$this->io->error($critical);
						}
					}
					$result = self::FAILURE;
				}
				if (!empty($crresult['suggestions'])) {
					foreach ($crresult['suggestions'] as $ctype => $suggestion) {
						if ($ctype == 'missing_extensions') {
							$this->io->warning([
								lng('install.errors.suggestedextensions'),
								implode("\n", $suggestion)
							]);
						} else {
							$this->io->warning($suggestion);
						}
					}
				}
				if ($result == self::SUCCESS && $this->io->confirm('Continue?', true)) {
					return $this->showStep(++$step, $extended);
				}
				break;
			case 1:
			case 2:
			case 3:
				$section = $inst->formfield['install']['sections']['step' . $step] ?? [];
				$this->io->section($section['title']);
				$this->io->note($section['description']);
				foreach ($section['fields'] as $fieldname => $fielddata) {
					if ($extended == false && isset($fielddata['advanced']) && $fielddata['advanced'] == true) {
						continue;
					}
					$fielddata['value'] = $this->formfielddata[$fieldname] ?? ($fielddata['value'] ?? null);
					$fielddata['label'] = strip_tags(str_replace("<br>", " ", $fielddata['label']));
					if ($fielddata['type'] == 'password') {
						$this->formfielddata[$fieldname] = $this->io->askHidden($fielddata['label'], function ($value) use ($fielddata) {
							if (isset($fielddata['mandatory']) && $fielddata['mandatory'] && empty($value)) {
								throw new \RuntimeException('You must enter a value.');
							}
							return $value;
						});
					} elseif ($fielddata['type'] == 'checkbox') {
						$this->formfielddata[$fieldname] = $this->io->confirm($fielddata['label'], $fielddata['value'] ?? false);
					} elseif ($fielddata['type'] == 'select') {
						$this->formfielddata[$fieldname] = $this->io->choice($fielddata['label'], $fielddata['select_var'], $fielddata['selected'] ?? '');
					} else {
						$this->formfielddata[$fieldname] = $this->io->ask($fielddata['label'], $fielddata['value'] ?? '', function ($value) use ($fielddata) {
							if (isset($fielddata['mandatory']) && $fielddata['mandatory'] && empty($value)) {
								throw new \RuntimeException('You must enter a value.');
							}
							return $value;
						});
					}
				}

				try {
					if ($step == 1) {
//						$inst->checkDatabase($this->formfielddata);
					} elseif ($step == 2) {
//						$inst->checkAdminUser($this->formfielddata);
					} elseif ($step == 3) {
//						$inst->checkSystem($this->formfielddata);
					}
				}
				catch (Exception $e) {
					$this->io->error($e->getMessage());
					return $this->showStep($step, $extended);
				}
				return $this->showStep(++$step, $extended);
				break;
			case 4:
				// do actual install with data from $this->formfielddata
//				$core = new Core($this->formfielddata);
//				$core->doInstall();
				$section = $inst->formfield['install']['sections']['step' . $step] ?? [];
				$this->io->section($section['title']);
				$this->io->note($section['description']);
				$cmdfield = $section['fields']['system'];
				$this->io->success([
					$cmdfield['label'],
					$cmdfield['value']
				]);
				if ($this->io->confirm('Execute command now?', false)) {
					exec($cmdfield['value']);
				}
				break;
		}
		return $result;
	}
}
