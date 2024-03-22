$(document).ready(function () {
    var id, opcion
    opcion = 4
    
   
    $('#tablaV thead tr').clone(true).appendTo( '#tablaV thead' );
    $('#tablaV thead tr:eq(1) th').each( function (i) {


        var title = $(this).text();


        $(this).html( '<input class="form-control form-control-sm" type="text" placeholder="'+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
          
          if (i==6){

            
            valbuscar=this.value;
          }else{
            valbuscar=this.value;

          }
          
            if ( tablaVis.column(i).search() !== valbuscar ) {
                tablaVis
                    .column(i)
                    .search( valbuscar,true,true )
                    .draw();
            }
        } );
    } );
  
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        columnDefs: [
            { targets: [7], type: 'num-html' },
          {
            targets: 4,
            render: function (data, type, full, meta) {
              return "<div class='text-wrap width-200'>" + data + '</div>'
              //return "<div class='text-wrap width-200'>" + data + '</div>'
            },
          },
          {
            targets: -1,
            data: null,
            defaultContent:
              "<div class='text-center'><button class='btn btn-sm btn-primary btnVer' data-toggle='tooltip' data-placement='top' title='Detalle'><i class='fa-solid fa-magnifying-glass-dollar'></i></button>\
                </div>",
    
                //
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
      orderCellsTop: true,
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
        $($(row).find('td')['8']).css('color', 'white')
        $($(row).find('td')['8']).addClass('text-center')
        //$($(row).find('td')['7']).addClass('text-right')
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
        
  
  
        if (data[8] == 'MEDICION') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[8]).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (data[8] == 'CORTE') {
          //$($(row).find("td")[8]).css("background-color", "blue");
          $($(row).find('td')[8]).addClass('bg-gradient-secondary')
          //$($(row).find('td')['7']).text('ENVIADO')
        } else if (data[8] == 'ENSAMBLE') {
          //$($(row).find("td")[8]).css("background-color", "success");
          $($(row).find('td')[8]).addClass('bg-lightblue')
          //$($(row).find('td')['7']).text('ACEPTADO')
        } else if (data[8] == 'PULIDO') {
          //$($(row).find("td")[8]).css("background-color", "purple");
          $($(row).find('td')[8]).addClass('bg-gradient-purple')
          //$($(row).find('td')['7']).text('EN ESPERA')
        } else if (data[8] == 'COLOCACION') {
          //$($(row).find("td")[5]).css("background-color", "light-blue");
  
          $($(row).find('td')[8]).addClass('bg-gradient-orange')
          //$($(row).find('td')['7']).text('EDITADO')
        } else if (data[8] == 'PROCESANDO'){
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[8]).addClass('bg-gradient-warning')
          //$($(row).find('td')['7']).text('RECHAZADO')
        }
        else if(data[8]=="LIBERADO") {
          $($(row).find('td')[8]).addClass('bg-gradient-success')
        }
        else if(data[8]=="ACTIVO") {
          $($(row).find('td')[8]).addClass('bg-gradient-primary')
        }
      },


    
    });
  
    $(document).on('click', '.btnVer', function () {
      fila = $(this).closest('tr')
      id = parseInt(fila.find('td:eq(1)').text())
  
      window.location.href = 'ordensum.php?folio=' + id
    })
  
    var fila //capturar la fila para editar o borrar el registro
  
    //botón EDITAR

 
  
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

    $('#btnconsulta').click(function () {
        var inicio = $('#ini').val()
        var final = $('#final').val()
        var tipof=$('#tipof').val()
        console.log(inicio);
        console.log(final);
    
      
    
        tablaVis.clear()
        tablaVis.draw()
    
     
    
        if (inicio != '' && final != '') {
          $.ajax({
            type: 'POST',
            url: 'bd/buscarordenesobra.php',
            dataType: 'json',
            data: { inicio: inicio, final: final,tipof: tipof },
            success: function (data) {
              for (var i = 0; i < data.length; i++) {
                console.log(data)
                folio = data[i].folio_ord;
                folio_vta = data[i].folio_vta;
                fecha_ord = data[i].fecha_ord;
                cliente = data[i].nombre;
                concepto = data[i].concepto_vta;
                
                fecha_limite = data[i].fecha_limite;
                tipop = data[i].tipop;
                avance = data[i].avance;
                edo_ord = data[i].edo_ord;
               
               fecha_liberacion = data[i].fecha_liberacion;
                
                
                
                tablaVis.row
                  .add([
                    folio,
                    folio_vta,
                    fecha_ord,
                    cliente,
                    concepto,
                    fecha_limite,
                    tipop,
                    avance,
                    edo_ord,
                    fecha_liberacion
                  ])
                  .draw()
    
                //tabla += '<tr><td>' + res[i].id_objetivo + '</td><td>' + res[i].desc_objetivo + '</td><td class="text-center">' + icono + '</td><td class="text-center"></td></tr>';
              }
            },
          })
        } else {
          alert('Selecciona ambas fechas')
        }
      })
  
  
 
  })
  

