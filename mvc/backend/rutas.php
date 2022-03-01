<?php

    include_once "controlador/CatalogosControlador.php";
    include_once "controlador/EmpleadosControlador.php";

    // echo 'hola mundo rutas';
    //obtener los datos de la url GET para los parametros de la peticion
    $parametros_get = $_GET; //para obtener los parametros con la variable global $_GET
    // var_dump($parametros_get);

    $respuesta_backend = array(
        'success' => false,
        'msg' => array(
            'Error no encontro la peticion solicitada'
        )
    );

    $parametros_post = $_POST; //para enviar parametros con la variable global $_POST, es todo lo que se manda en el body de la peticion post de POSTMAN


    //instancia a la clase
    $rutas = new Rutas();

    //Si existe la peticion o el mensaje no esta vacio muestra mensaje de 'existe la peticion' entra al if
    if(isset($parametros_get['peticion']) && $parametros_get['peticion'] != ''  && isset($parametros_get['funcion']) && $parametros_get['funcion'] != '' ){
        //echo 'existe la peticion';
        switch($parametros_get['peticion']){
            case 'catalogos':
                // echo 'entre a peticion de catalogos';exit;
                $catControlador = new CatalogosControlador();
                switch($parametros_get['funcion'])
                {
                    case 'tipo_contacto':
                        $respuesta_controlador =  $catControlador -> obtenerCatalogoTipoContacto();
                        // var_dump($respuessta_controlador);
                        $rutas->peticion(200,$respuesta_controlador);
                        break;
                    default:
                        $rutas->peticion(404,$respuesta_backend);
                        break;
                }
                break;
            case 'empleados':
                $empControlador = new EmpleadosControlador();
                switch($parametros_get['funcion'])
                {
                    case 'listado':
                        $respuesta_controlador =  $empControlador -> listado();
                        $rutas->peticion(200,$respuesta_controlador); //Tarea 22 febrero 2022
                        break;
                    case 'agregar':
                        $respuesta_controlador =  $empControlador -> agregar($parametros_post);
                        $rutas->peticion($respuesta_controlador['success'] ? 201 : 400, $respuesta_controlador); //terna: condicion ? vverdadero :vfalso
                        break;
                    case 'actualizar':
                        $respuesta_controlador =  $empControlador -> actualizar($parametros_post);
                        $rutas->peticion($respuesta_controlador['success'] ? 200 : 400, $respuesta_controlador); //terna: condicion ? vverdadero :vfalso
                        break;
                    case 'eliminar':
                        $respuesta_controlador =  $empControlador -> eliminar($parametros_post);
                        $rutas->peticion($respuesta_controlador['success'] ? 200 : 400, $respuesta_controlador); //terna: condicion ? vverdadero :vfalso
                        break;
                    default:
                        $rutas->peticion(404,$respuesta_backend);
                        break;
                }
                break;
            default:
                 $rutas->peticion_no_encontrada($respuesta_backend);
        }

    }else{
        $rutas->peticion(404,$respuesta_backend);

    }

    class Rutas{
        
        public function peticion($codigo,$respuesta){
            http_response_code($codigo);
            echo json_encode($respuesta);
        }
    }
?>