<div class="row py-3 m-0">
	<div class="col-4" style="text-align: -webkit-center;"><?php echo count($serviceList) ?> <div><?php echo direction("Services","خدمة") ?></div></div>
	<div class="col-4" style="text-align: -webkit-center; border-right: 1px solid var(--border-color); border-left: 1px solid var(--border-color);"><?php echo count($clientsList) ?> <div><?php echo direction("Clients","عميل") ?></div></div>
	<div class="col-4 mb-3" style="text-align: -webkit-center;"><?php echo count($bookingsList) ?> <div><?php echo direction("Bookings","حجز") ?></div></div>
		<?php
		if( !empty($vendor["socialMedia"]) ){
			$socialMedia = json_decode($vendor["socialMedia"],true);
			$socialMediaKeys = array_keys($socialMedia);
			if( sizeof($socialMediaKeys) > 0 ){
				echo '<div class="col-md-12 mt-3 d-flex justify-content-center align-items-center"><div class="row p-3 socialMediaBar">';
			for( $i = 0; $i < sizeof($socialMedia) ; $i++){
				if( !empty($socialMedia[$socialMediaKeys[$i]]) ){
					$socialMediaLink = selectDB("socialmedia","`enTitle` = '{$socialMediaKeys[$i]}'");
					?>
					<div class="col d-flex align-items-center justify-content-center socialIconDiv"><a href="<?php echo $socialMediaLink[0]["link"] . $socialMedia[$socialMediaKeys[$i]] ?>" target="_blank">
						<span class="socialMediaSpan"><i class="fa fa-<?php echo strtolower($socialMediaKeys[$i]) ?>" aria-hidden="true"></i></span></a>
					</div>
					<?php
				}
			}
				echo '</div></div>';
			}
		}
		?>
</div>