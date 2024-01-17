<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$orden = (isset($_POST['orden'])) ? $_POST['orden'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$medida = (isset($_POST['medida'])) ? $_POST['medida'] : '';
$tipoc = (isset($_POST['tipoc'])) ? $_POST['tipoc'] : '';


$id = (isset($_POST['id'])) ? $_POST['id'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res=0;

switch($opcion){
    case 1: //alta
        switch($tipoc){
            case 0:
                for ($i=0; $i < $cantidad; $i++){
                    $consulta = "INSERT INTO det_ot (concepto,id_ot,tipo) VALUES('$concepto','$orden','$tipoc') ";			
                    $resultado = $conexion->prepare($consulta);
                    if($resultado->execute()){
                        $res++;
                    }
                }
                break;
            case 1:
                $consulta = "INSERT INTO det_ot (concepto,id_ot,medida,tipo) VALUES('$concepto','$orden','$medida','$tipoc') ";			
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                    $res++;
                }
                break;
            case 2:
                $consulta = "INSERT INTO det_ot (concepto,id_ot,medida,tipo) VALUES('$concepto','$orden','$medida','$tipoc') ";			
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                    $res++;
                }
                break;
            case 3:
                $consulta = "INSERT INTO det_ot (concepto,id_ot,medida,tipo) VALUES('$concepto','$orden','$medida','$tipoc') ";			
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                    $res++;
                }
                break;
            case 4:
                $consulta = "INSERT INTO det_ot (concepto,id_ot,medida,tipo) VALUES('$concepto','$orden','$medida','$tipoc') ";			
                $resultado = $conexion->prepare($consulta);
                if($resultado->execute()){
                    $res++;
                }
                break;

        }
       
     
        break;
    case 2: //modificación
        switch($tipoc){
        case 0:
        $consulta = "UPDATE det_ot SET concepto='$concepto',medida='$medida' WHERE id_reg='$id' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $res=1;
        }
        break;
        case 1:
            $consulta = "UPDATE det_ot SET concepto='$concepto',medida='$medida' WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            if($resultado->execute()){
                $res=1;
            }
            break;
        case 2:
            $consulta = "UPDATE det_ot SET concepto='$concepto',medida='$medida' WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            if($resultado->execute()){
                $res=1;
            }
            break;
        case 3:
            $consulta = "UPDATE det_ot SET concepto='$concepto',medida='$medida' WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            if($resultado->execute()){
                $res=1;
            }
            break;
        case 4:
            $consulta = "UPDATE det_ot SET concepto='$concepto',medida='$medida' WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            if($resultado->execute()){
                $res=1;
            }
            break;
    }
        break;        
    case 3://baja
        $consulta = "DELETE FROM det_ot  WHERE id_reg='$id' ";		
        $resultado = $conexion->prepare($consulta);
        if($resultado->execute()){
            $res=1;
        }
                             
        break;        
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
