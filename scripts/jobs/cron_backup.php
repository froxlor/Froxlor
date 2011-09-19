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
 *
*/

if(@php_sapi_name() != 'cli'){
    die('This script will only work in the shell');
}

openRootDB($debugHandler, $lockfile);

/**
 * Backup
 */

if($settings['system']['backup_enabled'] == '1'){

    fwrite($debugHandler, 'backup customers started...' . "\n");

    $result = $db->query("SELECT customerid, loginname, guid, documentroot, backup_allowed, backup_enabled FROM `" . TABLE_PANEL_CUSTOMERS . "` ORDER BY `customerid` ASC;");
    while($row = $db->fetch_array($result)){
	fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' started...' . "\n");

	// backup
	if($row['backup_allowed'] == '1' && $row['backup_enabled'] == '1'){
	    // get uid & gid from ftp table
	    $ftp_result = $db->query("SELECT uid, gid FROM `" . TABLE_FTP_USERS . "` WHERE `username` = '" . $db->escape($row['loginname']) . "';");
	    $ftp_row = mysql_fetch_array($ftp_result);

	    // create backup dir an set rights
       if(!file_exists($settings['system']['backup_dir'] . $row['loginname'])) {
		safe_exec('install -d ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . ' -o ' . escapeshellarg($ftp_row['uid']) . ' -g ' . escapeshellarg($ftp_row['gid']) . ' -m ' . '0500');
	    }

	    // create customers html backup
	    safe_exec('tar -C ' . escapeshellarg($row['documentroot']) . ' -c -z -f ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname'])  . '/' . escapeshellarg($row['loginname']) . 'html.tar.gz .');

	    // get customer dbs
	    $dbs_result = $db->query("SELECT databasename FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = '" . $db->escape($row['customerid']) . "';");
	    while($dbs_row = $db->fetch_array($dbs_result)){
		// create customers sql backup
		safe_exec(escapeshellarg($settings['system']['backup_mysqldump_path']) . ' --opt --force --allow-keywords -u ' . escapeshellarg($sql_root[0]['user']) . ' -p' . escapeshellarg($sql_root[0]['password']) . ' -h ' . $sql_root[0]['host'] . ' ' . escapeshellarg($dbs_row['databasename']) . ' -r ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql'  );
		// compress sql backup
		safe_exec('tar -C ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . ' -c -z -f ' . escapeshellarg($settings['system']['backup_dir']) . $row['loginname'] . '/' . escapeshellarg($dbs_row['databasename']) . '.tar.gz ' . escapeshellarg($dbs_row['databasename']) . '.sql');
		// remove uncompresed sql files
		safe_exec('rm ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql');
	    }

	    // create 1 big file with html & db
	    if($settings['system']['backup_bigfile'] == 1){
		safe_exec('tar -C ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/'  . ' --exclude=' . escapeshellarg($row['loginname']) . '.tar.gz -c -z -f ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($row['loginname']) . '.tar.gz .');
		// remove separated files
		$tmp_files = scandir($settings['system']['backup_dir'] . $row['loginname']);
		foreach ($tmp_files as $tmp_file){
		    if(preg_match('/.*(html|sql|aps).*\.tar\.gz$/', $tmp_file) && !preg_match('/^' . $row['loginname'] . '\.tar\.gz$/', $tmp_file)){
			safe_exec('rm ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($tmp_file) . '');
		    }
		}
	    }
	    else {
		//remove big file if separated backups are used
		if (file_exists($settings['system']['backup_dir'] . $row['loginname'] . '/' . $row['loginname'] . '.tar.gz')) {
		    safe_exec('rm ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($row['loginname']) . '.tar.gz');
		}
	    }

	    // chown & chmod files to prevent manipulation
	    safe_exec('chown ' . escapeshellarg($row['guid']) . ':' . escapeshellarg($row['guid']) . ' ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/*');
	    safe_exec('chmod 0400 ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/*');

	    // create ftp backup user
	    $user_result = $db->query("SELECT username, password FROM `" . TABLE_FTP_USERS . "` WHERE `customerid` = '" . $db->escape($row['customerid']) . "' AND `username` = '" . $db->escape($row['loginname']) . "';");
	    $user_row = mysql_fetch_array($user_result);
	    $db->query("REPLACE INTO `" . TABLE_FTP_USERS . "` (`customerid`, `username`, `password`, `homedir`, `login_enabled`, `uid`, `gid`) VALUES ('" . $db->escape($row['customerid']) . "', '" . $db->escape($row['loginname']) . "_backup', '" . $db->escape($user_row['password']) . "', '" . $db->escape($settings['system']['backup_dir']) . $db->escape($row['loginname']) . "/', 'y', '" . $db->escape($row['guid']) . "', '" . $db->escape($row['guid']) . "')");

	    if($settings['system']['backup_ftp_enabled'] == '1'){
		// upload backup to customers ftp server
		$ftp_files = scandir($settings['system']['backup_dir'] . $row['loginname']);
		foreach ($ftp_files as $ftp_file){
		    if(preg_match('/.*\.tar\.gz$/', $ftp_file)){
			$ftp_con = ftp_connect($settings['system']['backup_ftp_server']);
			$ftp_login = ftp_login($ftp_con, $settings['system']['backup_ftp_user'], $settings['system']['backup_ftp_pass']);
			
			/* Check whether to use passive mode or not */
			if($settings['system']['backup_ftp_passive'] == 1)
			{
				ftp_pasv($ftp_con, true);
			}
			else
			{
				ftp_pasv($ftp_con, false);
			}
			
			$ftp_upload = ftp_put($ftp_con, $ftp_file, $settings['system']['backup_dir'] . $row['loginname'] . "/" . $ftp_file, FTP_BINARY);
		    }
		}
	    }
	    fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' finished...' . "\n");
	}
	

	// delete old backup data (deletes backup if customer or admin disables backup)
	elseif($row['backup_allowed'] == '0' || $row['backup_enabled'] == '0'){
	    if (file_exists($settings['system']['backup_dir'] . $row['loginname'] . '/')){
		$files = scandir($settings['system']['backup_dir'] . $row['loginname'] . '/');
		foreach ($files as $file){
	    	    if(preg_match('/.*\.tar\.gz$/', $file)){
			safe_exec('rm ' . escapeshellarg($settings['system']['backup_dir']) . escapeshellarg($row['loginname']) . '/' . escapeshellarg($file) . '');
		    }
		}
	    }
	}
    }
    fwrite($debugHandler, 'backup customers finished...' . "\n");
}

?>
