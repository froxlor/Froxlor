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
 *
 * @since 0.9.34
 */

const AREA = 'admin';
require __DIR__ . '/lib/init.php';

use Froxlor\Settings;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

if ($userinfo['change_serversettings'] == '1') {

	if ($action == 'setconfigured') {
		Settings::Set('panel.is_configured', '1', true);
		\Froxlor\UI\Response::redirectTo('admin_configfiles.php');
	}

	// get distro from URL param
	$distribution = Request::get('distribution');

	$distributions_select = [];

	$services = [];
	$config_dir = \Froxlor\FileDir::makeCorrectDir(\Froxlor\Froxlor::getInstallDir() . '/lib/configfiles/');

	if (!empty($distribution)) {
		if (!file_exists($config_dir . '/' . $distribution . ".xml")) {
			\Froxlor\UI\Response::dynamic_error("Unknown distribution");
		}

		// create configparser object
		$configfiles = new \Froxlor\Config\ConfigParser($config_dir . '/' . $distribution . ".xml");

		// get distro-info
		$dist_display = getCompleteDistroName($configfiles);

		// get all the services from the distro
		$services = $configfiles->getServices();
	} else {

		// show list of available distro's
		$distros = glob($config_dir . '*.xml');
		// read in all the distros
		foreach ($distros as $_distribution) {
			// get configparser object
			$dist = new \Froxlor\Config\ConfigParser($_distribution);
			// get distro-info
			$dist_display = getCompleteDistroName($dist);
			// store in tmp array
			$distributions_select[str_replace(".xml", "", strtolower(basename($_distribution)))] = $dist_display;
		}

		// sort by distribution name
		asort($distributions_select);
	}

	if ($distribution != "" && isset($_POST['finish'])) {

		unset($_POST['finish']);
		$params = $_POST;
		$params['distro'] = $distribution;
		$params['system'] = [];
		foreach ($_POST['system'] as $sysdaemon) {
			$params['system'][] = $sysdaemon;
		}
		$params_content = json_encode($params);
		$params_filename = \Froxlor\FileDir::makeCorrectFile(\Froxlor\Froxlor::getInstallDir() . 'install/' . \Froxlor\Froxlor::genSessionId() . '.json');
		file_put_contents($params_filename, $params_content);

		UI::twigBuffer('settings/configuration-final.html.twig', [
			'distribution' => $distribution,
			// alert
			'type' => 'info',
			'alert_msg' => $lng['admin']['configfiles']['finishnote'],
			'basedir' => \Froxlor\Froxlor::getInstallDir(),
			'params_filename' => $params_filename
		]);
	} else {

		if (!empty($distribution)) {
			// show available services to configure
			$fields = $services;
			$link_params = ['section' => 'configfiles', 'distribution' => $distribution];
			UI::twigBuffer('settings/configuration.html.twig', [
				'action' => $linker->getLink($link_params),
				'fields' => $fields,
				'distribution' => $distribution
			]);
		} else {
			// @fixme check set distribution from settings

			$cfg_formfield = [
				'config' => [
					'title' => $lng['admin']['configfiles']['serverconfiguration'],
					'image' => 'fa-solid fa-wrench',
					'description' => $lng['admin']['configfiles']['description'],
					'sections' => [
						'section_config' => [
							'fields' => [
								'distribution' => ['type' => 'select', 'select_var' => $distributions_select, 'label' => $lng['admin']['configfiles']['distribution']]
							]
						]
					],
					'buttons' => [
						[
							'class' => 'btn-outline-secondary',
							'label' => $lng['panel']['cancel'],
							'type' => 'reset'
						],
						[
							'label' => $lng['update']['proceed']
						]
					]
				]
			];

			UI::twigBuffer('user/form-note.html.twig', [
				'formaction' => $linker->getLink(array('section' => 'configfiles')),
				'formdata' => $cfg_formfield['config'],
				'actions_links' => (int) Settings::Get('panel.is_configured') == 0 ? [[
					'href' => $linker->getLink(['section' => 'configfiles', 'page' => 'overview', 'action' => 'setconfigured']),
					'label' => $lng['panel']['ihave_configured'],
					'class' => 'btn-outline-warning',
					'icon' => 'fa fa-circle-check'
				]] : [],
				// alert
				'type' => 'warning',
				'alert_msg' => $lng['panel']['settings_before_configuration'] . ((int)Settings::Get('panel.is_configured') == 1 ? '<br><br>' . $lng['panel']['system_is_configured'] : '')
			]);
		}
	}

	UI::twigOutputBuffer();
} else {
	\Froxlor\UI\Response::redirectTo('admin_index.php');
}

function getCompleteDistroName($cparser)
{
	// get distro-info
	$dist_display = $cparser->distributionName;
	if ($cparser->distributionCodename != '') {
		$dist_display .= " " . $cparser->distributionCodename;
	}
	if ($cparser->distributionVersion != '') {
		$dist_display .= " (" . $cparser->distributionVersion . ")";
	}
	if ($cparser->deprecated) {
		$dist_display .= " [deprecated]";
	}
	return $dist_display;
}
