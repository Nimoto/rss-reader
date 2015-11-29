<?php
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