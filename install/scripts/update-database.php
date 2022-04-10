#!/usr/bin/php
<?php
// Check if we're in the CLI
if (@php_sapi_name() !== 'cli') {
	die('This script will only work in the shell.');
}


// Include autoloader and table constants
require __DIR__.'/../../vendor/autoload.php';
require \Froxlor\Froxlor::getInstallDir() . '/lib/tables.inc.php';

// remove html for console output
function cleanUpdateOutput($buffer) {
        static $newLine = true;
        $buffer = strip_tags(preg_replace("/<br\W*?\/>/", "\n", $buffer));
        if($newLine) {
                $buffer = date('[H:i:s] ').$buffer;
        }

        $newLine = strpos($buffer, "\n") !== false              ;
        return $buffer;
}

define('_CRON_UPDATE', 1);
ob_start('cleanUpdateOutput', 2); //force direct flushing

// execute update scripts
include_once \Froxlor\Froxlor::getInstallDir() . '/install/updatesql.php';
ob_end_flush();
