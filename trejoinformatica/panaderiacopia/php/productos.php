<?php
echo "<title>Formulario LA PANERA</title>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<meta charset='UTF-8'>";
echo "<link rel='stylesheet' type='text/css' href='../css/index.css'>";

$cantidadPandulce = isset($_POST["cantidad-pandulce"]) ? intval($_POST["cantidad-pandulce"]) : 0;
$cantidadTeleras = isset($_POST["cantidad-teleras"]) ? intval($_POST["cantidad-teleras"]) : 0;
$cantidadBolillos = isset($_POST["cantidad-bolillos"]) ? intval($_POST["cantidad-bolillos"]) : 0;
$cantidadSinAzucar = isset($_POST["cantidad-sinazucar"]) ? intval($_POST["cantidad-sinazucar"]) : 0;
$cantidadGalletas = isset($_POST["cantidad-galletas"]) ? intval($_POST["cantidad-galletas"]) : 0;
$cantidadSaludable = isset($_POST["cantidad-saludable"]) ? intval($_POST["cantidad-saludable"]) : 0;
$correo = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "";

$precioPandulce = 11.50;  // Pan dulce
$precioTeleras = 2.50;    // Teleras
$precioBolillos = 4.50;    // Bolillos
$precioSinAzucar = 11.00;  // Pan sin azúcar
$precioGalletas = 19.00;   // Galletas y más
$precioSaludable = 17.50;   // Línea Saludable

$t1 = $precioPandulce * $cantidadPandulce;
$t2 = $precioTeleras * $cantidadTeleras;
$t3 = $precioBolillos * $cantidadBolillos;
$t4 = $precioSinAzucar * $cantidadSinAzucar;
$t5 = $precioGalletas * $cantidadGalletas;
$t6 = $precioSaludable * $cantidadSaludable;

$totalfinal = $t1 + $t2 + $t3 + $t4 + $t5 + $t6;
$totalProductos = $cantidadPandulce + $cantidadTeleras + $cantidadBolillos + $cantidadSinAzucar + $cantidadGalletas + $cantidadSaludable;

$descuento = 0;
$mensajeDescuento = "";

if ($totalProductos >= 15) {
    $descuento = $totalfinal * 0.20;
    $mensajeDescuento = "Descuento del 20% (por comprar 15 o más productos)";
} elseif ($totalProductos >= 10) {
    $descuento = $totalfinal * 0.10;
    $mensajeDescuento = "Descuento del 10% (por comprar 10 o más productos)";
}

$totalConDescuento = $totalfinal - $descuento;

echo "<div class='confirmacion'>";
echo "<h2>Resumen de Compra</h2>";
echo "<p><strong>Correo del cliente:</strong> $correo</p>";
echo "<div class='detalles-compra'>";

echo "<table border='1'>";
echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr>";

if ($cantidadPandulce > 0) 
    echo "<tr><td>Pan dulce</td><td>$cantidadPandulce</td><td>$" . number_format($precioPandulce, 2) . "</td><td>$" . number_format($t1, 2) . "</td></tr>";
if ($cantidadTeleras > 0) 
    echo "<tr><td>Teleras</td><td>$cantidadTeleras</td><td>$" . number_format($precioTeleras, 2) . "</td><td>$" . number_format($t2, 2) . "</td></tr>";
if ($cantidadBolillos > 0) 
    echo "<tr><td>Bolillos</td><td>$cantidadBolillos</td><td>$" . number_format($precioBolillos, 2) . "</td><td>$" . number_format($t3, 2) . "</td></tr>";
if ($cantidadSinAzucar > 0) 
    echo "<tr><td>Pan sin azúcar</td><td>$cantidadSinAzucar</td><td>$" . number_format($precioSinAzucar, 2) . "</td><td>$" . number_format($t4, 2) . "</td></tr>";
if ($cantidadGalletas > 0) 
    echo "<tr><td>Galletas y más</td><td>$cantidadGalletas</td><td>$" . number_format($precioGalletas, 2) . "</td><td>$" . number_format($t5, 2) . "</td></tr>";
if ($cantidadSaludable > 0) 
    echo "<tr><td>Línea Saludable</td><td>$cantidadSaludable</td><td>$" . number_format($precioSaludable, 2) . "</td><td>$" . number_format($t6, 2) . "</td></tr>";

echo "<tr><td colspan='3' style='text-align:right;'><strong>Subtotal ($totalProductos productos):</strong></td><td><strong>$" . number_format($totalfinal, 2) . "</strong></td></tr>";

if ($descuento > 0) {
    echo "<tr><td colspan='3' style='text-align:right;'><strong>$mensajeDescuento:</strong></td><td><strong>-$" . number_format($descuento, 2) . "</strong></td></tr>";
}

echo "<tr><td colspan='3' style='text-align:right;'><strong>Total Final:</strong></td><td><strong>$" . number_format($totalConDescuento, 2) . "</strong></td></tr>";
echo "</table>";

echo "</div>";

$con = new mysqli("localhost", "root", "", "lapanera");
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

$check_sql = "SELECT * FROM clientes WHERE Email = '$correo'";
$result = mysqli_query($con, $check_sql);

if (mysqli_num_rows($result) > 0) {
    $sql = "INSERT INTO ventas (
        correo, 
        total, 
        dulce, 
        teleras, 
        bolillos, 
        sinazu, 
        galletas, 
        integral
    ) VALUES (
        '".$con->real_escape_string($correo)."', 
        $totalConDescuento,
        $cantidadPandulce,
        $cantidadTeleras,
        $cantidadBolillos,
        $cantidadSinAzucar,
        $cantidadGalletas,
        $cantidadSaludable
    )";

    if ($con->query($sql)) {
        echo "<div class='success-message'>";
        echo "<p>¡Venta registrada exitosamente!</p>";
        echo "</div>";
    } else {
        echo "<div class='error-message'>";
        echo "<p>Error al registrar la venta: " . $con->error . "</p>";
        echo "</div>";
    }
} else {
    echo "<div class='error-message'>";
    echo "<p>El correo no está registrado. Por favor registre al cliente primero.</p>";
    echo "<button><a href='../html/cuenta.html'>Registrar cliente</a></button>";
    echo "</div>";
}

$con->close();

echo "<div class='acciones'>";
echo "<a href='../html/productos.html' class='btn btn-cancelar'>Seguir comprando</a>";
echo "<a href='../index.html' class='btn'>Volver al inicio</a>";
echo "</div>";
echo "</div>";

echo "<footer>";
echo "LA PANERA - Desde 1985<br>";    
echo "Equipo:<br>";
echo "Flores Castañeda Valeria<br>";
echo "Édgar Fernando Trejo Ibarra<br>";
echo "Aguilar Rosas Melanie Samaris";
echo "</footer>";
?>