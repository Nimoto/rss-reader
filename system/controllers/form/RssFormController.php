<?php

class RssFormController extends MainFormController {

    function handler() {
        global $_USER;
        $messages = parent::handler();
        if ($messages["status"] == "success" && !empty($this->_FORMDATA)) {
            $arFields = array(
                "user_id" => $this->_FORMDATA["id"],
                "rss_url" => $this->_FORMDATA["rss_url"]
            );
            $rss = DataBaseController::init()->insertRss($arFields);
            if ($rss && !empty($_USER)) {
                $rss_controller = new RssController($_USER->getProperty("id"));
                print_r($rss_controller);
                $rss_controller->updateOneRss($rss);
            }
            $messages["success"] = "Лента добавлена.";
        }
        return $messages;
    }
}

?>