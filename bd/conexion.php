<?php
    class conn{
        
        function connect(){
        
            define('servidor','localhost');
            define('bd_nombre','tecniemc_gs');
            define('usuario','tecniemc_gs');
            define('password','GS2020erptec');

            $opciones=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

            try{
                $conexion=new PDO("mysql:host=".servidor.";dbname=".bd_nombre, usuario,password, $opciones);
                return $conexion;
            }catch(Exception $e){
                return null;
            }
        }
    }
?>