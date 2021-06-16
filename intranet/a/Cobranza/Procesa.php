<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

// Activa Inspeccion
$Insp = false ;

$SW_Confirma = false;

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
</head>
<?php 
$Tiempo = 500; 
if( $MM_Username == 'piero')
	$Tiempo = 5000; 
//echo $MM_Username;

?>
<body <?php if($MM_Username!='piero' or true and !isset($_GET['bot_EliminarMov']) and !isset($_GET['bot_Prioridad']) and !isset($_GET['Prioridad'])){ ?> onload="setTimeout('window.close()',<?php echo $Tiempo ?>)" <?php } ?>>
<?php 
// Actualiza Foto
if (isset($_GET['ActualizaFoto']) ) {
	
	$Foto = $_GET['Foto'];
	$Actualiza = $_GET['ActualizaFoto'];
	$partes_ruta = pathinfo($Foto);
	echo 'dirname ('.$_SERVER['PHP_SELF'].') ' .dirname($_SERVER['PHP_SELF']).'<br>';
	$NombreActual = "../Foto_Repre/".$Foto;
	$NombreNuevo = "../Foto_Repre/x_".$Foto;
	echo $NombreActual.'<br>';
	echo $NombreNuevo.'<br>';
	
	rename($NombreActual , $NombreNuevo);
	
}
// fin  Actualiza Foto



// Cambia Inscribir 
if (isset($_GET['Inscribir']) and $_GET['Inscribir']==1) {
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Inscrito',
					Status_por = '$MM_Username',
					Fecha_Inscrito = '".date('Y-m-d')."',
					SeRetira = '0'
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";
		$mysqli->query($query); 
		echo "<H1>Inscrito ".$_GET['CodigoAlumno']." </h1>"; }
// fin Cambia PreInscribir

// Cambia ANULA FACTURA =0 
if (isset($_GET['AnularFactura'])) {
		$query = "UPDATE Recibo 
					SET NumeroFactura = '0'
					WHERE NumeroFactura='".$_GET['NumeroFactura']."' ";
		$mysqli->query($query); 
//		echo $query;
		echo "<H1>NumeroFactura = 0 ".$_GET['NumeroFactura']." <br>$query</h1>"; 
		
		$query = "UPDATE Factura_Control 
					SET Factura_Numero = '0'
					WHERE Factura_Numero='".$_GET['NumeroFactura']."' ";
		$mysqli->query($query); 
		echo "<H1>$query</h1>"; 
		
//		
		
		
		}
// Cambia ANULA FACTURA =0 


// Cambia Retirar 
if (isset($_GET['Retirar']) and $_GET['Retirar']==1) {
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Retirado',
					Status_por = '$MM_Username',
					Fecha_Retiro = '".date('Y-m-d')."'
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";
				$mysqli->query($query); 
 		echo "<H1>Retirar ".$_GET['CodigoAlumno']." </h1>"; 
 }
// fin Cambia Retirar

// Cambia a Aceptado 
if (isset($_GET['Aceptado']) and $_GET['Aceptado']==1) {
		mysql_select_db($database_bd, $bd);
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Aceptado',
					Status_por = '$MM_Username',
					Fecha_Inscrito = '".date('Y-m-d')."'
					WHERE CodigoAlumno='".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";	
		$mysqli->query($query); 
 }
// fin Cambia a Aceptado

// Cambia a Solicitando 
if (isset($_GET['Solicitando']) and $_GET['Solicitando']==1) {
		mysql_select_db($database_bd, $bd);
		$query = "UPDATE AlumnoXCurso 
					SET Status = 'Aceptado -> ".$_GET['Motivo']."',
					Status_por = '$MM_Username'
					WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."' 
					AND Ano =  '".$_GET['AnoEscolar']."'";	
		echo $query;			
		$mysqli->query($query); 
 }
// fin Cambia a Solicitando



// Cambia SeRetira 
if ($_GET['SeRetira']==1) {
	$query = "UPDATE AlumnoXCurso 
				SET SeRetira = '1'
				WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."' 
				AND Ano =  '".$_GET['AnoEscolar']."'";
	echo '<H1>'.$query." </h1>";			
	$mysqli->query($query); 
 }
// fin Cambia SeRetira


// Crear ProcesoSolicitud 
if ($_GET['Crear']=='ProcesoSolicitud') {
	
	$query = "SELECT * ContableMov 
				WHERE CodigoPropietario = '".$_GET['CodigoAlumno']."'
				AND Descripcion = 'Proceso de Solicitud'
				AND Referencia = 'Sol ".$AnoEscolarProx."'
				";
	$RS = $mysqli->query($query); 
	$Conteo = $RS->num_rows;
	echo '<H1>'.$query." </h1>";	

	if($Conteo == 0){
		$query = "INSERT INTO ContableMov 
					SET CodigoPropietario = '".$_GET['CodigoAlumno']."',
					Descripcion = 'Proceso de Solicitud',
					MontoDebe = '600',
					Fecha = '".date('Y-m-d')."',
					Referencia = 'Sol ".$AnoEscolarProx."',
					ReferenciaMesAno = 'Sol ".$AnoEscolarProx."',
					SWValidado = '1'
					";
		echo '<H1>'.$query." </h1>";	
		$mysqli->query($query); 
	
		$sql = "UPDATE Alumno SET Deuda_Actual='600' WHERE CodigoAlumno = ".$_GET['CodigoAlumno'];
		$mysqli->query($sql);			  
		echo '<H1>'.$query." </h1>";	
	}
 }
// fin ProcesoSolicitud



