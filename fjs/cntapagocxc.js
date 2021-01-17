$(document).ready(function() {
    var id, opcion;
    opcion = 4;
    var folio_venta, folio_pago;

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Cobranza",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Reporte de Cobranza",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1, 2, 3, 4, 5] },
            },
        ],

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnCancelar'><i class='fas fa-ban'></i></button></div></div>",
        }, ],

        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });

    $("#btnBuscar").click(function() {
        var inicio = $("#inicio").val();
        var final = $("#final").val();


        if (inicio != "" && final != "") {
            $.ajax({
                type: "POST",
                url: "bd/buscarpago_cxc.php",
                dataType: "json",
                data: { inicio: inicio, final: final },
                success: function(data) {

                    tablaVis.clear();
                    tablaVis.draw();
                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].folio_vta,
                                data[i].cliente,
                                data[i].concepto_vta,
                                data[i].folio_pagocxc,
                                data[i].fecha,
                                data[i].concepto,
                                data[i].monto,
                                data[i].metodo,

                            ])
                            .draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });

    $("#btnNuevo").click(function() {
        //window.location.href = "presupuesto.php";
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
        venta = parseInt(fila.find("td:eq(0)").text());
        pago = parseInt(fila.find("td:eq(1)").text());
        //window.location.href = "venta.php?folio=" + id;
    });

    $(document).on("click", ".btnCancelar", function() {
        fila = $(this).closest("tr");

        folio_venta = parseInt(fila.find("td:eq(0)").text());
        folio_pago = parseInt(fila.find("td:eq(3)").text());

        $("#formcan").trigger("reset");
        /*$(".modal-header").css("background-color", "#28a745");*/
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Cancelar Pago");
        $("#modalcan").modal("show");
    });

    $(document).on("click", "#btnGuardar", function() {
        motivo = $("#motivo").val();
        fecha = $("#fecha").val();
        usuario = $("#nameuser").val();
        $("#modalcan").modal("hide");



        if (motivo === "") {
            swal.fire({
                title: "Datos Incompletos",
                text: "Verifique sus datos",
                icon: "warning",
                focusConfirm: true,
                confirmButtonText: "Aceptar",
            });
        } else {
            $.ajax({
                type: "POST",
                url: "bd/cancelarpcxc.php",
                async: false,
                dataType: "json",
                data: {
                    folio_venta: folio_venta,
                    folio_pago: folio_pago,
                    motivo: motivo,
                    fecha: fecha,
                    usuario: usuario,
                },
                success: function(res) {
                    if (res == 1) {
                        mensaje();
                        location.reload();
                    } else {
                        mensajeerror();
                    }
                },
            });
        }
    });

    function mensaje() {
        swal.fire({
            title: "Pago Cancelado",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajeerror() {
        swal.fire({
            title: "Error al Cancelar el pago",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        //Add a zero in front of numbers<10
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + " : " + min + " : " + sec;
        var time = setTimeout(function() {
            startTime();
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
});