<?php
require('fpdf.php');

// Conexión a la base de datos
//$conexion = new mysqli("cpanel4-co.conexcol.net:3306", "kayrosco_admin", "28982700aA?+", "kayrosco_tenoplus");
$conexion = new mysqli("localhost", "newuser", "", "tenoplus");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta productos
$sql = "SELECT id, nombre, marca, categoria, precio,condicion FROM partes";
$resultado = $conexion->query($sql);

// Crear PDF
$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);
$pdf->SetFont('Arial', '', 10);

$x = 10;
$y = 10;
$ancho = 63;
$alto = 70;
$columna = 0;

$logoPath = 'kayros_logo.png'; // Asegúrate de que esta ruta sea correcta

while ($p = $resultado->fetch_assoc()) {
    $categoria = strtolower($p['categoria']);

    // Establecer color según categoría
    if (in_array($categoria, ['portatil', 'portátiles', 'portátiles'])) {
        $r = 212; $g = 252; $b = 212;
    } elseif (in_array($categoria, ['tablet', 'tableta', 'tablets'])) {
        $r = 243; $g = 209; $b = 247;
    } elseif (in_array($categoria, ['celular', 'celulares'])) {
        $r = 255; $g = 249; $b = 196;
    } else {
        $r = 255; $g = 255; $b = 255;
    }

    $r = 112;
    $g = 222;
    $b = 95;

    // Fondo
    //$pdf->SetFillColor($r, $g, $b);
    $pdf->SetFillColor($r, $g, $b);
    $pdf->Rect($x, $y, $ancho, $alto, 'F');

    // Logo (ajustado al tamaño del rótulo)
    $pdf->Image($logoPath, $x + 2, $y + 2, 10, 10); // x, y, width, height

    // Texto del rótulo
    $pdf->SetXY($x + 14, $y + 2);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->MultiCell($ancho - 16, 6, strtoupper($p['nombre']), 0);

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY($x + 2, $pdf->GetY() + 1);
    $pdf->MultiCell($ancho - 4, 5, "Categoria: " . $p['categoria'], 0);

    $pdf->SetXY($x + 2, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "Marca: " . $p['marca'], 0);

    $pdf->SetXY($x + 2, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "Precio: $" . number_format($p['precio'], 0), 0);

    $pdf->SetXY($x + 2, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "Condicion: " . $p['condicion'], 0);

    $pdf->SetXY($x + 2, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "ID: " . $p['id'], 0);

    $pdf->SetXY($x + 2, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "    Calle 15 No. 8A - 22 Local 26", 0);
    $pdf->SetXY($x + 1, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "        C.C. San Francisco ", 0);
    $pdf->SetXY($x + 1, $pdf->GetY());
    $pdf->MultiCell($ancho - 4, 5, "         Tel. 3004451636", 0);






    // Posición siguiente
    $columna++;
    if ($columna == 3) {
        $columna = 0;
        $x = 10;
        $y += $alto + 5;
        if ($y + $alto > 260) {
            $pdf->AddPage();
            $y = 10;
        }
    } else {
        $x += $ancho + 5;
    }
}

$pdf->Output("I", "rotulos_partes.pdf");
