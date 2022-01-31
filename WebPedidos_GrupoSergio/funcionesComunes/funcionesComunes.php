<?php
  function test_input($data) {//Limpiamos los datos que nos pasan
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
  }

  function abrirConexion() {//Devolvemos la conexión con el servidor si ha sido posible realizarla si no mostramos un mensaje
    $servername = "localhost";
    $username = "id18363069_pedidosroot";
    $password = "LeonardoDaVinci123$";
    $dbname="id18363069_pedidos";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname",$username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }

  function cerrarConexión($conn) {
    $conn = null;//Cerramos la conexión
  }

  function nombreCliente($cliente,$conn) {//Le pasamos le ID del cliente y devolvemos su nombre
  try {
    $stmt = $conn->prepare("SELECT customerName FROM customers WHERE customerNumber = '$cliente'");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);//Guardo los resultados
      foreach($stmt->fetchAll() as $row) {
        $nombre = $row["customerName"];
     }
     return $nombre;
  }
  catch(PDOException $e) {
      echo "Error: ".$e->getMessage();
  }
  }
 ?>
