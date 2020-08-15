<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');

// Fideicomiso trimestral


if(!isset($_GET['AnoMes'])){

	$Mes = date('m');
	//$Mes = "03";
	
	if($Mes == '03' or $Mes == '04' or $Mes == '05'){
		$AnoMes = date('Y') . '03';
		}
	if($Mes == '06' or $Mes == '07' or $Mes == '08'){
		$AnoMes = date('Y') . '06';
		}
	if($Mes == '09' or $Mes == '10' or $Mes == '11'){
		$AnoMes = date('Y') . '09';
		}
	if($Mes == '12' or $Mes == '01' or $Mes == '02'){
		$AnoMes = date('Y') . '12';
		}
		
		

	header("Location: ".$_SERVER['PHP_SELF']."?Quincena=0&AnoMes=".$AnoMes);
	}



//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


$Quincena = substr($_GET['Quincena'],0,1);



$AnoMes = $_GET['AnoMes'];
$Mes = substr($_GET['AnoMes'],4,2);
$Ano = substr($_GET['AnoMes'],0,4);

if($Mes == '03'){
	$Codigo_Quincena_Obj = $Ano . ' 02 2';
	$FechaFinTrimestre = $Ano . '-02-30'; //Fecha Fin Trimestre
}

if($Mes == '06'){
	$Codigo_Quincena_Obj = $Ano . ' 05 2';
	$FechaFinTrimestre = $Ano . '-05-30'; //Fecha Fin Trimestre
}

if($Mes == '09'){
	$Codigo_Quincena_Obj = $Ano . ' 07 2';
	$FechaFinTrimestre = $Ano . '-08-30'; //Fecha Fin Trimestre
}

if($Mes == '12'){
	$Codigo_Quincena_Obj = $Ano . ' 11 2';
	$FechaFinTrimestre = $Ano . '-11-30'; //Fecha Fin Trimestre
}




//echo $Codigo_Quincena_Obj;

class PDF extends FPDF
{
	//Cabecera de página
	function Header() {

		$Mes = substr($_GET['AnoMes'],4,2);
		$Ano = substr($_GET['AnoMes'],0,4);
		$Quincena = substr($_GET['Quincena'],0,1);
	
		if($Mes == '03')
			$titulo = 'correspondiente al trimestre '.Mes('12').'-'.Mes('01').'-'.Mes('02').' de '.$Ano;

		if($Mes == '06')
			$titulo = 'correspondiente al trimestre '.Mes('03').'-'.Mes('04').'-'.Mes('05').' de '.$Ano;

		if($Mes == '09')
			$titulo = 'correspondiente al trimestre '.Mes('06').'-'.Mes('07').'-'.Mes('08').' de '.$Ano;
	
		if($Mes == '12')
			$titulo = 'correspondiente al trimestre '.Mes('09').'-'.Mes('10').'-'.Mes('11').' de '.$Ano;
	
		$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$linea=5;
		$this->Ln(5);
	
		$this->SetFont('Times','B',14);
		$this->Cell(200,$linea, 'NÓMINA DE FIDEICOMISO' ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		$this->Cell(200,$linea, $titulo ,0,1,'R'); 
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(8,$linea,'No',1,0,'C');
		$this->Cell(8,$linea,'Cod',1,0,'C');
		$this->Cell(20,$linea,'Cédula',1,0,'C');
		$this->Cell(44,$linea,'Apellidos y Nombre',1,0,'L');
		$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
		$this->Cell(26,$linea,'F. Ingreso',1,0,'L');
		//$this->Cell(18,$linea,'S. Base',1,0,'C');
		$this->SetFont('Arial','',10);
		//$this->Cell(18,$linea,'S.Int/Día',1,0,'C');
		$this->Cell(20,$linea,'S. Quinc.',1,0,'C');
		$this->Cell(20,$linea,'S.Int.Dia.',1,0,'C');
		$this->Cell(8,$linea,'x Ds',1,0,'C');
		$this->Cell(20,$linea,'Fideic',1,0,'C');
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
		$this->Cell(0,5, 'Fecha: '.date('d-m-Y'),0,0,'L');
		$this->Cell(0,5, 'Pág. '.$this->PageNo(),0,0,'R');
		
	}
}



$linea = 5.9;
$tipologia = 'Arial';


$pdf=new PDF('P', 'mm', 'Letter');
$pdf->SetFillColor(255);
$pdf->SetMargins(10,5,10);

$pdf->AddPage();

$pdf->SetFont('Arial','',10);
 
mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_Antiguedad=1 
						AND SW_activo=1 
						ORDER BY Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);


//$Nom_archivo = '../../archivo/Fideicom_'.$Ano .'_'. $Mes.'.txt';

//$Nom_archivo = str_replace('-','_',$Nom_archivo);

//if(file_exists($Nom_archivo))
//	unlink($Nom_archivo);

