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

