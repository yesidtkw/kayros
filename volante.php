<?php
require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Fondo color azul muy claro
        $this->SetFillColor(230, 240, 255);
        $this->Rect(0, 0, 139.7, 215.9, 'F');

        // Título grande
        $this->SetFont('Arial', 'B', 28);
        $this->SetTextColor(37, 99, 235); // Azul moderno
        $this->Cell(0, 20, 'KAYROS', 0, 1, 'C');

        // Espacio
        $this->Ln(5);

        // Línea decorativa
        $this->SetDrawColor(100, 149, 237); // Azul suave
        $this->SetLineWidth(1);
        $this->Line(20, $this->GetY(), 120, $this->GetY());

        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, 'Visítanos en C.C. San Francisco Bogotá D.C.', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', array(139.7, 215.9));
$pdf->AddPage();

// Dirección y Teléfono
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(55, 65, 81);
$pdf->MultiCell(0, 8, 'Dirección: Calle 15 No. 8A - 22 Local 26 C.C. San Francisco Bogotá D.C.', 0, 'C');
$pdf->Ln(2);
$pdf->MultiCell(0, 8, 'Teléfono: 3004451636', 0, 'C');

// Separador
$pdf->Ln(8);
$pdf->SetDrawColor(200, 200, 255);
$pdf->Line(20, $pdf->GetY(), 120, $pdf->GetY());
$pdf->Ln(10);

// Sección Venta
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(37, 99, 235);
$pdf->Cell(0, 10, 'Venta de:', 0, 1, 'C');

$pdf->SetFont('Arial', '', 14);
$pdf->SetTextColor(55, 65, 81);
$pdf->Ln(3);
$pdf->Cell(0, 8, '• Portátiles', 0, 1, 'C');
$pdf->Cell(0, 8, '• Celulares', 0, 1, 'C');
$pdf->Cell(0, 8, '• Tablets', 0, 1, 'C');

// Otra Línea
$pdf->Ln(8);
$pdf->SetDrawColor(200, 200, 255);
$pdf->Line(20, $pdf->GetY(), 120, $pdf->GetY());
$pdf->Ln(10);

// Sección Servicio Técnico
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetTextColor(37, 99, 235);
$pdf->Cell(0, 10, 'Servicio Técnico:', 0, 1, 'C');

$pdf->SetFont('Arial', '', 13);
$pdf->SetTextColor(55, 65, 81);
$pdf->Ln(3);
$pdf->MultiCell(0, 8, '• Cambio de pantalla\n• Limpieza\n• Reparación de puertos\n• Cambio de batería, etc.', 0, 'C');

// Exportar PDF
$pdf->Output();
?>
