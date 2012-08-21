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
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 */

/**
 * Class to manage the connection to the Database
 * @package Functions
 */

class db
{
	/**
	 * Link ID for every connection
	 * @var int
	 */

	public $link_id = 0;

	/**
	 * Query ID for every query
	 * @var int
	 */

	private $query_id = 0;

	/**
	 * Errordescription, if an error occures
	 * @var string
	 */

	public $errdesc = '';

	/**
	 * Errornumber, if an error occures
	 * @var int
	 */

	public $errno = 0;

	/**
	 * Servername
	 * @var string
	 */

	private $server = '';

	/**
	 * Username
	 * @var string
	 */

	private $user = '';

	/**
	 * Password
	 * @var string
	 */

	private $password = '';

	/**
	 * Database
	 * @var string
	 */

	private $database = '';

	/**
	 * Class constructor. Connects to Databaseserver and selects Database
	 *
	 * @param string Servername
	 * @param string Username
	 * @param string Password
	 * @param string Database
	 */

	function db($server, $user, $password, $database = '')
	{
		// check for mysql extension

		if(!extension_loaded('mysql'))
		{
			$this->showerror('You should install the PHP MySQL extension!', false);
		}

		$this->server = $server;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		$this->link_id = @mysql_connect($this->server, $this->user, $this->password, 1);

		if(!$this->link_id)
		{
			//try to connect with no password and change it afterwards. only for root user

			if($this->user == 'root')
			{
				$this->link_id = @mysql_connect($this->server, $this->user, '', 1);

				if($this->link_id)
				{
					$this->query("SET PASSWORD = PASSWORD('" . $this->escape($this->password) . "')");
				}
				else
				{
					$this->showerror('Establishing connection failed, exiting');
				}
			}
			else
			{
				$this->showerror('Establishing connection failed, exiting');
			}
		}

		if($this->database != '')
		{
			if(!@mysql_select_db($this->database, $this->link_id))
			{
				$this->showerror('Trying to use database ' . $this->database . ' failed, exiting');
			}
		}

		mysql_set_charset('utf8', $this->link_id);
	}

	/**
	 * Closes connection to Databaseserver
	 */

	function close()
	{
		return @mysql_close($this->link_id);
	}

	function getDbName()
	{
		return $this->database;
	}

	/**
	 * Escapes user input to be used in mysql queries
	 *
	 * @param string $input
	 * @return string escaped string
	 */

	function escape($input)
	{
		if(is_int($input))
		{
			return (int)$input;
		}
		elseif(is_float($input))
		{
			return (float)$input;
		}
		else
		{
			return mysql_real_escape_string($input, $this->link_id);
		}
	}

	/**
	 * Query the Database
	 *
	 * @param string Querystring
	 * @param bool Unbuffered query?
	 * @return string RessourceId
	 */

	function query($query_str, $unbuffered = false, $suppress_error = false)
	{

		global $numbqueries, $theme;

		if (!mysql_ping($this->link_id))
		{
			$this->link_id = mysql_connect($this->server,$this->user,$this->password);
			if(!$this->database)
			{
				return false;
			}
			mysql_select_db($this->database);
		}

		if(!$unbuffered)
		{
			if($suppress_error)
			{
				$this->query_id = @mysql_query($query_str, $this->link_id);
			} else {
				$this->query_id = mysql_query($query_str, $this->link_id);
			}
		}
		else
		{
			if($suppress_error)
			{
				$this->query_id = @mysql_unbuffered_query($query_str, $this->link_id);
			} else {
				$this->query_id = mysql_unbuffered_query($query_str, $this->link_id);
			}
		}

		if(!$this->query_id && !$suppress_error)
		{
			$this->showerror('Invalid SQL: ' . $query_str);
		}
		elseif(!$this->query_id && $suppress_error)
		{
			return false;
		}

		$numbqueries++;

		//echo $query_str.' '.$numbqueries.'<br />';

		return $this->query_id;
	}

	/**
	 * Fetches Row from Query and returns it as array
	 *
	 * @param string RessourceId
	 * @param string Datatype, num or assoc
	 * @return array The row
	 */

	function fetch_array($query_id = - 1, $datatype = 'assoc')
	{
		if($query_id != - 1)
		{
			$this->query_id = $query_id;
		}

		if($datatype == 'num')
		{
			$datatype = MYSQL_NUM;
		}
		else
		{
			$datatype = MYSQL_ASSOC;
		}

		$this->record = mysql_fetch_array($this->query_id, $datatype);
		return $this->record;
	}

	/**
	 * Query Database and fetche the first row from Query and returns it as array
	 *
	 * @param string Querystring
	 * @param string Datatype, num or assoc
	 * @return array The first row
	 */

	function query_first($query_string, $datatype = 'assoc')
	{
		$this->query($query_string);
		return $this->fetch_array($this->query_id, $datatype);
	}

	/**
	 * Returns how many rows have been selected
	 *
	 * @param string RessourceId
	 * @return int Number of rows
	 */

	function num_rows($query_id = - 1)
	{
		if($query_id != - 1)
		{
			$this->query_id = $query_id;
		}

		return mysql_num_rows($this->query_id);
	}

	/**
	 * Returns the auto_incremental-Value of the inserted row
	 *
	 * @return int auto_incremental-Value
	 */

	function insert_id()
	{
		return mysql_insert_id($this->link_id);
	}

	/**
	 * Returns the number of rows affected by last query
	 *
	 * @return int affected rows
	 */

	function affected_rows()
	{
		return mysql_affected_rows($this->link_id);
	}

	/**
	 * Returns errordescription and errornumber if an error occured.
	 *
	 * @return int Errornumber
	 */

	function geterrdescno()
	{
		if($this->link_id != 0)
		{
			$this->errdesc = mysql_error($this->link_id);
			$this->errno = mysql_errno($this->link_id);
		}
		else
		{
			// Maybe we don't have any linkid so let's try to catch at least anything

			$this->errdesc = mysql_error();
			$this->errno = mysql_errno();
		}

		return $this->errno;
	}

	/**
	 * Dies with an errormessage
	 *
	 * @param string Errormessage
	 */

	function showerror($errormsg, $mysqlActive = true)
	{
		global $filename, $theme;

		$text = 'MySQL - Error: ' . str_replace("\n", "\t", $errormsg);
		if($mysqlActive)
		{
			$this->geterrdescno();
			$text .= "; ErrNo: " . $this->errno . "; Desc: " . $this->errdesc;
		}

		if($filename != 'cronscript.php')
		{
			$text .= "; Script: " . getenv('REQUEST_URI') . "; Ref: " . getenv('HTTP_REFERER');
		}
		else
		{
			$text .= "; Script: cronscript";
		}
		$md5 = md5($text . time());
		openlog("Froxlor", LOG_NDELAY, LOG_USER);
		syslog(LOG_ERR, $text . "; $md5");
		closelog();
		die("We are sorry, but a MySQL - error occurred. The administrator may find more information in syslog with the ID $md5");
	}
}

?>
