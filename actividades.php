<?php
header("Content-Type: text/html;charset=utf-8");
//carga y se conecta a la base de datos
require_once 'conexion.php';

    //Si hay parámetros
    if (!empty($_POST)) {

        $iddossier = $_POST['iddossier'];

        $response["actividades"] = array();

        // Conecta a la BD
        $db = new DB_CONEXION();
        //mysql_set_charset('utf8');
        $result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

        // Consulta usuario
        $query = " SELECT idactaprend, nombreact, tipoactaprend
                    FROM actaprend
                    WHERE iddossier = '$iddossier'";
        $result = mysql_query($query);

        // Verifica si hay resultados
        if (mysql_num_rows($result) > 0) {

            $response["actividades"] = array();
            
            while ($row = mysql_fetch_array($result)) {
                $actividad = array();

                $actividad["idactaprend"] = $row["idactaprend"];
                $actividad["nombreact"] = $row["nombreact"];
                $actividad["tipoactaprend"] = $row["tipoactaprend"];
                array_push($response["actividades"], $actividad);
            }

            $response["success"] = 1;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response["success"] = 0;
            $response["message"] = "No hay actividades para este dossier";
            die(json_encode($response));
        }
    } else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Login</h1> 
          <form action="actividades.php" method="post"> 
              Id de Dossier:<br /> 
              <input type="text" name="iddossier" placeholder="iddossier" /> 
              <br /><br /> 
              <input type="submit" value="Buscar" /> 
          </form> 
      <a href="dossiers.php">Ver Dossiers</a>
     <?php
    }

?>