<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Duergner <michael@duergner.com> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

// Source for updates: https://github.com/phlylabs/idna-convert.git

/**
 * Class for wrapping a specific idna conversion class and offering a standard interface
 * @package Functions
 */
class idna_convert_wrapper
{
	/**
	 * idna converter we use
	 * @var object
	 */

	private $idna_converter;

	/**
	 * Class constructor. Creates a new idna converter
	 */

	public function __construct()
	{
		// Instantiate it
		if (version_compare("5.6.0", PHP_VERSION, ">=")) {
			$this->idna_converter = new idna_convert(array('idn_version' => '2008', 'encode_german_sz' => false));
		} else {
			// use this when using new version of IdnaConverter (which does not work yet)
			$this->idna_converter = new Mso\IdnaConvert\IdnaConvert();
		}
	}

	/**
	 * Encode a domain name, a email address or a list of one of both.
	 *
	 * @param string May be either a single domain name, e single email address or a list of one
	 * separated either by ',', ';' or ' '.
	 *
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 * both separated by the same string as the input.
	 */

	public function encode($to_encode)
	{
		if (version_compare("5.6.0", PHP_VERSION, ">=")) {
			return $this->_do_action('encode', $to_encode);
		} else {
			$to_encode = $this->is_utf8($to_encode) ? $to_encode : utf8_encode($to_encode);
			return $this->idna_converter->encode($to_encode);
		}
	}

	public function encode_uri($to_encode)
	{
		if (version_compare("5.6.0", PHP_VERSION, ">=")) {
			return $this->_do_action('encode', $to_encode);
		} else {
			$to_encode = $this->is_utf8($to_encode) ? $to_encode : utf8_encode($to_encode);
			return $this->idna_converter->encodeUri($to_encode);
		}
	}

	/**
	 * Decode a domain name, a email address or a list of one of both.
	 *
	 * @param string May be either a single domain name, e single email address or a list of one
	 * separated either by ',', ';' or ' '.
	 *
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 * both separated by the same string as the input.
	 */

	public function decode($to_decode)
	{
		if (version_compare("5.6.0", PHP_VERSION, ">=")) {
			return $this->_do_action('decode', $to_decode);
		} else {
			return $this->idna_converter->decode($to_decode);
		}
	}

	/**
	 * check whether a string is utf-8 encoded or not
	 *
	 * @param string $string
	 *
	 * @return boolean
	 */
	public function is_utf8($string = null) {

		if (function_exists("mb_detect_encoding")) {
			if (mb_detect_encoding($string, 'UTF-8, ISO-8859-1') === 'UTF-8') {
				return true;
			}
			return false;
		}
		$strlen = strlen($string);
		for ($i = 0; $i < $strlen; $i ++) {
			$ord = ord($string[$i]);
			if ($ord < 0x80)
				continue; // 0bbbbbbb
				elseif (($ord & 0xE0) === 0xC0 && $ord > 0xC1)
				$n = 1; // 110bbbbb (exkl C0-C1)
				elseif (($ord & 0xF0) === 0xE0)
				$n = 2; // 1110bbbb
				elseif (($ord & 0xF8) === 0xF0 && $ord < 0xF5)
				$n = 3; // 11110bbb (exkl F5-FF)
				else
					return false; // ungültiges UTF-8-Zeichen
					for ($c = 0; $c < $n; $c ++) // $n Folgebytes? // 10bbbbbb
						if (++ $i === $strlen || (ord($string[$i]) & 0xC0) !== 0x80)
							// ungültiges UTF-8-Zeichen
							return false;
		}
		// kein ungültiges UTF-8-Zeichen gefunden
		return true;
	}

	/**
	 * Do the real de- or encoding. First checks if a list is submitted and separates it. Afterwards sends
	 * each entry to the idna converter to do the converting.
	 *
	 * @param string May be either 'decode' or 'encode'.
	 * @param string The string to de- or endcode.
	 *
	 * @return string The input string after being processed.
	 */

	private function _do_action($action, $string)
	{
		$string = trim($string);

		if(strpos($string, ',') !== false)
		{
			$strings = explode(',', $string);
			$sepchar = ',';
		}
		elseif(strpos($string, ';') !== false)
		{
			$strings = explode(';', $string);
			$sepchar = ';';
		}
		elseif(strpos($string, ' ') !== false)
		{
			$strings = explode(' ', $string);
			$sepchar = ' ';
		}
		else
		{
			$strings = array(
				$string
			);
			$sepchar = '';
		}

		for ($i = 0;$i < count($strings);$i++)
		{
			if(strpos($strings[$i], '@') !== false)
			{
				$split = explode('@', $strings[$i]);
				$localpart = $split[0];
				$domain = $split[1];
				$email = true;
			}
			else
			{
				$domain = $strings[$i];
				$email = false;
			}

			if(strlen($domain) !== 0)
			{
				$domain = $this->idna_converter->$action($domain . '.none');
				$domain = substr($domain, 0, strlen($domain) - 5);
			}

			if($email)
			{
				$strings[$i] = $localpart . '@' . $domain;
			}
			else
			{
				$strings[$i] = $domain;
			}
		}

		return implode($sepchar, $strings);
	}
}
