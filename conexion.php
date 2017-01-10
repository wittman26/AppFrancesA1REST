<?php

// Realiza la conexión a la base de datos (la abre y cierra)
    class DB_CONEXION {

        // constructor: me conecta
        function __construct() {
            // conexión a la base
            $this->conectar();
        }

        // destructor: me cierra la conexión
        function __destruct() {
            // cerrando la conexión
            $this->close();
        }        

        //Función conectar
        public function conectar() {
            require_once 'config.php'; //Llama el archivo con las variables globales
            $conexion = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());//conecta usando las variables
            mysql_select_db(DB_DATABASE);//Selecciona la base de datos
            return $conexion;
        }
     
        public function close() {
            mysql_close();
        } 
    }
?>