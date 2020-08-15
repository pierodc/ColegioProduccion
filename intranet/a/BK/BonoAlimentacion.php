<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../inc/fpdf.php');
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$aaaa_mm_dd_obj = $Ano.'-'.$Mes.'-01';

$Nombre = 'BonoAlim_'.$Ano.'_'.$Mes.'_'.$Descripcion.'.txt';
$Descripcion = $Descripcion.Mes($Mes)." ".$Ano;

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$Nombre.''); 
header('Pragma: public'); 



$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
						SW_activo=1 AND 
						SW_cestaT='1' 
						ORDER BY PaginaCT, Apellidos, Nombres ASC";
$RS_Empleados = $mysqli->query($query_RS_Empleados);
while($row_Empleados = $RS_Empleados->fetch_assoc()){
	$DiasLaborables = DiasLaborables( $aaaa_mm_dd_obj , $row_Empleados['DiasSemana']);
	$DiasBono = $DiasLaborables - $row_Empleados['DiasInasistencia'];
	$Bono = round($DiasBono * $row_Empleados['MontoCestaT'] + $row_Empleados['BonifAdicCT'],2);
	$MontoTotal += $Bono;
	$nEmp++;
}
$MontoTotal = round($MontoTotal*100 , 0);
$MontoTotal = substr('00000000000000000000'.$MontoTotal , -18);

$nEmp = substr('00000'.$nEmp , -5);

$NumLote = $Ano.''.$Mes.'01';

//0 12013101 J-00137023-4   00094 2 20120131 000000000003446064
print "0";
print $NumLote;
print "J-00137023-4   ";
print $nEmp; //Num Empleados
print "2"; 
print date('Ymd'); // Fecha
print $MontoTotal; //Monto Total
print "\r\n";

//2120131016817759        000000000000038912
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$row_Empleados = $RS_Empleados->fetch_assoc();
do{
	print '2';
	print $NumLote;
	print substr($row_Empleados['Cedula'].'                    ',0,15);
	
	$DiasLaborables = DiasLaborables( $aaaa_mm_dd_obj , $row_Empleados['DiasSemana']);
	$DiasBono = $DiasLaborables - $row_Empleados['DiasInasistencia'];
	$Bono = round($DiasBono * $row_Empleados['MontoCestaT'] + $row_Empleados['BonifAdicCT'],2);

	$Monto = round($Bono*100 , 0);
	$Monto = '000000000000000'.$Monto;
	print substr($Monto,-18);
	
	if($row_Empleados = $RS_Empleados->fetch_assoc())
		print "\r\n"; //Datos Empleados
	}while($row_Empleados);

?>