<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

$borde=1;
$Ln = 4.25;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);

mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_activo=1  
						AND SW_Asistencia=1
						ORDER BY Apellidos, Apellido2, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

while($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)) {
	
	if($Linea == 24 or $Linea == 0){
		$Linea=0;
		$pdf->AddPage();
		$pdf->Image('../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$pdf->Image('../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		$pdf->SetFont('Times','B',18);
		$pdf->Cell(100);
		$pdf->Cell(95 , 8 , 'Lista fotos' , 'BR' , 1 , 'R'); 
	
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(100);
		$pdf->Cell(95 , 4 , date('d-m-Y') , '' , 0 , 'R'); 
		$_x_Foto = 10; 
		$_y_Foto = 30;
		
	}

		

	extract($row_RS_Empleados);

	$Foto = '../../../FotoEmp/150/'.$CodigoEmpleado.'.jpg';
	if(file_exists($Foto)){
		$pdf->Image($Foto , $_x_Foto, $_y_Foto, 0, 25);
	} 

	$Cedula = '../archivo/ci/100/'.$Cedula.'.jpg';
	if(file_exists($Cedula)){
		$pdf->Image($Cedula , $_x_Foto + 35, $_y_Foto, 23, 0);
	} 
	
	
	$pdf->SetFont('Arial','',10);

	$pdf->SetXY($_x_Foto + 26 , $_y_Foto + 17);
	$pdf->Cell(38 , 4 , $Apellidos.' '.$Apellido2 , 'T' , 0 , 'L'); 
	$pdf->SetXY($_x_Foto + 26 , $_y_Foto + 21);
	$pdf->Cell(38 , 4 , $Nombres.' '.$Nombre2.' ('.$CodigoEmpleado.') ' , 'TB' , 0 , 'L'); 

	$pdf->SetXY($_x_Foto ,$_y_Foto);
		
		
	$nLn++;
	$Linea++;
	
	if($nLn == 3){
		$nLn = 0;
		$_y_Foto = $_y_Foto + 27;
		$_x_Foto = 10;
		}
	else{
		$_x_Foto = $_x_Foto + 65;
		}


} 


//$pdf->Cell(40);






//$pdf->Cell(8.85 , $Ln , $i , $borde , 0 , 'C'); 
$pdf->Ln($Ln);




$pdf->Output();


?>