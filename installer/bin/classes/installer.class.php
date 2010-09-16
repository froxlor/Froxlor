<?php

define(I_YES, 1);
define(I_NO, 0);

/* OS dependend files */
define(OS_CHK_DEBIAN, "/etc/debian_version");
define(OS_CHK_OTHER, "/etc/*-release");

define(OS_DEBIANSARGE, '1');
define(OS_DEBIANETCH, '2');
define(OS_DEBIANLENNY, '3');
define(OS_GENTOO, '4');
define(OS_SUSE, '5');
define(OS_UBUNTU, '6');
define(OS_OTHER, '99');

define(TPL_PATH, '/templates/misc/configfiles/');

class System
{
	private static $useflags = array();

	public function __construct() 
	{ 
		self::$useflags['aps'] = false;
		self::$useflags['autoresponder'] = false;
		self::$useflags['billing'] = false;
		self::$useflags['bind'] = false;
		self::$useflags['domainkey'] = false;
		self::$useflags['dovecot'] = false;
		self::$useflags['fcgid'] = false;
		self::$useflags['lighttpd'] = false;
		self::$useflags['log'] = true;
		self::$useflags['mailquota'] = false;
		self::$useflags['ssl'] = false;
		self::$useflags['tickets'] = true;
	}

	public function getOS()
	{
		if ( file_exists ( OS_CHK_DEBIAN ) ) 
		{
			$_debv = '';
			$_debv = system('cat ' . OS_CHK_DEBIAN);

			if ( $_debv == '3.1' )	
			{
				return OS_DEBIANSARGE;
			}
			elseif ( $_debv == '4.0' )
			{
				return OS_DEBIANETCH;
			}
			elseif ( $_debv == '5.0' )
			{
				return OS_DEBIANLENNY;
			}
			else
			{
				return OS_OTHER;
			}
		}
		else
		{
			$_osv = array();
			@exec( 'cat ' . OS_CHK_OTHER, $_osv);

			if ($_osv == null || $_osv[0] == '')
				return OS_OTHER;

			if ( strtolower( substr( $_osv[0], 0, 6 ) ) == 'gentoo' ) {
				return OS_GENTOO;
			}
			elseif ( strtolower( substr( $_osv[0], 0, 8 ) ) == 'opensuse'
			  || strtolower( substr( $_osv[0], 0, 4 ) ) == 'suse') {
				return OS_SUSE;
			}
			elseif ( strtolower( substr( $_osv[0], 11, 6 ) ) == 'ubuntu' ) {
				return OS_UBUNTU;
			}
			else {
				return OS_OTHER;
			}
		}
	}

	public function getOSName($os = OS_OTHER)
	{
		switch($os)
		{
			case OS_DEBIANSARGE:
				$ret = 'Debian Sarge';
				break;
			case OS_DEBIANETCH:
				$ret = 'Debian Etch';
				break;
			case OS_DEBIANLENNY:
				$ret = 'Debian Lenny';
				break;
			case OS_GENTOO:
				$ret = 'Gentoo Linux';
				break;
			case OS_SUSE:
				$ret = 'SuSE Linux';
				break;
			case OS_UBUNTU:
				$ret = 'Ubuntu';
				break;
			case OS_OTHER:
			default:
				$ret = 'an unknown OS. You should not see this!';
				break;
		}
		return $ret;
	}

	public function setUseflag($flag = null, $value = '')
	{
		$flag = strtolower($flag);

		if (isset(self::$useflags[$flag])) {
			self::$useflags[$flag] = isset($value) ? (int)$value : false;
		} else {
			return false;
		}
	}

	public function getUseflag($flag = null)
	{
		$flag = strtolower($flag);

		if (isset(self::$useflags[$flag])) {
			return self::$useflags[$flag];
		} else {
			return false;
		}
	}

