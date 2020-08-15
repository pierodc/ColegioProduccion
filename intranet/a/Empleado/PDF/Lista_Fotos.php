<?php 
$MM_authorizedUsers = "";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 

require_once('../../../../inc/fpdf.php'); 

$borde=1;
$Ln = 4.25;

$pdf=new FPDF('L', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();
$pdf->Image('../../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 22 );
$pdf->Cell(50 , $Ln , $TituloPag , 0 , 1 , 'L'); 
$pdf->SetFont('Arial','',10);
$pdf->SetY( 30 );

$pdf->SetFont('Arial','',11);


//$pdf->Image('../../img/LogoME_ResFinal.jpg', 10, 10, 0, 13);


$pdf->SetY( 30 );




mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activo=1 ORDER BY Pagina, Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);
do{
	extract($row_RS_Empleados);
	$Foto = '../../FotoEmp/'.$CodigoEmpleado.'jpg';
	$pdf->Cell(12 , 8 , $Apellidos , 'TB' , 0 , 'R'); 

	if(file_exists($Foto)){
		$_x_Foto = $pdf->GetX(); 
		$_y_Foto = $pdf->GetY();
		$pdf->Image($Foto , $_x_Foto, $_y_Foto, 15, 0);
	}
	
} while($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));


//$pdf->Cell(40);






$pdf->Cell(8.85 , $Ln , $i , $borde , 0 , 'C'); 
$pdf->Ln($Ln);




$pdf->Output();


?>