<?php
/*if (isset($_GET['folio'])) {
   echo getPlantilla($_GET['folio']);
}*/

require '../vendor/autoload.php';
    use Luecano\NumeroALetras\NumeroALetras;


function getPlantilla($folio,$pago)
{
    include_once '../bd/conexion.php';

    



    if ($folio != "" && $pago!="") {
        $objeto = new conn();
        $conexion = $objeto->connect();
        $formatter = new NumeroALetras();
        $formatter->conector = 'PESOS (';

        $consulta = "SELECT * FROM vventa WHERE folio_vta='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {
           
            $cliente = $dt['nombre'];
            $concepto = $dt['concepto_vta'];
            $gtotal = $dt['gtotal'];
            $saldo = $dt['saldo'];
        }

        $consultadet = "SELECT * FROM pagocxc WHERE folio_vta='$folio' AND estado_pagocxc=1 AND folio_pagocxc='$pago' ORDER BY folio_pagocxc,fecha";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);

        foreach($datadet as $regdata){
            $saldoant=$regdata['saldoini'];
            $saldofin=$regdata['saldofin'];
            $fecha=$regdata['fecha'];
            $comision=$regdata['comision'];
            $pagocom=$regdata['pagocom'];


        }
      
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../cntaventa.php";';
        echo '</script>';
    }

    $plantilla .= '
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../img/logof.png">
      </div>
      <div id="company">
        <h2 class="name">GALLERY STONE</h2>
        <div>Araucarias No 116, Col. Indeco Animas Xalapa, Veracruz</div>
        <div>Teléfonos: 228-1524147 228-1179998</div>
        <div><a href="mailto:ventas@gallerystone.com.mx">Email: ventas@gallerystone.com.mx</a></div>
      </div>

      <div id="folio">
        <h1>Recibo de Pago</h1>
        <div class="">Folio: <strong>' . $pago . '</strong></div>
        <div class="date">Fecha:' .$fecha . '</div>
      </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <h2 class="name">' . $cliente . '</h2>
          <h3 style="text-align:justify">PROYECTO: <strong>' . $concepto . '<strong></h3>
          <h3 style="text-align:justify">TOTAL VENTA: <strong>$ ' . number_format($gtotal,2) . '<strong></h3>
          <h3 style="text-align:justify">SALDO ANTERIOR: <strong>$ ' . number_format($saldoant,2) . '<strong></h3>
          
        </div>
        
    </div>
    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            
            <th class="total">Fecha</th>
            <th class="total">Concepto</th>
            <th class="total">Metodo de Pago</th>
            <th class="total">Monto</th>
            
          </tr>
        </thead>
        <tbody>';
    $x = 1;
    $pagos = 0;
    
    foreach ($datadet as $row) {
        $pagos += $row['monto'];
        $plantilla .= '
          <tr>
          
            <td class="desc">' . $row['fecha'] . '</td>
            <td class="desc">' . $row['concepto'] . '</td>
            <td class="desc">' . $row['metodo'] . '</td>
            <td class="qty">$' . number_format($row['monto'], 2) . '</td>
          </tr>
        ';
        $x++;
    }

    //.$formatter->toInvoice($pagocom, 2, ') M.N' ).
    $plantilla .=
        '</tbody>
        <tfoot class="sborde">
        <tr>
          <td></td>
          <td></td>
          <td>Pago Recibido</td>
          <td class=><strong>$ ' . number_format($pagos, 2) . '</strong></td>
        </tr>';
        if ($comision<>0 && $pagocom<>0) {        
        $plantilla .='<tr>
          <td></td>
          <td></td>
          <td>Comisión</td>
          <td class=><strong>$ ' . number_format($comision, 2) . '</strong></td>
        </tr>';
        }
        if ($comision<>0 && $pagocom<>0) { 
        $plantilla .='<tr>
          <td></td>
          <td></td>
          <td>Total </td>
          <td class=><strong>$ ' . number_format($pagocom, 2) . '</strong></td>
        </tr>';
        }
        $plantilla.=
         '<tr>
            <td ></td>
            <td ></td>
            <td  >Saldo Actual</td>
            <td >$ ' . number_format($saldofin, 2) . '</td>
          </tr>
             </tfoot>
      </table>
        
      <div id="thanks">¡Gracias por su preferencia!</div>
      <div class="advertencia" >
      *Este documento no es un comprobante fiscal
      </div>
    </main>
    <footer>
     
    </footer>
  </body>';

    return $plantilla;
}
