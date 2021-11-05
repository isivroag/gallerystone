<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';


$idcons = (isset($_POST['idcons'])) ? $_POST['idcons'] : '';
$cantidadi = (isset($_POST['cantidadi'])) ? $_POST['cantidadi'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';


switch ($opcion) {

        //AGREAR
    case 1:
        $consulta = "INSERT INTO consumible_ord (folio_ord,id_cons,cantidad) values ('$folio','$idcons','$cantidadi')";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        $id = $idcons;
        $tipomov = "Salida";
        $descripcion = "Usado en Orden Folio:" . $folio;
        $montomov = $cantidadi;

        $fechavp = date('Y-m-d');


        $saldofinn = 0;
        $saldofina = 0;
        $saldofint = 0;
        $saldoinn = 0;
        $saldoina = 0;
        $saldoint = 0;

        $consulta = "SELECT * from consumible where id_cons='$id'";
        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            foreach ($data as $rowdata) {

                $cantidad = $rowdata['cant_cons'];
                $saldoinn = $rowdata['contenidon'];
                $saldoina = $rowdata['contenidoa'];
                $saldoint = $rowdata['contenidot'];
                $saldo = $rowdata['cant_cons'];;
            }


            $saldofinn = $saldoinn;
            $saldofinab = $saldoina - $montomov;
            $saldofint = $saldoint - $montomov;
            $saldofin = $saldo;


            $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
            values('$id','$fechavp','$tipomov','0','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','0','$saldofinn','$saldoina','$montomov','$saldofinab','$saldoint','$montomov','$saldofint')";
            $resultado = $conexion->prepare($consulta);

            if ($resultado->execute()) {

                $consulta = "UPDATE consumible SET contenidoa='$saldofinab',contenidot='$saldofint' WHERE id_cons='$id'";
                $resultado = $conexion->prepare($consulta);

                $resultado->execute();
            }
        }



        $consulta = "SELECT * FROM vconsumibleord WHERE folio_ord='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        break;
        //CANCELAR
    case 2:
        $consulta = "UPDATE consumible_ord SET estado_detalle=0 WHERE id_reg='$id'";

        $resultado = $conexion->prepare($consulta);
        if ($resultado->execute()) {
       

            $consulta = "SELECT * FROM consumible_ord WHERE id_reg='$id'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($data as $rowd) {
                $idcons = $rowd['id_cons'];
                $montomov = $rowd['cantidad'];
                $folio=$rowd['folio_ord'];
            }
    
      
            $tipomov = "Entrada Can";
            $descripcion = "Cancelacion en Orden Reg:" . $folio;
          
            $fechavp = date('Y-m-d');

            $saldofinn = 0;
            $saldofina = 0;
            $saldofint = 0;
            $saldoinn = 0;
            $saldoina = 0;
            $saldoint = 0;

            $consulta = "SELECT * from consumible where id_cons='$idcons'";
            $resultado = $conexion->prepare($consulta);
            if ($resultado->execute()) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $rowdata) {

                    $cantidad = $rowdata['cant_cons'];
                    $saldoinn = $rowdata['contenidon'];
                    $saldoina = $rowdata['contenidoa'];
                    $saldoint = $rowdata['contenidot'];
                    $saldo = $rowdata['cant_cons'];;
                }



                $saldofinn = $saldoinn;
                $saldofinab = $saldoina + $montomov;
                $saldofint = $saldoint + $montomov;
                $saldofin = $saldo;



                $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
                values('$idcons','$fechavp','$tipomov','0','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','0','$saldofinn','$saldoina','$montomov','$saldofinab','$saldoint','$montomov','$saldofint')";
                $resultado = $conexion->prepare($consulta);

                if ($resultado->execute()) {

                    $consulta = "UPDATE consumible SET contenidoa='$saldofinab',contenidot='$saldofint' WHERE id_cons='$idcons'";
                    $resultado = $conexion->prepare($consulta);

                    $resultado->execute();
                    $data = 1;
                }
            }
        } else {
            $data = 0;
        }

        break;
}







print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
