<?php
namespace Froxlor;

class PhpHelper
{

	/**
	 * Wrapper around htmlentities to handle arrays, with the advantage that you
	 * can select which fields should be handled by htmlentities
	 *
	 * @param array $subject
	 *        	The subject array
	 * @param string $fields
	 *        	The fields which should be checked for, separated by spaces
	 * @param int $quote_style
	 *        	See php documentation about this
	 * @param string $charset
	 *        	See php documentation about this
	 *        	
	 * @return array The array with htmlentitie'd strings
	 * @author Florian Lippert <flo@syscp.org>
	 */
	public static function htmlentitiesArray($subject, $fields = '', $quote_style = ENT_QUOTES, $charset = 'UTF-8')
	{
		if (is_array($subject)) {
			if (! is_array($fields)) {
				$fields = self::arrayTrim(explode(' ', $fields));
			}

			foreach ($subject as $field => $value) {
				if ((! is_array($fields) || empty($fields)) || (is_array($fields) && ! empty($fields) && in_array($field, $fields))) {
					// Just call ourselve to manage multi-dimensional arrays
					$subject[$field] = self::htmlentitiesArray($subject[$field], $fields, $quote_style, $charset);
				}
			}
		} else {
			$subject = htmlentities($subject, $quote_style, $charset);
		}

		return $subject;
	}

