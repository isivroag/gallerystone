<?php  
 //filter.php  

 include_once 'conexion.php';
 $objeto = new conn();
 $conexion = $objeto->connect();
 
 // Recepción de los datos enviados mediante POST desde el JS   
 

 $banco = (isset($_POST['banco'])) ? $_POST['banco'] : '';
 $inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
 $final = (isset($_POST['final'])) ? $_POST['final'] : '';
 
 
 $consulta = "SELECT * FROM mov_banco WHERE id_banco='$banco' and estado_movb=1 order by fecha_movb,id_movb";
 $resultado = $conexion->prepare($consulta);
 $resultado->execute();
 $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
 
 
 print json_encode($data, JSON_UNESCAPED_UNICODE);
 $conexion = NULL;  
 ?>