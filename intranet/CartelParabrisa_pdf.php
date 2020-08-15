<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');

$TituloPantalla = "TituloPantalla";


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 50;

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();

//$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,30 );
$pdf->SetY( 30 );
$pdf->SetFont('Arial','B',140);
$pdf->Image($_SERVER['DOCUMENT_ROOT'].'/img/solcolegio.jpg', 180, 130, 0, 80);

// Ejecuta $sql y While
$sql = "SELECT * FROM Alumno
		WHERE CodigoAlumno = '$CodigoAlumno'";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	
	extract($row);
	$pdf->Cell(250 , $Ln , "$Nombres" , $borde , 1 , 'C'); 
	$pdf->Cell(250 , $Ln , "$Apellidos" , $borde , 0 , 'C'); 
	
	//$pdf->Cell(250 , $Ln , "$Apellidos" , $borde , 1 , 'C'); 
	

}

$pdf->Ln(100);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(30 , 10 , "Agradecemos hacer una sola fila y respetar el turno de los otros." , 0 , 1 , 'L'); 
	





$pdf->Output();
?>