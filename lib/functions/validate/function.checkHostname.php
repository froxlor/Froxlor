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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 *
 * @param mixed $fieldname
 * @param mixed $fielddata
 * @param mixed $newfieldvalue
 * @param mixed $allnewfieldvalues
 */
function checkHostname($fieldname, $fielddata, $newfieldvalue, $allnewfieldvalues)
{
    if (0 === strlen(trim($newfieldvalue))
        || validateDomain($newfieldvalue) === false
    ) {
        return array(FORMFIELDS_PLAUSIBILITY_CHECK_ERROR, 'invalidhostname');
    }

    return array(FORMFIELDS_PLAUSIBILITY_CHECK_OK);
}
