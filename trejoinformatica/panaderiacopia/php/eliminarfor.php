<?php
echo "<title>Eliminar Cliente LA PANERA</title>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<meta charset='UTF-8'>";
echo "<link rel='stylesheet' type='text/css' href='../css/index.css'>";

if ($_POST) {  
    $con = new mysqli("localhost", "root", "", "lapanera");
    if ($con->connect_error) {
        die("Conexión fallida: " . $con->connect_error);
    }

    $correo = isset($_POST["correo"]) ? htmlspecialchars($_POST["correo"]) : "";

    $check_sql = "SELECT * FROM clientes WHERE Email = '$correo'";
    $result = mysqli_query($con, $check_sql);
    
    if (mysqli_num_rows($result) > 0) {
        mysqli_query($con, "DELETE FROM ventas WHERE correo = '$correo'") 
            or die("Error al eliminar ventas asociadas: " . mysqli_error($con));
        
        mysqli_query($con, "DELETE FROM clientes WHERE Email = '$correo'") 
            or die("Error al eliminar el cliente: " . mysqli_error($con));
        
        echo "<div class='success-message'>";
        echo "<p>Cliente y sus compras asociadas eliminados correctamente</p>";
        echo "</div>";
    } else {
        echo "<div class='error-message'>";
        echo "<p>El correo no existe en nuestra base de datos</p>";
        echo "</div>";
    }

    $con->close();
}

echo "<div class='form-container'>";
echo "<div class='action-buttons'>";
echo "<button><a href='../html/productos.html'>Volver al catálogo</a></button>";
echo "<button><a href='../index.html'>Volver al inicio</a></button>";
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