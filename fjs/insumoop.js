$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
            <button class='btn btn-sm bg-gradient-orange text-light btnMov' data-toggle='tooltip' data-placement='top' title='Movimientos'><i class='fas fa-exchange-alt'></i></button>\
            <button class='btn btn-sm bg-gradient-purple text-light btnKardex' data-toggle='tooltip' data-placement='top' title='Kardex'><i class='fas fa-bars'></i></button>\
            <button class='btn btn-sm btn-danger btnBorrar'><i class='fas fa-trash-alt'></i></button></div>"
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
     
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Nuevo Insumo");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(0)').text());
        id_umedida = fila.find('td:eq(3)').text();
        nom_cons = fila.find('td:eq(1)').text(); //window.location.href = "actprospecto.php?id=" + id;
        cantidad = fila.find('td:eq(4)').text();
        ubicacion = fila.find('td:eq(5)').text();
        obs = fila.find('td:eq(6)').text();

        $("#umedida").val(id_umedida);
        $("#nom_cons").val(nom_cons);
        $("#cantidad").val(cantidad);
        $("#ubicacion").val(ubicacion);
        $("#obs").val(obs);

        opcion = 2; //editar

       
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Insumo");
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

                url: "bd/crudinsumoop.php",
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
      
        var nom_cons = $.trim($("#nom_cons").val());
        var cantidad = $.trim($("#cantidad").val());
       
        var umedida = $.trim($("#umedida").val());
        var ubicacion = $.trim($("#ubicacion").val());
      
        var obs = $.trim($("#obs").val());
       

      
        


        if (nom_cons.length == 0 || umedida.length == 0  ) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Prospecto",
                icon: 'warning',
            })
            return false;
        } else {
           
            $.ajax({
                url: "bd/crudinsumoop.php",
                type: "POST",
                dataType: "json",
                data: {  umedida: umedida, nom_cons: nom_cons, cantidad: cantidad, id: id, opcion: opcion, ubicacion: ubicacion, obs: obs },
                success: function(data) {
                    
                    id=data[0].id_cons
                    umedida = data[0].id_umedida;
                    nom_umedida = data[0].nom_umedida;
                    nom_cons = data[0].nom_cons;
                    cantidad= data[0].cant_cons;
                    ubicacion= data[0].ubi_cons;
                    obs= data[0].obs_cons;
                    if (opcion == 1) {
                        tablaVis.row.add([id, nom_cons,nom_umedida, umedida,  cantidad,ubicacion,obs,]).draw();
                    } else {
                        tablaVis.row(fila).data([id, nom_cons,nom_umedida, umedida,  cantidad,ubicacion,obs,]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

    //MOVIMIENTOS DE INVENTARIO
    
    $(document).on('click', '.btnMov', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())
    
        nombre = fila.find('td:eq(1)').text()
        saldo = fila.find('td:eq(4)').text()
        
    
        $('#id').val(id)
        $('#nmaterial').val(nombre)
    
        $('#extact').val(saldo)
       
        $('.modal-header').css('background-color', '#007bff')
        $('.modal-header').css('color', 'white')
        $('.modal-title').text('Movimiento de Inventario')
        $('#modalMOV').modal('show')
      })
    
      $('#formMov').submit(function (e) {
        e.preventDefault();
        var id = $.trim($('#id').val());
        var descripcion = $('#descripcion').val();
        var tipomov = $.trim($('#tipomov').val());
        var saldo = $('#extact').val();
        var montomov = $('#montomov').val();
        var saldofin = 0;
    
    
    
        if (id.length == 0 || tipomov.length == 0 || montomov.length == 0) {
          Swal.fire({
            title: 'Datos Faltantes',
            text: 'Debe ingresar todos los datos de la cuenta',
            icon: 'warning',
          })
          return false
        } else {
          switch (tipomov) {
            case 'Entrada':
              saldofin = parseFloat(saldo) + parseFloat(montomov);
              $.ajax({
                url: 'bd/crudmovimientoinvin.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: id,
                  tipomov: tipomov,
                  saldo: saldo,
                  saldofin: saldofin,
                  montomov: montomov,
                  descripcion: descripcion
                },
                success: function (data) {
                  if (data == 3) {
                    Swal.fire({
                      title: 'Operación Exitosa',
                      text: 'Movimiento Guardado',
                      icon: 'success',
                    })
                    $('#modalMOV').modal('hide');
                    window.location.reload();
                  } else {
                    Swal.fire({
                      title: 'No fue posible cocluir la operacion',
                      text: 'Movimiento No Guardado',
                      icon: 'error',
                    })
                  }
                },
              })
    
              break
            case 'Salida':
              saldofin = parseFloat(saldo) - parseFloat(montomov);
              $.ajax({
                url: 'bd/crudmovimientoinvin.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  id: id,
                  tipomov: tipomov,
                  saldo: saldo,
                  saldofin: saldofin,
                  montomov: montomov,
                  descripcion: descripcion
                },
                success: function (data) {
                  if (data == 3) {
                    Swal.fire({
                      title: 'Operación Exitosa',
                      text: 'Movimiento Guardado',
                      icon: 'success',
                    })
                    window.location.reload()
                    $('#modalMOV').modal('hide');
                    window.location.reload();
                  } else {
                    Swal.fire({
                      title: 'No fue posible cocluir la operacion',
                      text: 'Movimiento No Guardado',
                      icon: 'error',
                    })
                  }
                },
              })
              break
            case 'Inventario Inicial':
              //Advertir y preguntar
              swal
                .fire({
                  title: 'Inventario Inicial',
                  text:
                    'Este movimiento cambia las Existencias totales del Producto por la cantidad establecida sin importar los movimientos anteriores ¿Desea Continuar?',
    
                  showCancelButton: true,
                  icon: 'warning',
                  focusConfirm: true,
                  confirmButtonText: 'Aceptar',
    
                  cancelButtonText: 'Cancelar',
                })
                .then(function (isConfirm) {
                  if (isConfirm.value) {
                    saldofin = montomov;
    
                    $.ajax({
                      url: 'bd/crudmovimientoinvin.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        id: id,
                        tipomov: tipomov,
                        saldo: saldo,
                        saldofin: saldofin,
                        montomov: montomov,
                        descripcion: descripcion
                      },
                      success: function (data) {
                        if (data == 3) {
                          Swal.fire({
                            title: 'Operación Exitosa',
                            text: 'Movimiento Guardado',
                            icon: 'success',
                          })
                          $('#modalMOV').modal('hide');
                          window.location.reload();
                        } else {
                          Swal.fire({
                            title: 'No fue posible cocluir la operacion',
                            text: 'Movimiento No Guardado',
                            icon: 'error',
                          })
                        }
                      },
                    })
                  } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                  }
                })
    
              break
          }
        }
      })
    
      $(document).on('click', '.btnKardex', function () {
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())
        window.location='cntamovin.php?id='+id;
        
    
        
    })

});