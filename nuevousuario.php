<?php

// array con la respuesta
$response = array();

if (!empty($_POST)) {
    
    $nombreusuario = $_POST['nombreusuario'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    //carga y se conecta a la base de datos
    require_once 'conexion.php';

    // Conecta a la BD
    $db = new DB_CONEXION();

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO usuarios(nombreusuario, email , contrasena ) 
                            VALUES('$nombreusuario', '$email', '$contrasena')");

    // Verifica si se han isertado filas
    if ($result) {
        // Insertó con éxito
        $response["success"] = 1;
        $response["message"] = "Usuario creado exitosamente";

        // codificando en JSON
        echo json_encode($response);
    } else {
        // fallo al insertar
        $response["success"] = 0;
        $response["message"] = "No se ha podido crear el usuario";
        
        // codificando en JSON
        echo json_encode($response);
    }
} else {
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Login</h1> 
          <form action="nuevousuario.php" method="post"> 
              Usuario:<br /> 
              <input type="text" name="nombreusuario" placeholder="usuario" /> 
              <br /><br /> 
              Email:<br /> 
              <input type="text" name="email" placeholder="email" /> 
              <br /><br />               
              Password:<br /> 
              <input type="password" name="contrasena" placeholder="password" value="" /> 
              <br /><br /> 
              <input type="submit" value="Login" /> 
          </form> 
      <a href="register.php">Registrar</a>
     <?php
}
?>