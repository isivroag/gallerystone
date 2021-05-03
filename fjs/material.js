$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
        }, { className: "hide_column", "targets": [1] }],

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
        $(".modal-title").text("Nuevo Formato-Precio");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        id_umedida = fila.find('td:eq(1)').text();
        nom_mat = fila.find('td:eq(3)').text(); //window.location.href = "actprospecto.php?id=" + id;
        largo = fila.find('td:eq(4)').text();
        alto = fila.find('td:eq(5)').text();
        ancho = fila.find('td:eq(6)').text();
        cantidad = fila.find('td:eq(8)').text();
        metros = fila.find('td:eq(7)').text();
        ubicacion = fila.find('td:eq(9)').text();

        $("#umedida").val(id_umedida);
        $("#nom_mat").val(nom_mat);
        $("#largo").val(largo);
        $("#ancho").val(ancho);
        $("#alto").val(alto);
        $("#cantidad").val(cantidad);
        $("#ubicacion").val(ubicacion);
        $("#metros").val(metros);

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Material");
        $("#modalCRUD").modal("show");

    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find('td:eq(0)').text());
        opcion = 3; //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm("¿Está seguro de eliminar el registro: " + id + "?");


        if (respuesta) {
            $.ajax({

                url: "bd/crudmaterial.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                

                    tablaVis.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });



    $("#formDatos").submit(function(e) {
        e.preventDefault();
        var id_item = $.trim($("#iditem").val());
        var nom_mat = $.trim($("#nom_mat").val());
        var cantidad = $.trim($("#cantidad").val());
        var alto = $.trim($("#alto").val());
        var ancho = $.trim($("#ancho").val());
        var largo = $.trim($("#largo").val());
        var umedida = $.trim($("#umedida").val());
        var ubicacion = $.trim($("#ubicacion").val());
        var metros = $.trim($("#metros").val());
       

      
        


        if (nom_mat.length == 0 || umedida.length == 0 || id_item.length == 0 ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
           
            $.ajax({
                url: "bd/crudmaterial.php",
                type: "POST",
                dataType: "json",
                data: { id_item: id_item, umedida: umedida, nom_mat: nom_mat, cantidad: cantidad,alto: alto,ancho: ancho,largo: largo, id: id, opcion: opcion,ubicacion:ubicacion,metros:metros },
                success: function(data) {
                 


                    //tablaPersonas.ajax.reload(null, false);
                    id = data[0].id_mat;
                    umedida = data[0].id_umedida;
                    nom_umeddia = data[0].nom_umedida;
                    nom_mat = data[0].nom_mat;
                    largo= data[0].largo_mat;
                    ancho= data[0].ancho_mat;
                    alto= data[0].alto_mat;
                    cantidad= data[0].cant_mat;
                    m2_mat= data[0].m2_mat;
                    ubicacion= data[0].ubi_mat;

                    if (opcion == 1) {
                        tablaVis.row.add([id, umedida, nom_umeddia, nom_mat, largo,alto,ancho,m2_mat,cantidad,ubicacion,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, umedida, nom_umeddia, nom_mat, largo,alto,ancho,m2_mat,cantidad,ubicacion,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});