<?php
echo '<title>Resultado Panadería</title>';
echo '<meta name=viewport content=width=device-width, initial-scale=1.0>';
echo '<meta charset=UTF-8>';
echo "<link rel=stylesheet type=text/css href=../css/phpvalido.css>";
echo "<link rel=stylesheet type=text/css href=../html/formularo.html>";

$nombre = $_POST["nombre"];
$tel = $_POST["tel"];
$email = $_POST["email"];
$tipo_pan = $_POST["tipo_pan"];
$cantidad = $_POST["cantidad"];
$pago = $_POST["pago"];
$fecha = $_POST["fecha"];

$terminos = isset($_POST['terminos']);

echo "<header><h2> Pedido Panadería </h2></header>";
echo "<main> El nombre del cliente es:" .$nombre. "<br><br>";
echo "Teléfono de contacto:" .$tel. "<br><br>";
echo "Correo electrónico:" .$email. "<br><br>";
echo "Tipo de pan seleccionado:" .$tipo_pan. "<br><br>";
echo "Cantidad:" .$cantidad. " piezas<br><br>";
echo "Método de pago:" .$pago. "<br><br>";
echo "Fecha de entrega:" .$fecha. "<br><br>";

echo "Acepta los terminos?" .($terminos? 'si' : 'no'). "<br><br>";
echo "<footer>Jefes de La Panaderia: <br><br>Edgar Trejo  <br> Melanie samaris <br> Valeria Flores</footer>";
?>