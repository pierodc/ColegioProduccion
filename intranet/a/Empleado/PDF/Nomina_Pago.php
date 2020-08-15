<?php 
$MM_authorizedUsers = "91,AsistDireccion,Contable";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');

// Nomina de pago quincenal

$Quincena = substr($_GET['Quincena'],0,1);
$Mes = substr($_GET['AnoMes'],5,2);
$Ano = substr($_GET['AnoMes'],0,4);
$FechaObj = $Ano2.'-09-15'; //Para calculo de antiguedad 
 
$Mes = $_GET['Mes'];
$Ano = $_GET['Ano'];

class PDF extends FPDF
{
	//Cabecera de página
	function Header() {

		$Mes = $_GET['Mes'];
		$Ano = $_GET['Ano'];
		$Quincena = substr($_GET['Quincena'],0,1);
		if($Quincena=='1') 
			$Quincena='1ra'; 
		else 
			$Quincena='2da';
		$titulo = 'correspondiente a la '.$Quincena.' quincena del mes de '.Mes($Mes).' de '.$Ano;

		$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$linea=5;
		$this->Ln(5);
	
		$this->SetFont('Times','B',14);
		$this->Cell(250,$linea, 'NÓMINA DE PAGO' ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		$this->Cell(250,$linea, $titulo ,0,1,'R'); 
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(18,$linea,'Cédula',1,0,'C');
		$this->Cell(45,$linea,'Apellidos y Nombre',1,0,'L');
		$this->Cell(15,$linea,'Cargo','TBL',0,'L');
		$this->Cell(10,$linea,'(hr)','TBR',0,'R');
		$this->Cell(22,$linea,'S. Base',1,0,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(15,$linea,'IVSS 4%',1,0,'C');
		$this->Cell(15,$linea,'LH 1%',1,0,'C');
		$this->Cell(15,$linea,'SPFO ,5%',1,0,'C');
		//$this->Cell(15,$linea,'ISLR',1,0,'C');
		$this->Cell(16,$linea,'F. Ingreso',1,0,'L');
		$this->Cell(37,$linea,'Deduc/Bonif',1,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(22,$linea,'S. Neto',1,0,'C');
		$this->Cell(30,$linea,'Firma',1,1,'C');
	}
	
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-10);
		//Arial italic 8
		$this->SetFont('Arial','I',8);
		//Número de página
		$this->Cell(0,5,'Pág. '.$this->PageNo(),0,0,'R');
		
		$Fecha = date('d ').Mes( date('m') ).date(' Y');
		$this->SetXY(10,-10);
		$this->Cell(0,5,''.$Fecha,0,0,'L');
		
	}
}


$linea = 5.9;
$tipologia = 'Arial';


$pdf=new PDF('L', 'mm', 'Letter');
$pdf->SetMargins(10,5,10);
$pdf->SetFillColor(255);

$pdf->AddPage();

$pdf->SetFont('Arial','',10);
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_activo = 1 
						ORDER BY Pagina, Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);


//?Ano=2014&Mes=12&Quincena=1ra
// $Quincena



if(date('Y') == $_GET['Ano'] and date('m') == $_GET['Mes'] ){
       $sql = "DELETE FROM Empleado_Pago WHERE Codigo_Quincena LIKE '%$Ano $Mes $Quincena%'";
       $RS = mysql_query($sql, $bd) or die(mysql_error());
	   }

$PagAnterior = $row_RS_Empleados['Pagina'];


/*$Nom_archivo = 'archivo/Fideicomiso_'.$Ano.'_'.$Mes.'.csv';
if(file_exists($Nom_archivo))
	unlink($Nom_archivo);
*/

