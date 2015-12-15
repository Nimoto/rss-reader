<div class="select">
<?php foreach ($urls as $key => $value) {?>
	<div class="option" onclick="ChooseRss(<?php echo $key?>);" id="rss<?php echo $key?>"><?php echo $value?></div>
<?php }?> 
</div>
