<?php
header("Content-Type: application/json");
require "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$sql = "UPDATE productosmalos SET nombre=?, marca=?, categoria=?, condicion=?, precio=?, imagen=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisi", $data["nombre"], $data["marca"], $data["categoria"],
                  $data["condicion"], $data["precio"], $data["imagen"], $data["id"]);

if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto actualizado correctamente"]);
} else {
    echo json_encode(["error" => "Error al actualizar el producto"]);
}

$stmt->close();
$conn->close();
?>
