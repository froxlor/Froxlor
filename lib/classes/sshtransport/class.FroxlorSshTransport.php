<?php

/**
 * ssh Transport class
 *
 * This class provides interaction with modules
 *
 * PHP version 5
 *
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @category   FroxlorCore
 * @package    Classes
 * @subpackage System
 * @author     Froxlor Team <team@froxlor.org>
 * @copyright  2010 the authors
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @version    SVN: $Id$
 * @link       http://www.froxlor.org/
 */

/**
 * Class FroxlorSshTransport
 * 
 * This class handles remote server related stuff.
 *
 * @category   FroxlorCore
 * @package    Classes
 * @subpackage System
 * @author     Froxlor Team <team@froxlor.org>
 * @copyright  2010 the authors
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @link       http://www.froxlor.org/
 */
class FroxlorSshTransport
{
	/**
	 * Clas object.
	 * 
	 * @var FroxlorSshTransport
	 */
	private static $_instance = null;
	
	/**
	 * Contains the connection handle.
	 * 
	 * @var resource
	 */
	private $_connection = null;
	
	/**
	 * Contains all information for the ssh connection.
	 * 
	 * @var array
	 */
	private $_settings = array();
	
	/**
	 * Contains the shell resource.
	 * 
	 * @var resource
	 */
	private $_shell = null;
	
	/**
	 * Constructor (Singleton)
	 * 
	 * @param array $settings contains an array of settings for the connection
	 * 
	 * @return FroxlorSshTransport
	 * 
	 * @throws Exception if the connection could not be established
	 */
	private function __construct($settings)
	{
		// settings
		$this->_settings = $settings;
		// try to connect
		$this->_connect();
		
		// get a shell stream
		$this->_shell = $this->_getShell();
	}
	
	/**
	 * Destructor.
	 *
	 */
	public function __destruct()
	{
		$this->close();
	}

	/**
	 * Constructor for publickey auth
	 * 
	 * @param string $ip          ip toremote server
	 * @param string $port        remote port
	 * @param string $username    ssh username
	 * @param string $pubkeyfile  path to pubkeyfile
	 * @param string $privkeyfile path to privatekeyfile
	 * @param string $passphrase  passphrase
	 * 
	 * @return FroxlorSshTransport
	 */
	public static function usePublicKey($ip, $port, $username, $pubkeyfile, $privkeyfile , $passphrase)
	{
		$settings = array(
		  'ip' => $ip,
		  'port' => $port,
		  'username' => $username,
		  'pubkeyfile' => $pubkeyfile,
		  'privkeyfile' => $privkeyfile,
		  'passphrase' => $passphrase
		);
		
		if (is_null(self::$_instance)) {
			self::$_instance = new FroxlorSshTransport($settings);
		}
		
		return self::$_instance;
	}
	
	/**
	 * Constructor for plain password auth
	 * 
	 * @param string $ip       ip to remote server
     * @param string $port     remote port
     * @param string $username ssh username
	 * @param string $password ssh password
	 * 
	 * @return FroxlorSshTransport
	 */
	public static function usePlainPassword($ip, $port, $username, $password)
	{
		$settings = array(
          'ip' => $ip,
          'port' => $port,
          'username' => $username,
		  'password' => $password
        );
        
	   if (is_null(self::$_instance)) {
	       self::$_instance = new FroxlorSshTransport($settings);
	   }
	   
	   return self::$_instance;
	}
	
	/**
	 * Send a command to the shell session.
	 * 
	 * @param string $cmd command to send (without EOL)
	 */
	public function sendCmd($cmd)
	{
		// writes the command to the shell
		fwrite($this->_shell, $cmd.PHP_EOL);
	}
	
	/**
	 * Sends a file to the remote server.
	 * The function checks if fopen() is enabled to use a faster way
	 * to send the file. Otherwise ssh2_scp_send() is used.
	 * 
	 * @param string $localFile  path to the local file
	 * @param string $remoteFile remote file path
	 * @param string $chmod      file rights (default: 0644)
	 * 
	 * @return boolean
	 */
	public function sendFile($localFile, $remoteFile, $chmod = 0644)
	{
		// check if file exists
		if (@!is_readable($localFile)) {
			return false;
		}
		
		// send file with scp if fopen() is disabled
		if (ssh2_scp_send($this->_connection, $localFile, $remoteFile, $chmod) && !function_exists("fopen")) {
			return true;
		} else {
			return false;
		}
		
		// open a sftp cnnection
		$sftp = ssh2_sftp($this->_connection);
		
		// connect to it
		$sftpStream = @fopen('ssh2.sftp://'.$sftp.$remoteFile, 'w');
	
		try {
			if (!$sftpStream) {
				throw new Exception("Could not open remote file: $remoteFile");
		    }
		   
		    $data_to_send = @file_get_contents($localFile);
		   
		    if ($data_to_send === false) {
				throw new Exception("Could not open local file: $localFile.");
		    }
		   
		    if (@fwrite($sftpStream, $data_to_send) === false) {
				throw new Exception("Could not send data from file: $localFile.");
		    }
		    
		    fclose($sftpStream);
		    return true;
				   
		} catch (Exception $e) {
			// TODO log to error log?
		    fclose($sftpStream);
		    return false;
		}
	}
	
	/**
	 * This reads all available output.
	 * 
	 * @return array
	 */
	public function readAll()
	{
		if (is_null($this->_shell)) {
			return array();
		}
		
		$output = array();
		
		while($line = fgets($this->_shell)) {
		$output[] = $line;
		}
		
		return $output;
	}
	
	/**
	 * Clean up.
	 */
	public function close()
	{
		// close the session and force flushing file content to disk
		ssh2_exec($this->_connection, 'exit'); 
		
		// set null values
		$this->_shell = null;
		$this->_settings = null;
		$this->_connection = null;
		$this->_instance = null;
	}
	
	/**
	 * This function connects to the remote server.
	 * 
	 * @return void
	 */
	private function _connect()
	{
		$callbacks = array('disconnect' => array('FroxlorSshTransport', 'disconnected'));
		
		if ($this->_settings['pubkeyfile']) {
			// pubkey authentication
			$this->_connection = ssh2_connect($this->_settings['ip'], $this->_settings['port'], array('hostkey'=>'ssh-rsa'), $callbacks);
			$success = ssh2_auth_pubkey_file($this->_connection, $this->_settings['username'], $pubkeyfile, $privkeyfile, $passphrase);
		} else {
			// plain password authentication
			$this->_connection = ssh2_connect($this->_settings['ip'], $this->_settings['port'], array(), $callbacks);
			$success = ssh2_auth_password($this->_connection, $this->_settings['username'], $this->_settings['password']);
		}
		
		// check connection
		if (!$success) {
			// TODO change this to an Exception for froxlor 1.0
			throw new Exception("Connection to ssh could not be established!");
		}
	}
	
	/**
	 * Returns a shell.
	 * 
	 * @return resource
	 */
	private function _getShell()
	{
		return ssh2_shell($this->_connection, 'vt102', null, 80, 24, SSH2_TERM_UNIT_CHARS);
	}
	
	/**
	 * Callback function if the connection disconnects.
	 * 
	 * @param string $reason   reason
	 * @param string $message  message
	 * @param string $language language
	 * 
	 * @return void
	 */
	public static function disconnected($reason, $message, $language)
	{
		// try reconnecting
		try{
			self::$_instance->_connect();
		} catch (Exception $e) {
			die("Connection lost and could not re-established! \n".$reason."\n".$message."\n".$language."\n".$e->getMessage());
		}
	}
}

