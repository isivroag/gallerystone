<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idmat = (isset($_POST['idmat'])) ? $_POST['idmat'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$m2 = (isset($_POST['m2'])) ? $_POST['m2'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$entregado= (isset($_POST['entregado'])) ? $_POST['entregado'] : '';
$recibido= (isset($_POST['recibido'])) ? $_POST['recibido'] : '';
$fecha= (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';

switch ($opcion) {
    case 1: //alta
        //$consulta = "INSERT INTO detalle_ord (folio_ord,id_mat,cant_mat) values ('$folio','$idmat','$cantidad')";
        $consulta = "INSERT INTO detalle_ordsum (folio_ord,id_mat,cant_mat,entregado,recibido,fecha,m2_mat) 
        values ('$folio','$idmat','$cantidad','$entregado','$recibido','$fecha','$m2')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
       

        //BUSCAR MATERIAL Y TRAER INVENTARIO ACTUAL

     
        $tipomov = "Salida";
        $descripcion = "Usado en Orden Folio:" . $folio;
        $fechavp = date('Y-m-d');


        $saldoini = 0;
        $saldofin = 0;

        $saldoinim2 = 0;
        $saldofinm2 = 0;
        

        $consulta = "SELECT * from materialpieza where id_mat='$idmat'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {

                
                $saldoini = $rowdata['cant_mat'];
                $saldoinim2 = $rowdata['m2_mat'];
            }


            $saldofin = $saldoini-$cantidad;
            $saldofinm2 = $saldoinim2-$m2;
            
            //INSERTAR EL MOVIMIENTO

            $consulta = "INSERT INTO mov_matpieza(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario,m2_ini,m2_cantidad,m2_final) 
            values('$idmat','$fechavp','$tipomov','$cantidad','$saldoini','$saldofin','$descripcion','$usuario','$saldoinim2','$m2','$saldofinm2')";
            $resultado = $conexion->prepare($consulta);

            if ($resultado->execute()) {
            // DESCONTAR DE INVENTARIO
       
                $consulta = "UPDATE materialpieza SET cant_mat='$saldofin', m2_mat='$saldofinm2' WHERE id_mat='$idmat'";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute() ){
                    //DEVUELVE LA FILA
                    $consulta = "SELECT * FROM vdetalle_ordsum WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
                    $resultado = $conexion->prepare($consulta);
                    $resultado->execute();
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }

        

       
        

        break;
        case 2:
            $consulta = "UPDATE detalle_ordsum SET estado_deto=0 where id_reg='$id'";
        
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()){

                
                //BUSCAR MATERIAL Y CANTIDAD
                $consulta = "SELECT * FROM detalle_ordsum WHERE id_reg='$id'";
                $resultado = $conexion->prepare($consulta);
                $resultado->execute();
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($data as $rowd) {
                    $idmat = $rowd['id_mat'];
                    $montomov = $rowd['cant_mat'];
                    $folio=$rowd['folio_ord'];
                    $m2=$rowd['m2_mat'];
                }
        
          
                $tipomov = "Entrada Can";
                $descripcion = "Cancelacion en Orden Reg:" . $folio;
              
                $fechavp = date('Y-m-d');
    
                $saldoini = 0;
                $saldofin = 0;

                $saldoinim2 = 0;
                $saldofinm2 = 0;
    
                $consulta = "SELECT * from materialpieza where id_mat='$idmat'";
                $resultado = $conexion->prepare($consulta);
                if ($resultado->execute()) {
                    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($data as $rowdata) {
    
                        $saldoini = $rowdata['cant_mat'];
                        $saldoinim2 = $rowdata['m2_mat'];
                    }
    
                    $saldofin = $saldoini+$montomov;
    
                    $saldofinm2 = $saldoinim2+$m2;
                  
                  
    
    
    
                    $consulta = "INSERT INTO mov_matpieza(id_mat,fecha_movp,tipo_movp,cantidad,saldoini,saldofin,descripcion,usuario,m2_ini,m2_cantidad,m2_final) 
                    values('$idmat','$fechavp','$tipomov','$montomov','$saldoini','$saldofin','$descripcion','$usuario','$saldoinim2','$m2','$saldofinm2')";
                    $resultado = $conexion->prepare($consulta);
    
                    if ($resultado->execute()) {
    
                        $consulta = "UPDATE materialpieza SET cant_mat='$saldofin', m2_mat='$saldofinm2' WHERE id_mat='$idmat'";
                        $resultado = $conexion->prepare($consulta);
    
                        $resultado->execute();
                        $data = 1;
                    }
                }

             

                //REGRESAR A INVENTARIO
                
            }
            else{
                $data=0;
            }
            
          
        break;
  
}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;

?>