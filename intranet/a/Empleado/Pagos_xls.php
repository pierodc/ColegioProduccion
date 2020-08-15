<?php
//$MM_authorizedUsers = "99,91,95,90,secreAcad,AsistDireccion";
//require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
//require_once '../../../xls/excel.php';

$export_file = "xlsfile://tmp/ListaSeguro.xls";


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$ArchivoDe = "Costo_Personal";
$NombreArchivo = $ArchivoDe.'_'.date('Y').'_'.date('m').'_'.date('d').'.csv';

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$NombreArchivo); 
header('Pragma: public'); 

$Tipos_Empleado = array("1 Docente","2 Directivo","3 Administrativo","4 Obrero");
$Quincenas = array ( array ( "2014 09 1","2014 09 2") ,
						array ( "2014 10 1","2014 10 2") ,
						array ( "2014 11 1","2014 11 2") ,
						array ( "2014 12 1","2014 12 2") ,
						array ( "2015 01 1","2015 01 2") ,
						array ( "2015 02 1","2015 02 2") ,
						array ( "2015 03 1","2015 03 2") ,
						array ( "2015 04 1","2015 04 2") ,
						array ( "2015 05 1","2015 05 2") ,
						array ( "2015 06 1","2015 06 2") ,
						array ( "2015 07 1","2015 07 2") ,
						array (  "2015 08 1","2015 08 2"));
print "Quincena,";
foreach ($Quincenas AS $Quincena){
	print substr($Quincena[0],0,7).",";
}
print "\r\n";

$Conceptos = array("+SueldoBase","-ivss","-spf","-lph");

foreach ($Conceptos AS $Concepto){
	print $Concepto;
	print "\r\n";
	foreach ($Tipos_Empleado AS $Tipo_Empleado){
		print "$Tipo_Empleado,";
		$Tipo_Empleado = substr($Tipo_Empleado,0,1);
		foreach ($Quincenas AS $Quincena){
			$sql = "SELECT * FROM Empleado_Pago, Empleado 
				WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado 
				AND Empleado.TipoEmpleadoContabilidad = '$Tipo_Empleado'
				AND Empleado_Pago.Concepto = '$Concepto'
				AND (Empleado_Pago.Codigo_Quincena = '$Quincena[0]' OR Empleado_Pago.Codigo_Quincena = '$Quincena[1]')
				";
				//echo $sql."<br>";
			$Monto_Sumatoria = 0;
			$RS = $mysqli->query($sql);
			$row = $RS->fetch_assoc();
			do { 
				$Monto_Sumatoria = $Monto_Sumatoria + $row['Monto'];
			} while ($row = $RS->fetch_assoc());
			print $Monto_Sumatoria.",";
			
		}
		print "\r\n";
	}
	print "\r\n";
	print "\r\n";
}        