<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../inc/fpdf.php');
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

if(date('d') <= '15')
	$Descripcion = "1ra";
else
	$Descripcion = "2da";

$Nombre = 'Nomina_'.date('Y').'_'.date('m').'_'.$Descripcion.'.txt';
$Descripcion = $Descripcion.Mes(date('m'))." ".date('Y');

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$Nombre.''); 
header('Pragma: public'); 


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE SW_activo = 1 
						AND FormaDePago = 'T' 
						AND MontoUltimoPago > 0
						ORDER BY Apellidos, Nombres";
$RS_Empleados = $mysqli->query($query_RS_Empleados);
while($row_Empleados = $RS_Empleados->fetch_assoc()){

	$MontoTotal += $row_Empleados['MontoUltimoPago'];
	$nEmp++;

}
$MontoTotal = round($MontoTotal*100 , 0);
$MontoTotal = substr('000000000000000'.$MontoTotal , -15);
;
$nEmp = substr('00000'.$nEmp , -5);

$Descripcion = substr($Descripcion.'               ' , 0 , 20);

print "00800089J0001370234";
print $Descripcion; // Descripcion
print "000000000000001105";
print "VEF8079037183"; 
print $MontoTotal; //Monto Total
print $nEmp; //Num Empleados
print date('Ymd'); // Fecha
print "\r\n";


$RS_Empleados = $mysqli->query($query_RS_Empleados);
while($row_Empleados = $RS_Empleados->fetch_assoc()){
		
	print '01'.$row_Empleados['CedulaLetra'] . substr('000000000000'.$row_Empleados['Cedula'],-10);
	print substr($row_Empleados['Apellidos'].' '.$row_Empleados['Nombres'].'                                                           ',0,60);
	print '1105'.$row_Empleados['NumCuenta'];
	$Monto = round($row_Empleados['MontoUltimoPago']*100 , 0);
	$Monto = '000000000000000'.$Monto;
	print substr($Monto,-15);
	print substr($Monto,-15);
	print "\r\n"; //Datos Empleados
	
	}

?>