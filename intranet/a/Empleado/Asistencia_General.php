<?php 
//$MM_authorizedUsers = "91,AsistDireccion,Contable";
//require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php');
require_once('../../../inc/rutinas.php'); 
require_once('../../../inc/fpdf.php'); 
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$TituloPantalla = "Asistencia General";

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
	
	$AnoMes = substr($_GET['Inicio'],0,4)."_".substr($_GET['Inicio'],5,2)."_";
	//echo $AnoMes.'<br>';
	// Crea Variables
	$FechaInicioGET = $_GET['Inicio'].'-01';
	//echo $FechaInicioGET.'<br>';
	$FechaInicioGET = $Ano.'-'.$Mes.'-01';	
	//echo $FechaInicioGET.'<br>';
	$AnoMes = $Ano.'_'.$Mes.'_';
	//echo $AnoMes.'<br>';
	$FechaInicio = strtotime($FechaInicioGET);
	//echo $FechaInicio;
	//$Mes = Mes(date('m' , $FechaInicio));
	//$Ano = Mes(date('Y' , $FechaInicio));
	
	//echo $Mes.$Ano;
	
	
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
	$query_RS_ = "SELECT * FROM Calendario WHERE Fecha >= '".$FechaInicioGET."' AND  Fecha < '".$FechaFin."'";
	//echo $query_RS_;
	$RS_ = $mysqli->query($query_RS_);
	while ($row_RS_ = $RS_->fetch_assoc()) {
		
		if($row_RS_['Feriado']=='1'){
			$Feriado[  substr($row_RS_['Fecha'],8,2)*1  ] = true;
			//echo $row_RS_['Fecha']."  ".substr($row_RS_['Fecha'],8,2)."<br>";
			}
		if($row_RS_['NoLaboral']=='1')
			$NoLaboral[date('d',$row_RS_['Fecha'])] = true;
	} 
	// FIN Busca los $Feriado y $NoLaboral



	$query_RS_Empleados = "SELECT * FROM Empleado  
						   WHERE SW_activo=1 
						   AND SW_Asistencia='1' 
						   ORDER BY Apellidos, Nombres ASC";

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
		//echo $sql_Registros.'<br>';					
		$RS_Registros = $mysqli->query($sql_Registros);
		while ($row_Registros = $RS_Registros->fetch_assoc()) { // Llena horas
			$Dia = DiaN($row_Registros['Fecha'])*1;
			//echo $Dia;	
		 // Entrada
			if($FechaAnterior != $row_Registros['Fecha'] or $Codigo_Empleado_Anterior != $row_Registros['Codigo_Empleado']){ //echo $row_Registros['Fecha'].'<br>';
				$Empleado[$Ln][$Dia][Entrada][Hr] = $row_Registros['Hora'];
				$Empleado[$Ln][$Dia][Entrada][Obs] = $row_Registros['Obs'];
				$Empleado[$Ln][$Dia][Entrada][Nota] = $row_Registros['Nota'];
				$Empleado[$Ln][$Dia][Entrada][SW_Consolidado] = $row_Registros['SW_Consolidado'];
				$Empleado[$Ln][$Dia][Entrada][CodigoRegistro] = $row_Registros['Codigo'];}
		
		 // Salida
			if($FechaAnterior == $row_Registros['Fecha']){
				$Empleado[$Ln][$Dia][Salida][Hr] = $row_Registros['Hora'];
				$Empleado[$Ln][$Dia][Salida][SW_Consolidado] = $row_Registros['SW_Consolidado'];
				$Empleado[$Ln][$Dia][Salida][Obs] = $row_Registros['Obs'];}

			
					

		 // Dias No Laboral
	 	//	$DiaSemana = date('N',mktime(0,0,0,MesN($row_Registros['Fecha']),DiaN($row_Registros['Fecha']),AnoN($row_Registros['Fecha'])));
		 //	if($Empleado[$Ln][Asis][$DiaSemana] == '0'){
		//		$Empleado[$Ln][$Dia][Entrada][Obs] = '-';	}
			
			$FechaAnterior = $row_Registros['Fecha'];
			$Codigo_Empleado_Anterior = $row_Registros['Codigo_Empleado'];
			}
		
		$LnMax++;
	}

$DiaMax = $Dia;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center"><?php 
		$addVars = "";
		Ir_a_AnoMes($Mes, $Ano, $addVars);
 ?></td>
  </tr>
  <tr>
    <td align="center" valign="top">
