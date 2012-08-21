<?php

/**
 * returns the customer-id of a customer by given domain
 * 
 * @param string $domain users domain
 * 
 * @return int customers id
 */
function getCustomerIdByDomain($domain = null)
{
	global $db, $theme;
	
	$result = $db->query_first("SELECT `customerid` FROM `" . TABLE_PANEL_DOMAINS . "` WHERE `domain` = '".$domain."'");
	if(is_array($result)
		&& isset($result['customerid'])
	) {
		return $result['customerid'];
	}
	return false;
}
