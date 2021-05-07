<?php 
$MM_authorizedUsers = "Coordinador,docente,99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php'); 
require_once('../../intranet/a/archivo/Variables.php'); 
require_once('../../inc/rutinas.php'); 
require_once('../../inc/fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
function Header()
{

}

//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    //$this->SetY(-10);
    //Arial italic 8
    //$this->SetFont('Arial','I',8);
    //Número de página
    //$this->Cell(0,5,'Pág. '.$this->PageNo(),0,0,'R');
	
}
}


$linea = 6.2;
$tipologia = 'Arial';

$pdf=new PDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255);
$pdf->SetMargins(10,10,10);
$pdf->SetFont('Arial','',10);

if(isset($_GET['CodigoEmpleado'])){ 
	$add_sql = " AND CodigoEmpleado = '".$_GET['CodigoEmpleado']."' ";}

$add_sql .= " AND SW_PagoVacac = '1' ";
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
					   WHERE SW_activo=1 
					   $add_sql
					   AND Cedula = '$MM_Username'  
					   ORDER BY Pagina, Apellidos, Nombres 
					   LIMIT 0 , 200 ";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);



$PagAnterior = $row_RS_Empleados['Pagina'];
$impar=true;

do { 

	
	$pdf->AddPage();
	//Reticula($pdf);	
	$pdf->Image('../../img/solcolegio.jpg',10,10,0,19	);
	//$pdf->Image('../../../../img/solcolegio.jpg',10,150,0,19 );
	
	$pdf->SetXY(32,12);
	
	$linea=5;
	$pdf->SetFont('Times','',12);
	$pdf->SetXY(32,12);
	$pdf->Cell(60,$linea,' COLEGIO ',0,1,'C',1); 
	$pdf->SetFont('Times','B',16);
	$pdf->SetX(32);
	$pdf->Cell(60,$linea,' San Francisco de Asís, c.a. ',0,1,'C',1);  
	$pdf->SetX(32);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(60,$linea,' RIF: J-00137023-4 ',0,0,'C',1); 
	$pdf->SetX(32);


	$pdf->SetFont('Times','B',14);
	$pdf->SetXY(110,10);
	$pdf->Cell(95,$linea, 'RECIBO DE PAGO' ,0,1,'R',1); 
	
	$pdf->SetFont('Times','B',12);
	$titulo = 'correspondiente a las vacaciones del período '.$AnoEscolar;
	$pdf->SetXY(110,20);
	$pdf->Cell(95,$linea, $titulo ,0,0,'R',1); 
	$linea=6.5;
	
	$pdf->SetXY(10,30);

	$pdf->SetFont('Arial','',10);	
	$pdf->Cell(20,$linea,'Cédula',1,0,'C',1);
	$pdf->Cell(125,$linea,'Apellidos y Nombre',1,0,'L',1);
	$pdf->Cell(50,$linea,'Cargo (hr)',1,1,'R',1);
	$pdf->Cell(20,$linea, Fnum_dec($row_RS_Empleados['Cedula']) ,1,0,'R',1);
	$pdf->Cell(125,$linea, $row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Nombre2'].' '. $row_RS_Empleados['Apellidos'].' '. $row_RS_Empleados['Apellido2'] ,1,0,'L',1);
	

	$Horas = '';
	if($row_RS_Empleados['BsHrAcad'] > 0){ 
		$Horas = 'Ac:'.$row_RS_Empleados['HrAcad'].' ';}
	if($row_RS_Empleados['BsHrAdmi'] > 0){ 
		$Horas .= '/ Ad:'.$row_RS_Empleados['HrAdmi'].'';}
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 50,$linea,  $row_RS_Empleados['CargoCorto'].' ( '.$Horas.' )' , 1,1,'R', 1 );
	$pdf->SetFont('Arial','',10);

	$pdf->Cell(91,$linea, 'Concepto' ,1,0,'C',1);
	$pdf->Cell(25,$linea, 'Sueldo Base' ,1,0,'C',1);
	$pdf->Cell(18,$linea, 'IVSS' ,1,0,'C',1);
	$pdf->Cell(18,$linea, 'LPH' ,1,0,'C',1);
	$pdf->Cell(18,$linea, 'SFP' ,1,0,'C',1);
	$pdf->Cell(25,$linea, 'Neto' ,1,1,'C',1);




	$SueldoBase = round($row_RS_Empleados['SueldoBase'] ,2);
	$ivss = round($SueldoBase * $row_RS_Empleados['SW_ivss'] * 0.04 ,2);
	$lph  = round($SueldoBase * $row_RS_Empleados['SW_lph']  * 0.01 ,2); 
	$spf  = round($SueldoBase * $row_RS_Empleados['SW_spf']  * 0.005 ,2);
	$neto = round($SueldoBase - $ivss - $lph - $spf ,2);
	//$deducciones = $row_RS_Empleados['MontoDeducciones'];
	$linea = 5; 
	

	$Pagos = array('1ra Quincena de Agosto','2do Quincena de Agosto','1ra Quincena de Septiembre');

	//$pdf->Cell(100,1, '' ,'TB',1,'C',0);
	$TotalNeto = 0;
	foreach($Pagos as $Pago){
		$pdf->Cell(91,$linea, "Vacaciones ". $Pago ,'LR',0,'L',0);
		$pdf->Cell(25,$linea, Fnum($SueldoBase) ,'LR',0,'R',0);
		$pdf->Cell(18,$linea, Fnum($ivss) ,'LR',0,'R',0);
		$pdf->Cell(18,$linea, Fnum($lph) ,'LR',0,'R',0);
		$pdf->Cell(18,$linea, Fnum($spf) ,'LR',0,'R',0);
		$pdf->Cell(25,$linea, Fnum($neto) ,'LR',1,'R',0);
		$TotalNeto += $neto; }
	
		$pdf->Cell(170,$linea, 'SubTotal Vacaciones: ' , 'T' ,0,'R',0);
		$pdf->Cell(25,$linea, Fnum($neto*3) ,1,1,'R',0);

		$MesesLaborados = Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'] , $FechaObjAntiguedadVacacional)*12; 
		if($MesesLaborados>3)
			$Factor = 15;
		else
			$Factor = round($MesesLaborados * 5 , 2);
	
		$AnosLaborados  = Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'] , $FechaObjAntiguedadVacacional);
		if($AnosLaborados < 1) {
			$FactorBaseBono = $AnosLaborados; 
			$AnosLaborados = 0;}
	
		elseif($AnosLaborados <= 15) {
			$AnosLaborados =  floor($AnosLaborados);
			$FactorBaseBono = 1;}
			
		elseif($AnosLaborados > 15) {
			$AnosLaborados =  15;
			$FactorBaseBono = 1;}
			
		
		$SueldoDiario = round( $SueldoBase /15 , 2);
		$DiasBono = $FactorBaseBono * 15 + $AnosLaborados ; // hasta 15+15
		$MontoBono = round($DiasBono * $SueldoDiario , 2);

		$pdf->Ln(1);
		$pdf->Cell(170,$linea, 'Bono Vacacional : '.$DiasBono." días a razón de Sueldo Diario Bs.".$SueldoDiario ." " ,'LRT',0,'L',0);
		$pdf->Cell(25,$linea, '' ,'LRT',1,'R',0);
		$pdf->Cell(170,$linea, 'Fecha Ingreso: '.DDMMAAAA($row_RS_Empleados['FechaIngreso']) ,'LRB',0,'L',0);
		$pdf->Cell(25,$linea, Fnum($MontoBono) ,'LRB',1,'R',0);
		$TotalNeto += $MontoBono; 
	
		$Codigo_Empleado = $row_RS_Empleados['CodigoEmpleado'];
		$Codigo_Quincena = date('Y').' 07 3';
		$Codigo_Quincena = date('Y').' 07 3b';
		
		$sql = "DELETE FROM Empleado_Pago
				WHERE Codigo_Empleado = '$Codigo_Empleado'
				AND Codigo_Quincena = '$Codigo_Quincena'";
		//$mysqli->query($sql) or die(mysql_error());

		$sql = "INSERT INTO Empleado_Pago
				(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto)
				VALUES
				('$Codigo_Empleado','$Codigo_Quincena','$Codigo_Quincena','B.Vacac. $DiasBono d.','$MontoBono')";
		//echo $sql;
		//$mysqli->query($sql) or die(mysql_error());
		
	
		if(strpos(" ".$row_RS_Empleados['TipoDocente'] , "Profesor") > 0 and $row_RS_Empleados['SW_BonoProfHora'] == '1'){
			$pdf->Ln(1);
			$pdf->Cell(170,$linea, "Bonificación de profesor por horas año escolar $AnoEscolar ",'LRTB',0,'L',0);
			$MontoBonoProfHora = $SueldoBase * 2*$FactorBaseBono;
			$pdf->Cell(25,$linea, Fnum($MontoBonoProfHora) ,1,1,'R',0);
			$TotalNeto += $MontoBonoProfHora; }
	
	
	
	
	
/*	
	
	$pdf->SetFont('Arial','',9);
	$linea = 4; 
	
	
	$pdf->SetFont('Arial','',10);
	$linea = 5; 
	
	$Quin = substr($Quincena,0,1);
	
	$sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
			AND Mes='".$Mes."' 
			AND Ano='".$Ano."' 
			AND Quincena='".$Quin."'  
			AND Tipo <> 'AQ' ";
	//echo $sql;
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	$deducciones = round($deducciones,2);
	if($totalRows_Result > 0){
	do{
	$Monto = round($row_Result['Monto'],2);	
	$Tipo = $row_Result['Tipo'] ; 
	$Desc ='';
	if($Tipo == 'PR') {
	$Desc = 'Prestamo Bs.'.Fnum($Monto).' ';
	$Monto = 0;}
	if($Tipo == 'PP') 
	$Desc = 'Pago a cuenta de prestamo ';
	if($Tipo == 'AU') 
	$Desc = 'Ausencia(s) ';
	if($Tipo == 'DE') 
	$Desc = 'Deducción ';
	if($Tipo == 'AQ') 
	$Desc = 'Adelanto de Quincena ';
	if($Tipo == 'BO') 
	$Desc = 'Bonificación ';
	if($Tipo == 'RE') 
	$Desc = 'Reintegro ';
	if($Tipo == 'PA') 
	$Desc = 'Pago ';
	
	if(	$Tipo == 'PP' or $Tipo == 'AU' or $Tipo == 'DE' or $Tipo == 'AQ' ){ 
	$pdf->Cell(145,$linea, $Desc . $row_Result['Descripcion'] ,'LR',0,'L',1);
	$pdf->Cell(25,$linea, Fnum($Monto) ,'LR',0,'R',1);
	$pdf->Cell(25,$linea, '' ,'LR',1,'C',1);
	$deducciones += $Monto;	}
	else{
	$pdf->Cell(145,$linea, $Desc . $row_Result['Descripcion'] ,'LR',0,'L',1);
	$pdf->Cell(25,$linea, '' ,'LR',0,'R',1);
	$pdf->Cell(25,$linea, Fnum($Monto) ,'LR',1,'R',1);
	$deducciones -= $Monto;	}
	
	} while ($row_Result = mysql_fetch_assoc($Result)); }
	
	// ADELANTO DE QUINCENA
	$sql = "SELECT * FROM Empleado_Deducciones 
	WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
	AND Mes='".$Mes."' 
	AND Ano='".$Ano."' 
	AND Quincena='".$Quin."'  
	AND Tipo = 'AQ' ";
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	
	if($totalRows_Result>0){
	$pdf->Cell(145,$linea, 'Adelanto '.$row_Result['Descripcion'] ,'LR',0,'L',1);
	$pdf->Cell(25,$linea, Fnum($row_Result['Monto']) ,'LR',0,'R',1);
	$pdf->Cell(25,$linea, '' ,'LR',1,'R',1);
	$deducciones += round($row_Result['Monto'],2);	
	}
	
	$neto = round(round($row_RS_Empleados['SueldoBase'] - $ivss - $lph - $spf ,2) - $deducciones ,2); 
*/

	
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	$linea=7;
	$pdf->Cell(170,$linea, 'Total' ,0,0,'R');
	$pdf->Cell(25,$linea, Format($TotalNeto) ,1,0,'R');
	$pdf->SetX(12);
	$pdf->Ln(1);
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(195,4, 'La cantidad de: ' ,0,1,'L');
	$pdf->Cell(195,4, Fnum_Letras($TotalNeto) ,0,1,'L');
	
	
	//$TotalNeto = $TotalNeto - $row_RS_Empleados['Pago_extra'];
	$TotalNeto = $TotalNeto;
	$sql_Pago_Extra = "UPDATE Empleado SET Pago_extra2 = '$TotalNeto' WHERE CodigoEmpleado = '".$row_RS_Empleados['CodigoEmpleado']."'";	
	//mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());	
	
	
	$pdf->SetFont('Arial','B',12);
	//$pdf->Ln(2);
	$pdf->Cell(60,$linea, 'Forma de Pago: ' ,0,1,'L',0);
	
	$pdf->SetFont('Arial','',10);
	
	$linea = 5;
	$pdf->Cell(5,$linea, '' ,1,0,'L',1);
	//$pdf->Cell(50,$linea, 'Cheque Banco:________________________ Núm:__________________ ' ,0,1,'L',0);
	$pdf->Cell(50,$linea, 'Transferencia Banco Mercantil Cuenta Núm: '.$row_RS_Empleados['NumCuentaA'].$row_RS_Empleados['NumCuenta']  ,0,1,'L',0);
	
	$pdf->Cell(5,$linea, '' ,1,0,'L',1);
	//$pdf->Cell(50,$linea, 'Cheque Banco:________________________ Núm:__________________ ' ,0,1,'L',0);
	$pdf->Cell(50,$linea, 'EFECTIVO Bs.'.Fnum($row_RS_Empleados['Pago_extra2_deduc'])  ,0,1,'L',0);
	
	$pdf->Ln(7);
	$pdf->Cell(60,$linea, 'Firma Empleado Conforme: _______________________________________________ C.I.: _____________________ ' ,0,1,'L',1);
	
	

	$pdf->SetFont('Arial','B',12);	
	$pdf->SetXY(150,130);
	$pdf->Cell(25,$linea, '***'.Fnum($TotalNeto).'***' ,0,0,'L',1);
	$pdf->SetXY(10,140);
	$pdf->Cell(150,$linea, $row_RS_Empleados['Nombres'].' '.$row_RS_Empleados['Nombre2'].' '. $row_RS_Empleados['Apellidos'].' '. $row_RS_Empleados['Apellido2'].' ----' ,0,0,'L',1);
	$pdf->SetXY(10,150);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(150,$linea, '***'.Fnum_Letras($TotalNeto).'***' ,0,0,'L',1);
	$pdf->SetXY(20,160);
	$pdf->Cell(50,$linea, "Caracas, ".date("d")." de ".Mes(date('m')) ,0,0,'L',1);
	$pdf->Cell(20,$linea, date("Y") ,0,0,'L',1);

	$pdf->SetXY(10,130);
	$pdf->Cell(195,60, '' ,1,0);


$Emp = $row_RS_Empleados['Apellidos'].', '. $row_RS_Empleados['Nombres'];	


} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	

