<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$descripcion = (isset($_POST['descripcion'])) ? $_POST['descripcion'] : '';
$area = (isset($_POST['area'])) ? $_POST['area'] : '';
$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '0';
$fin = (isset($_POST['fin'])) ? $_POST['fin'] : '0';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '0';


$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';





switch ($opcion) {
    case 1: //alta

        
        break;
        case 2:
            $consulta = "UPDATE tmp_gen SET fecha='$fecha',inicio='$inicio',fin='$fin',descripcion='$descripcion',area='$area' WHERE folio_gen='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            $consulta = "SELECT * FROM vtmpgen WHERE folio_gen='$folio'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()){
                $data=1;
            }
            else{
                $data=0;
            }
          
        break;
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;


?>