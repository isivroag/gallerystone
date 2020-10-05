<?php
    class conn{
        
        function connect(){
        
            define('servidor','localhost');
            define('bd_nombre','c0110108_gs');
            define('usuario','c0110108_gs');
            define('password','GS2020erp');

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