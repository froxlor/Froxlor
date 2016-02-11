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
 * @author     Daniel Reichelt <hacking@nachtgeist.net> (2016-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 *
 */

function getFormFieldDataText($fieldname, $fielddata, &$input) {
	if(isset($input[$fieldname])) {
		$newfieldvalue = str_replace("\r\n", "\n", $input[$fieldname]);
	} else {
		$newfieldvalue = $fielddata['default'];
	}

	return $newfieldvalue;
}
