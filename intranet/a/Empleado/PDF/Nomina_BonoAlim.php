<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once('../../../../inc/fpdf.php');



if(!isset($_GET['CodigoEmpleado'])){
	$sql_Pago_Extra = "UPDATE Empleado 
						SET Pago_extra2 = ''";
	$mysqli->query($sql_Pago_Extra); //mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());
}	

$Mes = $_GET['Mes'];
$Ano = $_GET['Ano'];
$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';

$Nom_archivo = '../archivo/BonoAlim/Bono_'.$Ano.'_'.$Mes.'.csv';

if(file_exists($Nom_archivo))
	unlink($Nom_archivo);



class PDF extends FPDF
{
//Cabecera de página
function Header()
{
	require('../../archivo/Variables.php');
	
	$linea=5;
	$this->Ln(10);
	
	$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 16);
	$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
	
	$Mes = $_GET['Mes'];
	$Ano = $_GET['Ano'];
	
	$this->SetFont('Times','B',14);
	$this->Cell(250,$linea, 'BONO ALIMENTACIÓN' ,0,1,'R'); 
	
	$titulo = 'correspondiente al mes de '. Mes( $Mes) .' de '.$Ano;
	$this->SetFont('Times','B',12);
	$this->Cell(250,$linea, $titulo ,0,1,'R'); 
	
	$this->SetFont('Times','',10);
	$this->Cell(250,$linea, 'Bonificación en base a la U.T. de Bs.'.$UnidadTributaria.' decretada en la Gaceta Ofici. No.'.$GacetaNumUnidadTributaria.' de Fecha '.$GacetaFechaUnidadTributaria ." ( CT/Día = Bs." . Fnum(round( $UnidadTributaria * $CT_PorcentajeDia/100 , 2)) . " )" ,0,0,'R'); 
	
		
	$this->Ln(7);
	$linea=6;
	