$asunto = 'Recibo Vacaciones '.$CedulaPC;
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>' . "\r\n";
$cabeceras .= 'To: Giampiero Di Campo <piero@sanfrancisco.e12.ve>' . "\r\n";
$para = ' Giampiero Di Campo <piero@sanfrancisco.e12.ve>';
	
$txt .= "<teble>";	
		
$txt .= "<tr><td>"."Emp" ."</td><td>". $Emp."</td></tr>\r\n";	
$txt .= "<tr><td>"."Emp" ."</td><td>". $CodigoQuincena."</td></tr>\r\n";	
$txt .= "<tr><td>"."CI" ."</td><td>". $row_RS_Empleados['Cedula']."</td></tr>\r\n";	
$txt .= "<tr><td>Fecha " ."</td><td>". date("d m Y H:i:s")."</td></tr>\r\n";	
$txt .= "<tr><td>Desde IP: " ."</td><td>". $_SERVER['REMOTE_ADDR']."</td></tr>\r\n";
$txt .= "<tr><td>CedulaPC: " ."</td><td>". $CedulaPC."</td></tr>\r\n";
	
	
	
$txt .= "</teble>";		
			
			
mail($para, $asunto, $txt, $cabeceras);


$pdf->Output();
mysql_free_result($RS_Empleados);
?>
