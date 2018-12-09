<?php if (!defined('MASTER_CRONJOB')) die('You cannot access this file directly!');

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

class lighttpd_fcgid extends lighttpd
{
	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1')
		{
			$php = new phpinterface($domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);

			// vhost data for php-fpm
			if((int)Settings::Get('phpfpm.enabled') == 1)
			{
				$php_options_text = '  fastcgi.server = ( '."\n";
				$php_options_text.=	"\t".'".php" => ('."\n";
				$php_options_text.=	"\t\t".'"localhost" => ('."\n";
				$php_options_text.=	"\t\t".'"socket" => "'.$php->getInterface()->getSocketFile().'",'."\n";
				$php_options_text.=	"\t\t".'"check-local" => "enable",'."\n";
				$php_options_text.=	"\t\t".'"disable-time" => 1'."\n";
				$php_options_text.=	"\t".')'."\n";
				$php_options_text.=	"\t".')'."\n";
				$php_options_text.=	'  )'."\n";				
			}
			// vhost data for fcgid
			elseif((int)Settings::Get('system.mod_fcgid') == 1)
			{
				$php_options_text = '  fastcgi.server = ( '."\n";
				$file_extensions = explode(' ', $phpconfig['file_extensions']);
				foreach($file_extensions as $f_extension)
				{
					$php_options_text.=	"\t".'".'.$f_extension.'" => ('."\n";
					$php_options_text.=	"\t\t".'"localhost" => ('."\n";
					$php_options_text.=	"\t\t".'"socket" => "/var/run/lighttpd/'.$domain['loginname'].'-'.$domain['domain'].'-php.socket",'."\n";
					$php_options_text.=	"\t\t".'"bin-path" => "'.$phpconfig['binary'].' -c '.$php->getInterface()->getIniFile().'",'."\n";
					$php_options_text.=	"\t\t".'"bin-environment" => ('."\n";
					if((int)$domain['mod_fcgid_starter'] != - 1)
					{
						$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)$domain['mod_fcgid_starter'] . '",'."\n";
					}
					else
					{
						if((int)$phpconfig['mod_fcgid_starter'] != - 1)
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)$phpconfig['mod_fcgid_starter'] . '",'."\n";
						}
						else
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_CHILDREN" => "' . (int)Settings::Get('system.mod_fcgid_starter') . '",'."\n";
						}
					}
	
					if((int)$domain['mod_fcgid_maxrequests'] != - 1)
					{
						$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)$domain['mod_fcgid_maxrequests'] . '"'."\n";
					}
					else
					{
						if((int)$phpconfig['mod_fcgid_maxrequests'] != - 1)
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)$phpconfig['mod_fcgid_maxrequests'] . '"'."\n";
						}
						else
						{
							$php_options_text.=	"\t\t\t".'"PHP_FCGI_MAX_REQUESTS" => "' . (int)Settings::Get('system.mod_fcgid_maxrequests') . '"'."\n";
						}
					}
	
					$php_options_text.=	"\t\t".')'."\n";
					$php_options_text.=	"\t".')'."\n";
					$php_options_text.=	"\t".')'."\n";
	
				} // foreach extension
				$php_options_text.=	'  )'."\n";
			}

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);
			
			// create php.ini (fpm does nothing here, as it
			// defines ini-settings in its pool config)
			$php->getInterface()->createIniFile($phpconfig);
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}

	public function createOwnVhostStarter()
	{
		if (Settings::Get('phpfpm.enabled') == '1'
			&& Settings::Get('phpfpm.enabled_ownvhost') == '1'
		) {
			$mypath = makeCorrectDir(dirname(dirname(dirname(__FILE__)))); // /var/www/froxlor, needed for chown

			$user = Settings::Get('phpfpm.vhost_httpuser');
			$group = Settings::Get('phpfpm.vhost_httpgroup');	

			// get fpm config
			$fpm_sel_stmt = Database::prepare("
				SELECT f.id FROM `" . TABLE_PANEL_FPMDAEMONS . "` f
				LEFT JOIN `" . TABLE_PANEL_PHPCONFIGS . "` p ON p.fpmsettingid = f.id
				WHERE p.id = :phpconfigid
			");
			$fpm_config = Database::pexecute_first($fpm_sel_stmt, array(
				'phpconfigid' => Settings::Get('phpfpm.vhost_defaultini')
			));

			$domain = array(
				'id' => 'none',
				'domain' => Settings::Get('system.hostname'),
				'adminid' => 1, /* first admin-user (superadmin) */
				'mod_fcgid_starter' => -1,
				'mod_fcgid_maxrequests' => -1,
				'guid' => $user,
				'openbasedir' => 0,
				'email' => Settings::Get('panel.adminmail'),
				'loginname' => 'froxlor.panel',
				'documentroot' => $mypath,
				'customerroot' => $mypath,
				'fpm_config_id' => isset($fpm_config['id']) ? $fpm_config['id'] : 1
			);

			// all the files and folders have to belong to the local user
			// now because we also use fcgid for our own vhost
			safe_exec('chown -R ' . $user . ':' . $group . ' ' . escapeshellarg($mypath));
						
			// get php.ini for our own vhost
			$php = new phpinterface($domain);

			// get php-config
			if (Settings::Get('phpfpm.enabled') == '1') {
				// fpm
				$phpconfig = $php->getPhpConfig(Settings::Get('phpfpm.vhost_defaultini'));
			} else {
				// fcgid
				$phpconfig = $php->getPhpConfig(Settings::Get('system.mod_fcgid_defaultini_ownvhost'));
			}

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);
			
			// create php.ini (fpm does nothing here, as it
			// defines ini-settings in its pool config)
			$php->getInterface()->createIniFile($phpconfig);
		}
	}
}
