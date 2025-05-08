
<?php
include 'conexion_tr.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("DELETE FROM transacciones WHERE id = ?");
  $stmt->bind_param("i", $id);
  if ($stmt->execute()) {
    header("Location: index_tr.php");
  } else {
    echo "Error al eliminar: " . $stmt->error;
  }
} else {
  echo "ID no especificado.";
}
?>
