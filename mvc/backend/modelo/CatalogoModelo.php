<?php
    //El controlador tiene que delegar las peticiones hacia un modelo
    //El modelo es el que obtiene la informacion o el acceso a los datos 
    //Fornatear datos, validacion, carpeta de modelo ideal (porque se obtienen desde la base de datos)

    //Nota_x: Para hacer una instancia se tiene que mandar a traer el archivo del cual se realizara una instancia.

    //Hace usuo de todos los catalogos

    include_once "CatalogoTipoContacto.php";

    class CatalogoModelo 
    {

        //Entidad es un archivo de php donde se esta instanciando una tabla de la base de datos

        public function obtenerCatalogoTipoContacto(){
            
            try{
                
                $ctcModel = new CatalogoTipoContacto(); //instancia para acceder a la clase del archivo BaseDeDatos.php
                $catTipoContacto = $ctcModel->obtenerListado();
    
                return $catTipoContacto;

            }catch(Exception $ex){
                echo 'Error BD';die;
            }
           
            
        }
    }

?>