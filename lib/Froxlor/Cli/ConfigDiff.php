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

use Froxlor\Config\ConfigParser;
use Froxlor\Froxlor;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ConfigDiff extends CliCommand
{
	protected function configure(): void
	{
		$this->setName('froxlor:config-diff')
			->setDescription('Shows differences in config templates between OS versions')
			->addArgument('from', InputArgument::OPTIONAL, 'OS version to compare against')
			->addArgument('to', InputArgument::OPTIONAL, 'OS version to compare from')
			->addOption('list', 'l', InputOption::VALUE_NONE, 'List all possible OS versions');
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		require Froxlor::getInstallDir() . '/lib/functions.php';

		$parsers = $versions = [];
		foreach (glob(Froxlor::getInstallDir() . '/lib/configfiles/*.xml') as $config) {
			$name = str_replace(".xml", "", strtolower(basename($config)));
			$parser = new ConfigParser($config);
			$versions[$name] = $parser->getCompleteDistroName();
			$parsers[$name] = $parser;
		}
		asort($versions);

		if ($input->getOption('list') === true) {
			$output->writeln('The following OS version templates are available:');
			foreach ($versions as $k => $v) {
				$output->writeln(str_pad($k, 20) . $v);
			}
			return self::SUCCESS;
		}

		if (!$input->hasArgument('from') || !array_key_exists($input->getArgument('from'), $versions)) {
			$output->writeln('<error>Missing or invalid "from" argument.</error>');
			$output->writeln('Available versions: ' . implode(', ', array_keys($versions)));
			return self::INVALID;
		}

		if (!$input->hasArgument('to') || !array_key_exists($input->getArgument('to'), $versions)) {
			$output->writeln('<error>Missing or invalid "to" argument.</error>');
			$output->writeln('Available versions: ' . implode(', ', array_keys($versions)));
			return self::INVALID;
		}

		$parser_from = $parsers[$input->getArgument('from')];
		$parser_to = $parsers[$input->getArgument('to')];
		$tmp_from = tempnam('/tmp', 'froxlor_config_diff_from');
		$tmp_to = tempnam('/tmp', 'froxlor_config_diff_to');
		$files = [];

		// Aggregate content for each config file
		foreach ([[$parser_from, 'from'], [$parser_to, 'to']] as $todo) {
			foreach ($todo[0]->getServices() as $service) {
				foreach ($service->getDaemons() as $daemon) {
					foreach ($daemon->getConfig() as $instruction) {
						if ($instruction['type'] !== 'file') {
							continue;
						}

						if (isset($instruction['subcommands'])) {
							foreach ($instruction['subcommands'] as $subinstruction) {
								if ($subinstruction['type'] !== 'file') {
									continue;
								}

								$content = $subinstruction['content'];
							}
						} else {
							$content = $instruction['content'];
						}

						if (!isset($content)) {
							throw new \Exception("Cannot find content for {$instruction['name']}");
						}

						$key = "{$service->title} : {$daemon->title} : {$instruction['name']}";
						if (!isset($files[$key])) {
							$files[$key] = ['from' => '', 'to' => ''];
						}
						$files[$key][$todo[1]] = $this->filterContent($content);
					}
				}
			}
		}
		ksort($files);

		// Run diff on each file and output, if anything changed
		foreach ($files as $file_key => $content) {
			file_put_contents($tmp_from, $content['from']);
			file_put_contents($tmp_to, $content['to']);
			exec("diff {$tmp_from} {$tmp_to}", $diff_output);

			if (count($diff_output) === 0) {
				continue;
			}

			$output->writeln('<info># ' . $file_key . '</info>');
			$output->writeln(implode("\n", $diff_output) . "\n");
			unset($diff_output);
		}

		// Remove tmp files again
		unlink($tmp_from);
		unlink($tmp_to);

		return self::SUCCESS;
	}

	private function filterContent(string $content): string
	{
		$new_content = '';

		foreach (explode("\n", $content) as $n) {
			$n = trim($n);
			if (!$n) {
				continue;
			}

			if (str_starts_with($n, '#')) {
				continue;
			}

			$new_content .= $n . "\n";
		}

		return $new_content;
	}
}
