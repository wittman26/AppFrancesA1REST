<?php

//Permite validar usuario y contraseña, para hacer la conexión a la base de datos
require_once 'conexion.php';//Llama al archivo 

    //Si hay datos (usuario y contraseña)
    
	if (!empty($_POST)) {//Si hay datos

        $usuario = $_POST['usuario'];//variable usuario = al parametro usuario introducido
        $password = $_POST['password'];//variable contraseña = al parametro contraseña introducido

        $response["usuario"] = array();//El atributo usuario = a un vector

        // Conecta a la BD
        $db = new DB_CONEXION();//Crea un objeto tipo db_conexión para conectar

        // Consulta usuario
        $query = " SELECT nombreusuario, email, contrasena
                    FROM usuarios 
                    WHERE nombreusuario = '$usuario'";//Consulta la base de datos

        $result = mysql_query($query);//Ejecuta la anterior sentencia

        //Se inicia indicador en false
        $login_ok = false;

        // Si encuentra el usuario, asigna datos
        if (mysql_num_rows($result) > 0) {
            
            while ($row = mysql_fetch_array($result)) {//Asignando los datos llena el vector usuario
                $usuario = array();
                $usuario["nombreusuario"] = $row["nombreusuario"];
                $usuario["email"] = $row["email"];
                $usuario["contrasena"] = $row["contrasena"];
            }

            //Verificar contraseña, comparando la contraseña gurdada en el vector usuario, con lo digitado
            if ($password === $usuario["contrasena"]) {
                array_push($response["usuario"], $usuario);
                $login_ok = true;//indicador en verdadero
            }            
        }
        
        // Valida loging y devuelve respuesta
        if ($login_ok) {//indicador en verdadero
            $response["success"] = 1;//Exitoso
            echo json_encode($response);//Codifica en Json
        } else {//indicador en falso
            $response["success"] = 0;//Fallido
            $response["message"] = "Login INCORRECTO";//mensaje por pantalla
            die(json_encode($response));//Codifica en Json
        }
		
		
    } else {//No hay datos
    ?>
      <!--Si no hay parámetros los pregunta-->
      <h1>Login</h1> 
          <form action="login.php" method="post"> 
              Usuario:<br /> 
              <input type="text" name="usuario" placeholder="usuario" /> 
              <br /><br /> 
              Password:<br /> 
              <input type="password" name="password" placeholder="password" value="" /> 
              <br /><br /> 
              <input type="submit" value="Login" /> 
          </form> 
      <a href="register.php">Registrar</a>
     <?php
    }

?> 