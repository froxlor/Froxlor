<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2015 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 * @since 0.9.34
 */

/**
 * Whenever the webserver- / FCGID- or FPM-user gets updated
 * we need to update ftp_groups accordingly
 */
function storeSettingWebserverFcgidFpmUser($fieldname, $fielddata, $newfieldvalue)
{
    if (is_array($fielddata) && isset($fielddata['settinggroup']) && isset($fielddata['varname'])) {
        
        $update_user = null;
        
        // webserver
        if ($fielddata['settinggroup'] == 'system' && $fielddata['varname'] == 'httpuser') {
            $update_user = Settings::Get('system.httpuser');
        }
        
        // fcgid
        if ($fielddata['settinggroup'] == 'system' && $fielddata['varname'] == 'mod_fcgid_httpuser') {
            $update_user = Settings::Get('system.mod_fcgid_httpuser');
        }
        
        // webserver
        if ($fielddata['settinggroup'] == 'phpfpm' && $fielddata['varname'] == 'vhost_httpuser') {
            $update_user = Settings::Get('phpfpm.vhost_httpuser');
        }
        
        $returnvalue = storeSettingField($fieldname, $fielddata, $newfieldvalue);
        
        if ($returnvalue !== false) {
            /**
             * only update if anything changed
             */
            if ($update_user != null && $newfieldvalue != $update_user) {
                $upd_stmt = Database::prepare("UPDATE `" . TABLE_FTP_GROUPS . "` SET `members` = REPLACE(`members`, :olduser, :newuser)");
                Database::pexecute($upd_stmt, array('olduser' => $update_user, 'newuser' => $newfieldvalue));
            }
        }
    }
    
    return $returnvalue;
}
