<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);

$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activoBK=1 ORDER BY Apellidos, Nombres";
//echo $query_RS_Empleados;
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);


$borde=1;
$Ln = 5;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetFillColor(255,255,255);
$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 22 );
$pdf->Cell(50 , $Ln , $TituloPag , 0 , 1 , 'L'); 
$pdf->SetFont('Arial','',10);
$pdf->SetY( 30 );

$pdf->Cell(8 , $Ln , 'No' , $borde , 0 , 'R',1); 
$pdf->Cell(8 , $Ln , 'Cod' , $borde , 0 , 'R',1); 
$pdf->Cell(23 , $Ln , 'Cédula' , $borde , 0 , 'L',1); 
$pdf->Cell(60 , $Ln , 'Apellidos y Nombres' , $borde , 0 , 'L',1); 
$pdf->SetFont('Arial','',9);
//$pdf->Cell(6 , $Ln , 'EC' , $borde , 0 , 'C',1); 
//$pdf->Cell(22 , $Ln ,'Fecha Nac' , $borde , 0 , 'C',1); 
//$pdf->Cell(22 , $Ln , 'Fecha Ing' , $borde , 0 , 'C',1); 
$pdf->Cell(22 , $Ln , 'Fecha Nac' , $borde , 0 , 'C',1); 

/*
$pdf->Cell(50 , $Ln , 'Cargo' , $borde , 0 , 'L',1); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(10 , $Ln , 'Hrio' , $borde , 0 , 'C',1); 
$pdf->Cell(10 , $Ln , 'Hr' , $borde , 0 , 'C',1); 
//$pdf->Cell(12 , $Ln , 'BsHr' , $borde , 0 , 'C',1); 
$pdf->Cell(10 , $Ln , 'Hr' , $borde , 0 , 'C',1); 
//$pdf->Cell(12 , $Ln , 'BsHr' , $borde , 0 , 'C',1); 
$pdf->Cell(17 , $Ln , 'S_Base' , $borde , 0 , 'R',1); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(4 , $Ln , 'ss' , $borde , 0 , 'C',1); 
$pdf->Cell(4 , $Ln , 'lh' , $borde , 0 , 'C',1); 
$pdf->Cell(4 , $Ln , 'pf' , $borde , 0 , 'C',1); 
$pdf->Cell(17 , $Ln , 'Fideic' , $borde , 0 , 'R',1); 
*/

$pdf->Ln($Ln);


do{
extract($row_RS_Empleados);
	
$pdf->Cell(8 , $Ln , ++$i , $borde , 0 , 'R',1); 
$pdf->Cell(8 , $Ln , $CodigoEmpleado , $borde , 0 , 'R',1); 
$pdf->Cell(23 , $Ln , $CedulaLetra .'-'. $Cedula , $borde , 0 , 'R',1); 
$pdf->Cell(60 , $Ln , $Apellidos.' '.$Nombres , $borde , 0 , 'L',1); 
$pdf->SetFont('Arial','',9);
//$pdf->Cell(6 , $Ln , $EdoCivil , $borde , 0 , 'C',1); 
//$pdf->Cell(22 , $Ln , DDMMAAAA($FechaNac) , $borde , 0 , 'C',1); 
//$pdf->Cell(22 , $Ln , DDMMAAAA($FechaIngreso) , $borde , 0 , 'C',1); 
$pdf->Cell(22 , $Ln , DDMMAAAA($FechaNac) , $borde , 0 , 'C',1); 
//$pdf->Cell(50 , $Ln , $CargoLargo.' '.$CargoCorto , $borde , 0 , 'L',1); 
$pdf->SetFont('Arial','',10);

/*
$sql = "SELECT * FROM Horario WHERE Cedula_Prof = '".$Cedula."'";
$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_sql = mysql_fetch_assoc($RS_sql);
$HrHorario = mysql_num_rows($RS_sql);
$HrHorario = $HrHorario>0?$HrHorario:'';

$pdf->Cell(10 , $Ln , $HrHorario , $borde , 0 , 'R',1); 

$BsHrAcad = $BsHrAdmi = 26.67;

$pdf->Cell(10 , $Ln , $HrAcad , $borde , 0 , 'R',1); 
//$pdf->Cell(12 , $Ln , $BsHrAcad , $borde , 0 , 'R',1); 
$pdf->Cell(10 , $Ln , $HrAdmi , $borde , 0 , 'R',1); 
//$pdf->Cell(12 , $Ln , $BsHrAdmi , $borde , 0 , 'R',1); 
//$S_Base = round($HrAcad*$BsHrAcad+$HrAdmi*$BsHrAdmi , 2);
$pdf->Cell(17 , $Ln , Fnum($SueldoBase) , $borde , 0 , 'R',1); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(4 , $Ln , $SW_ivss?'x':'' , $borde , 0 , 'C',1); 
$pdf->Cell(4 , $Ln , $SW_lph?'x':'' , $borde , 0 , 'C',1); 
$pdf->Cell(4 , $Ln , $SW_spf?'x':'' , $borde , 0 , 'C',1); 
$pdf->Cell(17 , $Ln , Fnum($SueldoBase/15*5) , $borde , 0 , 'R',1); 
*/

$pdf->Ln($Ln);
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));
//$pdf->Cell(40);






$pdf->Output();


?>