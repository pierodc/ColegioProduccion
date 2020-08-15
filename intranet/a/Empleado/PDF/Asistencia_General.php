<?php 
require_once('../../../../Connections/bd.php');
require_once('../../../../inc/rutinas.php'); 
require_once('../../../../inc/fpdf.php'); 


class PDF extends FPDF
{
	//Cabecera de página
	function Header() {
		$Ln = 4;
		$FechaInicio  = $_GET['Inicio'].'-01';
		$DDMMAAAA_Inicio = DiaN($FechaInicio).'-'.MesN($FechaInicio).'-'.AnoN($FechaInicio);
		$DiasDelMes = date('t' , strtotime($DDMMAAAA_Inicio));
		$DiaSemanaInicio  = date('w' , strtotime($DDMMAAAA_Inicio));
		$aux_DiaSemanaInicio = $DiaSemanaInicio;
		$Mes = Mes(date('m' , strtotime($DDMMAAAA_Inicio)));
		$Ano = Mes(date('Y' , strtotime($DDMMAAAA_Inicio)));
		$this->SetFont('Arial','B',18);
		$this->Cell(330 , 8 , 'Asistencia '.$Mes. ' '.$Ano , 0 , 1 , 'R'); 

		$this->Image('../../../../img/solcolegio.jpg', 10, 5, 0, 14);
		$this->Image('../../../../img/NombreCol.jpg' , 30, 5, 0, 12);
		$this->SetY( 20 );
		$this->SetFont('Arial','',10);
		
		$this->Cell(8 , $Ln*2 , 'No' , 1 , 0 , 'C'); 
		$this->Cell(8 , $Ln*2 , 'Cod' , 1 , 0 , 'C'); 
		$this->Cell(47 , $Ln*2 , 'Empleado' , 1 , 0 , 'L'); 
		for ($i = 1; $i <= $DiasDelMes; $i++) {
			$this->Cell(8.5 , $Ln , substr(DiaSemana($aux_DiaSemanaInicio++),0,2)  , 'LRT' , 0 , 'C'); 
			if($aux_DiaSemanaInicio==7) 
				$aux_DiaSemanaInicio=0;
			} 

		$this->Ln($Ln);
		$this->Cell(63);
		for ($i = 1; $i <= $DiasDelMes; $i++) {
			$this->Cell(8.5 , $Ln , $i , 'LR' , 0 , 'C'); 
			} 
		$this->Ln($Ln);
	}
	
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-10);
		//Arial italic 8
		//Número de página
		$this->Cell(0,5,'Aus: Ausente  /  Rep: Reposo  /  Asist: Asistió y no marcó  /  Amarillo: no marcó',0,0,'L');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,5,'Pág. '.$this->PageNo(),0,0,'R');
		
	}
}


mysql_select_db($database_bd, $bd);

// Asigna Dia de semana a la fecha
$sql = "SELECT * FROM Empleado_EntradaSalida WHERE DiasSemana IS NULL ";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);
$totalRows = mysql_num_rows($RS);
if($totalRows>0)
	do{
		extract($row);
		$Fecha = DiaN($Fecha).'-'.MesN($Fecha).'-'.AnoN($Fecha);
		$DiasSemana = date('w' , strtotime($Fecha));
		$sql_aux = "UPDATE Empleado_EntradaSalida 
					SET DiasSemana='$DiasSemana' 
					WHERE Codigo='$Codigo'";
		$RSaux = mysql_query($sql_aux, $bd) or die(mysql_error());
	} while ($row = mysql_fetch_assoc($RS));
// FIN Asigna Dia de semana a la fecha

$borde=1;
$Ln = 3.2;
$FechaInicio  = $_GET['Inicio'].'-01';
$DDMMAAAA_Inicio = DiaN($FechaInicio).'-'.MesN($FechaInicio).'-'.AnoN($FechaInicio);
$Mes = Mes(date('m' , strtotime($DDMMAAAA_Inicio)));

$mes_siguiente  = mktime(0, 0, 0, 
					date("m", strtotime($DDMMAAAA_Inicio))+1, 
					date("d",strtotime($DDMMAAAA_Inicio)),   
					date("Y",strtotime($DDMMAAAA_Inicio)));