	public function confReplace($haystack = null, $needle = null, $file = null)
	{
		if (file_exists($file))
		{
			@exec('sed -e "s|'.$needle.'|'.$haystack.'|g" -i ' . $file);
		} else {
			$this->ewarn("WARNING: File '".$file."' could not be found! Check paths!!!");
			die("\nHave to abort install process, could not perform a required action.\n\n");
			}
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

	public function getYesNo($default = null)
	{
		$value = null;

		while(true)
		{
			$this->getInput($_v);

			if(strtolower($_v) == 'y' || strtolower($_v) == 'yes') {
				$value = I_YES;
				break;
			}
			elseif(strtolower($_v) == 'n' || strtolower($_v) == 'no') {
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

	public function getDirectory($default = null)
	{
		$value = null;

		while(true)
		{
			$this->getInput($_v);

			if ($_v == '' && $default != null) {
				$value = $default;
				if (!is_dir($value)) {
					echo "Sorry, directory '" . $value . "' does not exist. Create it? [Y/n]: ";
					$cdir = $this->getYesNo(I_YES);
					if($cdir == I_YES) {
						exec("mkdir -p " . $value);
						break;
					} else {
						$value = null;
						echo "Please input directory [".$value."]: ";
						continue;
					}
				} else {
					break;
				}
			} else {
				$_v = $this->makeCorrectDir($_v);
				if (!is_dir($_v)) {
					echo "Sorry, directory '" . $_v . "' does not exist. Create it? [y/N]: ";
					$cdir = $this->getYesNo(I_NO);
					if($cdir == I_YES) {
						exec("mkdir -p " . $_v);
						$value = $_v;
						break;
					} else {
						$value = null;
						echo "Please input directory [".$_v."]: ";
						continue;
					}
				} else {
					$value = $_v;
					break;
				}
			}
		}
		return $value;
	}

	public function getInput(&$inputvar)
	{
		$inputvar = trim(fgets(STDIN));
	}

	public function makedir($directory = null, $chmod = "0755", $chown = "root:root")
	{
		if($directory != null)
		{
			echo "Creating directory '".$directory."'\t\t";
			exec("mkdir -p " . $directory);
			exec("chown " . $chown . " " . $directory);
			exec("chmod " . $chmod . " " . $directory);
			echo "[OK]\n";
		} else {
			$this->ewarn("Can't create empty directory");
		}
	}

	public function ewarn($msg = null)
	{
		echo "\n*";
		if(!is_array($msg) && $msg != '') { 
			echo "\n* ".$msg;
		} elseif(is_array($msg)) {
			foreach($msg as $line) {
				echo "\n* ".$line;
			}
		} else {
			echo "\n* EMPTY WARNING! Should *not* happen!";
		}
		echo "\n*\n\n";
	}

	private function getOSPathName($os = OS_OTHER)
	{
		switch($os)
		{
			case OS_DEBIANSARGE:
				$ret = 'debian_etch';
				break;
			case OS_DEBIANETCH:
				$ret = 'debian_etch';
				break;
			case OS_DEBIANLENNY:
				$ret = 'debian_etch';
				break;
			case OS_GENTOO:
				$ret = 'gentoo';
				break;
			case OS_SUSE:
				$ret = 'suse_linux_10_0';
				break;
			case OS_UBUNTU:
				$ret = 'ubuntu_hardy';
				break;
			case OS_OTHER:
			default:
				$ret = 'other';
				break;
		}
		return $ret;
	}

	private function serviceExists($sdir, $os, $service)
	{
		$service_dir = $this->makeCorrectDir($sdir.TPL_PATH.$this->getOSPathName($os).'/'.$service);
		if(is_dir($service_dir)) {
			return true;
		} else {
			return false;
		}
	}

	private function templateExists($sdir, $os, $service, $tpl)
	{
		$service_dir = $this->makeCorrectDir($sdir.TPL_PATH.$this->getOSPathName($os).'/'.$service);
		$template = $service_dir . $tpl;
		if(file_exists($template)) {
			return true;
		} else {
			return false;
		}
	}

	public function getConfPath($sdir, $os, $service, $tpl)
	{
		$service_dir = $this->makeCorrectDir($sdir.TPL_PATH.$this->getOSPathName($os).'/'.$service);
		$template = $service_dir . $tpl;
		return $template;
	}

	public function doconf($froxlordir = null, $os = OS_OTHER, $service = null, $origin = null, $tpl = null, $replacers = null)
	{
		if($froxlordir == null || $froxlordir == '')
		{
			$this->ewarn("Ups, where's the froxlordir gone?!");
			return;
		}

		if($os == OS_OTHER)
		{
			$this->ewarn("We don't have configuration templates for your system");
			return;
		}

		if($service == null || $service == '' || $this->serviceExists($froxlordir, $os, $service) == FALSE)
		{
			$this->ewarn("We don't have ".$service."-configurations for your system!");
			return;
		}

		if($tpl == null || $tpl == '' || $this->templateExists($froxlordir, $os, $service, $tpl) == FALSE)
		{
			$this->ewarn("Can't find ".$service."-configuration template '".$tpl."'");
			return;
		}

		if($origin == null || $origin == '')
		{
			$this->ewarn("No destination file given for '".$service."' - don't know where to save the config!");
			return;
		}

		if($origin != '' && file_exists($origin))
		{
			$this->ewarn("File '".$origin."' already exists, we'll create a backup named '".$origin.".bak'");
			exec("mv " . $origin . " " . $origin . ".bak");
		}

		$newconf = $this->getConfPath($froxlordir, $os, $service, $tpl);

		echo "Copying new configuration file for '".$service."'\t\t";
		exec("cp " . $newconf . " " . $origin);

		// sed replacers
		if(is_array($replacers))
		{
			foreach($replacers as $haystack => $needle)
			{
				exec('sed -e "s|'.$haystack.'|'.$needle.'|g -i '.$origin);
			}
		}

		echo "[OK]\n";
	}

	private function makeSecurePath($path)
	{
		$search = Array(
			'#/+#',
			'#\.+#',
			'#\0+#'
		);
		$replace = Array(
			'/',
			'.',
			''
		);
		$path = preg_replace($search, $replace, $path);
		return $path;
	}

	private function makeCorrectDir($dir)
	{
		if(substr($dir, -1, 1) != '/')
		{
			$dir.= '/';
		}
		
		if(substr($dir, 0, 1) != '/')
		{
			$dir = '/' . $dir;
		}
		
		$dir = $this->makeSecurePath($dir);
		return $dir;
	}

	public function showHelp()
	{
		$this->ewarn(array(
			"Usage:\t\t./install [options]",
			"",
			"Options are:",
			"",
			"aps\t\t\tApplication Packaging Standard [default: Off]",
			"autoresponder\t\tE-Mail autoresponder [default: Off]",
			"billing\t\tComplete billing system [default: Off]",
			"bind\t\t\tBind nameserver [default: Off]",
			"domainkey\t\tDomainkey service, needs 'bind' [default: Off]",
			"dovecot\t\tUse dovecot e-mailserver instead of courier [default: Off]",
			"fcgid\t\t\tRun PHP as FCGID (apache only) [default: Off]",
			"lighttpd\t\tUse lighttpd instead of apache2 [default: Off]",
			"log\t\t\tEnables the froxlor logging system [default: On]",
			"mailquota\t\tEnables mailquota for the mailserver [default: Off]",
			"ssl\t\t\tEnable ssl for web-, mail- and ftpserver [default: Off]",
			"tickets\t\tFroxlor ticket system [default: On]",
			"",
			"Notice: You can also disable features by putting a '-' before the name:",
			"for example: ./install -log -tickets")
		);
		die;
	}
}

?>