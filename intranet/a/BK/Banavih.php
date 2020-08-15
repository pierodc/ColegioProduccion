<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../inc/fpdf.php');
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 

$Nombre = "N03210013702340204594$Mes$Ano";
$Archivo = 'txt';

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$Nombre.'.'.$Archivo); 
header('Pragma: public'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd); // Mes 03


$query_RS_Empleados = "SELECT * FROM Empleado WHERE 
						SW_lph = '1' AND
						FechaIngreso < '$Ano-$Mes-31' AND 
						(FechaEgreso = '0000-00-00' OR 
						(FechaEgreso >= '$Ano-$Mes-01' AND FechaEgreso < '$Ano-$Mes-31' )  ) AND
						FechaEgreso <> '1950-01-01'
						ORDER BY Apellidos, Nombres ASC";
$RS_Empleados = $mysqli->query($query_RS_Empleados);
if($row_Empleados = $RS_Empleados->fetch_assoc()){
	do{
		// V,14154778,NEREIDA,JULIANA,GARCIA,NOGUERA,327030,11062005,
		print strtoupper($row_Empleados['CedulaLetra']).','.$row_Empleados['Cedula'].',';
		print strtoupper(sinAcento($row_Empleados['Nombres'].','.$row_Empleados['Nombre2']).',');
		print strtoupper(sinAcento($row_Empleados['Apellidos'].','.$row_Empleados['Apellido2']).',');
		
		$sql_Sueldo = "SELECT * FROM Empleado_Pago
						WHERE Codigo_Empleado  = '".$row_Empleados['CodigoEmpleado']."'  AND
						(Codigo_Quincena = '$Ano $Mes 2' OR Codigo_Quincena = '$Ano $Mes 1') AND
						Concepto = '+SueldoBase'";
		$RS_Sueldo = $mysqli->query($sql_Sueldo);
		
		if($row_Sueldo = $RS_Sueldo->fetch_assoc())
			$SueldoBase = round($row_Sueldo['Monto']*200 , 0);
		else 
			$SueldoBase = round($row_Empleados['SueldoBase']*200 , 0);
			
		print $SueldoBase.',';
		
		print DMA_lph($row_Empleados['FechaIngreso']).',';
		
		if($row_Empleados['FechaEgreso'] <> '0000-00-00')
			print DMA_lph($row_Empleados['FechaEgreso']);
		print "\r\n"; 
		
	}while($row_Empleados = $RS_Empleados->fetch_assoc());
}
?>