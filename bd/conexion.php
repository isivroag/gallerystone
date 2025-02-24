<?php
    class conn{
        
        function connect(){
/*      
          define('servidor','gallerystone.mx');
            define('bd_nombre','gallery1_gs');
            define('usuario','gallery1_admin');
            define('password','Gs.2024.Mayo');
            
*/
/*
    define('servidor','tecniem.com');
            define('bd_nombre','tecniemc_gs');
            define('usuario','tecniemc_gs');
            define('password','Gs2020.1.2024');
*/
/*
            define('servidor','192.168.3.45');
            define('bd_nombre','tecniemc_gs');
            define('usuario','root');
            define('password','');
            */
            define('servidor','tecniem.com');
            define('bd_nombre','tecniemc_gstec');
            define('usuario','tecniemc_gs');
            define('password','Gs2020.1.2024');
 
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