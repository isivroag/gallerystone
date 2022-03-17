$(document).ready(function () {

    const MAXIMO_TAMANIO_BYTES = 12000000;
    var opcion;

    $(document).on('click', '#btnAddplano', function ()  {
        //window.location.href = "prospecto.php";
        $('#formMapa').trigger('reset')
       
        $('#modalMAPA').modal('show')
    
    })


    
    $("#archivo").on('change', function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    
      })


      
      $(document).on('click', '#btnGuardar', function () {
        
        orden=$('#folioorden').val()
        folio=orden
        foliofis=$('#foliof').val()
        material=$('#material').val()
        moldura=$('#moldura').val()
        zoclo=$('#zoclo').val()
        superficie=$('#superficie').val()
        tipo=$('#tipo').val()
        obs=$('#obs').val()
        idot=$('#idot').val()
         usuario = $('#nameuser').val()
        opcion=1
        $.ajax({
            url: "bd/crudot.php",
            type: "POST",
            dataType: "json",
            async: false,
            data: { orden: orden,foliofis: foliofis,material: material,moldura: moldura, zoclo: zoclo, superficie: superficie,tipo: tipo,obs: obs, idot: idot, opcion: opcion,usuario: usuario },
            success: function(data) {
            
                if (data == 1) {
                    Swal.fire({
                        title: 'Registro Actualizado',
                        text: "La orden de Trabajo ha sido actualizada",
                        icon: 'success',
                    })
                    estado = 'CORTE'
                    porcentaje=5;
                
                    $.ajax({
                      url: 'bd/estadoorden.php',
                      type: 'POST',
                      dataType: 'json',
                      data: {
                        folio: folio,
                        estado: estado,
                        porcentaje: porcentaje
                      },
                      success: function (res) {
                        if (res == 1) {
                          
                          window.location.href = 'cntaorden.php'
                        } else {
                          Swal.fire({
                            title: 'Registro No actualizado',
                            text: "La orden de Trabajo no ha sido actualizada",
                            icon: 'error',
                        })
                        }
                      },
                    })
                   
                    
                }
            },
        });


      })
      $(document).on('click', '#upload', function () {
        
        orden=$('#folioorden').val();
        var formData = new FormData();
        var files = $('#archivo')[0].files[0];
        
        if (files.size > MAXIMO_TAMANIO_BYTES) {
          const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
         
    
          Swal.fire({
            title: 'El tamaño del archivo es muy grande',
            text: "El archivo no puede exceder los "+ tamanioEnMb+"MB",
            icon: 'warning',
        })
          // Limpiar
          $("#archivo").val();
        }
        else {
          formData.append('file', files);
          formData.append('orden',orden)
          $.ajax({
            url: 'bd/uploadot.php',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              if (response != 0) {
                Swal.fire({
                  title: 'Imagen Guardada',
                  text: "Se anexo el documento a la Orden",
                  icon: 'success',
              })
              $("#modalMAPA").modal("hide");
              window.location.href = "ot.php?folio="+ orden;
                //respuesta exitosa
              } else {
                //swal incorrecto
                Swal.fire({
                  title: 'Formato de Imagen Incorrecto',
                  text: "El archivo no es una imagen ",
                  icon: 'warning',
              })
    
              }
            }
          });
        }
    
        return false;
      });
})
