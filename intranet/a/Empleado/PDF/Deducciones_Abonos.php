<?php 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$borde = 1;
$Ln = 6;

$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255,255,255);
$pdf->AddPage();
$pdf->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
$pdf->SetY( 30 );


$Q1 = $_GET['Q']; 
if(isset($_GET['AnoMes'])){
		$Mes1 = substr($_GET['AnoMes'],-2);
		$Ano1 = substr($_GET['AnoMes'],0,4);
	}



// Ejecuta $sql y While
$sql = "SELECT * FROM Empleado 
		WHERE SW_activo=1 
		ORDER BY Apellidos, Nombres";
//echo $sql;
$RS = $mysqli->query($sql);
while ($row_RS_Empleados = $RS->fetch_assoc()) {
	$pdf->SetFont('Arial','',11);
	
	
	
	$sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
			AND Mes = '".$Mes1."' 
			AND Ano = '".$Ano1."' 
			AND Quincena = '".$Q1."'  
			"; //AND Tipo <> 'AQ' 
//echo $sql;
	$RS_Empleado_Deducciones = $mysqli->query($sql);
	while ($row_Empleado_Deducciones = $RS_Empleado_Deducciones->fetch_assoc()) {
		extract($row_Empleado_Deducciones);
		
		
		$pdf->Cell(8.85 , $Ln , ++$i , $borde , 0 , 'C'); 
		$pdf->Cell(8.85 , $Ln , $row_RS_Empleados['CodigoEmpleado'] , $borde , 0 , 'C'); 
		$pdf->Cell(40 , $Ln , $row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Nombres'] , $borde , 0 , 'L'); 
		$pdf->Cell(20 , $Ln , $Tipo , $borde , 0 , 'C'); 
		$pdf->Cell(75 , $Ln , $Descripcion , $borde , 0 , 'L'); 
		$pdf->Cell(25 , $Ln , $Monto , $borde , 0 , 'R'); 
		$pdf->Cell(20 , $Ln , "" , $borde , 0 , 'R'); 
		
		$pdf->Ln($Ln);
	}
	
}

$pdf->Ln($Ln);
$pdf->Cell(170 , $Ln , 'PR:Prestamo PP:Pago a cuenta de prestamo AU:Ausencia(s) DE:Deducción ' , $borde , 1 , 'L'); 
$pdf->Cell(170 , $Ln , 'AQ:Adelanto de Quincena  BO:Bonificación RE:Reintegro PA:Pago ' , $borde , 1 , 'L'); 






$pdf->Output();


?>