<table width="90%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-hover">
  <tr class="subtitle">
    <td colspan="<?php echo $DiasDelMes+4 ?>" align="center" nowrap="nowrap" ><img src="../../../img/b.gif" width="1" height="1" /></td>
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
	if($Encabezado==10)
	$Encabezado=-1;
	}
	
	$Encabezado++; 
	
	
	?>
	
	
	
	
	
	
	  <tr <?php //echo $sw=ListaFondo($sw,$Verde); ?>>
		<td align="right" nowrap="nowrap"><?php echo $Ln; ?></td>
		<td align="right" nowrap="nowrap"><?php echo $Empleado[$Ln][Codigo]; ?></td>
		<td nowrap="nowrap"><strong><?php echo $Empleado[$Ln][NombreApellido]; ?></strong></td>
	<?php 
	
	for ($Dia = 1; $Dia <= $DiasDelMes; $Dia++) { ?>
		<td align="center" valign="middle" nowrap="nowrap"><?php 
		$Diaa = substr("00000".$Dia , -2);
		$AnoMesDia = $AnoMes.$Diaa;
		$Coord = $Empleado[$Ln][Codigo] ."_".$AnoMesDia;
		$CodigoEmpleado = $Empleado[$Ln][Codigo];
		$URL = "Asis_jq.php?CodigoEmpleado=$CodigoEmpleado&AnoMesDia=$AnoMesDia&Obs=" ;
		 ?><div id="Espacio_<?php echo $Coord ?>">
		<?php
	
	
			
		if($Empleado[$Ln][$Dia][Entrada][Obs] > " "){
			
			if($Empleado[$Ln][$Dia][Entrada][SW_Consolidado] == 0){
			?><a href="#" id="X_Click_<?php echo $Coord; ?>"  title="Click para borrar"><?php
			}
			
			if($Empleado[$Ln][$Dia][Entrada][Obs] == "Falto"){
			?>
		<img src="../../../i/bullet_red.png" width="18" height="18" alt=""/>
		<?php }
			
			elseif($Empleado[$Ln][$Dia][Entrada][Obs] == "Asist"){
			?>
		<img src="../../../i/accept_1.png" width="16" height="16" alt=""/><?php }
			
			//Asist
			
			else{
				echo $Empleado[$Ln][$Dia][Entrada][Obs]; 	
				}
			
			if($Empleado[$Ln][$Dia][Entrada][SW_Consolidado] == 0){
			?></a><?php 
			}
			
			$Nota = $Empleado[$Ln][$Dia][Entrada][Nota];
			?><br>
            <a href="Asis_Nota.php?<? echo "CodigoEmpleado=$CodigoEmpleado&AnoMesDia=$AnoMesDia"; ?>" target="_blank"
             title="<?php echo $Nota; ?>"><?php if($Nota > "") {echo substr($Nota,0,8);}else{echo "n";}?></a>
			<script>
            $(document).ready(function() {
                $("#X_Click_<?php echo $Coord ?>").on("click",function(e){
                    e.preventDefault();
                    $("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."X" ?>");
                });
            });
            </script>
		<?php 
		}
		
		elseif($Empleado[$Ln][$Dia][Entrada][Hr] != ""){
			echo     '&nbsp;'.substr($Empleado[$Ln][$Dia][Entrada][Hr],0,5);
			//echo '<br>&nbsp;'.substr($Empleado[$Ln][$Dia][Salida][Hr],0,5);
			
			if($Empleado[$Ln][$Dia][Salida][Hr] > ""){
				$Tiempo = (strtotime($Empleado[$Ln][$Dia][Salida][Hr])-strtotime($Empleado[$Ln][$Dia][Entrada][Hr]))/3600;
				$Horas = floor($Tiempo);
				$Minutos = substr("00".round(( $Tiempo - $Horas ) * 60 , 0) , -2);
			
			if($Horas > 1)
				echo "<br>&nbsp;($Horas:$Minutos)";
			}
			
				}
		
		
		
		elseif($Feriado[$Dia] == true){
			echo 'F';}
		elseif($Empleado[$Ln][Asis][date('N',$Empleado[$Dia][Fecha])] == '0' ){
			echo '-';}
		else{ ?>
			  <a href="#" id="Click_<?php echo $Coord; ?>"><img src="../../../img/b_edit.png" width="16" height="16" /></a>   
		<?php }	
		?></div></td>
	<?php } ?>
		<td nowrap="nowrap">&nbsp;</td>
	  </tr>
<?php } ?>



</table>
</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<script>
$(document).ready(function() {<?php 
for ($Ln = 1; $Ln <= $LnMax; $Ln++) { 
	for ($Dia = 1; $Dia <= $DiasDelMes; $Dia++) {
		$Diaa = substr("00000".$Dia , -2);

?>	
	$("#Click_<?php echo $Empleado[$Ln][Codigo] ."_". $AnoMes.$Diaa ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Empleado[$Ln][Codigo] ."_". $AnoMes.$Diaa ?>").load("<?php //echo $ToRoot ?>Asis_jq.php?<?php echo "CodigoEmpleado=".$Empleado[$Ln][Codigo]."&AnoMesDia=$AnoMes$Diaa" ?>");
	});
	
	
	
	
<?php }} ?>
});
</script>