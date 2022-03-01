<?php
 
 //Un controlador es un capturadr
 //de peticiones puede responder
 //texto, html,json,xml

 //Controles delega las peticiones y devuelve
 //la informacion correspondiente

 include_once "modelo/CatalogoModelo.php";

 class CatalogosControlador{

    private $catalogoModelo;

    //Inicializar variable para consumir el CatalogoModel, en base al constructor.

    function __construct()
    {
        $this ->catalogoModelo = new CatalogoModelo(); //Instancia para hacer uso de la clase de CatalogoModelo.php
    }

     public function obtenerCatalogoTipoContacto()
     {
        $catTipoContacto = $this -> catalogoModelo->obtenerCatalogoTipoContacto(); //para entrar a la public funcion de la clase CatalogoModelo
        return array(
            'success' => true,
            'msg' => array ('Se obtuvo el catalogo correctamente'),
            'data' => array (
                'catalogo_contacto' => $catTipoContacto
            )
        );
     }
 }

?>