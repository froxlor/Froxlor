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
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

class Install
{
	public $currentStep;
	public $maxSteps;
	public $phpVersion;
	public $formfield;
	public string $requiredVersion = '7.4.0';
	public array $requiredExtensions = ['libxml', 'zip'];
	public array $suggestedExtensions = ['curl'];
	public array $suggestions = [];
	public array $criticals = [];
	public array $loadedExtensions;
	public array $supportedOS = [
		'focal' => 'Ubuntu 20.04 LTS (Focal Fossa)'
	];

	public function __construct()
	{
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

		// also handle completion of installation if it's the last step
		if ($this->currentStep == $this->maxSteps) {
			$this->startInstallation($validatedData);
			header('Location: ../');
			return;
		}

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
			$text = 'Your system is running with PHP ' . $this->phpVersion;
		} else {
			$text = 'Your system is running a lower version than PHP ' . $this->requiredVersion;
			$this->criticals[] = 'Update your current PHP Version from ' . $this->phpVersion . ' to ' . $this->requiredVersion . ' or higher';
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
		$dsn = sprintf('mysql:host=%s;charset=utf8mb4', $validatedData['sql_hostname']);
		$pdo = new \PDO($dsn, $validatedData['sql_root_username'], $validatedData['sql_root_password']);

		// check if the database already exist
		$stmt = $pdo->prepare('SHOW DATABASES LIKE ?');
		$stmt->execute([
			$validatedData['sql_database']
		]);
		$hasDatabase = $stmt->fetch();
		if ($hasDatabase && !$validatedData['sql_override_database']) {
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

		// FIXME: seems not to work
		// check if the user already exist
		$stmt = $pdo->prepare("SELECT `user` FROM `mysql.user` WHERE `user` = '?'");
		if ($stmt->rowCount()) {
			throw new Exception('Username already exist, please use another username!');
		}

		// check if we can create a new user
		$testUser = uniqid('froxlor_tmp_');
		$stmt = $pdo->prepare('CREATE USER ?@? IDENTIFIED BY ?');
		if ($stmt->execute([$testUser, $validatedData['sql_hostname'], uniqid()]) === false) {
			throw new Exception('cant create test user');
		}
		$stmt = $pdo->prepare('DROP USER ?@?');
		if ($stmt->execute([$testUser, $validatedData['sql_hostname']]) === false) {
			throw new Exception('cant create test user');
		}
		if ($pdo->prepare('FLUSH PRIVILEGES')->execute() === false) {
			throw new Exception('Cant flush privileges');
		}
	}

	/**
	 * @param array $validatedData
	 * @return void
	 * @throws Exception
	 */
	private function startInstallation(array $validatedData): void
	{
		// TODO: do the installation (maybe in an own class?)
	}
}
