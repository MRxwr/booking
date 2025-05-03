<div class="headerClass">
	<div class="row m-0 w-100" style="height: 60px;">
		<div class="col-2 d-flex align-items-center justify-content-center">
			<a href="?lang=<?php echo direction("ar","en") ?>" class="language-switch" data-aos="fade-right" data-aos-duration="800">
				<i class="fas fa-globe me-1"></i> <?php echo direction("العربية","English") ?>
			</a>
		</div>
		<div class="col-8 d-flex align-items-center justify-content-center">
			<a href="<?php echo "https://booking.createkuwait.com" . "/" . $_GET["vendorURL"] ?>" class="site-title" data-aos="fade-down" data-aos-duration="800">
				<?php echo direction($vendor["enTitle"],$vendor["arTitle"]) ?>
			</a>
		</div>
		<div class="col-2 d-flex align-items-center justify-content-center">
		</div>
	</div>
</div>