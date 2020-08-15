<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 
require_once('archivo/Variables.php');

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body><?php

$CodigoEmpleado = substr($_GET['CodigoEmpleado'],0,3)*1;
$_CodigoFMP = $_GET['CodigoFMP'];
$Fecha = date('Y-m-d');
$DiaSemana = date('N');
$Hora = $_GET['Hora'];
if($CodigoEmpleado > 0){
	//echo date('c');
	$sql = "SELECT * FROM Empleado
			WHERE CodigoEmpleado = '$CodigoEmpleado'
			";
	//echo "$_CodigoFMP ".$sql;		
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	//echo '<br>'.$Nombres.' '.$Apellidos;
	
	$sql = "SELECT * FROM Empleado_EntradaSalida
			WHERE CodigoFMP = '$_CodigoFMP'";	
		
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();

	//echo '<br>'.$sql.$row['Codigo'];
	
	if($row['Codigo'] > 0){
		$sql1 = "UPDATE Empleado_EntradaSalida SET
				CodigoEmpleado = '$CodigoEmpleado',
				Fecha = '$Fecha',
				Hora = '$Hora',
				Obs = 'Asist',
				Registrado_Por = 'php'
				WHERE
				CodigoFMP = $_CodigoFMP'"; }
	else {			
		$sql1 = "INSERT INTO Empleado_EntradaSalida
				(Codigo_Empleado, Fecha, Hora, CodigoFMP, Registrado_Por, DiasSemana) VALUES
				('$CodigoEmpleado', '$Fecha', '$Hora', '$_CodigoFMP', 'php', '$DiaSemana')
				"; }


	$row = $mysqli->query($sql1);
	
	//echo '<br>'.$sql1;

?><img src="../../FotoEmp/150/<?php echo $CodigoEmpleado ?>.jpg" width="100" height="100" /><?php 
}
?></body>
</html>