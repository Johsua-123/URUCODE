<?php
require 'fpdf186/fpdf.php';

$pdf = new FPDF();

$pdf->AddPage('PORTRAIT', 'A4');
$pdf->SetMargins(10, 0, 5);

$pdf->SetFont('Arial', 'I', 35);
$pdf->Write(5, 'Servicios');

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'I', 14);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(42, 10, 'Nombre', 1, 0, 'C', false);
$pdf->Cell(42, 10, 'Precio', 1, 0, 'C', false);
$pdf->Cell(42, 10, mb_convert_encoding('Descripción', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', false);
$pdf->Ln();

$nombre = mb_convert_encoding('nombre servicio ejemplo largo para ver si anda', 'ISO-8859-1', 'UTF-8');
$descripcion = mb_convert_encoding('descripcion de servicio muy larga para probar', 'ISO-8859-1', 'UTF-8');

$x = $pdf->GetX();
$y = $pdf->GetY();

$anchoCelda = 42;
$alturaCelda = 10;

$nb_nombre = $pdf->GetStringWidth($nombre) / $anchoCelda;
$nb_descripcion = $pdf->GetStringWidth($descripcion) / $anchoCelda;

$max_lines = ceil(max($nb_nombre, $nb_descripcion));
$altura = $max_lines * $alturaCelda;

$pdf->MultiCell($anchoCelda, $alturaCelda, $nombre, 1, 'L');
$pdf->SetXY($x + $anchoCelda, $y);

$pdf->Cell($anchoCelda, $altura, '$9999', 1, 0, 'L', false);

$pdf->SetXY($x + $anchoCelda * 2, $y);
$pdf->MultiCell($anchoCelda, $alturaCelda, $descripcion, 1, 'L');

$pdf->Ln();

$pdf->output();

?>
