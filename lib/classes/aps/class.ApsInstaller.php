<?php

/**
 * Implementation of the Application Packaging Standard from SwSoft/Parallels
 * http://apsstandard.com
 *
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
 * @package    APS
 *
 * @todo		logging
 *				run with user uid/gid
 *				folder truncation/tar all files
 */

class ApsInstaller extends ApsParser
{
	private $db = false;
	private $db_root = false;
	private $DomainPath = '';
	private $Domain = '';
	private $RealPath = '';
	private $RootDir = '';
	private $Hosts = '';
	private $aps_version = '1.0';

	/**
	 * constructor of class. setup some basic variables
	 *
	 * @param	settings	array with the global settings from syscp
	 * @param	db			instance of the database class from syscp
	 * @param	db_root		instance of the database class from syscp with root permissions
	 */

	public function __construct($settings, $db, $db_root)
	{
		$this->db = $db;
		$this->db_root = $db_root;
		$this->RootDir = dirname(dirname(dirname(dirname(__FILE__)))) . '/';
		$this->Hosts = $settings['system']['mysql_access_host'];
	}

	/**
	 * main function of class which handles all
	 */

	public function InstallHandler()
	{
		chdir($this->RootDir);
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` AS `t` INNER JOIN `' . TABLE_APS_INSTANCES . '` AS `i` ON `t`.`InstanceID` = `i`.`ID` INNER JOIN `' . TABLE_APS_PACKAGES . '` AS `p` ON `i`.`PackageID` = `p`.`ID` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `TASK` NOT IN (' . TASK_SYSTEM_UPDATE . ', ' . TASK_SYSTEM_DOWNLOAD . ')');

		while($Row = $this->db->fetch_array($result))
		{
			//check for existing aps xml file

			if(!file_exists($this->RootDir . 'packages/' . $Row['Path'] . '/APP-META.xml'))
			{
				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_ERROR . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));
				continue;
			}

			//get contents and parse them

			$XmlContent = file_get_contents($this->RootDir . 'packages/' . $Row['Path'] . '/APP-META.xml');
			$Xml = new SimpleXMLElement($XmlContent);
			
			$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';

			//check for unparseable xml data

			if($Xml == false)
			{
				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_ERROR . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));
				continue;
			}

			$Task = $Row['Task'];
			$this->DomainPath = '';
			$this->Domain = '';
			$this->RealPath = '';

			//lock instance so installation cannot be canceled from the panel

			$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_TASK_ACTIVE . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));

			//setup environment with data for domain/installation location

			self::PrepareBasics($Row);

			//create database if necessary and setup environment variables

			self::PrepareDatabase($Xml, $Row, $Task);

			//unpack installation scripts and package files if necessary

			if(self::PrepareFiles($Xml, $Row, $Task))
			{
				//setup environment variables fetched from installation wizard

				self::PrepareWizardData($Xml, $Row, $Task);

				//run installation scripts from packages

				self::RunInstaller($Xml, $Row, $Task);
			}

			//remove installation scripts

			self::CleanupData($Xml, $Row, $Task);
			unset($Xml);
		}
	}

	/**
	 * run the installation script and log errors if there are some
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 * @param	row			current entry from the database for app to handle
	 * @param	task		numeric code to specify what to do
	 * @return	success true/error false
	 */

	private function RunInstaller($Xml, $Row, $Task)
	{
		//installation

		if($Task == TASK_INSTALL)
		{
			//setup right path and run installation script

			if(!is_dir($this->RealPath . $this->DomainPath . '/install_scripts/'))
			{
				echo 'Directory: '. $this->RealPath . $this->DomainPath . '/install_scripts/ does not exist';
				return;
			}

			chdir($this->RealPath . $this->DomainPath . '/install_scripts/');

			// make configure-script executable
			if($this->aps_version != '1.0')
			{
				$scriptname = (string)$Xml->service->provision->{'configuration-script'}['name'];
			} else {
				$scriptname = 'configure';
			}

			chmod($this->RealPath . $this->DomainPath . '/install_scripts/'.$scriptname, 0755);
			
			$Return = array();
			
			// first 'true' to indicate that we want the return-status from exec.
			// after exec() is called, the value will be the return-status of the
			// program executed
			$ReturnStatus = true;

			$Return = safe_exec('php ' . escapeshellarg($this->RealPath . $this->DomainPath . '/install_scripts/'.$scriptname) . ' install', $ReturnStatus);

			if($ReturnStatus != 0)
			{
				//write output of script on error into database for admin

				$Buffer = '';
				$Count = 0;
				foreach($Return as $Line)
				{
					$Count+= 1;
					$Buffer.= $Line;

					if($Count != count($Return))$Buffer.= "\n";
				}

				//FIXME error logging

				echo ("error : installer\n" . $Buffer . "\n");
				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_ERROR . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));
				return false;
			}
			else
			{
				//installation succeeded
				//chown all files if installtion script has created some new files. otherwise customers cannot edit the files via ftp

				safe_exec('chown -R ' . (int)$Row['guid'] . ':' . (int)$Row['guid'] . ' ' . escapeshellarg($this->RealPath . $this->DomainPath . '/'));

				//update database

				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_SUCCESS . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));
				return true;
			}
		}
	}

	/**
	 * remove installation scripts from filesystem and remove tasks and update the database
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 * @param	row			current entry from the database for app to handle
	 * @param	task		numeric code to specify what to do
	 */

	private function CleanupData($Xml, $Row, $Task)
	{
		chdir($this->RootDir);

		if($Task == TASK_INSTALL)
		{
			//cleanup installation

			self::UnlinkRecursive($this->RealPath . $this->DomainPath . '/install_scripts/');

			//remove task

			$this->db->query('DELETE FROM `' . TABLE_APS_TASKS . '` WHERE `Task` = ' . TASK_INSTALL . ' AND `InstanceID` = ' . $this->db->escape($Row['InstanceID']));
		}
		elseif($Task == TASK_REMOVE)
		{
			// check for database
			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$XmlDb = $Xml->requirements->children('http://apstandard.com/ns/1/db');
			} 
			else 
			{
				// since 1.1
				$Xml->registerXPathNamespace('db', 'http://apstandard.com/ns/1/db');
	
				$XmlDb = new DynamicProperties;
				$XmlDb->db->id = getXPathValue($Xml, '//db:id');
			}

			if($XmlDb->db->id)
			{
				//drop database permissions

				$Database = 'web' . $Row['CustomerID'] . 'aps' . $Row['InstanceID'];
				foreach(array_map('trim', explode(',', $this->Hosts)) as $DatabaseHost)
				{
					$this->db_root->query('REVOKE ALL PRIVILEGES ON * . * FROM `' . $this->db->escape($Database) . '`@`' . $this->db->escape($DatabaseHost) . '`');
					$this->db_root->query('REVOKE ALL PRIVILEGES ON `' . $this->db->escape($Database) . '` . * FROM `' . $this->db->escape($Database) . '`@`' . $this->db->escape($DatabaseHost) . '`');
					$this->db_root->query('DELETE FROM `mysql`.`user` WHERE `User` = "' . $this->db->escape($Database) . '" AND `Host` = "' . $this->db->escape($DatabaseHost) . '"');
				}

				//drop database
				$this->db_root->query('DROP DATABASE IF EXISTS `' . $this->db->escape($Database) . '`');
				$this->db_root->query('FLUSH PRIVILEGES');

				/*
				 * remove database from customer-mysql overview, #272
				 */
				$this->db->query('DELETE FROM `' . TABLE_PANEL_DATABASES . '` WHERE `customerid`="' . (int)$Row['CustomerID'] . '" AND `databasename`="' . $this->db->escape($Database) . '" AND `apsdb`="1"');
				$result = $this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `mysqls_used`=`mysqls_used`-1 WHERE `customerid`="' . (int)$Row['CustomerID'] . '"');
			}

			//remove task & delete package instance + settings

			$this->db->query('DELETE FROM `' . TABLE_APS_TASKS . '` WHERE `Task` = ' . TASK_REMOVE . ' AND `InstanceID` = ' . $this->db->escape($Row['InstanceID']));
			$this->db->query('DELETE FROM `' . TABLE_APS_INSTANCES . '` WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));
			$this->db->query('DELETE FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['InstanceID']));

			//remove data,  #273
			if($this->DomainPath != '' && $this->DomainPath != '/') {
				self::UnlinkRecursive($this->RealPath . $this->DomainPath . '/');
			} else {
				// save awstats/webalizer folder if it's the docroot
				self::UnlinkRecursive($this->RealPath . $this->DomainPath . '/', true);
				// place standard-index file
				$loginname = getLoginNameByUid($Row['CustomerID']);
				if($loginname !== false)
				{
					storeDefaultIndex($loginname, $this->RealPath . $this->DomainPath . '/');
				}
			}
		}
	}

	/**
	 * setup all environment variables from the wizard, they're all needed by the installation script
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 * @param	row			current entry from the database for app to handle
	 * @param	task		numeric code to specify what to do
	 */

	private function PrepareWizardData($Xml, $Row, $Task)
	{
		//data collected by wizard
		//FIXME install_only parameter/reconfigure

		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['InstanceID']));

		while($Row2 = $this->db->fetch_array($result))
		{
			//skip APS internal data

			if($Row2['Name'] == 'main_location'
			|| $Row2['Name'] == 'main_domain'
			|| $Row2['Name'] == 'main_database_password'
			|| $Row2['Name'] == 'license')continue;
			putenv('SETTINGS_' . $Row2['Name'] . '=' . $Row2['Value']);
		}
	}

	/**
	 * extract all needed files from the aps packages
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 * @param	row			current entry from the database for app to handle
	 * @param	task		numeric code to specify what to do
	 * @return	success true/error false
	 */

	private function PrepareFiles($Xml, $Row, $Task)
	{
		if($this->aps_version != '1.0')
		{
			$mapping = $Xml->service->provision->{'url-mapping'}->mapping;
			$mapping_path = $Xml->service->provision->{'url-mapping'}->mapping['path'];
			$mapping_url = $Xml->service->provision->{'url-mapping'}->mapping['url'];
		}
		else 
		{
			$mapping = $Xml->mapping;
			$mapping_path = $Xml->mapping['path'];
			$mapping_url = $Xml->mapping['url'];
		}
		
		if($Task == TASK_INSTALL)
		{
			//FIXME truncate customer directory
			//remove files from: $this->RealPath . $this->DomainPath . '/*'

			if(!file_exists($this->RealPath . $this->DomainPath . '/'))mkdir($this->RealPath . $this->DomainPath . '/', 0777, true);

			//extract all files and chown them to the customer guid

			if(self::ExtractZip($this->RootDir . 'packages/' . $Row['Path'] . '/' . $Row['Path'], $mapping_path, $this->RealPath . $this->DomainPath . '/') == false
			|| self::ExtractZip($this->RootDir . 'packages/' . $Row['Path'] . '/' . $Row['Path'], 'scripts', $this->RealPath . $this->DomainPath . '/install_scripts/') == false)
			{
				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_ERROR . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));

				//FIXME clean up already installed data
				//remove files from: $this->RealPath . $this->DomainPath . '/*'

				return false;
			}

			safe_exec('chown -R ' . (int)$Row['guid'] . ':' . (int)$Row['guid'] . ' ' . escapeshellarg($this->RealPath . $this->DomainPath . '/'));
		}
		else
		{
			if(self::ExtractZip($this->RootDir . 'packages/' . $Row['Path'] . '/' . $Row['Path'], 'scripts', $this->RealPath . $this->DomainPath . '/install_scripts/') == false)
			{
				$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_ERROR . ' WHERE `ID` = ' . $this->db->escape($Row['InstanceID']));

				//clean up already installed data

				self::UnlinkRecursive($this->RealPath . $this->DomainPath . '/install_scripts/');
				return false;
			}

			//set right file owner

			safe_exec('chown -R ' . (int)$Row['guid'] . ':' . (int)$Row['guid'] . ' ' . escapeshellarg($this->RealPath . $this->DomainPath . '/'));
		}

		//recursive mappings

		self::PrepareMappings($mapping, $mapping_url, $this->RealPath . $this->DomainPath . '/');
		return true;
	}

	/**
	 * setup path environment variables for the installation script
	 *
	 * @param	parentmapping	instance of parsed xml file, current mapping position
	 * @param	url				relative path for application specifying the current path within the mapping tree
	 * @param	path			absolute path for application specifying the current path within the mapping tree
	 */

	private function PrepareMappings($ParentMapping, $Url, $Path)
	{
		//check for special PHP permissions
		//must be done with xpath otherwise check not possible (XML parser problem with attributes)

		if ($ParentMapping && $ParentMapping !== null) {

			$ParentMapping->registerXPathNamespace('p', 'http://apstandard.com/ns/1/php');
			$Result = $ParentMapping->xpath('p:permissions');

			if (is_array($Result) && isset($Result[0]) && is_array($Result[0])) {
				if	(isset($Result[0]['writable']) && $Result[0]['writable'] == 'true') {
					// fixing file permissions to writeable
					if (is_dir($Path)) {
						chmod($Path, 0775);
					} else {
						chmod($Path, 0664);
					}
				}

				if (isset($Result[0]['readable']) && $Result[0]['readable'] == 'false') {
					//fixing file permissions to non readable	
					if (is_dir($Path)) {
						chmod($Path, 0333);
					} else {
						chmod($Path, 0222);
					}
				}
			}
		}

		//set environment variables

		$EnvVariable = str_replace("/", "_", $Url);
		putenv('WEB_' . $EnvVariable . '_DIR=' . $Path);

		//resolve deeper mappings
		if($ParentMapping && $ParentMapping !== null)
		{
			foreach($ParentMapping->mapping as $Mapping)
			{
				//recursive check of other mappings
	
				if($Url == '/')
				{
					self::PrepareMappings($Mapping, $Url . $Mapping['url'], $Path . $Mapping['url']);
				}
				else
				{
					self::PrepareMappings($Mapping, $Url . '/' . $Mapping['url'], $Path . '/' . $Mapping['url']);
				}
			}
		}
	}

	/**
	 * setup domain environment variables for the installation script
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 */

	private function PrepareBasics($Row)
	{
		//domain

		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['InstanceID']) . ' AND `Name` = "main_domain"');
		$Row3 = $this->db->fetch_array($result);
		$result2 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `id` = ' . $this->db->escape($Row3['Value']));
		$Row3 = $this->db->fetch_array($result2);
		$this->Domain = $Row3['domain'];
		$this->RealPath = $Row3['documentroot'];

		//location

		$result3 = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['InstanceID']) . ' AND `Name` = "main_location"');
		$Row3 = $this->db->fetch_array($result3);
		$this->DomainPath = $Row3['Value'];

		//if application is directly installed on domain remove / at the end

		if($this->DomainPath == '')$this->RealPath = substr($this->RealPath, 0, strlen($this->RealPath) - 1);

		//url environment variables

		putenv('BASE_URL_HOST=' . $this->Domain);
		putenv('BASE_URL_PATH=' . $this->DomainPath . '/');
		putenv('BASE_URL_SCHEME=http');
	}

	/**
	 * create a database if necessary and setup environment variables
	 *
	 * @param	xml			instance of a valid xml object with a parsed APP-META.xml file
	 * @param	row			current entry from the database for app to handle
	 * @param	task		numeric code to specify what to do
	 */

	private function PrepareDatabase($Xml, $Row, $Task)
	{
		$XmlDb = $Xml->requirements->children('http://apstandard.com/ns/1/db');

		if ($this->aps_version == '1.0')
		{
			// the good ole way
			$XmlDb = $Xml->requirements->children('http://apstandard.com/ns/1/db');
		} 
		else
		{
			// since 1.1
			$Xml->registerXPathNamespace('db', 'http://apstandard.com/ns/1/db');

			$XmlDb = new DynamicProperties;
			$XmlDb->db->id = getXPathValue($Xml, '//db:id');
		}

		if($XmlDb->db->id)
		{
			//database management

			$NewDatabase = 'web' . $Row['CustomerID'] . 'aps' . $Row['InstanceID'];
			$result = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['InstanceID']) . ' AND `Name` = "main_database_password"');
			$Row3 = $this->db->fetch_array($result);
			$DbPassword = $Row3['Value'];

			if($Task == TASK_INSTALL)
			{
				$this->db_root->query('DROP DATABASE IF EXISTS `' . $this->db->escape($NewDatabase) . '`');
				$this->db_root->query('CREATE DATABASE IF NOT EXISTS `' . $this->db->escape($NewDatabase) . '`');
				foreach(array_map('trim', explode(',', $this->Hosts)) as $DatabaseHost)
				{
					$this->db_root->query('GRANT ALL PRIVILEGES ON `' . $this->db->escape($NewDatabase) . '`.* TO `' . $this->db->escape($NewDatabase) . '`@`' . $this->db->escape($DatabaseHost) . '` IDENTIFIED BY \'password\'');
					$this->db_root->query('SET PASSWORD FOR `' . $this->db->escape($NewDatabase) . '`@`' . $this->db->escape($DatabaseHost) . '` = PASSWORD(\'' . $DbPassword . '\')');
				}

				$this->db_root->query('FLUSH PRIVILEGES');

				/*
				 * add database to customers databases, #272
				 */
				$databasedescription = $Xml->name.' '.$Xml->version.' (Release ' . $Xml->release . ')'; 
				$result = $this->db->query('INSERT INTO `' . TABLE_PANEL_DATABASES . '` (`customerid`, `databasename`, `description`, `dbserver`, `apsdb`) VALUES ("' . (int)$Row['CustomerID'] . '", "' . $this->db->escape($NewDatabase) . '", "' . $this->db->escape($databasedescription) . '", "0", "1")');
				$result = $this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `mysqls_used`=`mysqls_used`+1 WHERE `customerid`="' . (int)$Row['CustomerID'] . '"');	
			}

			//get first mysql access host

			$AccessHosts = array_map('trim', explode(',', $this->Hosts));

			//environment variables

			putenv('DB_' . $XmlDb->db->id . '_TYPE=mysql');
			putenv('DB_' . $XmlDb->db->id . '_NAME=' . $NewDatabase);
			putenv('DB_' . $XmlDb->db->id . '_LOGIN=' . $NewDatabase);
			putenv('DB_' . $XmlDb->db->id . '_PASSWORD=' . $DbPassword);
			putenv('DB_' . $XmlDb->db->id . '_HOST=' . $AccessHosts[0]);
			putenv('DB_' . $XmlDb->db->id . '_PORT=3306');
			putenv('DB_' . $XmlDb->db->id . '_VERSION=' . mysql_get_server_info());
		}
	}

	/**
	 * extract complete directories from a zipfile
	 *
	 * @param	filename		path to zipfile to extract
	 * @param	directory		which directory in zipfile to extract
	 * @param	destination		destination directory for files to extract
	 * @return	success true/error false
	 */

	private function ExtractZip($Filename, $Directory, $Destination)
	{
		if(!file_exists($Filename))return false;

		//fix slash notation for correct paths

		if(substr($Directory, -1, 1) == '/')$Directory = substr($Directory, 0, strlen($Directory) - 1);

		if(substr($Destination, -1, 1) != '/')$Destination.= '/';

		//open zipfile to read its contents

		$ZipHandle = zip_open(realpath($Filename));

		if(is_resource($ZipHandle))
		{
			while($ZipEntry = zip_read($ZipHandle))
			{
				if(substr(zip_entry_name($ZipEntry), 0, strlen($Directory)) == $Directory)
				{
					//fix relative path from zipfile

					$NewPath = zip_entry_name($ZipEntry);
					$NewPath = substr($NewPath, strlen($Directory));

					//directory

					if(substr($NewPath, -1, 1) == '/')
					{
						if(!file_exists($Destination . $NewPath))mkdir($Destination . $NewPath, 0777, true);
					}
					else
					{
						//files

						if(zip_entry_open($ZipHandle, $ZipEntry))
						{
							// handle new directory
							$dir = dirname($Destination.$NewPath);
							if (!file_exists($dir)) {
								mkdir ($dir, 0777, true);
							}

							$File = fopen($Destination . $NewPath, "wb");

							if($File)
							{
								while($Line = zip_entry_read($ZipEntry))
								{
									fwrite($File, $Line);
								}

								fclose($File);
							}
							else
							{
								return false;
							}
						}
					}
				}
			}

			zip_close($ZipHandle);
			return true;
		}
		else
		{
			$ReturnLines = array();
			
			// first 'true' to indicate that we want the return-status from exec.
			// after exec() is called, the value will be the return-status of the
			// program executed
			$ReturnVal = true;


			//on 64 bit systems the zip functions can fail -> use exec to extract the files

			$ReturnLines = safe_exec('unzip -o -qq ' . escapeshellarg(realpath($Filename)) . ' ' . escapeshellarg($Directory . '/*') . ' -d ' . escapeshellarg(sys_get_temp_dir()), $ReturnVal);

			if($ReturnVal == 0)
			{
				//fix absolute structure of extracted data

				if(!file_exists($Destination))mkdir($Destination, 0777, true);
				safe_exec('cp -Rf ' . sys_get_temp_dir() . '/' . $Directory . '/*' . ' ' . escapeshellarg($Destination));
				self::UnlinkRecursive(sys_get_temp_dir() . '/' . $Directory . '/');
				return true;
			}
			else
			{
				return false;
			}
		}

		return false;
	}
}
