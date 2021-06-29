<?php
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$inicio = (isset($_GET['inicio'])) ? $_GET['inicio'] : '';
$fin = (isset($_GET['fin'])) ? $_GET['fin'] : '';
$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';

if ($folio != "" && $inicio != "" && $fin != "") {

    $consultatabla = "SELECT * FROM frente where id_ord='$folio'";

    $resultadotabla = $conexion->prepare($consultatabla);
    $resultadotabla->execute();


    $datatabla = $resultadotabla->fetchAll(PDO::FETCH_ASSOC);
}


?>

<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                <thead class="text-center bg-gradient-secondary">
                    <tr>
                        <th>Concepto</th>
                        <?php
                        $cntafrente = "SELECT id_frente,nom_frente FROM frente where id_ord='$folio' and estado_frente=1 order by id_frente";
                        $resfrente = $conexion->prepare($cntafrente);
                        $resfrente->execute();
                        $regfrente = $resfrente->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($regfrente as $rowfrente) {
                        ?>
                            <th><?php echo $rowfrente['nom_frente'] ?></th>
                        <?php } ?>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $consultadeto = "SELECT id_concepto,nom_concepto FROM detalle_conceptosobra where id_orden='$folio' order by id_concepto";
                    $resultadodeto = $conexion->prepare($consultadeto);
                    $resultadodeto->execute();
                    $datadeto = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($datadeto as $rowdet) {
                        $id_concepto = $rowdet['id_concepto'];

                        echo '<tr>';

                        echo '<td>' . $rowdet['nom_concepto'] . '</td>';


                        foreach ($regfrente as $rowfrente) {
                            $id_frente = $rowfrente['id_frente'];
                            $consultadeto = "SELECT sum(cantidad) as cantidad FROM v_resgenerador join detalle_gen ON v_resgenerador.folio_gen=detalle_gen.folio_gen where id_frente='$id_frente' and id_concepto='$id_concepto' and fecha between '$inicio' and '$fin' group by id_frente,id_concepto";
                            $resultadodeto = $conexion->prepare($consultadeto);
                            if ($resultadodeto->execute()) {
                                if ($resultadodeto->rowCount()>=1){
                                    $datadet = $resultadodeto->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($datadet as $rowreg) {

                                    echo '<td class="text-right">' . $rowreg['cantidad'] . '</td>';
                                }
                                }
                                else{
                                    echo '<td class="text-right">0.00</td>';
                                }
                                
                            } else {
                                echo '<td class="text-right">0</td>';
                            }
                        }

                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var id, opcion;
        opcion = 4;

        tablaVis = $("#tablaV").DataTable({





            //Para cambiar el lenguaje a español
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            }
        });


    });
</script>