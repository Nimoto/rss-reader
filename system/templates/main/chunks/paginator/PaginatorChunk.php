<?php ?>
<ul class="pagination">
 <!--<li><a href="#">&laquo;</a></li>-->
 <?php 
 for($i = 0; $i < $page_count; $i++){?>
 	<li <?php if($page_num == $i){echo "class='active'";}?>><a href="?<?php echo $page_modif?>=<? echo $i+1;?>"><?php echo $i+1?></a></li>
 <?php }?>
 <!--<li><a href="#">&raquo;</a></li>-->
</ul>