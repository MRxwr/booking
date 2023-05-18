<div class="fixed-sidebar-left">
	<ul class="nav navbar-nav side-nav nicescroll-bar">
		<li class="navigation-header">
			<span>C.K. Booking System</span> 
			<i class="zmdi zmdi-more"></i>
		</li>
		<?php
		if ( $pages = selectDB("pages","`hidden` = '0' AND `status` = '0' ORDER BY `order` ASC") ){
			foreach( $pages as $page ){
				if( isset($_GET["p"]) && $_GET["p"] == $page["fileName"] ){
					$active = "active";
				}else{
					$active = "";
				}
		?>
		<li>
			<a class="<?php echo $active ?>" href="?p=<?php echo $page["fileName"] ?>" ><div class="pull-left">
			<i class="<?php echo $page["icon"] ?> mr-20"></i>
			<span class="right-nav-text"><?php echo direction($page["enTitle"],$page["arTitle"]) ?></span>
			</div>
			<div class="pull-right"></div><div class="clearfix"></div>
			</a>
		</li>
		<?php
			}
		}
		?>
	</ul>
</div>