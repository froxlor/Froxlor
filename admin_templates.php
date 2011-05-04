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
 * @author     Florian Lippert <flo@syscp.org> (2003-2009)
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    Panel
 *
 */

define('AREA', 'admin');

/**
 * Include our init.php, which manages Sessions, Language etc.
 */

require ("./lib/init.php");

if(isset($_POST['subjectid']))
{
	$subjectid = intval($_POST['subjectid']);
	$mailbodyid = intval($_POST['mailbodyid']);
}
elseif(isset($_GET['subjectid']))
{
	$subjectid = intval($_GET['subjectid']);
	$mailbodyid = intval($_GET['mailbodyid']);
}

if(isset($_POST['id']))
{
	$id = intval($_POST['id']);
}
elseif(isset($_GET['id']))
{
	$id = intval($_GET['id']);
}

$available_templates = array(
	'createcustomer',
	'pop_success',
	'trafficmaxpercent',
	'diskmaxpercent',
	'new_ticket_by_customer',
	'new_ticket_for_customer',
	'new_ticket_by_staff',
	'new_reply_ticket_by_customer',
	'new_reply_ticket_by_staff',
	'new_database_by_customer',
	'new_ftpaccount_by_customer',
	'password_reset'
);
$file_templates = array(
	'index_html'
);

