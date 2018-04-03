<?php declare(strict_types=1);
/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 *
 * @since      0.9.29
 */
class ConfigIO
{
    /**
     * constructor
     */
    public function __construct()
    {
    }

    /**
     * clean up former created configs, including (if enabled)
     * awstats, fcgid, php-fpm and of course automatically created
     * webserver vhost and diroption files
     */
    public function cleanUp()
    {
        
        // old error logs
        $this->_cleanErrLogs();
        
        // awstats files
        $this->_cleanAwstatsFiles();
        
        // fcgid files
        $this->_cleanFcgidFiles();
        
        // php-fpm files
        $this->_cleanFpmFiles();
        
        // clean webserver-configs
        $this->_cleanWebserverConfigs();
        
        // old htpasswd files
        $this->_cleanHtpasswdFiles();
        
        // customer-specified ssl-certificates
        $this->_cleanCustomerSslCerts();
    }

    private function _cleanErrLogs()
    {
        $err_dir = makeCorrectDir(FROXLOR_INSTALL_DIR . '/logs/');
        if (@is_dir($err_dir)) {
            // now get rid of old stuff
            // (but append /*.log so we don't delete the directory)
            $err_dir .= '/*.log';
            safe_exec('rm -f ' . makeCorrectFile($err_dir));
        }
    }

    /**
     * remove customer-specified auto-generated ssl-certificates
     * (they are being regenerated)
     */
    private function _cleanCustomerSslCerts()
    {
        
        /*
         * only clean up if we're actually using SSL
         */
        if (Settings::Get('system.use_ssl') === '1') {
            // get correct directory
            $configdir = $this->_getFile('system', 'customer_ssl_path');
            if ($configdir !== false) {
                $configdir = makeCorrectDir($configdir);
                
                if (@is_dir($configdir)) {
                    // now get rid of old stuff
                    // (but append /* so we don't delete the directory)
                    $configdir .= '/*';
                    safe_exec('rm -f ' . makeCorrectFile($configdir));
                }
            }
        }
    }

