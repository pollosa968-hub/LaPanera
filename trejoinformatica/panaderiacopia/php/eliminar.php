<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-Strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title> Formulario</title>
  <link rel="stylesheet" type="text/css" href="../css/estiloeliminar.css" />
  <link rel="icon" href="../Logo.ico">

</head>

<body>
  <div id="Encabezado"><br>
   <h1> Technology store </h1>
  </div>
  
  <div id="Section">

    <h3> Eliminar registros </h3><br>

    <form action="eliminar.php" method="POST" align="center" class="box">


      <label for="correo">Escribe el correo </label>
      <i class="fas fa-envelope icon"></i>
      <input type="text" required name="correo" placeholder="Correo Electronico" maxlength="100">

      <input type="submit" name="Eliminar" value="Borrar" data-toggle="modal"><br><br>

      <button><a href='../venta.php'> Regresa al formulario </a></button>
    </form>
  </div>
 
  
  <?php
  include_once("eliminarregistros.php");
  ?>

</body>
</html>