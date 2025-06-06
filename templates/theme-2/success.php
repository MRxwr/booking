<div class="row m-0">
	<div class="col-12 p-3">
		<div class="row m-0 p-3 successBody">
			<div class="col-12 p-3 text-center">
				<?php echo direction("Booking Information","معلومات الحجز") ?>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Status","الحالة") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo direction("Success","ناجح") ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Booking#","رقم الحجز") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $order[0]["code"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Date","التاريخ") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $order[0]["bookedDate"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Branch","الفرع") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo direction($branch[0]["enTitle"],$branch[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Time","الوقت") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $order[0]["bookedTime"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Service","الخدمة") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo direction($service[0]["enTitle"],$service[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<?php 
			if( !empty($order[0]["pictureTypeId"]) ){
				$addons = selectDB("picturetype","`id` = '{$order[0]["pictureTypeId"]}'");
				foreach ($addons as $key => $value) {
					?>
					<div class="col-md-12 p-2">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Type","النوع") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
								<label><?php echo direction($value["enTitle"],$value["arTitle"]) ?></label>
							</div>
						</div>
					</div>
					<?php
				}
			}
			if( !empty($order[0]["themes"]) ){
				$themes = explode(",",$order[0]["themes"]);
				foreach ($themes as $value) {
					?>
					<div class="col-md-12 p-2">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Theme","الثيم") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
								<img src="logos/<?php echo $value ?>" style="75px;height:75px;">
							</div>
						</div>
					</div>
					<?php
				}
			}
			if( !empty($order[0]["extras"]) ){
				$extras = selectDB("extras","FIND_IN_SET(`id`,'{$order[0]["extras"]}')");
				foreach ($extras as $key => $value) {
					?>
					<div class="col-md-12 p-2">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Extra","الاضافي") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
								<label><?php echo direction($value["enTitle"],$value["arTitle"]) ?></label>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Total","الاجمالي") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php
						$price = json_decode($order[0]["gatewayBody"],true);
						echo $price["order[amount]"] . " -/KD";
						?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Customer","العميل") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $customer["name"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Mobile","الجوال") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $customer["mobile"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Email","البريد الالكتروني") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
						<label><?php echo $customer["email"] ?></label>
					</div>
				</div>
			</div>
			<?php
			if( !empty($order[0]["extraInfo"]) ){
				$order[0]["extraInfo"] = json_decode($order[0]["extraInfo"],true);
				foreach($order[0]["extraInfo"] as $key => $value) {
					$extraInfo = selectDB("extrainfo","`id` = '{$key}'");
					?>
					<div class="col-md-12 p-2">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
								<label><?php echo $value ?></label>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
			<div class="col-md-12 p-2 pt-4 text-center">
				<img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=<?php echo urlencode("https://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}") ?>" style="width:200px; height:200px">
			</div>
		</div>
	</div>
</div>