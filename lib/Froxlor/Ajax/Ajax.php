<?php

namespace Froxlor\Ajax;

use Exception;
use Froxlor\Http\HttpClient;
use Froxlor\PhpHelper;
use Froxlor\Settings;
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
	protected string $session;
	protected string $action;
	protected string $theme;
	protected array $lng;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->session = $_GET['s'] ?? $_POST['s'] ?? null;
		$this->action = $_GET['action'] ?? $_POST['action'] ?? null;
		$this->theme = $_GET['theme'] ?? 'Froxlor';

		$this->initLang();
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

		if (isset($this->user_data['language']) && isset($langs[$this->user_data['language']])) {
			// default: use language from session, #277
			$language = $this->user_data['language'];
		} elseif (isset($this->user_data['def_language'])) {
			$language = $this->user_data['def_language'];
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
		$session = $this->getValidatedSession();

		switch ($this->action) {
			case 'newsfeed':
				return $this->getNewsfeed();
			case 'updatecheck':
				return $this->getUpdateCheck();
			case 'searchsetting':
				return $this->searchSetting();
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
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		if (empty($_SERVER['HTTP_USER_AGENT'])) {
			$http_user_agent = 'unknown';
		} else {
			$http_user_agent = $_SERVER['HTTP_USER_AGENT'];
		}

		$timediff = time() - \Froxlor\Settings::Get('session.sessiontimeout');
		$sel_stmt = \Froxlor\Database\Database::prepare("
            SELECT * FROM `" . TABLE_PANEL_SESSIONS . "`
            WHERE `hash` = :hash AND `ipaddress` = :ipaddr AND `useragent` = :ua AND `lastactivity` > :timediff
        ");

		$session = \Froxlor\Database\Database::pexecute_first($sel_stmt, [
			'hash' => $this->session,
			'ipaddr' => $remote_addr,
			'ua' => $http_user_agent,
			'timediff' => $timediff
		]);

		if (!$session) {
			throw new Exception('Session is not defined!');
		}

		return $session;
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
		UI::twig()->addGlobal('s', $this->session);

		// TODO: set variables from current session
		try {
			$json_result = \Froxlor\Api\Commands\Froxlor::getLocal([
				'adminid' => 1,
				'adminsession' => 1,
				'change_serversettings' => 1,
				'loginname' => 'updatecheck'
			])->checkUpdate();
			$result = json_decode($json_result, true)['data'];
			echo UI::twig()->render($this->theme . '/misc/version_top.html.twig', $result);
			exit;
		} catch (Exception $e) {
			\Froxlor\UI\Response::dynamic_error($e->getMessage());
		}
	}

	private function searchSetting()
	{
		$searchtext = Request::get('searchtext');

		$result = [];
		if ($searchtext && strlen($searchtext) > 2) {
			$settings_data = PhpHelper::loadConfigArrayDir(\Froxlor\Froxlor::getInstallDir() . '/actions/admin/settings/');
			$results = array();
			PhpHelper::recursive_array_search($searchtext, $settings_data, $results);
			$processed_setting = array();
			foreach ($results as $pathkey) {
				$pk = explode(".", $pathkey);
				if (count($pk) > 4) {
					$settingkey = $pk[0] . '.' . $pk[1] . '.' . $pk[2] . '.' . $pk[3];
					if (!array_key_exists($settingkey, $processed_setting)) {
						$processed_setting[$settingkey] = true;
						$sresult = $settings_data[$pk[0]][$pk[1]][$pk[2]][$pk[3]];
						if ($sresult['type'] != 'hidden') {
							$result[] = [
								'title' => (is_array($sresult['label']) ? $sresult['label']['title'] : $sresult['label']),
								'href' => 'admin_settings.php?page=overview&part=' . $pk[1] . '&em=' . $pk[3] . '&s=' . $this->session,
							];
						}
					}
				}
			}
		}
		header("Content-type: application/json");
		echo json_encode(['settings' => $result]);
	}
}
