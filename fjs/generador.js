$(document).ready(function () {
    var id, opcion, fpago;
    jQuery.ajaxSetup({
      beforeSend: function() {
          $("#div_carga").show();
      },
      complete: function() {
          $("#div_carga").hide();
      },
      success: function() {},
  }); 
  
 
  
    tablaD = $('#tablaD').DataTable({
      paging: false,
      ordering: false,
      info: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'><div class='btn-group'><button class='btn btn-sm btn-danger btnEliminarcom'><i class='fas fa-trash'></i></button></div></div>",
        }, { className: 'hide_column', targets: [0] },
        { className: 'hide_column', targets: [1] },
        { className: 'text-center', targets: [2] },
        { className: 'text-center', targets: [3] }
        
      ],
  
      //Para cambiar el lenguaje a español
      language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        zeroRecords: 'No se encontraron resultados',
        info:
          'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
        infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
        infoFiltered: '(filtrado de un total de _MAX_ registros)',
        sSearch: 'Buscar:',
        oPaginate: {
          sFirst: 'Primero',
          sLast: 'Último',
          sNext: 'Siguiente',
          sPrevious: 'Anterior',
        },
        sProcessing: 'Procesando...',
      },
    })
  


  
  


    function nomensaje() {
      swal.fire({
        title: 'No existen Inventario suficiente',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
  

    




    $(document).on('click', '#btnAddcom', function ()  {
      //window.location.href = "prospecto.php";
      $('#formCom').trigger('reset')
     
      $('#modalCom').modal('show')
  
  })

  $(document).on('click', '.btnEliminarcom', function (event) {
     
    event.preventDefault();

    fila = $(this)
    id =  parseInt($(this).closest("tr").find("td:eq(0)").text());
    opcion=2;

    swal
    .fire({
        title: "Borrar",
        text: "¿Realmente desea borrar este elemento?",

        showCancelButton: true,
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Aceptar",

        cancelButtonText: "Cancelar",
    })
    .then(function(isConfirm) {
        if (isConfirm.value) {
            $.ajax({
                url: "bd/detallegenerador.php",
                type: "POST",
                dataType: "json",
                async: false,
                data: { id: id, opcion: opcion },
                success: function(data) {
                
                    if (data == 1) {
                      
                        tablaD.row(fila.parents("tr")).remove().draw();
                        
                    }
                },
            });
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {}
    });
  })


    $(document).on('click', '#btnGuardarcom', function () {
      idconcepto=$('#concepto').val();
      generador=$('#idgen').val();
      concepto=$('#concepto option:selected').text();
      cantidad=$('#cantcom').val();
      opcion=1;
       
      if (generador.length != 0 && cantidad.length != 0 &&  idconcepto.length!=0 && concepto.length!=0) {
       
       
       
        $.ajax({
          type: 'POST',
          url: 'bd/detallegenerador.php',
          dataType: 'json',
        
          data: {
            generador: generador,
            idconcepto: idconcepto,
            concepto: concepto,
            cantidad: cantidad,
            opcion: opcion,
          },
          success: function (data) {
            console.log(data);

            if (data==0){
                mensajeduplicado();
                return 0;
            }
            else{
                id_reg = data[0].id_reg
                idconcepto = data[0].id_concepto
                concepto = data[0].nom_concepto
                cantidad = data[0].cantidad
                tablaD.row
                  .add([
                    id_reg,
                    idconcepto,
                    concepto,
                    cantidad,
                    
                  ])
                  .draw()
                  $('#modalCom').modal('hide')
            }
           
          },
        })
      } else {
        Swal.fire({
          title: 'Datos Faltantes',
          text: 'Debe ingresar todos los datos del Complemento',
          icon: 'warning',
        })
        return false
      }
    })
  
  
  
    function mensajeduplicado() {
        swal.fire({
          title: 'El concepto ya se encuentra en la lista',
          icon: 'error',
          focusConfirm: true,
          confirmButtonText: 'Aceptar',
        })
      }
  
  
    function limpiar() {
      $('#nombre').val('')
      $('#area').val('')
      $('#areacol').val('')
      $('#supervisor').val('')
      $('#colocador').val('')
    }
  
    function mensajeerror() {
      swal.fire({
        title: 'Operacion No exitosa',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }


/*MODIFICAR PARA GUARDAR GENERADOR */
    $(document).on("click", "#btnGuardar", function() {
      
        folio = $("#idgen").val();
        fecha = $("#fechagen").val();
        descripcion=$("#nombre").val();
        area=$("#areacol").val();
        inicio=$("#fechaini").val();
        fin=$("#fechafin").val();
        tokenid = $("#tokenid").val();
        idorden=$('#folioorden').val()
       
        generador=$("#foliogen").val();
       
        
        opcion = 2;

        if (
            descripcion.length != 0 &&
            area.length != 0 &&
            inicio.length != 0 &&
            fin.length != 0 &&
            tablaD.data().any()
        ) {
            $.ajax({
                type: "POST",
                url: "bd/tmpgen.php",
                dataType: "json",
                //async: false,
                data: {
                    folio: folio,
                    fecha: fecha,
                    descripcion: descripcion,
                    area: area,
                    inicio: inicio,
                    fin: fin,
                    tokenid: tokenid,
                    opcion: opcion,
                    
                },
                success: function(res) {
                    if (res == 0) {
                        Swal.fire({
                            title: "Error al Guardar",
                            text: "No se puedo guardar los datos del cliente",
                            icon: "error",
                        });
                    } else {
                        /* MODIFICAR O GUARDAR NUEVO PRESUPUESTO*/
                        if (generador == 0) {
                            $.ajax({
                                type: "POST",
                                url: "bd/trasladogen.php",
                                dataType: "json",
                               //async: false,
                                data: { folio: folio,idorden: idorden },
                                success: function(res) {
                                    if (res == 0) {
                                        Swal.fire({
                                            title: "Error al Guardar",
                                            text: "No se puedo guardar los datos",
                                            icon: "error",
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Operación Exitosa",
                                            text: "Guardado",
                                            icon: "success",
                                        });
                                        window.setTimeout(function() {
                                          window.location.href = "detallefrente.php?id=" + $('#idarea').val();
                                      }, 1000);
                                    }
                                },
                            });
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "bd/modificargen.php",
                                dataType: "json",
                                //async: false,
                                data: { folio: folio, generador: generador,idorden: idorden },
                                success: function(res) {
                                    if (res == 0) {
                                        Swal.fire({
                                            title: "Error al Guardar",
                                            text: "No se puedo guardar los datos del cliente",
                                            icon: "error",
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Operación Exitosa",
                                            text: "Modificado",
                                            icon: "success",
                                        });
                                        window.setTimeout(function() {
                                          window.location.href = "detallefrente.php?id=" + $('#idarea').val();
                                      }, 1000);
                                  
                                        
                                    }
                                },
                            });
                        }
                    }
                },
            });
        } else {
            Swal.fire({
                title: "No es posible Guardar",
                text: "Revise sus datos, es posible que no haya capturado toda la información",
                icon: "error",
            });
        }
    });

  })
  