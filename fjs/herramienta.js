$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    var textcolumnas = permisos()

    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
     
      if (tipousuario == 5) {
        columnas = "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-edit'></i></button>\
        </div>"
      } else {
        columnas = "<div class='text-center'><button class='btn btn-sm btn-primary btnEditar'><i class='fas fa-edit'></i></button>\
        <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
      }
      return columnas
    }

    tablaVis = $("#tablaV").DataTable({

        "columnDefs": [{
            targets: -1,
            data: null,
            defaultContent: textcolumnas,
        }, { className: "hide_column", "targets": [3] }, { className: "hide_column", "targets": [4] }],

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
     
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nueva Herramienta");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        hom_her = fila.find('td:eq(1)').text(); //window.location.href = "actprospecto.php?id=" + id;
        cantidad = fila.find('td:eq(2)').text();
        ubicacion = fila.find('td:eq(3)').text();
        obs = fila.find('td:eq(6)').text();
        id_per = fila.find('td:eq(4)').text();
        nom_per = fila.find('td:eq(5)').text();

  
        $("#nom_her").val(hom_her);
        $("#cantidad").val(cantidad);
        $("#ubicacion").val(ubicacion);
        $("#responsable").val(id_per);
       
        $("#obs").val(obs);

        opcion = 2; //editar

       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Herramienta");
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

                url: "bd/crudherramienta.php",
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
      
        var nom_her = $.trim($("#nom_her").val());
        var cantidad = $.trim($("#cantidad").val());
        var ubicacion = $.trim($("#ubicacion").val());
        var responsable= $("#responsable").val();
      
        var obs = $.trim($("#obs").val());
       

      
        


        if (nom_her.length == 0 || cantidad.length == 0  ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
           
            $.ajax({
                url: "bd/crudherramienta.php",
                type: "POST",
                dataType: "json",
                data: {   nom_her: nom_her, cantidad: cantidad, responsable: responsable, id: id, opcion: opcion, ubicacion: ubicacion, obs: obs },
                success: function(data) {
                    
                    id=data[0].id_her
                    nom_her = data[0].nom_her;
                    cantidad= data[0].cant_her;
                    ubicacion= data[0].ubi_her;
                    obs= data[0].obs_her;
                    obs= data[0].obs_her;
                    id_per= data[0].id_per;
                    nom_per= data[0].nom_per;
                    if (opcion == 1) {
                        tablaVis.row.add([id,nom_her,cantidad,ubicacion,id_per,nom_per,obs,]).draw();
                    } else {
                        tablaVis.row(fila).data([id,nom_her,cantidad,ubicacion,id_per,nom_per,obs,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});