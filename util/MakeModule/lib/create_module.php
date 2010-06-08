<?php

if (function_exists("date_default_timezone_set") 
	&& function_exists("date_default_timezone_get")
) {
	@date_default_timezone_set(@date_default_timezone_get());
}

define('I_YES', 1);
define('I_NO', 0);

$system = new MakeModule();
$data = array();

echo "Starting Froxlor module-builder...\n\n";

echo "Path to build module [".getcwd()."]: ";
$data['path'] = $system->getString(getcwd());

echo "Author name [unknown author]: ";
$data['author']['name'] = $system->getString('unknown author');

echo "Author e-mail address [author@domain.tld]: ";
$data['author']['mail'] = $system->getString('author@domain.tld');

echo "Vendor name [NewVendor]: ";
$data['vendor'] = ucfirst($system->getString('NewVendor'));

echo "Module name [MyModule]: ";
$data['module'] = ucfirst($system->getString('MyModule'));

echo "Module version [1.0]: ";
$data['version'] = $system->getString('1.0');

echo "Short description [user was too lazy to edit this]: ";
$data['shortdesc'] = $system->getString('user was too lazy to edit this');

echo "Module website [http://example.com]: ";
$data['website'] = $system->getString('http://example.com');

/**
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */

$system->ewarn(array(
	"Configuration complete so far",
	"I will now create all necessary files for you")
);

echo "Would you like to build the Froxlor module now? [Y/n]: ";
$proceed = $system->getYesNo(I_YES);


if($proceed == I_YES) 
{
	echo "Creating all necessary files in '".$data['path']."'\n";
	$module_path = $data['path'].'/'.$data['vendor'].'/'.$data['module'];
	
	if (is_dir($module_path)) {
		$system->ewarn("Path '".$module_path."' already exists");
		echo "Would you like to continue? [y/N]: ";
		$proceedmkdir = $system->getYesNo(I_NO);
	} else {
		$proceedmkdir = I_YES;
	}
	
	if ($proceedmkdir == I_NO) {
		exit;
	}

	$system->makedir($module_path);
	
	echo "Getting module-skeleton\t\t";
	$module_skeleton = @file_get_contents(dirname(__FILE__).'/tpl/rawmodule.phps');
	echo "[OK]\n";

	echo "Replacing all values in skeleton\t\t";
	/**
	 * replace all values
	 */
	$module_skeleton = str_replace('{$MODULE_NAME}', $data['vendor'].$data['module'], $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_SHORTDESC}', $data['shortdesc'], $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_VENDOR}', $data['vendor'], $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_MODULE}', $data['module'], $module_skeleton);
	$module_skeleton = str_replace('{$AUTHOR_NAME}', $data['author']['name'], $module_skeleton);
	$module_skeleton = str_replace('{$AUTHOR_EMAIL}', $data['author']['mail'], $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_CR}', date('Y', time()), $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_VERSION}', $data['version'], $module_skeleton);
	$module_skeleton = str_replace('{$MODULE_WEBSITE}', $data['website'], $module_skeleton);
	echo "[OK]\n";
	
	echo "Saving bew module to '".$module_path."'\t\t";
	$mod_file = $module_path.'/module.'.$data['vendor'].$data['module'].'.php';
	
	if (file_exists($mod_file)) {
		$system->ewarn("File '".$mod_file."' already exists");
		echo "Would you like to continue (overwrite file)? [y/N]: ";
		$proceedovrw = $system->getYesNo(I_NO);
	} else {
		$proceedovrw = I_YES;
	}
	
	if ($proceedovrw == I_NO) {
		exit;
	}

	$mod = @fopen($mod_file, 'w');

	if ($mod !== false) {
		
		fwrite($mod, $module_skeleton);
		fclose($mod);
		echo "[OK]\n";

	} else {
		echo "[!!]\n";
		$system->ewarn(array(
			"Ups, i cannot create a new file in '".$module_path."'",
			"",
			"Sorry have to abort :(")
		);
		exit;
	}
	
	echo "Creating metadata.xml file\t\t";
	
	if (file_exists($module_path.'/metadata.xml')) {
		$system->ewarn("File '".$module_path.'/metadata.xml'."' already exists");
		echo "Would you like to continue (overwrite file)? [y/N]: ";
		$proceedovrw = $system->getYesNo(I_NO);
	} else {
		$proceedovrw = I_YES;
	}
	
	if ($proceedovrw == I_NO) {
		exit;
	}
		
	$xml = @fopen($module_path.'/metadata.xml', 'w');
	
	if ($xml !== false) {
		
		$raw_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<froxlormodule>
	<information>
		<vendor>'.$data['vendor'].'</vendor>
		<module>'.$data['module'].'</module>
		<version>'.$data['version'].'</version>
		<description>'.$data['shortdesc'].'</description>
		<longdescription>'.$data['shortdesc'].'</longdescription>
		<website>'.$data['website'].'</website>
		<authorgroup>
			<author>
				<name>'.$data['author']['name'].'</name>
				<email>'.$data['author']['mail'].'</email>
			</author>
		</authorgroup>
		<copyright>'.date('Y', time()).'</copyright>
	</information>
	<dependencies>
	</dependencies>
</froxlormodule>
';
		fwrite($xml, $raw_xml);
		fclose($xml);
		echo "[OK]\n";
		
	} else {
		echo "[!!]\n";
		$system->ewarn(array(
			"Ups, i cannot create a new file in '".$module_path."'",
			"",
			"Sorry have to abort :(")
		);
		exit;
	}
	
}

