<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2016 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Frontend
 *
 * @since      0.9.35
 *
 */
define('AREA', 'admin');
require './lib/init.php';

// define update-uri
define('UPDATE_URI', "https://version.froxlor.org/Froxlor/api/" . $version);
define('RELEASE_URI', "https://autoupdate.froxlor.org/froxlor-{version}.zip");
define('CHECKSUM_URI', "https://autoupdate.froxlor.org/froxlor-{version}.zip.sha256");

// check for archive-stuff
if (! extension_loaded('zip')) {
	redirectTo($filename, array(
		's' => $s,
		'page' => 'error',
		'errno' => 2
	));
}

// display initial version check
if ($page == 'overview') {
	
	// log our actions
	$log->logAction(ADM_ACTION, LOG_NOTICE, "checking auto-update");
	
	// check for new version
	$latestversion = HttpClient::urlGet(UPDATE_URI);
	
	$latestversion = explode('|', $latestversion);
	
	if (is_array($latestversion) && count($latestversion) >= 1) {
		$_version = $latestversion[0];
		$_message = isset($latestversion[1]) ? $latestversion[1] : '';
		$_link = isset($latestversion[2]) ? $latestversion[2] : htmlspecialchars($filename . '?s=' . urlencode($s) . '&page=' . urlencode($page) . '&lookfornewversion=yes');
		
		// add the branding so debian guys are not gettings confused
		// about their version-number
		$version_label = $_version . $branding;
		$version_link = $_link;
		$message_addinfo = $_message;
		
		// not numeric -> error-message
		if (! preg_match('/^((\d+\\.)(\d+\\.)(\d+\\.)?(\d+)?(\-(svn|dev|rc)(\d+))?)$/', $_version)) {
			// check for customized version to not output
			// "There is a newer version of froxlor" besides the error-message
			redirectTo($filename, array(
				's' => $s,
				'page' => 'error',
				'errno' => 3
			));
		} elseif (version_compare2($version, $_version) == - 1) {
			// there is a newer version - yay
			$isnewerversion = 1;
		} else {
			// nothing new
			$isnewerversion = 0;
		}
		
		// anzeige über version-status mit ggfls. formular
		// zum update schritt #1 -> download
		if ($isnewerversion == 1) {
			$text = 'There is a newer version available. Update to version <b>' . $_version . '</b> now?<br/>(Your current version is: ' . $version . ')';
			$hiddenparams = '<input type="hidden" name="newversion" value="' . $_version . '" />';
			$yesfile = $filename . '?s=' . $s . '&amp;page=getdownload';
			eval("echo \"" . getTemplate("misc/question_yesno", true) . "\";");
			exit();
		} elseif ($isnewerversion == 0) {
			// all good
			standard_success('noupdatesavail');
		} else {
			standard_error('customized_version');
		}
	}
}// download the new archive
elseif ($page == 'getdownload') {
	
	// retrieve the new version from the form
	$newversion = isset($_POST['newversion']) ? $_POST['newversion'] : null;
	
	// valid?
	if ($newversion !== null) {
		
		// define files to get
		$toLoad = str_replace('{version}', $newversion, RELEASE_URI);
		$toCheck = str_replace('{version}', $newversion, CHECKSUM_URI);
		
		// check for local destination folder
		if (! is_dir(FROXLOR_INSTALL_DIR . '/updates/')) {
			mkdir(FROXLOR_INSTALL_DIR . '/updates/');
		}
		
		// name archive
		$localArchive = FROXLOR_INSTALL_DIR . '/updates/' . basename($toLoad);
		
		$log->logAction(ADM_ACTION, LOG_NOTICE, "Downloading " . $toLoad . " to " . $localArchive);
		
		// remove old archive
		if (file_exists($localArchive)) {
			@unlink($localArchive);
		}
		
		// get archive data
		try {
			HttpClient::fileGet($toLoad, $localArchive);
		} catch (Exception $e) {
			redirectTo($filename, array(
				's' => $s,
				'page' => 'error',
				'errno' => 4
			));
		}
		
		// validate the integrity of the downloaded file
		$_shouldsum = HttpClient::urlGet($toCheck);
		if (! empty($_shouldsum)) {
			$_t = explode(" ", $_shouldsum);
			$shouldsum = $_t[0];
		} else {
			$shouldsum = null;
		}
		$filesum = hash_file('sha256', $localArchive);
		
		if ($filesum != $shouldsum) {
			redirectTo($filename, array(
				's' => $s,
				'page' => 'error',
				'errno' => 9
			));
		}
		
		// to the next step
		redirectTo($filename, array(
			's' => $s,
			'page' => 'extract',
			'archive' => basename($localArchive)
		));
	}
	redirectTo($filename, array(
		's' => $s,
		'page' => 'error',
		'errno' => 6
	));
}// extract and install new version
elseif ($page == 'extract') {
	
	$toExtract = isset($_GET['archive']) ? $_GET['archive'] : null;
	$localArchive = FROXLOR_INSTALL_DIR . '/updates/' . $toExtract;
	
	if (isset($_POST['send']) && $_POST['send'] == 'send') {
		// decompress from zip
		$zip = new ZipArchive();
		$res = $zip->open($localArchive);
		if ($res === true) {
			$log->logAction(ADM_ACTION, LOG_NOTICE, "Extracting " . $localArchive . " to " . FROXLOR_INSTALL_DIR);
			$zip->extractTo(FROXLOR_INSTALL_DIR);
			$zip->close();
			// success - remove unused archive
			@unlink($localArchive);
		} else {
			// error
			redirectTo($filename, array(
				's' => $s,
				'page' => 'error',
				'errno' => 8
			));
		}
		
		// redirect to update-page?
		redirectTo('admin_updates.php', array(
			's' => $s
		));
	}
	
	if (! file_exists($localArchive)) {
		redirectTo($filename, array(
			's' => $s,
			'page' => 'error',
			'errno' => 7
		));
	}
	
	$text = 'Extract downloaded archive "' . $toExtract . '"?';
	$hiddenparams = '';
	$yesfile = $filename . '?s=' . $s . '&amp;page=extract&amp;archive=' . $toExtract;
	eval("echo \"" . getTemplate("misc/question_yesno", true) . "\";");
}
// display error
elseif ($page == 'error') {
	
	// retrieve error-number via url-parameter
	$errno = isset($_GET['errno']) ? (int) $_GET['errno'] : 0;
	
	// 2 = no Zlib
	// 3 = custom version detected
	// 4 = could not store archive to local hdd
	// 5 = some weird value came from version.froxlor.org
	// 6 = download without valid version
	// 7 = local archive does not exist
	// 8 = could not extract archive
	// 9 = checksum mismatch
	standard_error('autoupdate_' . $errno);
}
