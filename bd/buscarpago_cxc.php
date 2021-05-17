<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 
 
 $inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
 $final = (isset($_POST['final'])) ? $_POST['final'] : '';
 $tipo_proy = (isset($_POST['tipo_proy'])) ? $_POST['tipo_proy'] : '';
 
 
 $consulta = "SELECT * FROM vpagocxc WHERE fecha BETWEEN '$inicio' AND '$final' and tipo_proy='$tipo_proy' and estado_pagocxc = 1 ORDER BY folio_vta,folio_pagocxc";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>