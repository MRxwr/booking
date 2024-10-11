<div class="row m-0 w-100">
	<div class="col-md-12">
		<label><?php echo direction("Branch","الفرع") ?></label>
		<select name="branch" class="form-control" required id="branch-select">
			<option selected disabled value="0"><?php echo direction("Please select a Branch","الرجاء تحديد فرع") ?></option>
			<?php
			$orderBy = direction("enTitle","arTitle");
			$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `{$orderBy}` ASC");
			foreach( $branches as $branch ){
				$branchTitle = direction($branch["enTitle"],$branch["arTitle"]);
				echo "<option value='{$branch["id"]}'>{$branchTitle}</option>";
			}
			?>
		</select>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-12">
		<span><?php echo direction("Services","الخدمات") ?></span>
	</div>
	<div class="col-12 p-3">
		<div class="row m-0" id="services-container">
			<div class="col d-flex align-items-center justify-content-center serviceBLk mx-2 mb-2 p-3">
				<span><?php echo direction("No Services	Available","لا يوجد خدمات متاحة"); ?></span>
			</div>
		</div>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-md-6">
		<label><?php echo direction("Date","التاريخ") ?></label>
		<input type="date" name="date" class="form-control">
	</div>
	<div class="col-md-6">
		<label><?php echo direction("Time","الوقت") ?></label>
		<select name="time" class="form-control" id="time-select">
			<option selected disabled value="0"><?php echo direction("Please select a Time","الرجاء تحديد الوقت") ?></option>
			<?php
			$times = selectDB("cbt_times","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' GROUP BY `time` ORDER BY `time` ASC");
			foreach($times as $time){
				echo "<option value='{$time["time"]}'>{$time["time"]}</option>";
			}
			?>
		</select>
	</div>
</div>

<script>
	// Store services data in a JavaScript object
	var services = [
		<?php
		$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach($services as $service){
			echo "{ id: '".$service["id"]."',period: '".$service["period"]."', title: '".direction($service["enTitle"],$service["arTitle"])."'},"; 
		}
		?>
	];

	// Store branches data in a JavaScript object
	var branches = [
		<?php
		$branches = selectDB("branches","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach( $branches as $branch ){
			$branchServices = json_decode($branch["services"]);
			echo "{ id: '".$branch["id"]."', services: ".json_encode($branchServices)."},";
		}
		?>
	];

	//calendar allowed booking period
	var allowedBookingPeriod = [
		<?php
		$calendars = selectDB("calendar","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach( $calendars as $calendar ){
			echo "{ id: '".$calendar["id"]."', branchId: '".$calendar["branchId"]."', startDate: '".$calendar["startDate"]."', endDate: '".$calendar["endDate"]."'},";
		}
		?>
	];

	//blocked days in calendar
	var blockedDays = [
		<?php
		$blockedDaysBranches = selectDB("blockday","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach( $blockedDaysBranches as $blockedDaysBranche ){
			echo "{ id: '".$blockedDaysBranche["id"]."', branchId: '".$blockedDaysBranche["branchId"]."', day: '".$blockedDaysBranche["day"]."'},";
		}
		?>
	];

	//blocked date periods in calendar
	var blockedPeriods = [
		<?php
		$blockedPeriodsBranches = selectDB("blockdate","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
		foreach( $blockedPeriodsBranches as $blockedPeriodsBranche ){
			echo "{ id: '".$blockedPeriodsBranche["id"]."', branchId: '".$blockedPeriodsBranche["branchId"]."', startDate: '".$blockedPeriodsBranche["startDate"]."', endDate: '".$blockedPeriodsBranche["endDate"]."'},";
		}
		?>
	];
	// intialze flatpicker
	var dateInput = document.querySelector("input[name='date']");
	var flatpickrInstance = flatpickr(dateInput, {
		// Initialize with no dates blocked or enabled
		disabled: [],
		enabled: []
	});

	// Get the branch select element, time select element and the services container
	var branchSelect = document.getElementById("branch-select");
	var timeSelect = document.getElementById("time-select");
	var servicesContainer = document.getElementById("services-container");

	// Add an event listener to the branch select element
	branchSelect.addEventListener("change", function(){
		var selectedBranch = this.value;
		var selectedBranchId = this.value;
		var selectedBranchData = branches.find(function(branch){
			return branch.id == selectedBranch;
		});
		var filteredServices = services.filter(function(service){
			return selectedBranchData.services.includes(service.id) || selectedBranchData.services.length === 0;
		});
		
		// Clear the services container
		servicesContainer.innerHTML = "";
		
		// Loop through the filtered services and add them to the container
		filteredServices.forEach(function(service){
			var serviceHTML = '<div class="col-6 d-flex align-items-center justify-content-center p-2">';
			serviceHTML += '<div class="w-100 p-3 text-center serviceBLk" id="serv-'+service.id+'"><span>'+service.title+'</span><hr class="m-0"><label style="font-size: 8px;">Duration: '+service.period+' mins</label></div>';
			serviceHTML += '</div>';
			servicesContainer.innerHTML += serviceHTML;
		});

		updateDatePicker(selectedBranchId);

	});

	function updateDatePicker(branchId) {
		// Find the allowed booking period for the selected branch
		var allowedPeriod = allowedBookingPeriod.find(function(period) {
			return period.branchId === branchId;
		});

		// Find the blocked days for the selected branch
		var blockedDaysForBranch = blockedDays.filter(function(day) {
			return day.branchId === branchId;
		});

		// Find the blocked periods for the selected branch
		var blockedPeriodsForBranch = blockedPeriods.filter(function(period) {
			return period.branchId === branchId;
		});

		// Update the date picker with the new allowed booking period, blocked days, and blocked periods
		flatpickrInstance.set('minDate', allowedPeriod.startDate);
		flatpickrInstance.set('maxDate', allowedPeriod.endDate);
		var disabledRanges = blockedPeriodsForBranch.map(function(period) {
		  return {
			from: new Date(period.startDate).toISOString().split('T')[0],
			to: new Date(period.endDate).toISOString().split('T')[0]
		  };
		});
		
		var blockedDays = blockedDaysForBranch.map(function(day) {
		  return new Date(day.day).toISOString().split('T')[0];
		});
		
		var disabledDates = blockedDays.concat(disabledRanges.map(function(range) {
		  return [range.from, range.to];
		}).flat());

		console.log(disabledDates);
		
		flatpickrInstance.set('disable', disabledDates);
	}

</script>