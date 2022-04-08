<?php

namespace Froxlor\Ajax;

use Froxlor\Froxlor;
use Froxlor\PhpHelper;
use Froxlor\Settings;
use Froxlor\UI\Collection;

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
 * @package    AJAX
 *
 */
class GlobalSearch
{
	protected array $userinfo;

	public static function searchSettings(string $searchtext, array $userinfo): array
	{
		$result = [];
		if ($searchtext && strlen(trim($searchtext)) > 2) {
			$processed = [];
			$stparts = explode(" ", $searchtext);
			foreach ($stparts as $searchtext) {
				$searchtext = trim($searchtext);
				if (preg_match('/^([a-z]+):$/', $searchtext, $matches)) {
					// only search settings if specific search is 'settings', else skip
					if ($matches[1] == 'settings') {
						continue;
					} else {
						break;
					}
				}
				$settings_data = PhpHelper::loadConfigArrayDir(Froxlor::getInstallDir() . '/actions/admin/settings/');
				$results = array();
				if (!isset($processed['settings'])) {
					$processed['settings'] = [];
				}
				PhpHelper::recursive_array_search($searchtext, $settings_data, $results);
				foreach ($results as $pathkey) {
					$pk = explode(".", $pathkey);
					if (count($pk) > 4) {
						$settingkey = $pk[0] . '.' . $pk[1] . '.' . $pk[2] . '.' . $pk[3];
						if (isset($settings_data[$pk[0]][$pk[1]]['advanced_mode']) && $settings_data[$pk[0]][$pk[1]]['advanced_mode'] && (int) Settings::Get('panel.settings_mode') == 0) {
							continue;
						}
						if (is_array($processed['settings']) && !array_key_exists($settingkey, $processed['settings'])) {
							$processed['settings'][$settingkey] = true;
							$sresult = $settings_data[$pk[0]][$pk[1]][$pk[2]][$pk[3]];
							if (isset($sresult['advanced_mode']) && $sresult['advanced_mode'] && (int) Settings::Get('panel.settings_mode') == 0) {
								continue;
							}
							if ($sresult['type'] != 'hidden') {
								if (!isset($result['settings'])) {
									$result['settings'] = [];
								}
								$result['settings'][] = [
									'title' => (is_array($sresult['label']) ? $sresult['label']['title'] : $sresult['label']),
									'href' => 'admin_settings.php?page=overview&part=' . $pk[1] . '&em=' . $pk[3]
								];
							} // not hidden
						} // if not processed
					} // correct settingkey
				} // foreach
			} // foreach
		} // searchtext min 3 chars
		return $result;
	}

