<div class="calendar-wrap mt-40">
    <div id="calendar"></div>
</div>

<script>
    $(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        events: [
            {
                title: 'Booking 1',
                start: '2024-11-05T10:00:00',
                end: '2024-11-05T12:00:00',
                description: 'Customer Name: John Doe'
            },
            {
                title: 'Booking 2',
                start: '2024-11-06T14:00:00',
                end: '2024-11-06T15:00:00',
                description: 'Customer Name: Jane Doe'
            }
            // Add more bookings here
        ],
        eventRender: function(event, element) {
            if (event.description) {
                element.find('.fc-title').append('<br/><span class="fc-description">' + event.description + '</span>');
            }
        }
    });
});

</script>