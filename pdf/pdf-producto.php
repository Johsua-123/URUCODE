<?php
require 'fpdf186/fpdf.php';

$pdf = new FPDF();

$pdf->AddPage('PORTRAIT', 'A4');
$pdf->SetMargins(10, 0, 5);

$pdf->SetFont('Arial', 'I', 35);
$pdf->Write(5, 'Productos');

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'I', 14);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'I', 14);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(37, 10, 'Nombre', 1, 0, 'C', false);
$pdf->Cell(37, 10, 'Precio', 1, 0, 'C', false);
$pdf->Cell(37, 10, 'Stock', 1, 0, 'C', false);
$pdf->Cell(37, 10, 'Modelo', 1, 0, 'C', false);
$pdf->Cell(37, 10, 'Marca', 1, 0, 'C', false);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

$nombre = mb_convert_encoding('Artículo Ejemplo con descripción larga para probar', 'ISO-8859-1', 'UTF-8');

$x = $pdf->GetX();
$y = $pdf->GetY();

$anchoCelda = 37;
$alturaCelda = 10;

$pdf->SetXY($x, $y); 
$nb = $pdf->GetStringWidth($nombre) / $anchoCelda; 
$nb = ceil($nb);  

$altura = $nb * $alturaCelda;

$pdf->MultiCell($anchoCelda, $alturaCelda, $nombre, 1, 'L');

$pdf->SetXY($x + $anchoCelda, $y);

$pdf->Cell(37, $altura, '$9999', 1, 0, 'L', false);
$pdf->Cell(37, $altura, '777', 1, 0, 'L', false);
$pdf->Cell(37, $altura, 'Mk-Ultra', 1, 0, 'L', false);
$pdf->Cell(37, $altura, 'SKZD', 1, 0, 'L', false);

$pdf->Ln(); 


$pdf->output();
?>