<?php 
require_once('../../../Connections/bd.php');
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

	// POSIBLE ELIMINABLE


	// Asigna Dia de Semana en BD
	$sql = "SELECT * FROM Empleado_EntradaSalida WHERE DiasSemana IS NULL ";
	$RS = $mysqli->query($sql);
	while($row = $RS->fetch_assoc()) {
		extract($row);
		$DiasSemana = date('N' , strtotime($Fecha));
		$sql_aux = "UPDATE Empleado_EntradaSalida 
					SET DiasSemana='$DiasSemana' 
					WHERE Codigo='$Codigo'";
		//echo $sql_aux;			
		$mysqli->query($sql_aux);			
	}
	// FIN Asigna Dia de Semana en BD
	

	// Crea Variables
	$FechaInicioGET = $_GET['Inicio'].'-01';
	$FechaInicio = strtotime($FechaInicioGET);

	$Mes = Mes(date('m' , $FechaInicio));
	$Ano = Mes(date('Y' , $FechaInicio));
	
	$mes_siguiente  = mktime(0, 0, 0, 
						date("m", $FechaInicio)+1, 
						date("d",$FechaInicio),   
						date("Y",$FechaInicio));
	
	$FechaFin     = date('Y-m-d' , $mes_siguiente);
	$DiaSemanaInicio  = date('N' , $FechaInicio);
	$aux_DiaSemanaInicio = $DiaSemanaInicio;
	$DiasDelMes = date('t' , $FechaInicio);
	// FIN Crea Variables
	
	
	// Busca los $Feriado y $NoLaboral
	$query_RS_ = "SELECT * FROM Calendario WHERE Fecha >= '".$FechaInicio."' AND  Fecha < '".$FechaFin."'";
	$RS_ = $mysqli->query($query_RS_);
	while ($row_RS_ = $RS_->fetch_assoc()) {
		if($row_RS_['Feriado']=='1')
			$Feriado[date('d',$row_RS_['Fecha'])] = true;
		if($row_RS_['NoLaboral']=='1')
			$NoLaboral[date('d',$row_RS_['Fecha'])] = true;
	} 
	// FIN Busca los $Feriado y $NoLaboral


	$query_RS_Empleados = "SELECT * FROM Empleado  
						   WHERE SW_activo=1 
						   AND SW_Asistencia='1' 
						   ORDER BY  Apellidos, Nombres ASC";

	// Llena Matriz
	$RS_Empleados = $mysqli->query($query_RS_Empleados);
	while ($row = $RS_Empleados->fetch_assoc()) {
		extract($row);
		$Ln++;
		$Empleado[$Ln][NombreApellido] = $Apellidos.' '.$Nombres;
		$Empleado[$Ln][Codigo] = $CodigoEmpleado;
		$Empleado[$Ln][Asis][1] = $SW_Lun;
		$Empleado[$Ln][Asis][2] = $SW_Mar;
		$Empleado[$Ln][Asis][3] = $SW_Mie;
		$Empleado[$Ln][Asis][4] = $SW_Jue;
		$Empleado[$Ln][Asis][5] = $SW_Vie;
		$Empleado[$Ln][Asis][6] = $SW_Sab;
		$Empleado[$Ln][Asis][7] = $SW_Dom;
		
		//echo $SW_Lun.$SW_Mar.$SW_Mie.$SW_Jue.$SW_Vie.$SW_Sab.$SW_Dom.'<br>';
		
		$sql_Registros = "SELECT * FROM Empleado_EntradaSalida  
				WHERE Codigo_Empleado = '$CodigoEmpleado'  
				AND Fecha >= '$FechaInicioGET' 
				AND Fecha < '$FechaFin'
				ORDER BY Fecha, Hora";
		$RS_Registros = $mysqli->query($sql_Registros);
		while ($row_Registros = $RS_Registros->fetch_assoc()) { // Llena horas
			$Dia = DiaN($row_Registros['Fecha'])*1;
			
		 // Entrada
			if($FechaAnterior != $row_Registros['Fecha']){
				$Empleado[$Ln][$Dia][Entrada][Hr] = $row_Registros['Hora'];
				$Empleado[$Ln][$Dia][Entrada][Obs] = $row_Registros['Obs'];
				$Empleado[$Ln][$Dia][Entrada][CodigoRegistro] = $row_Registros['Codigo'];}
		
		 // Salida
			if($FechaAnterior == $row_Registros['Fecha']){
				$Empleado[$Ln][$Dia][Salida][Hr] = $row_Registros['Hora'];
				$Empleado[$Ln][$Dia][Salida][Obs] = $row_Registros['Obs'];}

			
					

		 // Dias No Laboral
	 	//	$DiaSemana = date('N',mktime(0,0,0,MesN($row_Registros['Fecha']),DiaN($row_Registros['Fecha']),AnoN($row_Registros['Fecha'])));
		 //	if($Empleado[$Ln][Asis][$DiaSemana] == '0'){
		//		$Empleado[$Ln][$Dia][Entrada][Obs] = '-';	}
			
			$FechaAnterior = $row_Registros['Fecha'];
			}
		
		$LnMax++;
	}

