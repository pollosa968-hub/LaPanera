<?php
echo '<title> Consultas </title>';
echo '<link rel="icon" href="../Logo.ico">';
echo '<link rel="stylesheet" type="text/css" href="../css/insertarcompra.css" />';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

//Conectando con la BD
$servername = "localhost"; // Cambia según tu configuración
$username = "root"; // Tu usuario de la base de datos
$password = ""; // Tu contraseña de la base de datos
$db="technology_store";          //Nombre de la base de datos


// Crear conexión
//Establece conexión con la base de datos (dominio,usuarios,contraseña,base_de_datos)
$conn = mysqli_connect($servername, $username, $password, $db) or die("Problemas al Conectar");
mysqli_select_db($conn, $db) or die("problemas al conectar con la base de datos");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener variables del formulario
$correo = $_POST['correo']; // Suponiendo que el correo también se envía desde el formulario
$pc = $_POST['pc'];
$dd = $_POST['dd'];
$bocina = $_POST['bocina'];


// Verificar si el correo existe
$stmt = $conn->prepare ( "SELECT correo FROM clientes WHERE correo = ?");

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Insertar en la tabla ventas si el correo existe
    $sql_insertar = "INSERT INTO ventas (pc, dd, bocina, correo) VALUES (?, ?, ?, ?)";
    $stmt_insertar = $conn->prepare($sql_insertar);
    $stmt_insertar->bind_param("ssss", $pc, $dd, $bocina, $correo);

    if ($stmt_insertar->execute()) {
        echo "Venta registrada exitosamente.";
    } else {
        echo "<p> Error al insertar la venta: </p>" . $stmt_insertar->error;
    }
} else {
    echo "<p>El correo no está registrado. No se puede insertar la venta.</p><br><br>";
}

// Cerrar conexión
$stmt->close();

$conn->close();
?>