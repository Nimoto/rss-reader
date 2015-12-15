<?php foreach ($urls as $key => $value) {?>
	<?php
		$handler = "ExcludeRss(this, '".$key."')";
	?>
	<button name="exclude_rss" onclick="<?php echo $handler;?>; return false;" value="<?php echo $key;?>" type="submit" class="btn btn-info"><?php echo $value;?><i class="glyphicon glyphicon-remove"></i></button>
<?php }?> 