<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2013 the Froxlor Team (see authors).
 *
 * For the full copyright and license information, please view the COPYING
 * file that was distributed with this source code. You can also view the
 * COPYING file online at http://files.froxlor.org/misc/COPYING.txt
 *
 * @copyright  (c) the authors
 * @author     Roman Schmerold <bnoize@froxlor.org>
 * @author     Froxlor team <team@froxlor.org> (2010-)
 * @license    GPLv2 http://files.froxlor.org/misc/COPYING.txt
 * @package    AJAX
 *
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load the user settings
if (!file_exists('./userdata.inc.php')) {
	die();
}
require './userdata.inc.php';
require './tables.inc.php';

use Froxlor\UI\Panel\UI;

if (isset($_POST['s'])) {
	$s = $_POST['s'];
} elseif (isset($_GET['s'])) {
	$s = $_GET['s'];
} else {
	$s = '';
}

if (isset($_POST['action'])) {
	$action = $_POST['action'];
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

$theme = $_GET['theme'] ?? 'Froxlor';

UI::sendHeaders();
UI::initTwig();
UI::sendSslHeaders();

ini_set("session.name", "s");
ini_set("url_rewriter.tags", "");
ini_set("session.use_cookies", false);
ini_set("session.cookie_httponly", true);
ini_set("session.cookie_secure", UI::$SSL_REQ);
session_id($s);
session_start();

if (empty($s)) {
	die();
}

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
$sinfo = \Froxlor\Database\Database::pexecute_first($sel_stmt, [
	'hash' => $s,
	'ipaddr' => $remote_addr,
	'ua' => $http_user_agent,
	'timediff' => $timediff
]);

if ($sinfo == false) {
	die();
}

if ($action == "newsfeed") {

	if (isset($_GET['role']) && $_GET['role'] == "customer") {
		$feed = \Froxlor\Settings::Get("customer.news_feed_url");
		if (empty(trim($feed))) {
			$feed = "https://inside.froxlor.org/news/";
		}
	} else {
		$feed = "https://inside.froxlor.org/news/";
	}

	if (function_exists("simplexml_load_file") == false) {
		outputItem("Newsfeed not available due to missing php-simplexml extension", "Please install the php-simplexml extension in order to view our newsfeed.");
		exit();
	}

	if (function_exists('curl_version')) {
		$output = \Froxlor\Http\HttpClient::urlGet($feed);
		$news = simplexml_load_string(trim($output));
	} else {
		outputItem("Newsfeed not available due to missing php-curl extension", "Please install the php-curl extension in order to view our newsfeed.");
		exit();
	}

	if ($news !== false) {
		for ($i = 0; $i < 3; $i++) {
			$item = $news->channel->item[$i];

			$title = (string) $item->title;
			$link = (string) $item->link;
			$date = date("d.m.Y", strtotime($item->pubDate));
			$content = preg_replace("/[\r\n]+/", " ", strip_tags($item->description));
			$content = substr($content, 0, 150) . "...";

			echo UI::Twig()->render($theme . '/user/newsfeeditem.html.twig', [
				'link' => $link,
				'title' => $title,
				'date' => $date,
				'content' => $content
			]);
		}
	} else {
		echo "";
	}
} elseif ($action == "updatecheck") {
	try {
		$json_result = \Froxlor\Api\Commands\Froxlor::getLocal([
			'adminid' => 1,
			'adminsession' => 1,
			'change_serversettings' => 1,
			'loginname' => 'updatecheck'
		])->checkUpdate();
	} catch (Exception $e) {
		\Froxlor\UI\Response::dynamic_error($e->getMessage());
	}
	echo $result;
} else {
	echo "No action set.";
}
