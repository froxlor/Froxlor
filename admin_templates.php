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

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Database\Database;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

$id = (int) Request::get('id');
$subjectid = intval(Request::get('subjectid'));
$mailbodyid = intval(Request::get('mailbodyid'));

$available_templates = array(
	'createcustomer',
	'pop_success',
	'new_database_by_customer',
	'new_ftpaccount_by_customer',
	'password_reset'
);

// only show templates of features that are enabled #1191
if ((int) Settings::Get('system.report_enable') == 1) {
	array_push($available_templates, 'trafficmaxpercent', 'diskmaxpercent');
}
if (Settings::Get('panel.sendalternativemail') == 1) {
	array_push($available_templates, 'pop_success_alternative');
}

$file_templates = array(
	'index_html'
);

if ($action == '') {
	// email templates
	$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_NOTICE, "viewed admin_templates");

	$templates_array = array();
	$result_stmt = Database::prepare("
		SELECT `id`, `language`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `templategroup`='mails'
		ORDER BY `language`, `varname`
	");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid']
	));

	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$parts = array();
		preg_match('/^([a-z]([a-z_]+[a-z])*)_(mailbody|subject)$/', $row['varname'], $parts);
		$templates_array[$row['language']][$parts[1]][$parts[3]] = $row['id'];
	}

	$templates = [];
	foreach ($templates_array as $language => $template_defs) {
		foreach ($template_defs as $action => $email) {
			$templates[] = [
				'subjectid' => $email['subject'],
				'mailbodyid' => $email['mailbody'],
				'template' => $lng['admin']['templates'][$action],
				'language' => $language
			];
		}
	}

	$mail_actions_links = false;
	foreach ($languages as $language_file => $language_name) {

		$templates_done = array();
		$result_stmt = Database::prepare("
			SELECT `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
			WHERE `adminid` = :adminid AND `language`= :lang
			AND `templategroup` = 'mails' AND `varname` LIKE '%_subject'
		");
		Database::pexecute($result_stmt, array(
			'adminid' => $userinfo['adminid'],
			'lang' => $language_name
		));

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$templates_done[] = str_replace('_subject', '', $row['varname']);
		}

		if (count(array_diff($available_templates, $templates_done)) > 0) {
			$mail_actions_links = [[
				'href' => $linker->getLink(['section' => 'templates', 'page' => $page, 'action' => 'add']),
				'label' => $lng['admin']['templates']['template_add']
			]];
		}
	}

	$mailtpl_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.mailtemplates.php';
	$collection_mail = [
		'data' => $templates,
		'pagination' => []
	];

	// filetemplates
	$result_stmt = Database::prepare("
		SELECT `id`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `templategroup`='files'");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid']
	));

	$filetemplates = [];
	while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
		$filetemplates[] = [
			'id' => $row['id'],
			'template' => $lng['admin']['templates'][$row['varname']]
		];
	}

	$file_actions_links = false;
	if (Database::num_rows() != count($file_templates)) {
		$file_actions_links = [[
			'href' => $linker->getLink(['section' => 'templates', 'page' => $page, 'action' => 'add', 'files' => 'files']),
			'label' => $lng['admin']['templates']['template_fileadd']
		]];
	}

	$filetpl_list_data = include_once dirname(__FILE__) . '/lib/tablelisting/admin/tablelisting.filetemplates.php';
	$collection_file = [
		'data' => $filetemplates,
		'pagination' => []
	];

	UI::view('user/table-tpl.html.twig', [
		'maillisting' => \Froxlor\UI\Listing::formatFromArray($collection_mail, $mailtpl_list_data['mailtpl_list']),
		'filelisting' => \Froxlor\UI\Listing::formatFromArray($collection_file, $filetpl_list_data['filetpl_list']),
		'actions_links' => array_merge($mail_actions_links, $file_actions_links)
	]);
} elseif ($action == 'delete' && $subjectid != 0 && $mailbodyid != 0) {
	// email templates
	$result_stmt = Database::prepare("
		SELECT `language`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `id` = :id");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid'],
		'id' => $subjectid
	));
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if ($result['varname'] != '') {
		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `adminid` = :adminid
				AND (`id` = :ida OR `id` = :idb)");
			Database::pexecute($del_stmt, array(
				'adminid' => $userinfo['adminid'],
				'ida' => $subjectid,
				'idb' => $mailbodyid
			));
			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "deleted template '" . $result['language'] . ' - ' . $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])] . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			\Froxlor\UI\HTML::askYesNo('admin_template_reallydelete', $filename, array(
				'subjectid' => $subjectid,
				'mailbodyid' => $mailbodyid,
				'page' => $page,
				'action' => $action
			), $result['language'] . ' - ' . $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])]);
		}
	}
} elseif ($action == 'deletef' && $id != 0) {
	// file templates
	$result_stmt = Database::prepare("
		SELECT * FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `id` = :id");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid'],
		'id' => $id
	));

	if (Database::num_rows() > 0) {

		$row = $result_stmt->fetch(PDO::FETCH_ASSOC);

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$del_stmt = Database::prepare("
				DELETE FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `adminid` = :adminid AND `id` = :id");
			Database::pexecute($del_stmt, array(
				'adminid' => $userinfo['adminid'],
				'id' => $id
			));
			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "deleted template '" . $lng['admin']['templates'][$row['varname']] . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			\Froxlor\UI\HTML::askYesNo('admin_template_reallydelete', $filename, array(
				'id' => $id,
				'page' => $page,
				'action' => $action
			), $lng['admin']['templates'][$row['varname']]);
		}
	} else {
		\Froxlor\UI\Response::standard_error('templatenotfound');
	}
} elseif ($action == 'add') {

	if (isset($_POST['prepare']) && $_POST['prepare'] == 'prepare') {
		// email templates
		$language = htmlentities(\Froxlor\Validate\Validate::validate($_POST['language'], 'language', '/^[^\r\n\0"\']+$/', 'nolanguageselect'));
		$template = \Froxlor\Validate\Validate::validate($_POST['template'], 'template');

		$result_stmt = Database::prepare("
			SELECT COUNT(*) as def FROM `" . TABLE_PANEL_TEMPLATES . "`
			WHERE `adminid` = :adminid AND `language` = :lang
			AND `templategroup` = 'mails' AND `varname` LIKE :template
		");
		$result = Database::pexecute_first($result_stmt, array(
			'adminid' => $userinfo['adminid'],
			'lang' => $language,
			'template' => $template . '%'
		));
		if ($result && $result['def'] > 0) {
			\Froxlor\UI\Response::standard_error('templatelanguagecombodefined');
		}

		$lng_bak = $lng;
		foreach ($langs['English'] as $key => $value) {
			include_once \Froxlor\FileDir::makeSecurePath($value['file']);
		}
		if ($language != 'English') {
			foreach ($langs[$language] as $key => $value) {
				include \Froxlor\FileDir::makeSecurePath($value['file']);
			}
		}

		$subject = $lng['mails'][$template]['subject'];
		$body = str_replace('\n', "\n", $lng['mails'][$template]['mailbody']);

		$lng = $lng_bak;

		$template_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/templates/formfield.template_add.php';

		UI::view('user/form-replacers.html.twig', [
			'formaction' => $linker->getLink(array('section' => 'templates')),
			'formdata' => $template_add_data['template_add'],
			'replacers' => $template_add_data['template_replacers']
		]);
	} elseif (isset($_POST['send']) && $_POST['send'] == 'send' && !isset($_POST['filesend'])) {
		// email templates
		$language = htmlentities(\Froxlor\Validate\Validate::validate($_POST['language'], 'language', '/^[^\r\n\0"\']+$/', 'nolanguageselect'));
		$template = \Froxlor\Validate\Validate::validate($_POST['template'], 'template');
		$subject = \Froxlor\Validate\Validate::validate($_POST['subject'], 'subject', '/^[^\r\n\0]+$/', 'nosubjectcreate');
		$mailbody = \Froxlor\Validate\Validate::validate($_POST['mailbody'], 'mailbody', '/^[^\0]+$/', 'nomailbodycreate');
		$templates = array();
		$result_stmt = Database::prepare("
			SELECT `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
			WHERE `adminid` = :adminid AND `language` = :lang
			AND `templategroup` = 'mails' AND `varname` LIKE '%_subject'");
		Database::pexecute($result_stmt, array(
			'adminid' => $userinfo['adminid'],
			'lang' => $language
		));

		while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
			$templates[] = str_replace('_subject', '', $row['varname']);
		}

		$templates = array_diff($available_templates, $templates);
		if (!in_array($template, $templates)) {
			\Froxlor\UI\Response::standard_error('templatenotfound');
		} else {
			$ins_stmt = Database::prepare("
				INSERT INTO `" . TABLE_PANEL_TEMPLATES . "` SET
					`adminid` = :adminid,
					`language` = :lang,
					`templategroup` = 'mails',
					`varname` = :var,
					`value` = :value");

			// mail-subject
			$ins_data = array(
				'adminid' => $userinfo['adminid'],
				'lang' => $language,
				'var' => $template . '_subject',
				'value' => $subject
			);
			Database::pexecute($ins_stmt, $ins_data);

			// mail-body
			$ins_data = array(
				'adminid' => $userinfo['adminid'],
				'lang' => $language,
				'var' => $template . '_mailbody',
				'value' => $mailbody
			);
			Database::pexecute($ins_stmt, $ins_data);

			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "added template '" . $language . ' - ' . $template . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		}
	} elseif (isset($_POST['filesend']) && $_POST['filesend'] == 'filesend') {
		// file templates
		$template = \Froxlor\Validate\Validate::validate($_POST['template'], 'template');
		$filecontent = \Froxlor\Validate\Validate::validate($_POST['filecontent'], 'filecontent', '/^[^\0]+$/', 'filecontentnotset');

		$ins_stmt = Database::prepare("
			INSERT INTO `" . TABLE_PANEL_TEMPLATES . "` SET
				`adminid` = :adminid,
				`language` = '',
				`templategroup` = 'files',
				`varname` = :var,
				`value` = :value");

		$ins_data = array(
			'adminid' => $userinfo['adminid'],
			'var' => $template,
			'value' => $filecontent
		);
		Database::pexecute($ins_stmt, $ins_data);

		$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "added template '" . $template . "'");
		\Froxlor\UI\Response::redirectTo($filename, array(
			'page' => $page
		));
	} elseif (!isset($_GET['files'])) {

		// email templates
		$add = false;
		$language_options = [];
		$template_options = [];

		foreach ($languages as $language_file => $language_name) {
			$templates = array();
			$result_stmt = Database::prepare("
				SELECT `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `adminid` = :adminid AND `language` = :lang
				AND `templategroup` = 'mails' AND `varname` LIKE '%_subject'");
			Database::pexecute($result_stmt, array(
				'adminid' => $userinfo['adminid'],
				'lang' => $language_name
			));

			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$templates[] = str_replace('_subject', '', $row['varname']);
			}

			if (count(array_diff($available_templates, $templates)) > 0) {
				$add = true;
				$language_options[$language_file] = $language_name;

				$templates = array_diff($available_templates, $templates);

				foreach ($templates as $template) {
					$template_options[$template] = $lng['admin']['templates'][$template];
				}
			}
		}

		if ($add) {
			UI::view('user/form.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'templates')),
				'formdata' => [
					'title' => $lng['admin']['templates']['template_add'],
					'image' => 'fa-solid fa-plus',
					'sections' => [
						'section_a' => [
							'title' => $lng['admin']['templates']['template_add'],
							'fields' => [
								'language' => [
									'label' => $lng['login']['language'],
									'type' => 'select',
									'select_var' => $language_options,
									'selected' => $userinfo['language']
								],
								'template' => [
									'label' => $lng['admin']['templates']['action'],
									'type' => 'select',
									'select_var' => $template_options
								],
								'prepare' => [
									'type' => 'hidden',
									'value' => 'prepare'
								]
							]
						]
					]
				],
				'editid' => $id
			]);
		} else {
			\Froxlor\UI\Response::standard_error('alltemplatesdefined');
		}
	} else {
		// filetemplates
		$result_stmt = Database::prepare("
			SELECT `id`, `varname` FROM `" . TABLE_PANEL_TEMPLATES . "`
			WHERE `adminid` = :adminid AND `templategroup`='files'");
		Database::pexecute($result_stmt, array(
			'adminid' => $userinfo['adminid']
		));

		if (Database::num_rows() == count($file_templates)) {
			\Froxlor\UI\Response::standard_error('alltemplatesdefined');
		} else {

			$templatesdefined = array();
			$free_templates = [];

			while ($row = $result_stmt->fetch(PDO::FETCH_ASSOC)) {
				$templatesdefined[] = $row['varname'];
			}

			foreach (array_diff($file_templates, $templatesdefined) as $template) {
				$free_templates[$template] = $lng['admin']['templates'][$template];
			}

			$filetemplate_add_data = include_once dirname(__FILE__) . '/lib/formfields/admin/templates/formfield.filetemplate_add.php';

			UI::view('user/form-replacers.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'templates')),
				'formdata' => $filetemplate_add_data['filetemplate_add'],
				'replacers' => $filetemplate_add_data['filetemplate_replacers']
			]);
		}
	}
} elseif ($action == 'edit' && $subjectid != 0 && $mailbodyid != 0) {
	// email templates
	$result_stmt = Database::prepare("
		SELECT `language`, `varname`, `value` FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `id` = :subjectid");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid'],
		'subjectid' => $subjectid
	));
	$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

	if ($result['varname'] != '') {

		if (isset($_POST['send']) && $_POST['send'] == 'send') {
			$subject = \Froxlor\Validate\Validate::validate($_POST['subject'], 'subject', '/^[^\r\n\0]+$/', 'nosubjectcreate');
			$mailbody = \Froxlor\Validate\Validate::validate($_POST['mailbody'], 'mailbody', '/^[^\0]+$/', 'nomailbodycreate');

			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET
					`value` = :value
				WHERE `adminid` = :adminid AND `id` = :id");
			// subject
			Database::pexecute($upd_stmt, array(
				'value' => $subject,
				'adminid' => $userinfo['adminid'],
				'id' => $subjectid
			));
			// same query but mailbody
			Database::pexecute($upd_stmt, array(
				'value' => $mailbody,
				'adminid' => $userinfo['adminid'],
				'id' => $mailbodyid
			));

			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "edited template '" . $result['varname'] . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {

			$result = \Froxlor\PhpHelper::htmlentitiesArray($result);
			$template_name = $lng['admin']['templates'][str_replace('_subject', '', $result['varname'])];
			$subject = $result['value'];
			$result_stmt = Database::prepare("
				SELECT `language`, `varname`, `value`
				FROM `" . TABLE_PANEL_TEMPLATES . "`
				WHERE `id` = :id");
			Database::pexecute($result_stmt, array(
				'id' => $mailbodyid
			));
			$result = $result_stmt->fetch(PDO::FETCH_ASSOC);

			$template = str_replace('_mailbody', '', $result['varname']);

			// don't escape the already escaped language-string so save up before htmlentities()
			$language = $result['language'];
			$result = \Froxlor\PhpHelper::htmlentitiesArray($result);
			$mailbody = $result['value'];

			$template_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/templates/formfield.template_edit.php';

			UI::view('user/form-replacers.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'templates')),
				'formdata' => $template_edit_data['template_edit'],
				'replacers' => $template_edit_data['template_replacers']
			]);
		}
	}
} elseif ($action == 'editf' && $id != 0) {
	// file templates
	$result_stmt = Database::prepare("
		SELECT * FROM `" . TABLE_PANEL_TEMPLATES . "`
		WHERE `adminid` = :adminid AND `id` = :id");
	Database::pexecute($result_stmt, array(
		'adminid' => $userinfo['adminid'],
		'id' => $id
	));

	if (Database::num_rows() > 0) {

		$row = $result_stmt->fetch(PDO::FETCH_ASSOC);

		// filetemplates
		if (isset($_POST['filesend']) && $_POST['filesend'] == 'filesend') {
			$filecontent = \Froxlor\Validate\Validate::validate($_POST['filecontent'], 'filecontent', '/^[^\0]+$/', 'filecontentnotset');
			$upd_stmt = Database::prepare("
				UPDATE `" . TABLE_PANEL_TEMPLATES . "` SET
					`value` = :value
				WHERE `adminid` = :adminid AND `id` = :id");
			Database::pexecute($upd_stmt, array(
				'value' => $filecontent,
				'adminid' => $userinfo['adminid'],
				'id' => $id
			));

			$log->logAction(\Froxlor\FroxlorLogger::ADM_ACTION, LOG_INFO, "edited template '" . $row['varname'] . "'");
			\Froxlor\UI\Response::redirectTo($filename, array(
				'page' => $page
			));
		} else {
			$row = \Froxlor\PhpHelper::htmlentitiesArray($row);

			$filetemplate_edit_data = include_once dirname(__FILE__) . '/lib/formfields/admin/templates/formfield.filetemplate_edit.php';

			UI::view('user/form-replacers.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'templates')),
				'formdata' => $filetemplate_edit_data['filetemplate_edit'],
				'replacers' => $filetemplate_edit_data['filetemplate_replacers'],
				'editid' => $id
			]);
		}
	} else {
		\Froxlor\UI\Response::standard_error('templatenotfound');
	}
}
