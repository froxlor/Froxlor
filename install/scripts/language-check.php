<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2007 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Martin Burchert <eremit@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    System
 *
 */

// some configs

$baseLanguage = 'english.lng.php';

// Check if we're in the CLI

if(@php_sapi_name() != 'cli')
{
	die('This script will only work in the shell.');
}

// Check argument count

if(sizeof($argv) != 2)
{
	print_help($argv);
	exit;
}

// Load the contents of the given path

$path = $argv[1];
$files = array();

if($dh = opendir($path))
{
	while(false !== ($file = readdir($dh)))
	{
		if($file != "."
		   && $file != ".."
		   && !is_dir($file)
		   && preg_match('/(.+)\.lng\.php/i', $file))
		{
			$files[$file] = str_replace('//', '/', $path . '/' . $file);
		}
	}

	closedir($dh);
}
else
{
	print "ERROR: The path you requested cannot be read! \n ";
	print "\n";
	print_help();
	exit;
}

// check if there is the default language defined

if(!isset($files[$baseLanguage]))
{
	print "ERROR: The baselanguage cannot be found! \n";
	print "\n";
	print_help();
	exit;
}

// import the baselanguage

$base = import($files[$baseLanguage]);

// and unset it in the files, because we don't need to compare base to base

unset($files[$baseLanguage]);

// compare each language with the baselanguage

foreach($files as $key => $file)
{
	$comp = import($file);
	print "\n\nComparing " . $baseLanguage . " to " . $key . "\n";
	$result = compare($base, $comp);

	if(is_array($result)
	   && sizeof($result) > 0)
	{
		print "  found missing strings: \n";
		foreach($result as $value)
		{
			print "    " . $value . "\n";
		}
	}
	else
	{
		print "   no missing strings found! \n ";
	}

	print "\nReverse Checking " . $key . " to " . $baseLanguage . "\n";
	$result = compare($comp, $base);

	if(is_array($result)
	   && sizeof($result) > 0)
	{
		print "  found strings not in basefile: \n";
		foreach($result as $key => $value)
		{
			print "    " . $value . "\n";
		}
	}
	else
	{
		print "   There are no strings which are not in the basefile! \n ";
	}
}

//-----------------------------------------------------------------------------------------
// FUNCTIONS
//-----------------------------------------------------------------------------------------

/**
 * prints the help screen
 *
 * @param  array  $argv
 */

function print_help($argv)
{
	print "Usage: php " . $argv[0] . " /PATH/TO/LNG \n";
	print " \n ";
}

function import($file)
{
	$input = file($file);
	$return = array();
	foreach($input as $key => $value)
	{
		if(!preg_match('/^\$/', $value))
		{
			unset($input[$key]);
		}
		else
		{
			// generate the key

			$key = preg_replace('/^\$lng\[\'(.*)=(.*)$/U', '\\1', $value);
			$key = str_replace('[\'', '/', $key);
			$key = trim(str_replace('\']', '', $key));

			//generate the value

			$value = trim($value);

			// set the result

			$return[$key] = $value;
		}
	}

	return $return;
}

function compare($array1, $array2)
{
	$result = array();
	foreach($array1 as $key => $value)
	{
		if(!isset($array2[$key]))
		{
			$result[$key] = $value;
		}
	}

	return $result;
}

?>
