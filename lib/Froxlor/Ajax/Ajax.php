<?php

namespace Froxlor\Ajax;

use Exception;
use Froxlor\Http\HttpClient;
use Froxlor\Settings;
use Froxlor\UI\Listing;
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
			case 'tablelisting':
				return $this->updateTablelisting();
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

		// settings
		$result_settings = [];
		if (isset($this->userinfo['adminsession']) && $this->userinfo['adminsession'] == 1 && $this->userinfo['change_serversettings'] == 1) {
			$result_settings = GlobalSearch::searchSettings($searchtext, $this->userinfo);
		}

		// all searchable entities
		$result_entities = GlobalSearch::searchGlobal($searchtext, $this->userinfo);

		$result = array_merge($result_settings, $result_entities);

		header("Content-type: application/json");
		echo json_encode($result);
	}

	private function updateTablelisting()
	{
		$columns = [];
		foreach (Request::get('columns') as $requestedColumn => $value) {
			$columns[] = $requestedColumn;
		}

		Listing::storeColumnListingForUser([Request::get('listing') => $columns]);

		return json_encode($columns);
	}
}
