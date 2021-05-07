<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
if (!isset($_GET['Status_Proceso_Ins'])) {
	$SW_omite_trace = false;
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


if(isset($_GET['Status_Proceso_Ins'])){
	
	if($_GET['Status_Proceso_Ins'] == "Aceptado"){
		$addAceptado = " , Status = 'Aceptado', Status_por = '$MM_Username', Fecha_Aceptado = '".date('Y-m-d')."'";
	}
	else{
		$addAceptado = " , Status = 'Solicitando', Status_por = '$MM_Username', Fecha_Aceptado = ''";
	}
	
	$sql="UPDATE AlumnoXCurso
			SET Status_Proceso_Ins = '".$_GET['Status_Proceso_Ins']."'
			$addAceptado 
			WHERE Ano = '$AnoEscolarProx'
		  	AND CodigoAlumno = '".$_GET['CodigoAlumno']."'";
	//echo $sql;		
	$mysqli->query($sql);
}




$sql = "SELECT * FROM AlumnoXCurso
		  WHERE Ano = '$AnoEscolarProx'
		  AND CodigoAlumno = '".$_GET['CodigoAlumno']."'";
//echo $sql;
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();

echo "{".$row['Status']."}";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />

</head>

<body <?php if(isset($_GET['Status_Proceso_Ins'])){
 ?>bgcolor="#FFFFCC"<?php } ?>>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap="nowrap"><form name="form" id="form">
  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('self',this,0)">
   <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=">Seleccione</option>
     
    <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=No" <?php
				 if($row['Status_Proceso_Ins'] == "No") echo ' selected="selected"'; ?>>No Ingresa</option>

    <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Lista" <?php
				 if($row['Status_Proceso_Ins'] == "Lista") echo ' selected="selected"'; ?>>Lista Espera</option>
                 
    <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Lista2" <?php
				 if($row['Status_Proceso_Ins'] == "Lista2") echo ' selected="selected"'; ?>>Lista Espera 2</option>

   <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins="></option>

    
    <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Si" <?php
				 if($row['Status_Proceso_Ins'] == "Si") echo ' selected="selected"'; ?>>Ingreso</option>
   
    <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Si-Carpeta" <?php
				 if($row['Status_Proceso_Ins'] == "Si-Carpeta") echo ' selected="selected"'; ?>>Entreg&oacute; Carpeta</option>

   <option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins="></option>
   
<?php 
$Fechas = file('archivo/Fechas.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);			
foreach($Fechas as $Fecha){ ?>   
<option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Cita:<?php echo $Fecha ?>" <?php
if($row['Status_Proceso_Ins'] == "Cita:".$Fecha) echo ' selected="selected"'; ?>>Cita: <?php echo $Fecha ?></option>
<?php } ?>   
   
   
   
<option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins="></option>
   
<option value="Status_iFr.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Status_Proceso_Ins=Aceptado" <?php
				 if($row['Status_Proceso_Ins'] == "Aceptado") echo ' selected="selected"'; ?>>Aceptado <?php echo DDMMAAAA($row['Fecha_Aceptado']); echo " -> ".Dias_Dif ($row['Fecha_Aceptado'] , date('Y-m-d')); ?></option>
   
                 
                 
  </select></form>
		
</td>

<?php if (substr($row['Status_Proceso_Ins'],0,4) == "Cita"){ ?>
<td>

<a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=<?php echo $row['Status_Proceso_Ins'] ?>" target="_blank">
<?php echo $row['Status_Proceso_Ins'] ?> <img src="../../../i/email.png" width="16" height="16"   /></a>

</td>
<?php } ?>
<td><?php 

// Crear ProcesoSolicitud 
if ($_GET['Crear']=='ProcesoSolicitud') {
	
	$query = "SELECT * ContableMov 
				WHERE CodigoPropietario = '".$_GET['CodigoAlumno']."'
				AND Descripcion = 'Proceso de Solicitud'
				AND Referencia = 'Sol ".$AnoEscolarProx."'
				";
	$RS = $mysqli->query($query); 
	$Conteo = $RS->num_rows;
	//echo '<H1>'.$query." </h1>";	

	if($Conteo == 0){
		$query = "INSERT INTO ContableMov 
					SET CodigoPropietario = '".$_GET['CodigoAlumno']."',
					Descripcion = 'Proceso de Solicitud',
					MontoDebe = '".$Costo_Proceso_Sol_Cupo."',
					MontoDebe_Dolares = '".$Costo_Dolares_Proceso_Sol_Cupo."',
					Fecha = '".date('Y-m-d')."',
					Referencia = 'Sol ".$AnoEscolarProx."',
					ReferenciaMesAno = 'Sol ".$AnoEscolarProx."',
					SWValidado = '1'
					";
		//echo '<H1>'.$query." </h1>";	
		$mysqli->query($query); 
	
		echo "√";
		
		$sql = "UPDATE Alumno SET Deuda_Actual='".$Costo_Proceso_Sol_Cupo."' WHERE CodigoAlumno = ".$_GET['CodigoAlumno'];
		$mysqli->query($sql);			  
		//echo '<H1>'.$query." </h1>";	
	}
 }
// fin ProcesoSolicitud


?></td>

<td align="center" nowrap="nowrap">
<?php 
if($row['Status_Proceso_Ins'] == "Si") {
	$query = "SELECT * FROM ContableMov 
				WHERE CodigoPropietario = '".$_GET['CodigoAlumno']."'
				AND Descripcion = 'Proceso de Solicitud'
				AND Referencia = 'Sol ".$AnoEscolarProx."'";
	$RS_ = $mysqli->query($query);
	$existe = $RS_->num_rows;	
	if( !$existe ){	// No existe Factura -> Crear	
			?>
<a href="Status_iFr.php?Crear=ProcesoSolicitud&CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>" ><img src="../../../i/coins_in_hand.png" width="16" height="16" />Crear Fac</a>
          <?php }
		  else { // Se Creo Factura   
          
if($row['Status_Proceso_Ins'] == "Si"){
		$query = "SELECT * FROM Alumno 
					WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";
		$RS_ = $mysqli->query($query);
		//echo '<H1>'.$query." </h1>";	
		$row_ = $RS_->fetch_assoc();
		if($row_['Deuda_Actual'] == 0)
			echo '<img src="../../../i/coin_single_gold.png" width="16" height="16" />';
		if($row_['Deuda_Actual'] > 0)
			echo '<img src="../../../i/coin_single_silver.png" width="16" height="16" />';
			
	}
          
          
} ?>
</td>
          
      <td align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=SiEntro" target="_blank"> Si <img src="../../../i/email.png" width="16" height="16"   /></a></td>


<?php } elseif($row['Status_Proceso_Ins'] == "No") {  ?>

      <td align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=NoEntroProxAno" target="_blank"> No (Prox A&ntilde;o) <img src="../../../i/email.png" width="16" height="16"   /></a></td>

<?php } elseif($row['Status_Proceso_Ins'] == "Lista") {  ?>

      <td align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=NoEntroEspera" target="_blank"> Lista Espera <img src="../../../i/email.png" width="16" height="16"   /></a></td>

<?php } elseif($row['Status_Proceso_Ins'] == "Aceptado") {  ?>

      <td align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=Aceptado" target="_blank"> Aceptado <img src="../../../i/email.png" width="16" height="16"   /></a></td>
      
      <td align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno'] ?>&Email=NueIng_Cuota" target="_blank"> Nueva Cuota <img src="../../../i/email.png" width="16" height="16"   /></a></td>

<?php } ?>  


    
    </tr>
    
  </table>

</body>
</html>