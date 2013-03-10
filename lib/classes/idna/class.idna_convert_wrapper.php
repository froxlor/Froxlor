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
		$this->idna_converter = new idna_convert();
	}

	/**
	 * Encode a domain name, a email address or a list of one of both.
	 *
	 * @param string May be either a single domain name, e single email address or a list of one
	 * seperated either by ',', ';' or ' '.
	 *
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 * both seperated by the same string as the input.
	 */

	public function encode($to_encode)
	{
		return $this->_do_action('encode', $to_encode);
	}

	/**
	 * Decode a domain name, a email address or a list of one of both.
	 *
	 * @param string May be either a single domain name, e single email address or a list of one
	 * seperated either by ',', ';' or ' '.
	 *
	 * @return string Returns either a single domain name, a single email address or a list of one of
	 * both seperated by the same string as the input.
	 */

	public function decode($to_decode)
	{
		return $this->_do_action('decode', $to_decode);
	}

	/**
	 * Do the real de- or encoding. First checks if a list is submitted and seperates it. Afterwards sends
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

?>
