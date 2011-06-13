<?php
/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010-2011 the Froxlor Team (see authors).
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
	private $protocol = 'http';
	private $username = '';
	private $password = '';
	private $hostname = '';
	private $port = 80;
	private $filename = 'index.php';

	private $args = array();

	public function __construct($hostname, $protocol = 'http', $port = 80, $file = 'index.php', $username = '', $password = '')
	{
		# Set the basic parts of our URL
		$this->protocol = $protocol;
		$this->hostname = $hostname;
		$this->port = $port;
		$this->filename = $file;
		$this->username = $username;
		$this->password = $password;
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
		$this->args = array();
	}

	public function getLink()
	{
		$link = '';

		# Build the basic URL
		$link = $this->protocol . '://';

		# Let's see if we shall use a username in the URL
		if ($this->username != '')
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
		$link .= $this->hostname . ':' . $this->port . '/' . $this->filename;

		# Overwrite $this->args with parameters of this function (if necessary)
		if(func_num_args() == 1 && is_arrray(func_get_arg(0)))
		{
			$this->args = array_merge($this->args, func_get_arg(0));
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
			# For all but the first argument, prepend "&"
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
