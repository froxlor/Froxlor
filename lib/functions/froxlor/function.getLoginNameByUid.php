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
	global $db, $theme;
	
	$result = $db->query_first("SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `guid` = '".(int)$uid."'");
	if(is_array($result)
		&& isset($result['loginname'])
	) {
		return $result['loginname'];
	}
	return false;
}
