<div class="headerClass">
	<div class="row m-0 w-100" style="height: 50px;">
		<div class="col-2 d-flex align-items-center justify-content-center">
			<a href="?lang=<?php echo direction("ar","en") ?>" style="text-decoration: none;color: black;"><?php echo direction("العربية","English") ?></a>
		</div>
		<div class="col-8 d-flex align-items-center justify-content-center">
			<a href="<?php echo "https://booking.createkuwait.com" . "/" . $_GET["vendorURL"] ?>" style="text-decoration: none;color: black;"><?php echo direction($vendor["enTitle"],$vendor["arTitle"]) ?></a>
		</div>
		<div class="col-2 d-flex align-items-center justify-content-center">
		</div>
	</div>
</div>