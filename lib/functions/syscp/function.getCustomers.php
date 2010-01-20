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
 * @version    $Id: function.getCustomers.php 2735 2009-11-06 09:52:59Z flo $
 */

function getCustomers($limit_resource = '')
{
	global $db;

	$additional_conditions = '';
	$additional_conditions_array = array();
	if(getSessionUserDetail('customers_see_all') != true)
	{
		$additional_conditions_array[] = '`adminid` = \'' . (int)getSessionUserDetail('adminid') . '\'';
	}
	if($limit_resource != '')
	{
		$additional_conditions_array[] = '(`' . $limit_resource . '_used` < `' . $limit_resource . '` OR `' . $limit_resource . '` = \'-1\')';
	}
	if(!empty($additional_conditions_array))
	{
		$additional_conditions = ' WHERE ' . implode(' AND ', $additional_conditions_array) . ' ';
	}

	$query = 'SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `' . TABLE_PANEL_CUSTOMERS . '` ' . $additional_conditions  . ' ORDER BY `name` ASC';
	$result = $db->query($query);
	$customers_array = array();

	while($row = $db->fetch_array($result))
	{
		$customers_array[$row['customerid']] = getCorrectFullUserDetails($row) . ' (' . $row['loginname'] . ')';
	}

	return $customers_array;
}
