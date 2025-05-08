<?php
$host = "localhost";
$usuario = "newuser";
$contrasena = "";
$basedatos = "tenoplus";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}
?>
