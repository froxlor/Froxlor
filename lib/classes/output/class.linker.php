<?php
/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010- the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

class linker
{
	private $protocol = '';
	private $username = '';
	private $password = '';
	private $hostname = '';
	private $port = 80;
	private $filename = 'index.php';

	private $args = array();

	public function __construct($file = 'index.php', $sessionid = '', $hostname = '', $protocol = '', $port = '', $username = '', $password = '')
	{
		# Set the basic parts of our URL
		$this->protocol = $protocol;
		$this->username = $username;
		$this->password = $password;
		$this->hostname = $hostname;
		$this->port = $port;
		$this->filename = $file;
		# @TODO: Remove this
		$this->args['s'] = $sessionid;
	}

	public function __set($key, $value)
	{
		switch(strtolower($key))
		{
			case 'protocol': $this->protocol = $value; break;
			case 'username': $this->username = $value; break;
			case 'password': $this->password = $value; break;
			case 'hostname': $this->hostname = $value; break;
			case 'port': $this->port = $value; break;
			case 'filename': $this->filename = $value; break;
			default: return false;
		}
		return true;
	}

	public function add($key, $value)
	{
		# Add a new value to our parameters (overwrite = enabled)
		$this->args[$key] = $value;
	}

	public function del($key)
	{
		# If the key exists in our array -> delete it
		if (isset($this->args[$key]))
		{
			unset($this->args[$key]);
		}
	}

	public function delAll()
	{
		# Just resetting the array
		# Until the sessionid can be removed: save it
		# @TODO: Remove this
		$this->args = array('s' => $this->args['s']);
	}

	public function getLink()
	{
		$link = '';

		# Build the basic URL
		if (strlen($this->protocol) > 0 && strlen($this->hostname) > 0)
		{
			$link = $this->protocol . '://';
		}

		# Let's see if we shall use a username in the URL
		# This is only available if a hostname is used as well
		if (strlen($this->username) > 0 && strlen($this->hostname) > 0)
		{
			$link .= urlencode($this->username);

			# Maybe we even have to append a password?
			if ($this->password != '')
			{
				$link .= ':' . urlencode($this->password);
			}

			# At least a username was given, add the @ to allow appending the hostname
			$link .= '@';
		}

		# Add hostname, port and filename to the URL
		if (strlen($this->hostname) > 0)
		{
			$link .= $this->hostname;

			# A port may only be used if hostname is used as well
			if (strlen($this->port) > 0)
			{
				$link .= ':' . $this->port;
			}
			$link .= '/';
		}

		# Overwrite $this->args with parameters of this function (if necessary)
		if(func_num_args() == 1 && is_array(func_get_arg(0)))
		{
			$arguments = func_get_arg(0);
			$this->args = array_merge($this->args, $arguments);
		}

		# temporary until frontcontroller exists
		# We got a section in the URL -> morph AREA and section into filename
		# @TODO: Remove this
		if (isset($this->args['section']) && strlen($this->args['section']) > 0)
		{
			$link .= AREA . '_' . $this->args['section'] . '.php';
			unset($this->args['section']);
		}
		else
		{
			$link .= $this->filename;
		}

		# Let's see if we are done (no arguments in query)
		if (count($this->args) == 0)
		{
			return $link;
		}

		# We have parameters, add them with a "?"
		$link .= "?";

		# Loop through arguments and add them to the link
		foreach ($this->args as $key => $value)
		{
			# For all but the first argument, prepend "&amp;"
			if (substr($link, -1) != "?")
			{
				$link .= "&";
			}

			# Encode parameters and add them to the link
			$link .= urlencode($key) . '=' . urlencode($value);
		}

		# Reset our class for further use
		$this->delAll();
		return $link;
	}
}
