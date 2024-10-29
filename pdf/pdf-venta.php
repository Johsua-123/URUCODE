<?php
require 'fpdf186/fpdf.php';

$pdf = new FPDF();

$pdf->AddPage('PORTRAIT', 'A4');
$pdf->SetMargins(10, 0, 5);

$pdf->SetFont('Arial', 'I', 35);
$pdf->Write(5, 'Ventas');

$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'I', 14);
$pdf->SetTextColor(0, 0, 0);

$pdf->Cell(47, 10, 'Producto', 1, 0, 'C', false);
$pdf->Cell(47, 10, 'Comprador', 1, 0, 'C', false);
$pdf->Cell(47, 10, 'Precio', 1, 0, 'C', false);
$pdf->Cell(47, 10, 'Fecha', 1, 0, 'C', false);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);

$producto = mb_convert_encoding('Notebook ASUS Vivobook Go 15 E1504FA-NJ550W R5 7520U/8Gb/256Gb PCIe/15"/W11', 'ISO-8859-1', 'UTF-8');

$x = $pdf->GetX();
$y = $pdf->GetY();

$anchoCelda = 47;
$alturaCelda = 10;

$pdf->SetXY($x, $y); 
$nb = $pdf->GetStringWidth($producto) / $anchoCelda; 
$nb = ceil($nb);  

$altura = $nb * $alturaCelda;

$pdf->MultiCell($anchoCelda, $alturaCelda, $producto, 1, 'L');

$pdf->SetXY($x + $anchoCelda, $y);

$pdf->Cell($anchoCelda, $altura, mb_convert_encoding('Juan Pérez','ISO-8859-1', 'UTF-8'), 1, 0, 'L', false);
$pdf->Cell($anchoCelda, $altura, 'US$ 560', 1, 0, 'L', false);
$pdf->Cell($anchoCelda, $altura, '28/10/24', 1, 0, 'L', false);

$pdf->Ln(); 


$pdf->output();

?>
