<?php 
?>
<ul class="pagination">
<?php if($left_arrow) {?>
 <li><a onclick="Paginator(this);return false;" href="<?php echo $left_arrow?>">&laquo;</a></li>
<?php }?>
 <?php
 $old_key = 0;
 foreach ($nums as $key => $value) { 
 	if(($key - $old_key) > 1){?>
 			<li><span>...</span></li>
 	<?php }
 	$old_key = $key;?>
 	<li <?php if($page_num == $key){echo "class='active'";}?>><a onclick="Paginator(this);return false;" href="?<?php echo $page_modif?>=<? echo $key+1;?>"><?php echo $key+1?></a></li>
 	<?php
 }?>
<?php if($right_arrow) {?>
 <li><a onclick="Paginator(this);return false;" href="<?php echo $right_arrow?>">&raquo;</a></li>
<?php }?>
</ul>