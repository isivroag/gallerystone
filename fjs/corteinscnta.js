$(document).ready(function () {
    var id, opcion;
    opcion = 4;
  
    var textcolumnas = permisos();
  
    function permisos() {
      var tipousuario = $("#tipousuario").val();
      var columnas = "";
  
      if (tipousuario == 5) {
        columnas =
          "<div class='text-center'>\
              <button class='btn btn-sm bg-gradient-primary text-light btnMov' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa-solid fa-magnifying-glass'></i></button>\
             </div>";
      } else {
        columnas =
          "<div class='text-center'>\
              <button class='btn btn-sm bg-gradient-primary text-light btnMov' data-toggle='tooltip' data-placement='top' title='Ver'><i class='fa-solid fa-magnifying-glass'></i></button>\
             </div>";
      }
      return columnas;
    }
  
    tablaVis = $("#tablaV").DataTable({
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
        lengthMenu: "Mostrar _MENU_ registros",
        zeroRecords: "No se encontraron resultados",
        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        infoFiltered: "(filtrado de un total de _MAX_ registros)",
        sSearch: "Buscar:",
        oPaginate: {
          sFirst: "Primero",
          sLast: "Último",
          sNext: "Siguiente",
          sPrevious: "Anterior",
        },
        sProcessing: "Procesando...",
      },
  
      rowCallback: function (row, data) {
        if (data[5] == 2) {
          $($(row).find("td")).addClass("bg-gradient-success");
        } else {
          $($(row).find("td")).addClass("bg-gradient-warning");
        }
      },
    });
  
    $("#btnNuevo").click(function () {
   
        $.ajax({
          url: "bd/buscarvales.php",
          type: "POST",
          dataType: "json",
          async: false,
          data: {},
          success: function (data) {
            if (data == 1) {
              swal
                .fire({
                  title: "¿Esta seguro de continuar?",
                  html: "<strong>Este proceso guardará las medidas y cantidades actuales de todos los materiales en inventario.<br><br>\
                    Es vital terminar este procedimiento antes de usar materiales en otros procesos \
                    <br>De lo contrario, los movimientos de otros módulos podrían sobrescribirse, comprometiendo la integridad de tus registros.</strong>",
    
                  showCancelButton: true,
                  icon: "warning",
                  focusConfirm: true,
                  confirmButtonText: "Continuar",
    
                  cancelButtonText: "Cancelar",
    
                  //background: "#F4B554 ",
                  confirmButtonColor: "#0C9935",
                  cancelButtonColor: "#d33",
                })
                .then(function (isConfirm) {
                  if (isConfirm.value) {
                    window.location.href = "corteinsi.php";
                  } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
                  }
                });
            } else {
              swal
                .fire({
                  title: "Operación No permitida",
                  html: "<div class='text-justify'><strong>No es posible comenzar con el proceso de Corte<br><br>\
                    Para usar este modulo es necesario que todos los Vales de Entrega/Recepción esten cerrados.\
                    </strong></div>",
                  icon: "warning",
                  focusConfirm: true,
                  confirmButtonText: "Aceptar",
                  confirmButtonColor: "#0C9935",
    
                })
                
    
            
            }
          },
        });
    });
  
    $(".btnMov").click(function () {
      fila = $(this).closest("tr");
      id = parseInt(fila.find("td:eq(0)").text());
      
      swal
      .fire({
        title: "¿Esta seguro de continuar?",
        html: "<strong>Este proceso guardará las medidas y cantidades actuales de todos los insumos en inventario.<br><br>\
            Es vital terminar este procedimiento antes de usar insumos en otros procesos \
            <br>De lo contrario, los movimientos de otros módulos podrían sobrescribirse, comprometiendo la integridad de tus registros.</strong>",
  
        showCancelButton: true,
        icon: "warning",
        focusConfirm: true,
        confirmButtonText: "Continuar",
       
  
        cancelButtonText: "Cancelar",
      
        //background: "#F4B554 ",
        confirmButtonColor: '#0C9935',
        cancelButtonColor: '#d33',
      })
      .then(function (isConfirm) {
        if (isConfirm.value) {
          window.location.href = "corteinsi.php?folio=" + id;
        } else if (isConfirm.dismiss === swal.DismissReason.cancel) {
        }
      });
    });
  
    var fila; //capturar la fila para editar o borrar el registro
  });
  