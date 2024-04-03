<?php
if (isset($_GET['folio'])) {
    echo getPlantilla($_GET['folio']);
}


function getPlantilla($folio)
{
    include_once '../bd/conexion.php';
   
    $plantilla="";
    if ($folio != "") {
        $objeto = new conn();
        $conexion = $objeto->connect();

        $consulta = "SELECT * FROM vot WHERE folio_orden='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {
            $folioorden = $dt['folio_ord'];


            $foliofis = $dt['folio_fisico'];
            $foliovta = $dt['folio_vta'];


            $fecha = $dt['fecha_ord'];
            $fechalim = $dt['fecha_limite'];
            $nomclie = $dt['nombre'];
            $concepto = $dt['concepto_vta'];
            $ubicacion = $dt['ubicacion'];
            $notas = $dt['notas'];
            $mapaurl = $dt['mapaurl'];
            $idot = $dt['id_ot'];
            $material = $dt['material_ot'];
            $moldura = $dt['moldura_ot'];
            $zoclo = $dt['zoclo_ot'];
            $superficie = $dt['superficie_ot'];
            $tipo = $dt['tipos_ot'];
            $obs = $dt['obs_ot'];
        }

        $consultadet = "SELECT * FROM vdetalle_vta where folio_vta='$foliovta' GROUP BY id_item order by id_reg";
        $resultadodet = $conexion->prepare($consultadet);
        $resultadodet->execute();
        $datadet = $resultadodet->fetchAll(PDO::FETCH_ASSOC);


        $consultad = "SELECT * FROM det_ot where id_ot='$folioorden' order by id_reg";
        $resultadod = $conexion->prepare($consultad);
        $resultadod->execute();
        $datad = $resultadod->fetchAll(PDO::FETCH_ASSOC);

        $cntaimg = "SELECT * FROM imgot where folio_orden='$folioorden' order by id_reg";
        $resimg = $conexion->prepare($cntaimg);
        $resimg->execute();
        $dataimg = $resimg->fetchAll(PDO::FETCH_ASSOC);
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
        <h2 class="name">ORDEN DE TRABAJO</h2>
      </div>

      <div id="folio">
        <table style="border:0">
            <tbody style="border:0">
            <tr style="border:0">
            <td class="desc" style="border:0">Folio OT</td>
            <td style="border:0"><strong style="color:red;text-align:right">' . $folioorden . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Folio VTA</td>
            <td style="border:0"><strong style="text-align:right">' . $foliovta . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Fecha Inicio</td>
            <td style="border:0"><strong style="text-align:right">' . $fecha . '</strong></td>
            </tr>
            <tr style="border:0">
            <td class="desc" style="border:0">Fecha Col.</td>
            <td style="border:0"><strong style="text-align:right">' . $fechalim . '</strong></td>
            </tr>
            </tbody>
        </table>
      
      </div>

      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <p style="text-align:justify">Concepto: <strong>' . $concepto . '</strong></p>
          <p style="text-align:justify">Ubicación: <strong>' . $ubicacion . '</strong></p>
          
        </div>
        
    </div>
    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            
            
            <th class="total">Id</th>
            <th class="total">Concepto</th>
            <th class="total">Descripcion</th>
            <th class="total">Formato</th>
            <th class="total">Cantidad</th>
            <th class="total">U. Medida</th>
      
            
          </tr>
        </thead>
        <tbody>';

    foreach ($datadet as $row) {

        $plantilla .= '
        <tr>
            <td class="desc">'.$row['id_reg'] .'</td>
            <td class="desc">'.$row['nom_concepto'] .'</td>
            <td class="desc">'.$row['nom_item'] .'</td>
            <td class="desc">'.$row['formato'] .'</td>
            <td class="desc">'.$row['cantidad'] .'</td>
            <td class="desc">'.$row['nom_umedida'] .'</td>
        </tr>
        ';
    }
    $plantilla .=
        '</tbody>
    </table>
    <br>

    <table class="sborde" border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        
        <th class="total"><strong>Concepto</strong></th>
        <th class="total"><strong>Medidas</strong></th>
  
        
      </tr>
    </thead>
    <tbody>';

    foreach ($datad as $row) {

        $plantilla .= '
    <tr>
        <td class="desc">' . $row['concepto'] . '</td>
        <td class="medida">' . $row['medida'] . '</td>
    </tr>
    ';
    }
    $plantilla .= '

  
    </tbody>
</table>
<div id="details" class="clearfix">
<div id="client">
  <p style="text-align:justify">Superficie de Colocación: <strong>' . $superficie . '</strong></p>
  <p style="text-align:justify">Tipo de Servicio: <strong>' . $tipo . '</strong></p>
  <p style="text-align:justify">Observaciones: <strong>' . $obs . '</strong></p>
  
</div>

</div>
<div class="">
<table>
<thead>
    <tr>
    <th class="total"><strong>Despiece</strong></th>
    </tr>
</thead>
<tbody>';

foreach ($dataimg as $rowimg) {
  $mapaurl=$rowimg['mapaurl'];

$plantilla.='<tr style="align: center !important;">
        <td class="tdimagen" style="aling:center !important">
       
        <img class="imagen" src=../'. $mapaurl .' alt="Photo"  >
        
        </td>';
}   
$plantilla.='</tr>
</tbody>
</table>

</div>

    </main>
    <footer>
    </footer>
  </body>';

    return $plantilla;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../css/estiloorden.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>