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
 * @version    $Id$
 */

/*
 * This script creates the php.ini's used by mod_suPHP+php-cgi
 */

if(@php_sapi_name() != 'cli'
&& @php_sapi_name() != 'cgi'
&& @php_sapi_name() != 'cgi-fcgi')
{
	die('This script only works in the shell.');
}

class nginx_phpfpm extends nginx
{
	private $php_configs_cache = array();
	private $admin_cache = array();

	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			$php_options_text = $this->_createFpmPart($domain);
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}

	private function getPhpConfig($php_config_id)
	{
		$php_config_id = intval($php_config_id);

		// If domain has no config, we will use the default one.

		if($php_config_id == 0)
		{
			$php_config_id = 1;
		}

		if(!isset($this->php_configs_cache[$php_config_id]))
		{
			$this->php_configs_cache[$php_config_id] = $this->getDB()->query_first("SELECT * FROM `" . TABLE_PANEL_PHPCONFIGS . "` WHERE `id` = " . (int)$php_config_id);
		}

		return $this->php_configs_cache[$php_config_id];
	}

	private function getAdminData($adminid)
	{
		$adminid = intval($adminid);

		if(!isset($this->admin_cache[$adminid]))
		{
			$this->admin_cache[$adminid] = $this->getDB()->query_first("SELECT `email`, `loginname` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid` = " . (int)$adminid);
		}

		return $this->admin_cache[$adminid];
	}

	private function _createFpmPart($domain)
	{
		$php_options_text = '';

		if(!is_dir('/var/run/nginx/')) {
			safe_exec('mkdir -p /var/run/nginx/');
			safe_exec('chown -R '.$this->settings['system']['httpuser'].':'.$this->settings['system']['httpgroup'].' /var/run/nginx/');
		}
		$socket = makeCorrectFile('/var/run/nginx/'.$domain['loginname'].'-'.$domain['domain'].'-php-fpm.socket');
		$tmpfile = makeCorrectFile($this->settings['phpfpm']['configdir'].'/'.$domain['domain'].'.conf');
		
		$fh = @fopen($tmpfile, 'w');
		if($fh)
		{
			$fpm_pm = $this->settings['phpfpm']['pm'];
			$fpm_children = (int)$this->settings['phpfpm']['max_children'];
			$fpm_start_servers = (int)$this->settings['phpfpm']['start_servers'];
			$fpm_min_spare_servers = (int)$this->settings['phpfpm']['min_spare_servers'];
			$fpm_max_spare_servers = (int)$this->settings['phpfpm']['max_spare_servers'];
			$fpm_requests = (int)$this->settings['phpfpm']['max_requests'];

			if($fpm_children == 0) {
				$fpm_children = 1;
			}

			$tmpdir = makeCorrectDir($this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/');
			//$slowlog = makeCorrectFile($this->settings['system']['logfiles_directory'] . $domain['loginname'] . '/php-fpm_slow.log');

			$fpm_config = ';PHP-FPM configuration for "'.$domain['domain'].'" created on ' . date("Y.m.d H:i:s") . "\n\n";
			$fpm_config.= '['.$domain['domain'].']'."\n";
			$fpm_config.= 'listen = '.$socket."\n";
			$fpm_config.= 'listen.owner = '.$domain['loginname']."\n";
			$fpm_config.= 'listen.group = '.$domain['loginname']."\n";
			$fpm_config.= 'listen.mode = 0666'."\n\n";

			$fpm_config.= 'user = '.$domain['loginname']."\n";
			$fpm_config.= 'group = '.$domain['loginname']."\n\n";

			$fpm_config.= 'pm = '.$fpm_pm."\n";
			$fpm_config.= 'pm.max_children = '.$fpm_children."\n";
			if($fpm_pm == 'dynamic') {
				$fpm_config.= 'pm.start_servers = '.$fpm_start_servers."\n";
				$fpm_config.= 'pm.min_spare_servers = '.$fpm_min_spare_servers."\n";
				$fpm_config.= 'pm.max_spare_servers = '.$fpm_max_spare_servers."\n";
			}
			$fpm_config.= 'pm.max_requests = '.$fpm_requests."\n\n";

			$fpm_config.= ';chroot = '.makeCorrectDir($domain['documentroot'])."\n\n";

			$fpm_config.= 'env[TMP] = '.$tmpdir."\n";
			$fpm_config.= 'env[TMPDIR] = '.$tmpdir."\n";
			$fpm_config.= 'env[TEMP] = '.$tmpdir."\n\n";

			$fpm_config.= 'php_admin_value[sendmail_path] = /usr/sbin/sendmail -t -i -f '.$domain['email']."\n\n";
			$fpm_config.= 'php_admin_value[open_basedir] = ' . $this->settings['system']['documentroot_prefix'] . $domain['loginname'] . '/:' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/:' . $this->settings['phpfpm']['peardir'] . "\n";
			$fpm_config.= 'php_admin_value[session.save_path] = ' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/' . "\n";
			$fpm_config.= 'php_admin_value[upload_tmp_dir] = ' . $this->settings['phpfpm']['tmpdir'] . '/' . $domain['loginname'] . '/' . "\n\n";
			
			fwrite($fh, $fpm_config, strlen($fpm_config));
			fclose($fh);

			$php_options_text = "\t".'location ~ \.php$ {'."\n";
			$php_options_text.= "\t\t".'fastcgi_index index.php;'."\n";
			$php_options_text.= "\t\t".'include /etc/nginx/fastcgi_params;'."\n";
			$php_options_text.= "\t\t".'fastcgi_param SCRIPT_FILENAME '.makeCorrectDir($domain['documentroot']).'$fastcgi_script_name;'."\n";
			$php_options_text.= "\t\t".'fastcgi_pass unix:' . $socket . ';' . "\n";
			$php_options_text.= "\t".'}'."\n";

		}
		else
		{
			$php_options_text = '   # could not create php-fpm configuration for '.$domain['domain']. "\n";
		}
		return $php_options_text;
	}
}
