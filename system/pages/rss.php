<?php
	global $_USER;
	$rss = RssClass::getByUserId($_USER->getProperty("id"));
	$rssController = new RssController($rss->getProperty("url"), "rss/RssListChunk.php");
	$rssController->printRss();
?>