$FechaFin     = date('Y-m-d' , $mes_siguiente);
$DiaSemanaInicio  = date('w' , strtotime($DDMMAAAA_Inicio));
$DiasDelMes = date('t' , strtotime($DDMMAAAA_Inicio));
$Mes = Mes(date('m' , strtotime($DDMMAAAA_Inicio)));


	mysql_select_db($database_bd, $bd);
	$query_RS_ = "SELECT * FROM Calendario WHERE Fecha >= '".$FechaInicio."' AND  Fecha < '".$FechaFin."'";
	//echo $query_RS_;
	$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
	$row_RS_ = mysql_fetch_assoc($RS_);
	do {
		if($row_RS_['Feriado']=='1')
			$Feriado[DiaN($row_RS_['Fecha'])*1]=1;
		if($row_RS_['NoLaboral']=='1')
			$NoLaboral[DiaN($row_RS_['Fecha'])*1]=1;
			
	} while($row_RS_ = mysql_fetch_assoc($RS_));



$pdf = new PDF('L', 'mm', 'Legal');  //array(279,432)
$pdf->SetFillColor(255,255,255);
//$pdf->AddPage();
$pdf->SetFont('Arial','',11);

$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
						SW_activo=1 AND 
						SW_Asistencia='1' 
						ORDER BY  PaginaCT, Apellidos, Nombres ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$aux_DiaSemanaInicio = $DiaSemanaInicio;

$pdf->SetFont('Arial','',8);

