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
		var time = $("input[name=selectedTime]").val();
		var name = $("#name").val();
		var mobile = $("#mobile").val();
		var email = $("#email").val();
		// check all above values if they are = to 0 or not and show seperate alert for each one
		if (branchId == 0 ){
			alert("Please select a branch");
			return false;
		}else if(vendorId == 0){
			alert("Please select a vendor");
			return false;
		}else if( serviceId == 0){
			alert("Please select a service");
			return false;
		}else if(date == 0 ){
			alert("Please select a date");
			return false;
		}else if ( time == 0 ) {
			alert("Please select atime");
			return false;
		}else if( name == "" ){
			alert("Please enter your name");
		}else if ( mobile == "" ){
			alert("Please enter your mobile with country code")
			return false;
		}else if ( email == "" ){
			alert("Please enter your email")
			return false;
		}else if ( $("input[type=checkbox]").is(":checked") == false ){
			alert("Please agree to terms and conditions")
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
			  time: time,
			  customer: {
				name: name,
			  	mobile: mobile,
			  	email: email
			  }
			}
		  }).done(function(data){
			console.log(data);
			  if( data.ok === true ){
				console.log(data.data);
				return false;
				  //window.location.href = data.data.data.link;
				  
			  }else{
				// show error message
				alert('Something went wrong. Please try again.');
				return false;
			  }
		  }).fail(function(){
			// show error message
			alert('could not make server connection to payment gateway, please try again.');
			return false;
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

