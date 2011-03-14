<?php

require_once ('./bin/classes/installer.class.php');

$system = new System();

if(isset($argv[1]))
{
	foreach($argv as $parm)
	{
		$parm = strtolower($parm);
		switch($parm)
		{
			case 'aps':
				$system->setUseflag('aps', true);
				break;
			case '-aps':
				$system->setUseflag('aps', false);
				break;
			case 'autoresponder':
				$system->setUseflag('autoresponder', true);
				break;
			case '-autoresponder':
				$system->setUseflag('autoresponder', false);
				break;
			case 'awstats':
				$system->setUseflag('awstats', true);
				break;
			case '-awstats':
				$system->setUseflag('awstats', false);
				break;
			case 'bind':
				$system->setUseflag('bind', true);
				break;
			case '-bind':
				$system->setUseflag('bind', false);
				break;
			case 'domainkey':
				$system->setUseflag('domainkey', true);
				break;
			case '-domainkey':
				$system->setUseflag('domainkey', false);
				break;
			case 'dovecot':
				$system->setUseflag('dovecot', true);
				break;
			case '-dovecot':
				$system->setUseflag('dovecot', false);
				break;
			case 'fcgid':
				$system->setUseflag('fcgid', true);
				break;
			case '-fcgid':
				$system->setUseflag('fcgid', false);
				break;
			case 'ftpquota':
				$system->setUseflag('ftpquota', true);
				break;
			case '-ftpquota':
				$system->setUseflag('ftpquota', false);
				break;
			case 'fpm':
				$system->setUseflag('fpm', true);
				break;
			case '-fpm':
				$system->setUseflag('fpm', false);
				break;
			case 'lighttpd':
				$system->setUseflag('lighttpd', true);
				break;
			case '-lighttpd':
				$system->setUseflag('lighttpd', false);
				break;
			case 'log':
				$system->setUseflag('log', true);
				break;
			case '-log':
				$system->setUseflag('log', false);
				break;
			case 'mailquota':
				$system->setUseflag('mailquota', true);
				break;
			case '-mailquota':
				$system->setUseflag('mailquota', false);
				break;
			case 'nginx':
				$system->setUseflag('nginx', true);
				break;
			case '-nginx':
				$system->setUseflag('nginx', false);
				break;
			case 'pureftpd':
				$system->setUseflag('pureftpd', true);
				break;
			case '-pureftpd':
				$system->setUseflag('pureftpd', false);
				break;
			case 'ssl':
				$system->setUseflag('ssl', true);
				break;
			case '-ssl':
				$system->setUseflag('ssl', false);
				break;
			case 'tickets':
				$system->setUseflag('tickets', true);
				break;
			case '-tickets':
				$system->setUseflag('tickets', false);
				break;
			case '--help':
				$system->showHelp();
				break;
		}
	}
}

echo "Starting Froxlor shell-installer...\n";

$system->ewarn(array(
		"Please be sure that you have not yet configured Froxlor",
		"the shell-installer will overwrite an existing database!")
		);

/* Show what we are going to install! */

echo "Intalling Froxlor with the following options:\n\n";

echo "- APS \t\t[" . (($system->getUseflag('aps') == true) ? 'On' : 'Off') . "]\n";
echo "- Autoresponder [" . (($system->getUseflag('autoresponder') == true) ? 'On' : 'Off') . "]\n";
echo "- Awstats [" . (($system->getUseflag('awstats') == true) ? 'On' : 'Off') . "]\n";
echo "- Bind \t\t[" . (($system->getUseflag('bind') == true) ? 'On' : 'Off') . "]\n";
echo "- Domainkey \t[" . (($system->getUseflag('domainkey') == true) ? 'On' : 'Off') . "]\n";
echo "- Dovecot \t[" . (($system->getUseflag('dovecot') == true) ? 'On' : 'Off') . "]\n";
echo "- Fcgid \t[" . (($system->getUseflag('fcgid') == true) ? 'On' : 'Off') . "]\n";
echo "- FTP-quota \t[" . (($system->getUseflag('ftpquota') == true) ? 'On' : 'Off') . "]\n";
echo "- PHP-FPM \t[" . (($system->getUseflag('fpm') == true) ? 'On' : 'Off') . "]\n";
echo "- Lighttpd \t[" . (($system->getUseflag('lighttpd') == true) ? 'On' : 'Off') . "]\n";
echo "- Log \t\t[" . (($system->getUseflag('log') == true) ? 'On' : 'Off') . "]\n";
echo "- Mailquota \t[" . (($system->getUseflag('mailquota') == true) ? 'On' : 'Off') . "]\n";
echo "- nginx \t[" . (($system->getUseflag('nginx') == true) ? 'On' : 'Off') . "]\n";
echo "- PureFTPd \t[" . (($system->getUseflag('pureftpd') == true) ? 'On' : 'Off') . "]\n";
echo "- SSL \t\t[" . (($system->getUseflag('ssl') == true) ? 'On' : 'Off') . "]\n";
echo "- Tickets \t[" . (($system->getUseflag('tickets') == true) ? 'On' : 'Off') . "]\n";
echo "\n";

$os = $system->getOS();

if($os == OS_OTHER) {
	$system->ewarn(array(
			"Ups, looks like you are running an unsupported OS!",
			"",
			"If you know what you are doing proceed",
			"but the installer won't configure the services")
		);
} else {
	if($os < OS_DEBIANLENNY) {
		$system->ewarn(array(
			"The system you are using (".$system->getOSName($os).") is pretty old.",
			"Froxlor does not provide configuration templates for your OS anymore.",
			"",
			"If you know what you are doing proceed",
			"but the installer won't configure the services"
		));
	} else {
		echo "OK, looks like you are running " . $system->getOSName($os) . ".\n";
	}
}

