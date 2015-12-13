<form id="filter2" class="col-md-12" action="" method="post">
<?php foreach ($urls as $key => $value) {?>
	<?php
		if(in_array($key, $_SESSION["sort"]["exclude_rss"])){
			$name = "include_rss";
			$btn = "btn btn-default";
			$handler = "IncludeRss(this, '".$key."')";
		}else{
			$name = "exclude_rss";
			$btn = "btn btn-info";
			$handler = "ExcludeRss(this, '".$key."')";
		}
	?>
	<button name="<?php echo $name?>" onclick="<?php echo $handler;?>; return false;" value="<?php echo $key;?>" type="submit" class="<?php echo $btn?>"><?php echo $value;?><i class="glyphicon glyphicon-remove"></i></button>
<?php }?> 
</form>