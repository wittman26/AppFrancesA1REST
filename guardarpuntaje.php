<?php

header("Content-Type: text/html;charset=utf-8");
//carga y se conecta a la base de datos
require_once 'conexion.php';


// check for required fields
if (!empty($_POST)) {
    
    $nombreusuario = $_POST['nombreusuario'];
    $idactaprend = $_POST['idactaprend'];
    $puntajeacumulado = $_POST['puntajeacumulado'];

    // Conecta a la BD
    $db = new DB_CONEXION();

    $result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

    // Consulta puntaje
    $query = " SELECT *
                FROM puntajeactaprend
                WHERE nombreusuario = '$nombreusuario'
                AND   idactaprend = '$idactaprend' ";
    $result = mysql_query($query);

    $banderaUpdate = "";

    // Verifica si hay resultados
    if (mysql_num_rows($result) > 0) { 
        //Hace update     
        $banderaUpdate = "ACTUALIZADO";
        $operacion = mysql_query("  UPDATE puntajeactaprend
                                    SET puntajeacumulado = '$puntajeacumulado'
                                    WHERE nombreusuario = '$nombreusuario'
                                    AND idactaprend = '$idactaprend'");      
    } else {
        //Hace insert
        $operacion = mysql_query("INSERT INTO puntajeactaprend(nombreusuario, idactaprend, puntajeacumulado) 
                                    VALUES('$nombreusuario', '$idactaprend', '$puntajeacumulado')");      
    }

    // Chequea si inserta bien
    if ($operacion) {
        // Exitoso
        $response["success"] = 1;
        $response["message"] = "puntaje almacenado ".$banderaUpdate;

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Hubo error al insertar";
        
        // echoing JSON response
        echo json_encode($response);
    }    



} else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Preguntas</h1> 
          <form action="guardarpuntaje.php" method="post"> 
              Usuario:<br /> 
              <input type="text" name="nombreusuario" placeholder="nombreusuario" /><br /> 
              Id de Actividad:<br /> 
              <input type="text" name="idactaprend" placeholder="idactaprend" /><br />
              Puntaje:<br /> 
              <input type="text" name="puntajeacumulado" placeholder="puntajeacumulado" /><br />              
              <br /> 
              <input type="submit" value="Guardar" /> 
          </form> 
      <a href="dossiers.php">Ver Dossiers</a>
     <?php
}
?>