<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../inc/fpdf.php');
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$Nombre = 'Adelanto_'.date('Y').'_'.date('m').'_'.date('d').'.txt';

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$Nombre.''); 
header('Pragma: public'); 


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$sql = "SELECT * FROM Empleado_Pago, Empleado
		WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Status='PP'";
$RS = mysql_query($sql, $bd) or die(mysql_error());
if($row_Empleados = mysql_fetch_assoc($RS))
	do{
		print '05';
		print date('dmY'); // Fecha
		print '1059876';
		print $row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-9);
		$Monto = round(abs($row_Empleados['Monto'])*100 , 0);
		$Monto = '000000000000000'.$Monto;
		print substr($Monto,-14);
		print '200';
		print $row_Empleados['NumCuenta'];
		print '0000';
		if($row_Empleados = mysql_fetch_assoc($RS))
			print "\r\n"; //Datos Empleados
	}while($row_Empleados);


?>