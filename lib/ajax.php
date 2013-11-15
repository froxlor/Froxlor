<?php

/**
 * This file is part of the Froxlor project.
 * Copyright (c) 2003-2009 the SysCP Team (see authors).
 * Copyright (c) 2010 the Froxlor Team (see authors).
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
	$news = simplexml_load_file('http://froxlor.org/feed.rss.php', null, LIBXML_NOCDATA);

	if ($news !== false) {
		for ($i = 0; $i < 3; $i++) {
			$item = $news->channel->item[$i];
			
			$title = (string)$item->title;
			$link = (string)$item->link;
			$content = preg_replace("/[\r\n]+/", "", strip_tags($item->description));
			
			echo "<div class=\"newsitem\"><a href=\"" . $link . "\" target=\"_blank\"><b>" . $title . "</b>" . $content . "</a></div>";
		}
	} else {
		echo "";
	}
} else {
	echo "No action set.";
}