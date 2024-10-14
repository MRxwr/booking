<form method="post" action="">
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
				<span><?php echo direction("Please select branch first","الرجاء تحديد فرع"); ?></span>
			</div>
		</div>
	</div>
</div>

<div class="row m-0 w-100">
	<div class="col-md-6">
		<label><?php echo direction("Date","التاريخ") ?></label>
		<input type="date" name="date" data-disable-mobile="true" class="form-control" required>
		<input type="hidden" name="serviceId" value="0" required>
		<input type="hidden" name="branchId" value="0" required>
		<input type="hidden" name="selectedDate" value="0" required>
		<input type="hidden" name="selectedTime" value="0" required>
		<input type="hidden" name="vendorId" value="<?php echo $vendor["id"] ?>" required>
	</div> 
	<div class="col-md-6">
		<label><?php echo direction("Time","الوقت") ?></label>
		<select name="time" class="form-control" id="time-select" required>
			<option selected disabled value="0"><?php echo direction("Please select a Time","الرجاء تحديد الوقت") ?></option>
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
	// on change update input name branchId with value
	$("input[name=branchId]").val(this.value);
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
	  serviceHTML += '<div class="w-100 p-3 text-center serviceBLk" id="'+service.id+'"><span>'+service.title+'</span><hr class="m-0"><label style="font-size: 8px;">Duration: '+service.period+' mins</label></div>';
	  serviceHTML += '</div>';
	  servicesContainer.innerHTML += serviceHTML;
	});
	updateDatePicker(selectedBranchId);
  });

  // on serviceBLk click update input name serviceId with attr id
  $(document).on("click",".serviceBLk", function(){
	var serviceId = $(this).attr("id");
	$("input[name='serviceId']").val(serviceId);
	$("input[name='selectedTime']").val(0);
	$("input[name='selectedDate']").val(0);
	//reset and remove all option from select name time
	timeSelect.innerHTML = '';
	timeSelect.innerHTML = '<option value="0">Please select a time</option>';
	//reset and remove all option from input name date
	$("input[name='date']").val("Please select a date");
	// give it style active and remove the active from all other services 
	$(".serviceBLk").removeClass("activeService");
	$(this).addClass("activeService");
  });

  // on selecting select name time update input name selectedTime
  timeSelect.addEventListener("change", function(){
	$("input[name='selectedTime']").val(this.value);
  });

  // now on date change get vendroId branchId and date and serviceId and make a ajax call to retieve the time slots
  $("input[name='date']").on("change", function(){
	$("input[name=selectedDate]").val(this.value);
	$.ajax({
	  type: "POST",
	  url: "requests/index.php?a=GetTimeSlots",
	  data: {
		date: $("input[name='selectedDate']").val(),
		branchId: $("input[name='branchId']").val(),
		serviceId: $("input[name='serviceId']").val(),
		vendorId: <?php echo $vendor["id"] ?>
	  }
	}).done(function(data){
		// check if data.ok = false
		if( data.ok === false ){
			alert("<?php echo direction("No time slots available, Please select another date","لا يوجد وقت متاح، الرجاء تحديد تاريخ اخر") ?>");
			timeSelect.innerHTML = '<option value="0">No time slots available</option>';
			return false;
		}
		var timeSlots = data.data.timeSlots;
		var timeSlotHTML = "";
		timeSelect.innerHTML = '<option value="0">Please select a time</option>';
		timeSlots.forEach(function(timeSlot){
			timeSlotHTML += '<option value="'+timeSlot+'">'+timeSlot+'</option>';
		});
		timeSelect.innerHTML = timeSlotHTML;
	}).fail(function(){
	  timeSelect.innerHTML = '<option value="0">No time slots available</option>';
	});
  });

  function updateDatePicker(branchId){
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
	
	// Convert the blocked days to a format that flatpickr can understand
	var blockedDaysForBranchFlatpickr = blockedDaysForBranch.map(function(day) {
	  return function(date) {
		return date.getDay() == day.day;
	  };
	});
	
	flatpickrInstance.set('disable', disabledRanges.concat(blockedDaysForBranchFlatpickr));
  }
</script>