echo "Finished\n";
exit;

/**
 * +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 */

final class MakeModule
{
	
	public function __construct() {
		/* null */
	}

	public function getString($default = null)
	{
		$value = null;

		while(true)
		{
			$this->getInput($_v);

			if ($_v == '' && $default != null) {
				$value = $default;
				break;
			} elseif($_v == '' && $default == null) {
				echo "Please enter a value: ";
				$value = null;
				continue;
			} else {
				$value = $_v;
				break;
			}
		}

		return $value;
	}
	
	private function getInput(&$inputvar)
	{
		$inputvar = trim(fgets(STDIN));
	}
	
	public function getYesNo($default = null)
	{
		$value = null;

		while (true) {
			$this->getInput($_v);

			if (strtolower($_v) == 'y' || strtolower($_v) == 'yes') {
				$value = I_YES;
				break;
			}
			elseif (strtolower($_v) == 'n' || strtolower($_v) == 'no') {
				$value = I_NO;
				break;
			}
			else
			{
				if ($_v == '' && $default != null) {
					$value = $default;
					break;
				} else {
					echo "Sorry, response " . $_v . " not understood. Please enter 'yes' or 'no'\n";
					$value = null;
					continue;
				}
			}
		}

		return $value;
	}	

	public function makedir($directory = null, $chmod = "0755", $chown = "")
	{
		if ($directory != null) {
			echo "Creating directory '".$directory."'\t\t";
			exec("mkdir -p " . escapeshellarg($directory));
			if ($chown != '') {
				exec("chown " . escapeshellarg($chown) . " " . escapeshellarg($directory));
			}
			exec("chmod " . escapeshellarg($chmod) . " " . escapeshellarg($directory));
			echo "[OK]\n";
		} else {
			$this->ewarn("Can't create empty directory");
		}
	}

	public function ewarn($msg = null)
	{
		echo "\n*";
		if (!is_array($msg) && $msg != '') { 
			echo "\n* ".$msg;
		} elseif (is_array($msg)) {
			foreach ($msg as $line) {
				echo "\n* ".$line;
			}
		} else {
			echo "\n* EMPTY WARNING! Should *not* happen!";
		}
		echo "\n*\n\n";
	}
}
