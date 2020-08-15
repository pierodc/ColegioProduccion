<?php 
$MM_authorizedUsers = "91,AsistDireccion";
require_once('../../../../inc_login_ck.php'); 

require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php');
 
require_once('../../../../inc/fpdf.php');

$Mes = date('m');
$Ano = date('Y');


$linea = 6.2;
$tipologia = 'Arial';


$pdf=new FPDF('P', 'mm', 'Letter');
$pdf->SetMargins(12,10,10);
$pdf->SetFont('Arial','',10);

if(isset($_GET['CodigoEmpleado'])){ $add_sql = " AND CodigoEmpleado = '".$_GET['CodigoEmpleado']."' ";}
 
$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activo=1 $add_sql ORDER BY Apellidos, Nombres LIMIT 0 , 200 ";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);



if(!isset($_GET['CodigoEmpleado'])){
	$sql_Pago_Extra = "UPDATE Empleado SET Pago_extra2 = ''";
	mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());
}	

$PagAnterior = $row_RS_Empleados['Pagina'];
$impar = true;
//Util=1&Agui=1

do {
	$MontoBase=0;
	
	if(isset($_GET['Util'])){
		$ReciboDe = 'UTILIDADES';
		$MontoBase = $row_RS_Empleados['SueldoBase']*2;
	
	}elseif(isset($_GET['Agui'])){
		$ReciboDe = 'AGUINALDOS';
		$MontoBase = $row_RS_Empleados['SueldoBase']*2;
		
	}
	
	$Codigo_Empleado = $row_RS_Empleados['CodigoEmpleado'];
	$CodConcepto = ucwords(strtolower($ReciboDe));		
	
	$sql = "DELETE FROM Empleado_Pago
			WHERE Codigo_Empleado = '$Codigo_Empleado'
			AND Codigo_Quincena = '$Ano 12 $CodConcepto'
			AND Concepto = '+$CodConcepto'";
	$mysqli->query($sql);
	//echo $sql."<br>";

	
	if($MontoBase>0){
		$pdf->AddPage();
		$pdf->Image('../../../../img/solcolegio.jpg', 10,10,0,20);
		$pdf->Image('../../../../img/NombreCol.jpg' , 30,10,0,12);
		
		$TotalCheque = 0;
			
			
		$AnosLaborados = round( Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'], date('Y').'-12-31') , 2 );
		
		if($AnosLaborados >= 1) {
			$DiasPagados = 30; 
			$MontoPago = round( ($MontoBase / 30) * $DiasPagados ,2);
			$DiasPagados = $DiasPagados;}
		else {
			$DiasPagados = round( $AnosLaborados*30 , 2);
			$MontoPago = round( ($MontoBase / 30) * $DiasPagados ,2);
			$DiasPagados = Fnum($DiasPagados);}
		
		if(isset($_GET['Bono'])){
			//$MontoPago = $MontoBase;
			}
		
		$TotalCheque += $MontoPago;
		
		$linea=5;
		$pdf->Ln(7);
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(80); $pdf->Cell(115,$linea, 'RECIBO' ,0,1,'R'); 
		
		$pdf->SetFont('Times','',9);
		$pdf->Cell(20); 
		$pdf->Cell(47,$linea,' RIF: J-00137023-4 ',0,0,'C'); 
		
		$pdf->SetFont('Times','B',14);
		$pdf->Cell(128,$linea, 'Por Bs.'.Fnum($MontoPago) ,0,1,'R'); 
		
		
		$pdf->SetFont('Times','',12);
		//if(date('d')<=15) $quincena = '1ra'; else $quincena = '2da';
		$titulo = 'correspondiente a '.$ReciboDe.' de '.date('Y');
		$pdf->Cell(195,$linea, $titulo ,0,0,'R'); 
		$pdf->Ln(8);
		$linea=6.5;
		
		
		$pdf->SetFont('Arial','',12);
		$linea = 7; 
		$pdf->Ln($linea);
		$pdf->SetFont('Arial','',12);
		$pdf->Write($linea, 'Yo, ' );  
		$Concepto  = $row_RS_Empleados['Apellidos'].' '.$row_RS_Empleados['Apellido2'].', '. $row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Nombre2'];
		$pdf->SetFont('Arial','B',12);
		$pdf->Write($linea, $Concepto );
		
		$Concepto = ', portador(a) de la C.I.No.'.$row_RS_Empleados['CedulaLetra'].'-'.Fnum_dec($row_RS_Empleados['Cedula']).'';
		$pdf->SetFont('Arial','',12);
		$pdf->Write($linea, $Concepto );  $pdf->Ln();
		
		$Concepto = 'He recibido la cantidad de:  ';
		$pdf->SetFont('Arial','B',12);
		$pdf->Write($linea, $Concepto ); $pdf->Ln();
		
		$Concepto = '- - '.Fnum_Letras($MontoPago).' - -';
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(160,$linea, $Concepto ,0,0,'R'); 
		//$pdf->Write($linea, $Concepto );
		
		$Concepto = 'Bs.'.Fnum($MontoPago).'';
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(30,$linea, $Concepto ,0,1,'R'); 
		//$pdf->Write($linea, $Concepto );  $pdf->Ln();
		
		$Concepto = 'Por concepto de: ';
		//$Concepto .= $DiasPagados.' días de ';
		$Concepto .= ''.$ReciboDe.'';
		
		
		//$Concepto ='';
		if($DiasPagados < 30){
		if($ReciboDe == 'UTILIDADES') $Concepto .= ' (fraccionadas: ';
		else $Concepto .= ' (fraccionados: ';
		
		$Concepto .= ' '.DDMMAAAA($row_RS_Empleados['FechaIngreso']).' - Diciembre '.date('Y').') ('.$AnosLaborados.' año)'; }
		else
		$Concepto .= ' correspondientes al año '.date('Y').'.';
		// $Concepto .= ' (Enero 2011 - Diciembre 2011) ';
		
		/*
		if(isset($_GET['Bono'])){
			$Concepto = 'Por concepto de: '.'Bono de Productividad'; }
		*/
		
		$pdf->SetFont('Arial','',12);
		$pdf->Write($linea, $Concepto ); 
		
		//$Concepto .= 'correspondientes a '.$MesesLaborados.' meses laborados';
		//$Concepto .= ' en esta empresa devengando un sueldo mensual de Bs.';
		//$pdf->SetFont('Arial','',12);  
		//$pdf->Write($linea, $Concepto );
		
		$Concepto = Fnum($MontoBase);
		
		//$TotalCheque += $SueldoBase;
		
		$pdf->SetFont('Arial','B',12);  
		//$pdf->Write($linea, $Concepto );
		
		//$Concepto = ' a razón de ';
		//$pdf->SetFont('Arial','',12);  
		//$pdf->Write($linea, $Concepto );
		
		//$Concepto = 'Bs.'.Fnum($SueldoBase/30).'';
		//$pdf->SetFont('Arial','B',12);  
		//$pdf->Write($linea, $Concepto );
		
		//$Concepto = ' diarios.';
		//$pdf->SetFont('Arial','',12);  
		//$pdf->Write($linea, $Concepto );
		
		//$pdf->Ln();
		
		
		
		//  $pdf->MultiCell(195 , $linea, $Concepto ,0);
		//  $pdf->MultiCell(195 , $linea, $Concepto ,0);
		// $pdf->Write($linea, $Concepto );
		
		
		
		$pdf->SetFont('Arial','',10);
		$pdf->Ln($linea);
		//$pdf->Cell(195,4, 'La cantidad de: '.Fnum_Letras($MontoPago) ,0,1,'L');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(60,$linea, 'Forma de Pago: ' ,0,1,'L');
		
		$pdf->SetFont('Arial','',10);
		
		$linea = 5;
		//$pdf->Cell(5,$linea, '' ,1,0,'L');
		//$pdf->Cell(27,$linea, 'Transferencia ' ,0,0,'L');
		
		$pdf->Cell(5,$linea, '' ,1,0,'L');
		$pdf->Cell(50,$linea, 'Efectivo _________________ ' ,0,0,'L');
		
		$pdf->Cell(5,$linea, '' ,1,0,'L');
		$pdf->Cell(17,$linea, 'Cheque' ,0,0,'L');
		$pdf->Cell(5,$linea, '' ,1,0,'L');
		$pdf->Cell(17,$linea, 'Transf' ,0,0,'L');
		$pdf->Cell(5,$linea, '' ,1,0,'L');
		$pdf->Cell(20,$linea, 'B.Mercantil' ,0,0,'L');
		$pdf->Cell(5,$linea, '' ,1,0,'L');
		$pdf->Cell(20,$linea, 'B.Provincial' ,0,0,'L');
		$pdf->Cell(20,$linea, 'Núm:_________________' ,0,1,'L');
		
		$pdf->Ln($linea*2);
		$pdf->Cell(180,$linea*2, 'Trabajador Conforme: Firma  ______________________________ C.I.: _______________ Fecha: _______________ ' ,0,1,'L');
		//$pdf->Cell(180,$linea*2, '' ,0,1,'R');
		
		
		$PagAnterior = $row_RS_Empleados['Pagina']; 
		
		
		$pdf->SetFont('Arial','i',8);
		$pdf->Ln($linea*2);
		$pdf->Cell(195,$linea, "fi: ".DDMMAAAA($row_RS_Empleados['FechaIngreso']).' -> '.$DiasPagados.'d / '."base: ". ($row_RS_Empleados['SueldoBase']*2) , 0 , 0,'R');
		
		$TotalLote += $TotalCheque;
		
		
	$CodConcepto = ucwords(strtolower($ReciboDe));	$Obs = $DiasPagados.' d';
	$sql = "INSERT INTO Empleado_Pago
			(Codigo_Empleado, Codigo_Quincena, Concepto, Obs, Monto, Registro_por) 
			VALUES
			('$Codigo_Empleado', '$Ano 12 $CodConcepto', '+$CodConcepto', '$Obs', '$TotalCheque','$MM_Username') ";
	$mysqli->query($sql);
	//echo $sql."<br>";

	$Pago_extra = round($TotalCheque , 2);
	$sql_Pago_Extra = "UPDATE Empleado 
						 SET Pago_extra2 = '$Pago_extra'
						 WHERE CodigoEmpleado = '$Codigo_Empleado'";
	mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());		
		
	}
	} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
	//$pdf->SetFont('Arial','',8);
	//$pdf->Cell(115, 4, 'SubTot: '.Fnum($SubTotNominaBase),0,1,'R');
	//$pdf->Cell(115, 4, 'Total: '.Fnum($TotNominaBase),0,0,'R');

if($totalRows_RS_Empleados > 1){
	$pdf->AddPage();
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(20,$linea, 'total: '. Fnum($TotalLote) ,0,1,'L');
}

$pdf->Output();
mysql_free_result($RS_Empleados);
?>
