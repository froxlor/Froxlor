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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Cron
 * @version    $Id$
 */

/*
 * This script prepares data for froxlor-clients (multserver-mode)
 * and transfers them via ssh/scp to the destination-server
 */

if(@php_sapi_name() != 'cli'
&& @php_sapi_name() != 'cgi'
&& @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class client_deployer
{
	/**
	 * object of froxlor-client
	 * @var froxlorclient
	 */
	private $_client = null;
	
	public function __construct($client = null)
	{
		$this->_client = $client;
	}

	/**
	 * This functions deploys the needed files
	 * to the client destination server
	 * 
	 * @return bool
	 */
	public function Deploy()
	{
		// get FroxlorSshTransport-object
		$ssh = null;
		if($this->_client->getSetting('client', 'deploy_mode') !== null
			&& $this->_client->getSetting('client', 'deploy_mode') == 'pubkey'
		) {
			$ssh = FroxlorSshTransport::usePublicKey(
				$this->_client->getSetting('client', 'hostname'), 
				$this->_client->getSetting('client', 'ssh_port'), 
				$this->_client->getSetting('client', 'ssh_user'), 
				$this->_client->getSetting('client', 'ssh_pubkey'), 
				$this->_client->getSetting('client', 'ssh_privkey'), 
				$this->_client->getSetting('client', 'ssh_passphrase')
			);
		} 
		else if($this->_getSetting('client', 'deploy_mode') !== null) 
		{
			$ssh = FroxlorSshTransport::usePlainPassword(
				$this->_client->getSetting('client', 'hostname'), 
				$this->_client->getSetting('client', 'ssh_port'), 
				$this->_client->getSetting('client', 'ssh_user'), 
				$this->_client->getSetting('client', 'ssh_passphrase')
			);
		} else {
			throw new Exception('NO_DEPLOY_METHOD_GIVEN');
		}	
		
		if($ssh instanceof FroxlorSshTransport)
		{
			/**
			 * @TODO implement me
			 */
			
			$deployList = "/tmp/froxlor_deploy_".time().".txt";
			$zipPath = "/tmp/froxlor_deploy_".time().".zip";
			
			$remoteTo = "/var/ww/froxlor/"; // TODO setting variable?!
			
			// TODO get a deploy configuration from database/panel?
			// create the deploy list
			FroxlorDeployfileCreator::createList(
				array(
					"/var/www/froxlor/lib/",
					"/var/www/froxlor/lng/",
					"/var/www/froxlor/scripts/",
					"/var/www/froxlor/actions/",
					"/var/www/froxlor/templates/"
				)
			);
			
			FroxlorDeployfileCreator::saveListTo($deployList);
			
			// prepare and pack files
			$this->_prepareFiles($deployList, $zipPath);
			
			// transfer the data
			$bytes = $this->_transferArchive($ssh, $zipPath, $remoteTo);
				
			// close the session 
			$ssh->close();
		}
	}

	/**
	 * transfer the created archive to
	 * the destination host
	 * 
	 * @return double amount of bytes transferd 
	 */
	private function _transferArchive($ssh, $from, $to)
	{
		if ($ssh->sendFile($from, $to)) {
			return stat($from)['7'];
		} else {
			return 0.0;
		}
	}

	/**
	 * create an archive of all needed files listed
	 * in a list/xml file (@TODO)
	 * 
	 * @return string path to the created archive
	 */
	private function _prepareFiles($deployList, $toPath)
	{
		$pkg = FroxlorPkgCreator($deployList, $toPath);
		
		/** 
		 * create userdata file which
		 * has to be included to the archive
		 */
		$userdatafile = $this->_createUserdataFile();
		
		// add userdata.inc.php
		$pkg->addFile("lib/userdata.inc.php", $userdatafile);
		
		// pack it
		$pkg->pack();
	}

	/**
	 * create the userdata.inc.php file filled
	 * with necessary data, like database-host,
	 * username, etc. 
	 * !!! don't forget to set $server_id to the correct value !!!
	 * 
	 * @return string full path to the created file
	 */
	private function _createUserdataFile()
	{
		return "Chuck Norris doesn't need a userdata.inc.php to run Froxlor!";
	}
}
