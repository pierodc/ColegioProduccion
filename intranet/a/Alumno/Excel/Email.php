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

$export_file = "xlsfile://tmp/example.txt";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );


$Alumno = new Alumno();
$AlumnoXCurso = new AlumnoXCurso();
$Curso = new Curso();


$Alumnos = $AlumnoXCurso->all("Fecha_Inscrito DESC");
/*
echo "<pre>";	
var_dump($Alumnos);
echo "</pre>";	
*/


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Lista Curso para Excel</title>
</head>

<body>
<table border="1">
  <tr>
    
    <td align="center">First Name</td>
    <td align="center">Last Name</td>
    <td>Email Address</td>
    <td>Password</td>
    <td>Password Hash Function</td>
    <td>Org Unit Path</td>
  </tr>
<?php 

while ($row = $Alumnos->fetch_assoc()) {
	extract($row);
	$Alumno->id = $CodigoAlumno;
	
	
?>
  <tr>
   <!--td><?php //echo ++$no . ' ' .  $Alumno->id; ?></td-->
    
   
    <td><?php echo noAcentos($Alumno->Nombre()); ?></td>
    <td><?php echo noAcentos($Alumno->Apellido()); ?></td>
    
    
    <td><?php 
	$Usuario = noAcentos($Alumno->Nombre()).noAcentos($Alumno->Apellido());
	
	$Usuario = str_replace(" ","",$Usuario);
				
	echo $Usuario."@colegiosanfrancisco.com" ?></td>
    <td align="right"><?php echo str_replace("-","",DDMMAAAA($Alumno->FechaNac())."sfa"); ?></td>
    
    
    
    
    <td> </td>
    <td>/Alumno/<?php 
		
			
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
		
	
		echo $Curso->Curso($CodigoCurso);
		
		
		?></td>
   
  </tr><?php } ?>
</table>
</body>
</html>