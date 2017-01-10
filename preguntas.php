<?php
header("Content-Type: text/html;charset=utf-8");
//carga y se conecta a la base de datos
require_once 'conexion.php';

    //Si hay parámetros
    if (!empty($_POST)) {

        $idactaprend = $_POST['idactaprend'];

        $response["preguntas"] = array();

        // Conecta a la BD
        $db = new DB_CONEXION();
        //mysql_set_charset('utf8');
        $result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

        // Consulta usuario
        $query = " SELECT *
                    FROM preguntas
                    WHERE idactaprend = '$idactaprend' ";
        $result = mysql_query($query);
        

        // Verifica si hay resultados
        if (mysql_num_rows($result) > 0) {

            $response["preguntas"] = array();
            
            while ($row = mysql_fetch_array($result)) {
                $pregunta = array();
                $idpregunta = $row["idpregunta"];

                $pregunta["idpregunta"] = $row["idpregunta"];
                $pregunta["descripcionp"] = $row["descripcionp"];
                $pregunta["tipopregunta"] = $row["tipopregunta"];
                $pregunta["puntaje"] = $row["puntaje"];
                $pregunta["idactaprend"] = $row["idactaprend"];

                $pregunta["respuestas"] = array();


                $query2 = " SELECT *
                            FROM respuestas
                            WHERE idpregunta = '$idpregunta' ";

                $result2 = mysql_query($query2);

                while ( $row2 = mysql_fetch_array($result2)) {
                  $respuesta = array();

                  $respuesta["idrespuesta"] = $row2["idrespuesta"];
                  $respuesta["descripcionr"] = $row2["descripcionr"];
                  $respuesta["rcorrecta"] = $row2["rcorrecta"];

                  array_push($pregunta["respuestas"], $respuesta);
                }
            
                array_push($response["preguntas"], $pregunta);
            }

            $response["success"] = 1;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response["success"] = 0;
            $response["message"] = "No hay preguntas para esta actividad";
            die(json_encode($response));
        }
    } else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Preguntas</h1> 
          <form action="preguntas.php" method="post"> 
              Id de Actividad:<br /> 
              <input type="text" name="idactaprend" placeholder="idactaprend" /> 
              <br /><br /> 
              <input type="submit" value="Buscar" /> 
          </form> 
      <a href="dossiers.php">Ver Dossiers</a>
     <?php
    }

?>