$(document).ready(function() {

    $('#btnBuscar').click(function () {
        folio=$('#folioorden').val();
        inicio=$('#inicio').val();
        fin=$('#final').val();
       
    
        if (inicio != '' && final != '' && folio != '') {
            url='generartabla.php?folio='+folio+'&inicio='+inicio+'&fin='+fin
            console.log(url);
            $('#contenido').load(url);
          
        } else {
          alert('Selecciona ambas fechas')
        }
      })
  
});