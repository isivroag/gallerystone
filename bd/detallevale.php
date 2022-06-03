<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$iddes = (isset($_POST['iddes'])) ? $_POST['iddes'] : '';
$cantidad = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$fecha=date("Y-m-d");

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO vale_detalle (folio_vale,id_her,cantidad_her,estado,obs) 
        values ('$folio','$iddes','$cantidad','PENDIENTE','')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * from vvale_detalle where folio_vale='$folio' and id_her='$iddes' and estado_reg='1'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);


        break;
        case 2:
            $consulta = "DELETE FROM vale_detalle where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
           
            $data=1;
        break;
    case 3:
        $consulta = "SELECT * FROM vvale_detalle where folio_vale='$folio' and estado_reg=1 order by id_reg";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

       
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 4:
        $consulta = "UPDATE vale_detalle SET estado=1 where id_reg='$id'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        

        $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


       
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row){
            $foliovale=$row['folio_vale'];
        }
        $consulta2="SELECT * from vale_detalle where folio_vale='$foliovale' and estado='0' and estado_reg='1'";
        $res2=$conexion->prepare($consulta2);
        $res2->execute();
        if($res2->rowCount() == 0){
            $consulta2="UPDATE vale SET estado='ENTREGADO' where folio_vale='$foliovale'";
            $res2=$conexion->prepare($consulta2);
            $res2->execute();
        }

        $data=1;


        break;

        case 5:
            $consulta = "UPDATE vale_detalle SET estado=2 where id_reg='$id'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
    
            
    
            $consulta = "SELECT * from vvale_detalle where id_reg='$id'";
            
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
    
           
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($data as $row){
                $foliovale=$row['folio_vale'];
            }
            $consulta2="SELECT * from vale_detalle where folio_vale='$foliovale' and estado='1' and estado_reg='1'";
            $res2=$conexion->prepare($consulta2);
            $res2->execute();
            if($res2->rowCount() == 0){
                $consulta2="UPDATE vale SET estado='RECIBIDO', fecha_cierre='$fecha' where folio_vale='$foliovale'";
                $res2=$conexion->prepare($consulta2);
                $res2->execute();
            }
    
            $data=1;
    
    
            break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>