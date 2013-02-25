<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Michael Kaufmann <mkaufmann@nutime.de>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Logger
 *
 * @link       http://www.nutime.de/
 *
 * Support Tickets - Tickets-Class
 */

class ticket
{
	/**
	 * Userinfo
	 * @var array
	 */

	private $userinfo = array();

	/**
	 * Database handler
	 * @var db
	 */

	private $db = false;

	/**
	 * Settings array
	 * @var settings
	 */

	private $settings = array();

	/**
	 * Ticket ID
	 * @var tid
	 */

	private $tid = - 1;

	/**
	 * Ticket Data Array
	 * @var t_data
	 */

	private $t_data = array();

	/**
	 * Ticket-Object-Array
	 * @var tickets
	 */

	static private $tickets = array();

	/**
	 * HTML purifier
	 * @var purifier
	 */
	private $purifier = null;

	/**
	 * Class constructor.
	 *
	 * @param array userinfo
	 * @param resource database
	 * @param array settings
	 * @param int ticket id
	 */

	private function __construct($userinfo, $db, $settings, $tid = - 1)
	{
		$this->userinfo = $userinfo;
		$this->db = $db;
		$this->settings = $settings;
		$this->tid = $tid;

		// initialize purifier
		require_once dirname(dirname(__FILE__)).'/htmlpurifier/library/HTMLPurifier.auto.php';
		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'UTF-8'); //htmlpurifier uses utf-8 anyway as default
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
		$this->_purifier = new HTMLPurifier($config);

		// initialize data array

		$this->initData();

		// read data from database

