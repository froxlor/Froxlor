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
 * @package    Functions
 *
 */

function validateFormFieldHidden($fieldname, $fielddata, $newfieldvalue)
{
	/**
	 * don't show error on cronjob-timestamps changing
	 * because it might be possible that the cronjob ran
	 * while settings have been edited (bug #52)
	 */
	if($newfieldvalue === $fielddata['value']
		|| $fieldname == 'system_last_tasks_run'
		|| $fieldname == 'system_last_traffic_run'
		|| $fieldname == 'system_lastcronrun'
	) {
		return true;
	}
	else
	{
		return 'hiddenfieldvaluechanged';
	}
}
