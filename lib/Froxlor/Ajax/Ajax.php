<?php

namespace Froxlor\Ajax;

use Exception;
use Froxlor\Http\HttpClient;
use Froxlor\PhpHelper;
use Froxlor\Settings;
use Froxlor\User;
use Froxlor\UI\Panel\UI;
use Froxlor\UI\Request;

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
 * @author     Maurice Preuß <hello@envoyr.com>
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    AJAX
 *
 */
class Ajax
{
	protected string $action;
	protected string $theme;
	protected array $userinfo;
	protected array $lng;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->action = $_GET['action'] ?? $_POST['action'] ?? null;
		$this->theme = $_GET['theme'] ?? 'Froxlor';

		UI::sendHeaders();
		UI::sendSslHeaders();
	}

	/**
	 * initialize global $lng variable to have
	 * localized strings available for the ApiCommands
	 */
	private function initLang()
	{
		global $lng;

		// query the whole table
		$result_stmt = \Froxlor\Database\Database::query("SELECT * FROM `" . TABLE_PANEL_LANGUAGE . "`");

		$langs = array();
		// presort languages
		while ($row = $result_stmt->fetch(\PDO::FETCH_ASSOC)) {
			$langs[$row['language']][] = $row;
		}

		// set default language before anything else to
		// ensure that we can display messages
		$language = \Froxlor\Settings::Get('panel.standardlanguage');

		if (isset($this->userinfo['language']) && isset($langs[$this->userinfo['language']])) {
			// default: use language from session, #277
			$language = $this->userinfo['language'];
		} elseif (isset($this->userinfo['def_language'])) {
			$language = $this->userinfo['def_language'];
		}

		// include every english language file we can get
		foreach ($langs['English'] as $value) {
			include_once \Froxlor\FileDir::makeSecurePath(\Froxlor\Froxlor::getInstallDir() . '/' . $value['file']);
		}

		// now include the selected language if its not english
		if ($language != 'English') {
			if (isset($langs[$language])) {
				foreach ($langs[$language] as $value) {
					include_once \Froxlor\FileDir::makeSecurePath(\Froxlor\Froxlor::getInstallDir() . '/' . $value['file']);
				}
			}
		}

		// last but not least include language references file
		include_once \Froxlor\FileDir::makeSecurePath(\Froxlor\Froxlor::getInstallDir() . '/lng/lng_references.php');

		// set array
		$this->lng = $lng;
	}

	/**
	 * @throws Exception
	 */
	public function handle()
	{
		$this->userinfo = $this->getValidatedSession();

		$this->initLang();

		switch ($this->action) {
			case 'newsfeed':
				return $this->getNewsfeed();
			case 'updatecheck':
				return $this->getUpdateCheck();
			case 'searchglobal':
				return $this->searchGlobal();
			default:
				return $this->errorResponse('Action not found!');
		}
	}

	public function errorResponse($message, int $response_code = 500)
	{
		return \Froxlor\Api\Response::jsonErrorResponse($message, $response_code);
	}

	public function jsonResponse($value, int $response_code = 200)
	{
		return \Froxlor\Api\Response::jsonResponse($value, $response_code);
	}

	/**
	 * @throws Exception
	 */
	private function getValidatedSession(): array
	{
		if (\Froxlor\CurrentUser::hasSession() == false) {
			throw new Exception("No valid session");
		}
		return \Froxlor\CurrentUser::getData();
	}

	/**
	 * @throws Exception
	 */
	private function getNewsfeed()
	{
		UI::initTwig();

		$feed = "https://inside.froxlor.org/news/";

		// Set custom feed if provided
		if (isset($_GET['role']) && $_GET['role'] == "customer") {
			$custom_feed = Settings::Get("customer.news_feed_url");
			if (!empty(trim($custom_feed))) {
				$feed = $custom_feed;
			}
		}

		// Check for simplexml_load_file
		if (!function_exists("simplexml_load_file")) {
			return $this->errorResponse(
				"Newsfeed not available due to missing php-simplexml extension",
				"Please install the php-simplexml extension in order to view our newsfeed."
			);
		}

		// Check for curl_version
		if (!function_exists('curl_version')) {
			return $this->errorResponse(
				"Newsfeed not available due to missing php-curl extension",
				"Please install the php-curl extension in order to view our newsfeed."
			);
		}

		$output = HttpClient::urlGet($feed);
		$news = simplexml_load_string(trim($output));

		// Handle items
		if ($news) {
			$items = null;

			for ($i = 0; $i < 3; $i++) {
				$item = $news->channel->item[$i];

				$title = (string)$item->title;
				$link = (string)$item->link;
				$date = date("d.m.Y", strtotime($item->pubDate));
				$content = preg_replace("/[\r\n]+/", " ", strip_tags($item->description));
				$content = substr($content, 0, 150) . "...";

				$items .= UI::twig()->render($this->theme . '/user/newsfeeditem.html.twig', [
					'link' => $link,
					'title' => $title,
					'date' => $date,
					'content' => $content
				]);
			}

			return $items;
		} else {
			return $this->errorResponse('No Newsfeeds available at the moment.');
		}
	}

	private function getUpdateCheck()
	{
		UI::initTwig();

		try {
			$json_result = \Froxlor\Api\Commands\Froxlor::getLocal($this->userinfo)->checkUpdate();
			$result = json_decode($json_result, true)['data'];
			echo UI::twig()->render($this->theme . '/misc/version_top.html.twig', $result);
			exit;
		} catch (Exception $e) {
			// don't display anything if just not allowed due to permissions
			if ($e->getCode() != 403) {
				\Froxlor\UI\Response::dynamic_error($e->getMessage());
			}
		}
	}

	/**
	 * @todo $userinfo
	 */
	private function searchGlobal()
	{
		$searchtext = Request::get('searchtext');

		$result = [];
		if ($searchtext && strlen(trim($searchtext)) > 2) {

			$processed = [];

			$stparts = explode(" ", $searchtext);

			foreach ($stparts as $searchtext) {
				$searchtext = trim($searchtext);

				// settings (if allowed)
				if (isset($this->userinfo['adminsession']) && $this->userinfo['adminsession'] == 1) {

					if ($this->userinfo['change_serversettings'] == 1) {
						$settings_data = PhpHelper::loadConfigArrayDir(\Froxlor\Froxlor::getInstallDir() . '/actions/admin/settings/');
						$results = array();
						if (!isset($processed['settings'])) {
							$processed['settings'] = [];
						}
						PhpHelper::recursive_array_search($searchtext, $settings_data, $results);
						foreach ($results as $pathkey) {
							$pk = explode(".", $pathkey);
							if (count($pk) > 4) {
								$settingkey = $pk[0] . '.' . $pk[1] . '.' . $pk[2] . '.' . $pk[3];
								if (is_array($processed['settings']) && !array_key_exists($settingkey, $processed['settings'])) {
									$processed['settings'][$settingkey] = true;
									$sresult = $settings_data[$pk[0]][$pk[1]][$pk[2]][$pk[3]];
									if ($sresult['type'] != 'hidden') {
										if (!isset($result['settings'])) {
											$result['settings'] = [];
										}
										$result['settings'][] = [
											'title' => (is_array($sresult['label']) ? $sresult['label']['title'] : $sresult['label']),
											'href' => 'admin_settings.php?page=overview&part=' . $pk[1] . '&em=' . $pk[3]
										];
									}
								}
							}
						}
					}

					// customers
					$searchfields = [
						'c.loginname',
						'c.name',
						'c.firstname',
						'c.company',
						'c.street',
						'c.zipcode',
						'c.city',
						'c.email',
						'c.customernumber'
					];
					$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Customers::class, $this->userinfo))
						->addParam(['sql_search' => [
							'_plainsql' =>  $this->searchStringSql($searchfields, $searchtext)
						]]);
					if ($collection->count() > 0) {
						if (!isset($processed['customer'])) {
							$processed['customer'] = [];
						}
						foreach ($collection->getList() as $cresult) {
							if (is_array($processed['customer']) && !array_key_exists($cresult['customerid'], $processed['customer'])) {
								$processed['customer'][$cresult['customerid']] = true;
								if (!isset($result['customer'])) {
									$result['customer'] = [];
								}
								$result['customer'][] = [
									'title' => User::getCorrectFullUserDetails($cresult),
									'href' => 'admin_customers.php?page=customers&action=edit&id=' . $cresult['customerid']
								];
							}
						}
					}

					// domains
					$searchfields = [
						'd.domain',
						'd.domain_ace',
						'd.documentroot'
					];
					$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Domains::class, $this->userinfo))
						->addParam(['sql_search' => [
							'_plainsql' =>  $this->searchStringSql($searchfields, $searchtext)
						]]);
					if ($collection->count() > 0) {
						if (!isset($processed['domains'])) {
							$processed['domains'] = [];
						}
						foreach ($collection->getList() as $cresult) {
							if (is_array($processed['domains']) && !array_key_exists($cresult['id'], $processed['domains'])) {
								$processed['domains'][$cresult['id']] = true;
								if (!isset($result['domains'])) {
									$result['domains'] = [];
								}
								$result['domains'][] = [
									'title' => $cresult['domain_ace'],
									'href' => 'admin_domains.php?page=domains&action=edit&id=' . $cresult['id']
								];
							}
						}
					}
				} // is-admin
				else {
					// subdomains
					$searchfields = [
						'd.domain',
						'd.domain_ace',
						'd.documentroot'
					];
					$collection = (new \Froxlor\UI\Collection(\Froxlor\Api\Commands\Domains::class, $this->userinfo))
						->addParam(['sql_search' => [
							'_plainsql' =>  $this->searchStringSql($searchfields, $searchtext)
						]]);
					if ($collection->count() > 0) {
						if (!isset($processed['domains'])) {
							$processed['domains'] = [];
						}
						foreach ($collection->getList() as $cresult) {
							if (is_array($processed['domains']) && !array_key_exists($cresult['domains'], $processed['domains'])) {
								$processed['domains'][$cresult['id']] = true;
								if (!isset($result['domains'])) {
									$result['domains'] = [];
								}
								$result['domains'][] = [
									'title' => $cresult['domain_ace'],
									'href' => 'customer_domains.php?page=domains&action=edit&id=' . $cresult['id']
								];
							}
						}
					}
				} // is-customer
			} // foreach splitted search-term
		}
		header("Content-type: application/json");
		echo json_encode($result);
	}

	private function searchStringSql(array $searchfields, $searchtext)
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
}
