<?php
header("Content-Type: application/json");
require "conexion.php";

//$host = "localhost";
//$usuario = "newuser";
//$contrasena = "";
//$basedatos = "tenoplus";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);
if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}

$sql = "SELECT * FROM productos ORDER BY id DESC";
$resultado = $conn->query($sql);

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

echo json_encode($productos);
$conn->close();
?>
