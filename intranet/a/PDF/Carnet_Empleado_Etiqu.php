<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);

if($_GET['CodigoEmpleado']>0)
{$add = 'AND CodigoEmpleado='.$_GET['CodigoEmpleado'];}

$query_RS_Empleado = "SELECT * FROM Empleado WHERE SW_activo='1' $add ORDER BY Apellidos, Nombres";//AND CodigoEmpleado=44
$RS_Empleado = mysql_query($query_RS_Empleado, $bd) or die(mysql_error());
$row_RS_Empleado = mysql_fetch_assoc($RS_Empleado);
$totalRows_RS_Empleado = mysql_num_rows($RS_Empleado);

if($totalRows_RS_Empleado>0){


$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
$pdf->SetMargins(10,10,0);
$Ln = 20;
$pdf->SetFont('Arial','',8);
 
do{	
extract($row_RS_Empleado);

//$pdf->SetAutoPageBreak(false);

//$pdf->Ln(40); 
if($_y>240) 
	$pdf->AddPage();

$_x = $pdf->GetX()  ;
$_y = $pdf->GetY() + 3 ;
	
	
$pdf->Cell(60 , 3 , $Apellidos. ' ' .$Nombres , 0 , 0 , 'L'); 


$pdf->EAN13($_x,$_y,$CodigoBarras,7);

if($_x > 120)
$pdf->Ln(12);



//$pdf->Cell(54 , 4.5 ,  , 0 , 1 , 'C' ); 

//$pdf->Cell(32 , 3.5 , ++$j.' ' .$CodigoEmpleado , $borde , 0 , 'L'); 

$CodigoBarras = substr('0000'.$CodigoEmpleado , -4) . substr('00000000'.$Cedula , -8);



//$pdf->SetY( 50 );

//$pdf->Cell(40);


//$pdf->Cell(8.85 , $Ln , $i , $borde , 0 , 'C'); 

} while($row_RS_Empleado = mysql_fetch_assoc($RS_Empleado));


$pdf->Output();
}

?>