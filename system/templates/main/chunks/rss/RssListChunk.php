
	<?php if(!empty($items)){ ?>
	<?php foreach ($items as $date => $value) {?>
		<div class="col-xs-12 col-md-12 col-lg-12 rss-item-wrap">
			<div class="rss-wrapper alert  alert-info"  role="alert">
				<p class="lead">
					<a href="<?php echo $value['link']?>"><?php echo $value['title'];?></a> 
					<?php if($value["audio"]){?>
						<a href="#" class="audio-click" onclick="PlayPodcast('<?php echo $value["audio"]?>');return false;"><i class="glyphicon glyphicon-volume-up"></i></a>
					<?php }?>
				</p>
				<p class="date"><?php echo $value['date'];?></p>
				<p><?php echo $value['description'];?></p>
				<p><a href="<?php echo $value['main_link']?>"><?php echo $value['main_title'];?></a></p>
				<?/*php if($value["audio"]){?>			 	
					<audio src="<?php echo $value["audio"]?>" preload="auto" controls></audio>
				<?}*/?>
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

