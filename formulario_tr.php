
<?php
include 'conexion_tr.php';
$modo = "Agregar";
$transaccion = [
  "id" => "",
  "cliente_nombre" => "",
  "telefono" => "",
  "producto_nombre" => "",
  "cantidad" => "",
  "valor" => "",
  "tipo_venta" => "",
  "dueno" => "",
  "estado" => "",
  "observaciones" => ""
];

if (isset($_GET['id'])) {
  $modo = "Editar";
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM transacciones WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $resultado = $stmt->get_result();
  if ($resultado->num_rows > 0) {
    $transaccion = $resultado->fetch_assoc();
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= $modo ?> Transacción</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h1><?= $modo ?> Transacción</h1>
  <form action="guardar_tr.php" method="post">
    <input type="hidden" name="id" value="<?= $transaccion['id'] ?>">
    <input type="text" name="cliente_nombre" required placeholder="Nombre del cliente" value="<?= $transaccion['cliente_nombre'] ?>">
    <input type="text" name="telefono" required placeholder="Teléfono" value="<?= $transaccion['telefono'] ?>">
    <input type="text" name="producto_nombre" required placeholder="Producto" value="<?= $transaccion['producto_nombre'] ?>">
    <input type="number" name="cantidad" required placeholder="Cantidad" value="<?= $transaccion['cantidad'] ?>">
    <input type="number" name="valor" required placeholder="Valor total" value="<?= $transaccion['valor'] ?>">
    <input type="text" name="tipo_venta" placeholder="Tipo de venta" value="<?= $transaccion['tipo_venta'] ?>">
    <input type="text" name="dueno" placeholder="Dueño del producto" value="<?= $transaccion['dueno'] ?>">
    <input type="text" name="estado" placeholder="Estado (Pagado, Pendiente...)" value="<?= $transaccion['estado'] ?>">
    <textarea name="observaciones" rows="3" placeholder="Observaciones..."><?= $transaccion['observaciones'] ?></textarea>
    <button type="submit" class="guardar">Guardar</button>
    <div style="text-align:center;margin-top:10px;">
      <a href="index_tr.php" style="color:#ccc;">Cancelar y volver</a>
    </div>
  </form>
</body>
</html>
