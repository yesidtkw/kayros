
<?php
include 'conexion_tr.php';

$id = $_POST['id'];
$cliente = $_POST['cliente_nombre'];
$telefono = $_POST['telefono'];
$producto = $_POST['producto_nombre'];
$cantidad = $_POST['cantidad'];
$valor = $_POST['valor'];
$tipo_venta = $_POST['tipo_venta'];
$dueno = $_POST['dueno'];
$estado = $_POST['estado'];
$observaciones = $_POST['observaciones'];

if ($id) {
  $sql = "UPDATE transacciones SET cliente_nombre=?, telefono=?, producto_nombre=?, cantidad=?, valor=?, tipo_venta=?, dueno=?, estado=?, observaciones=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssidsdssi", $cliente, $telefono, $producto, $cantidad, $valor, $tipo_venta, $dueno, $estado, $observaciones, $id);
} else {
  $sql = "INSERT INTO transacciones (cliente_nombre, telefono, producto_nombre, cantidad, valor, tipo_venta, dueno, estado, observaciones)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssidsdss", $cliente, $telefono, $producto, $cantidad, $valor, $tipo_venta, $dueno, $estado, $observaciones);
}

if ($stmt->execute()) {
  header("Location: index_tr.php");
} else {
  echo "Error: " . $stmt->error;
}
?>
