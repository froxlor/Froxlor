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

namespace Froxlor;

use Exception;
use Froxlor\UI\Panel\UI;
use Net_DNS2_Exception;
use Net_DNS2_Resolver;
use Throwable;
use voku\helper\AntiXSS;

class PhpHelper
{
	private static $sort_key = 'id';
	private static $sort_type = SORT_STRING;

	/**
	 * sort an array by either natural or string sort and a given index where the value for comparison is found
	 *
	 * @param array $list
	 * @param string $key
	 *
	 * @return bool
	 */
	public static function sortListBy(array &$list, string $key = 'id'): bool
	{
		self::$sort_type = Settings::Get('panel.natsorting') == 1 ? SORT_NATURAL : SORT_STRING;
		self::$sort_key = $key;
		return usort($list, [
			'self',
			'sortListByGivenKey'
		]);
	}

	/**
	 * Wrapper around htmlentities to handle arrays, with the advantage that you
	 * can select which fields should be handled by htmlentities
	 *
	 * @param array|string $subject The subject array
	 * @param array|string $fields The fields which should be checked for, separated by spaces
	 * @param int $quote_style See php documentation about this
	 * @param string $charset See php documentation about this
	 *
	 * @return array|string The string or an array with htmlentities converted strings
	 * @author Florian Lippert <flo@syscp.org> (2003-2009)
	 */
	public static function htmlentitiesArray($subject, $fields = '', $quote_style = ENT_QUOTES, $charset = 'UTF-8')
	{
		if (is_array($subject)) {
			if (!is_array($fields)) {
				$fields = self::arrayTrim(explode(' ', $fields));
			}

			foreach ($subject as $field => $value) {
				if ((!is_array($fields) || empty($fields)) || (in_array($field, $fields))) {
					// Just call ourselve to manage multi-dimensional arrays
					$subject[$field] = self::htmlentitiesArray($value, $fields, $quote_style, $charset);
				}
			}
		} else {
			$subject = empty($subject) ? "" : htmlentities($subject, $quote_style, $charset);
		}

		return $subject;
	}

	/**
	 * Returns array with all empty-values removed
	 *
	 * @param array $source The array to trim
	 * @return array The trim'med array
	 */
	public static function arrayTrim(array $source): array
	{
		$source = array_map('trim', $source);
		return array_filter($source, function ($value) {
			return $value !== '';
		});
	}

	/**
	 * Replaces Strings in an array, with the advantage that you
	 * can select which fields should be str_replace'd
	 *
	 * @param string|array $search String or array of strings to search for
	 * @param string|array $replace String or array to replace with
	 * @param string|array $subject String or array The subject array
	 * @param string|array $fields string The fields which should be checked for, separated by spaces
	 *
	 * @return string|array The str_replace'd array
	 */
	public static function strReplaceArray($search, $replace, $subject, $fields = '')
	{
		if (is_array($subject)) {
			if (!is_array($fields)) {
				$fields = self::arrayTrim(explode(' ', $fields));
			}
			foreach ($subject as $field => $value) {
				if ((!is_array($fields) || empty($fields)) || (in_array($field, $fields))) {
					$subject[$field] = str_replace($search, $replace, $value);
				}
			}
		} else {
			$subject = str_replace($search, $replace, $subject);
		}

		return $subject;
	}

