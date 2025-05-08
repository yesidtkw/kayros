
<?php
include 'conexion_tr.php';
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$accion = $input["accion"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
  $result = $conn->query("SELECT * FROM transacciones ORDER BY fecha DESC");
  $datos = [];
  while ($fila = $result->fetch_assoc()) {
    $datos[] = $fila;
  }
  echo json_encode($datos);
  exit;
}

if ($accion === "crear") {
  $stmt = $conn->prepare("INSERT INTO transacciones (cliente_nombre, telefono, producto_nombre, cantidad, valor, tipo_venta, dueno, estado, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssidsdss",
    $input["cliente_nombre"], $input["telefono"], $input["producto_nombre"], $input["cantidad"],
    $input["valor"], $input["tipo_venta"], $input["dueno"], $input["estado"], $input["observaciones"]);
  $stmt->execute();
  echo json_encode(["ok" => true]);
  exit;
}

if ($accion === "editar") {
  $stmt = $conn->prepare("UPDATE transacciones SET cliente_nombre=?, telefono=?, producto_nombre=?, cantidad=?, valor=?, tipo_venta=?, dueno=?, estado=?, observaciones=? WHERE id=?");
  $stmt->bind_param("sssidsdssi",
    $input["cliente_nombre"], $input["telefono"], $input["producto_nombre"], $input["cantidad"],
    $input["valor"], $input["tipo_venta"], $input["dueno"], $input["estado"], $input["observaciones"], $input["id"]);
  $stmt->execute();
  echo json_encode(["ok" => true]);
  exit;
}

if ($accion === "eliminar") {
  $stmt = $conn->prepare("DELETE FROM transacciones WHERE id=?");
  $stmt->bind_param("i", $input["id"]);
  $stmt->execute();
  echo json_encode(["ok" => true]);
  exit;
}
?>
