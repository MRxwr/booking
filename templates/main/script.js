// on ready
$(window).ready(function() {
	var width = $(window).width();
	if (width < 768) {
	  $("#leftSide").removeClass("col-4").addClass("col-12");
	} else {
	  $("#leftSide").removeClass("col-12").addClass("col-4");
	}

	$("body").on("change", "select[name=branch]", function (e) {
		var branch = $(this).val();
		$("#serv-"+branch).removeClass("d-none").addClass("d-flex");
	});

	$("body").on("click", "#submitBtn", function (e) {
		var branchId = $("input[name=branchId]").val();
		var vendorId = $("input[name=vendorId]").val();
		var serviceId = $("input[name=serviceId]").val();
		var date = $("input[name=selectedDate]").val();
		var time = $("select[name=selectedTime]").val();
		// check all above values if they are = to 0 or not and show seperate alert for each one
		if (branchId == 0 || vendorId == 0 || serviceId == 0 || date == 0 || time == 0) {
			alert("Please select branch, vendor, service, date and time");
			return false;
		}
		$.ajax({
			type: "POST",
			url: "requests/index.php?a=Checkout",
			data: {
			  date: date,
			  branchId: branchId,
			  serviceId: serviceId,
			  vendorId: vendorId,
			  time: time
			}
		  }).done(function(data){
			  
		  }).fail(function(){
			// show error message
			alert('Something went wrong. Please try again.');
		  });
	});
}); 

// on resize
$(window).resize(function() {
	var width = $(window).width();
	if (width < 768) {
	  $("#leftSide").removeClass("col-4").addClass("col-12");
	} else {
	  $("#leftSide").removeClass("col-12").addClass("col-4");
	}
});

