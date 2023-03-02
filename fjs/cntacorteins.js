$(document).ready(function () {
    var id, opcion
    opcion = 4
  
    var textcolumnas = permisos()
  
    function permisos() {
      var tipousuario = $('#tipousuario').val()
      var columnas = ''
  
      if (tipousuario == 5) {
        columnas =
          "<div class='text-center'>\
            <button class='btn btn-sm bg-gradient-primary text-light btnMov' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa-solid fa-magnifying-glass'></i></button>\
           </div>"
      } else {
        columnas =
          "<div class='text-center'>\
            <button class='btn btn-sm bg-gradient-primary text-light btnMov' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa-solid fa-magnifying-glass'></i></button>\
           </div>"
      }
      return columnas
    }
  
    tablaVis = $('#tablaV').DataTable({
      stateSave: true,
      orderCellsTop: true,
      fixedHeader: true,
      paging: false,
      ordering: false,
      searching: false,
  
      columnDefs: [
        {
          targets: -1,
          data: null,
          defaultContent: textcolumnas,
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
  
      rowCallback: function (row, data) {
        if (data[5] == 2) {
          $($(row).find('td')).addClass('bg-gradient-success')
        } else {
            $($(row).find('td')).addClass('bg-gradient-warning')
        }
      },
    })
  
    $('#btnNuevo').click(function () {
        window.location.href="corteins.php"
    })

    $('.btnMov').click(function(){
        fila = $(this).closest('tr')
        id = parseInt(fila.find('td:eq(0)').text())
        window.location.href="corteins.php?folio="+id
    })
  
    var fila //capturar la fila para editar o borrar el registro
 
  })
  