$(document).ready(function () {
    var id, opcion
    opcion = 4

  

  
    tablaVis = $('#tablaV').DataTable({
      dom:
        "<'row justify-content-center'<'col-sm-12 col-md-4 form-group'l><'col-sm-12 col-md-4 form-group'B><'col-sm-12 col-md-4 form-group'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        columnDefs: [
            {
              targets: -1,
              data: null,
              defaultContent:
                "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar'><i class='fas fa-edit'></i></button>\
             </div>",
            },
          ],
       
    
      buttons: [
        {
          extend: 'excelHtml5',
          text: "<i class='fas fa-file-excel'> Excel</i>",
          titleAttr: 'Exportar a Excel',
          title: 'Presupuesto de Costos',
          className: 'btn bg-success ',
          footer: true,
          exportOptions: {
            columns: [0, 1, 2, 3, 4,],
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
          title: 'Presupuesto de Costos',
          footer: true,
          className: 'btn bg-danger',
          exportOptions: { columns: [0, 1, 2, 3, 4,] },
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
  



      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        // Total over all pages
        pres = api
            .column( 2 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            eje = api
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            dif = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

        // Update footer
        $( api.column( 2 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((pres + Number.EPSILON) * 100) / 100) 
        );
        $( api.column( 3 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((eje + Number.EPSILON) * 100) / 100) 
        );
        $( api.column( 4 ).footer() ).html(
            '$'+ new Intl.NumberFormat('es-MX').format(Math.round((dif + Number.EPSILON) * 100) / 100) 
        );
        }
    });
  
    $("#btnconsulta").click(function() {
        mes = $("#mes").val();
        ejercicio = $("#ejercicio").val();
        window.location.href = "cntaprescto.php?mes=" + mes + "&ejercicio=" + ejercicio;

    });

    $(document).on("click", ".btnEditar", function(e) {
        e.preventDefault()

        fila = $(this).closest("tr");
        id = parseInt(fila.find("td:eq(0)").text());
        partida = fila.find("td:eq(1)").text();
        pres = fila.find("td:eq(2)").text();
        $("#formPres").trigger("reset");
        $("#idpartida").val(id);
        $("#partida").val(partida);
        $("#monto").val(pres);
        $("#modalPres").modal("show");

    });
    $(document).on("click", "#bguardarpres", function(e) {
       
      
        
        partida =  $("#idpartida").val();
        mes =  $("#nmes").val();
        ejercicio =  $("#nejercicio").val();
        monto =  $("#monto").val();
        pres = fila.find("td:eq(2)").text();
        $.ajax({
            type: 'POST',
            url: 'bd/prescto.php',
            dataType: 'json',
      
            data: {
              partida: partida,
              mes: mes,
              ejercicio: ejercicio,
              monto: monto,
              
            },
            success: function (data) {
                if (data==1){
                    window.location.reload()
                }
              
            },
          })

    });
  })
  

