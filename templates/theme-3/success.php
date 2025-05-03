<div class="row m-0">
	<div class="col-12 p-3">
		<div class="row m-0 p-3 successBody" data-aos="fade-up">
			<div class="col-12 p-3 text-center booking-result-header success-header">
				<div class="status-icon success mb-3">
					<i class="fas fa-check-circle"></i>
				</div>
				<h2 class="mb-3"><?php echo direction("Booking Confirmed","تم تأكيد الحجز") ?></h2>
				<p class="text-muted"><?php echo direction("Booking Information","معلومات الحجز") ?></p>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="100">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Status","الحالة") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><span class="success-badge"><?php echo direction("Success","ناجح") ?></span></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="150">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Booking#","رقم الحجز") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><span class="booking-number"><?php echo $order[0]["code"] ?></span></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="200">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Date","التاريخ") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="far fa-calendar-alt me-2"></i><?php echo $order[0]["bookedDate"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="250">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Branch","الفرع") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="fas fa-map-marker-alt me-2"></i><?php echo direction($branch[0]["enTitle"],$branch[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="300">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Time","الوقت") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="far fa-clock me-2"></i><?php echo $order[0]["bookedTime"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="350">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Service","الخدمة") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="fas fa-concierge-bell me-2"></i><?php echo direction($service[0]["enTitle"],$service[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<?php 
			if( !empty($order[0]["pictureTypeId"]) ){
				$addons = selectDB("picturetype","`id` = '{$order[0]["pictureTypeId"]}'");
				foreach ($addons as $key => $value) {
					?>
					<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="400">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Type","النوع") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
									<label><i class="fas fa-palette me-2"></i><?php echo direction($value["enTitle"],$value["arTitle"]) ?></label>
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
					<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="450">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Theme","الثيم") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
								<img src="logos/<?php echo $value ?>" class="theme-preview-img" style="width:75px;height:75px;">
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
					<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="500">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction("Extra","الاضافي") ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
									<label><i class="fas fa-plus-circle me-2"></i><?php echo direction($value["enTitle"],$value["arTitle"]) ?></label>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="550">
				<div class="row m-0 p-2 successInfoSection total-section">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Total","الاجمالي") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label class="price-total">
							<?php
							$price = json_decode($order[0]["gatewayBody"],true);
							echo $price["order[amount]"] . " -/KD";
							?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="600">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Customer","العميل") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="fas fa-user me-2"></i><?php echo $customer["name"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="650">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Mobile","الجوال") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="fas fa-phone-alt me-2"></i><?php echo $customer["mobile"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="700">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4" style="white-space: nowrap;">
						<label><?php echo direction("Email","البريد الالكتروني") ?></label>
					</div>
					<div class="col-8" style="overflow-wrap: anywhere;">
							<label><i class="far fa-envelope me-2"></i><?php echo $customer["email"] ?></label>
					</div>
				</div>
			</div>
			<?php
			if( !empty($order[0]["extraInfo"]) ){
				$order[0]["extraInfo"] = json_decode($order[0]["extraInfo"],true);
				$delay = 750;
				foreach($order[0]["extraInfo"] as $key => $value) {
					$extraInfo = selectDB("extrainfo","`id` = '{$key}'");
					?>
					<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
						<div class="row m-0 p-2 successInfoSection">
							<div class="col-4" style="white-space: nowrap;">
								<label><?php echo direction($extraInfo[0]["enTitle"],$extraInfo[0]["arTitle"]) ?></label>
							</div>
							<div class="col-8" style="overflow-wrap: anywhere;">
									<label><i class="fas fa-info-circle me-2"></i><?php echo $value ?></label>
							</div>
						</div>
					</div>
					<?php
					$delay += 50;
				}
			}
			?>
			<div class="col-md-12 p-2 pt-4 text-center" data-aos="zoom-in" data-aos-delay="800">
				<div class="qr-code-container">
					<img src="https://api.qrserver.com/v1/create-qr-code/?size=350x350&data=<?php echo urlencode("https://{$_SERVER["HTTP_HOST"]}{$_SERVER["REQUEST_URI"]}") ?>">
					<p class="mt-2"><?php echo direction("Scan for details","مسح للتفاصيل") ?></p>
				</div>
			</div>
			
			<div class="col-12 p-2 pt-4 text-center" data-aos="fade-up" data-aos-delay="900">
				<a href="<?php echo "https://booking.createkuwait.com" . "/" . $_GET["vendorURL"] ?>" class="btn btn-outline-primary return-home-btn">
					<i class="fas fa-home me-2"></i> <?php echo direction("Return to homepage","العودة إلى الصفحة الرئيسية") ?>
				</a>
			</div>
		</div>
	</div>
</div>