do{ // Para cada empleado
	if( $PaginaCTanterior != $row_RS_Empleados['PaginaCT'] )
		$pdf->AddPage();
	$Amarillo = false;
	extract($row_RS_Empleados);
	$sql = "SELECT * FROM Empleado_EntradaSalida WHERE 
			Codigo_Empleado = '$CodigoEmpleado' AND 
			Fecha >= '$FechaInicio' AND
			Fecha < '$FechaFin'
			ORDER BY Fecha, Hora";
	//eko ($sql);		
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);

	do{
		$j = DiaN($row['Fecha'])*1;
		if(!$HoraEntrada[$j]){
			$HoraEntrada[$j] 	= mktime( substr($row['Hora'],0,2) , substr($row['Hora'],3,2) ,0,0,0,0);
			$Obs[$j] = $row['Obs'];}
		if($DiaRegistroAnterior == $row['Fecha'])	
			$HoraSalida[$j] 	= mktime( substr($row['Hora'],0,2) , substr($row['Hora'],3,2) ,0,0,0,0);
		else
			$HoraSalida[$j] = '';
		
		
		$DiaRegistroAnterior = $row['Fecha'];
	} while ($row = mysql_fetch_assoc($RS)); 

	$pdf->SetFont('Arial','',10);
	$pdf->Cell(8 , $Ln*2 , ++$No , $borde , 0 , 'C'); 
	$pdf->Cell(8 , $Ln*2 , $CodigoEmpleado , $borde , 0 , 'C'); 
	$pdf->Cell(47 , $Ln*2 , $Apellidos.' '.$Nombres , $borde , 0 , 'L'); 
	$pdf->SetFont('Arial','',8);

	$aux_DiaSemanaInicio = $DiaSemanaInicio;
	
	// ENTRADAS
	for ($i = 1; $i <= $DiasDelMes; $i++) { 
	$Casilla='';
		if(substr_count( "$DiasSemana" , "$aux_DiaSemanaInicio")){
			if( $HoraEntrada[$i]>'1' ){
				if($HoraEntrada[$i]>0)
					$Casilla = date('G:i',$HoraEntrada[$i]);
				//if($HoraSalida[$i]>0)
					//$Casilla .= ' '.date('G:i',$HoraSalida[$i]);
				$pdf->SetFillColor(255);
				$pdf->SetFont('Arial','B',8);}
			else {
				$Casilla = '';
				$pdf->SetFillColor(255,255,200);
				//$Amarillo = true;
				 }
			
			if($HoraEntrada[$i]) {
				$HoraSuma+=$HoraEntrada[$i]; 
				$HoraCuenta+=1;}
		}else{
			$pdf->SetFillColor(235);
			$Casilla = '-   ';
			$pdf->SetFont('Arial','',8);}
		
		//echo " $i = ".date('j') .' '.MesN($FechaInicio) .' '. date('m');
		// or 
		if($Feriado[$i]==1 or $NoLaboral[$i]==1 or (MesN($FechaInicio) == date('m') and date('j') < $i)){
			$pdf->SetFillColor(255);
			}

		if(	$Obs[$i] > ''){
		$Casilla = $Obs[$i];
		}
		
		
		if($Casilla == 'Aus')
			$pdf->SetFillColor(255,100,100);
	
		$pdf->Cell(8.5 , $Ln , $Casilla , 'TLR', 0 , 'R' , 1);
		
		
		// FIN ENTRADAS
		
		
		
		$aux_DiaSemanaInicio++;
		if($aux_DiaSemanaInicio==7) 
			$aux_DiaSemanaInicio=0;
	} // END for
	
	if($HoraCuenta>0) 
		$Promedio = date('G:i',$HoraSuma/$HoraCuenta); else $Promedio='';
	$pdf->Cell(8.5 , $Ln , $Promedio , $borde , 0 , 'C'); 
	
	
	
		// SALIDAS
	$pdf->Ln($Ln);
	$aux_DiaSemanaInicio = $DiaSemanaInicio;
	$pdf->Cell(63);
	for ($i = 1; $i <= $DiasDelMes; $i++) { 
	$Casilla='';
		if(substr_count( "$DiasSemana" , "$aux_DiaSemanaInicio")){
			if( $HoraEntrada[$i]>'1'){
				//if($HoraEntrada[$i]>0)
					//$Casilla = date('G:i',$HoraEntrada[$i]);
				if($HoraSalida[$i]>0)
					$Casilla = ' '.date('G:i',$HoraSalida[$i]);
				$pdf->SetFillColor(255);
				$pdf->SetFont('Arial','B',8);}
			else {
				$Casilla = '';
				$pdf->SetFillColor(255,255,200);}
			
			if($HoraEntrada[$i]) {
				$HoraSuma+=$HoraEntrada[$i]; 
				$HoraCuenta+=1;}
		}else{
			$pdf->SetFillColor(235);
			$Casilla = '-   ';
			$pdf->SetFont('Arial','',8);}

		if($Feriado[$i]==1 or $NoLaboral[$i]==1  or (MesN($FechaInicio) == date('m') and date('j') < $i))
			$pdf->SetFillColor(255);
			


		
		$pdf->Cell(8.5 , $Ln , $Casilla , 'BLR', 0 , 'R' , 1);
		
		$aux_DiaSemanaInicio++;
		if($aux_DiaSemanaInicio==7) 
			$aux_DiaSemanaInicio=0;
		// FIN SALIDAS
	}

	
	
	
	$HoraSuma=0; $HoraCuenta=0;
	if($Amarillo == true){
		$pdf->SetX(10);
		$pdf->Cell(8.5 , $Ln , 'fff' , 'BLR', 0 , 'R' , 1);
	}
	$pdf->Ln($Ln);
	unset($HoraEntrada);
	unset($HoraSalida);
	unset($Obs);
	$PaginaCTanterior = $row_RS_Empleados['PaginaCT'];
} while($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));

	$sql = "SELECT * FROM Empleado_EntradaSalida WHERE 
			Fecha >= '$FechaInicio' AND
			Fecha < '$FechaFin'
			ORDER BY Fecha DESC,  Hora desc";
	//eko ($sql);		
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	
	$pdf->SetFillColor(255);
	$pdf->Cell(80 , $Ln , 'Último registro: '.DDMMAAAA($row['Fecha']) .' a las: '. $row['Hora'], $borde, 0 , 'C' , 1);
	//$pdf->Cell(25 , $Ln ,  , $borde, 0 , 'C' , 1);


$pdf->Output();


?> 