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

if (isset($_POST['action'])) {
	$action = $_POST['action'];
} elseif (isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

$theme = $_GET['theme'] ?? 'Froxlor';

if ($action == "newsfeed") {

	UI::initTwig();

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
} else {
	echo "No action set.";
}
