<?php

class RssItemsController {
    private $user_id;
    private $page;
    private $limit;
    private $template;
    private $view;
    private $rss_list;
    private $count;
    private $arParams;
    private $paginator;

    public function __construct($user_id, $tpl, $arParams = NULL, $limit = 10) {
        $this->user_id = $user_id;
        $this->limit = $limit;
        $this->template = $tpl;
        $this->view = new View();
        $this->paginator = new PaginatorClass();
        $this->page = $this->paginator->getProperty("page_num");
        $this->arParams = $arParams;
        $arParams["user_id"] = $this->user_id;
        $this->paginator->setProperty("page_count", ceil(DataBaseController::init()->getRssItems($arParams, NULL, NULL, true) / $limit));
    }

    private function getAllRssItems($arSort = NULL) {
        $offset = $this->limit * $this->page;
        $this->arParams["user_id"] = $this->user_id;
        $items = DataBaseController::init()->getRssItems($this->arParams, $offset, $this->limit, false, $arSort);
        return $items;
    }

    private function createRss($arSort = NULL) {
        $items = array();
        $lenta = $this->getAllRssItems($arSort);
        if (!empty($lenta["items"])) {
            foreach ($lenta["items"] as $item) {
                if (!$this->rss_list[$item["rss_id"]]) {
                    $this->rss_list[$item["rss_id"]] = RssClass::getById($item["rss_id"]);
                }
                $date_nf = $item["date"];
                $items[$item["id"]]["id"] = $item["id"];
                $items[$item["id"]]["title"] = $item["title"];
                $items[$item["id"]]["link"] = $item["link"];
                $items[$item["id"]]["date"] = $date_nf;
                $items[$item["id"]]["description"] = $item["description"];
                $items[$item["id"]]["audio"] = $item["audio"];
                $items[$item["id"]]["read"] = $item["read"];
                if ($this->rss_list[$item["rss_id"]]) {
                    $items[$item["id"]]["main_title"] = $this->rss_list[$item["rss_id"]]->getProperty("title");
                    $items[$item["id"]]["main_link"] = $this->rss_list[$item["rss_id"]]->getProperty("rss_url");
                }
            }
            $result["items"] = $items;
        } else {
            $result["message"] = "Вы не подписаны ни на одну ленту. Перейти в <a href='/personal/'>Личный кабинет</a>";
        }
        return $result;
    }

    public function printRssItems($arSort = NULL) {
        $data = $this->createRss($arSort);
        $this->include_tpl($this->template, $data);
    }

    private function include_tpl($tpl, $data) {
        $this->view->generate($tpl, $data);
    }

    public function getProperty($property_name) {
        return $this->$property_name;
    }

}

?>