<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php');
require_once('../../inc/fpdf.php');


$Quincena = substr($_GET['Quincena'],0,1);
$Mes = substr($_GET['AnoMes'],5,2);
$Ano = substr($_GET['AnoMes'],0,4);


class PDF extends FPDF
{
	//Cabecera de página
	function Header() {
		$this->Image('../../img/solcolegio.jpg',10,5,0,20);
		$linea=5;
		$this->Ln(5);
		
		$this->SetFont('Times','',12);
		$this->Cell(20,$linea); $this->Cell(60,$linea,' U.E. COLEGIO ',0,0,'C'); 
		
		$this->SetFont('Times','B',14);
		$this->Cell(170,$linea, 'NÓMINA DE PAGO' ,0,1,'R'); 
		
		$this->SetFont('Times','B',16);
		$this->Cell(20,$linea); $this->Cell(60,$linea,' San Francisco de Asís ',0,0,'C');  
		
		$this->SetFont('Times','B',12);
		$Mes = substr($_GET['AnoMes'],5,2);
		$Ano = substr($_GET['AnoMes'],0,4);
		$Quincena = substr($_GET['Quincena'],0,1);
		if($Quincena=='1') 
			$Quincena='1ra'; 
		else 
			$Quincena='2da';
		$titulo = 'correspondiente a la '.$Quincena.' quincena del mes de '.Mes($Mes).' de '.$Ano;
		$this->Cell(170,$linea, $titulo ,0,1,'R'); 
		
		$this->SetFont('Times','',9);
		$this->Cell(20); $this->Cell(60,$linea,' Los Palos Grandes ',0,0,'C'); 
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(20,$linea,'Cédula',1,0,'C');
		$this->Cell(55,$linea,'Apellidos y Nombre',1,0,'L');
		$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
		$this->Cell(18,$linea,'S. Base',1,0,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(12,$linea,'IVSS 4%',1,0,'C');
		$this->Cell(12,$linea,'LH 1%',1,0,'C');
		$this->Cell(12,$linea,'SPFO ,5%',1,0,'C');
		$this->Cell(18,$linea,'F. Ingreso',1,0,'L');
		$this->Cell(18,$linea,'Deducciones',1,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(18,$linea,'S. Neto',1,0,'C');
		$this->Cell(55,$linea,'Firma',1,1,'C');
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
		
	}
}

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "99,91,95,90,secreAcad";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../Login.php?L=0";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}



$linea = 5.9;
$tipologia = 'Arial';


$pdf=new PDF('L', 'mm', 'Letter');
$pdf->SetMargins(10,5,10);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activoBK=1 ORDER BY Pagina, Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);




//$sql = "DELETE FROM Empleado_Pago WHERE Cod_Descripcion LIKE '%$Ano $Mes $Quincena%'";
//$RS = mysql_query($sql, $bd) or die(mysql_error());

$PagAnterior = $row_RS_Empleados['Pagina'];

$AnoMes = $_GET['AnoMes'];
//$Nom_archivo = 'archivo/Fideicomiso_'.$Ano.'_'.$Mes.'.csv';
///if(file_exists($Nom_archivo))
	//unlink($Nom_archivo);

do { // para cada empleado
	if($PagAnterior != $row_RS_Empleados['Pagina']){
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(115, 3.5, 'SubTot: '.Fnum($SubTotNominaBase),0,0,'R');
		$SubTotNominaBase=0;
		$pdf->SetFont('Arial','',10);
		$pdf->AddPage();}
	
	$SubTotNominaBase += $row_RS_Empleados['SueldoBaseBK']*1; 
	$TotNominaBase    += $row_RS_Empleados['SueldoBaseBK']*1; 
	
	$ivss = $row_RS_Empleados['SueldoBaseBK'] * $row_RS_Empleados['SW_ivss'] * 0.04 ;
	$lph  = $row_RS_Empleados['SueldoBaseBK'] * $row_RS_Empleados['SW_lph']  * 0.01 ; 
	$spf  = $row_RS_Empleados['SueldoBaseBK'] * $row_RS_Empleados['SW_spf']  * 0.005 ;
	$deducciones = $row_RS_Empleados['MontoDeducciones'];
	
	$sql = "SELECT * FROM Empleado_Deducciones 
			WHERE Codigo_Empleado = '".$row_RS_Empleados['CodigoEmpleado']."' 
			AND Quincena='".$Quincena."' 
			AND Mes='".$Mes."' 
			AND Ano='".$Ano."' 
			AND (Tipo='2' OR Tipo='3' OR Tipo='4' OR Tipo='5' OR Tipo='10' OR Tipo='11')";
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	
	if($totalRows_Result>0){
		do{
			$deducciones += $row_Result['Monto'];	
		} while ($row_Result = mysql_fetch_assoc($Result)); }
	
	$SueldoBaseBK = round($row_RS_Empleados['SueldoBaseBK'],2);
	$neto = round(round($SueldoBaseBK - $ivss - $lph - $spf,2) - $deducciones , 2); 
	
$sql = "INSERT INTO Empleado_Pago 
		(Codigo_Empleado, Cod_Descripcion, Monto) VALUES
		('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena +SueldoBaseBK', '$SueldoBaseBK'),
		('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena -ivss', '-$ivss'),
		('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena -lph',  '-$lph'),
		('".$row_RS_Empleados['CodigoEmpleado']."', '$Ano $Mes $Quincena -spf',  '-$spf')";
//$RS = mysql_query($sql, $bd) or die(mysql_error());
	
	
	
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(20,$linea, Fnum_dec($row_RS_Empleados['Cedula']) ,1,0,'R');
	$pdf->Cell(55,$linea, $row_RS_Empleados['Apellidos'].', '. $row_RS_Empleados['Nombres'] ,1,0,'L');
	
	
	$pdf->Cell(17,$linea,  $row_RS_Empleados['CargoCorto'] ,'TBL',0,'L');
	$Horas = '';
	if($row_RS_Empleados['Horas']>0){ 
		$Horas = '('.$row_RS_Empleados['Horas'].')';}
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 5,$linea,  $Horas ,'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(18,$linea, Fnum($row_RS_Empleados['SueldoBaseBK']) ,1,0,'R');
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(12,$linea, Fnum($ivss) ,1,0,'R');
	$pdf->Cell(12,$linea, Fnum($lph) ,1,0,'R');
	$pdf->Cell(12,$linea, Fnum($spf) ,1,0,'R');
	$pdf->Cell(18,$linea, DDMMAAAA($row_RS_Empleados['FechaIngreso']) ,1,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18,$linea, Fnum($deducciones) ,1,0,'R');
	$pdf->Cell(18,$linea, Format($neto) ,1,0,'R');
	$pdf->Cell(55,$linea, '' ,1,1,'L');
		
	$PagAnterior = $row_RS_Empleados['Pagina']; 
	
/** INICIO Fideicomiso
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
}
**/
// FIN Fideicomiso

	 
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(115, 4, 'SubTot: '.Fnum($SubTotNominaBase),0,1,'R');
	$pdf->Cell(115, 4, 'Total: '.Fnum($TotNominaBase),0,0,'R');

// Archivo Fideicomiso	
file_put_contents($Nom_archivo , $txt );	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>
