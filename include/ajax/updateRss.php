<?php
include($_SERVER["DOCUMENT_ROOT"] . "/system/prolog.php");
global $_USER;
if ($_POST["refresh"] == 1) {
    $rss_controller = new RssController($_USER->getProperty("id"));
    $rss_controller->updateRss();
}
if ($_SESSION["sort"]["date"]) {
    $arSort["date"] = $_SESSION["sort"]["date"];
}
if ($_SESSION["sort"]["read"] == 1) {
    $arParams["read"] = 0;
}
if (empty($arSort)) {
    $arSort["date"] = "desc";
}
$rss_item_controller = new RssItemsController($_USER->getProperty("id"), "rss/RssListChunk.php", $arParams);
$rss_item_controller->printRssItems($arSort);
$paginator_controller = new PaginatorController($rss_item_controller->getProperty("paginator"), "paginator/PaginatorChunk.php");
$paginator_controller->printPaginator();
?>