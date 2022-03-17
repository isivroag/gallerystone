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
        url: 'bd/bcitasmed.php',
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
            

                $.ajax({
                    url: "bd/citasmedir.php",
                    type: "POST",
                    dataType: "json",
                    data: { id: id, opcion: 4 },
                    success: function(data) {
                        $("#foliocita").val(data[0].folio_cita);
                        $("#folioorden").val(data[0].folio_ord);
                        
                        $("#responsable").val(data[0].responsable);
                        
                        $("#fecha").val(data[0].fecha);

                       
                        document.getElementById("btnCancelarf").style.visibility="visible";
                        document.getElementById("btnAtendido").style.visibility="visible";
                        $("#modalFecha2").modal("show");
                    },
                });
            },

            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
        });

        calendar.render();

    }

    tablaC = $("#tablaorden").DataTable({
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnselorden'><i class='fas fa-hand-pointer'></i></button></div></div>",
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
    $(document).on("click", ".btnselorden", function() {
        fila = $(this).closest('tr')
        $("#modalorden").modal("hide");
        id = parseInt(fila.find('td:eq(0)').text())
        
       
       
        $('#formFecha2').trigger('reset');
        
        $('#modalFecha2').modal('show');
     
        $('#foliocita').val(0);
        $('#folioorden').val(id);


       

     
    });


    $(document).on("click", "#btnNuevo", function() {
      
      
        opcion = 1;
        document.getElementById("btnCancelarf").style.visibility="hidden";
        document.getElementById("btnAtendido").style.visibility="hidden";
        $("#modalorden").modal("show");
    });

    $(document).on("click", "#btnGuardarf", function() {
        var folioorden = $("#folioorden").val();
        var foliocita = $("#foliocita").val();
        var fecha = $("#fecha").val();
        var responsable = $("#responsable").val();
        if (foliocita==0){
            opcion=1
            id=0
        }else{
            opcion=2
            id=foliocita
        }

        $.ajax({
            url: "bd/citasmedir.php",
            type: "POST",
            dataType: "json",
            async:false,
            data: {
                id: id,
                folioorden: folioorden,
                fecha: fecha,
                responsable: responsable,
                opcion: opcion,
            },
            success: function(data) {
                if (data!=0){
                  /*  folio=data

                    var ancho = 600;
                    var alto = 600;
                    var x = parseInt((window.screen.width / 2) - (ancho / 2));
                    var y = parseInt((window.screen.height / 2) - (alto / 2));
    
    

                    url = "formatos/enviarevento.php?folio=" + folio;

                    window.open(url, "CITA DE TOMA DE PLANTILLA", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");*/
                    swal.fire({
                        title: 'Cita de Toma de Plantilla agendada',
                        icon: 'success',
                        focusConfirm: true,
                        confirmButtonText: 'Aceptar',
                      })
                    window.location.reload()
                    
                }
            },
        });
        $("#modalCRUD").modal("hide");
    });


    
  $(document).on('click', '#btnAtendido', function () {
   
    folio =$("#folioorden").val();
    foliocita =$("#foliocita").val();
    estado = 'MEDICION'
    porcentaje=0;

    opcion=5
    id=foliocita

    $.ajax({
      url: 'bd/estadoorden.php',
      type: 'POST',
      dataType: 'json',
      data: {
        folio: folio,
        estado: estado,
        porcentaje: porcentaje
      },
      success: function (res) {
        if (res == 1) {
        
            $.ajax({
                url: 'bd/citasmedir.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    opcion: opcion,
                },
                success: function (res) {
                  if (res == 1) {

                    window.location.href = 'cntaorden.php'
                  } else {
                    
                  }
                },
              })


         
        } else {
          
        }
      },
    })



  })
  $(document).on('click', '#btnCancelarf', function () {
   
    folio =$("#folioorden").val();
    foliocita =$("#foliocita").val();
   
    opcion=6
    id=foliocita

    $.ajax({
        url: 'bd/citasmedir.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            opcion: opcion,
        },
        success: function (res) {
          if (res == 1) {

            window.location.reload()
          } else {
            
          }
        },
      })



  })

});