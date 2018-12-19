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

class nginx_phpfpm extends nginx
{
	protected function composePhpOptions($domain, $ssl_vhost = false) {
		$php_options_text = '';

		if ($domain['phpenabled_customer'] == 1 && $domain['phpenabled_vhost'] == '1') {
			$php = new phpinterface($domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);
			
			$php_options_text = "\t" . 'location ~ ^(.+?\.php)(/.*)?$ {' . "\n";
			$php_options_text .= "\t\t" . 'try_files ' . $domain['nonexistinguri'] . ' @php;' . "\n";
			$php_options_text .= "\t" . '}' . "\n\n";

			$php_options_text .= "\t" . 'location @php {' . "\n";
			$php_options_text .= "\t\t" . 'try_files $1 = 404;' . "\n\n";
			$php_options_text .= "\t\t" . 'include ' . Settings::Get('nginx.fastcgiparams') . ";\n";
			$php_options_text .= "\t\t" . 'fastcgi_split_path_info ^(.+\.php)(/.+)\$;' . "\n";
			$php_options_text .= "\t\t" . 'fastcgi_param SCRIPT_FILENAME $document_root$1;' . "\n";
			$php_options_text .= "\t\t" . 'fastcgi_param PATH_INFO $2;' . "\n";
			if ($domain['ssl'] == '1' && $ssl_vhost) {
				$php_options_text .= "\t\t" . 'fastcgi_param HTTPS on;' . "\n";
			}
			$php_options_text .= "\t\t" . 'fastcgi_pass unix:' . $php->getInterface()->getSocketFile() . ";\n";
			$php_options_text .= "\t\t" . 'fastcgi_index index.php;' . "\n";
			$php_options_text .= "\t}\n\n";
			
			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);

			// create php.ini (fpm does nothing here, as it
			// defines ini-settings in its pool config)
			$php->getInterface()->createIniFile($phpconfig);
		}
		else {
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}
	

	public function createOwnVhostStarter() {
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
