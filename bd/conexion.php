<?php
    class conn{
        
        function connect(){
      
          define('servidor','tecniem.com');
            define('bd_nombre','tecniemc_gstec');
            define('usuario','tecniemc_gs');
            define('password','GS2020erptec');
            
/*
   
            define('servidor','server');
            define('bd_nombre','tecniemc_gs');
            define('usuario','root');
            define('password','');
 */
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