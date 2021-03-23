<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
 
 
 
 $consulta = "SELECT * FROM llamadapres where folio_pres='$folio' and estado_llamada=1 order by id_llamada";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;
