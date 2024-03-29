$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    tablaVis = $('#tablaV').DataTable({
      dom:
      "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Progreso de Ordenes',
          className: 'btn bg-success ',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5,6,7,8,9],
            /*format: {
              body: function (data, row, column, node) {
                if (column === 5) {
                  return data.replace(/[$,]/g, '')
                } else if (column === 6) {
                  return data
                } else {
                  return data
                }
              },
            },*/
          },
        },
        {
          extend: 'pdfHtml5',
          text: "<i class='far fa-file-pdf'> PDF</i>",
          titleAttr: 'Exportar a PDF',
          title: 'Progreso de Ordenes',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5,6,7,8,9] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
                 
                  return data
                } else {
                  return data
                }
              },
            },
        },
      ],
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'>\
              </div>",
  
              //
        },
        { className: "btfecha editable", "targets": [7] },
        { className: "btFolio editable", "targets": [2] },
        { targets: [6], type: 'num-html' },{
          targets: 4,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
  
        },
      {
          targets: 5,
          render: function (data, type, full, meta) {
            return "<div class='text-wrap width-200'>" + data + '</div>'
            //return "<div class='text-wrap width-200'>" + data + '</div>'
          },
  
        },
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
  
      rowCallback: function (row, data) {
        $($(row).find('td')['8']).css('color', 'white')
        $($(row).find('td')['8']).addClass('text-center')
        $($(row).find('td')['7']).addClass('text-center')
        fecha = new Date(data[5]).getTime()
        fechaactual = new Date().getTime()
        
  
        dias = parseInt(fecha - fechaactual) / (1000 * 60 * 60 * 24)
        avance = data[7]
  
        barra =
          "<div class='progress mb-3 ' style='width:120px' > \
                <div class='progress-bar bg-success' role='progressbar' aria-valuenow='" +
          avance +
          "' aria-valuemin='0' aria-valuemax='100' style='width:" +
          avance +
          "%'> \
                <span class='text-light text-center'>" +
          avance +
          '%</span> \
                </div> \
                </div>'
  
        $($(row).find('td')[7]).html(barra)
        estadoord=data[8];

  
        if (data[8] == 'MEDICION') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[8]).addClass('bg-gradient-warning')
          //$($(row).find('td')['8']).text('PENDIENTE')
        } else if (data[8] == 'CORTE') {
          //$($(row).find("td")[8]).css("background-color", "blue");
          $($(row).find('td')[8]).addClass('bg-gradient-secondary')
          //$($(row).find('td')['8']).text('ENVIADO')
        } else if (data[8] == 'ENSAMBLE') {
          //$($(row).find("td")[8]).css("background-color", "success");
          $($(row).find('td')[8]).addClass('bg-lightblue')
          //$($(row).find('td')['8']).text('ACEPTADO')
        } else if (data[8] == 'PULIDO') {
          //$($(row).find("td")[8]).css("background-color", "purple");
          $($(row).find('td')[8]).addClass('bg-gradient-purple')
          //$($(row).find('td')['8']).text('EN ESPERA')
        } else if (data[8] == 'COLOCACION') {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
  
          $($(row).find('td')[8]).addClass('bg-gradient-orange')
          //$($(row).find('td')['8']).text('EDITADO')
        } else if (data[8] == 'PROCESANDO'){
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[8]).addClass('bg-gradient-warning')
          //$($(row).find('td')['8']).text('RECHAZADO')
        }
        else if(data[8]=="LIBERADO") {
          $($(row).find('td')[8]).addClass('bg-gradient-success')
        }
        else if(data[8]=="ACTIVO") {
          $($(row).find('td')[8]).addClass('bg-gradient-primary')
        }
      },
    })
  
    var fila //capturar la fila para editar o borrar el registro

 
    $("#btnBuscar").click(function() {
      window.location.href = "rptordenm.php?inicio=" + $('#inicio').val()+"&fin="+$('#fin').val();
    
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
  