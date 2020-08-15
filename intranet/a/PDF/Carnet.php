<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 

$CodigoAlumno = $_GET['CodigoAlumno'].$_GET['CodigoPropietario'];
$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);



//$pdf=new FPDF('P', 'mm', array(85,54));   // tamaño carnet
$pdf=new FPDF('P', 'mm', 'Letter');

$x0 = 10;
$y0 = 10;

$pdf->SetMargins($x0+1,$y0+0,0);

$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$borde=0;
$Ln = 4;

// SOL
$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/img/solcolegio.jpg', $x0+33, $y0+1, 0, 54);


$pdf->SetY($y0+1);
$pdf->SetTextColor(0,0,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(85 , 4 , 'COLEGIO' , $borde , 1 , 'C'); 
$pdf->SetFont('Times','B',20);
$pdf->Cell(85 , 4 , 'San Francisco de Asís' , $borde , 1 , 'C'); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(85 , 3 , 'RIF: J-00137023-4' , $borde , 1 , 'C'); 



$pdf->SetXY($x0+1,$y0+16);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(46 , 5 , $Alumno->Nombres() , $borde , 1 , 'L'); 
$pdf->Cell(46 , 5 , $Alumno->Apellidos() , $borde , 1 , 'L'); 

$pdf->Ln(1); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(23 , 4 , 'C.I.'.$Alumno->Cedula().' (Cod.'.$Alumno->Codigo().')' , $borde , 1 , 'L'); 
$pdf->Cell(17 , 4 , 'F.Nac.:'. DDMMAAAA( $Alumno->FechaNac() ) , $borde , 1 , 'L'); 
$pdf->SetFont('Arial','',6);

$pdf->EAN13($x0+10,$y0+47, substr($CodigoAlumno.$Cedula,0,12) ,7);


// FIRMA Directors
$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/Firma_Direc.jpg', $x0+3, $y0+38, 20);
$pdf->SetXY($x0+3,$y0+43);
$pdf->Cell(20, 4 , 'La Directora' , $borde , 0 , 'C');


$pdf->Image($Alumno->Foto(""), $x0+46, $y0+14, 0, 30);

$pdf->SetXY($x0+46,$y0+45);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30 , 5 , Curso($CodigoCurso) , $borde , 1 , 'C'); 
$pdf->SetXY($x0+46,$y0+50);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30 , 4 , 'Vence el:31-12-20'.$Ano2 , $borde , 1 , 'C'); 

$pdf->SetXY($x0+1,$y0+50);
$pdf->Cell(32 , 4 , ++$j , $borde , 0 , 'L'); 


$pdf->Output();
?>