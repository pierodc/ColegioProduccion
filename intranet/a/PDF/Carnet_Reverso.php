<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 



$pdf=new FPDF('P', 'mm', array(85,54));
$pdf->SetMargins(0,0,0,0);
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

$pdf->SetFont('Arial','B',10);

$ln = 3.6;

$pdf->Cell(85 , $ln , ' ' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'Carnet propiedad del Colegio' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'Si consigue este carnet favor notificar' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'por los teléfonos 0212-283.25.75 / 286.04.37' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , ' ' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'En caso de accidente' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'número de póliza es: 10-10-2000060' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'Estar Seguros s.a.' , $borde , 1 , 'C'); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(85 , $ln , '(Alumno sin cédula indicar la C.I. de la madre)' , $borde , 1 , 'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(85 , $ln , 'Corredor Póliza: Charles Quintero' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , '0414-1207155 / 0424-1922738' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , ' ' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'www.ColegioSanFrancisco.com' , $borde , 1 , 'C'); 
$pdf->Cell(85 , $ln , 'colegio@ColegioSanFrancisco.com' , $borde , 1 , 'C'); 



$pdf->Output();


?>