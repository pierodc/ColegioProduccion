<?php
$MM_authorizedUsers = "99,91,95,90,secreAcad,AsistDireccion";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 

$export_file = "xlsfile://tmp/ListaSeguro.xls";


$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$ArchivoDe = "Seguro";
$NombreArchivo = $ArchivoDe.'_'.date('Y').'_'.date('m').'_'.date('d').'.csv';

header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename='.$NombreArchivo); 
header('Pragma: public'); 

$FechaObj = date('Y').'-09-30'; //Para calculo de edad

// Asigna CedulaSeguro
$mysqli->query("UPDATE Alumno SET CedulaSeguro = Cedula , CedulaSeguroLetra = CedulaLetra");

if(isset($_GET["CodigoCurso"])){
	
	$add_sql = " AND AlumnoXCurso.CodigoCurso = '".$_GET["CodigoCurso"]."' ";
	
}

$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso
					WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
					AND AlumnoXCurso.Ano = '$AnoEscolar' 
					AND AlumnoXCurso.Status = 'Inscrito' 
					AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp' 
					$add_sql
					ORDER BY AlumnoXCurso.CodigoCurso, Alumno.Apellidos, Alumno.Apellidos2
					 ";
					 
					 
					 //AND (AlumnoXCurso.CodigoCurso = 43 or AlumnoXCurso.CodigoCurso = 44)
					 //ORDER BY Alumno.CedulaSeguro
$RS_Alumno = $mysqli->query($query_RS_Alumno);

while($row_RS_Alumno = $RS_Alumno->fetch_assoc()){ 
	extract($row_RS_Alumno);
	if ($Cedula < 50000000) 
		$CedulaLetraSeguro = $CedulaLetra;
	else 
		$CedulaSeguroLetra = "M";
		
	$CedulaSeguro = substr($Cedula,-8)*1;	
	// quita los ceros derecha del numero
	$sql = "UPDATE Alumno SET 
			CedulaSeguro = '$CedulaSeguro', 
			CedulaSeguroLetra = '$CedulaSeguroLetra'
			WHERE CodigoAlumno = '$CodigoAlumno'"; 
	$mysqli->query($sql);
}



$RS_Alumno = $mysqli->query($query_RS_Alumno);
while($row_RS_Alumno = $RS_Alumno->fetch_assoc()){ 
	extract($row_RS_Alumno);
	$query_RS_Hermanos = "SELECT * FROM Alumno, AlumnoXCurso
						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
						AND AlumnoXCurso.Ano = '$AnoEscolar' 
						AND AlumnoXCurso.Status = 'Inscrito' 
						AND AlumnoXCurso.Tipo_Inscripcion <> 'Mp' 
						AND Alumno.CedulaSeguro = '$CedulaSeguro'
						ORDER BY Alumno.CedulaSeguro, Alumno.FechaNac DESC";
	//echo $query_RS_Hermanos."<BR>";				
	$RS_Hermanos = $mysqli->query($query_RS_Hermanos);
	$NumHermanos = $RS_Hermanos->num_rows;
	
	if ($NumHermanos > 1){ // Asigna Numeral
		//echo "<BR><BR> ASIGNA LITERAL<BR>";
		$CedulaSeguro = $row_RS_Alumno['CedulaSeguro'] * 10;
		$RS_Familia = $mysqli->query($query_RS_Hermanos);
		while($row_ = $RS_Familia->fetch_assoc()){ 
			$CedulaSeguro++;
			$sql = "UPDATE Alumno SET CedulaSeguro = '$CedulaSeguro' 
					WHERE CodigoAlumno = '".$row_['CodigoAlumno']."'";
			//echo $sql.'<br><br>';
			$mysqli->query($sql);
			}
		
		
		
		}
	
}






while(false and $row_RS_Alumno = $RS_Alumno->fetch_assoc()){ 
	extract($row_RS_Alumno);
	$Ced_base = $CedSeguro = substr($Cedula,-8)*1; 
	
	// Asigna terminal 1,2,3 a cedula de madre para menor
	if(strlen($Cedula) > 8){
		$H_No = substr_count($Ced_Menores,$Ced_base)+1;
		$Ced_Menores .= ' '.$Ced_base.$H_No;
		$CedSeguro = $Ced_base.$H_No;
		}
	
	$sql = "UPDATE Alumno SET CedulaSeguro = '$CedSeguro' WHERE CodigoAlumno = '$CodigoAlumno'";
	$mysqli->query($sql);
	//echo $sql.'<br>';
}

if(isset($_GET['Asegura_hoy'])){
		
	$UPDATE_Asegura = "UPDATE AlumnoXCurso
						SET Fecha_Seguro = ''";
	$mysqli->query($UPDATE_Asegura);
		
	$UPDATE_Asegura = "UPDATE AlumnoXCurso
						SET Fecha_Seguro = '".date('Y-m-d')."'
						WHERE Ano = '$AnoEscolar' 
						AND Status = 'Inscrito' 
						AND Tipo_Inscripcion <> 'Mp'
						AND CodigoAlumno < 20000";
	$mysqli->query($UPDATE_Asegura);
}









	
print "No,TipoCedula,Cedula,Apellido,Apellido2,Nombre,Nombre2, Fecha N.,Edad,Sexo,FechaSeguro\r\n";
$RS_Alumno = $mysqli->query($query_RS_Alumno);
//echo $RS_Alumno->num_rows;
while($row_RS_Alumno = $RS_Alumno->fetch_assoc()){ 
	extract($row_RS_Alumno);

	print ++$No.",";
	
	if ($Cedula < 50000000)	
		$TipoCedula = $CedulaLetra;
	else
		$TipoCedula = "M";
	
	
	
	print $TipoCedula;
	print ""; 
	print $CedulaSeguro;
	print ","; 
	
	print strtoupper(NoAcentos($Apellidos." ".$Apellidos2." ".$Nombres." ".$Nombres2));
	print ","; 
	print $EntidadCorta.","; 
	print $Localidad.","; 
	print substr($FechaNac,8,2);
	print ","; 
	print substr($FechaNac,5,2);
	print ","; 
	print substr($FechaNac,0,4);
	print ","; 
	
	
	
	/*
	print $TipoCedula;
	print ","; 
	print $CedulaSeguro;
	print ","; 
	
	print strtoupper(NoAcentos($Apellidos.",".$Apellidos2.",".$Nombres.",".$Nombres2));
	print ","; 

	print substr($FechaNac,8,2);
	print ","; 
	print substr($FechaNac,5,2);
	print ","; 
	print substr($FechaNac,0,4);
	print ","; 
	
	print Edad($FechaNac).","; 
	print $Sexo.","; 
	
	print $EntidadCorta.","; 
	print $Localidad.","; 
	*/
	
	print "\r\n";

}


        