	/**
	 * froxlor php error handler
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 *
	 * @return void|boolean
	 */
	public static function phpErrHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}

		if (!isset($_SERVER['SHELL']) || (isset($_SERVER['SHELL']) && $_SERVER['SHELL'] == '')) {
			// prevent possible file-path-disclosure
			$errfile = str_replace(Froxlor::getInstallDir(), "", $errfile);
			// build alert
			$type = 'danger';
			if ($errno == E_NOTICE || $errno == E_DEPRECATED || $errno == E_STRICT) {
				$type = 'info';
			} elseif ($errno = E_WARNING) {
				$type = 'warning';
			}
			$err_display = '<div class="alert alert-' . $type . ' my-1" role="alert">';
			$err_display .= '<strong>#' . $errno . ' ' . $errstr . '</strong><br>';
			$err_display .= $errfile . ':' . $errline;
			// later depended on whether to show or now
			$err_display .= '<br><p><pre>';
			$debug = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
			foreach ($debug as $dline) {
				$err_display .= $dline['function'] . '() called at [' . str_replace(Froxlor::getInstallDir(), '',
						($dline['file'] ?? 'unknown')) . ':' . ($dline['line'] ?? 0) . ']<br>';
			}
			$err_display .= '</pre></p>';
			// end later
			$err_display .= '</div>';
			// check for more existing errors
			$errors = isset(UI::twig()->getGlobals()['global_errors']) ? UI::twig()->getGlobals()['global_errors'] : "";
			UI::twig()->addGlobal('global_errors', $errors . $err_display);
			// return true to ignore php standard error-handler
			return true;
		}

		// of on shell, use the php standard error-handler
		return false;
	}

	/**
	 * @param Throwable $exception
	 * @return void
	 */
	public static function phpExceptionHandler(Throwable $exception)
	{
		if (!isset($_SERVER['SHELL']) || $_SERVER['SHELL'] == '') {
			// show
			UI::initTwig(true);
			UI::twig()->addGlobal('install_mode', '1');
			UI::view('misc/alert_nosession.html.twig', [
				'page_title' => 'Uncaught exception',
				'heading' => 'Uncaught exception',
				'type' => 'danger',
				'alert_msg' => $exception->getCode() . ' ' . $exception->getMessage(),
				'alert_info' => $exception->getTraceAsString()
			]);
			die();
		}
	}

	/**
	 * @param ...$configdirs
	 * @return array|null
	 */
	public static function loadConfigArrayDir(...$configdirs)
	{
		if (count($configdirs) <= 0) {
			return null;
		}

		$data = [];
		$data_files = [];
		$has_data = false;

		foreach ($configdirs as $data_dirname) {
			if (is_dir($data_dirname)) {
				$data_dirhandle = opendir($data_dirname);
				while (false !== ($data_filename = readdir($data_dirhandle))) {
					if ($data_filename != '.' && $data_filename != '..' && $data_filename != '' && substr($data_filename,
							-4) == '.php') {
						$data_files[] = $data_dirname . $data_filename;
					}
				}
				$has_data = true;
			}
		}

		if ($has_data) {
			sort($data_files);
			foreach ($data_files as $data_filename) {
				$data = array_merge_recursive($data, include $data_filename);
			}
		}

		return $data;
	}

	/**
	 * ipv6 aware gethostbynamel function
	 *
	 * @param string $host
	 * @param boolean $try_a default true
	 * @param string|null $nameserver set additional resolver nameserver to use (e.g. 1.1.1.1)
	 * @return bool|array
	 */
	public static function gethostbynamel6(string $host, bool $try_a = true, string $nameserver = null)
	{
		$ips = [];

		try {
			// set the default nameservers to use, use the system default if none are provided
			$resolver = new Net_DNS2_Resolver($nameserver ? ['nameservers' => [$nameserver]] : []);

			// get all ip addresses from the A record and normalize them
			if ($try_a) {
				try {
					$answer = $resolver->query($host, 'A')->answer;
					foreach ($answer as $rr) {
						if ($rr instanceof \Net_DNS2_RR_A) {
							$ips[] = inet_ntop(inet_pton($rr->address));
						}
					}
				} catch (Net_DNS2_Exception $e) {
					// we can't do anything here, just continue
				}
			}

			// get all ip addresses from the AAAA record and normalize them
			try {
				$answer = $resolver->query($host, 'AAAA')->answer;
				foreach ($answer as $rr) {
					if ($rr instanceof \Net_DNS2_RR_AAAA) {
						$ips[] = inet_ntop(inet_pton($rr->address));
					}
				}
			} catch (Net_DNS2_Exception $e) {
				// we can't do anything here, just continue
			}
		} catch (Net_DNS2_Exception $e) {
			// fallback to php's dns_get_record if Net_DNS2 has no resolver available, but this may cause
			// problems if the system's dns is not configured correctly; for example, the acme pre-check
			// will fail because some providers put a local ip in /etc/hosts

			// get all ip addresses from the A record and normalize them
			if ($try_a) {
				$answer = @dns_get_record($host, DNS_A);
				foreach ($answer as $rr) {
					$ips[] = inet_ntop(inet_pton($rr['ip']));
				}
			}

			// get all ip addresses from the AAAA record and normalize them
			$answer = @dns_get_record($host, DNS_AAAA);
			foreach ($answer as $rr) {
				$ips[] = inet_ntop(inet_pton($rr['ipv6']));
			}
		}

		return count($ips) > 0 ? $ips : false;
	}

	/**
	 * Function randomStr
	 *
	 * generate a pseudo-random string of bytes
	 *
	 * @param int $length
	 * @return string
	 * @throws Exception
	 */
	public static function randomStr(int $length): string
	{
		if (function_exists('openssl_random_pseudo_bytes')) {
			return openssl_random_pseudo_bytes($length);
		}
		return random_bytes($length);
	}

	/**
	 * Return human-readable sizes
	 *
	 * @param int $size size in bytes
	 * @param ?string $max maximum unit
	 * @param string $system 'si' for SI, 'bi' for binary prefixes
	 * @param string $retstring string-format
	 *
	 * @return string
	 */
	public static function sizeReadable(
		$size,
		?string $max = '',
		string $system = 'si',
		string $retstring = '%01.2f %s'
	): string {
		// Pick units
		$systems = [
			'si' => [
				'prefix' => [
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB'
				],
				'size' => 1000
			],
			'bi' => [
				'prefix' => [
					'B',
					'KiB',
					'MiB',
					'GiB',
					'TiB',
					'PiB'
				],
				'size' => 1024
			]
		];
		$sys = $systems[$system] ?? $systems['si'];

		// Max unit to display
		$depth = count($sys['prefix']) - 1;
		if ($max && false !== $d = array_search($max, $sys['prefix'])) {
			$depth = $d;
		}
		// Loop
		$i = 0;
		while ($size >= $sys['size'] && $i < $depth) {
			$size /= $sys['size'];
			$i++;
		}

		return sprintf($retstring, $size, $sys['prefix'][$i]);
	}

	/**
	 * Replaces all occurrences of variables defined in the second argument
	 * in the first argument with their values.
	 *
	 * @param string $text The string that should be searched for variables
	 * @param array $vars The array containing the variables with their values
	 *
	 * @return string The submitted string with the variables replaced.
	 */
	public static function replaceVariables(string $text, array $vars): string
	{
		$pattern = "/\{([a-zA-Z0-9\-_]+)\}/";
		$matches = [];

		if (count($vars) > 0 && preg_match_all($pattern, $text, $matches)) {
			for ($i = 0; $i < count($matches[1]); $i++) {
				$current = $matches[1][$i];

				if (isset($vars[$current])) {
					$var = $vars[$current];
					$text = str_replace("{" . $current . "}", $var, $text);
				}
			}
		}

		return str_replace('\n', "\n", $text);
	}

	/**
	 * @param string $needle
	 * @param array $haystack
	 * @param array $keys
	 * @param string $currentKey
	 * @return true
	 */
	public static function recursive_array_search(
		string $needle,
		array $haystack,
		array &$keys = [],
		string $currentKey = ''
	): bool {
		foreach ($haystack as $key => $value) {
			$pathkey = empty($currentKey) ? $key : $currentKey . '.' . $key;
			if (is_array($value)) {
				self::recursive_array_search($needle, $value, $keys, $pathkey);
			} else {
				if (stripos($value, $needle) !== false) {
					$keys[] = $pathkey;
				}
			}
		}
		return true;
	}

	/**
	 * function to check a super-global passed by reference,
	 * so it gets automatically updated
	 *
	 * @param array $global
	 * @param AntiXSS $antiXss
	 */
	public static function cleanGlobal(array &$global, AntiXSS &$antiXss)
	{
		$ignored_fields = [
			'system_default_vhostconf',
			'system_default_sslvhostconf',
			'system_apache_globaldiropt',
			'specialsettings',
			'ssl_specialsettings',
			'default_vhostconf_domain',
			'ssl_default_vhostconf_domain',
			'filecontent',
			'admin_password',
			'password',
			'new_customer_password',
			'privileged_password',
			'email_password',
			'directory_password',
			'ftp_password',
			'mysql_password',
		];
		if (!empty($global)) {
			$tmp = $global;
			foreach ($tmp as $index => $value) {
				if (!in_array($index, $ignored_fields)) {
					$global[$index] = $antiXss->xss_clean($value);
				}
			}
		}
	}

	/**
	 * @param array $a
	 * @param array $b
	 * @return int
	 */
	private static function sortListByGivenKey(array $a, array $b): int
	{
		if (self::$sort_type == SORT_NATURAL) {
			return strnatcasecmp($a[self::$sort_key], $b[self::$sort_key]);
		}
		return strcasecmp($a[self::$sort_key], $b[self::$sort_key]);
	}

	/**
	 * Generate php file from array.
	 *
	 * @param array $array
	 * @param string|null $comment
	 * @param bool $asReturn
	 * @return string
	 */
	public static function parseArrayToPhpFile(array $array, string $comment = null, bool $asReturn = false): string
	{
		$str = sprintf("<?php\n// %s\n\n", $comment ?? 'autogenerated froxlor file');

		if ($asReturn) {
			return $str . sprintf("return %s;\n", rtrim(self::parseArrayToString($array), "\n,"));
		}

		foreach ($array as $var => $arr) {
			$str .= sprintf("\$%s = %s;\n", $var, rtrim(self::parseArrayToString($arr), "\n,"));
		}
		return $str;
	}

	/**
	 * Parse array to array string.
	 *
	 * @param array $array
	 * @param ?string $key
	 * @param int $depth
	 * @return string
	 */
	public static function parseArrayToString(array $array, string $key = null, int $depth = 1): string
	{
		$str = '';
		if (!is_null($key)) {
			$str .= self::tabPrefix(($depth - 1), "'{$key}' => [\n");
		} else {
			$str .= self::tabPrefix(($depth - 1), "[\n");
		}
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				if (is_bool($value)) {
					$str .= self::tabPrefix($depth, sprintf("'%s' => %s,\n", $key, $value ? 'true' : 'false'));
				} elseif (is_int($value)) {
					$str .= self::tabPrefix($depth, "'{$key}' => $value,\n");
				} else {
					if ($key == 'password') {
						// special case for passwords (nowdoc)
						$str .= self::tabPrefix($depth, "'{$key}' => <<<'EOT'\n{$value}\nEOT,\n");
					} else {
						$str .= self::tabPrefix($depth, "'{$key}' => '{$value}',\n");
					}
				}
			} else {
				$str .= self::parseArrayToString($value, $key, ($depth + 1));
			}
		}
		$str .= self::tabPrefix(($depth - 1), "],\n");
		return $str;
	}

	/**
	 * Apply tabs with given depth to string.
	 *
	 * @param int $depth
	 * @param string $str
	 * @return string
	 */
	private static function tabPrefix(int $depth, string $str = ''): string
	{
		$tab = '';
		for ($i = 1; $i <= $depth; $i++) {
			$tab .= "\t";
		}
		return $tab . $str;
	}
}
