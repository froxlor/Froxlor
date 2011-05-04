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

    $result = $db->query("SELECT customerid, loginname, guid, documentroot, backup_allowed, backup_enabled FROM `" . TABLE_PANEL_CUSTOMERS . "` ORDER BY `customerid` ASC");
    while($row = $db->fetch_array($result)){
	fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' started...' . "\n");

	// create webserver backup directory access protection
	$backupprotectfile = $settings['system']['apacheconf_diroptions'] . '50_froxlor_diroption_' . md5($row['documentroot'] . $settings['system']['backup_dir']) . '.conf';
	$fh = fopen($backupprotectfile, 'w');
	if($settings['system']['webserver'] == 'apache2'){
	    $filedata = '# ' . basename($backupprotectfile) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" .
		'# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n\n" . 
		'<Directory "' . $row['documentroot'] . $settings['system']['backup_dir'] . '/">' . "\n" .
		'	deny from all' . "\n" .
		'</Directory>' . "\n";
	}
	elseif($settings['system']['webserver'] == 'lighttpd'){
	    $filedata = '# ' . basename($backupprotectfile) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" .
		'# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n\n" .
		'$PHYSICAL["path"] !~ "^' . $row['documentroot'] . $settings['system']['backup_dir'] . '/$" {' . "\n" .
		'	access.deny-all = "enable"' . "\n" .
		'}' . "\n";
	}
	elseif($settings['system']['webserver'] == 'nginx'){
	    $filedata = '# ' . basename($backupprotectfile) . "\n" . '# Created ' . date('d.m.Y H:i') . "\n" .
		'# Do NOT manually edit this file, all changes will be deleted after the next domain change at the panel.' . "\n\n" .
		'location ' . $row['documentroot'] . $settings['system']['backup_dir'] . ' {' . "\n" .
	        '	deny all;' . "\n" .
	        '	return 403;' . "\n" .
		'}' . "\n";
	}
	fwrite($fh, $filedata);
	fclose($fh);

	//reload webserver to enable directory protection
	safe_exec(escapeshellcmd($settings['system']['apachereload_command']));

	// backup
	if($row['backup_allowed'] == '1' && $row['backup_enabled'] == '1'){
	    // get uid & gid from ftp table
	    $ftp_result = $db->query("SELECT uid, gid FROM `" . TABLE_FTP_USERS . "` WHERE `username` = '" . $db->escape($row['loginname']) . "'");
	    $ftp_row = mysql_fetch_array($ftp_result);

	    // create backup dir an set rights
	    if(!file_exists($row['documentroot'] . $settings['system']['backup_dir'])){
		safe_exec('install -d ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . ' -o ' . escapeshellarg($ftp_row['uid']) . ' -g ' . escapeshellarg($ftp_row['gid']) . ' -m ' . '0500'); 
	    }

	    // create customers html backup
	    safe_exec('tar --exclude=' . escapeshellarg($settings['system']['backup_dir']) . ' -C ' . escapeshellarg($row['documentroot']) . ' -c -z -f ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . escapeshellarg($row['loginname']) . 'html.tar.gz .');

	    // get customer dbs
	    $dbs_result = $db->query("SELECT databasename FROM `" . TABLE_PANEL_DATABASES . "` WHERE `customerid` = '" . $db->escape($row['customerid']) . "'");
	    while($dbs_row = $db->fetch_array($dbs_result)){
		// create customers sql backup
		safe_exec(escapeshellarg($settings['system']['backup_mysqldump_path']) . ' --opt --allow-keywords -u ' . $sql_root[0]['user'] . ' -p' . $sql_root[0]['password'] . ' -h ' . $sql_root[0]['host'] . ' ' . escapeshellarg($dbs_row['databasename']) . ' -r ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql'  );
		// compress sql backup
		safe_exec('tar -C ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . ' -c -z -f ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . escapeshellarg($dbs_row['databasename']) . '.tar.gz ' . escapeshellarg($dbs_row['databasename']) . '.sql');
		// remove uncompresed sql files
		safe_exec('rm ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . escapeshellarg($dbs_row['databasename']) . '.sql');
	    }

	    // create 1 big file with html & db
	    if($settings['system']['backup_bigfile'] == 1){
		safe_exec('tar -C ' . escapeshellarg($row['documentroot'] . $settings['system']['backup_dir']) . ' --exclude=' . escapeshellarg($row['loginname']) . '.tar.gz -c -z -f ' . escapeshellarg($row['documentroot'] . $settings['system']['backup_dir']) . '/' . escapeshellarg($row['loginname']) . '.tar.gz .');
		// remove separated files
		$tmp_files = scandir($row['documentroot'] . $settings['system']['backup_dir']);
		foreach ($tmp_files as $tmp_file){
		    if(preg_match('/.*(html|sql|aps).*\.tar\.gz$/', $tmp_file) && !preg_match('/^' . $row['loginname'] . '\.tar\.gz$/', $tmp_file)){
			safe_exec('rm ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . $tmp_file . '');
		    }
		}
	    }

	    // set correct user
	    if($settings['system']['mod_fcgid'] == 1){
		$user = $row['loginname'];
		$group = $row['loginname'];
	    }
	    else {
		$user = $row['guid'];
		$group = $row['guid'];
	    }

	    // chown & chmod files to prevent manipulation
	    safe_exec('chown ' . escapeshellarg($user) . ':' . escapeshellarg($group) . ' ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . '*');
	    safe_exec('chmod 0400 ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/*');

	    if($settings['system']['backup_ftp_enabled'] == '1'){
		// upload backup to customers ftp server
		$ftp_files = scandir($row['documentroot'] . $settings['system']['backup_dir']);
		foreach ($ftp_files as $ftp_file){
		    if(preg_match('/.*\.tar\.gz$/', $ftp_file)){
			$ftp_con = ftp_connect($settings['system']['backup_ftp_server']);
			$ftp_login = ftp_login($ftp_con, $settings['system']['backup_ftp_user'], $settings['system']['backup_ftp_pass']);
			ftp_pasv($ftp_con, true);
			$ftp_upload = ftp_put($ftp_con, $ftp_file, $row['documentroot'] . $settings['system']['backup_dir'] . "/" . $ftp_file, FTP_BINARY);
		    }
		}
	    }
	    fwrite($debugHandler, 'backup for ' . $row['loginname'] . ' finished...' . "\n");
	}
	// delete old backup data (deletes backup if customer or admin disables backup)
	elseif($row['backup_allowed'] == '0' || $row['backup_enabled'] == '0'){
	    if (file_exists($row['documentroot'] . $settings['system']['backup_dir'] . '/')){
		$files = scandir($row['documentroot'] . $settings['system']['backup_dir']);
		foreach ($files as $file){
	    	    if(preg_match('/.*\.tar\.gz$/', $file)){
			safe_exec('rm ' . escapeshellarg($row['documentroot']) . escapeshellarg($settings['system']['backup_dir']) . '/' . $file . '');
		    }
		}
	    }
	}
    }
    fwrite($debugHandler, 'backup customers finished...' . "\n");    
}

?>