	/**
	 * 
	 */
	public static function searchGlobal(string $searchtext, array $userinfo): array
	{
		$result = [];
		if ($searchtext && strlen(trim($searchtext)) > 2) {
			$processed = [];

			$stparts = explode(" ", $searchtext);
			$module = "";

			foreach ($stparts as $searchtext) {

				$searchtext = trim($searchtext);

				if (preg_match('/^([a-z]+):$/', $searchtext, $matches)) {
					$module = $matches[1];
					if ($matches[1] == 'settings') {
						break;
					} else {
						continue;
					}
				}

				// admin
				if (isset($userinfo['adminsession']) && $userinfo['adminsession'] == 1) {

					$toSearch = [
						// customers
						'customer' => [
							'class' => \Froxlor\Api\Commands\Customers::class,
							'searchfields' => [
								'c.loginname',
								'c.name',
								'c.firstname',
								'c.company',
								'c.street',
								'c.zipcode',
								'c.city',
								'c.email',
								'c.customernumber',
								'c.custom_notes'
							],
							'result_key' => 'loginname',
							'result_format' => [
								'title' => ['\\Froxlor\\User', 'getCorrectFullUserDetails'],
								'href' => 'admin_customers.php?page=customers&searchfield=c.loginname&searchtext='
							]
						],
						// domains
						'domains' => [
							'class' => \Froxlor\Api\Commands\Domains::class,
							'searchfields' => [
								'd.domain',
								'd.domain_ace',
								'd.documentroot'
							],
							'result_key' => 'domain_ace',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'domain_ace',
								'href' => 'admin_domains.php?page=domains&searchfield=d.domain_ace&searchtext='
							]
						],
						// ips and ports
						'ipsandports' => [
							'class' => \Froxlor\Api\Commands\IpsAndPorts::class,
							'searchfields' => [
								'ip',
								'vhostcontainer',
								'specialsettings'
							],
							'result_key' => 'ip',
							'result_groupkey' => 'ip',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'ip',
								'href' => 'admin_ipsandports.php?page=ipsandports&searchfield=ip&searchtext='
							]
						],
						// hosting-plans
						'hostingplans' => [
							'class' => \Froxlor\Api\Commands\HostingPlans::class,
							'searchfields' => [
								'p.name',
								'p.description'
							],
							'result_key' => 'id',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'name',
								'href' => 'admin_plans.php?page=overview&action=edit&id='
							]
						],
						// PHP configs
						'phpconfigs' => [
							'class' => \Froxlor\Api\Commands\PhpSettings::class,
							'searchfields' => [
								'c.description',
								'fd.description',
								'c.binary'
							],
							'result_key' => 'id',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'description',
								'href' => 'admin_phpsettings.php?page=overview&searchfield=id&searchtext='
							]
						],
						// FPM daemons
						'fpmconfigs' => [
							'class' => \Froxlor\Api\Commands\FpmDaemons::class,
							'searchfields' => [
								'description',
								'reload_cmd'
							],
							'result_key' => 'id',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'description',
								'href' => 'admin_phpsettings.php?page=fpmdaemons&searchfield=id&searchtext='
							]
						]
					];

					if ((bool) $userinfo['change_serversettings']) {
						// admins
						$toSearch['admins'] = [
							'class' => \Froxlor\Api\Commands\Admins::class,
							'searchfields' => [
								'loginname',
								'name',
								'email',
								'custom_notes'
							],
							'result_key' => 'loginname',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'name',
								'href' => 'admin_admins.php?page=admins&searchfield=loginname&searchtext='
							]
						];
					}
				} else {
					$toSearch = [
						// (sub)domains
						'domains' => [
							'class' => \Froxlor\Api\Commands\SubDomains::class,
							'searchfields' => [
								'd.domain',
								'd.domain_ace',
								'd.documentroot'
							],
							'result_key' => 'domain_ace',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'domain_ace',
								'href' => 'customer_domains.php?page=domains&searchfield=d.domain_ace&searchtext='
							]
						],
						// email addresses
						'emails' => [
							'class' => \Froxlor\Api\Commands\Emails::class,
							'searchfields' => [
								'm.email',
								'm.email_full'
							],
							'result_key' => 'email',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'email',
								'href' => 'customer_email.php?page=emails&searchfield=m.email&searchtext='
							]
						],
						// databases
						'databases' => [
							'class' => \Froxlor\Api\Commands\Mysqls::class,
							'searchfields' => [
								'databasename',
								'description'
							],
							'result_key' => 'databasename',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'databasename',
								'href' => 'customer_mysql.php?page=mysqls&searchfield=databasename&searchtext='
							]
						],
						// ftp user
						'ftpuser' => [
							'class' => \Froxlor\Api\Commands\Ftps::class,
							'searchfields' => [
								'username',
								'description'
							],
							'result_key' => 'username',
							'result_format' => [
								'title' => ['self', 'getFieldFromResult'],
								'title_args' => 'username',
								'href' => 'customer_ftp.php?page=accounts&searchfield=username&searchtext='
							]
						]
					];
				}

				// module specific search
				if (!empty($module)) {
					$modSearch = $toSearch[$module] ?? [];
					$toSearch = [$module => $modSearch];
				}

				foreach ($toSearch as $entity => $edata) {

					$collection = (new Collection($edata['class'], $userinfo))
						->addParam(['sql_search' => [
							'_plainsql' =>  self::searchStringSql($edata['searchfields'], $searchtext)
						]]);
					if ($collection->count() > 0) {
						if (!isset($processed[$entity])) {
							$processed[$entity] = [];
						}
						$group_key = $edata['result_groupkey'] ?? $edata['result_key'];
						foreach ($collection->getList() as $cresult) {
							if (is_array($processed[$entity]) && !array_key_exists($cresult[$group_key], $processed[$entity])) {
								$processed[$entity][$cresult[$group_key]] = true;
								if (!isset($result[$entity])) {
									$result[$entity] = [];
								}
								$result[$entity][] = [
									'title' => call_user_func($edata['result_format']['title'], $cresult, ($edata['result_format']['title_args'] ?? null)),
									'href' => $edata['result_format']['href'] . $cresult[$edata['result_key']]
								];
							}
						}
					}
				} // foreach entity

			} // foreach splitted search-term
		}
		return $result;
	}

	private  static function searchStringSql(array $searchfields, $searchtext)
	{
		$result = ['sql' => [], 'values' => []];
		$result['sql'] = "(";
		foreach ($searchfields as $sf) {
			$result['sql'] .= $sf . " LIKE :searchtext OR ";
		}
		$result['sql'] = substr($result['sql'], 0, -3) . ")";
		$result['values'] = ['searchtext' => '%' . $searchtext . '%'];
		return $result;
	}

	private static function getFieldFromResult(array $resultset, string $field = null)
	{
		return $resultset[$field] ?? '';
	}
}
