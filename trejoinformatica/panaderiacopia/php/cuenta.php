<?php
echo '<title>Registro LA PANERA</title>';
echo '<meta name=viewport content=width=device-width, initial-scale=1.0>';
echo '<meta charset=UTF-8>';
echo "<link rel=stylesheet type=text/css href=../css/cuenta.css>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lapanera";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$telefono = $_POST["telefono"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

echo "<header><h2>Resultado del Registro</h2></header>";
echo "<main>";
echo "Nombre completo: " . htmlspecialchars($nombre) . "<br><br>";
echo "Correo electrónico: " . htmlspecialchars($email) . "<br><br>";
echo "Teléfono: " . htmlspecialchars($telefono) . "<br><br>";

if ($password === $confirm_password) {
    
    $sql = "SELECT * FROM clientes WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<span style='color:red;'>Error: El correo ya está registrado.</span><br><br>";
    } else {
       
        $sql = "INSERT INTO clientes (Nombre, Numero, Email, Contraseña) VALUES ('$nombre', '$telefono', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<span style='color:green;'>Registro exitoso.</span><br><br>";
        } else {
            echo "<span style='color:red;'>Error al registrar: " . $conn->error . "</span><br><br>";
        }
    }

} else {
    echo "<span style='color:red;'>Error: Las contraseñas no coinciden.</span><br><br>";
}

$conn->close();
echo '<button><a href="../html/productos.html"> Regresar </a></button><br><br><br>';
echo "</main>";
echo "<footer>LA PANERA - Desde 1985<br><br>Equipo:<br>Valeria Flores Castañeda<br>Édgar Fernando Trejo Ibarra<br>Aguilar Rosas Melanie Samaris</footer>";
?>
