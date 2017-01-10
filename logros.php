<?php
header("Content-Type: text/html;charset=utf-8");
//carga y se conecta a la base de datos
require_once 'conexion.php';

    //Si hay parámetros
    if (!empty($_POST)) {

        $nombreusuario = $_POST['nombreusuario'];


        // Conecta a la BD
        $db = new DB_CONEXION();
        //mysql_set_charset('utf8');
        $result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

        // Consulta de logros
        $query = "  SELECT SUM(puntajeactaprend.puntajeacumulado) AS puntajeacumulado, 
                          puntajeactaprend.nombreusuario AS nombreusuario, 
                          dossiers.iddossier AS iddossier1,
                          dossiers.nombredossier AS nombredossier,
                    (
                      SELECT SUM(preguntas.puntaje)
                      FROM preguntas
                      INNER JOIN actaprend  AS A ON A.idactaprend = preguntas.idactaprend
                      INNER JOIN dossiers AS D ON A.iddossier = D.iddossier
                      WHERE D.iddossier = iddossier1
                      GROUP BY D.iddossier
                    ) as puntajemaximo
                    FROM puntajeactaprend
                    INNER JOIN actaprend ON puntajeactaprend.idactaprend = actaprend.idactaprend
                    INNER JOIN dossiers ON actaprend.iddossier = dossiers.iddossier
                    WHERE puntajeactaprend.nombreusuario = '$nombreusuario'
                    GROUP BY puntajeactaprend.nombreusuario, dossiers.iddossier";
        $result = mysql_query($query);

        // Verifica si hay resultados
        if (mysql_num_rows($result) > 0) {

            $response["logros"] = array();
            
            while ($row = mysql_fetch_array($result)) {
                $logro = array();

                $logro["puntajeacumulado"] = $row["puntajeacumulado"];
                $logro["iddossier"] = $row["iddossier1"];
                $logro["nombredossier"] = $row["nombredossier"];
                $logro["puntajemaximo"] = $row["puntajemaximo"];

                array_push($response["logros"], $logro);
            }

            $response["success"] = 1;
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
        } else {
            $response["success"] = 0;
            $response["message"] = "Hubo error al traer logros: ".$query;
            die(json_encode($response));
        }
    } else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Logros</h1> 
          <form action="logros.php" method="post"> 
              Nombre usuario:<br /> 
              <input type="text" name="nombreusuario" placeholder="nombreusuario" /> 
              <br /><br /> 
              <input type="submit" value="Buscar" /> 
          </form> 
      <a href="dossiers.php">Ver Dossiers</a>
     <?php
    }

?>