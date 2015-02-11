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
 * @package    Panel
 *
 * @since 0.9.34
 */
define('AREA', 'admin');
require './lib/init.php';

if ($userinfo['change_serversettings'] == '1') {
    
    $replace_arr = Array(
        '<SQL_UNPRIVILEGED_USER>' => $sql['user'],
        '<SQL_UNPRIVILEGED_PASSWORD>' => 'MYSQL_PASSWORD',
        '<SQL_DB>' => $sql['db'],
        '<SQL_HOST>' => $sql['host'],
        '<SERVERNAME>' => Settings::Get('system.hostname'),
        '<SERVERIP>' => Settings::Get('system.ipaddress'),
        '<NAMESERVERS>' => Settings::Get('system.nameservers'),
        '<VIRTUAL_MAILBOX_BASE>' => Settings::Get('system.vmail_homedir'),
        '<VIRTUAL_UID_MAPS>' => Settings::Get('system.vmail_uid'),
        '<VIRTUAL_GID_MAPS>' => Settings::Get('system.vmail_gid'),
        '<SSLPROTOCOLS>' => (Settings::Get('system.use_ssl') == '1') ? 'imaps pop3s' : '',
        '<CUSTOMER_TMP>' => (Settings::Get('system.mod_fcgid_tmpdir') != '') ? makeCorrectDir(Settings::Get('system.mod_fcgid_tmpdir')) : '/tmp/',
        '<BASE_PATH>' => makeCorrectDir(FROXLOR_INSTALL_DIR),
        '<BIND_CONFIG_PATH>' => makeCorrectDir(Settings::Get('system.bindconf_directory')),
        '<WEBSERVER_RELOAD_CMD>' => Settings::Get('system.apachereload_command'),
        '<CUSTOMER_LOGS>' => makeCorrectDir(Settings::Get('system.logfiles_directory')),
        '<FPM_IPCDIR>' => makeCorrectDir(Settings::Get('phpfpm.fastcgi_ipcdir')),
        '<WEBSERVER_GROUP>' => Settings::Get('system.httpgroup')
    );
    
    // get distro from URL param
    $distribution = isset($_GET['distribution']) ? $_GET['distribution'] : "";
    $service = isset($_GET['service']) ? $_GET['service'] : "";
    $daemon = isset($_GET['daemon']) ? $_GET['daemon'] : "";
    $distributions_select = "";
    $services_select = "";
    $daemons_select = "";
    
    $configfiles = "";
    $services = "";
    $daemons = "";
    
    $config_dir = makeCorrectDir(FROXLOR_INSTALL_DIR . '/lib/configfiles/');
    
    if ($distribution != "") {
        // create configparser object
        $configfiles = new ConfigParser($config_dir . '/' . $distribution . ".xml");
        
        // get distro-info
        $dist_display = getCompleteDistroName($configfiles);
        
        // get all the services from the distro
        $services = $configfiles->getServices();
        
        if ($service != "") {
            
            $daemons = $services[$service]->getDaemons();
            
            if ($daemon == "") {
                foreach ($daemons as $di => $dd) {
                    $title = $dd->title;
                    if ($dd->default) {
                        $title = $title." ".$lng['panel']['default'];
                    }
                    $daemons_select .= makeoption($title, $di);
                }
            }
        } else {
            foreach ($services as $si => $sd) {
                $services_select .= makeoption($sd->title, $si);
            }
        }
    } else {
        
        // show list of available distro's
        $distros = glob($config_dir . '*.xml');
        // tmp array
        $distributions_select_data = array();
        // read in all the distros
        foreach ($distros as $_distribution) {
            // get configparser object
            $dist = new ConfigParser($_distribution);
            // get distro-info
            $dist_display = getCompleteDistroName($dist);
            // store in tmp array
            $distributions_select_data[$dist_display] = str_replace(".xml", "", strtolower(basename($_distribution)));
        }
        
        // sort by distribution name
        ksort($distributions_select_data);
        
        foreach ($distributions_select_data as $dist_display => $dist_index) {
            // create select-box-option
            $distributions_select .= makeoption($dist_display, $dist_index);
        }
    }
    
    if ($distribution != "" && $service != "" && $daemon != "") {
        
        $confarr = $daemons[$daemon]->getConfig();
        
        $configpage = '';
        
        $commands_pre = "";
        $commands_file = "";
        $commands_post = "";
        
        $lasttype = '';
        $commands = '';
        foreach ($confarr as $idx => $action) {
            if ($lasttype != '' && $lasttype != $action['type']) {
                eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
                $lasttype = '';
                $commands = '';
            }
            switch ($action['type']) {
                case "install":
                    $commands .= $action['content'] . "\n";
                    $lasttype = "install";
                    break;
                case "command":
                    $commands .= $action['content'] . "\n";
                    $lasttype = "command";
                    break;
                case "file":
                    if (array_key_exists('content', $action)) {
                        $commands_file = getFileContentContainer($action['content'], $replace_arr, $action['name']);
                    } elseif (array_key_exists('subcommands', $action)) {
                        foreach ($action['subcommands'] as $fileaction) {
                            if (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "pre") {
                                $commands_pre .= $fileaction['content'] . "\n";
                            } elseif (array_key_exists('execute', $fileaction) && $fileaction['execute'] == "post") {
                                $commands_post .= $fileaction['content'] . "\n";
                            } elseif ($fileaction['type'] == 'file') {
                                $commands_file = getFileContentContainer($fileaction['content'], $replace_arr, $action['name']);
                            }
                        }
                    }
                    $realname = $action['name'];
                    $commands = trim($commands_pre);
                    if ($commands != "") {
                        eval("\$commands_pre=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
                    }
                    $commands = trim($commands_post);
                    if ($commands != "") {
                        eval("\$commands_post=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
                    }
                    eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_subfileblock") . "\";");
                    $commands = '';
                    $commands_pre = '';
                    $commands_post = '';
                    break;
            }
        }
        $commands = trim($commands);
        if ($commands != '') {
            eval("\$configpage.=\"" . getTemplate("configfiles/configfiles_commands") . "\";");
        }
        eval("echo \"" . getTemplate("configfiles/configfiles") . "\";");
    } else {
        eval("echo \"" . getTemplate("configfiles/wizard") . "\";");
    }
} else {
    die('not allowed to see this page');
    // redirect or similar here
}

// helper functions
function getFileContentContainer($file_content, &$replace_arr, $realname)
{
    $files = "";
    if ($file_content != '') {
        $file_content = strtr($file_content, $replace_arr);
        $file_content = htmlspecialchars($file_content);
        eval("\$files=\"" . getTemplate("configfiles/configfiles_file") . "\";");
    }
    return $files;
}

function getCompleteDistroName($cparser)
{
    // get distro-info
    $dist_display = $cparser->distributionName;
    if ($cparser->distributionCodename != '') {
        $dist_display .= " ".$cparser->distributionCodename;
    }
    if ($cparser->distributionVersion != '') {
        $dist_display .= " (" . $cparser->distributionVersion . ")";
    }
    if ($cparser->deprecated) {
        $dist_display .= " [deprecated]";
    }
    return $dist_display;
}
