<?php
class RssFormController extends MainFormController{

	function handler(){
		$messages = parent::handler();
		if($messages["status"] == "success" && !empty($this->_FORMDATA)){
				$arFields = array(
						"user_id" => $this->_FORMDATA["id"],
						"rss_url" => $this->_FORMDATA["rss_url"]
					);
				RssClass::addRss($arFields);
				$messages["success"] = "Лента добавлена.";			
		}
		return $messages;
	}
}
?>