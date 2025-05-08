<?php
header("Content-Type: application/json");
require "conexion.php";

$sql = "SELECT * FROM partes ORDER BY id DESC";
$resultado = $conn->query($sql);

$productos = [];
while ($fila = $resultado->fetch_assoc()) {
    $productos[] = $fila;
}

echo json_encode($productos);
$conn->close();
?>