if($action == '')
{
	//email templates

	$log->logAction(ADM_ACTION, LOG_NOTICE, "viewed admin_templates");

	if($settings['panel']['sendalternativemail'] == 1)
	{
		$available_templates[] = 'pop_success_alternative';
	}

	$templates_array = array();
	$result = $db->query("SELECT `id`, `language`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `templategroup`='mails' ORDER BY `language`, `varname`");

	while($row = $db->fetch_array($result))
	{
		$parts = array();
		preg_match('/^([a-z]([a-z_]+[a-z])*)_(mailbody|subject)$/', $row['varname'], $parts);
		$templates_array[$row['language']][$parts[1]][$parts[3]] = $row['id'];
	}

	$templates = '';
	foreach($templates_array as $language => $template_defs)
	{
		foreach($template_defs as $action => $email)
		{
			$subjectid = $email['subject'];
			$mailbodyid = $email['mailbody'];
			$template = $lng['admin']['templates'][$action];
			eval("\$templates.=\"" . getTemplate("templates/templates_template") . "\";");
		}
	}

	$add = false;

	while(list($language_file, $language_name) = each($languages))
	{
		$templates_done = array();
		$result = $db->query('SELECT `varname` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($language_name) . '\' AND `templategroup`=\'mails\' AND `varname` LIKE \'%_subject\'');

		while(($row = $db->fetch_array($result)) != false)
		{
			$templates_done[] = str_replace('_subject', '', $row['varname']);
		}

		if(count(array_diff($available_templates, $templates_done)) > 0)
		{
			$add = true;
		}
	}

	//filetemplates

	$filetemplates = '';
	$filetemplateadd = false;
	$result = $db->query("SELECT `id`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `templategroup`='files'");

	if($db->num_rows($result) != count($file_templates))$filetemplateadd = true;

	while($row = $db->fetch_array($result))
	{
		eval("\$filetemplates.=\"" . getTemplate("templates/templates_filetemplate") . "\";");
	}

	eval("echo \"" . getTemplate("templates/templates") . "\";");
}
elseif($action == 'delete'
       && $subjectid != 0
       && $mailbodyid != 0)
{
	//email templates

	$result = $db->query_first("SELECT `language`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$subjectid . "'");

	if($result['varname'] != '')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$db->query("DELETE FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND (`id`='" . (int)$subjectid . "' OR `id`='" . (int)$mailbodyid . "')");
			$log->logAction(ADM_ACTION, LOG_INFO, "deleted template '" . $result['language'] . ' - ' . $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])] . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			ask_yesno('admin_template_reallydelete', $filename, array('subjectid' => $subjectid, 'mailbodyid' => $mailbodyid, 'page' => $page, 'action' => $action), $result['language'] . ' - ' . $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])]);
		}
	}
}
elseif($action == 'deletef'
       && $id != 0)
{
	//file templates

	$result = $db->query("SELECT * FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$id . "'");

	if($db->num_rows($result) > 0)
	{
		$row = $db->fetch_array($result);

		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$db->query("DELETE FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`=" . (int)$userinfo['adminid'] . " AND `id`=" . (int)$id . "");
			$log->logAction(ADM_ACTION, LOG_INFO, "deleted template '" . $lng['admin']['templates'][$row['varname']] . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			ask_yesno('admin_template_reallydelete', $filename, array('id' => $id, 'page' => $page, 'action' => $action), $lng['admin']['templates'][$row['varname']]);
		}
	}
	else
	{
		standard_error('templatenotfound');
		exit;
	}
}
elseif($action == 'add')
{
	if($settings['panel']['sendalternativemail'] == 1)
	{
		$available_templates[] = 'pop_success_alternative';
	}

	if(isset($_POST['prepare'])
	   && $_POST['prepare'] == 'prepare')
	{
		//email templates

		$language = validate($_POST['language'], 'language');
		$templates = array();
		$result = $db->query('SELECT `varname` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($language) . '\' AND `templategroup`=\'mails\' AND `varname` LIKE \'%_subject\'');

		while(($row = $db->fetch_array($result)) != false)
		{
			$templates[] = str_replace('_subject', '', $row['varname']);
		}

		$templates = array_diff($available_templates, $templates);
		$template_options = '';
		foreach($templates as $template)
		{
			$template_options.= makeoption($lng['admin']['templates'][$template], $template, NULL, true);
		}

		$template_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/templates/formfield.template_add.php';
		$template_add_form = htmlform::genHTMLForm($template_add_data);

		$title = $template_add_data['template_add']['title'];
		$image = $template_add_data['template_add']['image'];

		eval("echo \"" . getTemplate("templates/templates_add_2") . "\";");
	}
	elseif(isset($_POST['send'])
	       && $_POST['send'] == 'send')
	{
		//email templates

		$language = validate($_POST['language'], 'language', '/^[^\r\n\0"\']+$/', 'nolanguageselect');
		$template = validate($_POST['template'], 'template');
		$subject = validate($_POST['subject'], 'subject', '/^[^\r\n\0]+$/', 'nosubjectcreate');
		$mailbody = validate($_POST['mailbody'], 'mailbody', '/^[^\0]+$/', 'nomailbodycreate');
		$templates = array();
		$result = $db->query('SELECT `varname` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($language) . '\' AND `templategroup`=\'mails\' AND `varname` LIKE \'%_subject\'');

		while(($row = $db->fetch_array($result)) != false)
		{
			$templates[] = str_replace('_subject', '', $row['varname']);
		}

		$templates = array_diff($available_templates, $templates);

		if(array_search($template, $templates) === false)
		{
			standard_error('templatenotfound');
		}
		else
		{
			$result = $db->query("INSERT INTO `" . TABLE_PANEL_TEMPLATES . "` (`adminid`, `language`, `templategroup`, `varname`, `value`)
									VALUES ('" . (int)$userinfo['adminid'] . "', '" . $db->escape($language) . "', 'mails', '" . $db->escape($template) . "_subject','" . $db->escape($subject) . "')");
			$result = $db->query("INSERT INTO `" . TABLE_PANEL_TEMPLATES . "` (`adminid`, `language`, `templategroup`, `varname`, `value`)
									VALUES ('" . (int)$userinfo['adminid'] . "', '" . $db->escape($language) . "', 'mails', '" . $db->escape($template) . "_mailbody','" . $db->escape($mailbody) . "')");
			$log->logAction(ADM_ACTION, LOG_INFO, "added template '" . $language . ' - ' . $template . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
	}
	elseif(isset($_POST['filesend'])
	       && $_POST['filesend'] == 'filesend')
	{
		//file templates

		$template = validate($_POST['template'], 'template');
		$filecontent = validate($_POST['filecontent'], 'filecontent', '/^[^\0]+$/', 'filecontentnotset');
		$db->query("INSERT INTO `" . TABLE_PANEL_TEMPLATES . "` (`adminid`, `language`, `templategroup`, `varname`, `value`)
					VALUES ('" . (int)$userinfo['adminid'] . "', '', 'files', '" . $db->escape($template) . "','" . $db->escape($filecontent) . "')");
		$log->logAction(ADM_ACTION, LOG_INFO, "added template '" . $template . "'");
		redirectTo($filename, Array('page' => $page, 's' => $s));
	}
	elseif(!isset($_GET['files']))
	{
		//email templates

		$add = false;
		$language_options = '';

		while(list($language_file, $language_name) = each($languages))
		{
			$templates = array();
			$result = $db->query('SELECT `varname` FROM `' . TABLE_PANEL_TEMPLATES . '` WHERE `adminid`=\'' . (int)$userinfo['adminid'] . '\' AND `language`=\'' . $db->escape($language_name) . '\' AND `templategroup`=\'mails\' AND `varname` LIKE \'%_subject\'');

			while(($row = $db->fetch_array($result)) != false)
			{
				$templates[] = str_replace('_subject', '', $row['varname']);
			}

			if(count(array_diff($available_templates, $templates)) > 0)
			{
				$add = true;
				$language_options.= makeoption($language_name, $language_file, $userinfo['language'], true);
			}
		}

		if($add)
		{
			eval("echo \"" . getTemplate("templates/templates_add_1") . "\";");
		}
		else
		{
			standard_error('alltemplatesdefined');
			exit;
		}
	}
	else
	{
		//filetemplates

		$result = $db->query("SELECT `id`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `templategroup`='files'");

		if($db->num_rows($result) == count($file_templates))
		{
			standard_error('alltemplatesdefined');
			exit;
		}
		else
		{
			$templatesdefined = array();
			$free_templates = '';

			while($row = $db->fetch_array($result))$templatesdefined[] = $row['varname'];
			foreach(array_diff($file_templates, $templatesdefined) as $template)
			{
				$free_templates.= makeoption($lng['admin']['templates'][$template], $template, '', true);
			}

			$filetemplate_add_data = include_once dirname(__FILE__).'/lib/formfields/admin/templates/formfield.filetemplate_add.php';
			$filetemplate_add_form = htmlform::genHTMLForm($filetemplate_add_data);

			$title = $filetemplate_add_data['filetemplate_add']['title'];
			$image = $filetemplate_add_data['filetemplate_add']['image'];

			eval("echo \"" . getTemplate("templates/filetemplates_add") . "\";");
		}
	}
}
elseif($action == 'edit'
       && $subjectid != 0
       && $mailbodyid != 0)
{
	//email templates

	$result = $db->query_first("SELECT `language`, `varname`, `value` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$subjectid . "'");

	if($result['varname'] != '')
	{
		if(isset($_POST['send'])
		   && $_POST['send'] == 'send')
		{
			$subject = validate($_POST['subject'], 'subject', '/^[^\r\n\0]+$/', 'nosubjectcreate');
			$mailbody = validate($_POST['mailbody'], 'mailbody', '/^[^\0]+$/', 'nomailbodycreate');
			$db->query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `value`='" . $db->escape($subject) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$subjectid . "'");
			$db->query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `value`='" . $db->escape($mailbody) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$mailbodyid . "'");
			$log->logAction(ADM_ACTION, LOG_INFO, "edited template '" . $result['varname'] . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$result = htmlentities_array($result);
			$template = $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])];
			$subject = $result['value'];
			$result = $db->query_first("SELECT `language`, `varname`, `value` FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `id`='$mailbodyid'");
			$result = htmlentities_array($result);
			$mailbody = $result['value'];

			$template_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/templates/formfield.template_edit.php';
			$template_edit_form = htmlform::genHTMLForm($template_edit_data);

			$title = $template_edit_data['template_edit']['title'];
			$image = $template_edit_data['template_edit']['image'];

			eval("echo \"" . getTemplate("templates/templates_edit") . "\";");
		}
	}
}
elseif($action == 'editf'
       && $id != 0)
{
	//file templates

	$result = $db->query("SELECT * FROM `" . TABLE_PANEL_TEMPLATES . "` WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$id . "'");

	if($db->num_rows($result) > 0)
	{
		$row = $db->fetch_array($result);

		//filetemplates

		if(isset($_POST['filesend'])
		   && $_POST['filesend'] == 'filesend')
		{
			$filecontent = validate($_POST['filecontent'], 'filecontent', '/^[^\0]+$/', 'filecontentnotset');
			$db->query("UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET `value`='" . $db->escape($filecontent) . "' WHERE `adminid`='" . (int)$userinfo['adminid'] . "' AND `id`='" . (int)$id . "'");
			$log->logAction(ADM_ACTION, LOG_INFO, "edited template '" . $row['varname'] . "'");
			redirectTo($filename, Array('page' => $page, 's' => $s));
		}
		else
		{
			$row = htmlentities_array($row);

			$filetemplate_edit_data = include_once dirname(__FILE__).'/lib/formfields/admin/templates/formfield.filetemplate_edit.php';
			$filetemplate_edit_form = htmlform::genHTMLForm($filetemplate_edit_data);

			$title = $filetemplate_edit_data['filetemplate_edit']['title'];
			$image = $filetemplate_edit_data['filetemplate_edit']['image'];

			eval("echo \"" . getTemplate("templates/filetemplates_edit") . "\";");
		}
	}
	else
	{
		standard_error('templatenotfound');
		exit;
	}
}
