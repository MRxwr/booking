<div class="row py-3 m-0">
	<div class="col-sm-2 col-3" style="text-align: -webkit-center;"><img src="<?php echo "logos/{$vendor["logo"]}" ?>" class="heroLogo"></div>
	<div class="col-sm-10 col-9" style="font-size: 12px;align-content: center;"><?php echo direction($vendor["enDetails"],$vendor["arDetails"]) ?></div>
		<?php
		if( !empty($vendor["socialMedia"]) ){
			$socialMedia = json_decode($vendor["socialMedia"],true);
			$socialMediaKeys = array_keys($socialMedia);
			if( sizeof($socialMediaKeys) > 0 ){
				echo '<div class="col-md-12 d-flex justify-content-center align-items-center"><div class="row p-3 socialMediaBar">';
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
		<?php /*
		<div class="col-4" style="text-align: -webkit-center;"><?php echo count($serviceList) ?> <div><?php echo direction("Services","خدمة") ?></div></div>
		<div class="col-4" style="text-align: -webkit-center;border-right: 1px solid; border-left: 1px solid"><?php echo count($clientsList) ?> <div><?php echo direction("Clients","عميل") ?></div></div>
		<div class="col-4 mt-3" style="text-align: -webkit-center;"><?php echo count($bookingsList) ?> <div><?php echo direction("Bookings","حجز") ?></div></div>
		*/
		?>
</div>