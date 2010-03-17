<?php

/**
 * returns the loginname of a customer by given uid
 * 
 * @param int $uid uid of customer
 * 
 * @return string customers loginname
 */
function getLoginNameByUid($uid = null)
{
	global $db;
	
	$result = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `guid` = '".(int)$uid."'");
	if($db->num_rows($result) > 0)
	{
		return $result['loginname'];
	}
	return false;
}
