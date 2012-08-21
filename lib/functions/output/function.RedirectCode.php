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
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Functions
 * @version    $$
 */

/**
 * return an array of all enabled redirect-codes
 * 
 * @return array array of enabled redirect-codes
 */
function getRedirectCodesArray()
{
	global $db, $theme;
	
	$sql = "SELECT * FROM `".TABLE_PANEL_REDIRECTCODES."` WHERE `enabled` = '1' ORDER BY `id` ASC";
	$result = $db->query($sql);
	
	$codes = array();
	while($rc = $db->fetch_array($result))
	{
		$codes[] = $rc;
	}
	
	return $codes;
}

/**
 * return an array of all enabled redirect-codes
 * for the settings form
 * 
 * @return array array of enabled redirect-codes
 */
function getRedirectCodes()
{
	global $db, $lng, $theme;
	
	$sql = "SELECT * FROM `".TABLE_PANEL_REDIRECTCODES."` WHERE `enabled` = '1' ORDER BY `id` ASC";
	$result = $db->query($sql);
	
	$codes = array();
	while($rc = $db->fetch_array($result))
	{
		$codes[$rc['id']] = $rc['code']. ' ('.$lng['redirect_desc'][$rc['desc']].')';
	}
	
	return $codes;
}

/**
 * returns the redirect-code for a given 
 * domain-id
 * 
 * @param integer $domainid id of the domain
 * 
 * @return string redirect-code
 */
function getDomainRedirectCode($domainid = 0)
{
	global $db, $theme;

	$code = '';
	if($domainid > 0)
	{
		$sql = "SELECT `r`.`code` as `redirect` 
				FROM `".TABLE_PANEL_REDIRECTCODES."` `r`, `".TABLE_PANEL_DOMAINREDIRECTS."` `rc` 
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = '".(int)$domainid."'";
		
		$result = $db->query_first($sql);
		
		if(is_array($result)
			&& isset($result['redirect'])
		) {
			$code = ($result['redirect'] == '---') ? '' : $result['redirect'];
		}
	}
	return $code;
}

/**
 * returns the redirect-id for a given 
 * domain-id
 * 
 * @param integer $domainid id of the domain
 * 
 * @return integer redirect-code-id
 */
function getDomainRedirectId($domainid = 0)
{
	global $db, $theme;

	$code = 1;
	if($domainid > 0)
	{
		$sql = "SELECT `r`.`id` as `redirect` 
				FROM `".TABLE_PANEL_REDIRECTCODES."` `r`, `".TABLE_PANEL_DOMAINREDIRECTS."` `rc` 
				WHERE `r`.`id` = `rc`.`rid` and `rc`.`did` = '".(int)$domainid."'";
		
		$result = $db->query_first($sql);
		
		if(is_array($result)
			&& isset($result['redirect'])
		) {
			$code = (int)$result['redirect'];
		}
	}
	return $code;
}

/**
 * adds a redirectcode for a domain
 * 
 * @param integer $domainid id of the domain to add the code for
 * @param integer $redirect selected redirect-id 
 * 
 * @return null
 */
function addRedirectToDomain($domainid = 0, $redirect = 1)
{
	global $db, $theme;
	if($domainid > 0)
	{
		$db->query("INSERT INTO `".TABLE_PANEL_DOMAINREDIRECTS."`
					SET `rid` = '".(int)$redirect."', `did` = '".(int)$domainid."'");
	}
}

/**
 * updates the redirectcode of a domain
 * if redirect-code is false, nothing happens
 * 
 * @param integer $domainid id of the domain to update
 * @param integer $redirect selected redirect-id or false
 * 
 * @return null
 */
function updateRedirectOfDomain($domainid = 0, $redirect = false)
{
	global $db, $theme;

	if($redirect == false)
	{
		return;
	}
	
	if($domainid > 0)
	{
		$db->query("DELETE FROM `".TABLE_PANEL_DOMAINREDIRECTS."` 
					WHERE `did` = '".(int)$domainid."'");
		$db->query("INSERT INTO `".TABLE_PANEL_DOMAINREDIRECTS."`
					SET `rid` = '".(int)$redirect."', `did` = '".(int)$domainid."'");
	}
}
