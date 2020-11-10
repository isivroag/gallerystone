$(document).ready(function() {
    var opcion;
    $(function() {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function() {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                }

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject)

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                })

            })
        }

        /* $('.form_datetime').datetimepicker({
             language: 'es',
             weekStart: 1,
             todayBtn: 1,
             autoclose: 1,
             todayHighlight: 1,
             startView: 2,
             forceParse: 0,
             showMeridian: 1
         });*/

        $(function() {
            $('#datetimepicker1').datetimepicker({
                locale: 'es'
            });
        });

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;


        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        };




        var calendar = new Calendar(calendarEl, {

            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            'themeSystem': 'bootstrap',
            'locale': 'es',



            //Random default events
            events: 'bd/dbeventosv.php',
            eventClick: function(calEvent) {
                var id = calEvent.event.id;
                opcion = 2;
                console.log(id);


                $.ajax({
                    url: "bd/citasv.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, opcion: 4 },
                    success: function(data) {
                        console.log(data);
                        $('#folio').val(data[0].id);
                        $('#id_pros').val(data[0].id_clie);
                        $('#nom_pros').val(data[0].title);
                        $('#concepto').val(data[0].descripcion);
                        $('#fecha').val(data[0].start);
                        $('#obs').val(data[0].obs);
                        $("#modalCRUD").modal("show");
                    }
                });
                


            },

            editable: false,
            droppable: true, // this allows things to be dropped onto the calendar !!!

        });

        calendar.render();


        // $('#calendar').fullCalendar()


    })




    tablaC = $("#tablaC").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }],

        //Para cambiar el lenguaje a español
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "sProcessing": "Procesando...",
        }
    });



  



    $(document).on("click", "#btnGuardar", function() {

        var id_pros = $.trim($("#id_pros").val());
        var nombre = $.trim($("#nom_pros").val());
        var concepto = $.trim($("#concepto").val());
        var fecha = $.trim($("#fecha").val());
        var obs = $.trim($("#obs").val());
        var id = $.trim($("#folio").val());

        console.log(opcion);
        console.log(id);



        $.ajax({
            url: "bd/citasv.php",
            type: "POST",
            dataType: "json",
            data: { nombre: nombre, id_pros: id_pros, fecha: fecha, obs: obs, concepto: concepto, id: id, opcion: opcion },
            success: function(data) {
                console.log(data);
                console.log(fila);
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', events);
                $('#calendar').fullCalendar('rerenderEvents');

            }
        });
        $("#modalCRUD").modal("hide");
    });





});