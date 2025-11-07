<?php
echo '<title> Actualización </title>';
echo '<link rel="icon" href="../Logo.ico">';
echo '<link rel="stylesheet" type="text/css" href="../css/estilomodifica.css" />';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

// Conexión a la base de datos
$servername = "localhost"; // Cambia según tu configuración
$username = "root"; // Tu usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$db="technology_store";          //Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$correo = $_POST['correo']; // Asegúrate de que el formulario envíe el correo
$pc = $_POST['pc'];
$dd = $_POST['dd'];
$bocina = $_POST['bocina'];

// Verificar si el correo existe
$sql_verificar = "SELECT * FROM ventas WHERE correo = ?";
$stmt = $conn->prepare($sql_verificar);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    // Si el correo existe, actualizar los registros
    $sql_actualizar = "UPDATE ventas SET pc = ?, dd = ?, bocina = ? WHERE correo = ?";
    $stmt = $conn->prepare($sql_actualizar);
    $stmt->bind_param("ssss", $pc, $dd, $bocina, $correo);

    if ($stmt->execute()) {
        echo "<p> Registro actualizado correctamente. </p>";
    } else {
        echo "<p> Error al actualizar el registro: </p>" . $stmt->error;
    }
} else {
    echo "<p> El correo no existe en la base de datos. </p><br><br><br>";
}

// Cerrar conexión
$stmt->close();
$conn->close();

echo '<button><a href="../venta.php"> Ir a la página principal </a></button>';


?>