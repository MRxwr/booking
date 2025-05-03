<div class="row py-3 m-0" data-aos="fade-up">
	<div class="col-4 stats-counter" style="text-align: -webkit-center;" data-aos="zoom-in" data-aos-delay="100">
		<div class="counter-value"><?php echo count($serviceList) ?></div>
		<div class="counter-label"><?php echo direction("Services","خدمة") ?></div>
	</div>
	<div class="col-4 stats-counter" style="text-align: -webkit-center;border-right: 1px solid var(--border-color); border-left: 1px solid var(--border-color)" data-aos="zoom-in" data-aos-delay="200">
		<div class="counter-value"><?php echo count($clientsList) ?></div>
		<div class="counter-label"><?php echo direction("Clients","عميل") ?></div>
	</div>
	<div class="col-4 mb-3 stats-counter" style="text-align: -webkit-center;" data-aos="zoom-in" data-aos-delay="300">
		<div class="counter-value"><?php echo count($bookingsList) ?></div>
		<div class="counter-label"><?php echo direction("Bookings","حجز") ?></div>
	</div>
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
				<div class="col d-flex align-items-center justify-content-center socialIconDiv" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($i*100); ?>">
					<a href="<?php echo $socialMediaLink[0]["link"] . $socialMedia[$socialMediaKeys[$i]] ?>" target="_blank" aria-label="<?php echo $socialMediaKeys[$i]; ?>">
						<span class="socialMediaSpan"><i class="fab fa-<?php echo strtolower($socialMediaKeys[$i]) ?>" aria-hidden="true"></i></span>
					</a>
				</div>
				<?php
			}
		}
			echo '</div></div>';
		}
	}
	?>
</div>