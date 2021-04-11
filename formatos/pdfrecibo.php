<?php
    $folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
    $pago = (isset($_GET['pago'])) ? $_GET['pago'] : '';

    

    require_once ('../vendor/autoload.php');
    
    $css=file_get_contents('../css/estilorep.css');

    require_once ('recibo.php');
    $plantilla= getPlantilla($folio,$pago);
   
    $mpdf = new \Mpdf\Mpdf(['format' => [139, 215],'orientation' => 'L']);

    
    
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($plantilla,\Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Estado de Cuenta Venta: ".$folio.".pdf","I");

   
