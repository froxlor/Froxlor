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
	protected function composePhpOptions($domain)
	{
		$php_options_text = '';

		if($domain['phpenabled'] == '1')
		{
			$php = new phpinterface($this->getDB(), $this->settings, $domain);
			$phpconfig = $php->getPhpConfig((int)$domain['phpsettingid']);
			
			$php_options_text = "\t".'location ~ \.php$ {'."\n";
			$php_options_text.= "\t\t".'fastcgi_index index.php;'."\n";
			$php_options_text.= "\t\t".'include /etc/nginx/fastcgi_params;'."\n";
			$php_options_text.= "\t\t".'fastcgi_param SCRIPT_FILENAME '.makeCorrectDir($domain['documentroot']).'$fastcgi_script_name;'."\n";
			$php_options_text.= "\t\t".'fastcgi_pass unix:' . $php->getInterface()->getSocketFile() . ';' . "\n";
			$php_options_text.= "\t".'}'."\n";

			// create starter-file | config-file
			$php->getInterface()->createConfig($phpconfig);
			
			// create php.ini 
			// @TODO make php-fpm support this
			$php->getInterface()->createIniFile($phpconfig);
		}
		else
		{
			$php_options_text.= '  # PHP is disabled for this vHost' . "\n";
		}

		return $php_options_text;
	}
}
