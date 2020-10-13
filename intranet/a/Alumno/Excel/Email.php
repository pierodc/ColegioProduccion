<?php 
$MM_authorizedUsers = "91,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 

// $FechaObjAntiguedad = "2017-09-30";

$export_file = "xlsfile://tmp/Email_Alumno.csv";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: text/csv");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );


$Alumno = new Alumno();
$AlumnoXCurso = new AlumnoXCurso();
$Curso = new Curso();


$Alumnos = $AlumnoXCurso->all("Fecha_Inscrito DESC, Nombres, Apellidos");

/*
echo "<pre>";	
var_dump($Alumnos);
echo "</pre>";	
*/


?>
First Name,Last Name,Email Address,Password,Password Hash Function,Org Unit Path
<?php 

while ($row = $Alumnos->fetch_assoc()) {
	extract($row);
	
	if ($Fecha_Inscrito_Anterior > "" and $Fecha_Inscrito_Anterior != $Fecha_Inscrito){
		echo "$Fecha_Inscrit\r\n";
	}
	
	$Alumno->id = $CodigoAlumno;
	
	
	//echo ++$no . ' ' .  $Alumno->id;
	echo noAcentos($Alumno->Nombre()) .",";
	echo noAcentos($Alumno->Apellido()) .",";
	
	
	
	if($Alumno->Email() > ""){
		echo $Alumno->Email().",";
	}
	else{
		$Usuario = noAcentos($Alumno->Nombre()).noAcentos($Alumno->Apellido());
		$Usuario = str_replace(" ","",$Usuario);
		echo $Usuario."@colegiosanfrancisco.com" .",";
	}
	
	
	
	echo str_replace("-","",DDMMAAAA($Alumno->FechaNac())."sfa") .",,";
	
	
	
	echo "/Alumno/";
		
	$NivelCurso = NivelCurso($CodigoCurso);

	if($NivelCurso < 20)
		echo "Preescolar";
	elseif($NivelCurso < 30)
		echo "Primaria";
	elseif($NivelCurso < 46)
		echo "Bachillerato";
	else
		echo "--- INDEFINIDO --- $NivelCurso ".$CodigoCurso;


	echo "/";

	$Curso->id = $CodigoCurso;


	echo $Curso->Curso($CodigoCurso) ."";
	
	
	//echo $Fecha_Inscrito;
	
	echo "\r\n";
	
	$Fecha_Inscrito_Anterior = $Fecha_Inscrito;
	
	}
	