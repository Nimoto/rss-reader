
	<?php if(!empty($items)){ ?>
	<?php foreach ($items as $date => $value) {?>
		<?php
		if($value['read']){
			$main_class = "alert-success";
			$read = "<a onclick=\"IsNotRead(this, '".$value['id']."');return false;\" href=\"#\"><i class=\"glyphicon glyphicon-ok\"></i></a>";
		}else{
			$main_class = "alert-info";
			$read = "<a onclick=\"IsRead(this, '".$value['id']."');return false;\" href=\"#\">отметить как<br />прочитанное</a>";
		}
		?>
		<div class="col-xs-12 col-md-12 col-lg-12 rss-item-wrap">
			<div class="rss-wrapper alert <?php echo $main_class;?> rss-wrap-<?php echo $value['id']?>"  role="alert">
				<div class="lead-wrap">
					<p class="lead">
						<a target="_blank" href="<?php echo $value['link']?>"><?php echo $value['title'];?></a> 
						<?php if($value["audio"]){?>
							<a href="#" class="audio-click" onclick="PlayPodcast('<?php echo $value["audio"]?>');return false;"><i class="glyphicon glyphicon-volume-up"></i></a>
						<?php }?>
					</p>
				</div>
				<div class="is-read"><?php echo $read;?></div>
				<div class="clear"></div>
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

