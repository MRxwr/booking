<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="index.php">
							<img class="brand-img" src="../img/logo.png" alt="brand"/>
							<span class="brand-text">C-Booking</span>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="../img/user1.png" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a><i class="fa fa-user"></i><span><?php echo $username ?></span><hr></a>
							</li>
						<?php
						if ( !isset($_COOKIE["CREATEkwLANG"]) OR $_COOKIE["CREATEkwLANG"] == "ENG" )
						{
						?>
							<li>
								<a href="?lang=AR"><i class="fa fa-language"></i><span>العربية</span></a>
							</li>
						<?php
						}
						else
						{
						?>
							<li>
								<a href="?lang=ENG"><i class="fa fa-language"></i><span>ENGLISH</span></a>
							</li>
						<?php
						}
						?>
							<li>
								<a href="logout.php"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>