		$this->readData();
	}

	/**
	 * Singleton ftw ;-)
	 *
	 * @param int ticket id
	 */

	static public function getInstanceOf($_usernfo, $_db, $_settings, $_tid)
	{
		if(!isset(self::$tickets[$_tid]))
		{
			self::$tickets[$_tid] = new ticket($_usernfo, $_db, $_settings, $_tid);
		}

		return self::$tickets[$_tid];
	}

	/**
	 * Initialize data-array
	 */

	private function initData()
	{
		$this->Set('customer', 0, true, true);
		$this->Set('admin', 1, true, true);
		$this->Set('subject', '', true, true);
		$this->Set('category', '0', true, true);
		$this->Set('priority', '2', true, true);
		$this->Set('message', '', true, true);
		$this->Set('dt', 0, true, true);
		$this->Set('lastchange', 0, true, true);
		$this->Set('ip', '', true, true);
		$this->Set('status', '0', true, true);
		$this->Set('lastreplier', '0', true, true);
		$this->Set('by', '0', true, true);
		$this->Set('answerto', '0', true, true);
		$this->Set('archived', '0', true, true);
	}

	/**
	 * Read ticket data from database.
	 */

	private function readData()
	{
		if(isset($this->tid)
		&& $this->tid != - 1)
		{
			$_ticket = $this->db->query_first('SELECT * FROM `' . TABLE_PANEL_TICKETS . '` WHERE `id` = "' . $this->tid . '"');
			$this->Set('customer', $_ticket['customerid'], true, false);
			$this->Set('admin', $_ticket['adminid'], true, false);
			$this->Set('subject', $_ticket['subject'], true, false);
			$this->Set('category', $_ticket['category'], true, false);
			$this->Set('priority', $_ticket['priority'], true, false);
			$this->Set('message', $_ticket['message'], true, false);
			$this->Set('dt', $_ticket['dt'], true, false);
			$this->Set('lastchange', $_ticket['lastchange'], true, false);
			$this->Set('ip', $_ticket['ip'], true, false);
			$this->Set('status', $_ticket['status'], true, false);
			$this->Set('lastreplier', $_ticket['lastreplier'], true, false);
			$this->Set('by', $_ticket['by'], true, false);
			$this->Set('answerto', $_ticket['answerto'], true, false);
			$this->Set('archived', $_ticket['archived'], true, false);
		}
	}

	/**
	 * Insert data to database
	 */

	public function Insert()
	{
		$this->db->query("INSERT INTO `" . TABLE_PANEL_TICKETS . "`
                (`customerid`,  
                 `adminid`,
                 `category`, 
                 `priority`, 
                 `subject`, 
                 `message`, 
                 `dt`, 
                 `lastchange`, 
                 `ip`, 
                 `status`, 
                 `lastreplier`, 
                 `by`,
                 `answerto`) 
                  VALUES 
                  ('" . (int)$this->Get('customer') . "', 
                   '" . (int)$this->Get('admin') . "',
                   '" . (int)$this->Get('category') . "', 
                   '" . (int)$this->Get('priority') . "', 
                   '" . $this->db->escape($this->Get('subject')) . "', 
                   '" . $this->db->escape($this->Get('message')) . "', 
                   '" . (int)$this->Get('dt') . "', 
                   '" . (int)$this->Get('lastchange') . "', 
                   '" . $this->db->escape($this->Get('ip')) . "', 
                   '" . (int)$this->Get('status') . "',
                   '" . (int)$this->Get('lastreplier') . "',
                   '" . (int)$this->Get('by') . "',
                   '" . (int)$this->Get('answerto') . "');");
		$this->tid = $this->db->insert_id();
		return true;
	}

	/**
	 * Update data in database
	 */

	public function Update()
	{
		// Update "main" ticket

		$this->db->query('UPDATE `' . TABLE_PANEL_TICKETS . '` SET
                `priority` = "' . (int)$this->Get('priority') . '",  
                `lastchange` = "' . (int)$this->Get('lastchange') . '", 
                `status` = "' . (int)$this->Get('status') . '", 
                `lastreplier` = "' . (int)$this->Get('lastreplier') . '"
                WHERE `id` = "' . (int)$this->tid . '";');
		return true;
	}

	/**
	 * Moves a ticket to the archive
	 */

	public function Archive()
	{
		// Update "main" ticket

		$this->db->query('UPDATE `' . TABLE_PANEL_TICKETS . '` SET `archived` = "1" WHERE `id` = "' . (int)$this->tid . '";');

		// Update "answers" to ticket

		$this->db->query('UPDATE `' . TABLE_PANEL_TICKETS . '` SET `archived` = "1" WHERE `answerto` = "' . (int)$this->tid . '";');
		return true;
	}

	/**
	 * Remove ticket from database
	 */

	public function Delete()
	{
		// Delete "main" ticket

		$this->db->query('DELETE FROM `' . TABLE_PANEL_TICKETS . '` WHERE `id` = "' . (int)$this->tid . '";');

		// Delete "answers" to ticket"

		$this->db->query('DELETE FROM `' . TABLE_PANEL_TICKETS . '` WHERE `answerto` = "' . (int)$this->tid . '";');
		return true;
	}

	/**
	 * Mail notifications
	 */

	public function sendMail($customerid = - 1, $template_subject = null, $default_subject = null, $template_body = null, $default_body = null)
	{
		global $mail, $theme;

		// Some checks are to be made here in the future

		if($customerid != - 1)
		{
			// Get e-mail message for customer

			$usr = $this->db->query_first('SELECT `name`, `firstname`, `company`, `email`
                               FROM `' . TABLE_PANEL_CUSTOMERS . '` 
                               WHERE `customerid` = "' . (int)$customerid . '"');
			$replace_arr = array(
				'FIRSTNAME' => $usr['firstname'],
				'NAME' => $usr['name'],
				'COMPANY' => $usr['company'],
				'SALUTATION' => getCorrectUserSalutation($usr),
				'SUBJECT' => $this->Get('subject', true)
			);
		}
		else
		{
			$replace_arr = array(
				'SUBJECT' => $this->Get('subject', true)
			);
		}

		$result = $this->db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
                                WHERE `adminid`=\'' . (int)$this->userinfo['adminid'] . '\' 
                                AND `language`=\'' . $this->db->escape($this->userinfo['def_language']) . '\' 
                                AND `templategroup`=\'mails\' 
                                AND `varname`=\'' . $template_subject . '\'');
		$mail_subject = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $default_subject), $replace_arr));
		$result = $this->db->query_first('SELECT `value` FROM `' . TABLE_PANEL_TEMPLATES . '`
                                WHERE `adminid`=\'' . (int)$this->userinfo['adminid'] . '\' 
                                AND `language`=\'' . $this->db->escape($this->userinfo['def_language']) . '\' 
                                AND `templategroup`=\'mails\' 
                                AND `varname`=\'' . $template_body . '\'');
		$mail_body = html_entity_decode(replace_variables((($result['value'] != '') ? $result['value'] : $default_body), $replace_arr));

		if($customerid != - 1)
		{
			$_mailerror = false;
			try {
				$mail->SetFrom($this->settings['ticket']['noreply_email'], $this->settings['ticket']['noreply_name']);
				$mail->Subject = $mail_subject;
				$mail->AltBody = $mail_body;
				$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
				$mail->AddAddress($usr['email'], $usr['firstname'] . ' ' . $usr['name']);
				$mail->Send();
			} catch(phpmailerException $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'ticket_class'), $this->db, $this->settings);
				$rstlog->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
				standard_error('errorsendingmail', $usr['email']);
			}

			$mail->ClearAddresses();
		}
		else
		{
			$admin = $this->db->query_first("SELECT `name`, `email` FROM `" . TABLE_PANEL_ADMINS . "` WHERE `adminid`='" . (int)$this->userinfo['adminid'] . "'");

			$_mailerror = false;
			try {
				$mail->SetFrom($this->settings['ticket']['noreply_email'], $this->settings['ticket']['noreply_name']);
				$mail->Subject = $mail_subject;
				$mail->AltBody = $mail_body;
				$mail->MsgHTML(str_replace("\n", "<br />", $mail_body));
				$mail->AddAddress($admin['email'], $admin['name']);
				$mail->Send();
			} catch(phpmailerException $e) {
				$mailerr_msg = $e->errorMessage();
				$_mailerror = true;
			} catch (Exception $e) {
				$mailerr_msg = $e->getMessage();
				$_mailerror = true;
			}

			if ($_mailerror) {
				$rstlog = FroxlorLogger::getInstanceOf(array('loginname' => 'ticket_class'), $this->db, $this->settings);
				$rstlog->logAction(ADM_ACTION, LOG_ERR, "Error sending mail: " . $mailerr_msg);
				standard_error('errorsendingmail', $admin['email']);
			}

			$mail->ClearAddresses();
		}
	}

	/**
	 * Add a support-categories
	 */

	static public function addCategory($_db, $_category = null, $_admin = 1, $_order = 1)
	{
		if($_category != null
		&& $_category != '')
		{
			if($_order < 1) {
				$_order = 1;
			}

			$_db->query('INSERT INTO `' . TABLE_PANEL_TICKET_CATS . '` SET
						`name` = "' . $_db->escape($_category) . '", 
						`adminid` = "' . (int)$_admin . '", 
						`logicalorder` = "' . (int)$_order . '"');
			return true;
		}

		return false;
	}

	/**
	 * Edit a support-categories
	 */

	static public function editCategory($_db, $_category = null, $_id = 0, $_order = 1)
	{
		if($_category != null
		&& $_category != ''
		&& $_id != 0)
		{
			if($_order < 1) {
				$_order = 1;
			}

			$_db->query('UPDATE `' . TABLE_PANEL_TICKET_CATS . '` SET
					`name` = "' . $_db->escape($_category) . '",
					`logicalorder` = "' . (int)$_order . '"
                   WHERE `id` = "' . (int)$_id . '"');
			return true;
		}

		return false;
	}

	/**
	 * Delete a support-categories
	 */

	static public function deleteCategory($_db, $_id = 0)
	{
		if($_id != 0)
		{
			$result = $_db->query_first('SELECT COUNT(`id`) as `numtickets` FROM `' . TABLE_PANEL_TICKETS . '`
                                   WHERE `category` = "' . (int)$_id . '"');

			if($result['numtickets'] == "0")
			{
				$_db->query('DELETE FROM `' . TABLE_PANEL_TICKET_CATS . '` WHERE `id` = "' . (int)$_id . '"');
				return true;
			}
			else
			{
				return false;
			}
		}

		return false;
	}

	/**
	 * Return a support-category-name
	 */

	static public function getCategoryName($_db, $_id = 0)
	{
		if($_id != 0)
		{
			$category = $_db->query_first('SELECT `name` FROM `' . TABLE_PANEL_TICKET_CATS . '` WHERE `id` = "' . (int)$_id . '"');
			return $category['name'];
		}

		return null;
	}

	/**
	 * get the highest order number
	 * 
	 * @param object $_db database-object
	 * 
	 * @return int highest order number
	 */
	static public function getHighestOrderNumber($_db = null, $_uid = 0)
	{
		$where = '';
		if ($_uid > 0) {
			$where = ' WHERE `adminid` = "'.(int)$_uid.'"';
		}
		$sql = "SELECT MAX(`logicalorder`) as `highestorder` FROM `" . TABLE_PANEL_TICKET_CATS . "`".$where.";";
		$result = $_db->query_first($sql);
		return (isset($result['highestorder']) ? (int)$result['highestorder'] : 0);
	}

	/**
	 * returns the last x archived tickets
	 */

	static public function getLastArchived($_db, $_num = 10, $_admin = 1)
	{
		if($_num > 0)
		{
			$archived = array();
			$counter = 0;
			$result = $_db->query('SELECT *,
                              (SELECT COUNT(`sub`.`id`) 
                                FROM `' . TABLE_PANEL_TICKETS . '` `sub` 
                                WHERE `sub`.`answerto` = `main`.`id`) as `ticket_answers`  
                             FROM `' . TABLE_PANEL_TICKETS . '` `main` 
                             WHERE `main`.`answerto` = "0" 
                             AND `main`.`archived` = "1" AND `main`.`adminid` = "' . (int)$_admin . '" 
                             ORDER BY `main`.`lastchange` DESC LIMIT 0, ' . (int)$_num);

			while($row = $_db->fetch_array($result))
			{
				$archived[$counter]['id'] = $row['id'];
				$archived[$counter]['customerid'] = $row['customerid'];
				$archived[$counter]['adminid'] = $row['adminid'];
				$archived[$counter]['lastreplier'] = $row['lastreplier'];
				$archived[$counter]['ticket_answers'] = $row['ticket_answers'];
				$archived[$counter]['category'] = $row['category'];
				$archived[$counter]['priority'] = $row['priority'];
				$archived[$counter]['subject'] = $row['subject'];
				$archived[$counter]['message'] = $row['message'];
				$archived[$counter]['dt'] = $row['dt'];
				$archived[$counter]['lastchange'] = $row['lastchange'];
				$archived[$counter]['status'] = $row['status'];
				$archived[$counter]['by'] = $row['by'];
				$counter++;
			}

			if(isset($archived[0]['id']))
			{
				return $archived;
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 * Returns a sql-statement to search the archive
	 */

	static public function getArchiveSearchStatement($db, $subject = NULL, $priority = NULL, $fromdate = NULL, $todate = NULL, $message = NULL, $customer = - 1, $admin = 1, $categories = NULL)
	{
		$query = 'SELECT `main`.*,
                (SELECT COUNT(`sub`.`id`) FROM `' . TABLE_PANEL_TICKETS . '` `sub` 
                 WHERE `sub`.`answerto` = `main`.`id`) as `ticket_answers` 
              FROM `' . TABLE_PANEL_TICKETS . '` `main` 
              WHERE `main`.`archived` = "1" AND `main`.`adminid` = "' . (int)$admin . '" ';

		if($subject != NULL
		&& $subject != '')
		{
			$query.= 'AND `main`.`subject` LIKE "' . $db->escape("%$subject%") . '" ';
		}

		if($priority != NULL
		&& isset($priority[0])
		&& $priority[0] != '')
		{
			if(isset($priority[1])
			&& $priority[1] != '')
			{
				if(isset($priority[2])
				&& $priority[2] != '')
				{
					$query.= 'AND (`main`.`priority` = "1"
                     OR `main`.`priority` = "2" 
                     OR `main`.`priority` = "3") ';
				}
				else
				{
					$query.= 'AND (`main`.`priority` = "1"
                     OR `main`.`priority` = "2") ';
				}
			}
			elseif(isset($priority[2])
			&& $priority[2] != '')
			{
				$query.= 'AND (`main`.`priority` = "1"
                     OR `main`.`priority` = "3") ';
			}
			else
			{
				$query.= 'AND `main`.`priority` = "1" ';
			}
		}
		elseif($priority != NULL
		&& isset($priority[1])
		&& $priority[1] != '')
		{
			if(isset($priority[2])
			&& $priority[2] != '')
			{
				$query.= 'AND (`main`.`priority` = "2" OR `main`.`priority` = "3") ';
			}
			else
			{
				$query.= 'AND `main`.`priority` = "2" ';
			}
		}
		elseif($priority != NULL)
		{
			if(isset($priority[3])
			&& $priority[3] != '')
			{
				$query.= 'AND `main`.`priority` = "3" ';
			}
		}

		if($fromdate != NULL
		&& $fromdate > 0)
		{
			$query.= 'AND `main`.`lastchange` > "' . $db->escape(strtotime($fromdate)) . '" ';
		}

		if($todate != NULL
		&& $todate > 0)
		{
			$query.= 'AND `main`.`lastchange` < "' . $db->escape(strtotime($todate)) . '" ';
		}

		if($message != NULL
		&& $message != '')
		{
			$query.= 'AND `main`.`message` LIKE "' . $db->escape("%$message%") . '" ';
		}

		if($customer != - 1)
		{
			$query.= 'AND `main`.`customerid` = "' . (int)$customer . '" ';
		}

		if($categories != NULL)
		{
			$cats = array();
			foreach($categories as $index => $catid)
			{
				if ($catid != "")
				{
					$cats[] = $catid;
				}
			}

			if (count($cats) > 0)
			{
				$query.= 'AND (';
			}

			foreach($cats as $catid)
			{
				if(isset($catid)
				&& $catid > 0)
				{
					$query.= '`main`.`category` = "' . (int)$catid . '" OR ';
				}
			}

			if (count($cats) > 0)
			{
				$query = substr($query, 0, strlen($query) - 3);
				$query.= ') ';
			}
		}

		return $query;
	}

	/**
	 * Get statustext by status-no
	 */

	static public function getStatusText($_lng, $_status = 0)
	{
		switch($_status)
		{
			case 0:
				return $_lng['ticket']['open'];
				break;
			case 1:
				return $_lng['ticket']['wait_reply'];
				break;
			case 2:
				return $_lng['ticket']['replied'];
				break;
			default:
				return $_lng['ticket']['closed'];
				break;
		}
	}

	/**
	 * Get prioritytext by priority-no
	 */

	static public function getPriorityText($_lng, $_priority = 0)
	{
		switch($_priority)
		{
			case 1:
				return $_lng['ticket']['high'];
				break;
			case 2:
				return $_lng['ticket']['normal'];
				break;
			default:
				return $_lng['ticket']['low'];
				break;
		}
	}

	private function convertLatin1ToHtml($str)
	{
		$html_entities = array (
					"Ä" =>  "&Auml;",
					"ä" =>  "&auml;",
					"Ö" =>  "&Ouml;",
					"ö" =>  "&ouml;",
					"Ü" =>  "&Uuml;",
					"ü" =>  "&uuml;",
					"ß" =>  "&szlig;"
					/*
					 * @TODO continue this table for all the special-characters
					 */
		);

		foreach ($html_entities as $key => $value) {
			$str = str_replace($key, $value, $str);
		}
		return $str;
	}

	/*
	 * function customerHasTickets
	 *
	 * @param	object	mysql-db-object
	 * @param	int		customer-id
	 *
	 * @return	array/bool	array of ticket-ids if customer has any, else false
	 */
	static public function customerHasTickets($_db = null, $_cid = 0)
	{
		if($_cid != 0)
		{
			$result = $_db->query('SELECT `id` FROM `' . TABLE_PANEL_TICKETS . '` WHERE `customerid` ="'.(int)$_cid.'"');

			$tickets = array();
			while($row = $_db->fetch_array($result))
			{
				$tickets[] = $row['id'];
			}

			return $tickets;
		}

		return false;
	}

	/**
	 * Get a data-var
	 */

	public function Get($_var = '', $_vartrusted = false)
	{
		if($_var != '')
		{
			if(!$_vartrusted)
			{
				$_var = htmlspecialchars($_var);
			}

			if(isset($this->t_data[$_var]))
			{
				if(strtolower($_var) == 'message')
				{
					return nl2br($this->t_data[$_var]);
				}
				elseif(strtolower($_var) == 'subject')
				{
					return nl2br($this->t_data[$_var]);
				}
				else
				{
					return $this->t_data[$_var];
				}
			}
			else
			{
				return null;
			}
		}
	}

	/**
	 * Set a data-var
	 */

	public function Set($_var = '', $_value = '', $_vartrusted = false, $_valuetrusted = false)
	{
		if($_var != ''
		&& $_value != '')
		{
			if(!$_vartrusted)
			{
				$_var = $this->_purifier->purify($_var);
			}

			if(!$_valuetrusted)
			{
				$_value = $this->_purifier->purify($_value);
			}

			if(strtolower($_var) == 'message' || strtolower($_var) == 'subject')
			{
				$_value = $this->convertLatin1ToHtml($_value);
			}

			$this->t_data[$_var] = $_value;
		}
	}
}

?>
