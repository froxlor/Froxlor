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
 
if(isset($_POST['action'])) {
	$action = $_POST['action'];
} elseif(isset($_GET['action'])) {
	$action = $_GET['action'];
} else {
	$action = "";
}

if ($action == "newsfeed") {
	$feed = "http://forum.froxlor.org/index.php/rss/forums/1-froxlor-announcements/";

	if (function_exists("simplexml_load_file") == false) {
		die();
	}

	if (ini_get('allow_url_fopen')) {
		$news = simplexml_load_file($feed, null, LIBXML_NOCDATA);
	} else {
		if (function_exists('curl_version')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $feed);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
			$news = simplexml_load_string(trim($output));
		} else {
			$news = false;
		}
	}

	if ($news !== false) {
		for ($i = 0; $i < 3; $i++) {
			$item = $news->channel->item[$i];

			$title = (string)$item->title;
			$link = (string)$item->link;
			$date = date("Y-m-d G:i", strtotime($item->pubDate));
			$content = preg_replace("/[\r\n]+/", "", strip_tags($item->description));

			echo "<div class=\"newsitem\"><small>" . $date . "</small><br /><a href=\"" . $link . "\" target=\"_blank\"><b>" . $title . "</b><br />" . $content . "</a></div>";
		}
	} else {
		echo "";
	}
} else {
	echo "No action set.";
}
