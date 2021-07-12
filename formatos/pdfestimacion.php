<?php
    $folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
    $inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : '';
    $fin = (isset($_GET['fin'])) ? $_GET['fin'] : '';

    

    require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estilorep.css');

    require_once ('estimacion2.php');
    $plantilla= getPlantilla($folio,$inicio,$fin);
   
    $mpdf = new \Mpdf\Mpdf(['format' => 'Letter']);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Estado de Cuenta Venta: ".$folio.".pdf","I");

   
