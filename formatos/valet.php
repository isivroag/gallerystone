<?php
/*
if (isset($_GET['folio'])) {
    echo getPlantilla($_GET['folio']);
}*/


function getPlantilla($folio)
{
    include_once '../bd/conexion.php';
    $plantilla="";
    if ($folio != "") {
        $objeto = new conn();
        $conexion = $objeto->connect();

        $consulta = "SELECT * FROM vale WHERE folio_vale='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {

            $fecha = $dt['fecha_vale'];
            $fecha_cierre = $dt['fecha_cierre'];
            $estado = $dt['estado'];
            $emisor = $dt['usuario_entrega'];
            $receptor = $dt['usuario_recibe'];
         
            $obs = $dt['obs'];
        }

        $consultadet = "SELECT * FROM vvale_detalle where folio_vale='$folio' and estado_reg='1' order by id_reg";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);


       
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="../cntavale.php";';
        echo '</script>';
    }

    $plantilla .= '



  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../img/logof.png">
      </div>
      <div id="company">
        <h2 class="name">VALE ENTREGA/RECEPCION DE HERRAMIENTAS</h2>
      </div>

      <div id="folio">
        <table style="border:0">
            <tbody style="border:0">
            <tr style="border:0">
            <td class="desc" style="border:0">Folio Vale</td>
            <td style="border:0"><strong style="color:red;text-align:right">' . $folio . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Fecha Inicio</td>
            <td style="border:0"><strong style="text-align:right">' . $fecha . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Fecha Cierre</td>
            <td style="border:0"><strong style="text-align:right">' . $fecha_cierre . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Estatus:</td>
            <td style="border:0"><strong style="text-align:right">' . $estado . '</strong></td>
            </tr>
            </tbody>
        </table>
      
      </div>

     
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <p style="text-align:justify">ENTREGA/EMITE: <strong>' . $emisor . '</strong></p>
          <p style="text-align:justify">RECIBE/DEVUELVE: <strong>' . $receptor . '</strong></p>
          
        </div>
        
      </div>
    
   

    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
        
                <th class="total"><strong>CLAVE</strong></th>
                <th class="total"><strong>HERRAMIENTA</strong></th>
                <th class="total"><strong>CANTIDAD</strong></th>
            </tr>
        </thead>
        <tbody>';

            foreach ($datadet as $row) {

                $plantilla .= '
            <tr>
                <td class="desc">' . $row['clave_her'] . '</td>
                <td class="medida">' . $row['nom_her'] . '</td>
                <td class="medida">' . $row['cantidad_her'] . '</td>
            </tr>
            ';
            }
            $plantilla .= '
        </tbody>
    </table>

<div style="padding-top:100px">
            <table style="border:0">
           
                <tbody style="border:0" >
                    <tr>
                    <td style="border:0;border-bottom:1px solid #000000"></td>
                    <td style="border:0">         </td>
                    <td style="border:0;border-bottom:1px solid #000000"></td>
                    </tr>
                    <tr>
                    <td class="desc" style="border:0; text-align:center">'.$emisor.'</td>
                    <td style="border:0">         </td>
                    <td class="desc" style="border:0; text-align:center">'.$receptor.'</td>
                    </tr>
                   
                </tbody>
            </table>
</div>

    </main>
    <footer>
    </footer>
  </body>';

    return $plantilla;
}
