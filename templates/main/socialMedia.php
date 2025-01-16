<div class="row py-3 m-0">
	<div class="col-4 justify-content-center align-items-center">Services</div>
	<div class="col-4 justify-content-center align-items-center">Clients</div>
	<div class="col-4 justify-content-center align-items-center">anything</div>
	<div class="col-md-12 mt-3 d-flex justify-content-center align-items-center">
		<div class="row p-3 socialMediaBar">
		<?php
		if( !empty($vendor["socialMedia"]) ){
			$socialMedia = json_decode($vendor["socialMedia"],true);
			$socialMediaKeys = array_keys($socialMedia);
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
		}
		?>
		</div>
	</div>
</div>