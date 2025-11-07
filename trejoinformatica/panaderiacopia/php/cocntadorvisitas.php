<?php
session_start();
if (isset($_SESSION["numero_acceso"])) //Verifica si existe la variable session
{
  $_SESSION["numero_acceso"]++;
} else {
  $_SESSION["numero_acceso"] = 0;
}
?>

<?php
$numero = $_SESSION["numero_acceso"];
if ($numero > 0) {
  print "<p> Haz accedido esta pagina <b> $numero </b> veces</p>";
} else {
  print "<p> Hola esta es tu primera visita.</p>";
}
?>