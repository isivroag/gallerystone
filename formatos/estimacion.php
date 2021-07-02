<?php
/*if (isset($_GET['folio'])) {
   echo getPlantilla($_GET['folio']);
}*/

require '../vendor/autoload.php';
    use Luecano\NumeroALetras\NumeroALetras;


function getPlantilla($folio,$inicio,$fin)
{
    include_once '../bd/conexion.php';

    



    if ($folio != "" && $inicio!="" && $fin!="") {
        $objeto = new conn();
        $conexion = $objeto->connect();
        $formatter = new NumeroALetras();
        $formatter->conector = 'PESOS (';
        $fecha=date('Y-m-d');
        $consulta = "SELECT * FROM vorden WHERE folio_ord='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {
            $venta= $dt['folio_vta'];
            $cliente = $dt['nombre'];
            $concepto = $dt['concepto_vta'];
            
            
        }

       
      
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../cntagenerador.php?folio='.$folio;
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
        <h1>Estimacion</h1>
        <div class="">Folio de Venta: <strong>' . $venta . '</strong></div>
        <div class="date">Fecha:' .$fecha . '</div>
      </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <h2 class="name">Cliente: <strong>' . $cliente . '</storng></h2>
          <h2 class="name">PROYECTO: <strong>' . $concepto . '</strong></h2>
          <h2 class="name">Período de Ejecución: <strong> Del ' . $inicio . ' al ' .$fin.'</strong></h2>
        </div>
        
    </div>
    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            
            <th class="total">Concepto</th>
            <th class="total">Area</th>
            <th class="total">Cantidad M2</th>
            <th class="total">Precio Unitario</th>
            <th class="total">Total</th>
            
          </tr>
        </thead>
        <tbody>';
    $x = 1;
    $pagos = 0;

    $consul="SELECT v_resgenerador.id_ord,v_resgenerador.folio_gen,v_resgenerador.id_frente,v_resgenerador.nom_frente,v_resgenerador.id_area,v_resgenerador.area,v_resgenerador.fecha,
    detalle_gen.id_concepto,detalle_gen.nom_concepto,SUM(detalle_gen.cantidad) AS cantidad,detalle_conceptosobra.precio_concepto,SUM(detalle_gen.cantidad) *detalle_conceptosobra.precio_concepto AS total
    FROM v_resgenerador
    JOIN detalle_gen on v_resgenerador.folio_gen=detalle_gen.folio_gen
    JOIN detalle_conceptosobra ON v_resgenerador.id_ord=detalle_conceptosobra.id_orden AND detalle_gen.id_concepto=detalle_conceptosobra.id_concepto
    WHERE v_resgenerador.fecha BETWEEN '$inicio' AND '$fin' and v_resgenerador.id_ord='$folio'
    GROUP BY v_resgenerador.id_ord,v_resgenerador.id_frente,v_resgenerador.id_area,detalle_gen.id_concepto";

    $resul = $conexion->prepare($consul);
    $resul->execute();

    $dat = $resul->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($dat as $row) {
        $pagos += $row['total'];
        $plantilla .= '
          <tr>
          
            <td class="desc">' . $row['nom_concepto'] . '</td>
            <td class="desc" style="text">' . $row['nom_frente'] . '</td>
            <td class="qty">' . $row['cantidad'] . '</td>
            <td class="qty">$' . number_format($row['precio_concepto'], 2) . '</td>
            <td class="qty">$' . number_format($row['total'], 2) . '</td>
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
          <td></td>
          <td>Total Estimación</td>
          <td class=><strong>$ ' . number_format($pagos, 2) . '</strong></td>
        </tr>';
  
  
        $plantilla.=
         '</tfoot>
      </table>
        
      <div id="thanks">¡Gracias por su preferencia!</div>
     
    </main>
    <footer>
     
    </footer>
  </body>';

    return $plantilla;
}
