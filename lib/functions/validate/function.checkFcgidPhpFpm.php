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
 * @package    Functions
 *
 */
function checkFcgidPhpFpm($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
    $returnvalue = array(
        FORMFIELDS_PLAUSIBILITY_CHECK_OK
    );
    
    $check_array = array(
        'system_mod_fcgid_enabled' => array(
            'other_post_field' => 'system_phpfpm_enabled',
            'other_enabled' => 'phpfpm.enabled',
            'other_enabled_lng' => 'phpfpmstillenabled'
        ),
        'system_phpfpm_enabled' => array(
            'other_post_field' => 'system_mod_fcgid_enabled',
            'other_enabled' => 'system.mod_fcgid',
            'other_enabled_lng' => 'fcgidstillenabled'
        )
    );
    
    // interface is to be enabled
    if ((int) $newfieldvalue == 1) {
        // check for POST value of the other field == 1 (active)
        if (isset($_POST[$check_array[$fieldname]['other_post_field']]) && (int) $_POST[$check_array[$fieldname]['other_post_field']] == 1) {
            // the other interface is activated already and STAYS activated
            if ((int) Settings::Get($check_array[$fieldname]['other_enabled']) == 1) {
                $returnvalue = array(
                    FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
                    $check_array[$fieldname]['other_enabled_lng']
                );
            } else {
                // fcgid is being validated before fpm -> "ask" fpm about its state
                if ($fieldname == 'system_mod_fcgid_enabled') {
                    $returnvalue = checkFcgidPhpFpm('system_phpfpm_enabled', null, $check_array[$fieldname]['other_post_field'], null);
                } else {
                    // not, bot are nogo
                    $returnvalue = $returnvalue = array(
                        FORMFIELDS_PLAUSIBILITY_CHECK_ERROR,
                        'fcgidandphpfpmnogoodtogether'
                    );
                }
            }
        }
    }
    
    return $returnvalue;
}
