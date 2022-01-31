<?php
session_start();
if (!isset($_SESSION["CustomerNumber"])) {//Si no hay sesión iniciada no nos permite acceder la programa y nos saca un mensaje de error
  //Cerrar sesion
  session_unset();
  session_destroy();
  //Mensaje
  exit("Se necesita iniciar sesión");
} else {
  require_once '../funciones/funcionespe_constock.php';
  require_once ("../funcionesComunes/funcionesComunes.php");
  //CREAMOS CONEXION
  $conexion=abrirConexion();

  ?>
  <!DOCTYPE html>
  <html lang='en' dir='ltr'>
  <head>
    <meta charset='utf-8'>
    <title>Empresa</title>
    <style>
            body {
              background-color:  #0a9c66 ;
              color: white;
              font-size: 14pt;
              font-family: Arial;
            }
            a {color: white;}
            a:hover{
              color: black;
              font-size: 16pt;
            }
    </style>
  </head>
  <body>
    <?php
    echo "Bienvenido/a <b>".nombreCliente(($_SESSION['CustomerNumber']),$conexion)."</b><br><br>";
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <p>Producto:</p>
      <select name="producto">
        <?php
        //CREAMOS EL DESPLEGABLE
        //SELECT
        $stmt = $conexion->prepare("SELECT productLine FROM products GROUP BY productLine");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $row) {
          //OPTIONS
          ?>
          <option value="<?php echo $row['productLine']; ?>"> <?php echo $row['productLine']; ?> </option>';

          <?php
        }
        //CERRAMOS CONEXION
        cerrarConexión($conexion);

        ?>
      </select>


      <br><br>
      <input type="submit" value="Enviar"  name="enviar">
    </form>
  </body>
  </html>


  <?php
  if (isset($_POST['enviar'])) {
    //INTRODUCIMOS LAS FUNCIONES

    //CREAMOS CONEXION
    $conexion=abrirConexion();

    //AÑADIMOS PARAMETROS
    $producto=$_POST['producto'];


    //FUNCIONES
    revisarParametros($producto);
    $arrayNombreStock= mostrarStockLine($producto,$conexion);
    $size=count($arrayNombreStock);
    ?>
    <!-- TABLA -->
    <table border=1>
      <tr>
        <th> <?php echo "NOMBRE PRODUCTO" ?> </th>
        <th> <?php echo "CANTIDAD EN STOCK" ?> </th>
      </tr>
      <?php
      for ($i=0; $i < $size ; $i+=2) {
        ?>
        <tr>
          <td> <?php echo $arrayNombreStock[$i] ?> </td>
          <td> <?php echo $arrayNombreStock[$i+1] ?> </td>
        </tr>
        <?php
      }
      ?>
    </table>
    <?php
    //CERRAMOS CONEXION
    cerrarConexión($conexion);

  }
}?>
<!-- VOLER AL LOGIN -->
<p><a href="pe_inicio.php">Volver al menu de usuario</a></p>