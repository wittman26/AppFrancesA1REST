<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require_once 'conexion.php';

// connecting to db
$db = new DB_CONEXION();

// get all products from products table
$result = mysql_query("SELECT * FROM empleados") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["empleados"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $empleado = array();
        $empleado["cedula"] = $row["cedula"];
        $empleado["nombre"] = $row["nombre"];
        $empleado["apellido"] = $row["apellido"];
        $empleado["sueldo"] = $row["sueldo"];

        //$product["created_at"] = $row["created_at"];
        //$product["updated_at"] = $row["updated_at"];



        // push single product into final response array
        array_push($response["empleados"], $empleado);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No empleados found";

    // echo no users JSON
    echo json_encode($response);
}
?>
