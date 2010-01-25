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
 * @version    $Id$
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

	var $link_id = 0;

	/**
	 * Query ID for every query
	 * @var int
	 */

	var $query_id = 0;

	/**
	 * Errordescription, if an error occures
	 * @var string
	 */

	var $errdesc = '';

	/**
	 * Errornumber, if an error occures
	 * @var int
	 */

	var $errno = 0;

	/**
	 * Servername
	 * @var string
	 */

	var $server = '';

	/**
	 * Username
	 * @var string
	 */

	var $user = '';

	/**
	 * Password
	 * @var string
	 */

	var $password = '';

	/**
	 * Database
	 * @var string
	 */

	var $database = '';

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
		$this->link_id = @mysql_connect($this->server, $this->user, $this->password);

		if(!$this->link_id)
		{
			//try to connect with no password an change it afterwards. only for root user

			if($this->user == 'root')
			{
				$this->link_id = @mysql_connect($this->server, $this->user, '');

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
		mysql_query("SET NAMES utf8", $this->link_id);
		mysql_query("SET CHARACTER SET utf8", $this->link_id);
	}

	/**
	 * Closes connection to Databaseserver
	 */

	function close()
	{
		return @mysql_close($this->link_id);
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

	function query($query_str, $unbuffered = false)
	{
		global $numbqueries;

		if(!$unbuffered)
		{
			$this->query_id = mysql_query($query_str, $this->link_id);
		}
		else
		{
			$this->query_id = mysql_unbuffered_query($query_str, $this->link_id);
		}

		if(!$this->query_id)
		{
			$this->showerror('Invalid SQL: ' . $query_str);
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
		global $filename;

		if($mysqlActive)
		{
			$this->geterrdescno();
			$errormsg.= "\n";
			$errormsg.= 'mysql error number: ' . $this->errno . "\n";
			$errormsg.= 'mysql error desc: ' . $this->errdesc . "\n";
		}

		$errormsg.= 'Time/date: ' . date('d/m/Y h:i A') . "\n";

		if($filename != 'cronscript.php')
		{
			$errormsg.= 'Script: ' . htmlspecialchars(getenv('REQUEST_URI')) . "\n";
			$errormsg.= 'Referer: ' . htmlspecialchars(getenv('HTTP_REFERER')) . "\n";
			die(nl2br($errormsg));
		}
		else
		{
			$errormsg.= 'Script: -- Cronscript --' . "\n";
			die($errormsg);
		}
	}
}

?>
