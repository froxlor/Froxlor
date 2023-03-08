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
use PDO;
use Froxlor\Install\Install\Core;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;
use Froxlor\Config\ConfigParser;
use Froxlor\Validate\Validate;
use Froxlor\System\IPTools;

class Install
{
	public $currentStep;
	public $extendedView;
	public $maxSteps;
	public $phpVersion;
	public $formfield;
	public string $requiredVersion = '7.4.0';
	public array $requiredExtensions = ['session', 'ctype', 'xml', 'filter', 'posix', 'mbstring', 'curl', 'gmp', 'json', 'gd'];
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

	public function __construct(array $cliData = [])
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

		// guess distribution and webserver to preselect in formfield
		$webserverBackend = $this->webserverBackend;
		$supportedOS = $this->supportedOS;
		$guessedDistribution = $this->guessDistribution();
		$guessedWebserver = $this->guessWebserver();

		// set formfield, so we can get the fields and steps etc.
		$this->formfield = require dirname(__DIR__, 3) . '/lib/formfields/install/formfield.install.php';

		// set actual step
		$this->currentStep = $cliData['step'] ?? Request::any('step', 0);
		$this->extendedView = $cliData['extended'] ?? Request::any('extended', 0);
		$this->maxSteps = count($this->formfield['install']['sections']);

		// set actual php version and extensions
		$this->phpVersion = phpversion();
		$this->loadedExtensions = get_loaded_extensions();

