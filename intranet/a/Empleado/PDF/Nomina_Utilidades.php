<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');

// Fideicomiso trimestral


if(!isset($_GET['AnoMes'])){
	$AnoMes = date('Y') . '12';
	header("Location: ".$_SERVER['PHP_SELF']."?Quincena=0&AnoMes=".$AnoMes);
	}


$Quincena = substr(1,0,1);


$AnoMes = $_GET['AnoMes'];
$Mes = substr($_GET['AnoMes'],4,2);
$Ano = substr($_GET['AnoMes'],0,4);
$FechaObjAntiguedad = $Ano ." 12 31";



class PDF extends FPDF
{
	//Cabecera de página
	function Header() {

		$Mes = substr($_GET['AnoMes'],4,2);
		$Ano = substr($_GET['AnoMes'],0,4);
		$Quincena = substr($_GET['Quincena'],0,1);
	
	
		$titulo = 'correspondiente al Año '.$Ano;

		$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$linea=5;
		$this->Ln(5);
	
		$this->SetFont('Times','B',14);
		$this->Cell(200,$linea, 'NÓMINA DE UTILIDADES' ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		$this->Cell(200,$linea, $titulo ,0,1,'R'); 
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(8,$linea,'No',1,0,'C');
		$this->Cell(8,$linea,'Cod',1,0,'C');
		$this->Cell(20,$linea,'Cédula',1,0,'C');
		$this->Cell(44,$linea,'Apellidos y Nombre',1,0,'L');
		//$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
		$this->Cell(30,$linea,'F. Ingreso',1,0,'L');
		//$this->Cell(18,$linea,'S. Base',1,0,'C');
		$this->SetFont('Arial','',10);
		//$this->Cell(18,$linea,'S.Int/Día',1,0,'C');
		$this->Cell(24,$linea,'S.Base Q.',1,0,'C');
		$this->Cell(24,$linea,'S.Base M.',1,0,'C');
		$this->Cell(15,$linea,'x Ds',1,0,'C');
		$this->Cell(24,$linea,'Total',1,0,'C');
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
						WHERE SW_Antiguedad = 1 
						AND SW_activo = 1 
						ORDER BY Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$sql='';
do { // para cada empleado
		extract($row_RS_Empleados);

		$sql_Sueldo = "SELECT * FROM Empleado
					   WHERE CodigoEmpleado = '$CodigoEmpleado'";
		$RS_Sueldo = $mysqli->query($sql_Sueldo);
		$row_Sueldo = $RS_Sueldo->fetch_assoc();
		$SueldoBase = $row_Sueldo['SueldoBase'];
		$SueldoDiario = round($SueldoBase/15,2);
		
		$AnosLaborados  = Fecha_Meses_Laborados($row_RS_Empleados['FechaIngreso'] , $FechaObjAntiguedad);
		if($AnosLaborados > 1) {
			$FactorBaseBono = 1;}
		else
			$FactorBaseBono = $AnosLaborados; 
			
		$DiasBono = $FactorBaseBono * 30; // hasta 15+15
		//echo $DiasBono."<br>";
		$MontoBono = round($DiasBono * $SueldoDiario , 2);
		
		//echo $MontoBono."<br>";
		
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(8,$linea, ++$No ,1,0,'R');
		$pdf->Cell(8,$linea, $CodigoEmpleado ,1,0,'R');
		$pdf->Cell(20,$linea, Fnum_dec($Cedula) ,1,0,'R');
		$pdf->Cell(44,$linea, $Apellidos.', '. $Nombres ,1,0,'L');
		//$pdf->Cell(13,$linea, $CargoCorto ,'TBL',0,'L',1);
		$Horas_desplegar = '';
		if($Horas > 0){ 
			$Horas_desplegar = '('.$Horas.')';
			$Fondo = 1;} else {$Fondo = 0;}
		$pdf->SetFont('Arial','',9);
		//$pdf->Cell( 9 ,$linea,  $Horas_desplegar ,'TBR',0,'R',$Fondo);
		
		$pdf->Cell(18,$linea, DDMMAAAA($FechaIngreso) ,'TBL',0,'L',1);
		$pdf->Cell(12 ,$linea, ''. $AnosLaborados.'a','TBR',0,'R');
		
		$pdf->SetFont('Arial','',10);

		$pdf->Cell(24,$linea, Format($SueldoBase) ,1,0,'R');
		$pdf->Cell(24,$linea, Format($SueldoBase*2) ,1,0,'R');
		
		if($DiasBono == 30)
			$Factor='';
		else
			$Factor = $DiasBono;
		$pdf->Cell(15,$linea, $Factor ." " ,1,0,'R');
		
		$pdf->Cell(24,$linea, Format($MontoBono) ,1,0,'R');
		
		$pdf->Ln($linea);

		$TotMontoBono += $MontoBono;
		
		$sqlINSERT .= "('".$CodigoEmpleado."', '$Ano $Mes', '$Ano $Mes', '+Utilidades', '$MontoBono'),";
	
		$sql_Pago_Extra = "UPDATE Empleado 
							SET Pago_extra = '$MontoBono'
							WHERE CodigoEmpleado = '$CodigoEmpleado'";
	    mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());				
	
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 


if($Mes=='12'){
	$sqldelete = "DELETE FROM Empleado_Pago WHERE Codigo_Quincena='$Ano $Mes' AND Concepto='+Utilidades'"; 
	//echo $sqldelete."<br>";
	$RS = mysql_query($sqldelete, $bd) or die(mysql_error());
	
	$sqlINSERT = "INSERT INTO Empleado_Pago 
			(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto) VALUES ".$sqlINSERT;
	$sqlINSERT = substr($sqlINSERT , 0 , strlen($sqlINSERT)-1);
	//echo $sqlINSERT."<br>";
	
	$RSINSERT = mysql_query($sqlINSERT, $bd) or die(mysql_error());

	//$txt = substr($txt,0,strlen($txt)-1);
	//file_put_contents($Nom_archivo , $txt );	
}
	
	$pdf->SetFont('Arial','',14);
	$pdf->Cell(195, 10, 'Total: '.Fnum($TotMontoBono),0,1,'R');

	$pdf->SetFont('Arial','',10);
	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>
