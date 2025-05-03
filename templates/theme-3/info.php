<div class="row m-0 customer-form" data-aos="fade-up">
	<div class="col-12 section-title mb-3">
		<h3><?php echo direction("Your Information","معلومات العميل") ?></h3>
	</div>
	<div class="col-12">
		<div class="form-group floating-label">
			<label for="name" class="form-label"><?php echo direction("Name","الإسم") ?></label>
			<input type="text" class="form-control" id="name" placeholder="<?php echo direction("Enter your name","أدخل اسمك") ?>" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group floating-label">
			<label for="mobile" class="form-label"><?php echo direction("Mobile","الجوال") ?></label>
			<input type="number" step="any" maxlength="11" class="form-control" id="mobile" placeholder="96512345678" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group floating-label">
			<label for="email" class="form-label"><?php echo direction("Email","البريد الالكتروني") ?></label>
			<input type="email" class="form-control" id="email" placeholder="<?php echo direction("Enter your email","أدخل بريدك الإلكتروني") ?>" required>
		</div>
	</div>
<?php
if( $extraInfo = selectDB("extrainfo","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC") ){
	foreach( $extraInfo as $info ){
		$title = direction($info["enTitle"],$info["arTitle"]);
		$required = ($info["isRequired"] == "1") ? "required" : "";
		?>
		<div class="col-md-6" data-aos="fade-up">
			<div class="form-group floating-label">
				<label for="extra-<?php echo $info["id"] ?>" class="form-label"><?php echo $title ?></label>
				<input type="text" class="form-control" id="extra-<?php echo $info["id"] ?>" name="extraInfo[<?php echo $info["id"] ?>]" placeholder="" <?php echo $required ?>>
			</div>	
		</div>
		<?php
	}
}
?>
	<div class="col-12 mt-4">
		<div class="form-check custom-checkbox">
			<input type="checkbox" class="form-check-input" id="termsCheckbox" required>
			<label class="form-check-label" for="termsCheckbox">
				<abbr title="<?php echo htmlspecialchars(direction($vendor["enTerms"],$vendor["arTerms"]), ENT_QUOTES, 'UTF-8'); ?>">
					<?php echo direction("I agree to terms and conditions","اوافق على الشروط والاحكام") ?>
				</abbr>
			</label>
		</div>
	</div>
	<div class="col-12 mt-4 mb-4">
		<div type="submit" class="btn btn-primary w-100 booking-button" id="submitBtn" data-aos="fade-up" data-aos-offset="-100">
		<div class="row m-0">
			<div class="col-9 text-center">
				<span class="btn-text"><?php echo direction("Book Now","حجز الان") ?></span>
				<div class="btn-hover-effect"></div>
			</div>
			<div class="col-3 btn-price-wrapper">
				<span class="btnPrice">0 -/KD</span>
			</div>
		</div>
		</div>
	</div>
</div>
</form>

<!-- Terms Modal -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="termsModalLabel"><?php echo direction("Terms and Conditions","الشروط والاحكام") ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="termsModalBody">
				<?php echo direction($vendor["enTerms"],$vendor["arTerms"]) ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<?php echo direction("Close","إغلاق") ?>
				</button>
			</div>
		</div>
	</div>
</div>