<?php
header("Content-Type: application/json");
require "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$sql = "INSERT INTO partes (nombre, marca, categoria, condicion, precio, imagen)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssis", $data["nombre"], $data["marca"], $data["categoria"],
                  $data["condicion"], $data["precio"], $data["imagen"]);

if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto creado correctamente"]);
} else {
    echo json_encode(["error" => "Error al crear el producto"]);
}

$stmt->close();
$conn->close();
?>
