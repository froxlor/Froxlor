<?php

/**
 * Support-Tickets - Admin
 *
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version. This program is distributed in the
 * hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @license    http://www.gnu.org/licenses/gpl.txt
 * @package    Panel
 * @version    CVS: $Id$
 * @link       http://www.nutime.de/
 * @since      File available since Release 1.2.18
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

if($page == 'tickets'
   && $userinfo['customers'] != '0')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_tickets");
		$fields = array(
			'status' => $lng['ticket']['status'],
			'priority' => $lng['ticket']['priority'],
			'lastchange' => $lng['ticket']['lastchange'],
			'ticket_answers' => $lng['ticket']['ticket_answers'],
			'subject' => $lng['ticket']['subject'],
			'lastreplier' => $lng['ticket']['lastreplier']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_TICKETS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$paging->sortfield = 'lastchange';
		$paging->sortorder = 'desc';
		$result = $db->query('SELECT `main`.`id`, `main`.`customerid`, (SELECT COUNT(`sub`.`id`) FROM `' . TABLE_PANEL_TICKETS . '` `sub` WHERE `sub`.`answerto` = `main`.`id`) as `ticket_answers`, `main`.`lastchange`, `main`.`subject`, `main`.`status`, `main`.`lastreplier`, `main`.`priority` FROM `' . TABLE_PANEL_TICKETS . '` as `main` WHERE `main`.`answerto` = "0"  AND `archived` = "0" AND `adminid` = "' . (int)$userinfo['adminid'] . '" ' . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$ctickets = array();

		while($row = $db->fetch_array($result))
		{
			if(!isset($ctickets[$row['customerid']])
			   || !is_array($ctickets[$row['customerid']]))
			{
				$ctickets[$row['customerid']] = array();
			}

			$ctickets[$row['customerid']][$row['id']] = $row;
		}

		if($paging->sortfield == 'customerid'
		   && $paging->sortorder == 'desc')
		{
			krsort($ctickets);
		}
		else
		{
			ksort($ctickets);
		}

		$i = 0;
		$count = 0;
		$tickets_count = 0;
		$tickets = '';
		foreach($ctickets as $cid => $ticketrows)
		{
			$_cid = 0;
			foreach($ticketrows as $row)
			{
				if($paging->checkDisplay($i))
				{
					$row = htmlentities_array($row);
					$row['lastchange'] = date("d.m.y H:i", $row['lastchange']);

					if($_cid != $row['customerid'])
					{
						$cid = $row['customerid'];
						$usr = $db->query_first('SELECT `firstname`, `name`, `loginname` FROM `' . TABLE_PANEL_CUSTOMERS . '`
                                     WHERE `customerid` = "' . (int)$cid . '"');
						$customer = $usr['firstname'] . " " . $usr['name'] . " (" . $usr['loginname'] . ")";
						eval("\$tickets.=\"" . getTemplate("ticket/tickets_customer") . "\";");
					}

					$tickets_count++;

					if($row['status'] >= 0
					   && $row['status'] <= 2)
					{
						$reopen = 0;
					}
					else
					{
						$reopen = 1;
					}

					$row['status'] = ticket::getStatusText($lng, $row['status']);
					$row['priority'] = ticket::getPriorityText($lng, $row['priority']);

					if($row['lastreplier'] == '1')
					{
						$row['lastreplier'] = $lng['ticket']['staff'];
						$cananswer = 0;
					}
					else
					{
						$row['lastreplier'] = $lng['ticket']['customer'];
						$cananswer = 1;
					}

					if(strlen($row['subject']) > 20)
					{
						$row['subject'] = substr($row['subject'], 0, 17) . '...';
					}

					eval("\$tickets.=\"" . getTemplate("ticket/tickets_tickets") . "\";");
					$count++;
					$_cid = $row['customerid'];
				}
			}

			$i++;
		}

		eval("echo \"" . getTemplate("ticket/tickets") . "\";");
	}
	elseif($action == 'new')
	{
		if($userinfo['tickets_used'] < $userinfo['tickets']
		   || $userinfo['tickets'] == '-1')
		{
			if(isset($_POST['send'])
			   && $_POST['send'] == 'send')
			{
				$newticket = ticket::getInstanceOf($userinfo, $db, $settings, -1);
				$newticket->Set('subject', validate($_POST['subject'], 'subject'), true, false);
				$newticket->Set('priority', validate($_POST['priority'], 'priority'), true, false);
				$newticket->Set('category', validate($_POST['category'], 'category'), true, false);
				$newticket->Set('customer', validate($_POST['customer'], 'customer'), true, false);
				$newticket->Set('message', validate(str_replace("\r\n", "\n", $_POST['message']), 'message', '/^[^\0]*$/'), true, false);

				if($newticket->Get('subject') == null)
				{
					standard_error(array('stringisempty', 'mysubject'));
				}
				elseif($newticket->Get('message') == null)
				{
					standard_error(array('stringisempty', 'mymessage'));
				}
				else
				{
					$now = time();
					$newticket->Set('admin', $userinfo['adminid'], true, true);
					$newticket->Set('dt', $now, true, true);
					$newticket->Set('lastchange', $now, true, true);
					$newticket->Set('ip', $_SERVER['REMOTE_ADDR'], true, true);
					$newticket->Set('status', '0', true, true);
					$newticket->Set('lastreplier', '1', true, true);
					$newticket->Set('by', '1', true, true);
					$newticket->Insert();
					$newticket->sendMail((int)$newticket->Get('customer'), 'new_ticket_by_staff_subject', $lng['mails']['new_ticket_by_staff']['subject'], 'new_ticket_by_staff_mailbody', $lng['mails']['new_ticket_by_staff']['mailbody']);
					$log->logAction(ADM_ACTION, LOG_NOTICE, "opened a new ticket for customer #" . $newticket->Get('customer') . " - '" . $newticket->Get('subject') . "'");
					redirectTo($filename, Array('page' => $page, 's' => $s));
				}
			}
			else
			{
				$categories = '';
				$result = $db->query_first('SELECT `id`, `name` FROM `' . TABLE_PANEL_TICKET_CATS . '` WHERE `adminid` = "' . $userinfo['adminid'] . '" ORDER BY `name` ASC');

				if(isset($result['name'])
				   && $result['name'] != '')
				{
					$result2 = $db->query('SELECT `id`, `name` FROM `' . TABLE_PANEL_TICKET_CATS . '` WHERE `adminid` = "' . $userinfo['adminid'] . '" ORDER BY `name` ASC');

					while($row = $db->fetch_array($result2))
					{
						$categories.= makeoption($row['name'], $row['id']);
					}
				}
				else
				{
					$categories = makeoption($lng['ticket']['no_cat'], '0');
				}

				$customers = '';
				$result_customers = $db->query("SELECT `customerid`, `loginname`, `name`, `firstname`, `company` FROM `" . TABLE_PANEL_CUSTOMERS . "` " . ($userinfo['customers_see_all'] ? '' : " WHERE `adminid` = '" . (int)$userinfo['adminid'] . "' ") . " ORDER BY `name` ASC");

				while($row_customer = $db->fetch_array($result_customers))
				{
					if($row_customer['company'] == '')
					{
						$customers.= makeoption($row_customer['name'] . ', ' . $row_customer['firstname'] . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
					}
					else
					{
						if($row_customer['name'] != ''
						   && $row_customer['firstname'] != '')
						{
							$customers.= makeoption($row_customer['name'] . ', ' . $row_customer['firstname'] . ' | ' . $row_customer['company'] . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
						}
						else
						{
							$customers.= makeoption($row_customer['company'] . ' (' . $row_customer['loginname'] . ')', $row_customer['customerid']);
						}
					}
				}

				$priorities = makeoption($lng['ticket']['unf_high'], '1');
				$priorities.= makeoption($lng['ticket']['unf_normal'], '2');
				$priorities.= makeoption($lng['ticket']['unf_low'], '3');
				eval("echo \"" . getTemplate("ticket/tickets_new") . "\";");
			}
		}
		else
		{
			standard_error('nomoreticketsavailable');
		}
	}
	elseif($action == 'answer'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$replyticket = ticket::getInstanceOf($userinfo, $db, $settings, -1);
			$replyticket->Set('subject', validate($_POST['subject'], 'subject'), true, false);
			$replyticket->Set('priority', validate($_POST['priority'], 'priority'), true, false);
			$replyticket->Set('message', validate(str_replace("\r\n", "\n", $_POST['message']), 'message', '/^[^\0]*$/'), true, false);

			if($replyticket->Get('message') == null)
			{
				standard_error(array('stringisempty', 'mymessage'));
			}
			else
			{
				$now = time();
				$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
				$replyticket->Set('customerid', $mainticket->Get('customer'), true, true);
				$replyticket->Set('lastchange', $now, true, true);
				$replyticket->Set('ip', $_SERVER['REMOTE_ADDR'], true, true);
				$replyticket->Set('status', '1', true, true);
				$replyticket->Set('answerto', (int)$id, true, false);
				$replyticket->Set('by', '1', true, true);
				$replyticket->Insert();

				// Update priority if changed

				if($replyticket->Get('priority') != $mainticket->Get('priority'))
				{
					$mainticket->Set('priority', $replyticket->Get('priority'), true);
				}

				$mainticket->Set('lastchange', $now);
				$mainticket->Set('lastreplier', '1');
				$mainticket->Set('status', '2');
				$mainticket->Update();
				$mainticket->sendMail((int)$mainticket->Get('customer'), 'new_reply_ticket_by_staff_subject', $lng['mails']['new_reply_ticket_by_staff']['subject'], 'new_reply_ticket_by_staff_mailbody', $lng['mails']['new_reply_ticket_by_staff']['mailbody']);
				$log->logAction(ADM_ACTION, LOG_NOTICE, "answered ticket '" . $mainticket->Get('subject') . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		}
		else
		{
			$ticket_replies = '';
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			$lastchange = date("d.m.Y H:i\h", $mainticket->Get('lastchange'));
			$status = ticket::getStatusText($lng, $mainticket->Get('status'));

			if($mainticket->Get('status') >= 0
			   && $mainticket->Get('status') <= 2)
			{
				$isclosed = 0;
			}
			else
			{
				$isclosed = 1;
			}

			if($mainticket->Get('by') == '1')
			{
				$by = $lng['ticket']['staff'];
			}
			else
			{
				$by = $lng['ticket']['customer'];
			}

			$subject = $mainticket->Get('subject');
			$message = $mainticket->Get('message');
			eval("\$ticket_replies.=\"" . getTemplate("ticket/tickets_tickets_main") . "\";");
			$result = $db->query('SELECT `name` FROM `' . TABLE_PANEL_TICKET_CATS . '`
                                WHERE `id`="' . (int)$mainticket->Get('category') . '"');
			$row = $db->fetch_array($result);
			$andere = $db->query('SELECT * FROM `' . TABLE_PANEL_TICKETS . '` WHERE `answerto`="' . (int)$id . '" ORDER BY `lastchange` DESC');

			while($row2 = $db->fetch_array($andere))
			{
				$subticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$row2['id']);
				$lastchange = date("d.m.Y H:i\h", $subticket->Get('lastchange'));

				if($subticket->Get('by') == '1')
				{
					$by = $lng['ticket']['staff'];
				}
				else
				{
					$by = $lng['ticket']['customer'];
				}

				$subject = $subticket->Get('subject');
				$message = $subticket->Get('message');
				eval("\$ticket_replies.=\"" . getTemplate("ticket/tickets_tickets_list") . "\";");
			}

			$priorities = makeoption($lng['ticket']['high'], '1', $mainticket->Get('priority'), true, true);
			$priorities.= makeoption($lng['ticket']['normal'], '2', $mainticket->Get('priority'), true, true);
			$priorities.= makeoption($lng['ticket']['low'], '3', $mainticket->Get('priority'), true, true);
			$subject = $mainticket->Get('subject');
			$ticket_replies_count = $db->num_rows($andere) + 1;

			// don't forget the main-ticket!

			eval("echo \"" . getTemplate("ticket/tickets_reply") . "\";");
		}
	}
	elseif($action == 'close'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$now = time();
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			$mainticket->Set('lastchange', $now, true, true);
			$mainticket->Set('lastreplier', '1', true, true);
			$mainticket->Set('status', '3', true, true);
			$mainticket->Update();
			$log->logAction(ADM_ACTION, LOG_NOTICE, "closed ticket '" . $mainticket->Get('subject') . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			ask_yesno('ticket_reallyclose', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $mainticket->Get('subject'));
		}
	}
	elseif($action == 'reopen'
	       && $id != 0)
	{
		$now = time();
		$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
		$mainticket->Set('lastchange', $now, true, true);
		$mainticket->Set('lastreplier', '1', true, true);
		$mainticket->Set('status', '0', true, true);
		$mainticket->Update();
		$log->logAction(ADM_ACTION, LOG_NOTICE, "reopened ticket '" . $mainticket->Get('subject') . "'");
		redirectTo($filename, Array('page' => $page, 's' => $s));
	}
	elseif($action == 'archive'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$now = time();
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			$mainticket->Set('lastchange', $now, true, true);
			$mainticket->Set('lastreplier', '1', true, true);
			$mainticket->Set('status', '3', true, true);
			$mainticket->Update();
			$mainticket->Archive();
			$log->logAction(ADM_ACTION, LOG_NOTICE, "archived ticket '" . $mainticket->Get('subject') . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			ask_yesno('ticket_reallyarchive', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $mainticket->Get('subject'));
		}
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			$log->logAction(ADM_ACTION, LOG_INFO, "deleted ticket '" . $mainticket->Get('subject') . "'");
			$mainticket->Delete();
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			ask_yesno('ticket_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $mainticket->Get('subject'));
		}
	}
}
elseif($page == 'categories'
       && $userinfo['customers'] != '0')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_tickets::categories");
		$fields = array(
			'name' => $lng['ticket']['category']
		);
		$paging = new paging($userinfo, $db, TABLE_PANEL_TICKET_CATS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
		$result = $db->query("SELECT `main`.`id`, `main`.`name`, (
                              SELECT COUNT(`sub`.`id`) FROM `" . TABLE_PANEL_TICKETS . "` `sub`
                              WHERE `sub`.`category` = `main`.`id`
                              AND `sub`.`answerto` = '0' AND `sub`.`adminid` = '" . $userinfo['adminid'] . "')
                              as `ticketcount`, (
                              SELECT COUNT(`sub2`.`id`) FROM `" . TABLE_PANEL_TICKETS . "` `sub2`
                              WHERE `sub2`.`category` = `main`.`id`
                              AND `sub2`.`answerto` = '0'
                              AND (`sub2`.`status` = '0' OR `sub2`.`status` = '1' OR `sub2`.`status` = '2')
                              AND `sub2`.`adminid` = '" . $userinfo['adminid'] . "'
                              ) as `ticketcountnotclosed`
                              FROM `" . TABLE_PANEL_TICKET_CATS . "` `main` WHERE `main`.`adminid` = '" . (int)$userinfo['adminid'] . "' " . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
		$paging->setEntries($db->num_rows($result));
		$sortcode = $paging->getHtmlSortCode($lng);
		$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
		$searchcode = $paging->getHtmlSearchCode($lng);
		$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
		$i = 0;
		$count = 0;
		$ticketcategories = '';
		$categories_count = $db->num_rows($result);

		while($row = $db->fetch_array($result))
		{
			if($paging->checkDisplay($i))
			{
				$row = htmlentities_array($row);
				$closedtickets_count = ($row['ticketcount'] - $row['ticketcountnotclosed']);
				eval("\$ticketcategories.=\"" . getTemplate("ticket/tickets_categories") . "\";");
				$count++;
			}

			$i++;
		}

		eval("echo \"" . getTemplate("ticket/categories") . "\";");
	}
	elseif($action == 'addcategory')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$category = validate($_POST['category'], 'category');

			if($category == '')
			{
				standard_error(array('stringisempty', 'mycategory'));
			}
			else
			{
				ticket::addCategory($db, $category, $userinfo['adminid']);
				$log->logAction(ADM_ACTION, LOG_INFO, "added ticket-category '" . $category . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		}
		else
		{
			eval("echo \"" . getTemplate("ticket/tickets_newcategory") . "\";");
		}
	}
	elseif($action == 'editcategory'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$category = validate($_POST['category'], 'category');

			if($category == '')
			{
				standard_error(array('stringisempty', 'mycategory'));
			}
			else
			{
				ticket::editCategory($db, $category, $id);
				$log->logAction(ADM_ACTION, LOG_INFO, "edited ticket-category '" . $category . "'");
				redirectTo($filename, Array('page' => $page, 's' => $s));
			}
		}
		else
		{
			$row = $db->query_first('SELECT * FROM `' . TABLE_PANEL_TICKET_CATS . '` WHERE `id` = "' . (int)$id . '"');
			eval("echo \"" . getTemplate("ticket/tickets_editcategory") . "\";");
		}
	}
	elseif($action == 'deletecategory'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			if(ticket::deleteCategory($db, $id) == false)
			{
				standard_error('categoryhastickets');
			}

			$log->logAction(ADM_ACTION, LOG_INFO, "deleted ticket-category #" . $id);
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$name = ticket::getCategoryName($db, $id);
			ask_yesno('ticket_reallydeletecat', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $name);
		}
	}
}
elseif($page == 'archive'
       && $userinfo['customers'] != '0')
{
	if($action == '')
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_tickets::archive");

		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$priority = array();
			$categories = array();
			$subject = validate($_POST['subject'], 'subject');
			$priority[0] = isset($_POST['priority1']) ? $_POST['priority1'] : '';
			$priority[1] = isset($_POST['priority2']) ? $_POST['priority2'] : '';
			$priority[2] = isset($_POST['priority3']) ? $_POST['priority3'] : '';
			$fromdate = validate($_POST['fromdate'], 'fromdate');
			$todate = validate($_POST['todate'], 'todate');
			$message = validate($_POST['message'], 'message');
			$customer = validate($_POST['customer'], 'customer');
			$cat = $db->query_first('SELECT COUNT(`id`) as `ccount` FROM `' . TABLE_PANEL_TICKET_CATS . '`');
			for ($x = 0;$x < $cat['ccount'];$x++)
			{
				$categories[$x] = isset($_POST['category' . $x]) ? $_POST['category' . $x] : '';
			}

			$query = ticket::getArchiveSearchStatement($subject, $priority, $fromdate, $todate, $message, $customer, $userinfo['adminid'], $categories);
			$fields = array(
				'lastchange' => $lng['ticket']['lastchange'],
				'ticket_answers' => $lng['ticket']['ticket_answers'],
				'subject' => $lng['ticket']['subject'],
				'lastreplier' => $lng['ticket']['lastreplier'],
				'priority' => $lng['ticket']['priority']
			);
			$paging = new paging($userinfo, $db, TABLE_PANEL_TICKETS, $fields, $settings['panel']['paging'], $settings['panel']['natsorting']);
			$result = $db->query($query . $paging->getSqlWhere(true) . " " . $paging->getSqlOrderBy() . " " . $paging->getSqlLimit());
			$sortcode = $paging->getHtmlSortCode($lng);
			$arrowcode = $paging->getHtmlArrowCode($filename . '?page=' . $page . '&s=' . $s);
			$searchcode = $paging->getHtmlSearchCode($lng);
			$pagingcode = $paging->getHtmlPagingCode($filename . '?page=' . $page . '&s=' . $s);
			$ctickets = array();

			while($row = $db->fetch_array($result))
			{
				if(!isset($ctickets[$row['customerid']])
				   || !is_array($ctickets[$row['customerid']]))
				{
					$ctickets[$row['customerid']] = array();
				}

				$ctickets[$row['customerid']][$row['id']] = $row;
			}

			if($paging->sortfield == 'customerid'
			   && $paging->sortorder == 'desc')
			{
				krsort($ctickets);
			}
			else
			{
				ksort($ctickets);
			}

			$i = 0;
			$count = 0;
			$tickets_count = 0;
			$tickets = '';
			foreach($ctickets as $cid => $ticketrows)
			{
				if($paging->sortfield == 'lastchange'
				   && $paging->sortorder == 'desc')
				{
					krsort($ticketrows);
				}
				else
				{
					ksort($ticketrows);
				}

				$_cid = 0;
				foreach($ticketrows as $ticket)
				{
					if($paging->checkDisplay($i))
					{
						$ticket = htmlentities_array($ticket);
						$ticket['lastchange'] = date("d.m.y H:i", $ticket['lastchange']);

						if($_cid != $ticket['customerid'])
						{
							$cid = $ticket['customerid'];
							$usr = $db->query_first('SELECT `firstname`, `name`, `loginname` FROM `' . TABLE_PANEL_CUSTOMERS . '`
                                       WHERE `customerid` = "' . (int)$cid . '"');
							$customer = $usr['firstname'] . " " . $usr['name'] . " (" . $usr['loginname'] . ")";
							eval("\$tickets.=\"" . getTemplate("ticket/tickets_customer") . "\";");
						}

						$tickets_count++;
						$ticket['priority'] = ticket::getPriorityText($lng, $ticket['priority']);

						if($ticket['lastreplier'] == '1')
						{
							$ticket['lastreplier'] = $lng['ticket']['staff'];
						}
						else
						{
							$ticket['lastreplier'] = $lng['ticket']['customer'];
						}

						if(strlen($ticket['subject']) > 20)
						{
							$ticket['subject'] = substr($ticket['subject'], 0, 17) . '...';
						}

						eval("\$tickets.=\"" . getTemplate("ticket/archived_tickets") . "\";");
						$count++;
						$_cid = $ticket['customerid'];
					}
				}

				$i++;
			}

			eval("echo \"" . getTemplate("ticket/archivesearch") . "\";");
		}
		else
		{
			$archived = array();
			$archived = ticket::getLastArchived($db, 6, $userinfo['adminid']);
			$tickets = '';

			if($archived !== false)
			{
				foreach($archived as $id => $ticket)
				{
					$ticket['lastchange'] = date("d.m.y H:i", $ticket['lastchange']);
					$ticket['priority'] = ticket::getPriorityText($lng, $ticket['priority']);

					if($ticket['lastreplier'] == '1')
					{
						$ticket['lastreplier'] = $lng['ticket']['staff'];
					}
					else
					{
						$ticket['lastreplier'] = $lng['ticket']['customer'];
					}

					if(strlen($ticket['subject']) > 20)
					{
						$ticket['subject'] = substr($ticket['subject'], 0, 17) . '...';
					}

					eval("\$tickets.=\"" . getTemplate("ticket/archived_tickets") . "\";");
				}
			}

			$priorities_options = makecheckbox('priority1', $lng['ticket']['unf_high'], '1');
			$priorities_options.= makecheckbox('priority2', $lng['ticket']['unf_normal'], '2');
			$priorities_options.= makecheckbox('priority3', $lng['ticket']['unf_low'], '3');
			$category_options = '';
			$ccount = 0;
			$result = $db->query('SELECT * FROM `' . TABLE_PANEL_TICKET_CATS . '` ORDER BY `name` ASC');

			while($row = $db->fetch_array($result))
			{
				$category_options.= makecheckbox('category' . $ccount, $row['name'], $row['id'], true);
				$ccount++;
			}

			$customers = makeoption($lng['ticket']['nocustomer'], '-1', '-1');
			$result = $db->query_first('SELECT `customerid` FROM `' . TABLE_PANEL_CUSTOMERS . '` ' . ($userinfo['customers_see_all'] ? '' : ' WHERE `adminid` = "' . (int)$userinfo['adminid'] . '" ') . 'ORDER BY `name` ASC');

			if(isset($result['customerid'])
			   && $result['customerid'] != '')
			{
				$result2 = $db->query('SELECT `customerid`, `loginname`, `firstname`, `name`
  									          FROM `' . TABLE_PANEL_CUSTOMERS . '` ' . ($userinfo['customers_see_all'] ? '' : ' WHERE `adminid` = "' . (int)$userinfo['adminid'] . '" ') . ' ORDER BY `name` ASC');

				while($row = $db->fetch_array($result2))
				{
					$customers.= makeoption($row['name'] . ', ' . $row['firstname'] . ' (' . $row['loginname'] . ')', $row['customerid']);
				}
			}

			eval("echo \"" . getTemplate("ticket/archive") . "\";");
		}
	}
	elseif($action == 'view'
	       && $id != 0)
	{
		$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed archived-ticket #" . $id);
		$ticket_replies = '';
		$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
		$lastchange = date("d.m.Y H:i\h", $mainticket->Get('lastchange'));
		$status = ticket::getStatusText($lng, $mainticket->Get('status'));
		$isclosed = 1;

		if($mainticket->Get('by') == '1')
		{
			$by = $lng['ticket']['staff'];
		}
		else
		{
			$by = $lng['ticket']['customer'];
		}

		$subject = $mainticket->Get('subject');
		$message = $mainticket->Get('message');
		eval("\$ticket_replies.=\"" . getTemplate("ticket/tickets_tickets_main") . "\";");
		$result = $db->query('SELECT `name` FROM `' . TABLE_PANEL_TICKET_CATS . '`
                              WHERE `id`="' . (int)$mainticket->Get('category') . '"');
		$row = $db->fetch_array($result);
		$andere = $db->query('SELECT * FROM `' . TABLE_PANEL_TICKETS . '` WHERE `answerto`="' . (int)$id . '"');

		while($row2 = $db->fetch_array($andere))
		{
			$subticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$row2['id']);
			$lastchange = date("d.m.Y H:i\h", $subticket->Get('lastchange'));

			if($subticket->Get('by') == '1')
			{
				$by = $lng['ticket']['staff'];
			}
			else
			{
				$by = $lng['ticket']['customer'];
			}

			$subject = $subticket->Get('subject');
			$message = $subticket->Get('message');
			eval("\$ticket_replies.=\"" . getTemplate("ticket/tickets_tickets_list") . "\";");
		}

		$priorities = makeoption($lng['ticket']['high'], '1', $mainticket->Get('priority'), true, true);
		$priorities.= makeoption($lng['ticket']['normal'], '2', $mainticket->Get('priority'), true, true);
		$priorities.= makeoption($lng['ticket']['low'], '3', $mainticket->Get('priority'), true, true);
		$subject = $mainticket->Get('subject');
		$ticket_replies_count = $db->num_rows($andere) + 1;

		// don't forget the main-ticket!

		eval("echo \"" . getTemplate("ticket/tickets_view") . "\";");
	}
	elseif($action == 'delete'
	       && $id != 0)
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			$log->logAction(ADM_ACTION, LOG_INFO, "deleted archived ticket '" . $mainticket->Get('subject') . "'");
			$mainticket->Delete();
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$mainticket = ticket::getInstanceOf($userinfo, $db, $settings, (int)$id);
			ask_yesno('ticket_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $mainticket->Get('subject'));
		}
	}
}

?>
