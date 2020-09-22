$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        }, { className: "hide_column", "targets": [3] }],

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
        $(".modal-title").text("Nuevo Servicio");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        servicio = fila.find('td:eq(1)').text();
        precio = fila.find('td:eq(2)').text();
        id_umedida = fila.find('td:eq(3)').text();



        $("#umedida").val(id_umedida);
        $("#servicio").val(servicio);
        $("#precio").val(precio);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Servicio");
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

                url: "bd/crudservicio.php",
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
        var precio = $.trim($("#precio").val());
        var servicio = $.trim($("#servicio").val());

        var umedida = $.trim($("#umedida").val());



        if (precio.length == 0 || servicio.length == 0 || umedida.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
            console.log(id);
            console.log(precio);
            console.log(servicio);
            console.log(umedida);

            $.ajax({
                url: "bd/crudservicio.php",
                type: "POST",
                dataType: "json",
                data: { umedida: umedida, precio: precio, servicio: servicio, id: id, opcion: opcion },
                success: function(data) {
                    console.log(data);


                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_servicio;
                    umedida = data[0].id_umedida;

                    nom_umeddia = data[0].nom_umedida;
                    servicio = data[0].nom_servicio;
                    precio = data[0].monto_servicio;

                    if (opcion == 1) {
                        tablaVis.row.add([id, servicio, precio, umedida, nom_umeddia]).draw();
                    } else {
                        tablaVis.row(fila).data([id, servicio, precio, umedida, nom_umeddia]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});