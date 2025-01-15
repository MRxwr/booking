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
		var extras = $("input[name=extras]").val();
		var pictureTypeId = $("input[name=pictureTypeId]").val();
		var themeId = $("input[name=themeId]").val();
		var extraInfo = {};
		$("input[name^='extraInfo']").each(function(){
			var key = $(this).attr('name').replace('extraInfo[', '').replace(']', '');
			extraInfo[key] = $(this).val();
		});
		var name = $("#name").val();
		var mobile = $("#mobile").val();
		var email = $("#email").val();
		$("#loading-screen").show();
		// check cookie[createLang] if is set to ar then show alert else show alrt in english
		if (getCookie("createLang") == "ar") {
			var branchError = "يرجى تحديد الفرع";
			var vendorError = "يرجى تحديد البائع";
			var serviceError = "يرجى تحديد الخدمة";
			var dateError = "يرجى تحديد التاريخ";
			var timeError = "يرجى تحديد الوقت";
			var nameError = "يرجى ادخال الاسم";
			var mobileError = "يرجى ادخال رقم الجوال";
			var emailError = "يرجى ادخال البريد الالكتروني";
			var termsError = "يرجى الموافقة على الشروط والاحكام";
			var paymentError = "حدث خطأ ، يرجى المحاولة مرة اخرى";
			var serverError = "لا يمكن الاتصال بخادم البيانات للدفع ، يرجى المحاولة مرة اخرى";
		}else{
			var branchError = "Please select a branch";
			var vendorError = "Please select a vendor";
			var serviceError = "Please select a service";
			var dateError = "Please select a date";
			var timeError = "Please select a time";
			var nameError = "Please enter your name";
			var mobileError = "Please enter your mobile with country code";
			var emailError = "Please enter your email";
			var termsError = "Please agree to terms and conditions";
			var paymentError = "Something went wrong. Please try again.";
			var serverError = "could not make server connection to payment gateway, please try again.";
		}
		// check all above values if they are = to 0 or not and show seperate alert for each one
		if 		( branchId == 0 ){	alert(branchError);	$("#loading-screen").hide();return false;
		}else if( vendorId == 0	){	alert(vendorError);	$("#loading-screen").hide();return false;
		}else if( serviceId == 0){	alert(serviceError);$("#loading-screen").hide();return false;
		}else if( date == 0 	){	alert(dateError);	$("#loading-screen").hide();return false;
		}else if( time == 0 	){	alert(timeError);	$("#loading-screen").hide();return false;
		}else if( name == "" 	){	alert(nameError);	$("#loading-screen").hide();return false;
		}else if( mobile == "" 	){	alert(mobileError);	$("#loading-screen").hide();return false;
		}else if( email == "" 	){	alert(emailError);	$("#loading-screen").hide();return false;
		}else if( $("input[type=checkbox]").is(":checked") == false ){alert(termsError);$("#loading-screen").hide();return false;
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
			  extras: extras,
			  pictureTypeId: pictureTypeId,
			  themeId: themeId,
			  extraInfo: extraInfo,
			  customer: {
				name: name,
			  	mobile: mobile,
			  	email: email
			  }
			}
		  }).done(function(result){
			  if( result.ok === true ){
				window.location.href = result.data.data.data.link;
			  }else{
				// show error message
				alert(paymentError);
				$("#loading-screen").hide();
				return false;
			  }
		  }).fail(function(){
			// show error message
			alert(serverError);
			$("#loading-screen").hide();
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

function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
  }

