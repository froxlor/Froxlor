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
 * @version    $Id: function.getFormFieldOutputLabel.php 2724 2009-06-07 14:18:02Z flo $
 */

function getFormFieldOutputLabel($fieldname, $fielddata)
{
	$label = $fielddata['label'];
	eval("\$returnvalue = \"" . getTemplate("formfields/label", true) . "\";");
	return $returnvalue;
}
