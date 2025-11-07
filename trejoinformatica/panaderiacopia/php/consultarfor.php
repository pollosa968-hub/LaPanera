<?php 
echo '<!DOCTYPE html>';
echo '<html lang="es">';
echo '<head>';
echo '<title>Consultas - LA PANERA</title>';
echo '<link rel="stylesheet" type="text/css" href="../css/index.css">';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '</head>';
echo '<body>';

echo '<div class="form-container">';

$servername = "localhost";
$username = "root";
$password = "";
$db = "lapanera";

$conn = mysqli_connect($servername, $username, $password, $db) or die("Problemas al conectar");
mysqli_select_db($conn, $db) or die("Problemas al conectar con la base de datos");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$correo = isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : "";

$stmt = $conn->prepare("SELECT * FROM ventas WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<h2>Historial de Compras - LA PANERA</h2>';
    
    $cliente_stmt = $conn->prepare("SELECT Nombre FROM clientes WHERE Email = ?");
    $cliente_stmt->bind_param("s", $correo);
    $cliente_stmt->execute();
    $cliente_result = $cliente_stmt->get_result();
    
    if ($cliente_result->num_rows > 0) {
        $cliente = $cliente_result->fetch_assoc();
        echo "<p><strong>Cliente:</strong> " . $cliente['Nombre'] . "</p>";
    }
    echo "<p><strong>Correo electrónico:</strong> $correo</p>";
    
    while ($venta = $result->fetch_assoc()) {
        echo '<div class="venta-container">';
        echo '<table class="resumen-table">';
        echo '<tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th></tr>';
        
        $precios = array(
            'dulce' => 11.50,
            'teleras' => 2.50,
            'bolillos' => 4.50,
            'sinazu' => 11.00,
            'galletas' => 19.00,
            'integral' => 17.50
        );
        
        $total_venta = 0;
        
        foreach ($precios as $producto => $precio) {
            if ($venta[$producto] > 0) {
                $subtotal = $venta[$producto] * $precio;
                $total_venta += $subtotal;
                $nombre_producto = match($producto) {
                    'dulce' => 'Pan dulce',
                    'teleras' => 'Teleras',
                    'bolillos' => 'Bolillos',
                    'sinazu' => 'Pan sin azúcar',
                    'galletas' => 'Galletas y más',
                    'integral' => 'Línea Saludable',
                    default => ucfirst($producto)
                };
                echo "<tr><td>" . $nombre_producto . "</td><td>" . $venta[$producto] . "</td><td>$" . number_format($subtotal, 2) . "</td></tr>";
            }
        }
        
        echo '<tr class="total-final"><td colspan="2"><strong>Total de la compra:</strong></td><td><strong>$' . number_format($venta['total'], 2) . '</strong></td></tr>';
        echo '</table>';
        
        echo '</div>';
    }
} else {
    echo "<div class='error-message'>";
    echo "<p>No se encontraron compras registradas para este correo.</p>";
    echo "<button><a href='../html/cuenta.html'>Registrar cliente</a></button>";
    echo "</div>";
}

$stmt->close();
$conn->close();

echo '<div class="action-buttons">';
echo '<button><a href="../html/productos.html">Realizar nueva compra</a></button>';
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