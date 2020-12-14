$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",


        buttons: [{
                extend: 'excelHtml5',
                "text": "<i class='fas fa-file-excel'> Excel</i>",
                "titleAttr": "Exportar a Excel",
                "title": 'Reporte de Presupuestos',
                "className": 'btn bg-success ',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Reporte de Presupuestos',
                "className": 'btn bg-danger',
                exportOptions: { columns: [0, 1, 2, 3, 4] }
            }



        ],



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-success btnLlamar'><i class='fas fa-phone'></i></button><button class='btn btn-sm bg-orange  btnhistory'><i class='fas fa-history text-light'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
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

    $("#btnNuevo").click(function() {

        window.location.href = "presupuesto.php";
        //$("#formDatos").trigger("reset");
        //$(".modal-header").css("background-color", "#28a745");
        //$(".modal-header").css("color", "white");
        //$(".modal-title").text("Nuevo Prospecto");
        //$("#modalCRUD").modal("show");
        //id = null;
        //opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "pres.php?folio=" + id;


    });

    $(document).on("click", ".btnLlamar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        $("#formllamada").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Llamada de seguimiento");
        $("#modalcall").modal("show");



    });


    $(document).on("click", ".btnhistory", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        window.location.href = "verhistorialpres.php?folio=" + id;



    });


    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this).closest("tr");

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");


        folio = id;
        estado = 0;
        nota = "CANCELACIÓN";
        fecha = $("#fechasys").val();
        usuario = $("#nameuser").val();
        console.log(fila);
        if (respuesta) {
            $.ajax({

                type: "POST",
                url: "bd/estadopres.php",
                dataType: "json",

                data: { folio: folio, usuario: usuario, estado: estado, nota: nota, fecha: fecha },



                success: function(data) {


                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() { startTime() }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    $("#formllamada").submit(function(e) {
        e.preventDefault();
        folio = id;
        estado = $("#estado").val();
        nota = $("#nota").val();
        fecha = $("#fechasys").val();
        usuario = $("#nameuser").val();

        $.ajax({
            type: "POST",
            url: "bd/estadopres.php",
            dataType: "json",

            data: { folio: folio, usuario: usuario, estado: estado, nota: nota, fecha: fecha },
            success: function() {
                window.location.reload(true);


            }
        });
        $("#modalcall").modal("hide");

    });




});