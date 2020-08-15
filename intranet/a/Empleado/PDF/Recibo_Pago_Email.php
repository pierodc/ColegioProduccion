<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 


if($_GET['Quincena']=='1ra') 
	$Quincena = '1'; 
elseif($_GET['Quincena']=='2da') 
	$Quincena = '2';
$Mes = date('m');
$Ano = date('Y');

if(isset($_GET['AnoMes'])){
		$Mes = substr($_GET['AnoMes'],-2);
		$Ano = substr($_GET['AnoMes'],0,4);
	}

$FechaInicial = $Ano.'-'.$Mes.'-01';
$FechaFinal = $Ano.'-'.$Mes.'-31';

// Elimina ausencias por feriado
$sql = "SELECT * FROM Calendario WHERE 
		Fecha >= '$FechaInicial' AND
		Fecha <= '$FechaFinal' AND 
		NoLaboral = '1'";
$Result = mysql_query($sql, $bd) or die(mysql_error());
$row_Result = mysql_fetch_assoc($Result);
$totalRows_Result = mysql_num_rows($Result);
if($totalRows_Result > 0)
do{
	$sql2 = "UPDATE Empleado_EntradaSalida 
				SET Obs = 'Fer' 
				WHERE Fecha = '".$row_Result['Fecha']."'";
	$Result2 = mysql_query($sql2, $bd) or die(mysql_error());
	}while ($row_Result = mysql_fetch_assoc($Result));
// Elimina


$linea = 6.2;
$tipologia = 'Arial';


if(isset($_GET['CodigoEmpleado'])){ 
	$add_sql = " AND CodigoEmpleado = '".$_GET['CodigoEmpleado']."' ";}
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_activo=1 
						$add_sql 
						ORDER BY Pagina, Apellidos, Nombres LIMIT 0 , 200 ";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);



do { 



$asunto = 'Aviso de Cobro '.$CodigoAlumno;
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$cabeceras .= 'From: Colegio San Francisco de A. <piero@sanfrancisco.e12.ve>' . "\r\n";
$cabeceras .= 'Cco: Giampiero Di Campo <piero@sanfrancisco.e12.ve>' . "\r\n";
$cabeceras .= 'To: ';
$para .= 	  "Giampiero". ' <piero@dicampo.com>, ';
$para .= ' Colegio San Francisco de A. <caja@sanfrancisco.e12.ve>';

$pdf.='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>
<body>';
$pdf.='Aviso de Cobro<br>';

$pdf .= 'Estimado Sr. Representante del Alumno: ';


$pdf .= ' COLEGIO San Francisco de Asís, c.a. ';  

$pdf .= 'RECIBO NÓMINA DE PAGO'; 

$pdf .= ' RIF: J-00137023-4 '; 

$titulo = 'correspondiente a la '.$Quincena.' quincena del mes de '.Mes($Mes).' de '.$Ano;


$pdf .= $titulo; 
$pdf .= 'Cédula';
$pdf .= 'Apellidos y Nombre';
$pdf .= 'Cargo (hr)';
 
 
 
  $SubTotNominaBase=$SubTotNominaBase + $row_RS_Empleados['SueldoBase']*1; 
  $TotNominaBase=$TotNominaBase + $row_RS_Empleados['SueldoBase']*1; 
  
$ivss = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_ivss'] * 0.04 ;
$lph  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_lph']  * 0.01 ; 
$spf  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_spf']  * 0.005 ;
$deducciones = $row_RS_Empleados['MontoDeducciones'];

$pdf .= Fnum_dec($row_RS_Empleados['Cedula']);
$pdf .= $row_RS_Empleados['Apellidos'].', '. $row_RS_Empleados['Nombres'] ;
  
  
//  $pdf->Cell(20,$linea,   ,'TBL',0,'L');
  $Horas = '';
  if($row_RS_Empleados['BsHrAcad']>0){ $Horas = 'Ac:'.$row_RS_Empleados['HrAcad'].' ';}
  if($row_RS_Empleados['BsHrAdmi']>0){ $Horas .= '/ Ad:'.$row_RS_Empleados['HrAdmi'].'';}
  $pdf->SetFont('Arial','',9);
  $pdf->Cell( 50,$linea,  $row_RS_Empleados['CargoCorto'].' ( '.$Horas.' )' ,'TBLR',1,'R');
  $pdf->SetFont('Arial','',10);
  //$pdf->Cell(25,$linea, DDMMAAAA($row_RS_Empleados['FechaIngreso']) ,1,1,'R');

  $pdf->SetFont('Arial','',10);
  $linea = 5; 
  //Encabezado
$pdf .= 'Concepto' ;
$pdf .= 'Deducción' ;
$pdf .= 'Pago' ;
 
$pdf .= 'Sueldo Base' ;
$pdf .= '';
$pdf .= Fnum($row_RS_Empleados['SueldoBase']) ;

  $pdf->SetFont('Arial','',9);
  $linea = 4; 
 
$pdf .= 'Seguro Social (4%)' ;
$pdf .= Fnum($ivss) ,'LR',0,'R');
$pdf .= '' ,'LR',1,'C');
  
  $pdf->Cell(145,$linea, 'Ley Política Hab. (1%)' ,'LR',0,'L');
