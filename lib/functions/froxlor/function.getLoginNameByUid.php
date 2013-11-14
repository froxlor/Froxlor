<?php

/**
 * returns the loginname of a customer by given uid
 * 
 * @param int $uid uid of customer
 * 
 * @return string customers loginname
 */
function getLoginNameByUid($uid = null) {

	$result_stmt = Database::prepare("
		SELECT `loginname` FROM `" . TABLE_PANEL_CUSTOMERS . "` WHERE `guid` = :guid
	");
	$result = Database::pexecute_first($result_stmt, array('guid' => $uid));

	if (is_array($result)
		&& isset($result['loginname'])
	) {
		return $result['loginname'];
	}
	return false;
}
