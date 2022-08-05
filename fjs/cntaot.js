$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'>\
              <button class='btn btn-sm btn-primary btnCortar' data-toggle='tooltip' data-placement='top' title='Ver Ot'><i class='fas fa-search'></i></button>\
              </div>",
  
              //
        },
     
      {
          targets: 6,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
  
        },
        { className: "hide_column", "targets": [0] },
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
      stateSave: true,
      orderCellsTop: true,
      fixedHeader: true,
      paging: false,
  
    
    })
  
    var fila //capturar la fila para editar o borrar el registro
    

  
  

    //NUEVO CORTE
    $(document).on('click', '.btnCortar', function () {
      fila = $(this).closest('tr')
      folio = parseInt(fila.find('td:eq(1)').text())
      estado = fila.find('td:eq(10)').text()

        window.setTimeout(function() {
          window.location.href="otr.php?folio="+folio
      }, 2000);
       
      
      
    })




    $("#btnBuscar").click(function() {
        var inicio = $("#inicio").val();
        var final = $("#final").val();
       

     
        tablaVis.clear();
        tablaVis.draw();

     

        if (inicio != "" && final != "") {
            $.ajax({
                type: "POST",
                url: "bd/buscarot.php",
                dataType: "json",
                data: { inicio: inicio, final: final},
                success: function(data) {

                    for (var i = 0; i < data.length; i++) {
                        tablaVis.row
                            .add([
                                data[i].id_ot,
                                data[i].folio_orden,
                                data[i].folio_vta,
                                data[i].fecha_ord,
                                data[i].fecha_ot,
                                data[i].nombre,
                                data[i].concepto_vta,
                            ])
                            .draw();

                        //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
                    }
                },
            });
        } else {
            alert("Selecciona ambas fechas");
        }
    });
    function mensaje() {
      swal.fire({
        title: 'Orden de Servicio Actualizada',
        icon: 'success',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
    function nomensaje() {
      swal.fire({
        title: 'No fue posible actualizar la Orden',
        icon: 'error',
        focusConfirm: true,
        confirmButtonText: 'Aceptar',
      })
    }
  
    function filterFloat(evt, input) {
      // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
      var key = window.Event ? evt.which : evt.keyCode
      var chark = String.fromCharCode(key)
      var tempValue = input.value + chark
      var isNumber = key >= 48 && key <= 57
      var isSpecial = key == 8 || key == 13 || key == 0 || key == 46
      if (isNumber || isSpecial) {
        return filter(tempValue)
      }
    
      return false
    }
    function filter(__val__) {
      var preg = /^([0-9]+\.?[0-9]{0,2})$/
      return preg.test(__val__) === true
    }
  
  })
  