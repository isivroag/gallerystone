$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({



        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<div class='text-center'><button class='btn btn-sm btn-primary btnVer'><i class='fas fa-search'></i></button>\
            <button class='btn btn-sm btn-success btnMedir'><i class='fas fa-ruler-combined'></i></button></div>"
        },{"targets": [7],"type": "num-html"}],

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
        },
        stateSave: true,
      orderCellsTop: true,
    fixedHeader: true,
    paging:false,

    rowCallback: function (row, data) {
        $($(row).find('td')['8']).css('color', 'white')
        $($(row).find('td')['8']).addClass('text-center')
        $($(row).find('td')['7']).addClass('text-center')
        fecha=new Date(data[6]).getTime();;
        fechaactual=new Date().getTime();;
        console.log(data[7]);
     
        dias=parseInt( fecha-fechaactual)/(1000*60*60*24);
        avance=data[7];

        barra="<div class='progress mb-3 ' style='width:120px' > \
              <div class='progress-bar bg-success' role='progressbar' aria-valuenow='"+avance+"' aria-valuemin='0' aria-valuemax='100' style='width:"+avance+ "%'> \
              <span class='text-light text-center'>"+avance+ "%</span> \
              </div> \
              </div>"
              

        $($(row).find('td')[7]).html(barra)
        
        if (dias<6){
            $($(row).find('td')).addClass('bg-gradient-warning blink_me')  
            $($(row).find('td')[6]).addClass('text-danger text-bold')  
            
        }
  
        if (data[8] == 'MEDICION') {
          //$($(row).find("td")[6]).css("background-color", "warning");
          $($(row).find('td')[8]).addClass('bg-gradient-warning')
          //$($(row).find('td')['9']).text('PENDIENTE')
        } else if (data[8] == 'CORTE') {
          //$($(row).find("td")[9]).css("background-color", "blue");
          $($(row).find('td')[8]).addClass('bg-gradient-primary')
          //$($(row).find('td')['9']).text('ENVIADO')
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
          
          $($(row).find('td')[8]).addClass('bg-gradient-success')
          //$($(row).find('td')['8']).text('EDITADO')
        } else {
          //$($(row).find("td")[5]).css("background-color", "red");
          $($(row).find('td')[8]).addClass('bg-gradient-danger')
          //$($(row).find('td')['8']).text('RECHAZADO')
        }
      }
    });


    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR    
    $(document).on("click", ".btnVer", function() {
        fila = $(this).closest("tr");
        id = parseInt(fila.find('td:eq(1)').text());

        window.location.href = "orden.php?folio=" + id;
      

    });

    $(document).on("click", ".btnMedir", function() {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find('td:eq(0)').text());
        estado='PROCESANDO'

        $.ajax({
            url: 'bd/estadoorden.php',
            type: 'POST',
            dataType: 'json',
            data: {
              folio: folio,
              estado: estado,
             
            },
            success: function (res) {
                if (res==1){
                    mensaje();
                    window.location.href="cntaorden.php";
                }
                else{
                    nomensaje();
                }
              
            },
          })
      

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


});