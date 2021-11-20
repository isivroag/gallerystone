<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';
$tokenid = (isset($_POST['tokenid'])) ? $_POST['tokenid'] : '';
$fecha = (isset($_POST['fecha'])) ? $_POST['fecha'] : '';
$fecha_limite = (isset($_POST['fechal'])) ? $_POST['fechal'] : '';
$fecha_actual = date('Y-m-d');
$id_prov = (isset($_POST['id_prov'])) ? $_POST['id_prov'] : '';
$id_partida = (isset($_POST['id_partida'])) ? $_POST['id_partida'] : '';
$concepto = (isset($_POST['concepto'])) ? $_POST['concepto'] : '';
$facturado = (isset($_POST['facturado'])) ? $_POST['facturado'] : '';
$referencia = (isset($_POST['referencia'])) ? $_POST['referencia'] : '';
$subtotal = (isset($_POST['subtotal'])) ? $_POST['subtotal'] : '';
$iva = (isset($_POST['iva'])) ? $_POST['iva'] : '';
$total = (isset($_POST['total'])) ? $_POST['total'] : '';
$saldo = (isset($_POST['saldo'])) ? $_POST['saldo'] : '';

$fechavp = date('Y-m-d');

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$res = 0;


switch ($opcion) {
    case 1: //alta
        $consulta = "UPDATE cxp set fecha='$fecha',fecha_limite='$fecha_limite',id_prov='$id_prov',id_partida='$id_partida',concepto='$concepto',facturado='$facturado',
        referencia='$referencia',subtotal='$subtotal',iva='$iva',total='$total',saldo='$total',estado='1' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;

        // CONSULTA DEL DETALLE
        $consulta = "SELECT * FROM detallecxp_insumo WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $row) {

            // EMPIEZA EL INCREMENTO EN INVENTARIO
            $id = $row['id_cons'];
            $tipomov = 'Entrada';
            $saldo = 0;
            $montomov = $row['cant_cons'];
            $saldofin = 0;
            $descripcion = "COMPRA DE INSUMOS CXP FOLIO: " . $folio;

            $conversion = 0;
            $saldofinn = 0;
            $saldofina = 0;
            $saldofint = 0;
            $saldoinn = 0;
            $saldoina = 0;
            $saldoint = 0;
            $contenidoc = 0;
            $contenidoa = 0;
            $contenidot = 0;

            $usuario = $row['usuario'];


            $consultam = "SELECT * from consumible where id_cons='$id'";
            $resultadom = $conexion->prepare($consultam);
            if ($resultadom->execute()) {
                $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                foreach ($datam as $rowdatam) {

                    $presentacion = $rowdatam['presentacion'];

   

                    $saldoinn = $rowdatam['contenidon'];
                    $saldoina = $rowdatam['contenidoa'];
                    $saldoint = $rowdatam['contenidot'];
            
                    $saldo = $rowdatam['cant_cons'];;
                }
                $res += 1;
            }
            $conversion = $presentacion * $montomov;
            $saldofinn = $saldoinn + $conversion;
            $saldofint = $saldoint + $conversion;
            $saldofin = $saldo + $montomov;

            //guardar el movimiento
            $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
            values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','$conversion','$saldofinn','$saldoina','0','$saldoina','$saldoint','$conversion','$saldofint')";
            $resultado = $conexion->prepare($consulta);
        
            if ($resultado->execute()) {
        
                $consulta = "UPDATE consumible SET cant_cons='$saldofin',contenidon='$saldofinn',contenidot='$saldofint' WHERE id_cons='$id'";
                $resultado = $conexion->prepare($consulta);
                
                if ($resultado->execute()) {
                    $res = 1;
                }
        
            }
            //TERMINA EL INCREMENTO EN INVENTARIO   

        }


        break;
    case 2:


        break;

    case 3:
        $consulta = "UPDATE cxp SET estado_cxp='0' WHERE folio_cxp='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $res = 1;




            // CONSULTA DEL DETALLE
            $consulta = "SELECT * FROM detallecxp_insumo WHERE folio_cxp='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($data as $row) {
    
                // EMPIEZA EL INCREMENTO EN INVENTARIO
                $id = $row['id_cons'];
                $tipomov = 'Salida Can';
                $saldo = 0;
                $montomov = $row['cant_cons'];
                $saldofin = 0;
                $descripcion = "CANCELACION DE COMPRA DE INSUMOS CXP FOLIO: " . $folio;
    
                $conversion = 0;
                $saldofinn = 0;
                $saldofina = 0;
                $saldofint = 0;
                $saldoinn = 0;
                $saldoina = 0;
                $saldoint = 0;
                $contenidoc = 0;
                $contenidoa = 0;
                $contenidot = 0;
    
                $usuario = $row['usuario'];
    
    
                $consultam = "SELECT * from consumible where id_cons='$id'";
                $resultadom = $conexion->prepare($consultam);
                if ($resultadom->execute()) {
                    $datam = $resultadom->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($datam as $rowdatam) {
    
                        $presentacion = $rowdatam['presentacion'];
    
       
    
                        $saldoinn = $rowdatam['contenidon'];
                        $saldoina = $rowdatam['contenidoa'];
                        $saldoint = $rowdatam['contenidot'];
                
                        $saldo = $rowdatam['cant_cons'];;
                    }
                    $res += 1;
                }
                $conversion = $presentacion * $montomov;
                $saldofinn = $saldoinn - $conversion;
                $saldofint = $saldoint - $conversion;
                $saldofin = $saldo - $montomov;
    
                //guardar el movimiento
                $consulta = "INSERT INTO mov_consumible(id_cons,fecha_movi,tipo_movi,cantidad,saldoini,saldofin,descripcion,usuario,saldoinn,cantidadn,saldofinn,saldoina,cantidada,saldofina,saldoint,cantidadt,saldofint) 
                values('$id','$fechavp','$tipomov','$montomov','$saldo','$saldofin','$descripcion','$usuario','$saldoinn','$conversion','$saldofinn','$saldoina','0','$saldoina','$saldoint','$conversion','$saldofint')";
                $resultado = $conexion->prepare($consulta);
            
                if ($resultado->execute()) {
            
                    $consulta = "UPDATE consumible SET cant_cons='$saldofin',contenidon='$saldofinn',contenidot='$saldofint' WHERE id_cons='$id'";
                    $resultado = $conexion->prepare($consulta);
                    
                    if ($resultado->execute()) {
                        $res = 1;
                    }
            
                }
                //TERMINA EL INCREMENTO EN INVENTARIO   
    
            }
        break;
}

print json_encode($res, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
