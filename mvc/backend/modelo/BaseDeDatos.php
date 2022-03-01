<?php


    /* -> se usa para relacionar el $this con los atributos o los métodos de la clase desde el interior de ella y 
    para diferenciar entre el acceso a los métodos con $this y el acceso a los métodos static, 
    que se hace con instancia::metodo_estatico(). */

    //encapsulamiento forma de proteger metodos, atributos o clases


    include_once "ConfigDB.php";

    class BaseDeDatos{

        private $dbConfig; //guarda el archivo de la configuración
        private $mysqli;
        private $errores;

        function __construct()
        {
            try{
                $this->dbConfig = ConfigDB::getConfig(); //Para una funcion estatica (public function static )no se instancia solo se hace el 
                                                         //llamado poniendo el nombre de la clase, esta viene del archivo configDB.
                $this->mysqli = new mysqli(
                    $this->dbConfig['hostname'], //vienen desde la clase estatica del archivo ConfigDB.php
                    $this->dbConfig['usuario'],
                    $this->dbConfig['password'],
                    $this->dbConfig['base_datos'],
                    $this->dbConfig['puerto'],
                );
               
                if($this->mysqli->connect_errno){
                    $this->errores = $this->mysqli->error_list; //Lista de errores
                    echo 'Error en la conexion base de datos';die;
                }else{
                    $this->errores = array();
                }
                // $this -> mysqli -> set_charset("utf8");
            }catch (Exception $ex){
                $this->errores = $this->mysqli->error_list; //Lista de errores
                echo 'Error en la conexion de BD';die;
            }
        }   

        public function consultaRegistros($tabla,$condicionales = array()){ //Se manda como parametro el nombre de la tabla 
            
            $condiciones = $this->obtenerCondicionalesWhereAnd($condicionales);//manda a traer a la clase privda
            $query = $this->mysqli->query("select * from ".$tabla.$condiciones); //se concatena el nombre de la tabla que corresponda

            $datos = array();

            while($registro = $query->fetch_assoc()){
                $datos[] = $registro;
            }

            return $datos;
        }
  
        public function insertarRegistro($tabla, $valoresInsert){

            $columnasValoresSQL = $this->obtenerClavesYvaloresInsert($valoresInsert);//manda a traer a la clase privda
            $consultaInsertSQL = "INSERT INTO ".$tabla."(". $columnasValoresSQL['columnas'].") VALUES (".$columnasValoresSQL['valores'].")";
            // var_dump($consultaInsertSQL);exit;
            try{
                $query= $this->mysqli->query($consultaInsertSQL);
                if($query != true){
                    return false;
                }return true;
            }catch(Exception $ex){
                return false;
            }

        }

        public function actualizarRegistro($tabla, $valoresUpdate, $condicionales){
           
            try{
                $sqlCampoUpdate = $this->obtenerColumnaValorUpdate($valoresUpdate);//manda a traer a la clase privda
                $condicionesSQL =  $this->obtenerCondicionalesWhereAnd($condicionales); //manda a traer a la clase privda para las condiciones
                $consultaUpdateSQL = "UPDATE $tabla SET $sqlCampoUpdate $condicionesSQL ";
                // echo   $consultaUpdateSQL ;exit;
                $query= $this->mysqli->query($consultaUpdateSQL);
                // var_dump($query,$this->mysqli,$this->mysqli->errno,$this->mysqli->error,$this->mysqli->error_list); //funciones de mysqli
                if($query != true){
                    $this->errores = $this->mysqli->error_list; //Lista de errores
                    return false;
                }return true;
            }catch(Exception $ex){
                return false;
            }
            
        }

        public function EliminarRegistro($tabla, $condicionales){  //24-febrero-2022
            
            try{
                $condicionesSQL =  $this->obtenerCondicionalesWhereAnd($condicionales); //manda a traer a la clase privda para las condiciones
                // $consultaDeleteSQL = "DELETE FROM $tabla $condicionesSQL ";
                $consultaDeleteSQL = ("DELETE FROM ".$tabla.$condicionesSQL); //se concatena el nombre de la tabla que corresponda

                // echo  $consultaDeleteSQL ;exit;
                $query= $this->mysqli->query($consultaDeleteSQL);
                // var_dump($query,$this->mysqli,$this->mysqli->errno,$this->mysqli->error,$this->mysqli->error_list); //funciones de mysqli
                if($query != true){
                    $this->errores = $this->mysqli->error_list; //Lista de errores
                    return false;
                }return true;
            }catch(Exception $ex){
                return false;
            }

        }

        public function ultimoID(){

            return $this->mysqli->insert_id;
        }

        public function ultimoRegistro($tabla){

            $queryc = ("select * from ".$tabla." where ".'id='.$this->mysqli->insert_id); //se concatena el nombre de la tabla que corresponda
            //echo $queryc;exit;
            $query= $this->mysqli->query($queryc);

            $datos = array();

            while($registro = $query->fetch_assoc()){
                $datos[] = $registro;
            }

            return $datos;
        }

        public function getErrores()
        {
            $msgError = array();
            foreach($this->errores as $e){
                $msgError[] = "Codigo error: ".$e['errno']." Detalle/Explicacion: ".$e['error'];
            }
            // return $this->errores;
            return $msgError;
        }

        /**  functiones privadas
     * */

        /**
         * @param $condicionales
         * @return string
         * funcion que recibe un arragle de condiciones para los SQL where
         * array(array('nombre_columna1'=> valor1), array('nombre_columna2'=> valor2),...)
         */
        private function obtenerCondicionalesWhereAnd($condicionales){
            $condiciones = " WHERE 1=1";
            foreach ($condicionales as $columna => $valor){
                $condiciones .= " AND $columna = '$valor'";
            }
            return $condiciones;
        }


        /**
         * @param $valoresInsert
         * @return string
         * Obtener las columnas y los valores que se van a insertar
         */
        private function obtenerClavesYvaloresInsert($valoresInsert){
            $retorno = array();
            $nombreColumnas = ""; //nombre,paterno,materno...
            $valoresColumnas = ""; //Viridiana,Chavarria,Zarate...
            $iteracionCampos = 1;
            $maxItCampo = sizeof($valoresInsert);
            foreach ($valoresInsert as $columna => $valor){

                $nombreColumnas .= $columna;
                $valoresColumnas .= "'".$valor."'";
                if($iteracionCampos < $maxItCampo){
                    $nombreColumnas .= ',';
                    $valoresColumnas .= ',';
                }
                $iteracionCampos ++;
            }
            $retorno ['columnas'] = $nombreColumnas;
            $retorno ['valores'] = $valoresColumnas;

            return $retorno;
        }


        private function obtenerColumnaValorUpdate($camposUpdate){
            $campoValorSQL = "";
            $iteracionCampos = 1;
            $maxItCampo = sizeof($camposUpdate);

            foreach ($camposUpdate as $columna => $valor){

                $campoValorSQL .= " $columna = '$valor'";
               
                if($iteracionCampos < $maxItCampo){
                    $campoValorSQL .= ',';
                }
                $iteracionCampos ++;
            }
            return  $campoValorSQL;
        }

    }
?>