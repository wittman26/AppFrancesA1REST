<?php
header("Content-Type: text/html;charset=utf-8");

// Arreglo JSON para el response
$response = array();


// Incluye la conexión
require_once 'conexion.php';

// Inicia la conexión
$db = new DB_CONEXION();
$result = mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

// arroja todos los registros de Dossiers
$result = mysql_query("SELECT * FROM dossiers") or die(mysql_error());

// Verifica si hay resultados
if (mysql_num_rows($result) > 0) {

    $response["dossiers"] = array();
    
    //Recorre la lista de resultados
    while ($row = mysql_fetch_array($result)) {
        // arreglo temporal
        $dossier = array();
        $dossier["iddossier"] = $row["iddossier"];
        $dossier["nombredossier"] = $row["nombredossier"];

        // agrega el registro a la respuesta
        array_push($response["dossiers"], $dossier);
    }
    // exito
    $response["success"] = 1;

    // devuelve JSON response
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No se encontraron dossiers";

    // echo no users JSON
    echo json_encode($response);
}
?>
