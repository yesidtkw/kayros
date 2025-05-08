<?php
require('fpdf.php');
//include 'conexion_tr.php';

// Clase personalizada para el PDF
class PDF extends FPDF
{
    // Encabezado
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

    // Pie de página
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

// Capturamos el ID de la URL
$id = $_GET['id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "newuser", "", "tenoplus");

// Consulta
$consulta = "SELECT * FROM transacciones WHERE id = $id";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();

    // Crear PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Dibujar fondo cuadro
    $pdf->SetFillColor(245, 245, 255); // Fondo lavanda claro
    $pdf->SetDrawColor(180, 130, 200); // Borde morado claro
    $pdf->SetLineWidth(0.5);

    $pdf->SetFont('Arial', '', 12);

    // Color de fondo para celdas
    //$pdf->SetFillColor(230, 230, 250);
    //$pdf->SetTextColor(0, 0, 0);

    // ID
    $pdf->SetY(40);
    $pdf->Cell(50, 10, 'ID:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['id'], 1, 1, 'L');

    // Cliente
    $pdf->Cell(50, 10, 'Cliente:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['cliente_nombre'], 1, 1, 'L');

    // Producto
    $pdf->Cell(50, 10, 'Producto:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['producto_nombre'], 1, 1, 'L');

    // Valor formateado con signo de pesos y miles
    $valorFormateado = '$' . number_format($row['valor'], 2, '.', ',');

    $pdf->Cell(50, 10, 'Valor:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $valorFormateado, 1, 1, 'L');

    // Telefono
    $pdf->Cell(50, 10, 'Telefono:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['telefono'], 1, 1, 'L');

    // cantidad
    $pdf->Cell(50, 10, 'cantidad:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['cantidad'], 1, 1, 'L');

    // cantidad
    $pdf->Cell(50, 10, 'Tipo de venta:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['tipo_venta'], 1, 1, 'L');

    // Dueno
    $pdf->Cell(50, 10, 'Propietario:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['dueno'], 1, 1, 'L');

    // Dueno
    $pdf->Cell(50, 10, 'Estado:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['estado'], 1, 1, 'L');

    // Observacioes
    $pdf->Cell(50, 10, 'Observaciones:', 1, 0, 'L', true);
    $pdf->Cell(0, 10, $row['observaciones'], 1, 1, 'L');

    // Salida del PDF
    $nombreArchivo = "pdf/miarchivo_" . $id . ".pdf";
    $pdf->Output('F', $nombreArchivo);

    // Ahora abrirlo en el navegador para visualización y impresión
    $pdf->Output('I', $nombreArchivo);  // 'I' para visualizar el archivo en el navegador

    // Mostrar PDF
    //$pdf->Output();
} else {
    echo "No se encontró el registro.";
}

// Cerrar conexión
$conexion->close();
?>
