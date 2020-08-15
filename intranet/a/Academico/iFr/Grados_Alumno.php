<?
$MM_authorizedUsers = "91,95,secreAcad,AsistDireccion";

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

// Cambia CURSO 
if ($_POST['CambiarCurso'] == 1) {
	
	$CodigoAlumno = $_POST['CodigoAlumno'];
	$Ano = $_POST['Ano'];
	$CodigoCurso = $_POST['CodigoCurso'];
	$Status   = "Aceptado";
	
	$sql = "SELECT * FROM AlumnoXCurso 
			WHERE CodigoAlumno = '$CodigoAlumno' 
			AND Ano='$Ano' ";
	$RS_sql = $mysqli->query($sql);
	$totalRows_RS = $RS_sql->num_rows;
	
	if($row = $RS_sql->fetch_assoc()){
		$Status   = $row['Status'];
		$Materias_Cursa   = $row['Materias_Cursa'];
		$Tipo_Inscripcion = $row['Tipo_Inscripcion'];
		$Codigo = $row['Codigo'];
		$sql1 = "UPDATE AlumnoXCurso SET 
				CodigoAlumno = '9999".$CodigoAlumno."' 
				WHERE Codigo = '$Codigo'";
		//echo $sql1."<br>";
	    $mysqli->query($sql1);
		
	}
	
	   $sql2 = "INSERT INTO AlumnoXCurso 
	 				(CodigoAlumno, Status, Ano, CodigoCurso, Materias_Cursa, Status_por )
				VALUES 
					('$CodigoAlumno','$Status','$Ano','$CodigoCurso','$Materias_Cursa',
					'$MM_Username')";				   
	   //echo $sql2."<br>";
	   $mysqli->query($sql2);
		 
 
 }
// fin Cambia CURSO


$query_RS_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

?><form id="form6" name="form6" method="post" action="Grados_Alumno.php?CodigoAlumno=<?php echo $_GET['CodigoAlumno']; ?>">

<?php echo $row_RS_Alumno['CodigoAlumno']; ?>

<?
$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
		AND Ano='$AnoEscolar'"; 
//echo $sql;
$RS_ = $mysqli->query($sql);
$row_Curso_Actual = $RS_->fetch_assoc();
$CodigoCursoActual = $row_Curso_Actual['CodigoCurso'];
	
MenuCurso($CodigoCursoActual,'');
if ($row_Curso_Actual['Status'] == "Solicitando") echo "<b>";
echo $row_Curso_Actual['Status'];
	//echo "$AnoEscolar == $AnoEscolarProx";
	//if($AnoEscolar == $AnoEscolarProx){

	?>
	
	<input name="CodigoAlumno" type="hidden" id="hiddenField" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>" />
	<input name="Ano" type="hidden" id="Ano" value="<?php echo $AnoEscolar; ?>" />
	<input name="CambiarCurso" type="hidden" id="CambiarCurso" value="1" />
    <input type="submit" name="button4" id="button4" value="Cambiar" />
</form>