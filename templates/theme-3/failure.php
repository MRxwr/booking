<div class="row m-0">
	<div class="col-12 p-3">
		<div class="row m-0 p-3 successBody" data-aos="fade-up">
			<div class="col-12 p-3 text-center booking-result-header failure-header">
				<div class="status-icon failure mb-3">
					<i class="fas fa-times-circle"></i>
				</div>
				<h2 class="mb-3"><?php echo direction("Booking Failed","فشل في الحجز") ?></h2>
				<p class="text-muted"><?php echo direction("Booking Information","معلومات الحجز") ?></p>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="100">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Status","الحالة") ?></label>
					</div>
					<div class="col-8">
							<label><span class="failure-badge"><?php echo direction("Failure","فاشلة") ?></span></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="150">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Booking#","رقم الحجز") ?></label>
					</div>
					<div class="col-8">
						<label><?php //echo $order[0]["code"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="200">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Date","التاريخ") ?></label>
					</div>
					<div class="col-8">
							<label><i class="far fa-calendar-alt me-2"></i><?php echo $order[0]["bookedDate"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="250">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Branch","الفرع") ?></label>
					</div>
					<div class="col-8">
							<label><i class="fas fa-map-marker-alt me-2"></i><?php echo direction($branch[0]["enTitle"],$branch[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="300">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Time","الوقت") ?></label>
					</div>
					<div class="col-8">
							<label><i class="far fa-clock me-2"></i><?php echo $order[0]["bookedTime"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="350">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Service","الخدمة") ?></label>
					</div>
					<div class="col-8">
							<label><i class="fas fa-concierge-bell me-2"></i><?php echo direction($service[0]["enTitle"],$service[0]["arTitle"]) ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="400">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Total","الاجمالي") ?></label>
					</div>
					<div class="col-8">
							<label class="price-total">
							<?php
							$price = json_decode($order[0]["gatewayBody"],true);
							echo $price["order[amount]"] . " -/KD";
							?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="450">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Customer","العميل") ?></label>
					</div>
					<div class="col-8">
							<label><i class="fas fa-user me-2"></i><?php echo $customer["name"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="500">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Mobile","الجوال") ?></label>
					</div>
					<div class="col-8">
							<label><i class="fas fa-phone-alt me-2"></i><?php echo $customer["mobile"] ?></label>
					</div>
				</div>
			</div>
			<div class="col-md-12 p-2" data-aos="fade-up" data-aos-delay="550">
				<div class="row m-0 p-2 successInfoSection">
					<div class="col-4">
						<label><?php echo direction("Email","البريد الالكتروني") ?></label>
					</div>
					<div class="col-8">
							<label><i class="far fa-envelope me-2"></i><?php echo $customer["email"] ?></label>
					</div>
				</div>
			</div>
			
			<div class="col-12 p-3 mt-4 text-center error-message" data-aos="fade-up" data-aos-delay="600">
				<div class="alert alert-warning">
					<i class="fas fa-exclamation-triangle me-2"></i>
					<?php echo direction("Your booking payment was not successful. Please try again later or contact support.", "لم تكن عملية الحجز ناجحة. يرجى المحاولة مرة أخرى لاحقاً أو الاتصال بالدعم.") ?>
				</div>
			</div>
			
			<div class="col-12 p-2 pt-4 text-center" data-aos="fade-up" data-aos-delay="700">
				<a href="<?php echo "https://booking.createkuwait.com" . "/" . $_GET["vendorURL"] ?>" class="btn btn-primary return-home-btn">
					<i class="fas fa-redo me-2"></i> <?php echo direction("Try again","حاول مرة اخرى") ?>
				</a>
			</div>
		</div>
	</div>
</div>