do { // para cada empleado
	if($PagAnterior != $row_RS_Empleados['Pagina']){
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(115, 3.5, 'SubTot: '.Fnum($SubTotNominaBase),0,0,'R');
		$SubTotNominaBase=0;
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();}
	
	$SubTotNominaBase += $row_RS_Empleados['SueldoBase']*1; 
	$TotNominaBase    += $row_RS_Empleados['SueldoBase']*1; 
	
	$ivss = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_ivss'] * 0.04 ;
	$lph  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_lph']  * 0.01 ; 
	$spf  = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_spf']  * 0.005 ;
	$islr = $row_RS_Empleados['SueldoBase'] * $row_RS_Empleados['SW_islr']  * $row_RS_Empleados['islr_porciento'] / 100 ;
	$deducciones = $row_RS_Empleados['MontoDeducciones'];
	
	// DEDUCCIONES
	$sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = '".$row_RS_Empleados['CodigoEmpleado']."' 
			AND Quincena='".$Quincena."' 
			AND Mes='".$Mes."' 
			AND Ano='".$Ano."' 
			AND (Tipo='PP' OR Tipo='AU' OR Tipo='DE' OR Tipo='AQ')";
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	
	if($totalRows_Result>0){
		do{
			$deducciones += $row_Result['Monto'];	
		} while ($row_Result = mysql_fetch_assoc($Result)); }
	
	
	//BONIFICACIONES Y PRESTAMOS
	$pagos_bonificaciones = 0;
	$sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = '".$row_RS_Empleados['CodigoEmpleado']."' 
			AND Quincena='".$Quincena."' 
			AND Mes='".$Mes."' 
			AND Ano='".$Ano."' 
			AND (Tipo='BO' OR Tipo='PA' OR Tipo='RE' OR Tipo='PR')";
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	
	if($totalRows_Result>0){
		do{
			$pagos_bonificaciones += $row_Result['Monto'];	
		} while ($row_Result = mysql_fetch_assoc($Result)); } 
	
	
	$SueldoBase = round($row_RS_Empleados['SueldoBase'],2);
	$neto = round(round($SueldoBase - $ivss - $lph - $spf - $islr,2) - $deducciones + $row_RS_Empleados['SueldoBase_Extra'], 2); 

$IngresoFideicomiso = $Ano.'-'.$Mes.'-01'; 

if($IngresoFideicomiso >= $row_RS_Empleados['FechaIngresoFideicomiso'])
	$SumaFideicomiso = 1;
else
	$SumaFideicomiso = 0;

$sql = "INSERT INTO Empleado_Pago 
	(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto) VALUES
	('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena', '$Ano $Mes $Quincena', '+SueldoBase', '$SueldoBase')";

if($ivss > 0)
	$sql .= ",('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena', '$Ano $Mes $Quincena', '-ivss', '-$ivss')";
if($lph > 0)
	$sql .= ",('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena', '$Ano $Mes $Quincena', '-lph' , '-$lph' )";
if($spf > 0)
	$sql .= ",('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena', '$Ano $Mes $Quincena', '-spf' , '-$spf' )";
if($islr > 0)
	$sql .= ",('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena', '$Ano $Mes $Quincena', '-islr' , '-$islr' )";


if(date('Y') == $_GET['Ano'] and date('m') == $_GET['Mes'] ){		
        $RS = mysql_query($sql, $bd) or die(mysql_error());
		}
	
	
	
	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(18,$linea, Fnum_dec($row_RS_Empleados['Cedula']) ,1,0,'R',1);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(45,$linea, $row_RS_Empleados['Apellidos'].' '.substr($row_RS_Empleados['Apellido2'],0,1).', '. $row_RS_Empleados['Nombres'].' '.substr($row_RS_Empleados['Nombre2'],0,1) ,1,0,'L',1);
	

$CargoCorto = $row_RS_Empleados['CargoCorto'];
	
$sql_Curso = "SELECT * FROM Curso 
				WHERE Cedula_Prof_Guia LIKE '%".$row_RS_Empleados['Cedula']."%' ";  
$RS = $mysqli->query($sql_Curso);
if ($row = $RS->fetch_assoc()) {
	$CargoCorto = "D: ".$row['Curso'].'º '.substr($row['NombreNivel'],0,3).' '.$row['Seccion'];
}

$sql_Curso = "SELECT * FROM Curso 
				WHERE Cedula_Prof_Aux LIKE '%".$row_RS_Empleados['Cedula']."%' ";  
$RS = $mysqli->query($sql_Curso);
if ($row = $RS->fetch_assoc()) {
	$CargoCorto = "Ax: ".$row['Curso'].'º '.substr($row['NombreNivel'],0,3).' '.$row['Seccion'];
}

	
	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(20,$linea,  $CargoCorto ,'TBL',0,'L',1);
	$Horas = '';
	if($row_RS_Empleados['HrAcad']>0 or $row_RS_Empleados['HrAdmi']>0){ 
		$Horas = $row_RS_Empleados['HrAcad']+$row_RS_Empleados['HrAdmi'];
		$Horas = '('.$Horas.')';
		}
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 5,$linea,  $Horas ,'TBR',0,'R',$Horas==''?0:1);
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(22,$linea, Fnum($row_RS_Empleados['SueldoBase']) ,1,0,'R',1);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,$linea, Fnum($ivss) ,1,0,'R');
	$pdf->Cell(15,$linea, Fnum($lph) ,1,0,'R');
	$pdf->Cell(15,$linea, Fnum($spf) ,1,0,'R');
	//$pdf->Cell(15,$linea, Fnum($islr) ,1,0,'R');
	$pdf->Cell(16,$linea, DDMMAAAA($row_RS_Empleados['FechaIngreso']) ,1,0,'R');
	
	$DeducBonif = '';
	if($deducciones > 0)
		$DeducBonif = '-'.Fnum($deducciones);
	
	if($pagos_bonificaciones > 0)
		$DeducBonif .= '+'.Fnum($pagos_bonificaciones);
	
	$neto += $pagos_bonificaciones; 
	
	//$neto -= $row_RS_Empleados['Pago_extra_deduc'];
	
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(37,$linea, $DeducBonif ,1,0,'R');
	
	if($neto < 0)
		$pdf->SetTextColor(255,100,100);
		
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22,$linea, Format($neto) ,1,0,'R');
	$pdf->SetTextColor(0);
	
	$TotalNominaNeto += $neto;
	$TotalNominaNetoForma[$row_RS_Empleados['FormaDePago']] += $neto;
	
	$pdf->SetFont('Arial','',7);
	//$pdf->Cell(4,$linea, $row_RS_Empleados['FormaDePago']  ,0,0,'L');
	$pdf->Cell(30,$linea, $row_RS_Empleados['FormaDePago']  ,1,1,'L');
	$pdf->SetFont('Arial','',10);
	
	
	
	
	$sqlUPDATE = "UPDATE Empleado SET 
					MontoUltimoPago = '".$neto."',
					Pago_extra = '".$neto."'
					WHERE CodigoEmpleado = '".$row_RS_Empleados['CodigoEmpleado']."'";	
	$RSupdate = mysql_query($sqlUPDATE, $bd) or die(mysql_error());

	$PagAnterior = $row_RS_Empleados['Pagina']; 
	
