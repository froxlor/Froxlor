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

use Exception;
use Froxlor\Install\Install\Core;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\Config\ConfigParser;

class Install
{
	public $currentStep;
	public $maxSteps;
	public $phpVersion;
	public $formfield;
	public string $requiredVersion = '7.4.0';
	public array $requiredExtensions = ['session', 'ctype', 'xml', 'filter', 'posix', 'mbstring', 'curl', 'gmp', 'json'];
	public array $suggestedExtensions = ['bcmath', 'zip'];
	public array $suggestions = [];
	public array $criticals = [];
	public array $loadedExtensions;
	public array $supportedOS = [];
	public array $webserverBackend = [
		'php-fpm' => 'PHP-FPM',
		'fcgid' => 'FCGID',
		'mod_php' => 'mod_php (not recommended)',
	];

	public function __construct()
	{
		// get all supported OS
		// show list of available distro's
		$distros = glob(dirname(__DIR__, 3) . '/lib/configfiles/*.xml');
		$distributions_select[''] = '-';
		// read in all the distros
		foreach ($distros as $distribution) {
			// get configparser object
			$dist = new ConfigParser($distribution);
			// store in tmp array
			$this->supportedOS[str_replace(".xml", "", strtolower(basename($distribution)))] = $dist->getCompleteDistroName();
		}
		// sort by distribution name
		asort($this->supportedOS);

		// set formfield, so we can get the fields and steps etc.
		$this->formfield = require dirname(__DIR__, 3) . '/lib/formfields/install/formfield.install.php';

		// set actual step
		$this->currentStep = Request::get('step', 0);
		$this->maxSteps = count($this->formfield['install']['sections']);

		// set actual php version and extensions
		$this->phpVersion = phpversion();
		$this->loadedExtensions = get_loaded_extensions();

		// init twig
		UI::initTwig(true);
		UI::sendHeaders();

		// set global variables
		UI::twig()->addGlobal('install_mode', true);
		UI::twig()->addGlobal('basehref', '../');

		// unset session if user goes back to step 0
		if (isset($_SESSION['installation']) && $this->currentStep == 0) {
			unset($_SESSION['installation']);
		}
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function handle(): void
	{
		// handle form data
		if (!is_null(Request::get('submit')) && $this->currentStep) {
			try {
				$this->handleFormData($this->formfield['install']);
			} catch (Exception $e) {
				$error = $e->getMessage();
			}
		}

		// load template
		UI::twigBuffer('/install/index.html.twig', [
			'setup' => [
				'step' => $this->currentStep,
			],
			'preflight' => $this->checkExtensions(),
			'page' => [
				'title' => 'Database',
				'description' => 'Test',
			],
			'section' => $this->formfield['install']['sections']['step' . $this->currentStep] ?? [],
			'error' => $error ?? null,
		]);

		// output view
		UI::twigOutputBuffer();
	}

	/**
	 * @throws Exception
	 */
	private function handleFormData(array $formfield): void
	{
		// Validate user data
		$validatedData = $this->validateRequest($formfield['sections']['step' . $this->currentStep]['fields']);

		// handle current step
		if ($this->currentStep <= $this->maxSteps) {
			// Check database connection (
			if ($this->currentStep == 1) {
				$this->checkDatabase($validatedData);
			}
			// Store validated data for later use
			$_SESSION['installation'] = array_merge($_SESSION['installation'] ?? [], $validatedData);
		}

		// also handle completion of installation if it's the step before the last step
		if ($this->currentStep == ($this->maxSteps - 1)) {
			$core = new Core($_SESSION['installation']);
			$core->doInstall();
		}

		// redirect user to home if the installation is done
		if ($this->currentStep == $this->maxSteps) {
			header('Location: ../');
			return;
		}

		// redirect to next step
		header('Location: ?step=' . ($this->currentStep + 1));
	}

	/**
	 * @return array
	 */
	private function checkExtensions(): array
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

		return [
			'text' => $this->getInformationText(),
			'suggestions' => $this->suggestions,
			'criticals' => $this->criticals,
		];
	}

	/**
	 * @return string
	 */
	private function getInformationText(): string
	{
		if (version_compare($this->requiredVersion, PHP_VERSION, "<")) {
			$text = lng('install.phpinfosuccess', [$this->phpVersion]);
		} else {
			$text = lng('install.phpinfowarn', [$this->requiredVersion]);
			$this->criticals[] = lng('install.phpinfoupdate', [$this->phpVersion, $this->requiredVersion]);
		}
		return $text;
	}

	/**
	 * @throws Exception
	 */
	private function validateRequest(array $fields): array
	{
		$attributes = [];
		foreach ($fields as $name => $field) {
			$attributes[$name] = $this->validateAttribute(Request::get($name), $field);
			if (isset($field['next_to'])) {
				$attributes = array_merge($attributes, $this->validateRequest($field['next_to']));
			}
		}
		return $attributes;
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	private function validateAttribute($attribute, array $field)
	{
		// TODO: do validations
		if (isset($field['mandatory']) && $field['mandatory'] && empty($attribute)) {
			throw new Exception('Mandatory field is not set!');
		}
		return $attribute;
	}

	/**
	 * @throws Exception
	 */
	private function checkDatabase(array $validatedData): void
	{
		$dsn = sprintf('mysql:host=%s;charset=utf8', $validatedData['mysql_host']);
		$pdo = new \PDO($dsn, $validatedData['mysql_root_user'], $validatedData['mysql_root_pass']);

		// check if the database already exist
		$stmt = $pdo->prepare('SHOW DATABASES LIKE ?');
		$stmt->execute([
			$validatedData['mysql_database']
		]);
		$hasDatabase = $stmt->fetch();
		if ($hasDatabase && !$validatedData['mysql_force_create']) {
			throw new Exception('Database already exist, please set override option to rebuild!');
		}

		// check if we can create a new database
		$testDatabase = uniqid('froxlor_tmp_');
		if ($pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $testDatabase . ';') === false) {
			throw new Exception('cant create test db');
		}
		if ($pdo->exec('DROP DATABASE IF EXISTS ' . $testDatabase . ';') === false) {
			throw new Exception('Cant drop test db');
		}

		// check if the user already exist
		$stmt = $pdo->prepare("SELECT `User` FROM `mysql`.`user` WHERE `User` = ?");
		$stmt->execute([$validatedData['mysql_unprivileged_user']]);
		if ($stmt->rowCount() && !$validatedData['mysql_force_create']) {
			throw new Exception('Username already exist, please use another username or delete it first!');
		}

		// check if we can create a new user
		$testUser = uniqid('froxlor_tmp_');
		$stmt = $pdo->prepare('CREATE USER ?@? IDENTIFIED BY ?');
		if ($stmt->execute([$testUser, $validatedData['mysql_host'], uniqid()]) === false) {
			throw new Exception('cant create test user');
		}
		$stmt = $pdo->prepare('DROP USER ?@?');
		if ($stmt->execute([$testUser, $validatedData['mysql_host']]) === false) {
			throw new Exception('cant create test user');
		}
		if ($pdo->prepare('FLUSH PRIVILEGES')->execute() === false) {
			throw new Exception('Cant flush privileges');
		}
	}
}