echo "Would you like to configure Froxlor now? [Y/n]: ";
$proceed = $system->getYesNo(I_YES);

if($proceed == I_YES) 
{
	/* hit the shit */
	
	/* check for sane use-flags */
	if ($system->getUseflag('lighttpd') && $system->getUseflag('fcgid')) {
		$system->ewarn("PLEASE NOTE: The lighttpd flag overwrites fcgid!");
	}

	if ($system->getUseflag('lighttpd') && $system->getUseflag('nginx')) {
		$system->ewarn("You cannot use two webservers at once. Please unset either lighttpd or nginx (or both for apache)");
		die();
	}

	if ($system->getUseflag('fcgid') && $system->getUseflag('fpm')) {
		$system->ewarn("You cannot use two php-interfaces at once. Please unset either fcgid or fpm (or both for mod_php)");
		die();
	}

	echo "Please enter the directory where Froxlor has been extracted to [/var/www/froxlor/]: ";
	$basedir = $system->getDirectory('/var/www/froxlor/');

	// copy the sql-file to /tmp so we don't screw up the original file
	$sqltmp = "/tmp/froxlor.sql";
	exec("cp " . $basedir . "install/froxlor.sql " . $sqltmp);
	if(!file_exists($sqltmp))
	{
		$system->ewarn("Could not create temporary file '".$sqltmp."'...have to abort!");
		die();
	}

	// get all the directories we need
	$docroot = array('web' => null, 'mail' => null, 'logs' => null, 'tmp' => null, 'fcgid' => null, 'fpm' => null);

	echo "Please enter the customer docroot directory [/var/customers/web/]: ";
	$docroot['web'] = $system->getDirectory('/var/customers/web/');

	echo "Please enter the customer mail directory [/var/customers/mail/]: ";
	$docroot['mail'] = $system->getDirectory('/var/customers/mail/');

	echo "Please enter the customer logs directory [/var/customers/logs/]: ";
	$docroot['logs'] = $system->getDirectory('/var/customers/logs/');

	if($system->getUseflag('fcgid'))
	{
		echo "Please enter the customer tmp directory [/var/customers/tmp/]: ";
		$docroot['tmp'] = $system->getDirectory('/var/customers/tmp/');

		echo "Please enter the fcgid starter files directory [/var/www/php-fcgi-scripts/]: ";
		$docroot['fcgid'] = $system->getDirectory('/var/www/php-fcgi-scripts/');
	}

	if($system->getUseflag('fpm'))
	{
		echo "Please enter the customer tmp directory [/var/customers/tmp/]: ";
		$docroot['tmp'] = $system->getDirectory('/var/customers/tmp/');

		echo "Please enter the fpm configuration directory [/etc/php-fpm.d/]: ";
		$docroot['fpm'] = $system->getDirectory('/etc/php-fpm.d/');
	}

	echo "Setting paths";
	$system->confReplace("'system', 'documentroot_prefix', '".$docroot['web']."'", "'system', 'documentroot_prefix', '/var/customers/webs/'", $sqltmp);
	echo "...";
	$system->confReplace("'system', 'vmail_homedir', '".$docroot['mail']."'", "'system', 'vmail_homedir', '/var/customers/mail/'", $sqltmp);
	echo "...";
	$system->confReplace("'system', 'logfiles_directory', '".$docroot['logs']."'", "'system', 'logfiles_directory', '/var/customers/logs/'", $sqltmp);
	echo "...";
	if($system->getUseflag('fcgid'))
	{
		$system->confReplace("'system', 'mod_fcgid_tmpdir', '".$docroot['tmp']."'", "'system', 'mod_fcgid_tmpdir', '/var/customers/tmp'", $sqltmp);
		echo "...";	
		$system->confReplace("'system', 'mod_fcgid_configdir', '".$docroot['fcgid']."'", "'system', 'mod_fcgid_configdir', '/var/www/php-fcgi-scripts'", $sqltmp);
		echo "...";
	}
	if($system->getUseflag('fpm'))
	{
		$system->confReplace("'phpfpm', 'tmpdir', '".$docroot['tmp']."'", "'phpfpm', 'tmpdir', '/var/customers/tmp'", $sqltmp);
		echo "...";	
		$system->confReplace("'phpfpm', 'configdir', '".$docroot['fcgid']."'", "'phpfpm', 'configdir', '/etc/php-fpm.d/'", $sqltmp);
		echo "...";
	}
	echo "[OK]\n";

	// create local users 
	echo "Creating users...\n";
	$users = array('froxlor' => 9995, 'froxlorftpd' => 9996, 'vmail' => 9997);

	// main user
	echo "Please enter the uid for the froxlor user [9995]: ";
	$users['froxlor'] = $system->getInt(9995);

	@exec("groupadd -g ".$users['froxlor']." froxlor");
	echo "...";
	@exec("useradd -u ".$users['froxlor']." -s /bin/false -d ".$basedir." -g froxlor froxlor");
	echo "...";

	// ftp user
	echo "Please enter the uid for the froxlor-ftpd user [9996]: ";
	$users['froxlorftpd'] = $system->getInt(9996);

	@exec("groupadd -g ".$users['froxlorftpd']." froxlorftpd");
	echo "...";
	@exec("useradd -u ".$users['froxlorftpd']." -s /bin/false -d ".$docroot['web']." -g froxlorftpd froxlorftpd");
	echo "...";

	// vmail user
	echo "Please enter the uid for the vmail user [9997]: ";
	$users['vmail'] = $system->getInt(9997);

	@exec("groupadd -g ".$users['vmail']." vmail");
	echo "...";
	@exec("useradd -u ".$users['vmail']." -s /bin/false -d ".$docroot['mail']." -g vmail vmail");
	echo "...";
	echo "[OK]\n";

	// create directories
	echo "Creating Froxlor directories...";
	$system->makedir($docroot['web']);
	$system->makedir($docroot['mail'], "0755", "vmail:vmail");
	$system->makedir($docroot['logs']);
	if($system->getUseflag('fcgid'))
	{
		$system->makedir($docroot['tmp']);
		$system->makedir($docroot['fcgid']);
	}
	if($system->getUseflag('fpm'))
	{
		$system->makedir($docroot['tmp']);
		$system->makedir($docroot['fpm']);
	}
	echo "[OK]\n";

	/* sed the froxlor.sql file (and maybe others) */
	if($os == OS_GENTOO) {
		echo "Setting 'lastguid' to '10000'\t\t";
		$system->confReplace("'lastguid', '10000'", "'lastguid', '9999'", $sqltmp);
		echo "[OK]\n";

		echo "Setting 'vmail_uid' and 'vmail_gid' to '".$users['vmail']."'\t\t";
		$system->confReplace("'vmail_uid', '".$users['vmail']."'", "'vmail_uid', '2000'", $sqltmp);
		$system->confReplace("'vmail_gid', '".$users['vmail']."'", "'vmail_gid', '2000'", $sqltmp);
		echo "[OK]\n";
	}

	if ($system->getUseflag('lighttpd'))
	{
		echo "Switching settings to fit 'lighttpd'\t\t";
		$system->confReplace("/etc/init.d/lighttpd restart", "/etc/init.d/apache reload", $sqltmp);
		$system->confReplace("'webserver', 'lighttpd'", "'webserver', 'apache2'", $sqltmp);
		$system->confReplace("'apacheconf_vhost', '/etc/lighttpd/froxlor-vhosts.conf'", "'apacheconf_vhost', '/etc/apache/vhosts.conf'", $sqltmp);
		$system->confReplace("'apacheconf_diroptions', '/etc/lighttpd/diroptions.conf'", "'apacheconf_diroptions', '/etc/apache/diroptions.conf'", $sqltmp);
		$system->confReplace("'apacheconf_htpasswddir', '/etc/lighttpd/htpasswd/'", "'apacheconf_htpasswddir', '/etc/apache/htpasswd/'", $sqltmp);
		echo "[OK]\n";
		if($os == OS_GENTOO) {
			$httpd = 'lighttpd';
		}
		else {
			$httpd = 'www-data';
		}
		echo "Please enter the webserver system user [".$httpd."]: ";
		$httpd = $system->getString($httpd);
		if ($httpd != 'www-data') {
			$system->confReplace("'httpuser', '".$httpd."'", "'httpuser', 'www-data'", $sqltmp);
			$system->confReplace("'httpgroup', '".$httpd."'", "'httpgroup', 'www-data'", $sqltmp);
		}
	} 
	elseif ($system->getUseflag('nginx')) 
	{
		echo "Switching settings to fit 'nginx'\t\t";
		$system->confReplace("/etc/init.d/nginx restart", "/etc/init.d/apache reload", $sqltmp);
		$system->confReplace("'webserver', 'nginx'", "'webserver', 'apache2'", $sqltmp);
		$system->confReplace("'apacheconf_vhost', '/etc/nginx/froxlor-vhosts.conf'", "'apacheconf_vhost', '/etc/apache/vhosts.conf'", $sqltmp);
		$system->confReplace("'apacheconf_diroptions', '/etc/nginx/diroptions.conf'", "'apacheconf_diroptions', '/etc/apache/diroptions.conf'", $sqltmp);
		$system->confReplace("'apacheconf_htpasswddir', '/etc/nginx/htpasswd/'", "'apacheconf_htpasswddir', '/etc/apache/htpasswd/'", $sqltmp);
		echo "[OK]\n";
		if($os == OS_GENTOO) {
			$httpd = 'nginx';
		}
		else {
			$httpd = 'www-data';
		}
		echo "Please enter the webserver system user [".$httpd."]: ";
		$httpd = $system->getString($httpd);
		if ($httpd != 'www-data') {
			$system->confReplace("'httpuser', '".$httpd."'", "'httpuser', 'www-data'", $sqltmp);
			$system->confReplace("'httpgroup', '".$httpd."'", "'httpgroup', 'www-data'", $sqltmp);
		}
	}
	else 
	{
		echo "Switching settings to fit 'apache2'\t\t";
		$system->confReplace("/etc/init.d/apache2 reload", "/etc/init.d/apache reload", $sqltmp);
		$system->confReplace("'apacheconf_vhost', '/etc/apache2/vhosts.d/99_froxlor-vhosts.conf'", "'apacheconf_vhost', '/etc/apache/vhosts.conf'", $sqltmp);
		$system->confReplace("'apacheconf_diroptions', '/etc/apache2/diroptions.conf'", "'apacheconf_diroptions', '/etc/apache/diroptions.conf'", $sqltmp);
		$system->confReplace("'apacheconf_htpasswddir', '/etc/apache2/htpasswd/'", "'apacheconf_htpasswddir', '/etc/apache/htpasswd/'", $sqltmp);
		echo "[OK]\n";
		if($os == OS_GENTOO) {
			$httpd = 'apache';
		}
		else {
			$httpd = 'www-data';
		}
		echo "Please enter the webserver system user [".$httpd."]: ";
		$httpd = $system->getString($httpd);
		if ($httpd != 'www-data') {
			$system->confReplace("'httpuser', '".$httpd."'", "'httpuser', 'www-data'", $sqltmp);
			$system->confReplace("'httpgroup', '".$httpd."'", "'httpgroup', 'www-data'", $sqltmp);
		}
	}

	// set mod_fcgid to "1" if it's wanted
	if ($system->getUseflag('fcgid') == true)
	{
		echo "Switching 'fcgid' to 'On'\t\t";
		$system->confReplace("'mod_fcgid', '1'", "'mod_fcgid', '0'", $sqltmp);
		echo "[OK]\n";
		$system->makedir($docroot['tmp']);
		if($os == OS_GENTOO) {
			$system->ewarn("You have to remove the '-D PHP5' entry from /etc/conf.d/apache2 if it exists!");
		}
	}

	// set php-fpm to "1" if it's wanted
	if ($system->getUseflag('fpm') == true)
	{
		echo "Switching 'fpm' to 'On'\t\t";
		$system->confReplace("'phpfpm', 'enabled', '1'", "'phpfpm', 'enabled', '0'", $sqltmp);
		$system->confReplace("'phpfpm', 'enabled_ownvhost', '1'", "'phpfpm', 'enabled_ownvhost', '0'", $sqltmp);
		$system->confReplace("'phpfpm', 'vhost_httpuser', 'froxlor'", "'phpfpm', 'vhost_httpuser', 'froxlorlocal'", $sqltmp);
		$system->confReplace("'phpfpm', 'vhost_httpgroup', 'froxlor'", "'phpfpm', 'vhost_httpgroup', 'froxlorlocal'", $sqltmp);
		echo "[OK]\n";
		$system->makedir($docroot['tmp']);
	}

	// If Bind is not to be used, change the reload path for it
	if (!$system->getUseflag('bind'))
	{
		echo "Switching 'bind' to 'Off'\t\t";
		$system->confReplace("/bin/true", "/etc/init.d/named reload", $sqltmp);
		echo "[OK]\n";

		// Delete any mention of inserttask('4') if no Bind is used
		exec('find "'.$basedir.'" -type f -exec sed -e "s|inserttask(\'4\');||g" -i {} \;');
	}

	// default value is logging_enabled='1'
	if (!$system->getUseflag('log'))
	{
		echo "Switching 'log' to 'Off'\t\t";
		$system->confReplace("'logger', 'enabled', '0'", "'logger', 'enabled', '1'", $sqltmp);
		echo "[OK]\n";
	}

	// default value is tickets_enabled='1'
	if (!$system->getUseflag('tickets'))
	{
		echo "Switching 'tickets' to 'Off'\t\t";
		$system->confReplace("'ticket', 'enabled', '0'", "'ticket', 'enabled', '1'", $sqltmp);
		echo "[OK]\n";
	}

	// default value is mailquota='0'
	if ($system->getUseflag('mailquota'))
	{
		echo "Switching 'mailquota' to 'On'\t\t";
		$system->confReplace("'mail_quota_enabled', '1'", "'mail_quota_enabled', '0'", $sqltmp);
		echo "[OK]\n";
	}

	// default value is autoresponder='0'
	if ($system->getUseflag('autoresponder'))
	{
		echo "Switching 'autoresponder' to 'On'\t\t";
		$system->confReplace("'autoresponder_active', '1'", "'autoresponder_active', '0'", $sqltmp);
		echo "[OK]\n";
	}

	// default value is dkim_enabled='0'
	if ($system->getUseflag('domainkey') && $system->getUseflag('bind'))
	{
		echo "Switching 'domainkey' to 'On'\t\t";
		$system->confReplace("'use_dkim', '1'", "'use_dkim', '0'", $sqltmp);
		echo "[OK]\n";

		if($os == OS_GENTOO)
		{
			echo "Setting dkim-path to gentoo value\t\t";
			$system->confReplace("'dkim_prefix', '/etc/mail/dkim-filter/'", "'dkim_prefix', '/etc/postfix/dkim/'", $sqltmp);
			echo "[OK]\n";
		}	
	}

	// default value is aps_enabled='0'
	if ($system->getUseflag('aps'))
	{
		echo "Switching 'APS' to 'On'\t\t";
		$system->confReplace("'aps_active', '1'", "'aps_active', '0'", $sqltmp);
		echo "[OK]\n";
		// if aps is used we enable required features in the php-cli php.ini
		$system->ewarn(array(
				"Please run the following command in your shell to change the php-cli php.ini file for APS",
				"* sed -ie \"s|allow_url_fopen = Off|allow_url_fopen = On|g\" -i \"/etc/php/cli-php5/php.ini\"")
				);
	}

	// default value is ssl_enabled='0'
	if ($system->getUseflag('ssl'))
	{
		echo "Switching 'SSL' to 'On'\t\t";
		$system->confReplace("'use_ssl', '1'", "'use_ssl', '0'", $sqltmp);
		echo "[OK]\n";
	}

	// we need to check if this is going to be an update or a fresh install!
	if (file_exists($basedir . "lib/userdata.inc.php"))
	{
		$system->ewarn(array(
				"Froxlor is already installed on this system!",
				"Do you want to perform an update?",
				"CAUTION: You should use the EXACT same use-flags as before!!!",
				"",
				"Run update [y/N]: ")
				);
		$doupdate = $system->getYesNo(I_NO);

		if($doupdate == I_NO)
			die("\nUser abort...\n");
	}

	if(!isset($doupdate))
	{
		/* ask for general information like the ebuild does */
		$sql = array('user' => null, 
			'password' => null, 
			'db' => null, 
			'host' => null, 
			'root_user' => 'root', 
			'root_password' => null
		);

		$sys = array('hostname' => null,
			'ipaddress' => null,
			'mysqlaccess_hosts' => 'localhost',
			'nameservers' => '',
			'admin' => 'admin',
			'admin_password' => null
		);

		$system->ewarn(array("Enter the domain under wich Froxlor shall be reached, this normally",
			"is the FQDN (Fully Qualified Domain Name) of your system.",
			"If you don't know the FQDN of your system, execute 'hostname -f'.",
			"This installscript will try to guess your FQDN automatically if",
			"you leave this field blank, setting it to the output of 'hostname -f'.")
		);

		$host = array();
		exec('hostname -f', $host);
		echo "Enter your system's hostname [".$host[0]."]: ";
		$sys['hostname'] = $system->getString($host[0]);

		$system->ewarn(array("Enter the IP address of your system, under wich all",
			"websites shall then be reached. This must be the same",
			"IP address the domain you inserted above points to.",
			"You *must* set this to your correct IP address.")
		);

		$ip = array();
		exec('ifconfig  | grep \'inet addr:\'| grep -v \'127.0.0.1\' | cut -d: -f2 | awk \'{ print $1}\'', $ip);
		echo "Enter your system's ip-address [".$ip[0]."]: ";
		$sys['ipaddress'] = $system->getString($ip[0]);

		$system->ewarn(array("Enter the IP address of the MySQL server, if the MySQL",
			"server is on the same machine, enter 'localhost' or",
			"simply leave the field blank.")
		);

		echo "Enter mysql-host address [localhost]: ";
		$sql['host'] = $system->getString('localhost');
		$sql['host'] = strtolower($sql['host']);

		if($sql['host'] != 'localhost') 
			$sys['mysqlaccess_hosts'] .= ','. $sql['host'];

		$system->ewarn(array("Enter the username of the MySQL root user.",
			"The default is 'root'.")
		);

		echo "MySQL root user [root]: ";
		$sql['root_user'] = $system->getString('root');

		while(true)
		{
			echo "Enter the password of the MySQL root user: ";
			$mrootpwd_a = $system->getString();
	
			echo "Enter the password of the MySQL root user again: ";
			$mrootpwd_b = $system->getString();

			if($mrootpwd_a == $mrootpwd_b) {
				$sql['root_password'] = $mrootpwd_a;
				break;
			} else {
				echo "Passwords do not match, please enter again\n";
			}
		}

		$system->ewarn(array("Enter the name of the database you want to",
			"use for Froxlor. The default is 'froxlor'.",
			"CAUTION: any database with that name will",
			"be dropped!")
		);

		echo "MySQL database name [froxlor]: ";
		$sql['db'] = $system->getString('froxlor');

		$system->ewarn(array("Enter the username of the unprivileged",
			"MySQL user you want Froxlor to use.",
			"The default is 'froxlor'.",
			"CAUTION: any user with that name will",
			"be deleted!")
		);

		echo "MySQL unprivileged user [froxlor]: ";
		$sql['user'] = $system->getString('froxlor');

		while(true)
		{
			echo "Enter the password of the MySQL unprivileged user: ";
			$musrpwd_a = $system->getString();
	
			echo "Enter the password of the MySQL unprivileged user again: ";
			$musrpwd_b = $system->getString();

			if($musrpwd_a == $musrpwd_b) {
				$sql['password'] = $musrpwd_a;
				break;
			} else {
				echo "Passwords do not match, please enter again\n";
			}
		}

		$system->ewarn(array("Enter the username of the admin user you",
			"want in your Froxlor panel.",
			"Default is 'admin'.")
		);

		echo "Froxlor admin user [admin]: ";
		$sys['admin'] = $system->getString('admin');

		while(true)
		{
			echo "Enter the password of the Froxlor admin user: ";
			$madmpwd_a = $system->getString();
	
			echo "Enter the password of the Froxlor admin user again: ";
			$madmpwd_b = $system->getString();

			if($madmpwd_a == $madmpwd_b) {
				$sys['admin_password'] = $madmpwd_a;
				break;
			} else {
				echo "Passwords do not match, please enter again\n";
			}
		}

		if($os == OS_GENTOO) {
			echo "Adding MySQL server to 'default' runlevel ...\n";
			exec("rc-update add mysql default");
		}
		echo "(Re)Starting MySQL server ...\n";
		exec("/etc/init.d/mysql restart");

		echo "\nPreparing SQL database files ...\t\t";
		$system->confReplace($sys['hostname'], "SERVERNAME", $sqltmp);
		$system->confReplace($sys['ipaddress'], "SERVERIP", $sqltmp);
		$system->confReplace("'mysql_access_host', '".$sys['mysqlaccess_hosts']."'", "'mysql_access_host', 'localhost'", $sqltmp);
		echo "[OK]\n";

		echo "Preparing creation of database ...\t\t";
		$sqltmpdb = "/tmp/createdb.sql";
		exec("touch " . $sqltmpdb);
		exec("echo \"DROP DATABASE IF EXISTS MYSQL_DATABASE_NAME;
CREATE DATABASE MYSQL_DATABASE_NAME;
GRANT ALL PRIVILEGES ON MYSQL_DATABASE_NAME.* TO MYSQL_UNPRIV_USER@MYSQL_ACCESS_HOST IDENTIFIED BY 'password';
SET PASSWORD FOR MYSQL_UNPRIV_USER@MYSQL_ACCESS_HOST = PASSWORD('MYSQL_UNPRIV_PASSWORD');
FLUSH PRIVILEGES;\" > " . $sqltmpdb);
		$system->confReplace($sql['host'], "MYSQL_ACCESS_HOST", $sqltmpdb);
		$system->confReplace($sql['user'], "MYSQL_UNPRIV_USER", $sqltmpdb);
		$system->confReplace($sql['password'], "MYSQL_UNPRIV_PASSWORD", $sqltmpdb);
		$system->confReplace($sql['db'], "MYSQL_DATABASE_NAME", $sqltmpdb);
		echo "[OK]\n";

		echo "Creating Froxlor database ...\t\t";
		exec("mysql -u ".$sql['root_user']." -p".$sql['root_password']." < " . $sqltmpdb);
		echo "[OK]\n";

		echo "Installing SQL database files ...\t\t";
		exec("mysql -u ".$sql['root_user']." -p".$sql['root_password']." ".$sql['db']." < " . $sqltmp);
		echo "[OK]\n";

		echo "Preparing creation of ip/port entry ...\t\t";
		$sqltmpiap = "/tmp/ipandport.sql";
		exec("touch " . $sqltmpiap);
		exec("echo \"INSERT INTO \`panel_ipsandports\` (\`ip\`, \`port\`, \`namevirtualhost_statement\`) VALUES ('".$sys['ipadress']."', '80', '1');\" > " . $sqltmpiap);
		echo "[OK]\n";

		echo "Installing ip and port entry ...\t\t";
		exec("mysql -u ".$sql['root_user']." -p".$sql['root_password']." ".$sql['db']." < " . $sqltmpiap);
		echo "[OK]\n";

		echo "Adding Froxlor admin-user...\t\t";
		// @TODO check if everything is present
		$sqltmpadm = "/tmp/admin.sql";
		exec("touch " . $sqltmpadm);
		exec("echo \"INSERT INTO \`panel_admins\` SET
        \`loginname\` = '".$sys['admin']."',
        \`password\` = MD5('".$sys['admin_password']."'),
        \`name\` = 'Siteadmin',
        \`email\` = 'admin@".$sys['hostname']."',
        \`customers\` = -1,
        \`customers_used\` = 0,
        \`customers_see_all\` = 1,
        \`caneditphpsettings\` = 1,
        \`domains\` = -1,
        \`domains_used\` = 0,
        \`domains_see_all\` = 1,
        \`change_serversettings\` = 1,
        \`edit_billingdata\` = 1,
        \`diskspace\` = -1024,
        \`diskspace_used\` = 0,
        \`mysqls\` = -1,
        \`mysqls_used\` = 0,
        \`emails\` = -1,
        \`emails_used\` = 0,
        \`email_accounts\` = -1,
        \`email_accounts_used\` = 0,
        \`email_forwarders\` = -1,
        \`email_forwarders_used\` = 0,
        \`email_quota\` = -1,
        \`email_quota_used\` = 0,
        \`ftps\` = -1,
        \`ftps_used\` = 0,
        \`tickets\` = -1,
        \`tickets_used\` = 0,
        \`subdomains\` = -1,
        \`subdomains_used\` = 0,
        \`traffic\` = -1048576,
        \`traffic_used\` = 0,
        \`deactivated\` = 0,
        \`aps_packages\` = -1;\" > " . $sqltmpadm);
		exec("mysql -u ".$sql['root_user']." -p".$sql['root_password']." ".$sql['db']." < " . $sqltmpadm);
		echo "[OK]\n";

	/*
		echo "Deleting SQL database files ...\t\t";
		exec("rm -f " . $sqltmp);
		exec("rm -f " . $sqltmpdb);
		exec("rm -f " . $sqltmpiap);
		exec("rm -f " . $sqltmpadm);
		echo "[OK]\n";
	*/

		echo "Installing Froxlor data file ...\t\t";
		exec("rm -rf " . $basedir . "/lib/userdata.inc.php");
		exec("touch " . $basedir . "/lib/userdata.inc.php");
		exec("chmod 0440 " . $basedir . "/lib/userdata.inc.php");
		exec("echo \"<?php
//automatically generated userdata.inc.php for Froxlor
\$sql['host']='".$sql['host']."';
\$sql['user']='".$sql['user']."';
\$sql['password']='".$sql['password']."';
\$sql['db']='".$sql['db']."';
\$sql_root[0]['caption']='Default';
\$sql_root[0]['host']='".$sql['host']."';
\$sql_root[0]['user']='".$sql['root_user']."';
\$sql_root[0]['password']='".$sql['root_password']."';
?>\" > ".$basedir."/lib/userdata.inc.php");
		echo "[OK]\n";

		if($system->getUseflag('ssl'))
		{
			$system->ewarn(array("Creating needed SSL certificates ...",
				"Please enter the correct input when it's requested.",
				"",
				"ATTENTION: when you're requested to enter a",
				"'Common Name' enter ".$sys['hostname'])
			);
			echo "...we'll do that later...promise!\n";
		}

		/* Fix the permissions for the Froxlor files */
		echo "Fixing permission of Froxlor files\t\t";
		exec("chown -R froxlor:".$httpd." " . $basedir);
		exec("find " . $basedir . " -type d -exec chmod 0755 {} \;");
		exec("find " . $basedir . " -type f -exec chmod 0444 {} \;");
		if($system->getUseflag('fcgid')
			|| $system->getUseflag('fpm')
		) {
			exec("chown -R froxlor:froxlor " . $basedir);
			exec("chmod 0750 " . $basedir);
		}
		else
		{
			exec("chown -R froxlor:".$httpd." " . $basedir . "{temp,packages}");
		}
		exec("chmod 0775 " . $basedir . "{temp,packages}");
		echo "[OK]\n";

		$bind_config = '/etc/bind/';

	} else {
		/**
		 *  +++++++++++++++++++++++++++++++++++++++++++++++++++
		 *  +++++++               UPDATE                +++++++
		 *  +++++++++++++++++++++++++++++++++++++++++++++++++++
		 */

		/* let's get our data somewhere else :P */
		include_once($basedir.'/lib/userdata.inc.php');

		/* @TODO read some settings from database */
		/*
		$sys['hostname']
		$sys['ipaddress']
		$sys['nameservers']
		$docroot['mail']
		$users['vmail']
		$system->setUseflag('ssl', false)
		$docroot['tmp']
		$bind_config
		*/
	}

	$replace_arr = Array(
		'<SQL_UNPRIVILEGED_USER>' => $sql['user'],
		'<SQL_UNPRIVILEGED_PASSWORD>' => $sql['password'],
		'<SQL_DB>' => $sql['db'],
		'<SQL_HOST>' => $sql['host'],
		'<SERVERNAME>' => $sys['hostname'],
		'<SERVERIP>' => $sys['ipaddress'],
		'<NAMESERVERS>' => $sys['nameservers'],
		'<VIRTUAL_MAILBOX_BASE>' => $docroot['mail'],
		'<VIRTUAL_UID_MAPS>' => $users['vmail'],
		'<VIRTUAL_GID_MAPS>' => $users['vmail'],
		'<SSLPROTOCOLS>' => ($system->getUseflag('ssl')) ? 'imaps pop3s' : '',
		'<CUSTOMER_TMP>' => ($docroot['tmp'] != '') ? $docroot['tmp'] : '/tmp/',
		'<BASE_PATH>' => $basedir,
		'<BIND_CONFIG_PATH>' => $bind_config
	);

	/* Services: configure */
	if(isset($doupdate) && $doupdate == I_YES)
	{
		$system->ewarn(array("WARNING: You are going to reconfigure your services!",
				"",
				"Reconfiguration may crash your current setup if you changed",
				"anything in the configurations manually!")
			);
		echo "Are you sure you want to proceed? [y/N]: ";
		$proceed = $system->getYesNo(I_NO);
		if($proceed == I_NO) {
			die("\nUser abort...\n");
		}
	}

	/* configure webserver */
	if($system->getUseflag('lighttpd'))
	{
		echo "Configuring Lighttpd ...\n";
		$system->doconf($basedir, $os, 'lighttpd', '/etc/lighttpd/lighttpd.conf', 'etc_lighttpd.conf', $replace_arr);
		if($os == OS_GENTOO) {
			exec("touch /etc/lighttpd/froxlor-vhosts.conf");
		}
	elseif($system->getUseflag('nginx')) 
	{
		echo "Configuring Nginx ...\n";
		$system->doconf($basedir, $os, 'nginx', '/etc/nginx/nginx.conf', 'etc_nginx_nginx.conf', $replace_arr);
		$system->doconf($basedir, $os, 'nginx', '/etc/nginx/fastcgi.conf', 'etc_nginx_fastcgi.conf', $replace_arr);
		$system->doconf($basedir, $os, 'nginx', '/etc/init.d/php-fcgi', 'etc_init.d_php-fcgi', $replace_arr);
	}
	} else {
		/* apache doesn't have any...cronjob does the job for us */
	}

	/* configure NSS-MySQL */
	echo "Configuring NSS-MySQL ...\n";
	$system->doconf($froxlordir, $os, 'libnss', '/etc/nss-mysql.conf', 'etc_nss-mysql.conf', $replace_arr);
	$system->doconf($froxlordir, $os, 'libnss', '/etc/nss-mysql-root.conf', 'etc_nss-mysql-root.conf', $replace_arr);
	$system->doconf($froxlordir, $os, 'libnss', '/etc/nsswitch.conf', 'etc_nsswitch.conf', $replace_arr);

	if($system->getUseflag('pureftpd'))
	{
		
	} else {
		/* configure ProFTPd */
		echo "Configuring ProFTPd ...\n";
		$system->doconf($froxlordir, $os, 'proftpd', '/etc/proftpd/proftpd.conf', 'etc_proftpd_proftpd.conf', $replace_arr);
		if($os != OS_GENTOO)
			$system->doconf($froxlordir, $os, 'proftpd', '/etc/proftdp/modules.conf', 'etc_proftpd_modules.conf', $replace_arr);
	
		if($system->getUseflag('ssl'))
		{
			$system->confReplace("<IfModule mod_tls.c>", "#<IfModule mod_tls.c>", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSEngine", "#TLSEngine", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSLog", "#TLSLog", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSProtocol", "#TLSProtocol", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSTimeoutHandshake", "#TLSTimeoutHandshake", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSOptions", "#TLSOptions", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSRSACertificateFile", "#TLSRSACertificateFile", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSRSACertificateKeyFile", "#TLSRSACertificateKeyFile", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSVerifyClient", "#TLSVerifyClient", "/etc/proftpd/proftpd.conf");
			$system->confReplace("TLSRequired", "#TLSRequired", "/etc/proftpd/proftpd.conf");
			$system->confReplace("</IfModule>", "#</IfModule>", "/etc/proftpd/proftpd.conf");
		}
	}

	/* configure froxlor-cronjob */
	echo "Configuring Froxlor-cronjob ...\n";
	$system->doconf($basedir, $os, 'cron', '/etc/cron.d/froxlor', 'etc_cron.d_froxlor', $replace_arr);

	/* configureing courier */
	if(!$system->getUseflag('dovecot'))
	{
		echo "Configuring Courier-IMAP ...\n";
		if(($os >= OS_DEBIANSARGE && $os <= OS_DEBIANLENNY) || $os == OS_UBUNTU)
		{
			$system->doconf($basedir, $os, 'courier', '/etc/courier/authdaemonrc', 'etc_courier_authdaemonrc', $replace_arr);
			$system->doconf($basedir, $os, 'courier', '/etc/courier/authmysqlrc', 'etc_courier_authmysqlrc', $replace_arr);
		}
		elseif($os == OS_SUSE)
		{
			$system->doconf($basedir, $os, 'courier', '/etc/authlib/authdaemonrc', 'etc_authlib_authdaemonrc', $replace_arr);
			$system->doconf($basedir, $os, 'courier', '/etc/authlib/authmysqlrc', 'etc_authlib_authmysqlrc', $replace_arr);
		}
		elseif($os == OS_GENTOO)
		{
			$system->doconf($basedir, $os, 'courier', '/etc/courier/authlib/authdaemonrc', 'etc_courier_authlib_authdaemonrc', $replace_arr);
			$system->doconf($basedir, $os, 'courier', '/etc/courier/authlib/authmysqlrc', 'etc_courier_authlib_authmysqlrc', $replace_arr);
			$system->doconf($basedir, $os, 'courier', '/etc/courier-imap/imapd', 'etc_courier-imap_imapd', $replace_arr);
			$system->doconf($basedir, $os, 'courier', '/etc/courier-imap/pop3d', 'etc_courier-imap_pop3d', $replace_arr);
			if($system->getUseflag('ssl')) 
			{
				$system->doconf($basedir, $os, 'courier', '/etc/courier-imap/imapd-ssl', 'etc_courier-imap_imapd-ssl', $replace_arr);
				$system->doconf($basedir, $os, 'courier', '/etc/courier-imap/pop3d-ssl', 'etc_courier-imap_pop3d-ssl', $replace_arr);
			}
		}
	} else {
		echo "Configuring Dovecot-IMAP ...\n";
		if($os != OS_SUSE)
		{
			$system->doconf($basedir, $os, 'dovecot', '/etc/dovecot/dovecot.conf', 'etc_dovecot_dovecot.conf', $replace_arr);
			$system->confReplace("root@".$sys['hostname'], "<postmaster-address>", "/etc/dovecot/dovecot.conf");
			$system->doconf($basedir, $os, 'dovecot', '/etc/dovecot/dovecot-sql.conf', 'etc_dovecot_dovecot-sql.conf', $replace_arr);
			if($system->getUseflag('ssl'))
			{
				$system->confReplace("ssl_cert_file", "#ssl_cert_file", "/etc/dovecot/dovecot.conf");
				$system->confReplace("ssl_key_file", "#ssl_key_file", "/etc/dovecot/dovecot.conf");
			}
		} else {
			$system->ewarn("Sorry, no dovecot for SuSE yet...");
		}
	}

	echo "Configuring Postfix ...\n";
	$system->doconf($basedir, $os, 'postfix', '/etc/postfix/main.cf', 'etc_postfix_main.cf', $replace_arr);
	if($system->getUseflag('dovecot'))
	{
		if($os != OS_SUSE)
		{
			$tpl = $system->getConfPath($basedir, $os, 'postfix', 'etc_postfix_master.cf');
			exec("cat " . $tpl . " >> /etc/postfix/master.cf");
		}

		$system->confReplace("mailbox_command = /usr/libexec/dovecot/deliver", "#mailbox_command = /usr/libexec/dovecot/deliver", "/etc/postfix/main.cf");
		$system->confReplace("smtpd_sasl_type = dovecot", "#smtpd_sasl_type = dovecot", "/etc/postfix/main.cf");
		$system->confReplace("smtpd_sasl_path = private/auth", "#smtpd_sasl_path = private/auth", "/etc/postfix/main.cf");
		$system->confReplace("virtual_transport = dovecot", "#virtual_transport = dovecot", "/etc/postfix/main.cf");
		$system->confReplace("dovecot_destination_recipient_limit = 1", "#dovecot_destination_recipient_limit = 1", "/etc/postfix/main.cf");
	}
	$system->doconf($basedir, $os, 'postfix', '/etc/postfix/mysql-virtual_alias_maps.cf', 'etc_postfix_mysql-virtual_alias_maps.cf', $replace_arr);
	$system->doconf($basedir, $os, 'postfix', '/etc/postfix/mysql-virtual_mailbox_domains.cf', 'etc_postfix_mysql-virtual_mailbox_domains.cf', $replace_arr);
	$system->doconf($basedir, $os, 'postfix', '/etc/postfix/mysql-virtual_mailbox_maps.cf', 'etc_postfix_mysql-virtual_mailbox_maps.cf', $replace_arr);
	if(($os >= OS_DEBIANSARGE && $os <= OS_DEBIANLENNY) || $os == OS_UBUNTU)
	{
		$system->doconf($basedir, $os, 'postfix', '/etc/postfix/sasl/smtpd.conf', 'etc_postfix_sasl_smtpd.conf', $replace_arr);
	}
	elseif($os == OS_SUSE)
	{
		$system->doconf($basedir, $os, 'postfix', '/usr/lib/sasl2/smtpd.conf', 'usr_lib_sasl2_smtpd.conf', $replace_arr);
	}
	elseif($os == OS_GENTOO)
	{
		$system->doconf($basedir, $os, 'postfix', '/etc/sasl2/smtpd.conf', 'etc_sasl2_smtpd.conf', $replace_arr);

		if($system->getUseflag('mailquota'))
		{
			$system->doconf($basedir, $os, 'postfix', '/etc/postfix/mysql-virtual_mailbox_limit_maps.cf', 'mysql-virtual_mailbox_limit_maps.cf', $replace_arr);

			$system->confReplace("virtual_transport = virtual", "#virtual_transport = virtual", "/etc/postfix/main.cf");
			$system->confReplace("virtual_create_maildirsize", "#virtual_create_maildirsize", "/etc/postfix/main.cf");
			$system->confReplace("virtual_mailbox_extended", "#virtual_mailbox_extended", "/etc/postfix/main.cf");
			$system->confReplace("virtual_mailbox_limit_inbox", "#virtual_mailbox_limit_inbox", "/etc/postfix/main.cf");
			$system->confReplace("virtual_mailbox_limit_maps", "#virtual_mailbox_limit_maps", "/etc/postfix/main.cf");
			$system->confReplace("virtual_maildir_limit_message", "#virtual_maildir_limit_message", "/etc/postfix/main.cf");
			$system->confReplace("virtual_overquota_bounce", "#virtual_overquota_bounce", "/etc/postfix/main.cf");
		}
	}

	if($system->getUseflag('domainkey') && $system->getUseflag('bind'))
	{
		exec("echo \"smtpd_milters = inet:localhost:8891
milter_macro_daemon_name = SIGNING
milter_default_action = accept}\" >> /etc/postfix/main.cf");
	}

	/* restart services */

	/* finish up */
}
else
{
	echo "kthxbye!\n\n";
}
