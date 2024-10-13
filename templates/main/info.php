
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
			<label class="form-check-label" for="exampleCheck1"><?php echo direction("I agree to terms and conditions","اوافق على الشروط والاحكام") ?></label>
		</div>
	</div>
	<div class="col-12 mt-3">
		<button type="submit" class="btn btn-primary w-100">
		<div class="row m-0" id="submitBtn">
			<div class="col-10 text-center">
			<?php echo direction("Book Now","حجز الان") ?>
			</div>
			<div class="col-2 bg-white text-black d-flex align-items-center justify-content-center btnPrice">
			0 -/KD
			</div>
		</div>
		</button>
	</div>
	</div>
</form>