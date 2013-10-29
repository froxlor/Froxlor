<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 *
 * @since      0.9.31
 *
 */

/**
 * Class Database
 *
 * Wrapper-class for PHP-PDO
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Classes
 */
class Database {

	/**
	 * current database link
	 *
	 * @var object
	 */
	private static $_link = null ;

	/**
	 * Wrapper for PDOStatement::execute so we can catch the PDOException
	 * and display the error nicely on the panel
	 *
	 * @param PDOStatement $stmt
	 * @param array $params (optional)
	 */
	public static function pexecute(&$stmt, $params = null) {
		try {
			$stmt->execute($params);
		} catch (PDOException $e) {
			self::_showerror($e);
		}
	}

	/**
	 * returns the number of found rows of the last select query
	 *
	 * @return int
	 */
	public static function num_rows($stmt) {
		return Database::query("SELECT FOUND_ROWS()")->fetchColumn();
	}

	/**
	 * let's us interact with the PDO-Object by using static
	 * call like "Database::function()"
	 *
	 * @param string $name
	 * @param mixed $args
	 *
	 * @return mixed
	 */
	public static function __callStatic($name, $args) {
		$callback = array(self::getDB(), $name);
		$result = null;
		try {
			$result = call_user_func_array($callback, $args );
		} catch (PDOException $e) {
			self::_showerror($e);
		}
		return $result;
	}

	/**
	 * function that will be called on every static call
	 * which connects to the database if necessary
	 *
	 * @param bool $root
	 *
	 * @return object
	 */
	private static function getDB($root = false) {

		if (!extension_loaded('pdo') || in_array("mysql", PDO::getAvailableDrivers()) == false) {
			self::_showerror(new Exception("The php PDO extension or PDO-MySQL driver is not available"));
		}

		// do we got a connection already?
		if (self::$_link) {
			// return it
			return self::$_link;
		}

		// include userdata.inc.php
		require FROXLOR_INSTALL_DIR."/lib/userdata.inc.php";

		// le format
		if ($root = true
				&& isset($sql['root_user'])
				&& isset($sql['root_password'])
				&& (!isset($sql_root) || !is_array($sql_root))
		) {
			$sql_root = array(0 => array('caption' => 'Default', 'host' => $sql['host'], 'user' => $sql['root_user'], 'password' => $sql['root_password']));
			unset($sql['root_user']);
			unset($sql['root_password']);
		}

		// either root or unprivileged user
		if ($root) {
			$user = $sql_root[0]['user'];
			$password = $sql_root[0]['password'];
			$host = $sql_root[0]['host'];
		} else {
			$user = $sql["user"];
			$password = $sql["password"];
			$host = $sql["host"];
		}

		// build up connection string
		$driver = 'mysql';
		$dsn = $driver.":";
		$options = array('PDO::MYSQL_ATTR_INIT_COMMAND' => 'set names utf8');
		$attributes = array('ATTR_ERRMODE' => 'ERRMODE_EXCEPTION');

		$dbconf["dsn"] = array(
				'host' => $host,
				'dbname' => $sql["db"]
		);

		// add options to dsn-string
		foreach ($dbconf["dsn"] as $k => $v) {
			$dsn .= $k."=".$v.";";
		}

		// clean up
		unset($dbconf);

		// try to connect
		try {
			self::$_link = new PDO($dsn, $user, $password, $options);
		} catch (PDOException $e) {
			self::_showerror($e);
		}

		// set attributes
		foreach ($attributes as $k => $v) {
			self::$_link->setAttribute(constant("PDO::".$k), constant("PDO::".$v));
		}

		// return PDO instance
		return self::$_link;
	}

	/**
	 * display a nice error if it occurs and log everything
	 *
	 * @param PDOException $error
	 */
	private static function _showerror($error) {
		global $theme;

		/**
		 * log to a file, so we can actually ask people for the error
		 * (no one seems to find the stuff in the syslog)
		*/
		$sl_dir = makeCorrectDir(FROXLOR_INSTALL_DIR."/logs/");
		if (!file_exists($sl_dir)) {
			@mkdir($sl_dir, 0755);
		}
		$sl_file = makeCorrectFile($sl_dir."/sql-error.log");
		$sqllog = @fopen($sl_file, 'a');
		@fwrite($sqllog, date('d.m.Y H:i', time())." --- ".str_replace("\n", " ", $error->getMessage())."\n");
		@fclose($sqllog);

		if (!isset($_SERVER['SHELL']) || (isset($_SERVER['SHELL']) && $_SERVER['SHELL'] == '')) {
			// if we're not on the shell, output a nicer error-message
			$err_hint = file_get_contents(dirname($sl_dir).'/templates/'.$theme.'/misc/dberrornice.tpl');
			// replace values
			$err_hint = str_replace("<TEXT>", $error->getMessage(), $err_hint);
			$err_hint = str_replace("<DEBUG>", $error->getTraceAsString(), $err_hint);
			// show
			die($err_hint);
		}
		die("We are sorry, but a MySQL - error occurred. The administrator may find more information in in the sql-error.log in the logs/ directory");
	}
}
