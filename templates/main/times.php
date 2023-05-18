<div class="row m-0 w-100">
	<div class="col-12">
		<span>Time</span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0">
		<?php
		for( $i = 0; $i < 5; $i++){
			?>
			<div class="col d-flex align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3">
				<span><?php echo "Time{$i}"; ?></span>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>