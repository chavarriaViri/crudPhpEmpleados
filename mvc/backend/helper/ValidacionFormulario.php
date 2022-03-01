<?php

    class ValidacionFormulario{ 

        public static function validarFormEmpleadoNuevo($datosFormularios){
            $validacion ['status'] = true;
            $validacion ['msg'] = array();

            if(!isset ($datosFormularios['nombre']) || $datosFormularios['nombre'] == ''){//Si no existe el campo o tiene una cadena vacia
                $validacion ['status'] = false; //cambia a falso
                $validacion ['msg'][] = 'El campo nombre es requerido'; 
            }if(!isset ($datosFormularios['paterno']) || $datosFormularios['paterno'] == ''){
                $validacion ['status'] = false; 
                $validacion ['msg'][] = 'El campo apellido paterno es requerido'; 
            }if(!isset ($datosFormularios['materno']) || $datosFormularios['materno'] ==''){
                $validacion ['status'] = false; 
                $validacion ['msg'][] = 'El campo apellido materno es requerido'; 
            }if(!isset ($datosFormularios['direccion']) || $datosFormularios['direccion'] == ''){
                $validacion ['status'] = false; 
                $validacion ['msg'][] = 'El campo dirección es requerido'; 
            }if(!isset ($datosFormularios['fecha_nacimiento']) || $datosFormularios['fecha_nacimiento'] == ''){
                $validacion ['status'] = false; 
                $validacion ['msg'][] = 'El campo fecha de nacimiento es requerido'; 
            }

            return $validacion;
        }

        public static function validarFormEmpleadoActualizar($datosFormularios){
            $validacion =  self::validarFormEmpleadoNuevo($datosFormularios);
            if(!isset ($datosFormularios['id_empleado']) || $datosFormularios['id_empleado'] == ''){
                $validacion ['status'] = false; 
                $validacion ['msg'][] = 'El campo identificador es requerido'; 
            }

            return $validacion;
        }

        public static function validarFormEmpleadoEliminar($datosFormularios){

            $validacion ['status'] = true;
            $validacion ['msg'] = array();

            if(!isset ($datosFormularios['id']) || $datosFormularios['id'] == ''){
                $validacion ['status'] = false; //cambia a falso
                $validacion ['msg'][] = 'El campo identificador es requerido'; 
            }
            

            return $validacion;
        }


    }

    
?>