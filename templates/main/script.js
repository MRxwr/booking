// on ready
$(window).ready(function() {
	var width = $(window).width();
	if (width < 768) {
	  $("#leftSide").removeClass("col-6").addClass("col-12");
	} else {
	  $("#leftSide").removeClass("col-12").addClass("col-6");
	}
}); 

// on resize
$(window).resize(function() {
	var width = $(window).width();
	if (width < 768) {
	  $("#leftSide").removeClass("col-6").addClass("col-12");
	} else {
	  $("#leftSide").removeClass("col-12").addClass("col-6");
	}
});