
	<div class="row m-0">
	<div class="col-12">
		<div class="form-group">
			<label for="name"><?php echo direction("Name","الإسم") ?></label>
			<input type="text" class="form-control" id="name" placeholder="Enter your name" required>
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="mobile"><?php echo direction("Mobile","الجوال") ?></label>
			<input type="number" step="any" maxlength="11" class="form-control" id="mobile" placeholder="96512345678" required>
		</div>
	</div>
	<div class="col-6">
		<div class="form-group">
			<label for="email"><?php echo direction("Email","البريد الالكتروني") ?></label>
			<input type="email" class="form-control" id="email" placeholder="Enter your email" required>
		</div>
	</div>
	<div class="col-12">
		<div class="form-group form-check">
			<input type="checkbox" class="form-check-input" id="exampleCheck1" required>
			<label class="form-check-label" for="exampleCheck1" ><?php echo direction("I agree to terms and conditions","اوافق على الشروط والاحكام") ?></label>
		</div>
	</div>
	<div class="col-12 mt-3">
		<div type="submit" class="btn btn-primary w-100" style="border-radius: 0px;">
		<div class="row m-0" id="submitBtn">
			<div class="col-9 text-center">
			<?php echo direction("Book Now","حجز الان") ?>
			</div>
			<div class="col-3 bg-white text-black d-flex align-items-center justify-content-center btnPrice">
			0 -/KD
			</div>
		</div>
		</div>
	</div>
	</div>
</form>

<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel"><?php echo direction("Terms and Conditions","الشروط والاحكام") ?></h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body" id="termsModalBody">
		<?php echo direction($vendor["enTerms"],$vendor["arTerms"]) ?>
	</div>
	</div>
</div>
</div>