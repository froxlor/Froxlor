<?php

require dirname(__DIR__) . '/vendor/autoload.php';
// Includes the Functions
require \Froxlor\Froxlor::getInstallDir() . '/lib/functions/constant.formfields.php';
require \Froxlor\Froxlor::getInstallDir() . '/lib/functions/constant.logger.php';

// Includes the MySQL-Tabledefinitions etc.
require \Froxlor\Froxlor::getInstallDir() . '/lib/tables.inc.php';

$functions = get_defined_functions();
$calls = array();
foreach ($functions['user'] as $func) {

	// grep for function
	exec('grep -ir "'.$func.'" '.dirname(__DIR__).'/lib/', $output);
	exec('grep -ir "'.$func.'" '.dirname(__DIR__).'/install/', $output);
	exec('grep -ir "'.$func.'" '.dirname(__DIR__).'/actions/', $output);
	exec('grep -ir "'.$func.'" '.dirname(__DIR__).'/*.php', $output);
	echo "***********************************************".PHP_EOL;
	echo "******* ". $func." ************************".PHP_EOL;
	echo "***********************************************".PHP_EOL;
	foreach ($output as $file) {
		echo str_replace(dirname(__DIR__), "", $file) . PHP_EOL;
	}
	echo PHP_EOL;
	$output = array();
}

