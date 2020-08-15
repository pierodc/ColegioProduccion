<?php 
$MM_authorizedUsers = "91,AsistDireccion";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php'); 
require_once('../../inc/fpdf.php'); 

if(isset($_GET['insert'])){
	$Codigo_Empleado = $_GET['Codigo_Empleado'];
	$Fecha = $_GET['Fecha'];
	$CodigoEmpleado = $_GET['insert'];
	$Registrado_Por = $_GET['Registrado_Por'];
	$Codigo = $_GET['Codigo'];
	$Obs = $_GET['Obs'];

	if($Codigo > 0){
		$sql = "UPDATE Empleado_EntradaSalida 
				SET Obs='$Obs', 
				Registrado_Por = '$Registrado_Por',
				Fecha = '$Fecha'
				WHERE Codigo = '$Codigo'";
		echo $sql;
		} 
	if($Codigo==''){
		$sql = "INSERT INTO Empleado_EntradaSalida 
				SET Obs='$Obs', 
				Registrado_Por = '$Registrado_Por' ,
				Fecha = '$Fecha' ,
				Codigo_Empleado = '$Codigo_Empleado',
				Hora = '12:00:00'
				";
		echo $sql;
		} 

	$RS = mysql_query($sql, $bd) or die(mysql_error());
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Asistencia</title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body <?php if(isset($_GET['insert'])) echo 'onload="window.close()"' ?>><?php 

if(!isset($_GET['insert'])){
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
	$RS_ = mysql_query($query_RS_, $bd) or die(mysql_error());
	$row_RS_ = mysql_fetch_assoc($RS_);
	do {
		if($row_RS_['Feriado']=='1')
			$Feriado[DiaN($row_RS_['Fecha'])*1]=1;
		if($row_RS_['NoLaboral']=='1')
			$NoLaboral[DiaN($row_RS_['Fecha'])*1]=1;
			
	} while($row_RS_ = mysql_fetch_assoc($RS_));




		$FechaInicio  = $_GET['Inicio'].'-01';
		$DDMMAAAA_Inicio = DiaN($FechaInicio).'-'.MesN($FechaInicio).'-'.AnoN($FechaInicio);
		$DiasDelMes = date('t' , strtotime($DDMMAAAA_Inicio));
		$DiaSemanaInicio  = date('w' , strtotime($DDMMAAAA_Inicio));
		$aux_DiaSemanaInicio = $DiaSemanaInicio;
		$Mes = Mes(date('m' , strtotime($DDMMAAAA_Inicio)));
		$Ano = Mes(date('Y' , strtotime($DDMMAAAA_Inicio)));
	
?>
<table width="100%" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="5">&nbsp;<?php echo 'Asistencia <br>'.$Mes. ' '.$Ano; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;No</td>
    <td rowspan="2">&nbsp;Cod</td>
    <td rowspan="2">&nbsp;Empleado</td>
<?php for ($i = 1; $i <= $DiasDelMes; $i++) { ?>    
    <td align="center">&nbsp;<?php  echo substr(DiaSemana($aux_DiaSemanaInicio++),0,2) ?></td>
 <?php if($aux_DiaSemanaInicio==7) 
			$aux_DiaSemanaInicio=0;
		} ?>    
    <td rowspan="2">&nbsp;Promedio</td>
  </tr>
  <tr>
<?php for ($i = 1; $i <= $DiasDelMes; $i++) {?>  
    <td align="center">&nbsp;<?php echo $i ?></td>
  <?php } 
  
  
  ?>
  </tr><?php 

$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
						SW_activo=1 AND 
						SW_Asistencia='1' 
						ORDER BY  Apellidos, Nombres ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

$aux_DiaSemanaInicio = $DiaSemanaInicio;


do{ // Para cada empleado
	extract($row_RS_Empleados);


?><tr>
    <td rowspan="2" class="Listado<?php echo $In ?>Par12">&nbsp;<?php echo ++$No ?></td>
    <td rowspan="2" class="Listado<?php echo $In ?>Par12">&nbsp;<?php echo $CodigoEmpleado ?></td>
    <td rowspan="2"  class="Listado<?php echo $In ?>Par12" nowrap="nowrap">&nbsp;<?php echo $Apellidos.' '.$Nombres ?></td>
<?php	$Amarillo = false;
	$sql = "SELECT * FROM Empleado_EntradaSalida WHERE 
			Codigo_Empleado = '$CodigoEmpleado' AND 
			Fecha >= '$FechaInicio' AND
			Fecha < '$FechaFin'
			ORDER BY Fecha, Hora";
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);

	do{
		$j = DiaN($row['Fecha'])*1;
		$CodigoRegistro[$j] = $row['Codigo'];
		if(!$HoraEntrada[$j]){
			$HoraEntrada[$j] 	= mktime( substr($row['Hora'],0,2) , substr($row['Hora'],3,2) ,0,0,0,0);
			$Obs[$j] = $row['Obs'];}
		if($DiaRegistroAnterior == $row['Fecha'])	
			$HoraSalida[$j] 	= mktime( substr($row['Hora'],0,2) , substr($row['Hora'],3,2) ,0,0,0,0);
		else
			$HoraSalida[$j] = '';
		
		
		$DiaRegistroAnterior = $row['Fecha'];
	} while ($row = mysql_fetch_assoc($RS)); 


	$aux_DiaSemanaInicio = $DiaSemanaInicio;
	
	// ENTRADAS
	for ($i = 1; $i <= $DiasDelMes; $i++) { 
	$Casilla  = '';
	$FechaMov = $_GET['Inicio'].'-'.substr('0'.$i,-2);
		if(substr_count( "$DiasSemana" , "$aux_DiaSemanaInicio")){
			if( $HoraEntrada[$i]>'1' ){
				if($HoraEntrada[$i]>0)
					$Casilla = date('G:i',$HoraEntrada[$i]);
				}
			else {
				$Casilla = '';
				 }
			
			if($HoraEntrada[$i]) {
				$HoraSuma+=$HoraEntrada[$i]; 
				$HoraCuenta+=1;}
		}else{
			$Casilla = '-   ';
			}
		
		if($Feriado[$i]==1 or $NoLaboral[$i]==1 or (MesN($FechaInicio) == date('m') and date('j') < $i)){
			}

		if(	$Obs[$i] > ''){
			$Casilla = $Obs[$i];
		}
		
	
?>    
    <td align="right" nowrap="nowrap" class="Listado<?php echo $In ?>Par12">&nbsp;<?php
	
	if($Casilla=='' or $Casilla=='Aus'){
		
		echo '<a href="Empleado_Asistencia.php?insert=1&Codigo_Empleado='.$CodigoEmpleado.
				'&Fecha='.$FechaMov.
				'&Registrado_Por='.$MM_Username.
				'&Obs=Asist'.
				'&Codigo='.$CodigoRegistro[$i].
				'" target="_blank">N/Marc';
		echo '</a><br>';
		$Obser[$i] = 'Asist';
	
		echo '<a href="Empleado_Asistencia.php?insert=1&Codigo_Empleado='.$CodigoEmpleado.
				'&Fecha='.$FechaMov.
				'&Registrado_Por='.$MM_Username.
				'&Obs=Just'.
				'&Codigo='.$CodigoRegistro[$i].
				'" target="_blank">F/Just';
		echo '</a><br>';
		$Obser[$i] = 'Just';

	}elseif($Casilla!='Aus'){
		echo $Casilla; 
		$Obser[$i] = '';
		}
	
	?></td>
 <?php	
		
		$aux_DiaSemanaInicio++;
		if($aux_DiaSemanaInicio==7) 
			$aux_DiaSemanaInicio=0;
	} // END for
	
	if($HoraCuenta>0) 
		$Promedio = date('G:i',$HoraSuma/$HoraCuenta); else $Promedio='';
	
	
   ?>    
    <td rowspan="2" class="Listado<?php echo $In ?>Par12">&nbsp;Promedio</td>
  </tr>
 <?php 


?> 
  <tr>
  <?php
	
	// SALIDAS
	$aux_DiaSemanaInicio = $DiaSemanaInicio;

	for ($i = 1; $i <= $DiasDelMes; $i++) { 
	$Casilla='';
		if(substr_count( "$DiasSemana" , "$aux_DiaSemanaInicio")){
			if( $HoraEntrada[$i]>'1'){
				if($HoraSalida[$i]>0)
					$Casilla = ' '.date('G:i',$HoraSalida[$i]);
				}
			else {
				$Casilla = '';
				}
			
			if($HoraEntrada[$i]) {
				$HoraSuma+=$HoraEntrada[$i]; 
				$HoraCuenta+=1;}
		}else{
			$Casilla = '-   ';
			}

		
		if($Obser[$i]=='Just' or $Obser[$i]=='Asist')
			$Casilla = '';
			
 ?>
    <td align="right" class="Listado<?php echo $In ?>Par12">&nbsp;<?php echo $Casilla; ?></td>
  <?php  
		
		
		$aux_DiaSemanaInicio++;
		if($aux_DiaSemanaInicio==7) 
			$aux_DiaSemanaInicio=0;
	}

?></tr><?php 	
	
	if($In=='') $In='In'; else $In=''; 
	$HoraSuma=0; $HoraCuenta=0;
	unset($HoraEntrada);
	unset($HoraSalida);
	unset($Obs);
	unset($CodigoRegistro);
	unset($Obser);

} while($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));

?>


  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
