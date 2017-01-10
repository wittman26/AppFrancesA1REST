<?php

// array con la respuesta
$response = array();

if (!empty($_POST)) {
    
    $nombreusuario = $_POST['nombreusuario'];

    //carga y se conecta a la base de datos
    require_once 'conexion.php';

    // Conecta a la BD
    $db = new DB_CONEXION();

    // actualizando usuario
    $result = mysql_query(" DELETE FROM puntajeactaprend
                            WHERE nombreusuario = '$nombreusuario'");

    // Verifica si se han actualizado filas
    if ($result) {

          $result2 = mysql_query(" DELETE FROM usuarios
                                   WHERE nombreusuario = '$nombreusuario'");

          if ($result2) {
            // Eliminó con éxito
            $response["success"] = 1;
            $response["message"] = "Usuario eliminado exitosamente";

            // codificando en JSON
            echo json_encode($response);            
          } else {
            // fallo al eliminar
            $response["success"] = 0;
            $response["message"] = "No se ha podido eliminar el usuario";
            
            // codificando en JSON
            echo json_encode($response);
          }

    } else {
        // fallo al insertar
        $response["success"] = 0;
        $response["message"] = "No se ha podido eliminar los puntajes de usuario";
        
        // codificando en JSON
        echo json_encode($response);
    }
} else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Eliminar</h1> 
          <form action="eliminarperfil.php" method="post"> 
              Usuario:<br /> 
              <input type="text" name="nombreusuario" placeholder="usuario" /> 
              <br /><br /> 
              <input type="submit" value="eliminar" /> 
          </form> 
     <?php
}
?>