<?php require_once('../../Connections/bd.php'); ?>
<?php require_once('../../inc/rutinas.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_bd, $bd);
$query_RS_Alumnos = "SELECT * FROM AlumnoXCurso WHERE SWinscrito = '1'";

//Activa para crear año nuevo
//$query_ = "INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status)  ( SELECT CodigoAlumno, CodigoCurso, '$AnoEscolar', 'Inscrito' FROM Alumno WHERE SWinscrito = '1')";

//Activa para crear año nuevo MATERIA PENDIENTE
//$query_RS_Alumnos = "INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status )   
//( SELECT CodigoAlumno, CodigoCursoAnteAno, '".$AnoEscolar."', 'MatPendienteEnero' FROM Alumno WHERE EscolaridadTipo = 'RgMp' AND SWinscrito = '1')";

//echo $query_RS_Alumnos;

//Activa para ejecutar
//$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());

//$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
//$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);

if(1==1){ // inicio de año escolar
$query_RS_Alumnos = "DELETE FROM AlumnoXCurso WHERE Ano = '$AnoEscolar'";
echo $query_RS_Alumnos.'<br>';
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());

$query_RS_Alumnos = "SELECT * FROM Alumno WHERE SW_pre_inscrito = '1' order by CodigoAlumno";
echo $query_RS_Alumnos.'<br>';


//$query_RS_Alumnos = "SELECT * FROM Alumno WHERE SWinscritoAnoAnte = '1' order by CodigoAlumno";



$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS_Alumnos);

do{
	$CodigoCurso = max($row['CodigoCurso'] , $row['CodigoCursoProxAno']);
	$sql= "SELECT * FROM Curso WHERE CodigoCursoAnteAno = '".$row['CodigoCurso']."' ";
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_curso =  mysql_fetch_assoc($RS);
	
	if($row['CodigoCurso']==0) {
		$CodigoCurso = $row['CodigoCursoProxAno'];}
		else{	
		$CodigoCurso = $row_curso['CodigoCurso']; }
	if($row['SWinscritoAnoAnte']==0){
		$CodigoCurso = $row['CodigoCursoProxAno'];}	
		
	
	echo '<br>'.$row['CodigoAlumno'].' ins:'.$row['SWinscrito'].' ante:'.$row['SWinscritoAnoAnte'].' .: '.$row['CodigoCurso'].'->'.$CodigoCurso;
	
//Activa para crear año nuevo
$query_ = "INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status)  VALUES ( '".$row['CodigoAlumno']."', '$CodigoCurso', '$AnoEscolar', 'Inscrito')";
//$query_ = "INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status)  VALUES ( '".$row['CodigoAlumno']."', '".$row['CodigoCursoAnteAno']."', '$AnoEscolar', 'Inscrito')";

//Activa para ejecutar
//$RS_ = mysql_query($query_, $bd) or die(mysql_error());
	
	echo $query_;
	
	} while ($row = mysql_fetch_assoc($RS_Alumnos));

}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($RS_Alumnos);
?>
