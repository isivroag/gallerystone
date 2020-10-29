$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-success btnPrecio'><i class='fas fa-dollar-sign'></i></button></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
            },
            { className: "hide_column", "targets": [3] },
            { className: "hide_column", "targets": [4] },
            { className: "hide_column", "targets": [6] },
            { className: "hide_column", "targets": [7] },
            { className: "hide_column", "targets": [9] },
            { className: "hide_column", "targets": [10] }


        ],

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

        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");
        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Item");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro
    $(document).on("click", ".btnPrecio", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());

        window.location.href = "cntaprecio.php?id=" + id;


    });
    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        clave = fila.find('td:eq(1)').text();
        //window.location.href = "actprospecto.php?id=" + id;
        nombre = fila.find('td:eq(2)').text();

        insumo = fila.find('td:eq(3)').text();
        color = fila.find('td:eq(6)').text();
        acabado = fila.find('td:eq(9)').text();
        tipo = fila.find('td:eq(12)').text();
        console.log(tipo);

        $("#nombre").val(nombre);
        $("#clave").val(clave);
        $("#insumo").val(insumo);
        $("#color").val(color);
        $("#acabado").val(acabado);
        $("#tipo").val(tipo);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Item");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");


        console.log(id);
        console.log(opcion);
        if (respuesta) {
            $.ajax({

                url: "bd/cruditem.php",
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



    $("#formDatos").submit(function(e) {
        e.preventDefault();

        var nombre = $.trim($("#nombre").val());
        var clave = $.trim($("#clave").val());
        var insumo = $.trim($("#insumo").val());
        var color = $.trim($("#color").val());
        var acabado = $.trim($("#acabado").val());
        var tipo = $.trim($("#tipo").val());


        console.log(nombre);


        if (nombre.length == 0 || clave.length == 0 || insumo.length == 0 || color.length == 0 || acabado.length == 0 || tipo.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/cruditem.php",
                type: "POST",
                dataType: "json",
                data: { nombre: nombre, clave: clave, insumo: insumo, color: color, acabado: acabado, id: id, opcion: opcion, tipo: tipo },
                success: function(data) {
                    console.log(data);
                    console.log(fila);

                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_item;
                    nombre = data[0].nom_item;
                    clave = data[0].clave_item;
                    id_insumo = data[0].id_insumo;
                    clave_insumo = data[0].clave_insumo;
                    insumo = data[0].nom_insumo;
                    id_color = data[0].id_color;
                    clave_color = data[0].clave_color;
                    color = data[0].nom_color;
                    id_acabado = data[0].id_acabado;
                    clave_acabado = data[0].clave_acabado;
                    acabado = data[0].nom_acabado;
                    tipo = data[0].tipo_item;

                    if (opcion == 1) {
                        tablaVis.row.add([id, clave, nombre, id_insumo, clave_insumo, insumo, id_color, clave_color, color, id_acabado, clave_acabado, acabado, tipo]).draw();
                    } else {
                        tablaVis.row(fila).data([id, clave, nombre, id_insumo, clave_insumo, insumo, id_color, clave_color, color, id_acabado, clave_acabado, acabado, tipo]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});