<?php
namespace Froxlor;

class PhpHelper
{

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
	 * Return human readable sizes
	 *
	 * @param int $size
	 *        	size in bytes
	 * @param string $max
	 *        	maximum unit
	 * @param string $system
	 *        	'si' for SI, 'bi' for binary prefixes
	 *
	 * @param string
	 */
	public static function size_readable($size, $max = null, $system = 'si', $retstring = '%01.2f %s')
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
	public static function replace_variables($text, $vars)
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
	function array_trim($source)
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
