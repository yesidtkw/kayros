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

// Crear clase extendida de FPDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFillColor(230, 230, 250); // Fondo lila claro
        $this->Rect(0, 0, 210, 40, 'F');

        $this->Image('pdf/kayros_logo.png', 10, 6, 20);

        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(0, 51, 102); // Azul oscuro
        $this->Cell(40);
        $this->Cell(110, 10, 'KAYROS', 0, 0, 'C');
        $this->Ln(15);

        $this->SetDrawColor(102, 0, 153); // Morado fuerte
        $this->SetLineWidth(0.8);
        $this->Line(10, 28, 200, 28);

        $this->SetLineWidth(0.2);
        $this->Line(10, 30, 200, 30);

        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-40);
        $this->SetFillColor(230, 230, 250); // Fondo lila claro
        $this->Rect(0, $this->GetY(), 210, 40, 'F');

        $this->SetY(-30);
        $this->SetDrawColor(102, 0, 153);
        $this->SetLineWidth(0.8);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Ln(2);

        $this->SetLineWidth(0.2);
        $this->Line(10, $this->GetY(), 200, $this->GetY());

        $this->Ln(5);

        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(80, 80, 80);
        $this->Cell(0, 5, mb_convert_encoding('Dirección: Calle 15 No. 8A-22 Local 26 C.C. San Francisco - Bogota D.C.', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding('Teléfono: +57 300-4451636 | Correo: martinezcorreayesid@gmail.com', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');

        //mb_convert_encoding('Dirección: Calle Ficticia 123, Ciudad Ejemplo', 'ISO-8859-1', 'UTF-8')
        //mb_convert_encoding('Teléfono: +58 123-4567890 | Correo: contacto@kayros.com', 'ISO-8859-1', 'UTF-8')

        //$pdf->Cell(0, 5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Dirección: Calle Ficticia 123, Ciudad Ejemplo'), 0, 1, 'C');
        //$pdf->Cell(0, 5, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Teléfono: +58 123-4567890 | Correo: contacto@kayros.com'), 0, 1, 'C');

        $this->Ln(2);
        $this->Cell(0, 5, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear PDF
$pdf = new PDF();
$pdf->AddPage();

// Dibujar fondo cuadro
$pdf->SetFillColor(245, 245, 255); // Fondo lavanda claro
$pdf->SetDrawColor(180, 130, 200); // Borde morado claro
$pdf->SetLineWidth(0.5);

$startX = 15;
$startY = 50;
$width = 180;
$height = 8 * count($registro) + 10;

$pdf->Rect($startX, $startY, $width, $height, 'DF');

// Posicionar inicio
//$pdf->SetXY($startX + 5, $startY + 5);
$pdf->SetXY($startX + 5, $startY + 5);

// Mostrar datos con línea divisora
foreach ($registro as $campo => $valor) {
    $x1 = $pdf->GetX();
    $pdf->SetX(20);
    $y1 = $pdf->GetY();

    $campo_formateado = ucwords(str_replace("_", " ", $campo));

    // Campo en negrita
    $pdf->SetFont('Arial', 'B', 12);
    //$pdf->Cell(50, 8, mb_convert_encoding($campo_formateado, 'UTF-8', 'ISO-8859-1') . ':', 0, 0);
    $pdf->Cell(50, 8, mb_convert_encoding($campo_formateado, 'UTF-8', 'ISO-8859-1') . ':', 0, 0);

    // Valor en normal
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, mb_convert_encoding($valor, 'UTF-8', 'ISO-8859-1'), 0, 1);
    
    if $valor = "valor"
      $valor = '$' . number_format($pdf['valor'], 2, '.', ',');
    endif

    // Dibujar línea divisora
    $pdf->SetDrawColor(200, 160, 220); // Morado clarito
    $pdf->SetLineWidth(0.2);
    $pdf->Line($startX + 5, $pdf->GetY(), $startX + $width - 5, $pdf->GetY());
}

// Salida del PDF
    $nombreArchivo = "pdf/miarchivo_" . $id . ".pdf";
    $pdf->Output('F', $nombreArchivo);
    //echo "Archivo guardado como: " . $nombreArchivo;

    //$pdf->Output('pdf/mi_archivo.pdf', 'F');

    // Ahora abrirlo en el navegador para visualización y impresión
    $pdf->Output('I', $nombreArchivo);  // 'I' para visualizar el archivo en el navegador
?>
