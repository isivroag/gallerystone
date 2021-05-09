<?php

$fechaact=date("Y-m-d");
$mod_date = strtotime($fechaact."+ 15 days");
$fechalim=date("d-m-Y",$mod_date);
echo $fechalim;
?>