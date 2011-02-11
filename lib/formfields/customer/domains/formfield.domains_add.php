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
 * @package    Formfields
 * @version    $Id: formfield.domains_add.php 112 2010-12-14 12:11:20Z d00p $
 */

return array(
	'domain_add' => array(
		'title' => $lng['domains']['subdomain_add'],
		'image' => 'icons/add_domain.png',
		'sections' => array(
			'section_a' => array(
				'title' => $lng['domains']['subdomain_add'],
				'image' => 'icons/add_domain.png',
				'fields' => array(
					'domain' => array(
						'label' => $lng['domains']['domainname'],
						'type' => 'text'
					),
					'aliasdomain' => array(
						'label' => $lng['domains']['aliasdomain'],
						'type' => 'select',
						'select_var' => $aliasdomains
					),
					'pathedit' => array(
						'visible' => ($settings['panel']['pathedit'] != 'Dropdown' ? true : false),
						'label' => $lng['panel']['pathorurl'],
						'desc' => $lng['panel']['pathDescription'], // TODO was ist mit: $lng['panel']['pathDescriptionEx'] ?
						'type' => 'text',
						'value' => $pathSelect
					),
					'pathedit_dropdown' => array(
						'visible' => ($settings['panel']['pathedit'] == 'Dropdown' ? true : false),
						'label' => $lng['panel']['path'],
						'type' => 'text',
						'value' => $pathSelect
					),
					'pathedit_dropdown2' => array(
						'visible' => ($settings['panel']['pathedit'] == 'Dropdown' ? true : false),
						'label' => $lng['panel']['urloverridespath'],
						'type' => 'text',
						'value' => $urlvalue,
						'size' => 30
					),
					'apache2_customerRedirect' => array(
						'visible' => (($settings['system']['webserver'] == 'apache2' && $settings['customredirect']['enabled'] == '1') ? true : false),
						'label' => $lng['domains']['redirectifpathisurl'],
						'desc' => $lng['domains']['redirectifpathisurlinfo'],
						'type' => 'select',
						'select_var' => $redirectcode
					),
					'ssl' => array(
						'visible' => ($settings['system']['use_ssl'] == '1' ? true : false),
						'label' => 'SSL Redirect',
						'type' => 'text',
						'yesno_var' => $ssl_redirect
					),
					'openbasedir' => array(
						'label' => $lng['domain']['openbasedirpath'],
						'type' => 'select',
						'select_var' => $openbasedir
					)
				)
			)
		)
	)
);
