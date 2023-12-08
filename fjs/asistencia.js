$(document).ready(function () {
    var id, opcion
    opcion = 4
    
    
   
  
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [ {
          targets: -1,
          data: null,
          defaultContent:
            "<div class='text-center'>\
              <button class='btn btn-sm btn-primary btnasistencia' data-toggle='tooltip' data-placement='top' title='Detalle'>\
                <i class='fa-solid fa-list-check'></i>\
              </button>\
            </div>",
        },
          
          {
            targets: [0,3],
           className:'hide_column'
          }
         
         
         
        ],
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Reporte de Presupuestos',
          className: 'btn bg-success ',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5,6],
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
          title: 'Reporte de Presupuestos',
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4, 5,6] },
          format: {
              body: function (data, row, column, node) {
                if (column === 6) {
                  /*switch (data) {
                    case '0':
                      return data.replace(0, 'RECHAZADO')
  
                      break
                    case '1':
                      return data.replace('1', 'PENDIENTE')
                      break
                    case '2':
                      return data.replace('2', 'ENVIADO')
                      break
                    case '3':
                      return data.replace('3', 'ACEPTADO')
                      break
                    case '4':
                      return data.replace('4', 'EN ESPERA')
                      break
                    case '5':
                      return data.replace('5', 'EDITADO')
                      break
                  }*/
                  return data
                } else {
                  return data
                }
              },
            },
        },
      ],
      stateSave: true,
      ordering: false,
    fixedHeader: true,
    paging:false,
      
  
      
  
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
 
      rowCallback: function (row, data) {
        $($(row).find('td')['4']).css('color', 'white')
        $($(row).find('td')['4']).addClass('text-center')
        
        
        
        
  
  
        if (data[4] == 'NR') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[4]).addClass('bg-gradient-lightblue');
          //$($(row).find('td')['4']).text('PENDIENTE')
        } else if (data[4] == 'ASISTENCIA') {
          //$($(row).find("td")[4]).css("background-color", "blue");
          $($(row).find('td')[4]).addClass('bg-gradient-success')
          //$($(row).find('td')['7']).text('ENVIADO')
        } else if (data[4] == 'FALTA') {
          //$($(row).find("td")[4]).css("background-color", "success");
          $($(row).find('td')[4]).addClass('bg-gradient-danger')
          //$($(row).find('td')['7']).text('ACEPTADO')
        } else if (data[4] == 'RETARDO') {
          //$($(row).find("td")[4]).css("background-color", "purple");
          $($(row).find('td')[4]).addClass('bg-gradient-warning')
          //$($(row).find('td')['7']).text('EN ESPERA')
        }  else if (data[4] == 'FALTA JUSTIFICADA') {
          //$($(row).find("td")[4]).css("background-color", "purple");
          $($(row).find('td')[4]).addClass('bg-gradient-info')
          //$($(row).find('td')['7']).text('EN ESPERA')
        }  else if (data[4] == 'NO CHECO') {
          //$($(row).find("td")[4]).css("background-color", "purple");
          $($(row).find('td')[4]).addClass('bg-gradient-danger')
          //$($(row).find('td')['7']).text('EN ESPERA')
        } 
      },

   
    });
  

    $("#btnconsulta").click(function() {
        fecha = $("#fecha").val();
       
        window.location.href = "asistencia.php?fecha=" + fecha ;
  
    });
  
    var fila //capturar la fila para editar o borrar el registro
  
     //botón VER
  $(document).on('click', '.btnasistencia', function () {
    fecha = $("#fecha").val();
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())
    idper=parseInt(fila.find('td:eq(1)').text())
    persona=fila.find('td:eq(2)').text()
    tipo=fila.find('td:eq(3)').text()

    $('#idreg').val(id)
    $('#idper').val(idper)
    $('#nombre').val(persona)

    $('#fecha2').val(fecha)
    $('#tipo').val(tipo)


    $("#modalAsistencia").modal("show");

  })


  $(document).on('click', '#btnGuardar', function () {
    fecha = $("#fecha2").val();
    id = $("#idreg").val();
    idper = $("#idper").val();
    tipo = $("#tipo").val();
    var selectElement = document.getElementById("tipo");

    tipon = selectElement.options[selectElement.selectedIndex].text;
    if (id==0){
      opcion=1
    }else{
      opcion=2
    }


    $.ajax({
      url: "bd/asistencia.php",
      type: "POST",
      dataType: "json",
      data: { fecha: fecha, idper: idper, id: id, tipo: tipo, tipon: tipon,  opcion: opcion },
      success: function (data) {
          if (data==1){
            window.location.reload();
          }

          
      }
  });
   

   
  })


 
  
    function startTime() {
      var today = new Date()
      var hr = today.getHours()
      var min = today.getMinutes()
      var sec = today.getSeconds()
      //Add a zero in front of numbers<10
      min = checkTime(min)
      sec = checkTime(sec)
      document.getElementById('clock').innerHTML = hr + ' : ' + min + ' : ' + sec
      var time = setTimeout(function () {
        startTime()
      }, 500)
    }
  
    function checkTime(i) {
      if (i < 10) {
        i = '0' + i
      }
      return i
    }
  
  
 
  })
  

