<?php

$miArray = $_GET['data'];
$miArray = explode(',', $miArray); 
print_r(array_values($miArray));

echo '<br>';

  
    foreach ($miArray as $valor) {
        echo $valor.'<br>';
    }

?>