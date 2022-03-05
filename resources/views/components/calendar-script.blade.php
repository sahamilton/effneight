 <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
    
    <script>
    document.addEventListener('livewire:load', function() {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        
        var calendarEl = document.getElementById('calendar');
        var checkbox = document.getElementById('drop-remove');

        // initialize the calendar
        // -----------------------------------------------------------------

        var calendar = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        
        eventReceive: info => @this.eventReceive(info.event),
        eventDrop: info => @this.eventDrop(info.event, info.oldEvent),
        loading: function(isLoading) {
                if (!isLoading) {
                    // Reset custom events
                    this.getEvents().forEach(function(e){
                        if (e.source === null) {
                            e.remove();
                        }
                    });
                }
            }
        });

        calendar.addEventSource( {
            url: '/calendar/events',
            extraParams: function() {
                return {
                    name: @this.name
                };
            }
        });

        calendar.render();

        @this.on(`refreshCalendar`, () => {
            calendar.refetchEvents()
        });
    });

    </script>


    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />

    <style>

    

    #calendar-container {
        position: relative;
        z-index: 1;
        margin-left: 200px;
    }

    #calendar {
        max-width: 1100px;
        margin: 20px auto;
    }

    </style>