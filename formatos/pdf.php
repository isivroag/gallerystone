<?php
    $folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

   

    require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estilocotizacion2.css');

    require_once ('fcot2.php');
    $plantilla= getPlantilla($folio);
   
    $mpdf = new \Mpdf\Mpdf(['format' => 'Letter']);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Presupuesto ".$folio.".pdf","I");

   
