<div class="row py-3 m-0">
	<div class="col-md-12 d-flex justify-content-center align-items-center">
		<div class="row p-3 socialMediaBar">
		<?php
		if( !empty($vendor["socialMedia"]) ){
			$socialMedia = json_decode($vendor["socialMedia"],true);
			$socialMediaKeys = array_keys($socialMedia);
			for( $i = 0; $i < sizeof($socialMedia) ; $i++){
				?>
				<div class="col-2 d-flex align-items-center justify-content-center socialIconDiv"><a href="#" target="_blank">
					<span class="socialMediaSpan"><i class="fa fa-<?php echo strtolower($socialMediaKeys[$i]) ?>" aria-hidden="true"></i></span></a>
				</div>
				<?php
			}
		}
		?>
		</div>
	</div>
</div>