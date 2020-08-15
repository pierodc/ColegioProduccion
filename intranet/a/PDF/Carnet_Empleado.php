<?php 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 

mysql_select_db($database_bd, $bd);

if($_GET['CodigoEmpleado']>0)
{$add = 'AND CodigoEmpleado='.$_GET['CodigoEmpleado'];}
else
{$add = 'AND SW_Asistencia=1';}


$query_RS_Empleado = "SELECT * FROM Empleado WHERE SW_activo='1' $add ORDER BY Apellidos, Nombres";//AND CodigoEmpleado=44
$RS_Empleado = mysql_query($query_RS_Empleado, $bd) or die(mysql_error());
$row_RS_Empleado = mysql_fetch_assoc($RS_Empleado);
$totalRows_RS_Empleado = mysql_num_rows($RS_Empleado);

if($totalRows_RS_Empleado>0){


$pdf=new FPDF('L', 'mm', array(85,54));
$pdf->SetMargins(0,0,0);
do{	
extract($row_RS_Empleado);
$foto = '../../../FotoEmp/150/'.$CodigoEmpleado.'.jpg';

if(file_exists($foto) or $_GET['CodigoEmpleado']>0){

$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
$borde=0;
$Ln = 4;
$pdf->Image('../../../img/solcolegio.jpg', 1, 6, 52);
$pdf->Ln(1); 
$pdf->SetTextColor(0,0,200);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(54 , 4 , 'COLEGIO' , $borde , 1 , 'C'); 
$pdf->SetFont('Times','B',14);
$pdf->Cell(54 , 5 , 'San Francisco de Asís' , $borde , 1 , 'C'); 
$pdf->SetFont('Arial','',7);
$pdf->Cell(54 , 4 , 'RIF: J-00137023-4' , $borde , 1 , 'C'); 

if(file_exists($foto)){
	$pdf->Image($foto, 12, 17, 0, 30);}

//$pdf->Image('../fotAl/14.jpg', 1, 8, 0, 10);
//$pdf->Image('../../i/amaz.jpg', 1, 48, 5);
//$pdf->Image('../../i/azul.jpg', 6, 48, 5);
//$pdf->Image('../../i/naraj.jpg', 11, 48, 5);
//$pdf->Image('../../i/r.jpg', 16, 48, 5);
//$pdf->Image('../../i/v.jpg', 21, 48, 5);
$pdf->Image('../../../img/Firma_Direc.jpg', 1, 65, 15);

//$pdf->Image('../../img/NombreCol.jpg', 12, 1, 60, 10);
$pdf->SetXY(0,18);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
//$pdf->Cell(44 , 4 , Curso($CodigoCurso) , $borde , 0 , 'L'); 
$pdf->SetFont('Arial','B',13);
//$pdf->Cell(14 , 4 , 'Cod.'.$CodigoAlumno , $borde , 1 , 'R'); 

$pdf->Ln(36); 
$pdf->Cell(54 , 4.5 , $Nombres.' '.substr($Nombre2,0,1)  , $borde , 1 , 'C'); 
$pdf->Cell(54 , 4.5 , $Apellidos.' '.substr($Apellido2,0,1) , $borde , 1 , 'C' ); 
 
$pdf->SetFont('Arial','',8);
$pdf->Ln(5); 
$pdf->Cell(53 , 3.5 , '' , $borde , 1 , 'R'); 

$pdf->SetFont('Arial','B',8);

$pdf->Cell(20, 2 , 'La Directora' , $borde , 0 , 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(33 , 2 , 'Tel Clg:0212.283.25.75' , $borde , 0 , 'R'); 
//$pdf->SetFont('Arial','',8);
//$pdf->Cell(12 , 2 , '31-12-'.$Ano2 , $borde , 1 , 'R'); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(32 , 2 , $CodigoEmpleado .' : '. ++$j , $borde , 0 , 'L'); 

if(strlen($CodigoBarras==12))
	$CodigoBarras = substr($CodigoBarras.'0000000000000000' ,0, 12) ;


$pdf->EAN13(12,74,$CodigoBarras,10);

//$pdf->SetY( 50 );

$pdf->Cell(40);


//$pdf->Cell(8.85 , $Ln , $i , $borde , 0 , 'C'); 
$pdf->Ln($Ln);
}
} while($row_RS_Empleado = mysql_fetch_assoc($RS_Empleado));


$pdf->Output();
}

?>