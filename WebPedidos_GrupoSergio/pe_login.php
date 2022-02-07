<?php
  require_once ("funcionesComunes/funcionesComunes.php");
  $conexion = abrirConexion();
  if($_POST){ //Cuando se completan los datos, se viene aquí.
      $usuario= test_input($_POST['usuario']);
      $password= test_input($_POST['password']);
      //Consulta: ¿Hay algún cliente con el usuario y la contraseña introducidas? Si es que sí, entonces entra en el if, si no dice que son incorrectos.
      $query=$conexion->prepare("SELECT customerNumber, contactLastName FROM customers WHERE customerNumber= :usuario AND contactLastName = :password");
      $query->bindParam(":usuario", $usuario); //Esto es simplemente una asociación de variables. Hasta que no se ejecuta, no se hace.
      $query->bindParam(":password", $password); //Se asocia el password introducido por el usuario a :password.
      $query->execute();
      $usuarioLogin=$query->fetch(PDO::FETCH_ASSOC); //Crea un array indexado: $usuarioLogin[customerNumber] = daría el usuario solicitado en la consulta.

      if ($usuarioLogin){
          session_start();
          $_SESSION['customerNumber'] = $usuarioLogin["customerNumber"];
          $_SESSION['usuarioContraseña'] = $usuarioLogin["contactLastName"];
          header("location:./php/pe_inicio.php"); //La función header() se puede utilizar para redirigir automáticamente a otra página, enviando como argumento la cadena Location:
      }else{
          echo "Usuario o password incorrecto";
      }
  }
 ?>
<html>
    <head>
        <title>LOGIN</title>
        <link rel="stylesheet" href="css/pe_login.css">
    </head>
    <body>
        <form action="pe_login.php" method="POST">
            <h1>Login_Pedidos04</h1>

            <label>USUARIO: </label>
            <input type="text" name="usuario" required/><br/><br>

            <label>CONTRASEÑA: </label>
            <input type="password" name="password" required/><br/><br>

            <input type="submit" value="LOGIN"/>
        </form>
    </body>
</html>
