<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php');
require_once('../../inc/fpdf.php');


$Quincena = substr($_GET['Quincena'],0,1);
$Mes = substr($_GET['AnoMes'],5,2);
$Ano = substr($_GET['AnoMes'],0,4);
$FechaObj = '2012-09-15'; //Para calculo de antiguedad


class PDF extends FPDF
{
	//Cabecera de página
	function Header() {

		$Mes = substr($_GET['AnoMes'],5,2);
		$Ano = substr($_GET['AnoMes'],0,4);
		$Quincena = substr($_GET['Quincena'],0,1);
		if($Quincena=='1') 
			$Quincena='1ra'; 
		if($Quincena=='2') 
			$Quincena='2da';
		
		$titulo = 'correspondiente al mes de '.Mes($Mes).' de '.$Ano;
	

		$this->Image('../../img/solcolegio.jpg', 10, 5, 0, 16);
		$this->Image('../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$linea=5;
		$this->Ln(5);
	
		$this->SetFont('Times','B',14);
		$this->Cell(200,$linea, 'NÓMINA DE IVSS' ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		$this->Cell(200,$linea, $titulo ,0,1,'R'); 
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(8,$linea,'No',1,0,'C');
		$this->Cell(20,$linea,'Cédula',1,0,'C');
		$this->Cell(50,$linea,'Apellidos y Nombre',1,0,'L');
		$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
		//$this->Cell(26,$linea,'F. Ingreso',1,0,'L');
		$this->Cell(18,$linea,'Ap. Emp.',1,0,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(18,$linea,'Ap. Pat.',1,0,'C');
		$this->Cell(18,$linea,'Total',1,0,'C');
		$this->Ln($linea);

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


$pdf=new PDF('P', 'mm', 'Letter');
$pdf->SetMargins(10,5,10);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_Activo=1 ORDER BY Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);



//$AnoMes = $_GET['AnoMes'];
/*if($Quincena>'0')
	$Nom_archivo = 'archivo/fideicomiso/Fidei_'.$Ano.'_'.$Mes.'_'.$Quincena.'.csv';
else
	$Nom_archivo = 'archivo/fideicomiso/Fidei_'.$Ano.'_'.$Mes.'.csv';
	
if(file_exists($Nom_archivo))
	unlink($Nom_archivo);
*/
if($Quincena>'0')
	$add_SQL = " $Quincena";
else
	$add_SQL = ' ';
	

do { // para cada empleado
	
	$sql = "SELECT * FROM Empleado_Pago 
			WHERE Codigo_Empleado = '".$row_RS_Empleados['CodigoEmpleado']."' 
			AND Codigo_Quincena LIKE '%$Ano $Mes$add_SQL%'  
			AND Concepto LIKE '%ivss%' ";
			//echo $sql;
	$Result = mysql_query($sql, $bd) or die(mysql_error());
	$row_Result = mysql_fetch_assoc($Result);
	$totalRows_Result = mysql_num_rows($Result);
	$MontoMes=0;
	
	if(	$totalRows_Result > 0 ) {
		extract($row_RS_Empleados);
		$SueldoBaseMes=0;
		if($totalRows_Result>0){
			do{
				$MontoMes -= $row_Result['Monto'];	
			} while ($row_Result = mysql_fetch_assoc($Result)); }
		
		$MontoMes = round($MontoMes,2);

		if($MontoMes>0){
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(8,$linea, ++$No ,1,0,'R');
				$pdf->Cell(20,$linea, Fnum_dec($Cedula) ,1,0,'R');
				$pdf->Cell(50,$linea, $Apellidos.', '. $Nombres ,1,0,'L');
				$pdf->Cell(17,$linea, $CargoCorto ,'TBL',0,'L');
				$Horas_desplegar = '';
				if($Horas>0){ 
					$Horas_desplegar = '('.$Horas.')';}
				$pdf->SetFont('Arial','',9);
				$pdf->Cell( 5,$linea,  $Horas_desplegar ,'TBR',0,'R');
				
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(18,$linea, Fnum($MontoMes) ,1,0,'R');
				$pdf->Cell(18,$linea, Fnum($MontoMes*2) ,1,0,'R');
				$pdf->Cell(18,$linea, Fnum($MontoMes*3) ,1,0,'R');
				
				$pdf->Ln($linea);
				$MontoTotalMes += $MontoMes*3;
		}
	}
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(200, 10, 'Total: '.Fnum($MontoTotalMes),0,1,'R');

	/*$pdf->SetFont('Arial','',10);
	$pdf->Cell(200, 5, 'MontoFideicomiso = SueldoIntDia * 5',0,1,'L');
	$pdf->Cell(200, 5, 'SueldoIntDia = ( SueldoDiario * 30 * 14 + MontoBonoVac ) / 365',0,1,'L');
	$pdf->Cell(200, 5, 'MontoBonoVac = SueldoDiario * ( 6 + AñosLaborados )',0,1,'L');
	$pdf->Cell(200, 5, 'AñosLaborados max 15',0,1,'L');
*/


// Archivo Fideicomiso	
//file_put_contents($Nom_archivo , $txt );	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>
