<div class="row w-100 m-0" style="padding:16px">
	<div class="col-12 p-3 text-center" style="font-weight:700; font-size:20px">
	<?php echo direction("Welcome To Create Booking Vendor Control Panel","أهلاً بك في لوحة التحكم الخاصة بالعملاء"); ?>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-default card-view">
			<div class="panel-wrapper collapse in">
				<div class="panel-body">
					<!-- <div class="add-event-wrap">
						<div class="calendar-event btn btn-success">My Event One <a href="javascript:void(0);" class="remove-calendar-event"><i class="fa fa-times fa-fw"></i></a></div>
						<div class="calendar-event btn btn-info">My Event Two <a href="javascript:void(0);" class="remove-calendar-event"><i class="fa fa-times fa-fw"></i></a></div>
						<div class="calendar-event btn btn-warning">My Event Three <a href="javascript:void(0);" class="remove-calendar-event"><i class="fa fa-times fa-fw"></i></a></div>
						<div class="calendar-event btn btn-primary">My Event Four <a href="javascript:void(0);" class="remove-calendar-event"><i class="fa fa-times fa-fw"></i></a></div>
						<input type="text" placeholder="Add Event and hit enter" class="form-control add-event mt-30">
					</div> -->
					<div class="calendar-wrap mt-40">
						<div id="bTcalendar"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>	
</div>

<script>
   
   $(document).ready(function() {
    var calendar = $('#bTcalendar').fullCalendar({
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        eventLimit: true, // allow "more" link when too many events
        timeFormat: 'H:mm',
		header:{
		left:'prev,next today',
		center:'title',
		right:'month,agendaWeek,agendaDay'
		},
		eventMouseover: function (data, event, view) {
			var tooltip = '<div class="tooltiptopicevent tooltip tooltip-inner" style="width:auto;height:auto;position:absolute;z-index:10001;">' + data.description + '</div>';
			$("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });
        },
		eventMouseout: function(data, jsEvent, view) {
			alert('ok');
			$('.tooltiptopicevent').remove();
		},
       eventRender: function( event, element, view ) {
        	var title = element.find('.fc-title, .fc-list-item-title');          
        	title.html(title.text());
        },
     	events: '/admin/request.php?r=calendar',
     	selectable:true,
     	selectHelper:true,
     	select: function(start, end, allDay)
		{
			var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
			$('#start_date').val(start)
			var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
			$('#end_date').val(end)
		},
    
     eventDrop:function(event)
     {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
      var title = event.title;
      var id = event.id;
      $.ajax({
       url:"update.php",
       type:"POST",
       data:{title:title, start:start, end:end, id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
       
       }
      });
     },
     eventClick:function(event)
     {
      if(confirm("Are you sure you want to leave this page?"))
      {
       var url = event.url;
      }
     },
 
    });
   });
    

   </script>