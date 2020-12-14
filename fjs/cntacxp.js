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
                "title": 'Reporte de Egresos',
                "className": 'btn bg-success ',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            },
            {
                extend: 'pdfHtml5',
                "text": "<i class='far fa-file-pdf'> PDF</i>",
                "titleAttr": "Exportar a PDF",
                "title": 'Reporte de Egresos',
                "className": 'btn bg-danger',
                exportOptions: { columns: [1, 2, 3, 4, 5, 6] }
            }



        ],


        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-search'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
        }, {
            "render": function(data, type, row) {
                return commaSeparateNumber(data);
            },
            "targets": [4, 5]
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

    function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        val = '$ ' + val
        return val;
    }


    $("#btnBuscar").click(function() {
        var inicio = $('#inicio').val();
        var final = $('#final').val();
        console.log(inicio)
        console.log(final)
        tablaVis.clear();
        tablaVis.draw();

        if (inicio != '' && final != '') {
            $.ajax({
                type: "POST",
                url: "bd/buscarcxp.php",
                dataType: "json",
                data: { inicio: inicio, final: final },
                success: function(data) {
                    console.log(data)
                    for (var i = 0; i < data.length; i++) {

                        tablaVis.row.add([data[i].folio_cxp, data[i].fecha, data[i].nombre, data[i].concepto, data[i].total, data[i].saldo, data[i].fecha_limite]).draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }


                }
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });

    $("#btnNuevo").click(function() {

        window.location.href = "cxp.php";
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
        console.log(id);
        window.location.href = "cxp.php?folio=" + id;


    });



    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3 //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");



        if (respuesta) {
            $.ajax({

                url: "",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);


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
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "formatted-num-pre": function(a) {
            a = (a === "-" || a === "") ? 0 : a.replace(/[^\d\-\.]/g, "");
            return parseFloat(a);
        },

        "formatted-num-asc": function(a, b) {
            return a - b;
        },

        "formatted-num-desc": function(a, b) {
            return b - a;
        }
    });





});