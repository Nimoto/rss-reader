<?php
	if($error !== true){
		foreach ($error as $message) {
			?><div class="alert alert-danger" role="alert"><?php echo $message;?></div><?php
		}
	}
	echo $form_header;
	foreach ($fields as $field) {
		?><div class="form-group"><?php 
		echo $field;
		?></div><?php
	}
	foreach ($buttons as $button) {
		?><div class="form-group"><?php
		echo $button;
		?></div><?php
	}
	echo $form_footer;
?>