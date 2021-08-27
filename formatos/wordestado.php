<?php
    

   

    require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estilocotizacion2.css');

    $folio=array( 49,126,2,138,15,22,60);

    require_once ('estadocuentaw.php');
    
    
    $plantilla= getPlantilla($folio);
  
    $mpdf = new \Mpdf\Mpdf(['format' => 'Letter']);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Estado de Cuenta Venta.pdf","I");

   
