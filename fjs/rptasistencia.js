$(document).ready(function () {
    var id, opcion
    opcion = 4
    
    
   
  
  
    tablaVis = $('#tablaV').DataTable({
     
      searching: false,
      info: false,
    fixedHeader: true,
    paging:false,
    ordering:false,
      
  
      
  
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
  


    });
  

  
    var fila //capturar la fila para editar o borrar el registro
  
     //botón VER
  $(document).on('click', '#btnBuscar', function () {
    inicio = $("#inicio").val();
    fin = $("#fin").val();

    window.location.href = 'rptasistencia.php?inicio=' + inicio + '&fin=' + fin
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
  
  
    $("#btnconsulta").click(function() {
      mes = $("#mes").val();
      ejercicio = $("#ejercicio").val();
      window.location.href = "rptorden.php?mes=" + mes + "&ejercicio=" + ejercicio;

  });
  })
  

