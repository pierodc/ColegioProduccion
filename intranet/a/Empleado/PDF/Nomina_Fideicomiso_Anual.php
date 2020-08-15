<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once('../../../../inc_login_ck.php'); 
require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php'); 
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php');

// Fideicomiso Anual

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


//$Quincena = 'a';
//$Mes = '07';
$Ano = $GET['Ano'];
//$FechaObjAntiguedad = $Ano.'-09-30'; //Para calculo de antiguedad


class PDF extends FPDF
{
	//Cabecera de página
	function Header() {

		$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 16);
		$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		
		$linea=5;
		$this->Ln(5);
	
	
	
                $Ano2 = $GET['Ano'];
                $Ano1 = $Ano1-1;
		
		$this->SetFont('Times','B',14);
		$this->Cell(200,$linea, "NÓMINA DE FIDEICOMISO ANUAL 2017-2018" ,0,1,'R'); 
		$this->SetFont('Times','B',12);
		
		$this->Ln(5);
		$linea=6;
		
		$this->SetFont('Arial','',10);	
		$this->Cell(8,$linea,'No',1,0,'C');
		$this->Cell(8,$linea,'Cod',1,0,'C');
		$this->Cell(20,$linea,'Cédula',1,0,'C');
		$this->Cell(40,$linea,'Apellidos y Nombre',1,0,'L');
		$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
		$this->Cell(26,$linea,'F. Ingreso',1,0,'L');
		//$this->Cell(18,$linea,'S. Base',1,0,'C');
		$this->SetFont('Arial','',10);
		//$this->Cell(18,$linea,'S.Int/Día',1,0,'C');
		$this->Cell(23,$linea,'S. Quinc.',1,0,'C');
		$this->Cell(18,$linea,'Días',1,0,'C');
		$this->Cell(23,$linea,'Fideic',1,0,'C');
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


$linea = 5.9;
$tipologia = 'Arial';


$pdf=new PDF('P', 'mm', 'Letter');
$pdf->SetMargins(10,5,10);
$pdf->SetFillColor(255);
$pdf->AddPage();

$pdf->SetFont('Arial','',10);
 
//mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_Antiguedad = 1 
						AND SW_activo=1 
						ORDER BY Apellidos, Nombres  ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

//$Nom_archivo = '../../archivo/fideicomiso/Fideicom_'.$Ano.'_Anual.txt';
	
//if(file_exists($Nom_archivo))
//	unlink($Nom_archivo);

$TotMontoFideicomisoMes = 0;
	
do { // para cada empleado
	$MontoFideicomiso=0;
	$MontoSueldoMes=0;
	
	extract($row_RS_Empleados);
        
    $Ano = $_GET['Ano'];
	
	$sql_Sueldo = "SELECT * FROM Empleado_Pago
					WHERE Codigo_Empleado = '$CodigoEmpleado'
					AND Codigo_Quincena = '$Ano 07 2'
					AND Concepto = '+SueldoBase'";
	//echo $sql_Sueldo."<br>" ;				
	$RS_Sueldo = $mysqli->query($sql_Sueldo);
	$row_Sueldo = $RS_Sueldo->fetch_assoc();
	$SueldoBase = $row_Sueldo['Monto'];
	
	$SueldoBase = 900;
	
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(8,$linea, ++$No ,1,0,'R',1);
	$pdf->Cell(8,$linea, $CodigoEmpleado ,1,0,'R',1);
	$pdf->Cell(20,$linea, Fnum_dec($Cedula) ,1,0,'R',1);
	$pdf->Cell(40,$linea, $Apellidos.', '. $Nombres ,1,0,'L',1);
	
	$pdf->Cell(17,$linea, $CargoCorto ,'TBL',0,'L',1);
	$Horas_desplegar = '';
	if($Horas>0){ 
		$Horas_desplegar = '('.$Horas.')';}
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 5,$linea,  $Horas_desplegar ,'TBR',0,'R',0);
	
	
	$SueldoIntDia = SueldoIntDia($FechaIngreso , $FechaObjAntiguedad , $SueldoBase);
		
