<?php
if (! defined('FROXLOR_INSTALL_DIR')) {
	define('FROXLOR_INSTALL_DIR', dirname(dirname(dirname(__DIR__))));
	require_once FROXLOR_INSTALL_DIR . '/lib/tables.inc.php';
	require_once FROXLOR_INSTALL_DIR . '/lib/functions.php';
}

// query the whole table
$result_stmt = Database::query("SELECT * FROM `" . TABLE_PANEL_LANGUAGE . "`");

$langs = array();
// presort languages
while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
	$langs[$row['language']][] = $row;
	// check for row[iso] cause older froxlor
	// versions didn't have that and it will
	// lead to a lot of undfined variables
	// before the admin can even update
	if (isset($row['iso'])) {
		$iso[$row['iso']] = $row['language'];
	}
}

// set default language before anything else to
// ensure that we can display messages
$language = Settings::Get('panel.standardlanguage');

// include every english language file we can get
foreach ($langs['English'] as $key => $value) {
	include_once makeSecurePath($value['file']);
}

// now include the selected language if its not english
if ($language != 'English') {
	foreach ($langs[$language] as $key => $value) {
		include_once makeSecurePath($value['file']);
	}
}

// last but not least include language references file
include_once makeSecurePath('lng/lng_references.php');
