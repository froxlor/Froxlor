<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    System
 *
 */

define('TABLE_FTP_GROUPS', 'ftp_groups');
define('TABLE_FTP_USERS', 'ftp_users');
define('TABLE_FTP_QUOTALIMITS', 'ftp_quotalimits');
define('TABLE_FTP_QUOTATALLIES', 'ftp_quotatallies');
define('TABLE_MAIL_AUTORESPONDER', 'mail_autoresponder');
define('TABLE_MAIL_USERS', 'mail_users');
define('TABLE_MAIL_VIRTUAL', 'mail_virtual');
define('TABLE_PANEL_ACTIVATION', 'panel_activation');
define('TABLE_PANEL_ADMINS', 'panel_admins');
define('TABLE_PANEL_CUSTOMERS', 'panel_customers');
define('TABLE_PANEL_DATABASES', 'panel_databases');
define('TABLE_PANEL_DOMAINS', 'panel_domains');
define('TABLE_PANEL_HTACCESS', 'panel_htaccess');
define('TABLE_PANEL_HTPASSWDS', 'panel_htpasswds');
define('TABLE_PANEL_SESSIONS', 'panel_sessions');
define('TABLE_PANEL_SETTINGS', 'panel_settings');
define('TABLE_PANEL_TASKS', 'panel_tasks');
define('TABLE_PANEL_TEMPLATES', 'panel_templates');
define('TABLE_PANEL_TRAFFIC', 'panel_traffic');
define('TABLE_PANEL_TRAFFIC_ADMINS', 'panel_traffic_admins');
define('TABLE_PANEL_DISKSPACE', 'panel_diskspace');
define('TABLE_PANEL_DISKSPACE_ADMINS', 'panel_diskspace_admins');
define('TABLE_PANEL_LANGUAGE', 'panel_languages');
define('TABLE_PANEL_IPSANDPORTS', 'panel_ipsandports');
define('TABLE_PANEL_TICKETS', 'panel_tickets');
define('TABLE_PANEL_TICKET_CATS', 'panel_ticket_categories');
define('TABLE_PANEL_LOG', 'panel_syslog');
define('TABLE_PANEL_PHPCONFIGS', 'panel_phpconfigs');
define('TABLE_PANEL_CRONRUNS', 'cronjobs_run');
define('TABLE_PANEL_REDIRECTCODES', 'redirect_codes');
define('TABLE_PANEL_DOMAINREDIRECTS', 'domain_redirect_codes');
define('TABLE_PANEL_DOMAIN_SSL_SETTINGS', 'domain_ssl_settings');
define('TABLE_DOMAINTOIP', 'panel_domaintoip');
define('TABLE_DOMAIN_DNS', 'domain_dns_entries');
define('TABLE_PANEL_FPMDAEMONS', 'panel_fpmdaemons');
define('TABLE_PANEL_PLANS', 'panel_plans');
define('TABLE_API_KEYS', 'api_keys');

require dirname(__FILE__).'/version.inc.php';
