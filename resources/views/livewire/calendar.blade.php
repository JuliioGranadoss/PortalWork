<div>
  <div id='calendar-container' wire:ignore>
    <div id='calendar'></div>
  </div>
</div>
 
@push('scripts_calendar')
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="application/javascript">
        function mobileCheck() {
            if (window.innerWidth >= 768 ) {
                return false;
            } else {
                return true;
            }
        };
        document.addEventListener('livewire:load', function() {
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;
            var calendarEl = document.getElementById('calendar');
            var checkbox = document.getElementById('drop-remove');
            var data =   @this.events;
            var calendar = new Calendar(calendarEl, {
            initialView: mobileCheck() ? 'timeGridDay' : 'dayGridMonth',
            locale: "es",
            firstDay: 1, //Monday
            events: JSON.parse(data),
            dateClick(info)  {
                Swal.fire({
                    title: 'Introduce nombre de evento',
                    input: 'text',
                    showCancelButton: true
                }).then((result) => {
                    var date = new Date(info.dateStr + 'T00:00:00');
                    if(result.isConfirmed == true && result.value != null && result.value != ''){
                        var eventAdd = {title: result.value, start: date};
                        @this.addevent(eventAdd);
                    }
                });
            },
            eventClick(info)  {
                Swal.fire({
                    title: "¿Estas seguro?",
                    text: "¿Estas seguro de que quieres eliminar este evento?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Eliminar',
                    cancelButtonText: "Cancelar",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then((result) => {
                    var date = new Date(info.dateStr + 'T00:00:00');
                    if(result.isConfirmed == true){
                        @this.removeevent(info.event);
                    }
                });
            },
            editable: true,
            selectable: true,
            displayEventTime: false,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                // if so, remove the element from the "Draggable Events" list
                info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            },
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
            calendar.render();
            @this.on(`refreshCalendar`, () => {
                calendar.refetchEvents()
            });
            @this.on(`eventAdded`, (event) => {
                calendar.addEvent({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                });
            });
            @this.on(`eventRemoved`, (event) => {
                calendar.getEventById(event.id).remove();
            });
        });
    </script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
@endpush