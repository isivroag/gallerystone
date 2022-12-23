$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Ingresos",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Reporte de Ingresos",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1] },
            },
        ],
        stateSave: true,
        searching:false,
        info:false,
        paging: false,

        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'></i></button>\
            </button></div></div>",
        },
        { targets: [1], type: 'num-html' },
    
    ],
  
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

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(1)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
           
            // Update footer
            $(api.column(1).footer()).html(
                '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100)
            );
        }
    });

    tablaVis2 = $("#tablaV2").DataTable({
        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        buttons: [{
                extend: "excelHtml5",
                text: "<i class='fas fa-file-excel'> Excel</i>",
                titleAttr: "Exportar a Excel",
                title: "Reporte de Ingresos",
                className: "btn bg-success ",
                exportOptions: { columns: [0, 1] },
            },
            {
                extend: "pdfHtml5",
                text: "<i class='far fa-file-pdf'> PDF</i>",
                titleAttr: "Exportar a PDF",
                title: "Reporte de Ingresos",
                className: "btn bg-danger",
                exportOptions: { columns: [0, 1] },
            },
        ],
        stateSave: true,
        searching:false,
        info:false,
        paging: false,


        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'>\
            <button class='btn btn-sm bg-info btnResumen'><i class='fas fa-bars'></i></button>\
            </button></div></div>",
        },
        { targets: [1], type: 'num-html' },
    
    ],
  
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

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(1)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
           
            // Update footer
            $(api.column(1).footer()).html(
                '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100)
            );
        }
    });

    tablaResumen = $("#tablaResumen").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [{
            extend: "excelHtml5",
            text: "<i class='fas fa-file-excel'> Excel</i>",
            titleAttr: "Exportar a Excel",
            title: "Detalle de Ingresos",
            className: "btn bg-success ",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
        },
        {
            extend: "pdfHtml5",
            text: "<i class='far fa-file-pdf'> PDF</i>",
            titleAttr: "Exportar a PDF",
            title: "Detalle de Ingresos",
            className: "btn bg-danger",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
        },
    ],
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
        rowCallback: function (row, data) {

            $($(row).find('td')['5']).addClass('text-right')
            $($(row).find('td')['5']).addClass('currency')


        },

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
           
            // Update footer
            $(api.column(5).footer()).html(
                '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100)
            );
        }
    });
  


    tablaResumen2 = $("#tablaResumen2").DataTable({

        dom: "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

    buttons: [{
            extend: "excelHtml5",
            text: "<i class='fas fa-file-excel'> Excel</i>",
            titleAttr: "Exportar a Excel",
            title: "Detalle de Ingresos",
            className: "btn bg-success ",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
        },
        {
            extend: "pdfHtml5",
            text: "<i class='far fa-file-pdf'> PDF</i>",
            titleAttr: "Exportar a PDF",
            title: "Detalle de Ingresos",
            className: "btn bg-danger",
            exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7] },
        },
    ],
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
        rowCallback: function (row, data) {

            $($(row).find('td')['4']).addClass('text-right')
            $($(row).find('td')['4']).addClass('currency')


        },

        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page;
           
            // Update footer
            $(api.column(4).footer()).html(
                '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((total + Number.EPSILON) * 100) / 100)
            );
        }
    });


    function mensaje() {
        swal.fire({
            title: "Venta Cancelada",
            icon: "success",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    function mensajeerror() {
        swal.fire({
            title: "Error al Cancelar la venta",
            icon: "error",
            focusConfirm: true,
            confirmButtonText: "Aceptar",
        });
    }

    $("#btnBuscar").click(function() {
        window.location.href = "rptcorte.php?inicio=" + $('#inicio').val()+"&fin="+$('#fin').val();
      
    });

$(document).on("click", ".bingreso", function() {
        metodo=$(this).val()
        inicio=$('#inicio').val()
        opcion="ingreso"
        fin=$('#fin').val()
      
        buscarpagos(inicio,fin,metodo);
        $("#modalResumen").modal("show");
    });

    $(document).on("click", ".begreso", function() {
        metodo=$(this).val()
        inicio=$('#inicio').val()
   
        fin=$('#fin').val()
      
        buscarpagos2(inicio,fin,metodo);
        $("#modalResumen2").modal("show");
    });

    

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR


    function buscarpagos(inicio,fin,metodo) {
        tablaResumen.clear();
        tablaResumen.draw();

        $.ajax({
            type: "POST",
            url: "bd/buscarcobros.php",
            dataType: "json",

            data: { inicio: inicio,fin: fin,metodo: metodo },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen.row
                        .add([
                            res[i].folio_pagocxc,
                            res[i].concepto,
                            res[i].cliente,
                            res[i].concepto_vta,
                            res[i].metodo,
                            '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((parseFloat(res[i].monto) + Number.EPSILON) * 100) / 100),
                            res[i].factura,
                            res[i].tipop
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
        });
    }

    function buscarpagos2(inicio,fin,metodo) {
        tablaResumen2.clear();
        tablaResumen2.draw();

        $.ajax({
            type: "POST",
            url: "bd/buscarpagos.php",
            dataType: "json",

            data: { inicio: inicio,fin: fin,metodo: metodo },

            success: function(res) {
                for (var i = 0; i < res.length; i++) {
                    tablaResumen2.row
                        .add([
                            res[i].folio_pagocxp,
                            res[i].nombre,
                            res[i].concepto,
                            res[i].metodo,
                            '$ ' + new Intl.NumberFormat('es-MX').format(Math.round((parseFloat(res[i].monto) + Number.EPSILON) * 100) / 100),
                            res[i].referencia,
                            res[i].tipo
                        ])
                        .draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }
            },
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