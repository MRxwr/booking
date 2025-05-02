<div class="row m-0 w-100">
	<div class="col-12">
		<span><?php echo direction("Services","الخدمات") ?></span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0">
		<?php
		$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
		for( $i = 0; $i < count($services); $i++){
			?>
			<div class="col d-none align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3" id="serv-<?php echo $services[$i]["id"] ?>">
				<span><?php echo direction($services[$i]["enTitle"],$services[$i]["arTitle"]); ?></span>
			</div>
			<?php
		}
		?>
		</div>
	</div>
</div>