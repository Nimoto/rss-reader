<div class="row">
	<div class="col-md-12">
		<h1>Мои RSS-ленты<small>(<a href="?refresh=1">обновить</a>)</small></h1>
	</div>
</div>
<div class="row">
	<?php if(!empty($items)){ ?>
	<?php foreach ($items as $date => $value) {?>
		<div class="col-xs-12 col-md-12 col-lg-12 rss-item-wrap">
			<div class="rss-wrapper alert  alert-info"  role="alert">
				<p class="lead"><a href="<?php echo $value['link']?>"><?php echo $value['title'];?></a></p>
				<p class="date"><?php echo $value['date'];?></p>
				<p><?php echo $value['description'];?></p>
				<p><a href="<?php echo $value['main_link']?>"><?php echo $value['main_title'];?></a></p>
			</div>
		</div>	
	<?php }?>
	<?php } else {?>
		<div class="col-xs-12 col-md-12 col-lg-12 rss-item-wrap">
			<div class="rss-wrapper alert  alert-info"  role="alert">
				<p><?php echo $message;?></p>
			</div>
		</div>	
	<?php }?>
</div> 

