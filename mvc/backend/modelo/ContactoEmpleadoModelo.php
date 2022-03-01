<?php

    include_once "ModeloBase.php";

    class ContactoEmpleadoModelo extends ModeloBase
    { 

        function __construct()
        { 
            parent::__construct('contacto_empleados'); //Hacer que el padre del ModeloBase ejecute su constructor
            //nombre de la tabla 'catalogo_tipo_contacto'
        }
    }
?>