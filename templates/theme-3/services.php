<div class="row m-0 w-100 services-section" data-aos="fade-up">
	<div class="col-12 section-title">
		<h3><?php echo direction("Services","الخدمات") ?></h3>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0 services-grid">
		<?php
		$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
		for( $i = 0; $i < count($services); $i++){
			?>
			<div class="col d-none align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3" id="serv-<?php echo $services[$i]["id"] ?>" data-aos="zoom-in" data-aos-delay="<?php echo 100 * $i; ?>">
				<div class="service-icon">
					<i class="fas fa-check-circle"></i>
				</div>
				<span class="service-title"><?php echo direction($services[$i]["enTitle"],$services[$i]["arTitle"]); ?></span>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>