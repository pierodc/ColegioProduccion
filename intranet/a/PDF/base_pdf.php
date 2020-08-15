<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');

$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();

$borde = 1;
$Ln = 4.25;

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->AddPage();
//Reticula($pdf);
//$pdf->SetFillColor(255,255,255);
//$pdf->SetMargins(5,5,5);
//$pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/img/NombreCol.jpg' , 30, 5, 0, 12);

//$pdf->SetXY( 30,10 );
//$pdf->SetFont('Arial','',12);

// Ejecuta $sql y While
$sql = "SELECT * FROM xxx
		WHERE Campo = '$Valor'";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	
	extract($row);
	$pdf->Cell(8.85 , $Ln , "texto" , $borde , 0 , 'C'); 
	$pdf->Ln($Ln);

}




$pdf->Image('../../../img/SelloCol.jpg',145,108,0,18);
	





$pdf->Output();
?>