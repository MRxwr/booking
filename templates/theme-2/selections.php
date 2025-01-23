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

<?php 
if( $vendor["type"] == "3" ){
?>
	<div class="row m-0 w-100" id="pictureTypes-container-wrapper" style="display:none;">
		<div class="col-12">
			<span><?php echo direction("Types","النوع") ?></span>
		</div>
		<div class="col-12 p-3">
			<div class="row m-0 typesBLK" id="types-container">
				<div class="col d-flex align-items-center justify-content-center  mx-2 mb-2 p-3">
					<span><?php echo direction("Please select service first","الرجاء تحديد فرع"); ?></span>
				</div>
			</div>
		</div>
	</div>

	<div class="row m-0 w-100" id="themes-container-wrapper" style="display:none;">
		<div class="col-12">
			<span><?php echo direction("Themes","التصاميم") ?></span>
		</div>
		<div class="col-12 p-3">
			<div class="row m-0 themesBLK" id="themes-container" style="overflow-y: scroll;max-height: 250px;">
				<div class="col d-flex align-items-center justify-content-center  mx-2 mb-2 p-3">
					<span><?php echo direction("Please select service first","الرجاء تحديد فرع"); ?></span>
				</div>
			</div>
		</div>
	</div>
	<?php
}
	if( $extras = selectDB("extras","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC") ){
		?>
	<div class="row m-0 w-100">
		<div class="col-12">
			<span><?php echo direction("Extras","الإضافات") ?></span>
		</div>
		<div class="col-12 p-3">
			<div class="row m-0" id="themes-container">
				<?php
				foreach( $extras as $extra ){
					$extraTitle = direction($extra["enTitle"],$extra["arTitle"]);
					?>
				<div class="col-10 d-flex p-0 pb-1">
					<input type="checkbox" class="" id="checkExtras" data-price="<?php echo $extra["price"] ?>" value="<?php echo $extra["id"] ?>">
					<label class="form-check-label p-1" for="extra<?php echo $extra["id"] ?>"><?php echo $extraTitle ?></label>
				</div>
				<div class="col-2 p-0" style='font-size: 10px;align-content: center;white-space: nowrap;'>
					<span class="price">+<?php echo numTo3Float($extra["price"]) ?> -/KD</span>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
	}
?>
<div class="row m-0 w-100">
	<div class="col-md-6">
		<label><?php echo direction("Date","التاريخ") ?></label>
		<input type="date" name="date" data-disable-mobile="true" class="form-control" required>
		<input type="hidden" name="serviceId" value="0" required>
		<input type="hidden" name="branchId" value="0" required>
		<input type="hidden" name="selectedDate" value="0" required>
		<input type="hidden" name="selectedTime" value="0" required>
		<input type="hidden" name="vendorId" value="<?php echo $vendor["id"] ?>" required>
		<input type="hidden" name="pictureTypeId" value="0" required>
		<input type="hidden" name="themeId" value="0" required>
		<input type="hidden" name="extras" value="0" required>
	</div> 
	<div class="col-md-6">
		<label><?php echo direction("Time","الوقت") ?></label>
		<select name="time" class="form-control" id="time-select" required>
			<option selected disabled value="0"><?php echo direction("Please select a Time","الرجاء تحديد الوقت") ?></option>
		</select>
	</div>
</div>

<script>
  // total themes
  var totalThemes = 0;
  // Store services data in a JavaScript object
  var services = [
	<?php
	$services = selectDB("services","`status` = '0' AND `hidden` = '0' AND `vendorId` = '{$vendor["id"]}' ORDER BY `id` ASC");
	foreach($services as $service){
	  echo "{ id: '".$service["id"]."',price: '".$service["price"]."',period: '".$service["period"]."', title: '".direction($service["enTitle"],$service["arTitle"])."'},"; 
	}
	?>
  ];

  // Store picturetypes data in a JavaScript object
  var pictureTypes = [
	<?php
		for ( $i = 0; $i < sizeof($services); $i++ ) {
			$pictureTypes = ( is_null($services[$i]["listTypes"]) ) ? [] : json_decode($services[$i]["listTypes"],true);
			foreach($pictureTypes as $type){
				$types = selectDB("picturetype","`id` = '{$type}'");
				echo "{ id: '{$types[0]["id"]}', serviceId: '{$services[$i]["id"]}' , price: '{$types[0]["price"]}' , themesTotal: '{$types[0]["themes"]}' ,title: '".direction($types[0]["enTitle"],$types[0]["arTitle"])."'},"; 
			}
		}
	?>
  ];

    // Store themes data in a JavaScript object
	var themes = [
	<?php
		for ( $i = 0; $i < sizeof($services); $i++ ) {
			$themesList = ( is_null($services[$i]["themes"]) ) ? [] : json_decode($services[$i]["themes"],true);
			foreach($themesList as $theme){
				$themes = selectDB("themes","`id` = '{$theme}'");
				$images = ( is_null($themes[0]["themes"]) ) ? [] : json_decode($themes[0]["themes"],true);
				if( count($images) ){
					for( $j = 0; $j < sizeof($images); $j++ ){
						echo "{ id: '{$themes[0]["id"]}', serviceId: '{$services[$i]["id"]}' ,image: '{$images[$j]}'},"; 
					}
				}
			}
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
	themesTotal = 0;
	$("#loading-screen").show();
	// on change update input name branchId with value
	$("input[name=branchId]").val(this.value);
	$("input[name='serviceId']").val(0);
	$("input[name='selectedTime']").val(0);
	$("input[name='selectedDate']").val(0);
	$("input[name='pictureTypeId']").val(0);
	$("input[name='themeId']").val(0);
	$("input[name='extras']").val(0);
	$(".btnPrice").html("0 -/KD");
	//reset and remove all option from select name time
	timeSelect.innerHTML = '';
	timeSelect.innerHTML = '<option value="0">Please select a time</option>';
	//reset and remove all option from input name date
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
		if( getCookie("createLang") == "ar" ){
			var mins = "دقيقه";
			var priceText = "السعر";
			var durationText = "المدة";
		}else{
			var mins = "mins";
			var priceText = "Price";
			var durationText = "Duration";
		}
	  var serviceHTML = '<div class="col-6 d-flex align-items-center justify-content-center p-2">';
	  serviceHTML += '<div class="w-100 p-3 text-center serviceBLk" id="'+service.id+'"><span>'+service.title+' </span><label style="font-size: 8px;"></label><hr class="m-0"><label style="font-size: 8px;">'+durationText+': '+service.period+' '+mins+' </label><div style="font-size: 8px;" id="priceValue'+service.id+'" data-price="'+service.price+'">'+service.price+' -/KD</div></div>';
	  serviceHTML += '</div>';
	  servicesContainer.innerHTML += serviceHTML;
	});
	updateDatePicker(selectedBranchId);
	$("input[name='date']").val("Please select a date");
	$.each($("#checkExtras:checked"), function(){
		$(this).prop("checked", false);
	});
	updatePrice();
	$("#loading-screen").hide();
  });
  // get theme id
	$(document).on("click",".themeInput", function(){
		var selectedTheme = $(this).attr("id");
		var getSelectedThemes = $("input[name=themeId]").val();
		if( getSelectedThemes == 0 ){
			var array = [selectedTheme];
			$("input[name=themeId]").val(array);
		}else{
			var array = getSelectedThemes.split(",");
			if ( array.includes(selectedTheme) ){
				var index = array.indexOf(selectedTheme);
				array.splice(index, 1);
			}else{
				array.push(selectedTheme);
			}
		}
		if ( themesTotal >= array.length ){
			$("input[name=themeId]").val(array.join(","));
			if($(this).attr('style') && $(this).attr('style').indexOf('border') !== -1) {
				$(this).css({
					"width": "100px",
					"height": "100px",
					"border": "",
					"opacity": "1"
				});
			}else{
				$(this).css({
					"border": "1px solid",
					"opacity": "0.5",
					"width": "100px",
					"height": "100px"
				});
			}
		}else{
			if (getCookie("createLang") == "ar") {
				alert("لا يمكنك تحديد اكثر من "+themesTotal+" ثيمات");
			}else{
				alert("You can select only "+themesTotal+" themes");
			}
		}
	});

	function updatePrice(){
		var totalPrice = 0;

		var selectedService = $("input[name='serviceId']").val();
		var servicePrice = 0;
		var servicePrice = $("#priceValue"+selectedService).attr("data-price");
		
		var pictureTypePrice =  0;
		var pictureTypePrice = $("input[name=pictureTypeRadio]:checked").attr("data-price");

		var extrasPrice = 0;
		$.each($("#checkExtras:checked"), function(){
			extrasPrice += parseInt($(this).attr("data-price"));
		});
		totalPrice = parseInt(servicePrice) + parseInt(pictureTypePrice) + extrasPrice;
		$(".btnPrice").html(totalPrice+" -/KD");
	}

  // get picture type id
  $(document).on("click","#pictureType", function(){
	var selectedType = $(this).attr("value");
	$("input[name=pictureTypeId]").val(selectedType);
	$("input[name=themeId]").val(0);
	// do each on all .themeInput and make style opacity 1 and border none
	$(".themeInput").each(function(){
		$(this).css({
			"width": "100px",
			"height": "100px",
			"border": "",
			"opacity": "1"
		});
	})
	themesTotal = $(this).attr("data-themes");
	updatePrice();
  });

  // checkbox click
  $(document).on("click","#checkExtras", function(){
	var selectedExtra = $(this).attr("value");
	var getSelectedExtras = $("input[name=extras]").val();
	if( getSelectedExtras == 0 ){
		var array = [selectedExtra];
		$("input[name=extras]").val(array);
	}else{
		var selectedExtras = getSelectedExtras.split(",");
		if ( selectedExtras.includes(selectedExtra) ){
			var index = selectedExtras.indexOf(selectedExtra);
			selectedExtras.splice(index, 1);
		}else{
			selectedExtras.push(selectedExtra);
		}
		$("input[name=extras]").val(selectedExtras.join(","));
	}
	updatePrice();
});

  // on serviceBLk click update input name serviceId with attr id
  $(document).on("click",".serviceBLk", function(){
	themesTotal = 0;
	var serviceId = $(this).attr("id");
	$("input[name='serviceId']").val(serviceId);
	$("input[name='selectedTime']").val(0);
	$("input[name='selectedDate']").val(0);
	$("input[name='pictureTypeId']").val(0);
	$("input[name='extras']").val(0);
	$("input[name='themeId']").val(0);
	$.each($("#checkExtras:checked"), function(){
		$(this).prop("checked", false);
	});
	updatePrice();
	$(".btnPrice").html($(this).find("#priceValue"+serviceId).text());
	//reset and remove all option from select name time
	timeSelect.innerHTML = '';
	timeSelect.innerHTML = '<option value="0">Please select a time</option>';
	//reset and remove all option from input name date
	$("input[name='date']").val("Please select a date");
	// give it style active and remove the active from all other services 
	$(".serviceBLk").removeClass("activeService");
	$(this).addClass("activeService");
	// Get the selected serviceId
	var serviceId = $("input[name='serviceId']").val();

	// Filter pictureTypes based on serviceId
	var filteredPictureTypes = {};
	$.each(pictureTypes, function(key, value) {
	if (value.serviceId === serviceId) {
		filteredPictureTypes[key] = value;
	}
	});

	// Fill typesBlk with radio inputs based on filtered pictureTypes
	$(".typesBLK").empty();
	// check if filteredThemes emty then hide #theme-container-wrapper
	if( Object.keys(filteredPictureTypes).length == 0 ){
		$("#pictureTypes-container-wrapper").hide();
	}else{
		$("#pictureTypes-container-wrapper").show();
	}
	$.each(filteredPictureTypes, function(key, value) {
		$types = "<div class='col-10 p-0 pb-1'><input type='radio' id='pictureType' name='pictureTypeRadio' value='"+value.id+"' data-themes='"+value.themesTotal+"' data-price='"+value.price+"'> <label>"+value.title+"</label></div><div class='col-2 p-0' style='font-size: 10px;align-content: center;white-space: nowrap;'>"+parseFloat(value.price).toFixed(3)+" -/KD</div>";
		$(".typesBLK").append($types);
	});

	// Filter themes based on serviceId
	var filteredThemes = {};
	$.each(themes, function(key, value) {
	if (value.serviceId === serviceId) {
		filteredThemes[key] = value;
	}
	});

	// Fill themesBLK with radio inputs and images based on filtered themes
	$(".themesBLK").empty();
	// check if filteredThemes emty then hide #theme-container-wrapper
	if( Object.keys(filteredThemes).length == 0 ){
		$("#themes-container-wrapper").hide();
	}else{
		$("#themes-container-wrapper").show();
	}
	$.each(filteredThemes, function(key, value) {
		var image = value.image;
		var themes = "<div class='col-4 pb-1'><img src='logos/"+image+"' class='themeInput' id='"+image+"' style='width:100px; height:100px'></a></div>";
		$(".themesBLK").append(themes);
	});
	});

  // on selecting select name time update input name selectedTime
  timeSelect.addEventListener("change", function(){
	$("input[name='selectedTime']").val(this.value);
  });

  // now on date change get vendroId branchId and date and serviceId and make a ajax call to retieve the time slots
  $("input[name='date']").on("change", function(){
	$("input[name=selectedDate]").val(this.value);
	if ( $("input[name='branchId']").val() == 0 ){
		alert("<?php echo direction("Please select a branch","الرجاء تحديد فرع") ?>");
		return false;
	}
	if( $("input[name='serviceId']").val() == 0 ){
		alert("<?php echo direction("Please select a service","الرجاء تحديد خدمة") ?>");
		return false;
	}
	$("#loading-screen").show();
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
		$("#loading-screen").hide();
		// check if data.ok = false
		if( data.ok === false ){
			alert("<?php echo direction("No time slots available, Please select another date","لا يوجد وقت متاح، الرجاء تحديد تاريخ اخر") ?>");
			timeSelect.innerHTML = '<option value="0">No time slots available</option>';
			return false;
		}
		var timeSlots = data.data.timeSlots;
		var timeSlotHTML = '<option value="0">Please select a time</option>';
		timeSelect.innerHTML = '<option value="0">Please select a time</option>';
		var currentTime = new Date(); // Get the current device time

		var currentTime = new Date();

timeSlots.forEach(function(timeSlot) {
    // Split the timeslot string, e.g., "14:00 - 15:30" into ["14:00", "15:30"]
    var [startTime, endTime] = timeSlot.split(' - ');

    // Create a date object for the start time today
    var start = new Date(currentTime);
	
    start.setHours(...startTime.split(':').map(Number));
    // Only add timeslot if current time is before the start time
	// check if input[name='selectedDate'] == todays date
	// if yes then check if current time is before start time
	var today = new Date().toISOString().slice(0, 10);
	if ( $("input[name='selectedDate']").val() == today ){
		if (currentTime <= start) {
        	timeSlotHTML += '<option value="' + timeSlot + '">' + timeSlot + '</option>';
    	}
	}else{
		timeSlotHTML += '<option value="' + timeSlot + '">' + timeSlot + '</option>';
	}
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
	// check if todays date > allowedPeriod.startDate then set minDate to todays date
	var today = new Date().toISOString().slice(0, 10);
	if( today > allowedPeriod.startDate ){
		flatpickrInstance.set('minDate', today);
	}else{
		flatpickrInstance.set('minDate', allowedPeriod.startDate);
	}
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