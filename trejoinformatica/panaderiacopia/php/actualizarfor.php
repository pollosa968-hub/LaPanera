<?php 
echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<title>Actualización LA PANERA</title>';
echo '<link rel="stylesheet" type="text/css" href="../css/index.css">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
echo '</head>';
echo '<body>';

echo '<div class="form-container">';

$servername = "localhost";
$username = "root";
$password = "";
$db = "lapanera";
$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("<div class='error-message'>Conexión fallida: " . $conn->connect_error . "</div>");
}

$correo = isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : "";
$cantidadPandulce = isset($_POST["cantidad-pandulce"]) ? intval($_POST["cantidad-pandulce"]) : 0;
$cantidadTeleras = isset($_POST["cantidad-teleras"]) ? intval($_POST["cantidad-teleras"]) : 0;
$cantidadBolillos = isset($_POST["cantidad-bolillos"]) ? intval($_POST["cantidad-bolillos"]) : 0;
$cantidadSinAzucar = isset($_POST["cantidad-sinazucar"]) ? intval($_POST["cantidad-sinazucar"]) : 0;
$cantidadGalletas = isset($_POST["cantidad-galletas"]) ? intval($_POST["cantidad-galletas"]) : 0;
$cantidadSaludable = isset($_POST["cantidad-saludable"]) ? intval($_POST["cantidad-saludable"]) : 0;

$precios = [
    'dulce' => 11.50,
    'teleras' => 2.50,
    'bolillos' => 4.50,
    'sinazu' => 11.00,
    'galletas' => 19.00,
    'integral' => 17.50
];

$total = ($cantidadPandulce * $precios['dulce']) + 
         ($cantidadTeleras * $precios['teleras']) + 
         ($cantidadBolillos * $precios['bolillos']) + 
         ($cantidadSinAzucar * $precios['sinazu']) + 
         ($cantidadGalletas * $precios['galletas']) + 
         ($cantidadSaludable * $precios['integral']);

$sql_verificar_cliente = "SELECT * FROM clientes WHERE Email = ?";
$stmt_cliente = $conn->prepare($sql_verificar_cliente);
$stmt_cliente->bind_param("s", $correo);
$stmt_cliente->execute();
$resultado_cliente = $stmt_cliente->get_result();

if ($resultado_cliente->num_rows == 0) {
    echo "<div class='error-message'>El correo no está registrado como cliente.</div>";
    $stmt_cliente->close();
    $conn->close();
    echo '<div class="action-buttons">';
    echo '<button><a href="../html/cuenta.html">Registrar cliente</a></button>';
    echo '<button><a href="../html/productos.html">Volver a productos</a></button>';
    echo '</div>';
    echo '</div>';
    echo '<footer>LA PANERA - Desde 1985<br>Equipo: Flores Castañeda Valeria, Édgar Fernando Trejo Ibarra, Aguilar Rosas Melanie Samaris</footer>';
    echo '</body>';
    echo '</html>';
    exit();
}

$sql_verificar_venta = "SELECT * FROM ventas WHERE correo = ?";
$stmt_venta = $conn->prepare($sql_verificar_venta);
$stmt_venta->bind_param("s", $correo);
$stmt_venta->execute();
$resultado_venta = $stmt_venta->get_result();

if ($resultado_venta->num_rows > 0) {
    $sql_actualizar = "UPDATE ventas SET 
                      dulce = ?, 
                      teleras = ?, 
                      bolillos = ?, 
                      sinazu = ?, 
                      galletas = ?, 
                      integral = ?,
                      total = ?
                      WHERE correo = ?";
    
    $stmt = $conn->prepare($sql_actualizar);
    $stmt->bind_param("iiiiiids", 
                     $cantidadPandulce, 
                     $cantidadTeleras, 
                     $cantidadBolillos, 
                     $cantidadSinAzucar, 
                     $cantidadGalletas, 
                     $cantidadSaludable,
                     $total,
                     $correo);

    if ($stmt->execute()) {
        echo "<div class='success-message'>Compra actualizada correctamente.</div>";
    } else {
        echo "<div class='error-message'>Error al actualizar: " . $stmt->error . "</div>";
    }
} else {
    echo "<div class='error-message'>No existe una compra previa para este correo.</div>";
}

$stmt_venta->close();
$stmt_cliente->close();
if (isset($stmt)) $stmt->close();
$conn->close();

echo '<div class="action-buttons">';
echo '<button><a href="../html/productos.html">Volver a productos</a></button>';
echo '<button><a href="../index.html">Volver al inicio</a></button>';
echo '</div>';

echo '</div>';

echo '<footer>';
echo 'LA PANERA - Desde 1985<br>';    
echo 'Equipo:<br>';
echo 'Flores Castañeda Valeria<br>';
echo 'Édgar Fernando Trejo Ibarra<br>';
echo 'Aguilar Rosas Melanie Samaris';
echo '</footer>';
echo '</body>';
echo '</html>';
?>