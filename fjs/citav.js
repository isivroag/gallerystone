$(document).ready(function() {

    $.ajaxSetup({
        cache: false,
    });

    jQuery.ajaxSetup({
        beforeSend: function() {
            $("#div_carga").show();
        },
        complete: function() {
            $("#div_carga").hide();
        },
        success: function() {},
    });

    $.ajax({
        url: 'bd/dbeventosv.php',
        type: 'POST',
        async: false,

        success: function(data) {
            obj = JSON.stringify(data);
        },
        error: function(xhr, err) {
            alert("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
            alert("responseText: " + xhr.responseText);
        }
    });

    $("#datetimepicker1").datetimepicker({
        locale: "es",
    });

    var opcion;
    var calendar;
    var date = new Date();
    calendario();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();

    function calendario() {
        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById("calendar");

        calendar = new Calendar(calendarEl, {
            plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
            header: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay",
            },

            themeSystem: "bootstrap",
            locale: "es",
            cache: false,
            lazyFetching: true,
            //Random default events

            events: JSON.parse(obj),
            /*events: function(start, end, timezone, callback) {
                jQuery.ajax({
                    url: 'bd/dbeventosv.php',
                    type: 'POST',
                    dataType: 'json',

                    success: function(doc) {
                        var events = [];
                        if (!!doc.result) {
                            $.map(doc.result, function(r) {
                                events.push({
                                    id: r.id,
                                    title: r.title,
                                    start: r.date_start,
                                    end: r.date_end
                                });
                            });
                        }

                    }
                });
            },*/

            eventClick: function(calEvent) {
                var id = calEvent.event.id;
                opcion = 2;

                $.ajax({
                    url: "bd/citasv.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, opcion: 4 },
                    success: function(data) {
                        $("#folio").val(data[0].id);
                        $("#id_pros").val(data[0].id_clie);
                        $("#nom_pros").val(data[0].title);
                        $("#concepto").val(data[0].descripcion);
                        $("#fecha").val(data[0].start);
                        $("#obs").val(data[0].obs);

                        $("#modalCRUD").modal("show");
                    },
                });
            },

            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
        });

        calendar.render();

    }

    tablaC = $("#tablaC").DataTable({
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelCliente'><i class='fas fa-hand-pointer'></i></button></div></div>",
        }, ],

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
        },
    });
    $(document).on("click", "#btnNuevo", function() {
        calendar.destroy();
    });

    $(document).on("click", "#btnGuardar", function() {
        var id_pros = $.trim($("#id_pros").val());
        var nombre = $.trim($("#nom_pros").val());
        var concepto = $.trim($("#concepto").val());
        var fecha = $.trim($("#fecha").val());
        var obs = $.trim($("#obs").val());
        var id = $.trim($("#folio").val());

        $.ajax({
            url: "bd/citasv.php",
            type: "POST",
            dataType: "json",
            data: {
                nombre: nombre,
                id_pros: id_pros,
                fecha: fecha,
                obs: obs,
                concepto: concepto,
                id: id,
                opcion: opcion,
            },
            success: function(data) {
                location.reload();
            },
        });
        $("#modalCRUD").modal("hide");
    });
});