/*/ INICIO Fideicomiso
$FechaObj = '2012-09-15';
extract($row_RS_Empleados);
if($SW_Antiguedad=='1')	{
	$SueldoDiario = round($SueldoBase/15 , 2);
	$AnosLaborados = Fecha_Meses_Laborados($FechaIngreso,$FechaObj); 
	if($AnosLaborados>=1 and $AnosLaborados<=15) 
		$AnosLaborados =  floor($AnosLaborados);
	if($AnosLaborados>15) 
		$AnosLaborados =  15;
	$DiasBono = 6 + $AnosLaborados;
	$MontoBono = round($DiasBono*$SueldoDiario , 2);
	$SueldoIntDia = round( ($SueldoBase*2*14 + $MontoBono)/365 ,2);
	
	$MontoSep = round($SueldoIntDia*2.5 , 2);
	$TotSep += $MontoSep;
	
	$MontoOct = round($SueldoIntDia*5 , 2);
	$TotOct += $MontoOct;
	
	// Cambiar Oct <-> Sep para media quincena
	$Monto = substr('000000000000'.$MontoOct*100 , -14);
	
	$txt .= '01'.date('dmY').'1059876'.$CedulaLetra. substr('0000000000'.$Cedula,-9).$Monto.'
	';
}*/
/// FIN Fideicomiso

	 
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(115, 4, 'SubTotal Sueldo Base: '.Fnum($SubTotNominaBase),0,0,'R');
	$pdf->Cell(90, 4, 'Total Transf: '.Fnum($TotalNominaNetoForma['T']),0,1,'R');
	
	$pdf->Cell(115, 4, 'Total Sueldo Base: '.Fnum($TotNominaBase),0,0,'R');
	$pdf->Cell(90, 4, 'Total Cheque: '.Fnum($TotalNominaNetoForma['C']),0,1,'R');
	
	$pdf->Cell(115, 4, $FechaObjAntiguedad ,0,0,'R');
	$pdf->Cell(90, 4, 'Total Efect: '.Fnum($TotalNominaNetoForma['E']),0,1,'R');
	
	$pdf->Cell(115);
	$pdf->Cell(90, 4, 'Total Neto: '.Fnum($TotalNominaNeto),0,1,'R');

// Archivo Fideicomiso	
//file_put_contents($Nom_archivo , $txt );	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>