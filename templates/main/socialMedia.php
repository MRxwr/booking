<div class="row py-3 m-0">
	<div class="col-md-12 d-flex justify-content-center align-items-center">
		<div class="row p-3 socialMediaBar">
		<?php
		$socialIcon = ["facebook","instagram","snapchat","twitter","globe","whatsapp"];
		for( $i = 0; $i < sizeof($socialIcon) ; $i++){
			?>
			<div class="col-2 d-flex align-items-center justify-content-center socialIconDiv">
				<span class="socialMediaSpan"><i class="fa fa-<?php echo $socialIcon[$i] ?>" aria-hidden="true"></i></span>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>