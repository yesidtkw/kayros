<?php
require('fpdf.php');
include 'conexion_tr.php';

// Verificar si viene el ID
if (!isset($_GET['id'])) {
    die('ID no proporcionado');
}

// Obtener el ID
$id = intval($_GET['id']);

// Consultar la base de datos
$resultado = $conn->query("SELECT * FROM transacciones WHERE id = $id");

if ($resultado->num_rows == 0) {
    die('Registro no encontrado');
}

// Obtener datos del registro
$registro = $resultado->fetch_assoc();

// Crear una clase que herede de FPDF
class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo
        $this->Image('pdf/kayros_logo.png', 10, 8, 30); // Ruta, X, Y, ancho (auto alto)
        // Fuente
        $this->SetFont('Arial', 'B', 15);
        // Mover a la derecha
        $this->Cell(40);
        // Título
        $this->Cell(110, 10, 'Detalle de la Transaccion', 0, 0, 'C');
        // Salto de línea
        $this->Ln(20);
        // Línea de separación
        $this->Line(10, 28, 200, 28);
    }

    // Footer
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Fuente
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear el PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Mostrar cada campo del registro
foreach ($registro as $campo => $valor) {
    $campo_formateado = ucwords(str_replace("_", " ", $campo));
    $pdf->Cell(50, 8, (mb_convert_encoding($campo_formateado, 'UTF-8', 'ISO-8859-1')) . ':', 0, 0);
    $pdf->Cell(0, 8, (mb_convert_encoding($valor, 'UTF-8', 'ISO-8859-1')), 0, 1);
}

// Salida del PDF
$pdf->Output('pdf/mi_archivo.pdf', 'F');
?>
