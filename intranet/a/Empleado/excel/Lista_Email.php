<?php 
$MM_authorizedUsers = "91,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 

// $FechaObjAntiguedad = "2017-09-30";

$export_file = "xlsfile://tmp/example.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );





?>
First Name,Last Name,Email Address,Password,Password Hash Function,Org Unit Path
<?php 


$sql = "SELECT * FROM Empleado 
		WHERE SW_activo = '1'
		ORDER BY TipoEmpleado, TipoDocente, Apellidos, Apellido2, Nombres, Nombre2";
$RS = $mysqli->query($sql);
// Ejecuta $sql y While
while ($row = $RS->fetch_assoc()) {
	extract($row);

	
	//First Name,Last Name,Email Address,Password,Password Hash Function,Org Unit Path
	
	
	echo ucfirst("$Nombres") .","; //First Name,
	echo ucfirst("$Apellidos") .","; //Last Name
	
	echo str_replace(" ","",noAcentos(strtolower($Nombres.$Apellidos))."@colegiosanfrancisco.com" ."," ) ; //Email Address
    
	
	//echo $Cedula."sfa" .","; //Password
	echo "****" .","; //Password
	
	
	echo "" .",";//Password Hash Function
	echo "";//Org Unit Path

	if($TipoEmpleado == "2. Docente"){
		echo "/Docente";
		
		
		$TipoDocente = substr($TipoDocente , 0 , 3);
		if($TipoDocente == "5. "){
			echo "/Bachillerato";
		}
		elseif($TipoDocente == "6.1" or $TipoDocente == "7. "){
			echo "/Preescolar";
		}
		elseif($TipoDocente == "6.3"){
			echo "/Primaria";
		}
		elseif($TipoDocente == "6.4"){ // especialista
			echo "";
		}

		echo $TipoDocente;
	
	}
	
	echo "\r\n";
	
}

?>