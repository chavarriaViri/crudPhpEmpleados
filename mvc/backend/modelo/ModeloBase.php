<?php

    /*
    Realizar las operaciones basicas  de la base de datos
    CRUD: select, update, delete, insert
    dinamicamente  es el nombre de la tabla
    */

    include_once "BaseDeDatos.php";

    //La clase ModeloBase va a heredar todas las funciones, metodos y atributos que contiene la clase BaseDeDatos
    class ModeloBase extends BaseDeDatos
    {

        private $tabla;

        //Para que funcione la clase padre BaseDeDatos se necesita inicializar
        function __construct($nombreTabla){ 
            parent::__construct(); //Hacer que el padre del ModeloBase ejecute su constructor
            $this->tabla = $nombreTabla; //la que se recibe en el contructor
        }

        public function obtenerListado($condiciones = array()){
            return $this->consultaRegistros($this->tabla,$condiciones);
        }

        public function insertar($valoresInsert){
            return $this->insertarRegistro($this->tabla,$valoresInsert);
        }

        public function actualizar($valoresUpdate, $condicionales){
            return $this->actualizarRegistro($this->tabla,$valoresUpdate,$condicionales);
        }

        public function eliminar($condicionales){
            return $this->EliminarRegistro($this->tabla,$condicionales);
        }

        public function obtenerUltimoInsertado(){ //pendiente
            return $this->ultimoRegistro($this->tabla);
        }
    }
?>