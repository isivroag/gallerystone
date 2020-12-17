<?php
include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   

$folio = (isset($_POST['folio'])) ? $_POST['folio'] : '';

$id_concepto = (isset($_POST['idconcepto'])) ? $_POST['idconcepto'] : '';
$id_item = (isset($_POST['id_item'])) ? $_POST['id_item'] : '';
$id_precio = (isset($_POST['id_precio'])) ? $_POST['id_precio'] : '';
$precio = (isset($_POST['precio'])) ? $_POST['precio'] : '';
$cantidad = (isset($_POST['cantidad'])) ? $_POST['cantidad'] : '';
$total= (isset($_POST['total'])) ? $_POST['total'] : '';

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id= (isset($_POST['id'])) ? $_POST['id'] : '';

switch ($opcion) {
    case 1: //alta
        $consulta = "INSERT INTO detalle_tmp (folio_pres,id_concepto,id_item,id_precio,precio,cantidad,total) VALUES ('$folio','$id_concepto','$id_item','$id_precio','$precio','$cantidad','$total')";
        
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta="UPDATE tmp_pres SET total=total+'$total' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


        //buscar subtotal
   /*     $consulta="SELECT total FROM tmp_pres WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        if ($resultado->rowCount() >= 1) {
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $dt) {
            $monto = $dt['total'];
        }
        }
        else{
            $monto=0;
        }
        //buscar descuento


        //actualizar descuento en tabla presupuesto

        $consulta="UPDATE tmp_pres SET descuento='$mdes' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();


*/

        $consulta = "SELECT * FROM vdetalle_tmp WHERE folio_pres='$folio' ORDER BY id_reg DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

        

        break;
        case 2:
            $consulta = "DELETE FROM detalle_tmp WHERE id_reg='$id' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            /*CAMBIO IVA INCLUIDO EN TODOS LOS PRECIOS */
            $consulta="UPDATE tmp_pres SET total=total-'$total' WHERE folio_pres='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=1;
         //buscar subtotal
        /*    $consulta="SELECT total FROM tmp_pres WHERE folio_pres='$folio'";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            if ($resultado->rowCount() >= 1) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $dt) {
                $monto = $dt['total'];
                }
                }
            else{
                $monto=0;
                }
         //buscar descuento
            $consulta="SELECT descuento FROM pdescuento WHERE '$monto' between m_inicial and m_final";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
    
            if ($resultado->rowCount() >= 1) {
                $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
                foreach ($data as $dt) {
                    $descuento = $dt['descuento'];
                }
                }
                else{
                    $descuento=0;
                }
    
          $mdes= round($monto * ($descuento/100),0);
         //actualizar descuento en tabla presupuesto
        $consulta="UPDATE tmp_pres SET descuento='$mdes' WHERE folio_pres='$folio'";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        
        */
        
        break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
$conexion = NULL;
