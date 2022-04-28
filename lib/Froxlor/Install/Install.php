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

namespace Froxlor\Install;

use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

class Install
{
	public $step = 0;
	public $phpVersion;
	public string $requiredVersion = '7.4.0';
	public array $requiredExtensions = ['libxml', 'zip'];
	public array $suggestedExtensions = ['curl'];
	public array $suggestions = [];
	public array $criticals = [];

	public function __construct()
	{
		$this->step = Request::get('step');

		$this->phpVersion = phpversion();
		$this->loadedExtensions = get_loaded_extensions();

		$this->checkExtensions();
	}

	public function checkExtensions()
	{
		// check for required extensions
		foreach ($this->requiredExtensions as $requiredExtension) {
			if (in_array($requiredExtension, $this->loadedExtensions)) {
				continue;
			}
			$this->criticals['missing_extensions'][] = $requiredExtension;
		}

		// check for suggested extensions
		foreach ($this->suggestedExtensions as $suggestedExtension) {
			if (in_array($suggestedExtension, $this->loadedExtensions)) {
				continue;
			}
			$this->suggestions['missing_extensions'][] = $suggestedExtension;
		}
	}

	public function handle()
	{
		$formfield = require dirname(__DIR__, 3) . '/lib/formfields/install/formfield.install.php';

		// init twig
		UI::initTwig(true);
		UI::sendHeaders();

		// set global variables
		UI::twig()->addGlobal('install_mode', true);
		UI::twig()->addGlobal('basehref', '../');

		// load template
		UI::twigBuffer('/install/index.html.twig', [
			'setup' => [
				'step' => $this->step,
			],
			'preflight' => [
				'text' => $this->getPreflightText(),
				'suggestions' => $this->suggestions,
				'criticals' => $this->criticals,
			],
			'page' => [
				'title' => 'Database',
				'description' => 'Test',
			],
			'section' => $formfield['install']['sections'][sprintf('step%s', $this->step)] ?? [],
		]);

		// output view
		UI::twigOutputBuffer();
	}

	public function getPreflightText(): string
	{
		if (version_compare($this->requiredVersion, PHP_VERSION, "<")) {
			$text = 'Your system is running with PHP ' . $this->phpVersion;
		} else {
			$text = 'Your system is running a lower version than PHP ' . $this->requiredVersion;
			$this->criticals[] = 'Update your current PHP Version from ' . $this->phpVersion . ' to ' . $this->requiredVersion . ' or higher';
		}

		return $text;
	}
}
