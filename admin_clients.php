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
 * @package    Panel
 * @version    $Id$
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

// only if multiserver is enabled
if((int)$settings['multiserver']['enabled'] == 1)
{
	if($page == 'clients'
	   || $page == 'overview')
	{
		if($action == '')
		{
			$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_clients");

			$fields = array(
				'id' => 'ID#',
				'name' => $lng['admin']['froxlorclients']['name'],
				'enabled' => $lng['admin']['froxlorclients']['enabled']
			);
			$paging = new paging($userinfo, $db, TABLE_FROXLOR_CLIENTS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
			$ipsandports = '';
			$result = $db->query("SELECT * FROM `" . TABLE_FROXLOR_CLIENTS . "` " . $paging->getSqlWhere(false) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
			$paging->setEntries($db->num_rows($result));
			$sortcode = $paging->getHtmlSortCode($lng);
			$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
			$searchcode = $paging->getHtmlSearchCode($lng);
			$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
			$i = 0;
			$count = 0;

			while($row = $db->fetch_array($result))
			{
				if($paging->checkDisplay($i))
				{
					$row = htmlentities_array($row);
					if((int)$row['enabled'] == 1) {
						$row['enabled'] = $lng['panel']['yes'];
					} else {
						$row['enabled'] = $lng['panel']['no'];
					}
					eval("\$froxlorclients.=\"" . getTemplate("froxlorclients/froxlorclients_client") . "\";");
					$count++;
				}
				$i++;
			}
			eval("echo \"" . getTemplate("froxlorclients/froxlorclients") . "\";");
		}
		elseif($action == 'delete'
		       && $id != 0)
		{
			$client = froxlorclient::getInstance($userinfo, $db, $settings, $id);
	
			if(isset($_POST['send'])
				&& $_POST['send'] == 'send')
			{
				$log->logAction(ADM_ACTION, LOG_INFO, "deleted froxlor-client '" . $client->Get('name') . "'");
				$client->Delete();
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				ask_yesno('client_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $client->Get('name'));
			}
		}
		elseif($action == 'add')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$name = validate($_POST['name'], 'name');
				$desc = validate($_POST['desc'], 'desc');
				$client_enabled = intval($_POST['vhostcontainer']);

				if($name == '')
				{
					standard_error(array('stringisempty', 'name'));
				}

				if($desc == '')
				{
					standard_error(array('stringisempty', 'desc'));
				}
				
				if($client_enabled != 1) {
					$client_enabled = 0;
				}

				$new_client = froxlorclient::getInstance($userinfo, $db, $settings, -1);
				$new_client->Set('name', $name, true, false);
				$new_client->Set('desc', $desc, true, false);
				$new_client->Set('enabled', $client_enabled, true, true);
				$cid = $new_client->Insert();

				$log->logAction(ADM_ACTION, LOG_WARNING, "added froxlor-client '" . $name . "' (#" . $cid . ")");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
			else
			{
				$client_enabled = makeyesno('enabled', '1', '0', '0');
				eval("echo \"" . getTemplate("froxlorclients/froxlorclients_add") . "\";");
			}
		}
		/**
		 * edit client-base data like name and description
		 */
		elseif($action == 'edit'
			&& $id != 0
		) {
			$client = froxlorclient::getInstance($userinfo, $db, $settings, $id);

			if(isset($_POST['send'])
				&& $_POST['send'] == 'send')
			{

			}
			else
			{

			}
		}
		/**
		 * edit client settings 
		 */
		elseif($action == 'settings'
			&& $id != 0
		) {
			$client = froxlorclient::getInstance($userinfo, $db, $settings, $id);

			$settings_data = $client->getSettingsData();
			$settings = $client->getSettingsArray();

			if(isset($_POST['send'])
				&& $_POST['send'] == 'send')
			{
			}
			else
			{
			}
		}
	}
}
