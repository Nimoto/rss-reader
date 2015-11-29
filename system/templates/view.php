<?php
class View
{	
	function generate($template_view, $data = null)
	{	
		if(is_array($data)) {
			extract($data);
		}
		
		include TEMPLATE_CHUNKS_PATH.$template_view;
	}
}
?>