// Elimina ALUMNO
if ((isset($_GET['CodigoAlumno'])) && ($_GET['CodigoAlumno'] != "") && (isset($_GET['EliminaAlumno']))) {
  $query = sprintf("UPDATE Alumno SET Creador = CONCAT('x_',Creador) WHERE CodigoAlumno=%s",
                       GetSQLValueString($_GET['CodigoAlumno'], "int"));

	$mysqli->query($query); 
  if($Result1) echo "DELETE Alumno $_GET[CodigoAlumno] ";
}


// Eliminar EliminaGen 
if (isset($_GET['EliminaGen'])) {
	$Tabla = $_GET['Tabla'];
	$Clave = $_GET['Clave'];
	$Valor = $_GET['Valor'];
		
	  $query = "DELETE FROM $Tabla WHERE $Clave = '$Valor'";//echo "delete";
	  $Result1 = $mysqli->query($query); 
	  if($Result1) echo "DELETE $Tabla - > $Clave = $Valor ";
}




//Elimina ContableMov 
if(isset($_GET['bot_EliminarMov'])){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="../Procesa.php?EliminarMov=1&amp;Codigo=<?php echo $_GET['Codigo']; ?>"><img src="../../../img/b_drop.png" alt="" width="16" height="16" border="0" /></a></td>
  </tr>
</table>
<?
}





// Elimina ContableMov
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarMov']))) {
	$query = sprintf("DELETE FROM ContableMov WHERE Codigo=%s",
					   GetSQLValueString($_GET['Codigo'], "int"));
	$Result1 = $mysqli->query($query); 
    if($Result1) echo "ok";
}


// Prioridad ContableMov
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['PrioridadMov']))) {
	$PrioridadMov = $_GET['PrioridadMov'];
		
	$query = sprintf("UPDATE ContableMov 
						SET SW_Prioridad = '$PrioridadMov'
						WHERE Codigo=%s",
					   GetSQLValueString($_GET['Codigo'], "int"));
	//echo 	$query;			   
	$Result1 = $mysqli->query($query); 
    if($Result1) echo $PrioridadMov;
}
//Elimina bot_PrioridadMov 
if(isset($_GET['bot_PrioridadMov'])){
	if($_GET['bot_PrioridadMov'] == '1')
		$PrioridadMov = 0;
	else
		$PrioridadMov = 1;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="../Procesa.php?PrioridadMov=<?php echo $PrioridadMov ?>&amp;Codigo=<?php echo $_GET['Codigo']; ?>"><img src="../../../i/lightning.png" alt="" width="16" height="16" border="0" /></a></td>
  </tr>
</table>
<?
}








// Eliminar AsignacionXAlumno 
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarAsignacion']))) {
	  $query = sprintf("DELETE FROM AsignacionXAlumno WHERE Codigo=%s",
						   GetSQLValueString($_GET['Codigo'], "int"));//echo "delete";
	$Result1 = $mysqli->query($query); 
	  if($Result1) echo "DELETE Asignacion $_GET[Codigo] ";
}



// Asistencia Personal ELIMINAR
if(isset($_GET['AsistenciaPersonal'])){ // Actualiza registro
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
				Fecha = '$Fecha',
				Hora = '12:00:00'
				WHERE Codigo = '$Codigo'";
		} 
	if($Codigo==''){
		$sql = "INSERT INTO Empleado_EntradaSalida 
				SET Obs='$Obs', 
				Registrado_Por = '$Registrado_Por' ,
				Fecha = '$Fecha' ,
				Hora = '12:00:00',
				Codigo_Empleado = '$Codigo_Empleado'
				";
		} 
	$mysqli->query($sql);
	echo "<H1> $Obs </h1><br>".$sql.""; 

}






//  
if (isset($_GET['CambiaPagoProveedor'])) {
  $query = "UPDATE ContableMov SET PagoPreveedorNo = ".$_GET["CambiaPagoProveedor"]." WHERE Codigo = ".$_GET["Codigo"];
	$Result1 = $mysqli->query($query); 
  if($Result1) 
  		echo $SQL;
}

//  
if (isset($_GET['PagoProveedorAsistio'])) {
  $SQL = "UPDATE ContableMov SET PagoProveedorAsistio = ".$_GET["PagoProveedorAsistio"]." WHERE Codigo = ".$_GET["Codigo"];
	$Result1 = $mysqli->query($SQL); 
  if($Result1) 
  		echo $SQL;
}


// SQL Generico 
if (isset($_GET['t']) and isset($_GET['cam']) and isset($_GET['val']) and isset($_GET['obj']) and isset($_GET['valobj']) ) {
	$t = $_GET['t'];
	$cam = $_GET['cam'];
	$val = $_GET['val'];
	$obj = $_GET['obj'];
	$valobj = $_GET['valobj'];
	// t=&cam=&val=&obj=&valobj=
	  $sql = "UPDATE $t SET $cam = '$val' WHERE  $obj = '$valobj' ";
	  
	  //$Result1 = mysql_query($sql, $bd) or die(mysql_error()); 
	
	  //if($Result1) 
	  	echo "$sql";
}


if (isset($_GET['EliminaAdelantosFideicomiso'])) {
	$sql = "SELECT MAX(Lote) AS MaxLote FROM Empleado_Pago
			WHERE Concepto = '-Fideicomiso'
			AND Status = 'Eje'";
	$Result1 = $mysqli->query($sql); 
	$rowMaxLote = $Result1->fetch_assoc();
	$MaxLote = $rowMaxLote['MaxLote']+1;	
		
	$sql = "UPDATE Empleado_Pago
			SET Status='Eje',
			Lote = '$MaxLote'
			WHERE Status='PP'";
	$Result1 = $mysqli->query($sql); 
	if($Result1) 
		echo $sql;
}



?>
</body>
</html>