$DiaMax = $Dia;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Asistencia</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>

<body>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td colspan="<?php echo $DiasDelMes+4 ?>" align="center" nowrap="nowrap" class="subtitle"><?php echo 'Asistencia '.$Mes. ' '.$Ano; ?>&nbsp;</td>
  </tr>

  
  
<?php 
// Desplegar Empleados
for ($Ln = 1; $Ln <= $LnMax; $Ln++) { 

if($Encabezado == 0){
?>




  
  <tr class="NombreCampo" >
    <td nowrap="nowrap" class="NombreCampo">No</td>
    <td nowrap="nowrap" class="NombreCampo">Cod</td>
    <td nowrap="nowrap" class="NombreCampo">Empleado</td>
<?php 
// Encabezado Dias
$Fecha_aux = mktime(2,0,0,MesN($FechaInicioGET),DiaN($FechaInicioGET),AnoN($FechaInicioGET));
for ($Dia = 1; $Dia <= $DiasDelMes; $Dia++) {  ?>
    <td align="center" nowrap="nowrap" class="NombreCampo"><?php echo DiaS(date('N',$Fecha_aux)).'<br>'.$Dia; ?></td>
<?php 

$Empleado[$Dia][Fecha] = $Fecha_aux;
$Fecha_aux += 86400;

} ?>
    <td nowrap="nowrap" class="NombreCampo">&nbsp;</td>
  </tr>
<?php 
} 
else{
if($Encabezado==14)
$Encabezado=-1;
}

$Encabezado++; 


?>






  <tr <?php echo $sw=ListaFondo($sw,$Verde); ?>>
    <td align="right" nowrap="nowrap"><?php echo $Ln; ?></td>
    <td align="right" nowrap="nowrap"><?php echo $Empleado[$Ln][Codigo]; ?></td>
    <td nowrap="nowrap"><strong><?php echo $Empleado[$Ln][NombreApellido]; ?></strong></td>
<?php for ($Dia = 1; $Dia <= $DiasDelMes; $Dia++) { ?>
    <td align="center" valign="middle" nowrap="nowrap"><?php
		

	if($Empleado[$Ln][$Dia][Entrada][Obs]==''){
		$Print = '&nbsp;'.substr($Empleado[$Ln][$Dia][Entrada][Hr],0,5)
		    .'<br>&nbsp;'.substr($Empleado[$Ln][$Dia][Salida][Hr],0,5);}
	else{
		$Print = $Empleado[$Ln][$Dia][Entrada][Obs];}
	
	if($Empleado[$Ln][Asis][date('N',$Empleado[$Dia][Fecha])] == '0' )
		$Print = '-';

	if(($Print == '&nbsp;<br>&nbsp;' or $Print=='Aus') and $Dia <= $DiaMax){
		$Print = '<a href="../Procesa.php?AsistenciaPersonal=1&Codigo_Empleado='.$Empleado[$Ln][Codigo].
				'&Fecha='.date('Y-m-d',$Empleado[$Dia][Fecha]).
				'&Registrado_Por='.$MM_Username.
				'&Obs=Asist'.
				'&Codigo='.$Empleado[$Ln][$Dia][Entrada][CodigoRegistro].
				'" target="_blank">N/Marc</a><br>
				
				<a href="../Procesa.php?AsistenciaPersonal=1&Codigo_Empleado='.$Empleado[$Ln][Codigo].
				'&Fecha='.date('Y-m-d',$Empleado[$Dia][Fecha]).
				'&Registrado_Por='.$MM_Username.
				'&Obs=Just'.
				'&Codigo='.$Empleado[$Ln][$Dia][Entrada][CodigoRegistro].
				'" target="_blank">F/Just</a><br>'.
				
				'<a href="../Procesa.php?AsistenciaPersonal=1&Codigo_Empleado='.$Empleado[$Ln][Codigo].
				'&Fecha='.date('Y-m-d',$Empleado[$Dia][Fecha]).
				'&Registrado_Por='.$MM_Username.
				'&Obs=Desc'.
				'&Codigo='.$Empleado[$Ln][$Dia][Entrada][CodigoRegistro].
				'" target="_blank">Desc</a><br>';
				
				
				
				
	}


echo $Print;
	
	 ?>

<iframe src="ok.php" scrolling="no" seamless="seamless" width="80" height="50"></iframe>    

     
     </td>
<?php } ?>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
<?php } ?>



</table>









<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>