$pdf .= Fnum($lph) ,'LR',0,'R');
$pdf .= '' ,'LR',1,'C');
  
  $pdf->Cell(145,$linea, 'Seguro Paro Forzoso (0,5%)' ,'LR',0,'L');
$pdf .= Fnum($spf) ,'LR',0,'R');
$pdf .= '' ,'LR',1,'C');
  
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
		    $pdf->Cell(145,$linea, $Desc . $row_Result['Descripcion'] ,'LR',0,'L');
		  $pdf .= Fnum($Monto) ,'LR',0,'R');
		  $pdf .= '' ,'LR',1,'C');
		    $deducciones += $Monto;	}
		else{
		    $pdf->Cell(145,$linea, $Desc . $row_Result['Descripcion'] ,'LR',0,'L');
		  $pdf .= '' ,'LR',0,'R');
		  $pdf .= Fnum($Monto) ,'LR',1,'R');
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
	$pdf->Cell(145,$linea, 'Adelanto '.$row_Result['Descripcion'] ,'LR',0,'L');
	$pdf->Cell(25,$linea, Fnum($row_Result['Monto']) ,'LR',0,'R');
	$pdf->Cell(25,$linea, '' ,'LR',1,'R');
	$deducciones += round($row_Result['Monto'],2);	
}

$neto = round(round($row_RS_Empleados['SueldoBase'] - $ivss - $lph - $spf ,2) - $deducciones ,2); 
  
  $pdf->SetFont('Arial','B',12);
  //$pdf->Cell(18,$linea, Fnum($deducciones) ,1,0,'R');
  $linea=7;
  $pdf->Cell(170,$linea, 'Total' ,'T',0,'R');
  //$pdf->Cell(25,$linea, '' ,1,0,'R');
$pdf .= Format($neto) ,1,0,'R');
  $pdf->SetX(12);
  $pdf->Ln(1);

 
 // $pdf->Cell(25,$linea, Format($neto) ,1,1,'R');
if($neto>0){
  $pdf->SetFont('Arial','',10);
  $pdf->Cell(195,4, 'La cantidad de: '.Fnum_Letras($neto) ,0,1,'L');}


	// AUSENCIAS
	$sql = "SELECT * FROM Empleado_EntradaSalida 
		WHERE Codigo_Empleado = ".$row_RS_Empleados['CodigoEmpleado']." 
		AND Obs='Aus' 
		AND Fecha>='$FechaInicial'
		AND Fecha<='$FechaFinal'
		 ";
		 //echo $sql;
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	if($totalRows_Result>0){
		$pdf->Cell(50,$linea*.7 , 'Ausencias '.Mes($Mes).' '.date('Y').' : ' ,0,0,'L');
		do{
			$pdf->Cell(15,$linea*.7, DDMM($row_Result['Fecha']).' ' ;
		}while($row_Result = mysql_fetch_assoc($Result));
    	$pdf->Ln($linea*.7);
	}
	// AUSENCIAS


  $pdf->SetFont('Arial','B',12);
  //$pdf->Ln(2);
  $pdf->Cell(60,$linea, 'Forma de Pago: ' ,0,1,'L');
  
  $pdf->SetFont('Arial','',10);

$linea = 5;
  $pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(30,$linea, 'Transferencia ' ,0,0,'L');

  $pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(30,$linea, 'Efectivo ' ,0,0,'L');

  $pdf->Cell(5,$linea, '' ,1,0,'L');
  $pdf->Cell(50,$linea, 'Cheque Banco:__________________ Núm:__________________ ' ,0,1,'L');

  $pdf->Ln(7);
  $pdf->Cell(60,$linea, 'Firma Empleado Conforme: _______________________________________________ C.I.: _____________________ ' ,0,1,'L');





$pdf .= '</body></html>';

echo mail($para, $asunto, $pdf, $cabeceras); 
echo '<br>Asunto: '.$asunto;
echo '<br>para: '.$para;
$para='';
echo '<br>heathers: '.$cabeceras;
echo '<br>contenido: '.$pdf;


    } while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
	//$pdf->SetFont('Arial','',8);
	//$pdf->Cell(115, 4, 'SubTot: '.Fnum($SubTotNominaBase),0,1,'R');
	//$pdf->Cell(115, 4, 'Total: '.Fnum($TotNominaBase),0,0,'R');

	
	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>
