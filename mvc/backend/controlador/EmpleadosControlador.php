<?php
 
 //Un controlador es un capturadr
 //de peticiones puede responder
 //texto, html,json,xml

 //Controles delega las peticiones y devuelve
 //la informacion correspondiente
 include_once "modelo/EmpleadoModelo.php";
 include_once "modelo/ContactoEmpleadoModelo.php";
 include_once "helper/ValidacionFormulario.php";



 class EmpleadosControlador{


    private $empleadoModelo;
    private $contactoEmpleadoModelo;

    //Inicializar variable para consumir el CatalogoModel, en base al constructor.

    function __construct()
    {
        $this->empleadoModelo = new EmpleadoModelo(); 
        $this->contactoEmpleadoModelo = new ContactoEmpleadoModelo();

    }

    public function listado()
    {
       //tarea listar como el de catalogosControlador
       $empleadoDatos = $this -> empleadoModelo->obtenerListado(); //para entrar a la public funcion de la clase EmpleadoModelo
       $empleadoRespuesta = array();

       foreach ($empleadoDatos as $index => $empleado){
            $condicionesWhere = array(
                'empleados_id' => $empleado['id']
            );
            $contactoEmpleado = $this->contactoEmpleadoModelo->obtenerListado($condicionesWhere);
            $empleado['datos_contacto'] = $contactoEmpleado;
            $empleadoRespuesta[$index] = $empleado;
        }

        return array(
            'success' => true,
            'msg' => array ('Se obtuvo el listado de empleados correctamente'),
            'data' => array (
                'empleados' => $empleadoRespuesta //Se imprime la respuesta
            )
        );
    }

    public function agregar($datosFormularios)
    {
        $respuesta = array(
            'success' => false,
            'msg' => array ('No se inserto el empleado'),
        );
        //var_dump($datosFormularios);exit;
        $datosContacto = $datosFormularios['listado_datos_contacto'];
        unset($datosFormularios['listado_datos_contacto']); 

        $validacion = ValidacionFormulario ::validarFormEmpleadoNuevo($datosFormularios);
        
        if($validacion['status']){ //Si estatus es verdadera hace el guardado correspondiente
            $empleadoNuevo = $this->empleadoModelo->insertar($datosFormularios);
            //var_dump($empleadoNuevo);exit;
            if($empleadoNuevo){
                
                 //recuperar el id del empleado registrado
                 $idNuevoEmpleado = $this->empleadoModelo->ultimoID();
                 $guardoContacto = true;
                 foreach ($datosContacto as $dc){
                    $dc['empleados_id'] = $idNuevoEmpleado;
                    $guardoContacto = $this->contactoEmpleadoModelo->insertar($dc);
                 }
                if($guardoContacto){
                    $empleadoDatos = $this -> empleadoModelo->obtenerUltimoInsertado(); //para entrar a la public funcion de la clase EmpleadoModelo
                    $empleadoInsertado = array();
                    foreach ($empleadoDatos as $index => $empleado){
                        
                        $empleadoRespuesta[$index] = $empleado;
                    }
                    $respuesta = array(
                        'success' => true,
                        'msg' => array('Se registro el empleado correctamente'),
                        'data' => array (
                             'empleado' => $empleadoRespuesta //Se imprime los datos del contacto
                         )
                    );
                }else{
                    $respuesta = array(
                        'success' => false,
                        'msg' => array ('Faltaron datos del contacto'),
                        
                    );
                }
            }
            
        }else{ // si no devuelve los mensajes que se obtuvieron
            $respuesta['success'] = false;
            $respuesta['msg'] = $validacion['msg'];

        }
        return $respuesta;
    }

    public function actualizar($datosFormularios)
    {
        $respuesta = array(
            'success' => false,
            'msg' => array ('No se actualizo el empleado'),
        );
        $datosContacto = $datosFormularios['listado_datos_contacto'];
        unset($datosFormularios['listado_datos_contacto']);
        $validacion = ValidacionFormulario ::validarFormEmpleadoActualizar($datosFormularios);
        if($validacion['status']){ //Si estatus es verdadera hace el guardado correspondiente
            $id_empleado = $datosFormularios['id_empleado'];
            unset($datosFormularios['id_empleado']);
            $empleadoActualizar = $this->empleadoModelo->actualizar($datosFormularios,array('id'=> $id_empleado));
            // var_dump($empleadoActualizar);exit;
            if($empleadoActualizar){
                $guardoContacto = true;
                $this->contactoEmpleadoModelo->eliminar(array('empleados_id' => $id_empleado));
                foreach ($datosContacto as $dc){
                    $dc['empleados_id'] = $id_empleado;
                    $guardoContacto = $this->contactoEmpleadoModelo->insertar($dc);
                }
                if($guardoContacto){
                    $respuesta = array(
                        'success' => true,
                        'msg' => array ('Se actualizo correctamente'),
                    );
                }else{
                    $respuesta = array(
                        'success' => false,
                        'msg' => array('Faltaron los datos de contacto'),
                    );
                }
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $this->empleadoModelo->getErrores(); //para la funcion de errores
            }
        }else{ 
            $respuesta['success'] = false;
            $respuesta['msg'] = $validacion['msg'];

        }
        return $respuesta;
    }

    public function eliminar($datosFormularios)
    {   
        $respuesta = array(
            'success' => false,
            'msg' => array ('No se elimino el empleado'),
        );
        $validacion = ValidacionFormulario ::validarFormEmpleadoEliminar($datosFormularios);
        if($validacion['status']){ //Si estatus es verdadera hace el guardado correspondiente
            $id = $datosFormularios['id'];
          
            $this->contactoEmpleadoModelo->eliminar(array('empleados_id' => $id));
            $empleadoEliminar = $this->empleadoModelo->eliminar($datosFormularios,array('id'=> $id));
            // var_dump($empleadoEliminar);exit;
            if($empleadoEliminar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array ('Se elimino correctamente'),
                );
            }else{
                $respuesta['success'] = false;
                $respuesta['msg'] = $this->empleadoModelo->getErrores(); //para la funcion de errores
            }
            return $respuesta;
        }else{ 
            $respuesta['success'] = false;
            $respuesta['msg'] = $validacion['msg'];

        }
        return $respuesta;
    }
 }

?>