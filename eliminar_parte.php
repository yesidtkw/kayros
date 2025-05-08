<?php
header("Content-Type: application/json");
require "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"];

$sql = "DELETE FROM partes WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Producto eliminado correctamente"]);
} else {
    echo json_encode(["error" => "Error al eliminar el producto"]);
}

$stmt->close();
$conn->close();
?>
