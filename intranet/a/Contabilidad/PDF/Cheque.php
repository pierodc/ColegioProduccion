<?
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$borde = 0;
$Ln = 5;

$pdf=new FPDF('P', 'mm', array(250,100));
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();


if(isset($_GET['Codigo']) ){
	$sql = "SELECT * 
			FROM Cheque 
			WHERE Codigo = '".$_GET['Codigo']."'";	
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	extract($row_);
}

$pdf->SetFont('Arial','B',14);
$pdf->SetXY(135,27);
$pdf->Cell(20 , $Ln , "**".Fnum($Monto)."**" , $borde , 0 , 'L'); 

$pdf->SetXY(40,39);
$pdf->Cell(20 , $Ln , "*** ".$FavorDe." ***" , $borde , 0 , 'L'); 

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(24,46);
$pdf->Cell(20 , $Ln , Fnum_Letras($Monto) , $borde , 0 , 'L'); 

$pdf->SetXY(17,59);
$pdf->Cell(63 , $Ln , "Caracas, ".date("d")." de ".Mes(date("m")) , $borde , 0 , 'L'); 
$pdf->Cell(50 , $Ln , date("Y") , $borde , 0 , 'L'); 

$pdf->SetXY(130,35);
$pdf->Cell(50 , $Ln , "NO ENDOSABLE" , $borde , 0 , 'L'); 
$pdf->Output();



?>