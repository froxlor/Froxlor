<?php

/**
 * This file is part of the SysCP project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.syscp.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Florian Lippert <flo@syscp.org>
 * @license    GPLv2 http://files.syscp.org/misc/COPYING.txt
 * @package    Functions
 * @version    $Id: function.validateFormFieldLabel.php 2733 2009-11-06 09:32:00Z flo $
 */

function validateFormFieldLabel($fieldname, $fielddata, $newfieldvalue)
{
	// Return false, in case we happen to have that field in our $input array, so someone doesn't get the chance to save crap to our database
	// TODO: Throw some error that actually makes sense - false would just throw unknown error

	return false;
}
