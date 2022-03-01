<?php
   
    include_once "ModeloBase.php";

    class CatalogoTipoContacto extends ModeloBase
    {

        function __construct()
        { 
            parent::__construct('catalogo_tipo_contacto'); //Hacer que el padre del ModeloBase ejecute su constructor
            //nombre de la tabla 'catalogo_tipo_contacto'
        }

    }

?>