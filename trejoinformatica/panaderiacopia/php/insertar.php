<?php
echo '<title> Consultas </title>';
echo '<link rel="icon" href="../Logo.ico">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '<link rel="stylesheet" type="text/css" href="../css/insertar.css"/>';


$servername = "localhost"; // Cambia según tu configuración
$username = "root"; // Tu usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$db="technology_store";          //Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$pwd = $_POST['pwd'];

// Verificar si el correo ya existe
$sql = "SELECT * FROM clientes WHERE correo = '$correo'";   // Nombre de la tabla clientes y registro correo
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<p> El correo ya está registrado.</p><br><br>";
} else {
    $nombre = $_POST['nombre'];
    $sql = "INSERT INTO clientes (nombre, correo, pwd) VALUES ('$nombre', '$correo', '$pwd')";  //Insreta campos nombre, correo y pwd a tabla clientes
    
    if ($conn->query($sql) === TRUE) {
        echo "<p> Registro exitoso.</p>";
    } else {
        echo "<p> Error al registrar: </p>" . $conn->error;
    }
}

$conn->close();
echo '<button><a href="../venta.php"> Regresar </a></button><br><br><br>';

?>