	/**
	 * Replaces Strings in an array, with the advantage that you
	 * can select which fields should be str_replace'd
	 *
	 * @param
	 *        	mixed String or array of strings to search for
	 * @param
	 *        	mixed String or array to replace with
	 * @param
	 *        	array The subject array
	 * @param
	 *        	string The fields which should be checked for, separated by spaces
	 * @return array The str_replace'd array
	 * @author Florian Lippert <flo@syscp.org>
	 */
	public static function strReplaceArray($search, $replace, $subject, $fields = '')
	{
		if (is_array($subject)) {
			$fields = self::arrayTrim(explode(' ', $fields));
			foreach ($subject as $field => $value) {
				if ((! is_array($fields) || empty($fields)) || (is_array($fields) && ! empty($fields) && in_array($field, $fields))) {
					$subject[$field] = str_replace($search, $replace, $subject[$field]);
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
	 * @param array $errcontext
	 *
	 * @return void|boolean
	 */
	public static function phpErrHandler($errno, $errstr, $errfile, $errline, $errcontext)
	{
		if (! (error_reporting() & $errno)) {
			// This error code is not included in error_reporting
			return;
		}

		if (! isset($_SERVER['SHELL']) || (isset($_SERVER['SHELL']) && $_SERVER['SHELL'] == '')) {
			global $theme;

			// fallback
			if (empty($theme)) {
				$theme = "Sparkle";
			}
			// prevent possible file-path-disclosure
			$errfile = str_replace(\Froxlor\Froxlor::getInstallDir(), "", $errfile);
			// if we're not on the shell, output a nicer error-message
			$err_hint = file_get_contents(\Froxlor\Froxlor::getInstallDir() . '/templates/' . $theme . '/misc/phperrornice.tpl');
			// replace values
			$err_hint = str_replace("<TEXT>", '#' . $errno . ' ' . $errstr, $err_hint);
			$err_hint = str_replace("<DEBUG>", $errfile . ':' . $errline, $err_hint);

			// show
			echo $err_hint;
			// return true to ignore php standard error-handler
			return true;
		}

		// of on shell, use the php standard error-handler
		return false;
	}

	public static function loadConfigArrayDir()
	{
		// Workaround until we use gettext
		global $lng, $theme;

		// we now use dynamic function parameters
		// so we can read from more than one directory
		// and still be valid for old calls
		$numargs = func_num_args();
		if ($numargs <= 0) {
			return null;
		}

		// variable that holds all dirs that will
		// be parsed for inclusion
		$configdirs = array();
		// if one of the parameters is an array
		// we assume that this is a list of
		// setting-groups to be selected
		$selection = null;
		for ($x = 0; $x < $numargs; $x ++) {
			$arg = func_get_arg($x);
			if (is_array($arg) && isset($arg[0])) {
				$selection = $arg;
			} else {
				$configdirs[] = $arg;
			}
		}

		$data = array();
		$data_files = array();
		$has_data = false;

		foreach ($configdirs as $data_dirname) {
			if (is_dir($data_dirname)) {
				$data_dirhandle = opendir($data_dirname);
				while (false !== ($data_filename = readdir($data_dirhandle))) {
					if ($data_filename != '.' && $data_filename != '..' && $data_filename != '' && substr($data_filename, - 4) == '.php') {
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

		// if we have specific setting-groups
		// to select, we'll handle this here
		// (this is for multiserver-client settings)
		$_data = array();
		if ($selection != null && is_array($selection) && isset($selection[0])) {
			$_data['groups'] = array();
			foreach ($data['groups'] as $group => $data) {
				if (in_array($group, $selection)) {
					$_data['groups'][$group] = $data;
				}
			}
			$data = $_data;
		}

		return $data;
	}

	/**
	 * ipv6 aware gethostbynamel function
	 *
	 * @param string $host
	 * @param boolean $try_a
	 *        	default true
	 * @return boolean|array
	 */
	public static function gethostbynamel6($host, $try_a = true)
	{
		$dns6 = dns_get_record($host, DNS_AAAA);
		if ($try_a == true) {
			$dns4 = dns_get_record($host, DNS_A);
			$dns = array_merge($dns4, $dns6);
		} else {
			$dns = $dns6;
		}
		$ips = array();
		foreach ($dns as $record) {
			if ($record["type"] == "A") {
				$ips[] = $record["ip"];
			}
			if ($record["type"] == "AAAA") {
				$ips[] = $record["ipv6"];
			}
		}
		if (count($ips) < 1) {
			return false;
		} else {
			return $ips;
		}
	}

	/**
	 * Function randomStr
	 *
	 * generate a pseudo-random string of bytes
	 *
	 * @param int $length
	 *
	 * @return string
	 */
	public static function randomStr($length)
	{
		if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
			return random_bytes($length);
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
			return openssl_random_pseudo_bytes($length);
		} else {
			$pr_bits = '';
			$fp = @fopen('/dev/urandom', 'rb');
			if ($fp !== false) {
				$pr_bits .= @fread($fp, $length);
				@fclose($fp);
			} else {
				$pr_bits = substr(rand(time(), getrandmax()) . rand(time(), getrandmax()), 0, $length);
			}
			return $pr_bits;
		}
	}

	/**
	 * Return human readable sizes
	 *
	 * @param int $size
	 *        	size in bytes
	 * @param string $max
	 *        	maximum unit
	 * @param string $system
	 *        	'si' for SI, 'bi' for binary prefixes
	 *        	
	 * @param
	 *        	string
	 */
	public static function sizeReadable($size, $max = null, $system = 'si', $retstring = '%01.2f %s')
	{
		// Pick units
		$systems = array(
			'si' => array(
				'prefix' => array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB'
				),
				'size' => 1000
			),
			'bi' => array(
				'prefix' => array(
					'B',
					'KiB',
					'MiB',
					'GiB',
					'TiB',
					'PiB'
				),
				'size' => 1024
			)
		);
		$sys = isset($systems[$system]) ? $systems[$system] : $systems['si'];

		// Max unit to display
		$depth = count($sys['prefix']) - 1;
		if ($max && false !== $d = array_search($max, $sys['prefix'])) {
			$depth = $d;
		}
		// Loop
		$i = 0;
		while ($size >= $sys['size'] && $i < $depth) {
			$size /= $sys['size'];
			$i ++;
		}

		return sprintf($retstring, $size, $sys['prefix'][$i]);
	}

	/**
	 * Replaces all occurrences of variables defined in the second argument
	 * in the first argument with their values.
	 *
	 * @param string $text
	 *        	The string that should be searched for variables
	 * @param array $vars
	 *        	The array containing the variables with their values
	 *        	
	 * @return string The submitted string with the variables replaced.
	 */
	public static function replaceVariables($text, $vars)
	{
		$pattern = "/\{([a-zA-Z0-9\-_]+)\}/";
		$matches = array();

		if (count($vars) > 0 && preg_match_all($pattern, $text, $matches)) {
			for ($i = 0; $i < count($matches[1]); $i ++) {
				$current = $matches[1][$i];

				if (isset($vars[$current])) {
					$var = $vars[$current];
					$text = str_replace("{" . $current . "}", $var, $text);
				}
			}
		}

		$text = str_replace('\n', "\n", $text);
		return $text;
	}

	/**
	 * Returns array with all empty-values removed
	 *
	 * @param array $source
	 *        	The array to trim
	 * @return array The trim'med array
	 */
	public static function arrayTrim($source)
	{
		$returnval = array();
		if (is_array($source)) {
			$source = array_map('trim', $source);
			$source = array_filter($source, function ($value) {
				return $value !== '';
			});
		} else {
			$returnval = $source;
		}
		return $returnval;
	}
}
