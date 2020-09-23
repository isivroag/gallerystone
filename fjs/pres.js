$(document).ready(function() {
    var id, opcion;





    tablaVis = $("#tablaV").DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,


        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"
            },
            { className: "text-center", "targets": [4] },
            { className: "text-center", "targets": [5] },
            { className: "text-right", "targets": [6] },
            { className: "text-right", "targets": [7] }
        ],


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

    tablaCon = $("#tablaCon").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelConcepto'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }, { className: "hide_column", "targets": [2] }],

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

    tablaMat = $("#tablaMat").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelMaterial'><i class='fas fa-hand-pointer'></i></button></div></div>"
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

    tablaPre = $("#tablaP").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-success btnSelPrecio'><i class='fas fa-hand-pointer'></i></button></div></div>"
        }, { className: "text-right", "targets": [2] }],

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

    $(document).on("click", "#btnVer", function() {

        folio = $('#folio').val();
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));

        url = "formatos/generacot.php?folio=" + folio;
        console.log(url)
        window.open(url, "Presupuesto", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

    });
    $(document).on("click", "#btnEnviar", function() {

        folio = $('#folio').val();
        var ancho = 1000;
        var alto = 800;
        var x = parseInt((window.screen.width / 2) - (ancho / 2));
        var y = parseInt((window.screen.height / 2) - (alto / 2));

        url = "formatos/enviarcot.php?folio=" + folio;
        console.log(url)
        window.open(url, "Presupuesto", "left=" + x + ",top=" + y + ",height=" + alto + ",width=" + ancho + "scrollbar=si,location=no,resizable=si,menubar=no");

    });
    $(document).on("click", "#bcliente", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalProspecto").modal("show");

    });

    $(document).on("click", "#bconcepto", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalConcepto").modal("show");

    });

    $(document).on("click", "#bmaterial", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalMaterial").modal("show");

    });

    $(document).on("click", "#bprecio", function() {

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");

        $("#modalPrecio").modal("show");

    });

    /*
        $(document).on("change", "#folio", function() {
            folio = $("#folio").val();

            $.ajax({

                type: "POST",
                url: "bd/buscardetalletmp.php",
                dataType: "json",
                data: { folio: folio },
                success: function(res) {

                    for (var i = 0; i < res.length; i++) {
                        tablaVis.row.add([res[i].id_reg, res[i].nom_concepto, res[i].nom_item, res[i].formato, res[i].cantidad, res[i].nom_umedida, res[i].precio, res[i].total]).draw();
                    }
                }
            });
        });
    */
    $(document).on("click", ".btnSelCliente", function() {
        fila = $(this).closest("tr");

        IdCliente = fila.find('td:eq(0)').text();
        NomCliente = fila.find('td:eq(1)').text();
        correo = fila.find('td:eq(2)').text();
        tokenid = $('#tokenid').val();
        folio = $('#folio').val();
        opcion = 1;



        $("#id_pros").val(IdCliente);
        $("#nombre").val(NomCliente);
        $("#correo").val(correo);


        $.ajax({

            type: "POST",
            url: "bd/pres.php",
            dataType: "json",
            data: { IdCliente: IdCliente, tokenid: tokenid, folio: folio, opcion: opcion },
            success: function(res) {

                if (res == 0) {
                    Swal.fire({
                        title: 'Error al Guardar',
                        text: "No se puedo guardar los datos del cliente",
                        icon: 'error',
                    })
                }
            }
        });

        $("#modalProspecto").modal("hide");

    });

    $(document).on("click", "#btnGuardarHead", function() {

        IdCliente = $("#id_pros").val();
        fecha = $("#fecha").val();
        tokenid = $('#tokenid').val();
        folio = $('#folio').val();
        proyecto = $('#proyecto').val();
        ubicacion = $('#ubicacion').val();




        opcion = 2;




        $.ajax({

            type: "POST",
            url: "bd/pres.php",
            dataType: "json",
            data: { IdCliente: IdCliente, fecha: fecha, proyecto: proyecto, ubicacion: ubicacion, tokenid: tokenid, folio: folio, opcion: opcion },
            success: function(res) {

                if (res == 0) {
                    Swal.fire({
                        title: 'Error al Guardar',
                        text: "No se puedo guardar los datos del cliente",
                        icon: 'error',
                    })
                }
            }
        });

        $("#modalProspecto").modal("hide");

    });

    $(document).on("click", ".btnBorrar", function() {

        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        total = $(this).closest("tr").find('td:eq(7)').text();
        folio = $("#folio").val();
        opcion = 2;
        console.log(id);
        console.log(total);
        console.log(folio);
        console.log(opcion);
        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: ?");



        if (respuesta) {
            $.ajax({

                url: "bd/detallepres.php",
                type: "POST",
                dataType: "json",
                data: { id: id, total: total, folio: folio, opcion: opcion },

                success: function() {


                    tablaVis.row(fila.parents('tr')).remove().draw();
                    buscartotal();
                }
            });
        }
    });


    $(document).on("click", ".btnSelConcepto", function() {
        fila = $(this).closest("tr");

        idConcepto = fila.find('td:eq(0)').text();
        NomConcepto = fila.find('td:eq(1)').text();
        id_umedida = fila.find('td:eq(2)').text();
        usomat = fila.find('td:eq(4)').text();
        nom_umedida = fila.find('td:eq(3)').text();


        $("#claveconcepto").val(idConcepto);
        $("#concepto").val(NomConcepto);
        $("#id_umedida").val(id_umedida);
        $("#usomat").val(usomat);
        $("#nom_umedida").val(nom_umedida);



        listarmat();
        $("#bmaterial").prop('disabled', false);




        $("#modalConcepto").modal("hide");

    });

    $(document).on("click", ".btnSelMaterial", function() {
        fila = $(this).closest("tr");

        idMaterial = fila.find('td:eq(0)').text();
        NomMaterial = fila.find('td:eq(2)').text();
        ClaveMaterial = fila.find('td:eq(1)').text();

        /*
         */
        $("#clavemat").val(idMaterial);
        $("#material").val(NomMaterial);
        $("#clave").val(ClaveMaterial);

        $("#modalMaterial").modal("hide");
        listar();

    });

    $(document).on("click", ".btnSelPrecio", function() {
        fila = $(this).closest("tr");

        idPrecio = fila.find('td:eq(0)').text();
        unidad = fila.find('td:eq(1)').text();
        PrecioMaterial = fila.find('td:eq(2)').text();

        /*
        
                */
        $("#idprecio").val(idPrecio);
        $("#unidad").val(unidad);
        $("#precio").val(PrecioMaterial);
        $("#cantidad").prop('disabled', false);
        $("#modalPrecio").modal("hide");


    });

    $(document).on("click", "#btlimpiar", function() {


        $("#clavemat").val("");
        $("#material").val("");
        $("#precio").val("");
        $("#claveconcepto").val("");
        $("#concepto").val("");
        $("#cantidad").val("");

        $("#cantidad").prop('disabled', true);
        //$('#cantidad').attr('disabled', 'disabled');

    });

    $(document).on("click", "#btnagregar", function() {

        folio = $("#folio").val();
        idconcepto = $("#claveconcepto").val();
        NomConcepto = $("#concepto").val();

        id_item = $("#clavemat").val();
        claveMat = $("#clave").val();
        NomMaterial = $("#material").val();

        id_precio = $("#idprecio").val();
        formato = $("#unidad").val();
        precio = $("#precio").val();

        idmedida = $("#idumedida").val();
        umedida = $("#nom_umedida").val();

        cantidad = $("#cantidad").val();

        unidad = $("#unidad").val();
        total = cantidad * PrecioMaterial;
        opcion = 1;

        console.log("folio " + folio);
        console.log("Concepto " + idconcepto);
        console.log("Item " + id_item);
        console.log("IdPrecio " + id_precio);
        console.log("Precio " + precio);
        console.log("Cantidad " + cantidad);
        console.log("Total " + total);
        console.log("Opcion " + opcion);

        if (folio.length != 0 && idconcepto.length != 0 && id_item.length != 0 &&
            idprecio.length != 0 && precio.length != 0 &&
            cantidad.length != 0) {
            $.ajax({

                type: "POST",
                url: "bd/detallepres.php",
                dataType: "json",
                data: { folio: folio, idconcepto: idconcepto, id_item: id_item, id_precio: id_precio, precio: precio, cantidad: cantidad, total: total, opcion: opcion },
                success: function(data) {
                    console.log(data)
                    id_reg = data[0].id_reg;
                    nom_concepto = data[0].nom_concepto;
                    nom_item = data[0].nom_item;
                    formato = data[0].formato;
                    nom_umedida = data[0].nom_umedida;
                    precio = data[0].precio;
                    cantidad = data[0].cantidad;
                    total = data[0].total;


                    tablaVis.row.add([id_reg, nom_concepto, nom_item, formato, cantidad, nom_umedida, precio, total]).draw();
                    buscartotal();




                }
            });


        } else {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Item",
                icon: 'warning',
            })
            return false;
        }

    });

    function listar() {
        id = $('#clavemat').val();
        id_umedida = $('#id_umedida').val();
        tablaPre.clear();
        tablaPre.draw();



        $.ajax({
            type: "POST",
            url: "bd/buscarprecio.php",
            dataType: "json",
            data: { id: id, id_umedida: id_umedida },
            success: function(res) {


                for (var i = 0; i < res.length; i++) {

                    tablaPre.row.add([res[i].id_precio, res[i].formato, res[i].monto, res[i].nom_umedida]).draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }

            }
        });


    };


    function buscartotal() {
        folio = $('#folio').val();


        $.ajax({
            type: "POST",
            url: "bd/buscartotalpres.php",
            dataType: "json",
            data: { folio: folio },
            success: function(res) {
                $("#total").val(res[0].total);

            }
        });
    };


    function listarmat() {

        tablaMat.clear();
        tablaMat.draw();
        var tipo = $("#usomat").val();
        if (tipo == "Si") {
            tipoitem = "Material";
        } else {
            tipoitem = "Servicio";
        }

        $.ajax({
            type: "POST",
            url: "bd/buscaritem.php",
            dataType: "json",
            data: { tipoitem: tipoitem },

            success: function(res) {


                for (var i = 0; i < res.length; i++) {

                    tablaMat.row.add([res[i].id_item, res[i].clave_item, res[i].nom_item]).draw();

                    //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                }

            }
        });

    };

})