	$this->SetFont('Arial','',10);	
	$this->Cell(7,$linea, "No." ,1,0,'C');
	$this->Cell(20,$linea,'Cédula',1,0,'C');
	$this->Cell(45,$linea,'Apellidos y Nombre',1,0,'L');
	$this->Cell(22,$linea,'Cargo (hr)',1,0,'C');
	$this->Cell(12,$linea,'D/Sem',1,0,'C');
	$this->Cell(12,$linea,'Inas.',1,0,'C');
	$this->Cell(20,$linea,'Desc Días',1,0,'C'); //Observaciones
	$this->Cell(12,$linea,'D/Pag',1,0,'C');
	$this->Cell(25,$linea,'Tot Bono',1,0,'C');
	$this->Cell(25,$linea,'Horario',1,0,'C');
	$this->Cell(48,$linea,'Firma',1,1,'C');

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


$linea = 5.6;
$tipologia = 'Arial';

$pdf=new PDF('L', 'mm', 'Letter');
$pdf->SetMargins(10,0,10);
$pdf->SetFillColor(255);

$pdf->SetFont('Arial','',10);
 
//mysql_select_db($database_bd, $bd);
$br=false;

$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_cestaT='1' AND
						(SW_activo = '1' OR
								(FechaEgreso <= '".date('Y')."-$Mes-31' 
							AND FechaEgreso >= '".date('Y')."-$Mes-1'))
						ORDER BY PaginaCT, Apellidos, Nombres ASC";
						//echo $query_RS_Empleados;


$RS_Empleados = $mysqli->query($query_RS_Empleados); //
$row_RS_Empleados = $RS_Empleados->fetch_assoc();
$totalRows_RS_Empleados = $RS_Empleados->num_rows;
/*
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);
*/

$PaginaCTanterior = 0;
$SubTotGen = 0;
do { 
	if( $PaginaCTanterior != $row_RS_Empleados['PaginaCT'] )
		$pdf->AddPage();
	
	$No++;
	$Codigo_Empleado = $row_RS_Empleados['CodigoEmpleado'];
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(7,$linea, ++$NumLinea ,1,0,'R');
	$pdf->Cell(20,$linea, Fnum_dec($row_RS_Empleados['Cedula']) ,1,0,'R',1);
	$pdf->Cell(45,$linea, $row_RS_Empleados['Apellidos'].', '. $row_RS_Empleados['Nombres'] ,1,0,'L',1);
	
	
	$pdf->Cell(17,$linea,  $row_RS_Empleados['CargoCorto'] ,'TBL',0,'L',1);
	$Horas = '';
	if($row_RS_Empleados['Horas'] > 0){ $Horas = ''; }
	$pdf->SetFont('Arial','',9);
	$pdf->Cell( 5,$linea,  $Horas ,'TBR',0,'R');
	$pdf->SetFont('Arial','',10);
	
	
	$DiasSemana  = "";
	$DiasSemana .= $row_RS_Empleados['SW_Lun']==1?1:"";
	$DiasSemana .= $row_RS_Empleados['SW_Mar']==1?2:"";
	$DiasSemana .= $row_RS_Empleados['SW_Mie']==1?3:"";
	$DiasSemana .= $row_RS_Empleados['SW_Jue']==1?4:"";
	$DiasSemana .= $row_RS_Empleados['SW_Vie']==1?5:"";
	$DiasSemana .= $row_RS_Empleados['SW_Sab']==1?6:"";
	$DiasSemana .= $row_RS_Empleados['SW_Dom']==1?7:"";
	
	
	
	if($row_RS_Empleados['CestaTiketPorcentaje'] > 0)
		$CestaT_PorcentajeDia = $row_RS_Empleados['CestaTiketPorcentaje'];
	else
		$CestaT_PorcentajeDia = $CT_PorcentajeDia;	
		
	$DiasXSemana = strlen($DiasSemana);
	$DiasInasistencia = $row_RS_Empleados['DiasInasistencia'];
	
	$CestaTicket_Adicional = $row_RS_Empleados['SW_cestaT_Adicional']*$CT_BonoAdicional*$DiasXSemana/5;
	if($DiasInasistencia > 0 and $CestaTicket_Adicional > 0)
		$CestaTicket_Adicional = $CestaTicket_Adicional * (21-$DiasInasistencia)/21;
	
	$DiasXDescontar = round($DiasInasistencia * 1.4 , 2);
	$DiasXPagar = ( $DiasXSemana * 1.4 ) / 7 * $CT_DiasMes - $DiasXDescontar;
	
	
	//$MontoCestaT = round( $UnidadTributaria * $CestaT_PorcentajeDia/100 , 2);
	
	$MontoCestaT =  $CT_Mensual / 30 ;
	$TotBono = round($DiasXPagar * $MontoCestaT + $row_RS_Empleados['BonifAdicCT'] + $CestaTicket_Adicional,2);
	
	
	$Obs = $DiasXSemana.'/sem ';
	if($DiasXDescontar > 0)
		$Obs .= "Ina: ".$DiasXDescontar;
		
	$SubTotGen += $TotBono;
	
	

	if($DiasInasistencia == 0) $DiasInasistencia = "";
	if($DiasXDescontar == 0) $DiasXDescontar = "";

	$pdf->Cell(12,$linea, $DiasXSemana ,1,0,'C',1);
	$pdf->Cell(12,$linea, $DiasInasistencia ,1,0,'C',1);
	$pdf->Cell(20,$linea, $row_RS_Empleados['ObservacionesCestaT'].$DiasXDescontar ,1,0,'C',1);
	$pdf->Cell(12,$linea, $DiasXPagar ,1,0,'C');
	$pdf->Cell(25,$linea, Fnum($TotBono) ,1,0,'R',1);
	
	$pdf->SetFont('Arial','',9);
	if($DiasSemana == '12345') $DiasSemana = 'Lun-Vie';
	if($DiasSemana == '123456') $DiasSemana = 'Lun-Sáb';
	  
	if($DiasSemana != '12345' and $DiasSemana != '123456'){
		  //$DiasSemana = $row_RS_Empleados['DiasSemana'];
		  $DiasSemana = str_replace('1','Lu ',$DiasSemana);
		  $DiasSemana = str_replace('2','Ma ',$DiasSemana);
		  $DiasSemana = str_replace('3','Mi ',$DiasSemana);
		  $DiasSemana = str_replace('4','Ju ',$DiasSemana);
		  $DiasSemana = str_replace('5','Vi ',$DiasSemana);
		  $DiasSemana = str_replace('6','Sa ',$DiasSemana); }
		  
	$pdf->Cell(25,$linea, $DiasSemana ,1,0,'C');
	$pdf->SetFont('Arial','',10);
	
	
	if (	$row_RS_Empleados['FechaEgreso']<= date('Y')."-$Mes-31" and 
		$row_RS_Empleados['FechaEgreso']>= date('Y')."-$Mes-1"  )
		$add_Obs = "Egreso: ".DDMMAAAA($row_RS_Empleados['FechaEgreso']);
	else
		$add_Obs = "";	

	$pdf->Cell(48,$linea, ''.$add_Obs ,1,1,'R');
	
	$PagAnterior = $row_RS_Empleados['Pagina'];  
	$PaginaCTanterior = $row_RS_Empleados['PaginaCT'];

/*
	$sql = "DELETE FROM Empleado_BonoAlimentacion
			WHERE Codigo_Empleado = '$Codigo_Empleado'
			AND Ano = '$Ano'
			AND Mes = '$Mes'
			AND Descripcion = 'Total'";
	$mysqli->query($sql);
	
	$sql = "INSERT INTO Empleado_BonoAlimentacion
			(Codigo_Empleado, Ano, Mes, Descripcion, Monto) 
			VALUES
			('$Codigo_Empleado', '$Ano', '$Mes', 'Total', '$TotBono') ";
	$mysqli->query($sql);
*/	
	
	
	$sql = "DELETE FROM Empleado_Pago
			WHERE Codigo_Empleado = '$Codigo_Empleado'
			AND Codigo_Quincena = '$Ano $Mes CT'
			AND Concepto = '+Cesta Ticket'";
	$mysqli->query($sql);
	//echo $sql."<br>";
	
	$sql = "INSERT INTO Empleado_Pago
			(Codigo_Empleado, Codigo_Quincena, Concepto, Obs, Monto, Registro_por) 
			VALUES
			('$Codigo_Empleado', '$Ano $Mes CT', '+Cesta Ticket', '$Obs', '$TotBono','$MM_Username') ";
	$mysqli->query($sql);
	//echo $sql."<br>";
	
	$Pago_extra = round($TotBono , 2);
	$sql_Pago_Extra = "UPDATE Empleado 
						 SET Pago_extra2 = '$Pago_extra'
						 WHERE CodigoEmpleado = '$Codigo_Empleado'";
	$mysqli->query($sql_Pago_Extra); // mysql_query($sql_Pago_Extra, $bd) or die(mysql_error());		
			

} while ($row_RS_Empleados = $RS_Empleados->fetch_assoc()); 


$pdf->SetFont('Arial','B',11);

$pdf->Ln();	  
$pdf->Cell(100);
$pdf->Cell(41,$linea, 'Sub Total' ,1,0,'L');
$pdf->Cell(30 ,$linea, Fnum($SubTotGen) ,1,1,'R');

$pdf->Cell(100);
$pdf->Cell(41,$linea, 'Comisión 2,75%' ,1,0,'L');
$Comision = $SubTotGen*0.0275;
$pdf->Cell(30 ,$linea, Fnum($Comision) ,1,1,'R');

$pdf->Cell(100);
$pdf->Cell(41,$linea, 'IVA 12%' ,1,0,'L');
$IVA_Comision = round($Comision*0.12 , 2);
$pdf->Cell(30 ,$linea, Fnum($IVA_Comision) ,1,1,'R');

$pdf->Cell(100);
$pdf->Cell(41,$linea, 'ISRL 2%' ,1,0,'L');
$IVA_Comision = round($Comision*0.12 , 2);
$pdf->Cell(30 ,$linea, '-'.Fnum($Comision*0.02) ,1,1,'R');

$pdf->Cell(100);
$pdf->Cell(41,$linea, 'Total' ,1,0,'L');
$Total = round( $Comision + $IVA_Comision + $SubTotGen -($Comision*0.02) ,2);
$pdf->Cell(30 ,$linea, Fnum($Total) ,1,1,'R');

$pdf->Ln(15);	  
$pdf->Cell(150,$linea, 'Cheque a nombre de: TEBCA Transferencia Electrónica de Beneficios, C.A.' ,0,1,'L');


$pdf->Output();



//mysql_free_result($RS_Empleados);
?>