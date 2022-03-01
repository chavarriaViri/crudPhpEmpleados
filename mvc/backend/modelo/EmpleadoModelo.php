<?php
    //El controlador tiene que delegar las peticiones hacia un modelo
    //El modelo es el que obtiene la informacion o el acceso a los datos 
    //Fornatear datos, validacion, carpeta de modelo ideal (porque se obtienen desde la base de datos)
    
    include_once "ModeloBase.php";


    class EmpleadoModelo extends ModeloBase
    {
        function __construct(){ 
            parent::__construct('empleados'); //Hacer que el padre del ModeloBase ejecute su constructor
        }


    }

?>