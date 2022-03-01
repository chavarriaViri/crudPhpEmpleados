<?php


class ConfigDB{

    public static function getConfig(){
        switch ($_SERVER['SERVER_NAME']){ //En los case se pueden configurar las opciones de servidor con el nombre del servidor
            case 'empleadossoftura.000webhostapp.com':
            $dbConfig = array(
                'hostname' => 'localhost',
                'usuario' =>  'id18538487_softura',
                'password' => 'Contra$$5678',
                'base_datos' => 'id18538487_cap_softura_php',
                'puerto' => '3306'
             );
             break;
            default:
            $dbConfig = array(
                'hostname' => 'localhost',
                'usuario' =>  'root',
                'password' => '',
                'base_datos' => 'cap_softura_php',
                'puerto' => '3306',
            
             );

            
             break;
        }
        
        return $dbConfig;
    }

}

?>