		if (empty($cliData)) {
			// set global variables
			UI::twig()->addGlobal('install_mode', true);
			UI::twig()->addGlobal('basehref', '../');

			// unset session if user goes back to step 0
			if (isset($_SESSION['installation']) && $this->currentStep == 0) {
				unset($_SESSION['installation']);
			}

			// check for url manipulation or wrong step
			if ((isset($_SESSION['installation']['stepCompleted']) && ($this->currentStep + 1) > ($_SESSION['installation']['stepCompleted'] ?? 0))
				|| (!isset($_SESSION['installation']['stepCompleted']) && $this->currentStep > 0)
			) {
				$this->currentStep = isset($_SESSION['installation']['stepCompleted']) ? $_SESSION['installation']['stepCompleted'] + 1 : 1;
			}
		}
	}

	/**
	 * @return void
	 * @throws Exception
	 */
	public function handle(): void
	{
		// handle form data
		if (!is_null(Request::any('submit')) && $this->currentStep) {
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
				'max_steps' => $this->maxSteps,
			],
			'preflight' => $this->checkRequirements(),
			'page' => [
				'title' => 'Database',
				'description' => 'Test',
			],
			'section' => $this->formfield['install']['sections']['step' . $this->currentStep] ?? [],
			'error' => $error ?? null,
			'extended' => $this->extendedView,
		]);

		// output view
		UI::twigOutputBuffer();
	}

	/**
	 * @throws Exception
	 */
	private function handleFormData(array $formfield): void
	{
		// handle current step
		if ($this->currentStep <= $this->maxSteps) {
			// Validate user data
			$validatedData = $this->validateRequest($formfield['sections']['step' . $this->currentStep]['fields']);
			// Check database connection (
			if ($this->currentStep == 1) {
				$this->checkDatabase($validatedData);
			}
			// Check validity of admin user data
			elseif ($this->currentStep == 2) {
				$this->checkAdminUser($validatedData);
			}
			// Check validity of system data
			elseif ($this->currentStep == 3) {
				$this->checkSystem($validatedData);
			}
			$validatedData['stepCompleted'] = ($this->currentStep < $this->maxSteps) ? $this->currentStep : ($this->maxSteps - 1);
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
			// check setting for "panel.is_configured" whether user has
			// run the config-services script (or checked the manual mode)
			if ($this->checkInstallStateFinished()) {
				header('Location: ../');
				return;
			}
			throw new Exception(lng('install.errors.notyetconfigured'));
		}

		// redirect to next step
		header('Location: ?step=' . ($this->currentStep + 1));
	}

	private function checkInstallStateFinished(): bool
	{
		$core = new Core($_SESSION['installation']);
		if (isset($_SESSION['installation']['manual_config']) && (int) $_SESSION['installation']['manual_config'] == 1) {
			$core->createUserdataConf();
			return true;
		}
		$pdo = $core->getUnprivilegedPdo();
		$stmt = $pdo->prepare("SELECT `value` FROM `panel_settings` WHERE `settinggroup` = 'panel' AND `varname` = 'is_configured'");
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($result && (int) $result['value'] == 1) {
			$core->createUserdataConf();
			return true;
		}
		return false;
	}

	/**
	 * @return array
	 */
	public function checkRequirements(): array
	{
		// check whether we can read the userdata file
		if (!@touch(dirname(__DIR__, 2) . '/.~writecheck')) {
			// get possible owner
			$posixusername = posix_getpwuid(posix_getuid())['name'];
			$posixgroup = posix_getgrgid(posix_getgid())['name'];
			$this->criticals['wrong_ownership'] = ['user' => $posixusername, 'group' => $posixgroup];
		} else {
			@unlink(dirname(__DIR__, 2) . '/.~writecheck');
		}

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
			$attributes[$name] = $this->validateAttribute(Request::any($name), $field);
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
			throw new Exception(lng('install.errors.mandatory_field_not_set', [$field['label']]));
		}
		return $attribute;
	}

	/**
	 * @throws Exception
	 */
	public function checkSystem(array $validatedData): void
	{
		$serveripv4 = $validatedData['serveripv4'] ?? '';
		$serveripv6 = $validatedData['serveripv6'] ?? '';
		$servername = $validatedData['servername'] ?? '';
		$httpuser = $validatedData['httpuser'] ?? 'www-data';
		$httpgroup = $validatedData['httpgroup'] ?? 'www-data';

		if (empty($serveripv4) && empty($serveripv6)) {
			throw new Exception(lng('install.errors.nov4andnov6ip'));
		} elseif (!empty($serveripv4) && (!Validate::validate_ip2($serveripv4, true, '', false, true) || IPTools::is_ipv6($serveripv4))) {
			throw new Exception(lng('error.invalidip', [$serveripv4]));
		} elseif (!empty($serveripv6) && (!Validate::validate_ip2($serveripv6, true, '', false, true) || IPTools::is_ipv6($serveripv6) == false)) {
			throw new Exception(lng('error.invalidip', [$serveripv6]));
		} elseif (!Validate::validateDomain($servername) && !Validate::validateLocalHostname($servername)) {
			throw new Exception(lng('install.errors.servernameneedstobevalid'));
		} elseif (posix_getpwnam($httpuser) === false) {
			throw new Exception(lng('install.errors.websrvuserdoesnotexist'));
		} elseif (posix_getgrnam($httpgroup) === false) {
			throw new Exception(lng('install.errors.websrvgrpdoesnotexist'));
		}
	}

	/**
	 * @throws Exception
	 */
	public function checkAdminUser(array $validatedData): void
	{
		$name = $validatedData['admin_name'] ?? 'Administrator';
		$loginname = $validatedData['admin_user'] ?? '';
		$email = $validatedData['admin_email'] ?? '';
		$password = $validatedData['admin_pass'] ?? '';
		$password_confirm = $validatedData['admin_pass_confirm'] ?? '';

		if (!preg_match('/^[^\r\n\t\f\0]*$/D', $name)) {
			throw new Exception(lng('error.stringformaterror', ['admin_name']));
		} elseif (empty(trim($loginname)) || !preg_match('/^[a-z][a-z0-9]+$/', $loginname)) {
			throw new Exception(lng('error.loginnameiswrong', [$loginname]));
		} elseif (empty(trim($email)) || !Validate::validateEmail($email)) {
			throw new Exception(lng('error.emailiswrong', [$email]));
		} elseif (empty($password) || $password != $password_confirm) {
			throw new Exception(lng('error.newpasswordconfirmerror'));
		} elseif ($password == $loginname) {
			throw new Exception(lng('error.passwordshouldnotbeusername'));
		}
	}

	/**
	 * @throws Exception
	 */
	public function checkDatabase(array $validatedData): void
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
			throw new Exception(lng('install.errors.databaseexists'));
		}

		// check if we can create a new database
		$testDatabase = uniqid('froxlor_tmp_');
		if ($pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $testDatabase . ';') === false) {
			throw new Exception(lng('install.errors.unabletocreatedb'));
		}
		if ($pdo->exec('DROP DATABASE IF EXISTS ' . $testDatabase . ';') === false) {
			throw new Exception(lng('install.errors.unabletodropdb'));
		}

		// check if the user already exist
		$stmt = $pdo->prepare("SELECT `User` FROM `mysql`.`user` WHERE `User` = ?");
		$stmt->execute([$validatedData['mysql_unprivileged_user']]);
		if ($stmt->rowCount() && !$validatedData['mysql_force_create']) {
			throw new Exception(lng('install.errors.mysqlusernameexists'));
		}

		// check if we can create a new user
		$testUser = uniqid('froxlor_tmp_');
		$stmt = $pdo->prepare('CREATE USER ?@? IDENTIFIED BY ?');
		if ($stmt->execute([$testUser, $validatedData['mysql_host'], uniqid()]) === false) {
			throw new Exception(lng('install.errors.unabletocreateuser'));
		}
		$stmt = $pdo->prepare('DROP USER ?@?');
		if ($stmt->execute([$testUser, $validatedData['mysql_host']]) === false) {
			throw new Exception(lng('install.errors.unabletodropuser'));
		}
		if ($pdo->prepare('FLUSH PRIVILEGES')->execute() === false) {
			throw new Exception(lng('install.errors.unabletoflushprivs'));
		}
	}

	private function guessWebserver(): ?string
	{
		if (strtoupper(@php_sapi_name()) == "APACHE2HANDLER" || stristr($_SERVER['SERVER_SOFTWARE'], "apache")) {
			return 'apache24';
		} elseif (substr(strtoupper(@php_sapi_name()), 0, 8) == "LIGHTTPD" || stristr($_SERVER['SERVER_SOFTWARE'], "lighttpd")) {
			return 'lighttpd';
		} elseif (substr(strtoupper(@php_sapi_name()), 0, 8) == "NGINX" || stristr($_SERVER['SERVER_SOFTWARE'], "nginx")) {
			return 'nginx';
		}
		return null;
	}

	private function guessDistribution(): ?string
	{
		// set default os.
		$default = 'bullseye';

		// read os-release
		if (@file_exists('/etc/os-release') && is_readable('/etc/os-release')) {
			if (function_exists('parse_ini_file')) {
				$os_dist = parse_ini_file('/etc/os-release', false);
			} else {
				$osrf = explode("\n", file_get_contents('/etc/os-release'));
				foreach ($osrf as $line) {
					$osrfline = explode("\n", $line);
					if ($osrfline[0] == 'VERSION_CODENAME') {
						$os_dist['VERSION_CODENAME'] = $osrfline[1];
					} else if ($osrfline[0] == 'ID') {
						$os_dist['ID'] = $osrfline[1];
					}
				}
			}
			return strtolower($os_dist['VERSION_CODENAME'] ?? ($os_dist['ID'] ?? $default));
		}
		return $default;
	}
}
