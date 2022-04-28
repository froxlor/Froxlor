<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2010 the Froxlor Team (see authors).
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, you can also view it online at
 * https://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  the authors
 * @author     Froxlor team <team@froxlor.org>
 * @license    https://files.froxlor.org/misc/COPYING.txt GPLv2
 */

namespace Froxlor\UI\Callbacks;

use Froxlor\Domain\Domain as DDomain;
use Froxlor\FileDir;
use Froxlor\Settings;
use Froxlor\UI\Panel\UI;

class Domain
{
	public static function domainWithCustomerLink(array $attributes)
	{
		$linker = UI::getLinker();
		$result = '<a href="https://' . $attributes['data'] . '" target="_blank">' . $attributes['data'] . '</a>';
		$result .= ' (<a href="' . $linker->getLink([
				'section' => 'customers',
				'page' => 'customers',
				'action' => 'su',
				'sort' => $attributes['fields']['loginname'],
				'id' => $attributes['fields']['customerid'],
			]) . '">' . $attributes['fields']['loginname'] . '</a>)';
		return $result;
	}

	public static function domainTarget(array $attributes)
	{
		if (empty($attributes['fields']['aliasdomain'])) {
			// path or redirect
			if (preg_match('/^https?\:\/\//', $attributes['fields']['documentroot'])) {
				return [
					'macro' => 'link',
					'data' => [
						'text' => $attributes['fields']['documentroot'],
						'href' => $attributes['fields']['documentroot'],
						'target' => '_blank'
					]
				];
			} else {
				// show docroot nicely
				if (strpos($attributes['fields']['documentroot'], UI::getCurrentUser()['documentroot']) === 0) {
					$attributes['fields']['documentroot'] = FileDir::makeCorrectDir(str_replace(UI::getCurrentUser()['documentroot'], "/", $attributes['fields']['documentroot']));
				}
				return $attributes['fields']['documentroot'];
			}
		}
		return UI::getLng('domains.aliasdomain') . ' ' . $attributes['fields']['aliasdomain'];
	}

	public static function domainExternalLinkInfo(array $attributes)
	{
		$result = '<a href="http://' . $attributes['data'] . '" target="_blank">' . $attributes['data'] . '</a>';
		// check for statistics if parentdomainid==0 to show stats-link for customers
		if ((int)UI::getCurrentUser()['adminsession'] == 0 && $attributes['fields']['parentdomainid'] == 0) {
			$statsapp = 'webalizer';
			if (Settings::Get('system.awstats_enabled') == '1') {
				$statsapp = 'awstats';
			}
			$result .= ' <a href="http://' . $attributes['data'] . '/' . $statsapp . '" rel="external" title="' . UI::getLng('domains.statstics') . '"><i class="fa-solid fa-chart-line text-secondary"></i></a>';
		}
		if ($attributes['fields']['registration_date'] != '') {
			$result .= '<br><small>' . UI::getLng('domains.registration_date') . ': ' . $attributes['fields']['registration_date'] . '</small>';
		}
		if ($attributes['fields']['termination_date'] != '') {
			$result .= '<br><small>' . UI::getLng('domains.termination_date_overview') . ': ' . $attributes['fields']['termination_date'] . '</small>';
		}
		return $result;
	}

	public static function canEdit(array $attributes): bool
	{
		return (bool)$attributes['fields']['caneditdomain'];
	}

	public static function canViewLogs(array $attributes): bool
	{
		if ((int)$attributes['fields']['email_only'] == 0) {
			if ((int)UI::getCurrentUser()['adminsession'] == 0 && (bool)UI::getCurrentUser()['logviewenabled']) {
				return true;
			} elseif ((int)UI::getCurrentUser()['adminsession'] == 1) {
				return true;
			}
		}
		return false;
	}

	public static function canDelete(array $attributes): bool
	{
		return $attributes['fields']['parentdomainid'] != '0'
			&& empty($attributes['fields']['domainaliasid']);
	}

	public static function adminCanDelete(array $attributes): bool
	{
		return $attributes['fields']['id'] != Settings::Get('system.hostname_id')
			&& empty($attributes['fields']['domainaliasid'])
			&& $attributes['fields']['standardsubdomain'] != $attributes['fields']['id'];
	}

	public static function canEditDNS(array $attributes): bool
	{
		return $attributes['fields']['isbinddomain'] == '1'
			&& UI::getCurrentUser()['dnsenabled'] == '1'
			&& $attributes['fields']['caneditdomain'] == '1'
			&& Settings::Get('system.bind_enable') == '1'
			&& Settings::Get('system.dnsenabled') == '1';
	}

	public static function adminCanEditDNS(array $attributes): bool
	{
		return $attributes['fields']['isbinddomain'] == '1'
			&& Settings::Get('system.bind_enable') == '1'
			&& Settings::Get('system.dnsenabled') == '1';
	}

	public static function hasLetsEncryptActivated(array $attributes): bool
	{
		return ((bool)$attributes['fields']['letsencrypt'] && (int)$attributes['fields']['email_only'] == 0);
	}

	public static function canEditSSL(array $attributes): bool
	{
		if (Settings::Get('system.use_ssl') == '1'
			&& DDomain::domainHasSslIpPort($attributes['fields']['id'])
			&& (int)$attributes['fields']['caneditdomain'] == 1
			&& (int)$attributes['fields']['letsencrypt'] == 0
			&& (int)$attributes['fields']['email_only'] == 0
		) {
			return true;
		}
		return false;
	}

	public static function canEditAlias(array $attributes): bool
	{
		return !empty($attributes['fields']['domainaliasid']);
	}

	public static function isAssigned(array $attributes): bool
	{
		return ($attributes['fields']['parentdomainid'] == 0 && empty($attributes['fields']['domainaliasid']));
	}
}