	$AnosLaborados = Fecha_Meses_Laborados($FechaIngreso,$FechaObjAntiguedad); 
	
	$AnosLaborados =  floor($AnosLaborados);
	
	$DiasPagados = ($AnosLaborados-1)*2;
	if($DiasPagados<0)
		$DiasPagados=0;
	if($DiasPagados>30)
		$DiasPagados=30;
	
	
	// MONTO FIDEICOMISO
	$MontoFideicomiso = round($SueldoIntDia * $DiasPagados,2);

	$TotalDiasPagados += $DiasPagados;
	$TotalSumaSueldos += $SueldoBase;
	
	
	$Monto = substr('000000000000'.$MontoFideicomiso*100 , -14);
	if($MontoFideicomiso>0)
$txt .= '01'.date('dmY').'1059876'.$CedulaLetra. substr('0000000000'.$Cedula,-9).$Monto.'
';
	
	
	$pdf->Cell(18,$linea, DDMMAAAA($FechaIngreso) ,'TBL',0,'L',1);
	$pdf->Cell(8 ,$linea, ''. $AnosLaborados.'a','TBR',0,'R',1);
	
	$pdf->SetFont('Arial','',10);

	$pdf->Cell(23,$linea, Format($SueldoBase) ,1,0,'R');
	

	$pdf->Cell(18,$linea, $DiasPagados ,1,0,'C');
	$pdf->Cell(23,$linea, Format($MontoFideicomiso) ,1,0,'R');
	$TotMontoFideicomisoMes += $MontoFideicomiso;
	//$pdf->Cell(18,$linea, Format($TotMontoFideicomisoMes) ,1,0,'R');
	
	$pdf->Ln($linea);
	
	$sqlINSERT .= "('".$CodigoEmpleado."', '$Ano 09 5', '$Ano 09 5', '+Fideicomiso Anual', '$MontoFideicomiso'),";
	
} while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); 
	
$pdf->Ln($linea);

$pdf->SetFont('Arial','',14);
$pdf->Cell(190, 10, 'Total: '.Fnum($TotMontoFideicomisoMes),0,1,'R',1);

$pdf->SetFont('Arial','',10);
$pdf->Cell(200, 5, ' Quincena Observada: 2da de Julio '.$Ano  ,0,1,'L',1);
$pdf->Cell(200, 5, ' Fecha Objetivo Antiguedad '. DDMMAAAA($FechaObjAntiguedad),0,1,'L',1);
$pdf->Cell(200, 5, ' Promedio Dias Pagados: '. round($TotalDiasPagados/$No,2)  ,0,1,'L',1);
$pdf->Cell(200, 5, ' Total Dias Pagados: '. round($TotalDiasPagados,2)  ,0,1,'L',1);


if(true){
	$sqldelete = "DELETE FROM Empleado_Pago WHERE Codigo_Quincena='$Ano 09 5' AND Concepto='+Fideicomiso Anual'"; 
	$RS = mysql_query($sqldelete, $bd) or die(mysql_error());
	
	$sqlINSERT = "INSERT INTO Empleado_Pago 
			(Codigo_Empleado, Codigo_Quincena, Codigo_Fecha_Ejecutado, Concepto, Monto) VALUES ".$sqlINSERT;
			
	$sqlINSERT = substr($sqlINSERT , 0 , strlen($sqlINSERT)-1);
	
	//echo $sqlINSERT ;
	
	// Crear codigo para registrar transaccion
	$RSINSERT = mysql_query($sqlINSERT, $bd) or die(mysql_error());
	
}



//$SueldoIntDia = round( ($SueldoDiario*15*2*14 + $MontoBono)/365 ,2);

// Archivo Fideicomiso	
//file_put_contents( $Nom_archivo , $txt );	

$pdf->Output();
mysql_free_result($RS_Empleados);
?>