$sql='';
do { // para cada empleado
		extract($row_RS_Empleados);

		$sql_Sueldo = "SELECT * FROM Empleado_Pago
			       WHERE Codigo_Empleado = '$CodigoEmpleado'
			       AND Codigo_Quincena = '$Codigo_Quincena_Obj'
			       AND Concepto = '+SueldoBase'";
		$RS_Sueldo = $mysqli->query($sql_Sueldo);
		$row_Sueldo = $RS_Sueldo->fetch_assoc();
		$SueldoBase = $row_Sueldo['Monto'];

		$MesesLaborados = Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'] , $FechaFinTrimestre)*12; 
		if($MesesLaborados>3)
			$Factor = 15;
		else
			$Factor = round($MesesLaborados * 5 , 2);
	
		
		$AnosLaborados  = Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'] , $FechaObjAntiguedad);
		
		if($AnosLaborados < 1) {
			$FactorBaseBono = $AnosLaborados; 
			$AnosLaborados = 0;}
	
		elseif($AnosLaborados <= 15) {
			$AnosLaborados =  floor($AnosLaborados);
			$FactorBaseBono = 1;}
			
		elseif($AnosLaborados > 15) {
			$AnosLaborados =  15;
			$FactorBaseBono = 1;}
			
		
		//$SueldoBase = 900;
		
		$SueldoDiario = round($SueldoBase/15 , 2);
		$DiasBono = $FactorBaseBono * 15 + $AnosLaborados ; // hasta 15+15
		$MontoBono = round($DiasBono * $SueldoDiario , 2);
		$SueldoIntDia = round( ($SueldoDiario * 30 * 14 + $MontoBono) / 360 , 2 ); // 14 meses
		
		$MontoFideicomiso = round($SueldoIntDia * $Factor , 2);
		if ($MontoFideicomiso < 0)
			$MontoFideicomiso = 0;

		$pdf->SetFont('Arial','',10);
		$pdf->Cell(8,$linea, ++$No ,1,0,'R');
		$pdf->Cell(8,$linea, $CodigoEmpleado ,1,0,'R');
		$pdf->Cell(20,$linea, Fnum_dec($Cedula) ,1,0,'R');
		$pdf->Cell(44,$linea, $Apellidos.', '. $Nombres ,1,0,'L');
		$pdf->Cell(13,$linea, $CargoCorto ,'TBL',0,'L',1);
		$Horas_desplegar = '';
		if($Horas > 0){ 
			$Horas_desplegar = '('.$Horas.')';
			$Fondo = 1;} else {$Fondo = 0;}
		$pdf->SetFont('Arial','',9);
		$pdf->Cell( 9 ,$linea,  $Horas_desplegar ,'TBR',0,'R',$Fondo);
		
		$pdf->Cell(18,$linea, DDMMAAAA($FechaIngreso) ,'TBL',0,'L',1);
		$pdf->Cell(8 ,$linea, ''. $AnosLaborados.'a','TBR',0,'R');
		
		$pdf->SetFont('Arial','',9);

		$pdf->Cell(20,$linea, Format($SueldoBase) ,1,0,'R');
		$pdf->Cell(20,$linea, Format($SueldoIntDia) ,1,0,'R');
		
		if($Factor==15)
			$Factor='';
		$pdf->Cell(8,$linea, $Factor ,1,0,'R');
		
		$pdf->Cell(20,$linea, Format($MontoFideicomiso) ,1,0,'R');
		
		$pdf->Ln($linea);

		$TotMontoFideicomisoMes += $MontoFideicomiso;
		
		$Monto = substr('000000000000'.$MontoFideicomiso*100 , -14);
		if($MontoFideicomiso>0)
			$txt .= '01'.date('dmY').'1059876'.$CedulaLetra. substr('0000000000'.$Cedula,-9).$Monto.'
';
		
		$sqlINSERT .= "('".$CodigoEmpleado."', '$Ano $Mes', '$Ano $Mes', '+Fideicomiso', '$MontoFideicomiso'),";
	
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 


if($Mes=='03' or $Mes=='06' or $Mes=='09' or $Mes=='12'){
	$sqldelete = "DELETE FROM Empleado_Pago 
				  WHERE Codigo_Quincena='$Ano $Mes' 
				  AND Concepto='+Fideicomiso'"; 
	$RS = mysql_query($sqldelete, $bd) or die(mysql_error());
	
	$sqlINSERT = "INSERT INTO Empleado_Pago 
					(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto) 
					VALUES ".$sqlINSERT;
	$sqlINSERT = substr($sqlINSERT , 0 , strlen($sqlINSERT)-1);
	$RSINSERT = mysql_query($sqlINSERT, $bd) or die(mysql_error());

	//$txt = substr($txt,0,strlen($txt)-1);
	//file_put_contents($Nom_archivo , $txt );	
}
	
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(195, 10, 'Total: '.Fnum($TotMontoFideicomisoMes),0,1,'R');

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(200, 5, 'MontoFideicomiso = SueldoIntDia * 5',0,1,'L');
	$pdf->Cell(200, 5, 'SueldoIntDia = ( SueldoDiario * 30 * 14 + MontoBonoVac ) / 360',0,1,'L');
	$pdf->Cell(200, 5, 'MontoBonoVac = SueldoDiario * ( 15 + AñosLaborados )'.' FechaObj '.DDMMAAAA($FechaObjAntiguedad),0,1,'L');
	$pdf->Cell(200, 5, 'Años Laborados max 15',0,1,'L');
	$pdf->Cell(200, 5, 'Fecha Obj Trimestre '.DDMMAAAA($FechaFinTrimestre),0,1,'L');
	$pdf->Cell(200, 5, 'Quincena Objetivo '.$Codigo_Quincena_Obj,0,1,'L');


$pdf->Output();
mysql_free_result($RS_Empleados);
?>
