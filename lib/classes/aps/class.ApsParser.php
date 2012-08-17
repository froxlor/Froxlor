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
 * @todo		implement charset validation
 *				reconfigure
 *				patch- and versionmanagement
 *				use settings/userinfo array instead a copy of this vars
 *				remove locked packages
 *				replace all html code
 *				add https support
 *				multi language support (package localization)
 *				zip stuff in own class
 *				logging
 *				button for remove of all failed installations
 *				increse database counter for customer
 */

class ApsParser
{
	private $userinfo = array();
	private $settings = array();
	private $db = false;
	private $RootDir = '';
	private $aps_version = '1.0';

	/**
	 * Constructor of class, setup basic variables needed by the class
	 *
	 * @param	userinfo		global array with the current userinfos
	 * @param	settings		global array with the current system settings
	 * @param	db				valid instance of the database class
	 */

	public function __construct($userinfo, $settings, $db)
	{
		$this->settings = $settings;
		$this->userinfo = $userinfo;
		$this->db = $db;
		$this->RootDir = dirname(dirname(dirname(dirname(__FILE__)))) . '/';
	}

	/**
	 * function provides instance management for admins
	 */

	private function ManageInstances()
	{
		global $lng, $filename, $s, $page, $action, $theme;
		$Question = false;

		//dont do anything if there is no instance

		if((int)$this->userinfo['customers_see_all'] == 1)
		{
			$Instances = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_APS_PACKAGES . '` AS `p` ON `i`.`PackageID` = `p`.`ID`');
		}
		else
		{
			$Instances = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_APS_PACKAGES . '` AS `p` ON `i`.`PackageID` = `p`.`ID` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid']);
		}

		if($this->db->num_rows($Instances) == 0)
		{
			self::InfoBox($lng['aps']['noinstancesexisting']);
			return;
		}

		if(isset($_POST['save']))
		{
			$Ids = '';
			$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '`');

			while($Row = $this->db->fetch_array($Result))
			{
				//has admin clicked "yes" for question

				if(isset($_POST['answer'])
				   && $_POST['answer'] == $lng['panel']['yes'])
				{
					//instance installation stop

					if(isset($_POST['stop' . $Row['ID']])
					   && $_POST['stop' . $Row['ID']] == '1')
					{
						//remove task

						$this->db->query('DELETE FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . (int)$Row['ID']);

						//remove settings

						$this->db->query('DELETE FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . (int)$Row['ID']);

						//remove instance

						$this->db->query('DELETE FROM `' . TABLE_APS_INSTANCES . '` WHERE `ID` = ' . (int)$Row['ID']);

						//decrease used flag

						$this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `aps_packages_used` = `aps_packages_used` - 1 WHERE `customerid` = ' . (int)$Row['	CustomerID']);
					}

					//instance uninstallation

					if(isset($_POST['remove' . $Row['ID']])
					   && $_POST['remove' . $Row['ID']] == '1')
					{
						//remove installation task if it still exists

						$this->db->query('DELETE FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . (int)$Row['ID'] . ' AND `Task` = ' . TASK_INSTALL);

						//insert task for uninstallation if it doesnt exists already

						$Result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . (int)$Row['ID'] . ' AND `Task` = ' . TASK_REMOVE);

						if($this->db->num_rows($Result2) == 0)
						{
							$this->db->query('INSERT INTO `' . TABLE_APS_TASKS . '` (`InstanceID`, `Task`) VALUES (' . (int)$Row['ID'] . ', ' . TASK_REMOVE . ')');
							$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_UNINSTALL . ' WHERE `ID` = ' . (int)$Row['ID']);
							$this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `aps_packages_used` = `aps_packages_used` - 1 WHERE `customerid` = ' . (int)$Row['	CustomerID']);
						}
					}
				}
				else
				{
					//backup all selected ids for yes/no question

					if(isset($_POST['stop' . $Row['ID']])
					   && $_POST['stop' . $Row['ID']] == '1')
					{
						$Ids.= '<input type="hidden" name="stop' . $Row['ID'] . '" value="1"/>';
					}

					if(isset($_POST['remove' . $Row['ID']])
					   && $_POST['remove' . $Row['ID']] == '1')
					{
						$Ids.= '<input type="hidden" name="remove' . $Row['ID'] . '" value="1"/>';
					}
				}
			}

			//if there are some ids, show yes/no question

			if($Ids != ''
			   && !isset($_POST['answer']))
			{
				//show yes/no question

				$Message = $lng['question']['reallydoaction'];
				eval("echo \"" . getTemplate("aps/askyesno") . "\";");
				$Question = true;
			}
		}
		//create table with contents based on instance status
		if($Question != true)
		{
			global $settings, $theme;
			$Instances = '';

			if((int)$this->userinfo['customers_see_all'] == 1)
			{
				$Result = $this->db->query('SELECT `p`.`Name`, `p`.`Version`, `p`.`Release`, `i`.`Status`, `i`.`PackageID`, `i`.`ID`, `i`.`CustomerID`, `c`.`name`, `c`.`firstname`, `c`.`company`, `c`.`loginname` FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_APS_PACKAGES . '` AS `p` ON `i`.`PackageID` = `p`.`ID` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` ORDER BY i.`Status`, p.`Version`, p.`Release`, i.`CustomerID`');
			}
			else
			{
				$Result = $this->db->query('SELECT `p`.`Name`, `p`.`Version`, `p`.`Release`, `i`.`Status`, `i`.`PackageID`, `i`.`ID`, `i`.`CustomerID`  FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_APS_PACKAGES . '` AS `p` ON `i`.`PackageID` = `p`.`ID` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid'] . ' ORDER BY i.`Status`, p.`Version`, p.`Release`, i.`CustomerID`');
			}
			$lastState = 0;
			$lastPackage = 0;
			
			while($Row = $this->db->fetch_array($Result))
			{
				if ($lastState != $Row['Status'])
				{
					switch ($Row['Status'])
					{
						case INSTANCE_INSTALL:
							$Caption = $lng['aps']['instance_install'];
							break;
						case INSTANCE_TASK_ACTIVE:
							$Caption = $lng['aps']['instance_task_active'];
							break;
						case INSTANCE_SUCCESS:
							$Caption = $lng['aps']['instance_success'];
							break;
						case INSTANCE_ERROR:
							$Caption = $lng['aps']['instance_error'];
							break;
						case INSTANCE_UNINSTALL:
							$Caption = $lng['aps']['instance_uninstall'];
							break;
					}
					eval("\$Instances.=\"" . getTemplate("aps/manage_instances_status") . "\";");
					$lastState = $Row['Status'];
					//we need to print the package header for the new State as well it can be that the last Package is the first in this section, so we would it ignore it otherwise
					$lastPackage = 0;
				}

				if (strcmp($lastPackage, $Row['Name'].$Row['Version']. '(Release ' . $Row['Release'] . ')'))
				{
					$lastPackage = $Row['Name'].$Row['Version']. '(Release ' . $Row['Release'] . ')';
					eval("\$Instances.=\"" . getTemplate("aps/manage_instances_package") . "\";");
				}

				$main_domain = $this->GetSettingValue($Row['ID'], 'main_domain');
				$main_location = $this->GetSettingValue($Row['ID'],  'main_location');
				$Result2 = $this->db->query('SELECT `domain` FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `id` = ' . $this->db->escape($main_domain));
				$Row2 = $this->db->fetch_array($Result2);
				
				$main_domain = $Row2['domain'] . '/' . $main_location;
				
				$database = $settings['customer']['accountprefix'] . $Row['CustomerID'] . 'aps' . $Row['ID'];

				switch ($Row['Status'])
				{
					case INSTANCE_INSTALL:
						$Stop = makecheckbox('stop' . $Row['ID'], '', '1');
						break;
					case INSTANCE_TASK_ACTIVE:
						break;
					case INSTANCE_SUCCESS:
						$Remove = makecheckbox('remove' . $Row['ID'], '', '1');
						break;
					case INSTANCE_ERROR:
						$Remove = makecheckbox('remove' . $Row['ID'], '', '1');
						break;
					case INSTANCE_UNINSTALL:
						break;
				}
				eval("\$Instances.=\"" . getTemplate("aps/manage_instances_detail") . "\";");
			}

			//create some statistics

			$Statistics = '';

			if((int)$this->userinfo['customers_see_all'] == 1)
			{
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '`');
				$Statistics.= sprintf($lng['aps']['numerofinstances'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `Status` = ' . INSTANCE_SUCCESS);
				$Statistics.= sprintf($lng['aps']['numerofinstancessuccess'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `Status` = ' . INSTANCE_ERROR);
				$Statistics.= sprintf($lng['aps']['numerofinstanceserror'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `Status` IN (' . INSTANCE_INSTALL . ', ' . INSTANCE_TASK_ACTIVE . ', ' . INSTANCE_UNINSTALL . ')');
				$Statistics.= sprintf($lng['aps']['numerofinstancesaction'], $this->db->num_rows($Result));
			}
			else
			{
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid']);
				$Statistics.= sprintf($lng['aps']['numerofinstances'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid'] . ' AND `Status` = ' . INSTANCE_SUCCESS);
				$Statistics.= sprintf($lng['aps']['numerofinstancessuccess'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid'] . ' AND `Status` = ' . INSTANCE_ERROR);
				$Statistics.= sprintf($lng['aps']['numerofinstanceserror'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid'] . ' AND `Status` IN (' . INSTANCE_INSTALL . ', ' . INSTANCE_TASK_ACTIVE . ', ' . INSTANCE_UNINSTALL . ')');
				$Statistics.= sprintf($lng['aps']['numerofinstancesaction'], $this->db->num_rows($Result));
			}

			eval("echo \"" . getTemplate("aps/manage_instances") . "\";");
		}
	}

	/**
	 * unlink files recursively
	 *
	 * @param	dir			directory to delete recursive
	 * @param   boolean     whether the base-directory should be kept or not
	 */
	protected function UnlinkRecursive($Dir, $save_base = false)
	{
		if(!$DirHandle = @opendir($Dir))return;

		while(false !== ($Object = readdir($DirHandle)))
		{
			if($Object == '.'
			   || $Object == '..')continue;

			if($save_base  
				&& (strtoupper($Object) == 'AWSTATS' || strtoupper($Object) == 'WEBALIZER')
			) {
				continue;
			}

			if(!@unlink($Dir . '/' . $Object))
			{
				self::UnlinkRecursive($Dir . '/' . $Object);
			}
		}

		closedir($DirHandle);
		if(!$save_base)
		{
			@rmdir($Dir);
		}
	}

	/**
	 * function provides package management for admins
	 */

	private function ManagePackages()
	{
		global $lng, $filename, $s, $page, $action, $theme;
		$Question = false;

		if(isset($_POST['save']))
		{
			if(isset($_POST['all'])
			   && $_POST['all'] == 'lock')
			{
				//lock alle packages

				$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_LOCKED . ' WHERE 1');
			}
			elseif(isset($_POST['all'])
			       && $_POST['all'] == 'unlock')
			{
				//enable all packages

				$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_ENABLED . ' WHERE 1');
			}
			elseif(isset($_POST['downloadallpackages']))
			{
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` WHERE `Task` = ' . TASK_SYSTEM_DOWNLOAD);

				if($this->db->num_rows($Result) > 0)
				{
					self::InfoBox($lng['aps']['downloadtaskexists']);
				}
				else
				{
					$this->db->query('INSERT INTO `' . TABLE_APS_TASKS . '` (`Task`, `InstanceID`) VALUES (' . TASK_SYSTEM_DOWNLOAD . ', 0)');
					self::InfoBox($lng['aps']['downloadtaskinserted']);
				}
			}
			elseif(isset($_POST['updateallpackages']))
			{
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` WHERE `Task` = ' . TASK_SYSTEM_UPDATE);

				if($this->db->num_rows($Result) > 0)
				{
					self::InfoBox($lng['aps']['updatetaskexists']);
				}
				else
				{
					$this->db->query('INSERT INTO `' . TABLE_APS_TASKS . '` (`Task`, `InstanceID`) VALUES (' . TASK_SYSTEM_UPDATE . ', 0)');
					self::InfoBox($lng['aps']['updatetaskinserted']);
				}
			}
			elseif(isset($_POST['enablenewest']))
			{
				//lock alle packages, then find newerst package and enable it

				$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_LOCKED);

				//get all packages

				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` GROUP BY `Name`');

				while($Row = $this->db->fetch_array($Result))
				{
					//get newest version of package

					$NewestVersion = '';
					$NewestId = '';
					$Result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Name` = "' . $this->db->escape($Row['Name']) . '"');

					while($Row2 = $this->db->fetch_array($Result2))
					{
						if(version_compare($Row2['Version'] . '-' . $Row2['Release'], $NewestVersion) == 1)
						{
							$NewestVersion = $Row2['Version'] . '-' . $Row2['Release'];
							$NewestId = $Row2['ID'];
						}
					}

					//enable newest version

					$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_ENABLED . ' WHERE `ID` = ' . $NewestId);
				}
			}
			elseif(isset($_POST['removeunused']))
			{
				//remove all packages which have no dependencies (count of package instances = 0)

				if(isset($_POST['answer'])
				   && $_POST['answer'] == $lng['panel']['yes'])
				{
					//get all packages

					$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '`');

					while($Row = $this->db->fetch_array($Result))
					{
						//query how often package has been installed

						$Result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `PackageID` = ' . $Row['ID']);

						if($this->db->num_rows($Result2) == 0)
						{
							//remove package if number of package instances is 0

							self::UnlinkRecursive('./packages/' . $Row['Path']);
							$this->db->query('DELETE FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $Row['ID']);
						}
					}
				}
				else
				{
					//show yes/no question

					$Message = $lng['question']['reallyremovepackages'];
					$Ids = '<input type="hidden" name="removeunused" value="1"/>';
					eval("echo \"" . getTemplate("aps/askyesno") . "\";");
					$Question = true;
				}
			}
			elseif(isset($_POST['all'])
			       && $_POST['all'] == 'remove')
			{
				//remove all packages from system

				if(isset($_POST['answer'])
				   && $_POST['answer'] == $lng['panel']['yes'])
				{
					$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '`');

					//check for dependencies

					while($Row = $this->db->fetch_array($Result))
					{
						//query how often package has been installed

						$Result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `PackageID` = ' . $Row['ID']);

						if($this->db->num_rows($Result2) == 0)
						{
							//remove package if number of package instances is 0

							self::UnlinkRecursive('./packages/' . $Row['Path']);
							$this->db->query('DELETE FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $Row['ID']);
						}
					}
				}
				else
				{
					//show yes/no question

					$Message = $lng['question']['reallyremovepackages'];
					$Ids = '<input type="hidden" name="all" value="remove"/>';
					eval("echo \"" . getTemplate("aps/askyesno") . "\";");
					$Question = true;
				}
			}
			else
			{
				//no special button or "all" function has been clicked
				//continue to parse "single" options

				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '`');
				$Ids = '';

				while($Row = $this->db->fetch_array($Result))
				{
					//set new status of package (locked)

					if($Row['Status'] == PACKAGE_ENABLED
					   && isset($_POST['lock' . $Row['ID']]))
					{
						$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_LOCKED . ' WHERE `ID` = ' . $this->db->escape($Row['ID']));
					}

					//set new status of package (enabled)

					if($Row['Status'] == PACKAGE_LOCKED
					   && isset($_POST['unlock' . $Row['ID']]))
					{
						$this->db->query('UPDATE `' . TABLE_APS_PACKAGES . '` SET `Status` = ' . PACKAGE_ENABLED . ' WHERE `ID` = ' . $this->db->escape($Row['ID']));
					}

					//save id of package to remove for yes/no question

					if(isset($_POST['remove' . $Row['ID']]))
					{
						$Ids.= '<input type="hidden" name="remove' . $Row['ID'] . '" value="1"/>';

						//remove package if answer is yes

						if(isset($_POST['answer'])
						   && $_POST['answer'] == $lng['panel']['yes'])
						{
							self::UnlinkRecursive('./packages/' . $Row['Path']);
							$this->db->query('DELETE FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $Row['ID']);
						}
					}
				}

				//if there are some ids to remove, show yes/no box

				if($Ids != ''
				   && !isset($_POST['answer']))
				{
					//show yes/no question

					$Message = $lng['question']['reallyremovepackages'];
					eval("echo \"" . getTemplate("aps/askyesno") . "\";");
					$Question = true;
				}
			}
		}

		//show package overview with options

		if(!isset($_POST['save'])
		   || $Question == false)
		{
			//query all packages grouped by package name

			$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` GROUP BY `Name` ORDER BY `Name` ASC');
			$Packages = '';

			while($Row = $this->db->fetch_array($Result))
			{
				eval("\$Packages.=\"" . getTemplate("aps/manage_packages_row") . "\";");

				//get all package versions of current package

				$Result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Name` = "' . $this->db->escape($Row['Name']) . '" ORDER BY `Version` DESC, `Release` DESC');

				while($Row2 = $this->db->fetch_array($Result2))
				{
					//show package with options

					$Lock = '';
					$Unlock = '';

					if($Row2['Status'] == PACKAGE_ENABLED)
					{
						$Lock = makecheckbox('lock' . $Row2['ID'], '', '1');
					}

					if($Row2['Status'] == PACKAGE_LOCKED)
					{
						$Unlock = makecheckbox('unlock' . $Row2['ID'], '', '1');
					}

					//query how often package has been installed

					$Result3 = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `PackageID` = ' . $Row2['ID']);
					$Installations = $this->db->num_rows($Result3);

					if($Installations == 0)$Remove = makecheckbox('remove' . $Row2['ID'], '', '1');
					eval("\$Packages.=\"" . getTemplate("aps/manage_packages_detail") . "\";");
				}
			}

			if($this->db->num_rows($Result) == 0)
			{
				//no packages have been installed in system

				self::InfoBox($lng['aps']['nopackagesinsystem']);
				eval("echo \"" . getTemplate("aps/manage_packages_download") . "\";");
			}
			else
			{
				//generate some statistics

				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '`');
				$Temp = $this->db->num_rows($Result);
				$Statistics = sprintf($lng['aps']['numerofpackagesinstalled'], $this->db->num_rows($Result));
				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED);
				$Statistics.= sprintf($lng['aps']['numerofpackagesenabled'], $this->db->num_rows($Result));
				$Statistics.= sprintf($lng['aps']['numerofpackageslocked'], $Temp - $this->db->num_rows($Result));

				if((int)$this->userinfo['customers_see_all'] == 1)
				{
					$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '`');
					$Statistics.= sprintf($lng['aps']['numerofinstances'], $this->db->num_rows($Result));
				}
				else
				{
					$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` AS `i` INNER JOIN `' . TABLE_PANEL_CUSTOMERS . '` AS `c` ON `i`.`CustomerID` = `c`.`customerid` WHERE `c`.`adminid` = ' . (int)$this->userinfo['adminid']);
					$Statistics.= sprintf($lng['aps']['numerofinstances'], $this->db->num_rows($Result));
				}

				eval("echo \"" . getTemplate("aps/manage_packages") . "\";");
			}
		}
	}

	/**
	 * function provides a upload site for new packages
	 */

	private function UploadNewPackages()
	{
		global $lng, $filename, $s, $page, $action, $theme;

		//define how many files can be uploaded at once

		$Files = array();

		//define how many upload fields will be shown

		for ($i = 1;$i <= (int)$this->settings['aps']['upload_fields'];$i++)
		{
			$Files[] = 'file' . $i;
		}

		//check whether one file has been uploaded

		$FilesSet = false;
		foreach($Files as $File)
		{
			if(isset($_FILES[$File]))$FilesSet = true;
		}

		if($FilesSet == true)
		{
			//any file has been uploaded, now check for errors and parse the input

			foreach($Files as $File)
			{
				if(isset($_FILES[$File]))
				{
					$Errors = array();

					//check uploaded files against some things
					//check for filetype

					if(substr($_FILES[$File]['name'], -3) != 'zip'
					   && $_FILES[$File]['error'] == 0)
					{
						$Errors[] = $lng['aps']['notazipfile'];
					}

					//check for filesize

					if(($_FILES[$File]['size'] > self::PhpMemorySizeToBytes(ini_get('upload_max_filesize')) && $_FILES[$File]['error'] == 0)
					   || $_FILES[$File]['error'] == 1)
					{
						$Errors[] = $lng['aps']['filetoobig'];
					}

					//check is file isnt complete

					if($_FILES[$File]['error'] == 3)
					{
						$Errors[] = $lng['aps']['filenotcomplete'];
					}

					//check for other php internal errors

					if($_FILES[$File]['error'] >= 6)
					{
						$Errors[] = $lng['aps']['phperror'] . (int)$_FILES[$File]['error'];
					}

					//all checks are ok, try to install the package

					if(count($Errors) == 0
					   && $_FILES[$File]['error'] == 0)
					{
						//install package in system

						if(move_uploaded_file($_FILES[$File]['tmp_name'], './temp/' . basename($_FILES[$File]['name'])) == true)
						{
							self::InstallNewPackage('./temp/' . basename($_FILES[$File]['name']));
						}
						else
						{
							$moveproblem = str_replace('{$path}', $this->RootDir, $lng['aps']['moveproblem']);
							$Errors[] = $moveproblem;
						}
					}

					if(count($Errors) > 0)
					{
						//throw errors

						$ErrorMessage = '';
						foreach($Errors as $Error)
						{
							$ErrorMessage.= '<li>' . $Error . '</li>';
						}

						self::InfoBox(sprintf($lng['aps']['uploaderrors'], htmlspecialchars($_FILES[$File]['name']), $ErrorMessage));
					}
				}
			}
		}

		//generate upload fields

		$Output = '';
		foreach($Files as $File)
		{
			$Output.= '<input size="45" name="' . $File . '" type="file" /><br /><br />';
		}

		eval("echo \"" . getTemplate("aps/upload") . "\";");
	}

	/**
	 * function provides a frontend for customers to search packages
	 */

	private function SearchPackages()
	{
		global $lng, $filename, $s, $page, $action, $theme;
		$Error = 0;
		$Ids = array();
		$ShowAll = 0;

		if(isset($_GET['keyword'])
		   && preg_match('/^[- _0-9a-z\.,:;]+$/i', $_GET['keyword']) != false)
		{
			//split all keywords

			$Elements = preg_split('/[ ,;]/', trim($_GET['keyword']));

			if(count($Elements) == 1
			   && strlen($Elements[0]) == 0)
			{
				//no keyword given -> show all packages

				$ShowAll = 1;
			}
			else
			{
				foreach($Elements as $Key)
				{
					//skip empty values -> prevents that whitespaces lead to the result that all packages will be found

					if($Key == '')continue;
					$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' AND (`Name` LIKE "%' . $this->db->escape($Key) . '%" OR `Path` LIKE "%' . $this->db->escape($Key) . '%" OR `Version` LIKE "%' . $this->db->escape($Key) . '%") ');

					//check if keyword got a result

					if($this->db->num_rows($result) > 0)
					{
						//add all package ids which match to result array

						while($Temp = $this->db->fetch_array($result))
						{
							if(!in_array($Temp['ID'], $Ids))$Ids[] = $Temp['ID'];
						}
					}
				}

				//no matches found to given keywords

				if(count($Ids) == 0)
				{
					$Error = 2;
				}
			}
		}
		elseif(isset($_GET['keyword'])
		       && strlen($_GET['keyword']) != 0)
		{
			//input contains illegal characters

			$Error = 1;
		}
		elseif(isset($_GET['keyword'])
		       && strlen($_GET['keyword']) == 0)
		{
			//nothing has been entered - show all packages

			$ShowAll = 1;
		}

		//show errors

		if($Error == 1)
		{
			self::InfoBox($lng['aps']['nospecialchars'], 1);
		}
		elseif($Error == 2)
		{
			self::InfoBox($lng['aps']['noitemsfound']);
		}

		//show keyword only if format is ok

		$Keyword = '';

		if(isset($_GET['keyword'])
		   && $Error == 0)$Keyword = htmlspecialchars($_GET['keyword']);
		eval("echo \"" . getTemplate("aps/search") . "\";");

		//show results

		if(($Error == 0 && count($Ids) > 0)
		   || $ShowAll == 1)
		{
			//run query based on search results

			if($ShowAll != 1)
			{
				$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` IN (' . $this->db->escape(implode(',', $Ids)) . ')');
			}
			else
			{
				$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED);
			}

			//show package infos

			if($this->db->num_rows($result) > 0)
			{
				if($this->db->num_rows($result) == 1)
				{
					self::InfoBox(sprintf($lng['aps']['searchoneresult'], $this->db->num_rows($result)), 2);
				}
				else
				{
					self::InfoBox(sprintf($lng['aps']['searchmultiresult'], $this->db->num_rows($result)), 2);
				}

				while($Row = $this->db->fetch_array($result))
				{
					self::ShowPackageInfo($Row['ID']);
				}
			}
		}
	}

	/**
	 * function provides a frontend for customers to show the status of installed packages
	 *
	 * @param	customerid	id of customer from database
	 */

	private function CustomerStatus($CustomerId)
	{
		global $lng, $filename, $s, $page, $action, $theme;
		$Data = '';
		$Fieldname = '';
		$Fieldvalue = '';
		$Groupname = '';
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId));

		//customer hasnt installed any package yet

		if($this->db->num_rows($result) == 0)
		{
			self::InfoBox($lng['aps']['nopackagesinstalled']);
			return;
		}

		while($Row = $this->db->fetch_array($result))
		{
			$Data = '';
			$result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($Row['PackageID']));
			$Row2 = $this->db->fetch_array($result2);
			$Xml = self::GetXmlFromFile('./packages/' . $Row2['Path'] . '/APP-META.xml');

			//skip if parse of xml has failed

			if($Xml == false)continue;
			$Icon = 'templates/'.$theme.'/assets/img/default.png';

			$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';

			//show data and status of package

			if($this->aps_version != '1.0')
			{
				$iconpath = $Xml->presentation->icon['path'];
				$Summary = htmlspecialchars($Xml->presentation->summary);
			} 
			else
			{
				$iconpath = $Xml->icon['path'];
				$Summary = htmlspecialchars($Xml->summary);
			}

			if($iconpath)
			{
				$Icon = './packages/' . $Row2['Path'] . '/' . basename($iconpath);
			}

			$Fieldname = $lng['aps']['version'];
			$Fieldvalue = $Xml->version . ' (Release ' . $Xml->release . ')';
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			$Temp = '';

			switch($Row['Status'])
			{
				case INSTANCE_INSTALL:
					$Temp.= $lng['aps']['instance_install'];
					break;
				case INSTANCE_TASK_ACTIVE:
					$Temp.= $lng['aps']['instance_task_active'];
					break;
				case INSTANCE_SUCCESS:
					$Temp.= $lng['aps']['instance_success'];
					break;
				case INSTANCE_ERROR:
					$Temp.= $lng['aps']['instance_error'];
					break;
				case INSTANCE_UNINSTALL:
					$Temp.= $lng['aps']['instance_uninstall'];
					break;
				default:
					$Temp.= $lng['aps']['unknown_status'];
					break;
			}

			$Fieldname = $lng['aps']['currentstatus'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			$result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . $this->db->escape($Row['ID']));
			$Temp = '';

			if($this->db->num_rows($result2) > 0)
			{
				while($Row2 = $this->db->fetch_array($result2))
				{
					switch($Row2['Task'])
					{
						case TASK_INSTALL:
							$Temp.= $lng['aps']['task_install'] . '<br/>';
							break;
						case TASK_REMOVE:
							$Temp.= $lng['aps']['task_remove'] . '<br/>';
							break;
						case TASK_RECONFIGURE:
							$Temp.= $lng['aps']['task_reconfigure'] . '<br/>';
							break;
						case TASK_UPGRADE:
							$Temp.= $lng['aps']['task_upgrade'] . '<br/>';
							break;
						default:
							$Temp.= $lng['aps']['unknown_status'] . '<br/>';
							break;
					}
				}
			}
			else
			{
				$Temp.= $lng['aps']['no_task'];
			}

			$Fieldname = $lng['aps']['activetasks'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");

			//show entrypoints for application (important URLs within the application)

			if($Row['Status'] == INSTANCE_SUCCESS)
			{
				$Temp = '';

				//get domain to domain id

				$result3 = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `Name` = "main_domain" AND `InstanceID` = ' . $this->db->escape($Row['ID']));
				$Row3 = $this->db->fetch_array($result3);
				$result4 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = ' . $this->db->escape($CustomerId) . ' AND `id` = ' . $this->db->escape($Row3['Value']));
				$Row3 = $this->db->fetch_array($result4);
				$Domain = $Row3['domain'];

				//get sub location for domain

				$result5 = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `Name` = "main_location" AND `InstanceID` = ' . $this->db->escape($Row['ID']));
				$Row3 = $this->db->fetch_array($result5);
				$Location = $Row3['Value'];

				//show main site link

				if($Location == '')
				{
					$Temp.= '<a href="http://' . $Domain . '/" target="_blank">' . $lng['aps']['mainsite'] . '</a><br/>';
				}
				else
				{
					$Temp.= '<a href="http://' . $Domain . '/' . $Location . '/" target="_blank">' . $lng['aps']['mainsite'] . '</a><br/>';
				}

				//show other links from meta data

				if($Xml->{'entry-points'})
				{
					foreach($Xml->{'entry-points'}->entry as $Entry)
					{
						if($Location == '')
						{
							$Temp.= '<a href="http://' . $Domain . $Entry->path . '" target="_blank">' . $Entry->label . '</a><br/>';
						}
						else
						{
							$Temp.= '<a href="http://' . $Domain . '/' . $Location . $Entry->path . '" target="_blank">' . $Entry->label . '</a><br/>';
						}
					}
				}

				$Fieldname = $lng['aps']['applicationlinks'];
				$Fieldvalue = $Temp;
				eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			}

			eval("echo \"" . getTemplate("aps/package_status") . "\";");
			unset($Xml);
		}
	}

	/**
	 * function creates a new instance of a package based on the installer data
	 *
	 * @param	packageid	id of package from database
	 * @param	customerid	id of customer from database
	 * @return	success true/error false
	 */

	private function CreatePackageInstance($PackageId, $CustomerId)
	{
		global $lng, $theme;

		if(!self::IsValidPackageId($PackageId, true))return false;

		//has user pressed F5/reload?

		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId));

		if($this->db->num_rows($result) == 0)
		{
			self::InfoBox($lng['aps']['erroronnewinstance'], 1);
			return false;
		}

		//get path to package xml file

		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($PackageId));
		$Row = $this->db->fetch_array($result);
		$Xml = self::GetXmlFromFile('./packages/' . $Row['Path'] . '/APP-META.xml');

		//return if parse of xml file has failed

		if($Xml == false)return false;

		//add new instance

		$this->db->query('INSERT INTO `' . TABLE_APS_INSTANCES . '` (`CustomerID`, `PackageID`, `Status`) VALUES (' . $this->db->escape($CustomerId) . ', ' . $this->db->escape($PackageId) . ', ' . INSTANCE_INSTALL . ')');
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `PackageID` = ' . $this->db->escape($PackageId) . ' AND `Status` = ' . INSTANCE_INSTALL . ' ORDER BY ID DESC');
		$Row = $this->db->fetch_array($result);

		//copy & delete temporary data

		$this->db->query('INSERT INTO `' . TABLE_APS_SETTINGS . '` (`InstanceID`, `Name`, `Value`) SELECT ' . $this->db->escape($Row['ID']) . ' AS `InstanceID`, `Name`, `Value` FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `PackageID` = ' . $this->db->escape($PackageId));
		$this->db->query('DELETE FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `PackageID` = ' . $this->db->escape($PackageId));

		//add task for installation

		$this->db->query('INSERT INTO `' . TABLE_APS_TASKS . '` (`InstanceID`, `Task`) VALUES(' . $this->db->escape($Row['ID']) . ', ' . TASK_INSTALL . ')');

		//update used counter for packages

		$this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `aps_packages_used` = `aps_packages_used` + 1 WHERE `customerid` = ' . (int)$CustomerId);
		self::InfoBox(sprintf($lng['aps']['successonnewinstance'], $Xml->name), 2);
		unset($Xml);
	}

	/**
	 * convert human readable memory sizes into bytes
	 *
	 * @param	value		ini_get() formated memory size
	 * @return	memory size in bytes
	 */

	private function PhpMemorySizeToBytes($Value)
	{
		//convert memory formats from php.ini to a integer value in bytes

		$Value = trim($Value);
		$Last = strtolower($Value{strlen($Value) - 1});

		switch($Last)
		{
			case 'g':
				$Value*= 1024;
			case 'm':
				$Value*= 1024;
			case 'k':
				$Value*= 1024;
		}

		return $Value;
	}

	/**
	 * convert php.ini formated strings into true and false as a string
	 *
	 * @param	value		value to read from php.ini (format: safe_mode or safe-mode)
	 * @return	(true|false) as string
	 */

	private function TrueFalseIniGet($Value)
	{
		//convert php.ini values to true and false as string

		$Value = ini_get(str_replace(array('-'), array('_'), $Value));

		if($Value == 0
		   || $Value == false
		   || $Value == 'off')
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
	}

	/**
	 * packages can fail during the validation process. this function allows to check for exceptions
	 *
	 * @param	category		category as string to check
	 * @param	item			item within category to check
	 * @return	success true (value has exception) / error false (value has no exception)
	 */

	private function CheckException($Category, $Item, $Value)
	{
		global $settings, $theme;

		//search for element within system settings

		$Elements = explode(',', $settings['aps'][$Category . '-' . $Item]);
		foreach($Elements as $Element)
		{
			if(strtolower($Element) == strtolower($Value))return true;
		}

		return false;
	}

	/**
	 * packages must be validated within the submappings of a filesystem structure
	 *
	 * @param	parentmapping	instance of parsed xml file, current mapping position
	 * @param	url				relative path for application specifying the current path within the mapping tree
	 * @return	array with errors found, optional empty when no errors were found
	 */

	private function CheckSubmappings($ParentMapping, $Url)
	{
		global $lng, $theme;
		$Error = array();

		//check for special PHP handler extensions

		$XmlPhpMapping = $ParentMapping->children('http://apstandard.com/ns/1/php');
		foreach($XmlPhpMapping->handler as $Handler)
		{
			if(isset($Handler->extension[0])
			   && strval($Handler->extension[0]) != 'php')
			{
				$Error[] = $lng['aps']['php_misc_handler'];
			}

			if(isset($Handler->disabled))
			{
				$Error[] = $lng['aps']['php_misc_directoryhandler'];
			}
		}

		//check for special ASP.NET url handler within mappings

		$XmlAspMapping = $ParentMapping->children('http://apstandard.com/ns/1/aspnet');

		if($XmlAspMapping->handler)
		{
			$Error[] = $lng['aps']['asp_net'];
		}

		//check for special CGI url handlers within mappings

		/**
		 * as of 0.9.13 we can handle CGI ;-), #404
		 *
		$XmlCgiMapping = $ParentMapping->children('http://apstandard.com/ns/1/cgi');
		if($XmlCgiMapping->handler) {
			$Error[] = $lng['aps']['cgi'];
		}
		*/

		//resolve deeper mappings

		foreach($ParentMapping->mapping as $Mapping)
		{
			$Return = array();

			//recursive check of other mappings

			if($Url == '/')
			{
				$Return = self::CheckSubmappings($Mapping, $Url . $Mapping['url']);
			}
			else
			{
				$Return = self::CheckSubmappings($Mapping, $Url . '/' . $Mapping['url']);
			}

			//if recursive checks found errors, attach them

			if(count($Return) != 0)
			{
				foreach($Return as $Value)
				{
					if(!in_array($Value, $Error))$Error[] = $Value;
				}
			}
		}

		return $Error;
	}

	/**
	 * function validates a package against a lot of options and installs it if all conditions have succeeded
	 *
	 * @param	filename		path to zipfile to install
	 */

	private function InstallNewPackage($Filename)
	{
		global $lng, $userinfo, $theme;

		if(file_exists($Filename)
		   && $Xml = self::GetXmlFromZip($Filename))
		{
			$Error = array();

			$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';

			//check alot of stuff if package is supported
			//php modules

			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$XmlPhp = $Xml->requirements->children('http://apstandard.com/ns/1/php');
			} 
			else 
			{
				// since 1.1
				$Xml->registerXPathNamespace('php', 'http://apstandard.com/ns/1/php');

				$XmlPhp = new DynamicProperties;
				$XmlPhp->extension = getXPathValue($Xml, '//php:extension', false);
				$XmlPhp->function = getXPathValue($Xml, '//php:function', false);
			}

			if($XmlPhp->extension)
			{
				$ExtensionsLoaded = get_loaded_extensions();
				foreach($XmlPhp->extension as $Extension)
				{
					if(strtolower($Extension) == 'php')
					{
						continue;
					}

					if(!in_array($Extension, $ExtensionsLoaded)
					   && !self::CheckException('php', 'extension', $Extension))
					{
						$Error[] = sprintf($lng['aps']['php_extension'], $Extension);
					}
				}
			}

			//php functions

			if($XmlPhp->function)
			{
				foreach($XmlPhp->function as $Function)
				{
					if(!function_exists($Function)
					   && !self::CheckException('php', 'function', $Function))
					{
						$Error[] = sprintf($lng['aps']['php_function'], $Function);
					}
				}
			}

			//php values

			$PhpValues = array(
				'short-open-tag',
				'file-uploads',
				'magic-quotes-gpc',
				'register-globals',
				'allow-url-fopen',
				'safe-mode'
			);
			foreach($PhpValues as $Value)
			{
				if ($this->aps_version != '1.0')
				{
					$XmlPhp->{$Value} = getXPathValue($Xml, '//php:'.$Value);
				}

				if($XmlPhp->{$Value})
				{
					if(self::TrueFalseIniGet($Value) != $XmlPhp->{$Value}
					   && !self::CheckException('php', 'configuration', str_replace(array('-'), array('_'), $Value)))
					{
						$Error[] = sprintf($lng['aps']['php_configuration'], str_replace(array('-'), array('_'), $Value));
					}
				}
			}

			if ($this->aps_version != '1.0')
			{
				$XmlPhp->{'post-max-size'} = getXPathValue($Xml, '//php:post-max-size');
			}

			if($XmlPhp->{'post-max-size'})
			{
				if(self::PhpMemorySizeToBytes(ini_get('post_max_size')) < intval($XmlPhp->{'post-max-size'})
				   && !self::CheckException('php', 'configuration', 'post_max_size'))
				{
					$Error[] = $lng['aps']['php_configuration_post_max_size'];
				}
			}

			if ($this->aps_version != '1.0')
			{
				$XmlPhp->{'memory-limit'} = getXPathValue($Xml, '//php:memory-limit');
			}

			if($XmlPhp->{'memory-limit'})
			{
				if(self::PhpMemorySizeToBytes(ini_get('memory_limit')) < intval($XmlPhp->{'memory-limit'})
				   && !self::CheckException('php', 'configuration', 'memory_limit'))
				{
					$Error[] = $lng['aps']['php_configuration_memory_limit'];
				}
			}

			if ($this->aps_version != '1.0')
			{
				$XmlPhp->{'max-execution-time'} = getXPathValue($Xml, '//php:max-execution-time');
			}

			if($XmlPhp->{'max-execution-time'})
			{
				if(ini_get('max_execution_time') < intval($XmlPhp->{'max-execution-time'})
				   && !self::CheckException('php', 'configuration', 'max_execution_time'))
				{
					$Error[] = $lng['aps']['php_configuration_max_execution_time'];
				}
			}

			//php version
			//must be done with xpath otherwise check not possible (XML parser problem with attributes)

			$Xml->registerXPathNamespace('phpversion', 'http://apstandard.com/ns/1/php');
			$Result = $Xml->xpath('//phpversion:version');

			if(isset($Result[0]['min']))
			{
				if(version_compare($Result[0]['min'], PHP_VERSION) == 1)
				{
					$Error[] = $lng['aps']['php_general_old'];
				}
			}

			if(isset($Result[0]['max-not-including']))
			{
				if(version_compare($Result[0]['max-not-including'], PHP_VERSION) == - 1)
				{
					$Error[] = $lng['aps']['php_general_new'];
				}
			}

			//database

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
				$XmlDb->db->{'server-type'} = getXPathValue($Xml, '//db:server-type');
				$XmlDb->db->{'server-min-version'} = getXPathValue($Xml, '//db:server-min-version');
			}

			if($XmlDb->db->id)
			{
				if($XmlDb->db->{'server-type'} != 'mysql')
				{
					$Error[] = $lng['aps']['db_mysql_support'];
				}

				if(version_compare($XmlDb->db->{'server-min-version'}, mysql_get_server_info()) == 1)
				{
					$Error[] = $lng['aps']['db_mysql_version'];
				}
			}

			//ASP.NET

			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$XmlAsp = $Xml->requirements->children('http://apstandard.com/ns/1/aspnet');
			} 
			else 
			{
				// since 1.1
				$Xml->registerXPathNamespace('aspnet', 'http://apstandard.com/ns/1/aspnet');

				$XmlAsp = new DynamicProperties;
				$XmlAsp->handler = getXPathValue($Xml, '//aspnet:handler');
				$XmlAsp->permissions = getXPathValue($Xml, '//aspnet:permissions');
				$XmlAsp->version = getXPathValue($Xml, '//aspnet:version');
			}

			if($XmlAsp->handler
			   || $XmlAsp->permissions
			   || $XmlAsp->version)
			{
				$Error[] = $lng['aps']['asp_net'];
			}

			//CGI
			/**
			 * as of 0.9.13 we can handle CGI ;-), #404
			 *
			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$XmlCgi = $Xml->requirements->children('http://apstandard.com/ns/1/cgi');
			} 
			else 
			{
				// since 1.1
				$Xml->registerXPathNamespace('cgi', 'http://apstandard.com/ns/1/cgi');

				$XmlCgi = new DynamicProperties;
				$XmlCgi->handler = getXPathValue($Xml, '//cgi:handler');
			}

			if($XmlCgi->handler)
			{
				$Error[] = $lng['aps']['cgi'];
			}
			*/

			//webserver modules

			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$XmlWebserver = $Xml->requirements->children('http://apstandard.com/ns/1/apache');
			} 
			else
			{
				// since 1.1
				$Xml->registerXPathNamespace('apache', 'http://apstandard.com/ns/1/apache');

				$XmlWebserver = new DynamicProperties;
				$XmlWebserver->{'required-module'} = getXPathValue($Xml, '//apache:required-module');
				$XmlWebserver->htaccess = getXPathValue($Xml, '//apache:htaccess');
			}

			if($XmlWebserver->{'required-module'})
			{
				if(function_exists('apache_get_modules'))
				{
					$ModulesLoaded = apache_get_modules();
					foreach($XmlWebserver->{'required-module'} as $Module)
					{
						if(!in_array($Module, $ModulesLoaded)
						   && !self::CheckException('webserver', 'module', $Module))
						{
							$Error[] = sprintf($lng['aps']['webserver_module'], $Module);
						}
					}
				}
				else
				{
					if(!self::CheckException('webserver', 'module', 'fcgid-any'))$Error[] = $lng['aps']['webserver_fcgid'];
				}
			}

			//webserver .htaccess

			if($XmlWebserver->htaccess
			   && !self::CheckException('webserver', 'htaccess', 'htaccess'))
			{
				$Error[] = $lng['aps']['webserver_htaccess'];
			}

			//configuration script check

			if($Xml->{'configuration-script-language'}
			   && $Xml->{'configuration-script-language'} != 'php')
			{
				$Error[] = $lng['aps']['misc_configscript'];
			}

			//validation against a charset not possible in current version

			if ($this->aps_version == '1.0')
			{
				// the good ole way
				$aps_settings_array = $Xml->settings->group;
			} 
			else
			{
				// since 1.1
				$aps_settings_array = $Xml->{'global-settings'}->setting;
				if(!is_array($aps_settings_array)) {
					$aps_settings_array = $Xml->service->settings->group;
				}
			}
			
			foreach($aps_settings_array as $Group)
			{
				foreach($Group->setting as $Setting)
				{
					if($Setting['type'] == 'string'
					   || $Setting['type'] == 'password')
					{
						if(isset($Setting['charset']))
						{
							if(!in_array($lng['aps']['misc_charset'], $Error))$Error[] = $lng['aps']['misc_charset'];
						}
					}
				}
			}

			//check different errors/features in submappings

			if ($this->aps_version == '1.0')
			{			
				$Return = self::CheckSubmappings($Xml->mapping, $Xml->mapping['url']);

				if(count($Return) != 0)
				{
					foreach($Return as $Value)
					{
						if(!in_array($Value, $Error))$Error[] = $Value;
					}
				}
			}

			//check already installed versions

			$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Name` = "' . $this->db->escape($Xml->name) . '"');
			$Newer = 0;

			if($this->db->num_rows($result) > 0)
			{
				while($Row = $this->db->fetch_array($result))
				{
					//package is newer, install package as a update

					if(version_compare($Row['Version'] . '-' . $Row['Release'], $Xml->version . '-' . $Xml->release) == - 1)
					{
						$Newer = 1;
					}

					//package is installed already with same version, cancel installation

					if(version_compare($Row['Version'] . '-' . $Row['Release'], $Xml->version . '-' . $Xml->release) == 0)
					{
						$Error[] = $lng['aps']['misc_version_already_installed'];
						break;
					}

					//package is older than the one which is installed already, cancel installation

					if(version_compare($Row['Version'] . '-' . $Row['Release'], $Xml->version . '-' . $Xml->release) == 1)
					{
						$Error[] = $lng['aps']['misc_only_newer_versions'];
						break;
					}
				}
			}

			if(count($Error) > 0)
			{
				//show errors

				$Output = '';
				foreach($Error as $Entry)
				{
					$Output.= '<li>' . $Entry . '</li>';
				}

				self::InfoBox(sprintf($lng['aps']['erroronscan'], $Xml->name, $Output), 1);
				return false;
			}
			else
			{
				//install package in system, all checks succeeded

				$Destination = './packages/' . basename($Filename) . '/';

				//create package directory

				if(!file_exists($Destination))mkdir($Destination, 0777, true);

				//copy xml meta data

				self::GetContentFromZip($Filename, 'APP-META.xml', $Destination . 'APP-META.xml');

				//copy screenshots
				
				if ($this->aps_version != '1.0')
				{
					$xml_screenshots = $Xml->presentation->screenshot;;
				}
				else
				{
					$xml_screenshots = $Xml->screenshot;
				}
				

				if($xml_screenshots)
				{
					foreach($xml_screenshots as $Screenshot)
					{
						self::GetContentFromZip($Filename, $Screenshot['path'], $Destination . basename($Screenshot['path']));
					}
				}

				//copy icon
				
				if ($this->aps_version != '1.0')
				{
					$xml_iconpath = $Xml->presentation->icon['path'];
				}
				else
				{
					$xml_iconpath = $Xml->icon['path'];
				}

				if($xml_iconpath)
				{
					self::GetContentFromZip($Filename, $xml_iconpath, $Destination . basename($xml_iconpath));
				}

				//copy license
				
				if ($this->aps_version != '1.0')
				{
					$xml_license = $Xml->service->license;
				}
				else
				{
					$xml_license = $Xml->license;
				}				
				

				if($xml_license
				   && $xml_license->text->file)
				{
					self::GetContentFromZip($Filename, $xml_license->text->file, $Destination . 'license.txt');
				}

				//insert package to database

				$this->db->query('INSERT INTO `' . TABLE_APS_PACKAGES . '` (`Path`, `Name`, `Version`, `Release`, `Status`) VALUES ("' . $this->db->escape(basename($Filename)) . '", "' . $this->db->escape($Xml->name) . '", "' . $this->db->escape($Xml->version) . '", ' . $this->db->escape($Xml->release) . ', ' . PACKAGE_LOCKED . ')');

				//copy zipfile do destination

				copy($Filename, $Destination . basename($Filename));
				unlink($Filename);

				//show some feedback messages to admin

				if($Newer == 1)
				{
					self::InfoBox(sprintf($lng['aps']['successpackageupdate'], $Xml->name), 2);
				}
				else
				{
					self::InfoBox(sprintf($lng['aps']['successpackageinstall'], $Xml->name), 2);
				}

				unset($Xml);
				return true;
			}
		}
		else
		{
			//file cannot be unzipped or parse of xml data has failed

			self::InfoBox(sprintf($lng['aps']['invalidzipfile'], basename($Filename)));
			return false;
		}
	}

	/**
	 * main function of the class, provides all of the aps installer frontend
	 */

	public function MainHandler($Action)
	{
		global $lng, $filename, $s, $page, $action, $Id, $userinfo, $theme;

		//check for basic functions, classes and permissions

		$Error = '';

		if(!class_exists('SimpleXMLElement')
		   || !function_exists('zip_open'))
		{
			$Error.= '<li>' . $lng['aps']['class_zip_missing'] . '</li>';
		}

		if(!is_writable($this->RootDir.'temp/')
		   || !is_writable($this->RootDir.'packages/'))
		{
			$dirpermission = str_replace('{$path}', $this->RootDir, $lng['aps']['dir_permissions']);
			$Error.= '<li>' . $dirpermission . '</li>';
		}

		if($Error != '')
		{
			//show different error to customer and admin

			if(!isset($this->userinfo['customerid']))
			{
				self::InfoBox(sprintf($lng['aps']['initerror'], $Error), 1);
			}
			else
			{
				self::InfoBox($lng['aps']['initerror_customer'], 1);
			}

			return;
		}

		if(isset($this->userinfo['customerid']))
		{		
			$CustomerId = $this->userinfo['customerid'];
		}
		else
		{
			$CustomerId = -1;
		}
		$AdminId = $this->userinfo['adminid'];
		$PackagesPerSite = $this->settings['aps']['items_per_page'];

		//run different functions based on action

		if($Action == 'install')
		{
			//check for valid package id

			if(self::IsValidPackageId($Id, true))
			{
				//installation data is given

				if(isset($_POST['withinput']))
				{
					$Errors = self::ValidatePackageData($Id, $CustomerId);

					//if there are no input errors, create a new instance

					if(count($Errors) == 0)
					{
						self::CreatePackageInstance($Id, $CustomerId);
					}
					else
					{
						self::ShowPackageInstaller($Id, $Errors, $CustomerId);
					}
				}
				else
				{
					//empty array -> no errors will be shown to customer

					$Errors = array();
					self::ShowPackageInstaller($Id, $Errors, $CustomerId);
				}
			}
			else
			{
				self::InfoBox($lng['aps']['iderror']);
			}
		}
		elseif($Action == 'remove')
		{
			//check for valid instance id

			if(self::IsValidInstanceId($Id, $CustomerId))
			{
				//customer has clicked yes to uninstall a package

				if(isset($_POST['answer'])
				   && $_POST['answer'] == $lng['panel']['yes'])
				{
					//check if there is already an task

					$result = $this->db->query('SELECT * FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . $this->db->escape($Id) . ' AND `Task` = ' . TASK_REMOVE);

					if($this->db->num_rows($result) > 0)
					{
						self::InfoBox($lng['aps']['removetaskexisting']);
					}
					else
					{
						//remove package, no task existing

						$this->db->query('INSERT INTO `' . TABLE_APS_TASKS . '` (`InstanceID`, `Task`) VALUES (' . (int)$Id . ', ' . TASK_REMOVE . ')');
						$this->db->query('UPDATE `' . TABLE_APS_INSTANCES . '` SET `Status` = ' . INSTANCE_UNINSTALL . ' WHERE `ID` = ' . (int)$Id);
						$this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `aps_packages_used` = `aps_packages_used` - 1 WHERE `customerid` = ' . (int)$CustomerId);
						self::InfoBox($lng['aps']['packagewillberemoved']);
					}
				}
				else
				{
					//show yes/no question

					$Message = $lng['question']['reallywanttoremove'];
					$action_alt = 'customerstatus';
					$Ids = '<input type="hidden" name="id" value="' . (int)$Id . '"/>';
					eval("echo \"" . getTemplate("aps/askyesno") . "\";");
				}
			}
			else
			{
				self::InfoBox($lng['aps']['iderror']);
			}
		}
		elseif($Action == 'stopinstall')
		{
			//check for valid instance id

			if(self::IsValidInstanceId($Id, $CustomerId))
			{
				//check if application installation runs already

				$Result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `ID` = ' . $this->db->escape($Id));
				$Row = $this->db->fetch_array($Result);

				if($Row['Status'] == INSTANCE_TASK_ACTIVE)
				{
					self::InfoBox($lng['aps']['installstoperror']);
				}
				else
				{
					if(isset($_POST['answer'])
					   && $_POST['answer'] == $lng['panel']['yes'])
					{
						//remove task

						$this->db->query('DELETE FROM `' . TABLE_APS_TASKS . '` WHERE `InstanceID` = ' . $this->db->escape($Id));

						//remove settings

						$this->db->query('DELETE FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Id));

						//remove instance

						$this->db->query('DELETE FROM `' . TABLE_APS_INSTANCES . '` WHERE `ID` = ' . $this->db->escape($Id));

						//update used counter

						$this->db->query('UPDATE `' . TABLE_PANEL_CUSTOMERS . '` SET `aps_packages_used` = `aps_packages_used` - 1 WHERE `customerid` = ' . (int)$CustomerId);
						self::InfoBox($lng['aps']['installstopped']);
					}
					else
					{
						//show yes/no question

						$Message = $lng['question']['reallywanttostop'];
						$action_alt = 'customerstatus';
						$Ids = '<input type="hidden" name="id" value="' . (int)$Id . '"/>';
						eval("echo \"" . getTemplate("aps/askyesno") . "\";");
					}
				}
			}
			else
			{
				self::InfoBox($lng['aps']['iderror']);
			}
		}
		elseif($Action == 'reconfigure')
		{
			//check for valid instance id

			if(self::IsValidInstanceId($Id, $CustomerId))
			{
				self::InfoBox('Reconfigure function not implemented in current version!');
			}
			else
			{
				self::InfoBox($lng['aps']['iderror']);
			}
		}
		elseif($Action == 'details')
		{
			//show advanced package infos if package id is valid

			if(self::IsValidPackageId($Id, true))
			{
				self::ShowPackageInfo($Id, true);
			}
			else
			{
				self::InfoBox($lng['aps']['iderror']);
			}
		}
		elseif($Action == 'scan'
		       && !isset($this->userinfo['customerid']))
		{
			//find all files in temp directory

			$Files = scandir('./temp/');
			$Counter = 0;
			foreach($Files as $File)
			{
				//skip invalid "files"

				if(substr($File, -4) != '.zip')continue;

				//install new package in system

				self::InstallNewPackage('./temp/' . $File);
				$Counter+= 1;
			}

			if($Counter == 0)
			{
				//throw error if no file was found

				self::InfoBox($lng['aps']['nopacketsforinstallation']);
			}
		}
		elseif($Action == 'manageinstances'
		       && !isset($this->userinfo['customerid']))
		{
			self::ManageInstances();
		}
		elseif($Action == 'managepackages'
		       && !isset($this->userinfo['customerid']))
		{
			self::ManagePackages();
		}
		elseif($Action == 'upload'
		       && !isset($this->userinfo['customerid']))
		{
			self::UploadNewPackages();
		}
		elseif($Action == 'customerstatus')
		{
			self::CustomerStatus($CustomerId);
		}
		elseif($Action == 'search')
		{
			self::SearchPackages();
		}
		elseif($Action == 'overview')
		{
			// show packages with paging

			if(isset($_GET['page'])
			   && preg_match('/^[0-9]+$/', $_GET['page']) != - 1)
			{
				//check if page parameter is valid
				//get all packages to find out how many pages are needed

				$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC');
				$Pages = intval($this->db->num_rows($result) / $PackagesPerSite);

				if(($this->db->num_rows($result) / $PackagesPerSite) > $Pages)$Pages+= 1;

				if($_GET['page'] >= 1
				   && $_GET['page'] <= $Pages)
				{
					//page parameter is within available pages, now show packages for that given page

					$result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC LIMIT ' . $this->db->escape((intval($_GET['page']) - 1) * $PackagesPerSite) . ', ' . $this->db->escape($PackagesPerSite));

					//show packages

					while($Row3 = $this->db->fetch_array($result2))
					{
						self::ShowPackageInfo($Row3['ID']);
					}

					//show URLs for other pages

					if($Pages > 1)
					{
						echo ('<div style="width: 90%; text-align: center;"><br/>');
						for ($i = 1;$i < $Pages + 1;$i++)
						{
							if($i == $_GET['page'])
							{
								echo ('<span class="pageitem">' . $i . '</span>&nbsp;');
							}
							else
							{
								echo ('<span class="pageitem"><a href="' . $filename . '?s=' . $s . '&amp;action=overview&amp;page=' . $i . '">' . $i . '</a></span>&nbsp;');
							}
						}

						echo ('</div><br/><br/>');
					}
				}
				else
				{
					//page parameter isnt within available pages, show packages from first page

					$result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC LIMIT 0, ' . $this->db->escape($PackagesPerSite));

					//show packages

					while($Row3 = $this->db->fetch_array($result2))
					{
						self::ShowPackageInfo($Row3['ID']);
					}

					//fetch number of packages to calculate the number of pages

					$result3 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC');
					$Pages = intval($this->db->num_rows($result3) / $PackagesPerSite);

					if(($this->db->num_rows($result3) / $PackagesPerSite) > $Pages)$Pages+= 1;

					//show URLs for other pages

					if($Pages > 1)
					{
						echo ('<div style="width: 90%; text-align: center;"><br/>');
						for ($i = 1;$i < $Pages + 1;$i++)
						{
							echo ('<span class="pageitem"><a href="' . $filename . '?s=' . $s . '&amp;action=overview&amp;page=' . $i . '">' . $i . '</a></span>&nbsp;');
						}

						echo ('</div>');
					}
				}
			}
			else
			{
				//page parameter isnt valid, show packages from first page

				$result2 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC LIMIT 0, ' . $this->db->escape($PackagesPerSite));

				if($this->db->num_rows($result2) == 0)
				{
					self::InfoBox($lng['aps']['nopackagestoinstall']);
					return;
				}

				// no more contingent, #278
				if($userinfo['aps_packages'] == $userinfo['aps_packages_used'] 
					&& $userinfo['aps_packages'] != '-1'
				){
					self::InfoBox($lng['aps']['nocontingent']);
				}

				//show packages

				while($Row3 = $this->db->fetch_array($result2))
				{
					self::ShowPackageInfo($Row3['ID']);
				}

				//fetch number of packages to calculate number of pages

				$result3 = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' ORDER BY `Name` ASC');
				$Pages = intval($this->db->num_rows($result3) / $PackagesPerSite);

				if(($this->db->num_rows($result3) / $PackagesPerSite) > $Pages)$Pages+= 1;

				//show URLs for other pages

				if($Pages > 1)
				{
					echo ('<div style="width: 90%; text-align: center;"><br/>');
					for ($i = 1;$i < $Pages + 1;$i++)
					{
						if($i == 1)
						{
							echo ('<span class="pageitem">' . $i . '</span>');
						}
						else
						{
							echo ('<span class="pageitem"><a href="' . $filename . '?s=' . $s . '&amp;action=overview&amp;page=' . $i . '">' . $i . '</a></span>');
						}
					}

					echo ('</div><br/><br/>');
				}
			}
		}
	}

	/**
	 * function extracts resources from a zipfile to return or save them on disk
	 *
	 * @param	filename		zipfile to read data from
	 * @param	file			file within zip archive to read
	 * @param	destination		optional parameter where to save file from within the zip file
	 * @return	success content of file from zip archive / error false
	 */

	private function GetContentFromZip($Filename, $File, $Destination = '')
	{
		if(!file_exists($Filename))return false;
		$Content = '';

		//now using the new ZipArchive class from php 5.2

		$Zip = new ZipArchive;
		$Resource = $Zip->open(realpath($Filename));

		if($Resource === true)
		{
			$FileHandle = $Zip->getStream($File);

			if(!$FileHandle)return false;

			while(!feof($FileHandle))
			{
				$Content.= fread($FileHandle, 8192);
			}

			fclose($FileHandle);
			$Zip->close();
		}
		else
		{
			//on 64 bit systems the zip functions can fail -> use safe_exec to extract the files

			$ReturnLines = array();
			$ReturnVal = - 1;
			$ReturnLines = safe_exec('unzip -o -j -qq ' . escapeshellarg(realpath($Filename)) . ' ' . escapeshellarg($File) . ' -d ' . escapeshellarg(sys_get_temp_dir() . '/'), $ReturnVal);

			if($ReturnVal == 0)
			{
				$Content = file_get_contents(sys_get_temp_dir() . '/' . basename($File));
				unlink(sys_get_temp_dir() . '/' . basename($File));

				if($Content == false)return false;
			}
			else
			{
				return false;
			}
		}

		//return content of file from within the zipfile or save to disk

		if($Content == '')
		{
			return false;
		}
		else
		{
			if($Destination == '')
			{
				return $Content;
			}
			else
			{
				//open file and save content

				$File = fopen($Destination, "wb");

				if($File)
				{
					fwrite($File, $Content);
					fclose($File);
				}
				else
				{
					return false;
				}
			}
		}
	}

	/**
	 * fetches the xml metafile from a zipfile and returns the parsed data
	 *
	 * @param	filename		zipfile containing the xml meta data
	 * @return	success parsed xml content of zipfile / error false
	 */

	private function GetXmlFromZip($Filename)
	{
		if(!file_exists($Filename))return false;

		//get content for xml meta data file from within the zipfile

		if($XmlContent = self::GetContentFromZip($Filename, 'APP-META.xml'))
		{
			//parse xml content

			$Xml = new SimpleXMLElement($XmlContent);
			return $Xml;
		}
		else
		{
			return false;
		}
	}

	/**
	 * reads the content of a xml metafile from disk and returns the parsed data
	 *
	 * @param	filename		xmlfile to parse
	 * @return	success parsed xml content of file / error false
	 */

	private function GetXmlFromFile($Filename)
	{
		//read xml file from disk and return parsed data

		if(!file_exists($Filename))return false;
		$XmlContent = file_get_contents($Filename);
		$Xml = new SimpleXMLElement($XmlContent);
		return $Xml;
	}

	/**
	 * check whether a given package id is valid
	 *
	 * @param	packageid		id of package from database to check vor validity
	 * @param	customer		check if package can be used by customer and/or admin [true|false]
	 * @return	success valid package id (id > 0 based on database layout) / error false
	 */

	private function IsValidPackageId($PackageId, $Customer)
	{
		if(preg_match('/^[0-9]+$/', $PackageId) != 1)return false;

		if($Customer == true)
		{
			//customers can only see packages which are enabled

			$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `Status` = ' . PACKAGE_ENABLED . ' AND `ID` = ' . $this->db->escape($PackageId));

			if($this->db->num_rows($result) > 0)
			{
				return $PackageId;
			}
			else
			{
				return false;
			}
		}
		else
		{
			//admins can see all packages

			$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($PackageId));

			if($this->db->num_rows($result) > 0)
			{
				return $PackageId;
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 * check whether a given instance id is valid
	 *
	 * @param	packageid		id of instance from database to check vor validity
	 * @return	success valid instance id (id > 0 based on database layout) / error false
	 */

	private function IsValidInstanceId($InstanceId, $CustomerId)
	{
		if(preg_match('/^[0-9]+$/', $InstanceId) != 1)return false;
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `ID` = ' . $this->db->escape($InstanceId));

		if($this->db->num_rows($result) > 0)
		{
			return $InstanceId;
		}
		else
		{
			return false;
		}
	}

	/**
	 * save installation values fetched from the installation wizard
	 *
	 * @param	packageid		id of package from database
	 * @param	customerid		id of customer for who the values should be saved
	 * @param	name			name of field to save
	 * @param	value			value to save for previously given name
	 */

	private function SetInstallationValue($PackageId, $CustomerId, $Name, $Value)
	{
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `PackageID` = ' . $this->db->escape($PackageId) . ' AND `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `Name` = "' . $this->db->escape($Name) . '"');

		if($this->db->num_rows($result) == 0)
		{
			$this->db->query('INSERT INTO `' . TABLE_APS_TEMP_SETTINGS . '` (`PackageID`, `CustomerID`, `Name`, `Value`) VALUES (' . $this->db->escape($PackageId) . ', ' . $this->db->escape($CustomerId) . ', "' . $this->db->escape($Name) . '", "' . $this->db->escape($Value) . '")');
		}
		else
		{
			$Row = $this->db->fetch_array($result);
			$this->db->query('UPDATE `' . TABLE_APS_TEMP_SETTINGS . '` SET `PackageID` = ' . $this->db->escape($PackageId) . ', `CustomerID` = ' . $this->db->escape($CustomerId) . ', `Name` = "' . $this->db->escape($Name) . '", `Value` ="' . $this->db->escape($Value) . '" WHERE `ID` = ' . $this->db->escape($Row['ID']));
		}
	}

	/**
	 * return previously saved installation values
	 *
	 * @param	packageid		id of package from database
	 * @param	customerid		id of customer for who the values should be read
	 * @param	name			name of field to read
	 * @return	success value of field from database / error false
	 */

	private function GetInstallationValue($PackageId, $CustomerId, $Name)
	{
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `PackageID` = ' . $this->db->escape($PackageId) . ' AND `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `Name` = "' . $this->db->escape($Name) . '"');

		if($this->db->num_rows($result) == 0)
		{
			return false;
		}
		else
		{
			$Row = $this->db->fetch_array($result);
			return $Row['Value'];
		}
	}
	
	/**
	 * return setting value for a given Instance
	 *
	 * @param	instanceid		id of APS Instance from database
	 * @param	name			name of field to read
	 * @return	success value of field from database / error false
	 */

	private function GetSettingValue($InstanceId, $Name)
	{
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($InstanceId) . ' AND `Name` = "' . $this->db->escape($Name) . '"');

		if($this->db->num_rows($result) == 0)
		{
			return false;
		}
		else
		{
			$Row = $this->db->fetch_array($result);
			return $Row['Value'];
		}
	}
	/**
	 * fix a path given by the customer
	 *
	 * @param	path		path which could be compromised
	 * @return	corrected path
	 */

	private function MakeSecurePath($path)
	{
		//code based on syscp core code

		$search = Array(
			'#/+#',
			'#\.+#',
			'#\0+#',
			'#\\\\+#'
		);
		$replace = Array(
			'/',
			'',
			'',
			'/'
		);
		$path = preg_replace($search, $replace, $path);

		//no / at the end

		if(substr($path, strlen($path) - 1, 1) == '/')$path = substr($path, 0, strlen($path) - 1);

		//no / at beginning

		if(substr($path, 0, 1) == '/')$path = substr($path, 1);
		return $path;
	}

	/**
	 * validate the input of a customer against the xml meta descriptions
	 *
	 * @param	packageid		id of package from database
	 * @param	customerid		id of customer from database
	 * @return	success/error array of errors found containing fields that were wrong
	 */

	private function ValidatePackageData($PackageId, $CustomerId)
	{
		if(!self::IsValidPackageId($PackageId, true))return false;
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($PackageId));
		$Row = $this->db->fetch_array($result);
		$Xml = self::GetXmlFromFile('./packages/' . $Row['Path'] . '/APP-META.xml');

		//return if parse of xml file has failed

		if($Xml == false)return false;

		$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';		

		//check all data fields of xml file against inut of customer

		if ($this->aps_version == '1.0')
		{
			// the good ole way
			$aps_settings_array = $Xml->settings->group;
		} 
		else
		{
			// since 1.1
			$aps_settings_array = $Xml->{'global-settings'}->setting;
			if(!is_array($aps_settings_array)) {
				$aps_settings_array = $Xml->service->settings->group;
			}			
		}
		
		$Error = array();
		foreach($aps_settings_array as $Group)
		{
			foreach($Group->setting as $Setting)
			{
				$FieldId = strval($Setting['id']);

				if($Setting['type'] == 'string'
				   || $Setting['type'] == 'password')
				{
					if(isset($_POST[$FieldId]))
					{
						if(isset($Setting['min-length'])
						   && strlen($_POST[$FieldId]) < $Setting['min-length'])
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['max-length'])
						   && strlen($_POST[$FieldId]) > $Setting['max-length'])
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['regex'])
						   && !preg_match("/" . $Setting['regex'] . "/", $_POST[$FieldId]))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						/*
						elseif(isset($Setting['charset']))
						{
							//CHARSET VALIDATION FOR LATER VERSIONS
						}
						*/

						if(!in_array($FieldId, $Error))self::SetInstallationValue($PackageId, $CustomerId, $FieldId, $_POST[$FieldId]);
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
				else

				if($Setting['type'] == 'email')
				{
					if(isset($_POST[$FieldId]))
					{
						$email = strtolower($_POST[$FieldId]);
						if(filter_var($email, FILTER_VALIDATE_EMAIL) === false)
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(!in_array($FieldId, $Error))self::SetInstallationValue($PackageId, $CustomerId, $FieldId, $_POST[$FieldId]);
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
				elseif($Setting['type'] == 'domain-name')
				{
					if(isset($_POST[$FieldId]))
					{
						if(!preg_match("^(http|https)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&%\$#\=~_\-]+))*$", $_POST[$FieldId]))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(!in_array($FieldId, $Error))self::SetInstallationValue($PackageId, $CustomerId, $FieldId, $_POST[$FieldId]);
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
				elseif($Setting['type'] == 'integer')
				{
					if(isset($_POST[$FieldId]))
					{
						//check if number is in the format of float

						if(round($_POST[$FieldId]) != $_POST[$FieldId])
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(!is_numeric($_POST[$FieldId]))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['min'])
						   && intval($_POST[$FieldId]) < intval($Setting['min']))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['max'])
						   && intval($_POST[$FieldId]) > intval($Setting['max']))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(!in_array($FieldId, $Error))self::SetInstallationValue($PackageId, $CustomerId, $FieldId, intval($_POST[$FieldId]));
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
				elseif($Setting['type'] == 'float')
				{
					if(isset($_POST[$FieldId]))
					{
						if(!is_numeric($_POST[$FieldId]))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['min'])
						   && floatval($_POST[$FieldId]) < floatval($Setting['min']))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(isset($Setting['max'])
						   && floatval($_POST[$FieldId]) > floatval($Setting['max']))
						{
							if(!in_array($FieldId, $Error))$Error[] = $FieldId;
						}

						if(!in_array($FieldId, $Error))self::SetInstallationValue($PackageId, $CustomerId, $FieldId, floatval($_POST[$FieldId]));
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
				elseif($Setting['type'] == 'boolean')
				{
					if(isset($_POST[$FieldId])
					   && $_POST[$FieldId] == 'true')
					{
						self::SetInstallationValue($PackageId, $CustomerId, $FieldId, 'true');
					}
					else
					{
						self::SetInstallationValue($PackageId, $CustomerId, $FieldId, 'false');
					}
				}
				elseif($Setting['type'] == 'enum')
				{
					if(isset($_POST[$FieldId]))
					{
						foreach($Setting->choice as $Choice)
						{
							if($Choice['id'] == $_POST[$FieldId])
							{
								self::SetInstallationValue($PackageId, $CustomerId, $FieldId, $_POST[$FieldId]);
								break;
							}
						}
					}
					else
					{
						if(!in_array($FieldId, $Error))$Error[] = $FieldId;
					}
				}
			}
		}

		//database required?

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
			if(isset($_POST['main_database_password']))
			{
				if(strlen($_POST['main_database_password']) < 8)
				{
					if(!in_array('main_database_password', $Error))$Error[] = 'main_database_password';
				}

				if(!in_array('main_database_password', $Error))self::SetInstallationValue($PackageId, $CustomerId, 'main_database_password', $_POST['main_database_password']);
			}
			else
			{
				if(!in_array('main_database_password', $Error))$Error[] = 'main_database_password';
			}
		}

		//application location

		if(isset($_POST['main_domain']))
		{
			$result2 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = ' . $this->db->escape($CustomerId) . ' AND `id` = ' . $this->db->escape($_POST['main_domain']));

			if($this->db->num_rows($result2) > 0)
			{
				self::SetInstallationValue($PackageId, $CustomerId, 'main_domain', $_POST['main_domain']);
			}
			else
			{
				self::SetInstallationValue($PackageId, $CustomerId, 'main_domain', '-1');

				if(!in_array('main_domain', $Error))$Error[] = 'main_domain';
			}
		}
		else
		{
			self::SetInstallationValue($PackageId, $CustomerId, 'main_domain', '-1');

			if(!in_array('main_domain', $Error))$Error[] = 'main_domain';
		}

		if(isset($_POST['main_location']))
		{
			$Temp = $_POST['main_location'];

			//call function twice for security reasons!

			$Temp = self::MakeSecurePath($Temp);
			$Temp = self::MakeSecurePath($Temp);

			//previous instance check

			$InstallPath = '';

			//find real path for selected domain

			$result3 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = ' . $this->db->escape($CustomerId) . ' AND `id` = ' . $this->db->escape(self::GetInstallationValue($PackageId, $CustomerId, 'main_domain')));

			if($this->db->num_rows($result3) > 0)
			{
				//build real path

				$Row = $this->db->fetch_array($result3);
				$InstallPath = $Row['documentroot'];
				$InstallPath.= $Temp;
				$result4 = $this->db->query('SELECT * FROM `' . TABLE_APS_INSTANCES . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId));

				//get all instances from current customer
				//thats needed because there cannot be installed two apps within the same directory

				while($Row3 = $this->db->fetch_array($result4))
				{
					//get all domains linked to instances

					$result5 = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row3['ID']) . ' AND `Name` = "main_domain"');

					if($this->db->num_rows($result5) > 0)
					{
						$Row2 = $this->db->fetch_array($result5);
						$Reserved = '';

						//get real domain path

						$result6 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = ' . $this->db->escape($CustomerId) . ' AND `id` = ' . $this->db->escape($Row2['Value']));

						if($this->db->num_rows($result6) > 0)
						{
							$Row = $this->db->fetch_array($result6);
							$Reserved = $Row['documentroot'];
						}

						//get location under domain

						$result7 = $this->db->query('SELECT * FROM `' . TABLE_APS_SETTINGS . '` WHERE `InstanceID` = ' . $this->db->escape($Row3['ID']) . ' AND `Name` = "main_location"');

						if($this->db->num_rows($result7) > 0)
						{
							$Row = $this->db->fetch_array($result7);
							$Reserved.= $Row['Value'];
						}

						//check whether there is another app installed already

						if($Reserved == $InstallPath)
						{
							if(!in_array('main_location', $Error))$Error[] = 'main_location';
							break;
						}
					}
				}
			}

			if(!in_array('main_location', $Error))self::SetInstallationValue($PackageId, $CustomerId, 'main_location', $Temp);
		}
		else
		{
			if(!in_array('main_location', $Error))$Error[] = 'main_location';
			self::SetInstallationValue($PackageId, $CustomerId, 'main_location', '');
		}

		if ($this->aps_version != '1.0')
		{
			$xml_license = $Xml->service->license;
		}
		else
		{
			$xml_license = $Xml->license;
		}
		
		if($xml_license)
		{
			if($xml_license['must-accept']
			   && $xml_license['must-accept'] == 'true')
			{
				if(isset($_POST['license'])
				   && $_POST['license'] == 'true')
				{
					self::SetInstallationValue($PackageId, $CustomerId, 'license', 'true');
				}
				else
				{
					self::SetInstallationValue($PackageId, $CustomerId, 'license', 'false');

					if(!in_array('license', $Error))$Error[] = 'license';
				}
			}
		}

		unset($Xml);
		return $Error;
	}

	/**
	 * functions provides the frontend of the installation wizard for the customer
	 *
	 * @param	packageid		id of package from database
	 * @param	wrongdata		array of fields that were wrong in previous validation check
	 * @return	error false / success none
	 */

	private function ShowPackageInstaller($PackageId, $WrongData, $CustomerId)
	{
		global $lng, $filename, $s, $page, $action, $theme;
		$Data = '';
		$Fieldname = '';
		$Fieldvalue = '';
		$Groupname = '';

		if(!self::IsValidPackageId($PackageId, true))return false;
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($PackageId));
		$Row = $this->db->fetch_array($result);
		$Xml = self::GetXmlFromFile('./packages/' . $Row['Path'] . '/APP-META.xml');

		//return if parse of xml file has failed

		if($Xml == false)return false;

		$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';
		
		//show notifcation if customer has reached his installation limit

		if($this->userinfo['aps_packages'] != '-1'
		   && (int)$this->userinfo['aps_packages_used'] >= (int)$this->userinfo['aps_packages'])
		{
			self::InfoBox($lng['aps']['allpackagesused']);
			return false;
		}

		//icon for package

		$Icon = 'templates/'.$theme.'/img/default.png';
		
		if($this->aps_version != '1.0')
		{
			$iconpath = $Xml->presentation->icon['path'];		
		} 
		else
		{
			$iconpath = $Xml->icon['path'];
		}

		if($iconpath)
		{
			$Icon = './packages/' . $Row['Path'] . '/' . basename($iconpath);
		}

		//show error message if some input was wrong

		$ErrorMessage = 0;

		if(count($WrongData) != 0)
		{
			$ErrorMessage = 1;
		}

		//remove previously entered values if new installation has been triggered

		if(!isset($_POST['withinput']))
		{
			$this->db->query('DELETE FROM `' . TABLE_APS_TEMP_SETTINGS . '` WHERE `CustomerID` = ' . $this->db->escape($CustomerId) . ' AND `PackageID` = ' . $this->db->escape($PackageId));
		}

		//where to install app?

		$Temp = 'http://<select size="1" name="main_domain">';
		$Value = self::GetInstallationValue($PackageId, $CustomerId, 'main_domain');
		$result2 = $this->db->query('SELECT * FROM `' . TABLE_PANEL_DOMAINS . '` WHERE `customerid` = ' . $this->db->escape($CustomerId));

		//if customer has no domains, app cannot be installed
		//FIXME function for html code

		if($this->db->num_rows($result2) > 0)
		{
			while($Row3 = $this->db->fetch_array($result2))
			{
				if($Value)
				{
					if($Row3['id'] == $Value)
					{
						$Temp.= '<option selected="selected" value="' . $Row3['id'] . '">' . $Row3['domain'] . '</option>';
					}
					else
					{
						$Temp.= '<option value="' . $Row3['id'] . '">' . $Row3['domain'] . '</option>';
					}
				}
				else
				{
					$Temp.= '<option value="' . $Row3['id'] . '">' . $Row3['domain'] . '</option>';
				}
			}
		}
		else
		{
			$Temp.= '<option value="-1">' . $lng['aps']['no_domains'] . '</option>';
		}

		$Temp.= '</select>';
		$Value = self::GetInstallationValue($PackageId, $CustomerId, 'main_location');

		if($Value)
		{
			$Temp.= '/<input type="text" name="main_location" value="' . $Value . '"/>';
		}
		else
		{
			$Temp.= '/<input type="text" name="main_location" value=""/>';
		}

		if(in_array('main_domain', $WrongData))
		{
			$Temp.= self::FieldError($lng['aps']['nodomains']);
		}

		if(in_array('main_location', $WrongData))
		{
			$Temp.= self::FieldError($lng['aps']['wrongpath']);
		}

		if(!in_array('main_location', $WrongData)
		   && !in_array('main_domain', $WrongData))$Temp.= '<br/>';
		$Temp.= '<em>' . $lng['aps']['application_location_description'] . '</em>';
		$Groupname = $lng['aps']['basic_settings'];
		$Fieldname = $lng['aps']['application_location'];
		$Fieldvalue = $Temp;
		eval("\$Data.=\"" . getTemplate("aps/data") . "\";");

		//database required?

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
			$Temp = '<input type="password" name="main_database_password" />';

			if(in_array('main_database_password', $WrongData))
			{
				$Temp.= self::FieldError($lng['aps']['dbpassword']);
			}

			if(!in_array('main_database_password', $WrongData))$Temp.= '<br/>';
			$Temp.= '<em>' . $lng['aps']['database_password_description'] . '</em>';
			$Groupname = '';
			$Fieldname = $lng['aps']['database_password'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
		}
		
		if ($this->aps_version == '1.0')
		{
			// the good ole way
			$aps_settings_array = $Xml->settings->group;
		} 
		else
		{
			// since 1.1
			$aps_settings_array = $Xml->{'global-settings'}->setting;
			if(!is_array($aps_settings_array)) {
				$aps_settings_array = $Xml->service->settings->group;
			}
		}		

		foreach($aps_settings_array as $Group)
		{
			$GroupPrinted = false;
			foreach($Group->setting as $Setting)
			{
				$Temp = '';

				if($Setting['type'] == 'string'
				   || $Setting['type'] == 'email'
				   || $Setting['type'] == 'integer'
				   || $Setting['type'] == 'float'
				   || $Setting['type'] == 'domain-name')
				{
					if(!$GroupPrinted)
					{
						$Groupname = $Group->name;
						$GroupPrinted = true;
					}
					else
					{
						$Groupname = '';
					}

					$Value = self::GetInstallationValue($PackageId, $CustomerId, strval($Setting['id']));

					if($Value)
					{
						$Temp.= '<input type="text" name="' . $Setting['id'] . '" value="' . $Value . '"/>';
					}
					elseif($Setting['default-value'])
					{
						$Temp.= '<input type="text" name="' . $Setting['id'] . '" value="' . $Setting['default-value'] . '"/>';
					}
					else
					{
						$Temp.= '<input type="text" name="' . $Setting['id'] . '" />';
					}

					if(in_array($Setting['id'], $WrongData))
					{
						if($Setting->{'error-message'})
						{
							$Temp.= self::FieldError($Setting->{'error-message'});
						}
						else
						{
							if($Setting['type'] == 'string')
							{
								$Temp.= self::FieldError($lng['aps']['error_text']);
							}
							elseif($Setting['type'] == 'email')
							{
								$Temp.= self::FieldError($lng['aps']['error_email']);
							}
							elseif($Setting['type'] == 'domain-name')
							{
								$Temp.= self::FieldError($lng['aps']['domain']);
							}
							elseif($Setting['type'] == 'integer')
							{
								$Temp.= self::FieldError($lng['aps']['error_integer']);
							}
							elseif($Setting['type'] == 'float')
							{
								$Temp.= self::FieldError($lng['aps']['error_float']);
							}
						}
					}
				}
				elseif($Setting['type'] == 'password')
				{
					if(!$GroupPrinted)
					{
						$Groupname = $Group->name;
						$GroupPrinted = true;
					}
					else
					{
						$Groupname = '';
					}

					$Temp.= '<input type="password" name="' . $Setting['id'] . '" />';

					if(in_array($Setting['id'], $WrongData))
					{
						if($Setting->{'error-message'})
						{
							$Temp.= self::FieldError($Setting->{'error-message'});
						}
						else
						{
							$Temp.= self::FieldError($lng['aps']['error_password']);
						}
					}
				}
				elseif($Setting['type'] == 'boolean')
				{
					if(!$GroupPrinted)
					{
						$Groupname = $Group->name;
						$GroupPrinted = true;
					}
					else
					{
						$Groupname = '';
					}

					$Value = self::GetInstallationValue($PackageId, $CustomerId, strval($Setting['id']));

					if($Value)
					{
						if($Value == 'true')
						{
							$Temp.= '<input checked="checked" name="' . $Setting['id'] . '" type="checkbox" value="true" />';
						}
						else
						{
							$Temp.= '<input name="' . $Setting['id'] . '" type="checkbox" value="true" />';
						}
					}
					elseif($Setting['default-value'] == 'true')
					{
						$Temp.= '<input checked="checked" name="' . $Setting['id'] . '" type="checkbox" value="true" />';
					}
					else
					{
						$Temp.= '<input name="' . $Setting['id'] . '" type="checkbox" value="true" />';
					}
				}
				elseif($Setting['type'] == 'enum')
				{
					if(!$GroupPrinted)
					{
						$Groupname = $Group->name;
						$GroupPrinted = true;
					}
					else
					{
						$Groupname = '';
					}

					$Temp.= '<select size="1" name="' . $Setting['id'] . '">';
					$Value = self::GetInstallationValue($PackageId, $CustomerId, strval($Setting['id']));
					foreach($Setting->choice as $Choice)
					{
						if($Value)
						{
							if(strval($Choice['id']) == $Value)
							{
								$Temp.= '<option selected="selected" value="' . $Choice['id'] . '">' . $Choice->name . '</option>';
							}
							else
							{
								$Temp.= '<option value="' . $Choice['id'] . '">' . $Choice->name . '</option>';
							}
						}
						elseif(strval($Choice['id']) == strval($Setting['default-value']))
						{
							$Temp.= '<option selected="selected" value="' . $Choice['id'] . '">' . $Choice->name . '</option>';
						}
						else
						{
							$Temp.= '<option value="' . $Choice['id'] . '">' . $Choice->name . '</option>';
						}
					}

					$Temp.= '</select>';
				}

				//default field description

				if(isset($Setting->description))
				{
					if(!in_array(strval($Setting['id']), $WrongData))$Temp.= '<br/>';
					$Temp.= '<em>' . $Setting->description . '</em>';
				}

				$Fieldname = $Setting->name;
				$Fieldvalue = $Temp;
				eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			}
		}

		if ($this->aps_version != '1.0')
		{
			$xml_license = $Xml->service->license;
		}
		else
		{
			$xml_license = $Xml->license;
		}
		
		if($xml_license)
		{
			$Temp = '';

			if($xml_license['must-accept']
			   && $xml_license['must-accept'] == 'true')
			{
				if($xml_license->text->name)$Temp.= $xml_license->text->name . '<br/>';

				if($xml_license->text->file)
				{
					$Temp.= '<textarea name="text" rows="10" cols="55">';
					$FileContent = file_get_contents('./packages/' . $Row['Path'] . '/license.txt');
					$Temp.= htmlentities($FileContent, ENT_QUOTES, 'UTF-8');
					$Temp.= '</textarea>';
					$Groupname = $lng['aps']['license'];
					$Fieldname = $lng['aps']['license'];
					$Fieldvalue = $Temp;
					eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
				}
				else
				{
					$Temp.= '<a target="_blank" href="' . htmlspecialchars($xml_license->text->url) . '">' . $lng['aps']['error_license'] . '</a>';
					$Groupname = $lng['aps']['license'];
					$Fieldname = $lng['aps']['license'];
					$Fieldvalue = $Temp;
					eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
				}

				$Temp = '<label><input name="license" type="checkbox" value="true" /> ' . $lng['aps']['error_license'] . '</label>';

				if(in_array('license', $WrongData))
				{
					$Temp.= self::FieldError($lng['aps']['error_licensenoaccept']);
				}

				$Groupname = '';
				$Fieldname = $lng['aps']['license_agreement'];
				$Fieldvalue = $Temp;
				eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			}
		}

		eval("echo \"" . getTemplate("aps/installer") . "\";");
		unset($Xml);
	}

	/**
	 * show informations for a package in basic or detailed view
	 *
	 * @param	packageid		id of package from database
	 * @param	mode			verbosity of data to view (basic|advanced)
	 * @return	error false / success none
	 */

	private function ShowPackageInfo($PackageId, $All = false)
	{
		global $lng, $filename, $s, $page, $action, $userinfo, $theme;
		$Data = '';
		$Fieldname = '';
		$Fieldvalue = '';
		$Groupname = '';

		if(!self::IsValidPackageId($PackageId, true))return false;
		$result = $this->db->query('SELECT * FROM `' . TABLE_APS_PACKAGES . '` WHERE `ID` = ' . $this->db->escape($PackageId));
		$Row = $this->db->fetch_array($result);
		$Xml = self::GetXmlFromFile('./packages/' . $Row['Path'] . '/APP-META.xml');

		//return if parse of xml file has failed

		if($Xml == false)return false;
		$Icon = 'templates/'.$theme.'/img/default.png';

		$this->aps_version = isset($Xml->attributes()->version) ? (string)$Xml->attributes()->version : '1.0';

		//show icon and basic data
		if($this->aps_version != '1.0')
		{
			$iconpath = $Xml->presentation->icon['path'];
			$Summary = htmlspecialchars($Xml->presentation->summary);
			$categories = $Xml->presentation->categories;
			$languages =  $Xml->presentation->languages;
			$description = $Xml->presentation->description;
			$changelogs = $Xml->presentation->changelog;
			$license = $Xml->service->license;
			$screenshots = $Xml->presentation->screenshot;			
		} 
		else
		{
			$iconpath = $Xml->icon['path'];
			$Summary = htmlspecialchars($Xml->summary);
			$categories = $Xml->categories;
			$languages =  $Xml->languages;
			$description = $Xml->description;
			$changelogs = $Xml->changelog;
			$license = $Xml->license;
			$screenshots = $Xml->screenshot;
		}

		if($iconpath)
		{
			$Icon = './packages/' . $Row['Path'] . '/' . basename($iconpath);
		}

		$Fieldname = $lng['aps']['version'];
		$Fieldvalue = $Xml->version . ' (Release ' . $Xml->release . ')';
		eval("\$Data.=\"" . getTemplate("aps/data") . "\";");

		//show website

		if($Xml->homepage)
		{
			$Fieldname = $lng['aps']['homepage'];
			$Fieldvalue = '<a target="_blank" href="' . htmlspecialchars($Xml->homepage) . '">' . htmlspecialchars($Xml->homepage) . '</a>';
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
		}

		//show size after installation

		if($Xml->{'installed-size'})
		{
			$Fieldname = $lng['aps']['installed_size'];
			$Fieldvalue = 'ca. ' . number_format(intval($Xml->{'installed-size'}) / (1024 * 1024), 2) . ' MB';
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
		}

		//show categories

		if($categories)
		{
			$Temp = '';
			foreach($categories->category as $_categories)
			{
				$Temp.= htmlspecialchars($_categories[0]) . '<br/>';
			}

			$Fieldname = $lng['aps']['categories'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
		}

		//show available languages

		if($languages)
		{
			$Temp = '';
			foreach($languages->language as $_languages)
			{
				$Temp.= $_languages[0] . ' ';
			}

			$Fieldname = $lng['aps']['languages'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
		}

		//show more information

		if($All == true)
		{
			$Fieldname = $lng['aps']['long_description'];
			$Fieldvalue = htmlspecialchars($description);
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");

			//show config script language

			if($Xml->{'configuration-script-language'})
			{
				$Fieldname = $lng['aps']['configscript'];
				$Fieldvalue = $Xml->{'configuration-script-language'};
				eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			}

			//show changelog

			$Temp = '<ul>';
			foreach($changelogs->version as $Versions)
			{
				$Temp.= '<li><strong>' . $Versions['version'] . ' (Release ' . $Versions['release'] . ')</strong>';
				$Temp.= '<ul>';
				foreach($Versions->entry as $Entries)
				{
					$Temp.= '<li>' . $Entries[0] . '</li>';
				}

				$Temp.= '</ul></li>';
			}

			$Temp.= '</ul>';
			$Fieldname = $lng['aps']['changelog'];
			$Fieldvalue = $Temp;
			eval("\$Data.=\"" . getTemplate("aps/data") . "\";");

			//show license

			if($license)
			{
				if($license->text->file)
				{
					$Temp = '';

					if($license->text->name)$Temp = $license->text->name . '<br/>';
					$Temp.= '<form name="license" action="#"><textarea name="text" rows="10" cols="70">';
					$FileContent = file_get_contents('./packages/' . $Row['Path'] . '/license.txt');
					$Temp.= htmlentities($FileContent, ENT_QUOTES, 'UTF-8');
					$Temp.= '</textarea></form>';
					$Fieldname = $lng['aps']['license'];
					$Fieldvalue = $Temp;
					eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
				}
				else
				{
					$Fieldname = $lng['aps']['license'];
					$Fieldvalue = '<a target="_blank" href="' . htmlspecialchars($license->text->url) . '">' . $lng['aps']['linktolicense'] . '</a>';
					eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
				}
			}

			//show screenshots

			if($screenshots)
			{
				$Count = 0;
				$Temp = '';
				foreach($screenshots as $Screenshot)
				{
					$Count+= 1;
					$Temp.= '<img src="./packages/' . $Row['Path'] . '/' . basename($Screenshot['path']) . '" alt="' . $Screenshot->description . '"/><br/><em>' . $Screenshot->description . '</em><br/>';

					if(count($screenshots) != $Count)$Temp.= '<br/>';
				}

				$Fieldname = $lng['aps']['screenshots'];
				$Fieldvalue = $Temp;
				eval("\$Data.=\"" . getTemplate("aps/data") . "\";");
			}
		}

		/*
		 * check if packages needs a database
		 * and if the customer has contingent for that, #272
		 */
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
			if($userinfo['mysqls_used'] < $userinfo['mysqls']
				|| $userinfo['mysqls'] == '-1'
			){
				$can_use_db = true;
			} else {
				$can_use_db = false;
			}
		} else { $can_use_db = true; }

		$db_info = '';
		if(!$can_use_db)
		{
			$db_info = $lng['aps']['packageneedsdb'];
		}

		eval("echo \"" . getTemplate("aps/package") . "\";");
		unset($Xml);
	}

	/**
	 * show a nice looking infobox
	 *
	 * @param string $Message message to display in beautifull layout
	 * @param int    $Type    0 = warning, 1 = errror, 2 = success
	 *
	 */
	private function InfoBox($Message, $Type = 0)
	{
		global $lng, $filename, $s, $page, $action, $theme;
		//shows a box with informations
		eval("echo \"" . getTemplate("aps/infobox") . "\";");
	}

	/**
	 * returns html code for nice looking boxes to show customers wrong input
	 *
	 * @param	error		error to display in beautifull layout
	 */

	private function FieldError($Error)
	{
		return '<div class="fielderror">' . $Error . '</div>';
	}
}
