<?php
namespace Froxlor\Idna;

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright (c) the authors
 * @author Michael Duergner <michael@duergner.com> (2003-2009)
 * @author Froxlor team <team@froxlor.org> (2010-)
 * @license GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package Classes
 *         
 */

/**
 * Class for wrapping a specific idna conversion class and offering a standard interface
 *
 * @package Functions
 */
class IdnaWrapper
{

	/**
	 * idna converter we use
	 *
	 * @var object
	 */
	private $idna_converter;

	/**
	 * Class constructor.
	 * Creates a new idna converter
	 */
	public function __construct()
	{
		// Instantiate it
		$this->idna_converter = new \Algo26\IdnaConvert\IdnaConvert();
	}

	/**
	 * Encode a domain name, a email address or a list of one of both.
	 *
	 * @param
	 *        	string May be either a single domain name, e single email address or a list of one
	 *        	separated either by ',', ';' or ' '.
	 *        	
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 *         both separated by the same string as the input.
	 */
	public function encode($to_encode)
	{
		$to_encode = $this->isUtf8($to_encode) ? $to_encode : utf8_encode($to_encode);
		try {
			return $this->idna_converter->encode($to_encode);
		} catch (\InvalidArgumentException $iae) {
			if ($iae->getCode() == 100) {
				return $to_encode;
			}
			throw $iae;
		}
	}

	/**
	 * Decode a domain name, a email address or a list of one of both.
	 *
	 * @param
	 *        	string May be either a single domain name, e single email address or a list of one
	 *        	separated either by ',', ';' or ' '.
	 *        	
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 *         both separated by the same string as the input.
	 */
	public function decode($to_decode)
	{
		return $this->idna_converter->decode($to_decode);
	}

	/**
	 * check whether a string is utf-8 encoded or not
	 *
	 * @param string $string
	 *
	 * @return boolean
	 */
	private function isUtf8($string = null)
	{
		if (function_exists("mb_detect_encoding")) {
			if (mb_detect_encoding($string, 'UTF-8, ISO-8859-1') === 'UTF-8') {
				return true;
			}
			return false;
		}
		$strlen = strlen($string);
		for ($i = 0; $i < $strlen; $i ++) {
			$ord = ord($string[$i]);
			if ($ord < 0x80) {
				continue; // 0bbbbbbb
			} elseif (($ord & 0xE0) === 0xC0 && $ord > 0xC1) {
				$n = 1; // 110bbbbb (exkl C0-C1)
			} elseif (($ord & 0xF0) === 0xE0) {
				$n = 2; // 1110bbbb
			} elseif (($ord & 0xF8) === 0xF0 && $ord < 0xF5) {
				$n = 3; // 11110bbb (exkl F5-FF)
			} else {
				// ungültiges UTF-8-Zeichen
				return false;
			}
			// $n Folgebytes? // 10bbbbbb
			for ($c = 0; $c < $n; $c ++) {
				if (++ $i === $strlen || (ord($string[$i]) & 0xC0) !== 0x80) {
					// ungültiges UTF-8-Zeichen
					return false;
				}
			}
		}
		// kein ungültiges UTF-8-Zeichen gefunden
		return true;
	}
}