    /**
     * remove webserver related configuration files before regeneration
     */
    private function _cleanWebserverConfigs()
    {
        
        // get directories
        $configdirs = array();
        $dir = $this->_getFile('system', 'apacheconf_vhost');
        if ($dir !== false) {
            $configdirs[] = makeCorrectDir($dir);
        }
        
        $dir = $this->_getFile('system', 'apacheconf_diroptions');
        if ($dir !== false) {
            $configdirs[] = makeCorrectDir($dir);
        }
        
        // file pattern
        $pattern = "/^([0-9]){2}_(froxlor|syscp)_(.+)\.conf$/";
        
        // check ALL the folders
        foreach ($configdirs as $config_dir) {
            
            // check directory
            if (@is_dir($config_dir)) {
                
                // create directory iterator
                $its = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($config_dir));
                
                // iterate through all subdirs,
                // look for vhost/diroption files
                // and delete them
                foreach ($its as $fullFileName => $it) {
                    if ($it->isFile() && preg_match($pattern, $it->getFilename())) {
                        // remove file
                        safe_exec('rm -f ' . escapeshellarg(makeCorrectFile($its->getPathname())));
                    }
                }
            }
        }
    }

    /**
     * remove htpasswd files before regeneration
     */
    private function _cleanHtpasswdFiles()
    {
        
        // get correct directory
        $configdir = $this->_getFile('system', 'apacheconf_htpasswddir');
        
        if ($configdir !== false) {
            $configdir = makeCorrectDir($configdir);
            
            if (@is_dir($configdir)) {
                // now get rid of old stuff
                // (but append /* so we don't delete the directory)
                $configdir .= '/*';
                safe_exec('rm -f ' . makeCorrectFile($configdir));
            }
        }
    }

    /**
     * remove awstats related configuration files before regeneration
     */
    private function _cleanAwstatsFiles()
    {
        if (Settings::Get('system.awstats_enabled') === '0') {
            return;
        }
        
        // dhr: cleanout froxlor-generated awstats configs prior to re-creation
        $awstatsclean['header'] = "## GENERATED BY FROXLOR\n";
        $awstatsclean['headerold'] = "## GENERATED BY SYSCP\n";
        $awstatsclean['path'] = $this->_getFile('system', 'awstats_conf');
        
        /**
         * don't do anything if the directory does not exist
         * (e.g.
         * awstats not installed yet or whatever)
         * fixes #45
         */
        if ($awstatsclean['path'] !== false && is_dir($awstatsclean['path'])) {
            $awstatsclean['dir'] = dir($awstatsclean['path']);
            while ($awstatsclean['entry'] = $awstatsclean['dir']->read()) {
                $awstatsclean['fullentry'] = makeCorrectFile($awstatsclean['path'] . '/' . $awstatsclean['entry']);
                /**
                 * don't do anything if the file does not exist
                 */
                if (@file_exists($awstatsclean['fullentry'])) {
                    $awstatsclean['fh'] = fopen($awstatsclean['fullentry'], 'r');
                    $awstatsclean['headerRead'] = fgets($awstatsclean['fh'], strlen($awstatsclean['header']) + 1);
                    fclose($awstatsclean['fh']);
                    
                    if ($awstatsclean['headerRead'] === $awstatsclean['header'] || $awstatsclean['headerRead'] === $awstatsclean['headerold']) {
                        $awstats_conf_file = makeCorrectFile($awstatsclean['fullentry']);
                        @unlink($awstats_conf_file);
                    }
                }
            }
        }
        unset($awstatsclean);
        // end dhr
    }

    /**
     * remove fcgid related configuration files before regeneration
     */
    private function _cleanFcgidFiles()
    {
        if (Settings::Get('system.mod_fcgid') === '0') {
            return;
        }
        
        // get correct directory
        $configdir = $this->_getFile('system', 'mod_fcgid_configdir');
        if ($configdir !== false) {
            $configdir = makeCorrectDir($configdir);
            
            if (@is_dir($configdir)) {
                // create directory iterator
                $its = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configdir));
                
                // iterate through all subdirs,
                // look for php-fcgi-starter files
                // and take immutable-flag away from them
                // so we can delete them :)
                foreach ($its as $fullFileName => $it) {
                    if ($it->isFile() && $it->getFilename() === 'php-fcgi-starter') {
                        // set chattr -i
                        removeImmutable($its->getPathname());
                    }
                }
                
                // now get rid of old stuff
                // (but append /* so we don't delete the directory)
                $configdir .= '/*';
                safe_exec('rm -rf ' . makeCorrectFile($configdir));
            }
        }
    }

    /**
     * remove php-fpm related configuration files before regeneration
     */
    private function _cleanFpmFiles()
    {
        if (Settings::Get('phpfpm.enabled') === '0') {
            return;
        }
        
        // get all fpm config paths
        $fpmconf_sel = Database::prepare('SELECT config_dir FROM `' . TABLE_PANEL_FPMDAEMONS . '`');
        Database::pexecute($fpmconf_sel);
        $fpmconf_paths = $fpmconf_sel->fetchAll(PDO::FETCH_ASSOC);
        // clean all php-fpm config-dirs
        foreach ($fpmconf_paths as $configdir) {
            $configdir = makeCorrectDir($configdir['config_dir']);
            if (@is_dir($configdir)) {
                // now get rid of old stuff
                // (but append /*.conf so we don't delete the directory)
                $configdir .= '/*.conf';
                safe_exec('rm -f ' . makeCorrectFile($configdir));
            } else {
                safe_exec('mkdir -p ' . $configdir);
            }
        }
        
        // also remove aliasconfigdir #1273
        $aliasconfigdir = $this->_getFile('phpfpm', 'aliasconfigdir');
        if ($aliasconfigdir !== false) {
            $aliasconfigdir = makeCorrectDir($aliasconfigdir);
            if (@is_dir($aliasconfigdir)) {
                $aliasconfigdir .= '/*';
                safe_exec('rm -rf ' . makeCorrectFile($aliasconfigdir));
            }
        }
    }

    /**
     * returns a file/direcotry from the settings and checks whether it exists
     *
     * @param string $group
     *        	settings-group
     * @param string $varname
     *        	var-name
     * @param bool $check_exists
     *        	check if the file exists
     *
     * @return string|bool complete path including filename if any or false on error
     */
    private function _getFile($group, $varname, $check_exists = true)
    {
        
        // read from settings
        $file = Settings::Get($group . '.' . $varname);
        
        // check whether it exists
        if ($check_exists && @file_exists($file) === false) {
            return false;
        }

        return $file;
    }
}
