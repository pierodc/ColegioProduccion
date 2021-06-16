<?php

$MesNum = array(1=>'01',2=>'02',3=>'03',4=>'04',5=>'05',6=>'06',7=>'07',8=>'08',9=>'09',10=>'10',11=>'11',12=>'12');
$MesNom = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');


$ReferenciaMesAno_array = array(
0=>'08-'.$Ano1,
1=>'09-'.$Ano1,
2=>'10-'.$Ano1,
3=>'11-'.$Ano1,
4=>'12-'.$Ano1,
5=>'01-'.$Ano2,
6=>'02-'.$Ano2,
7=>'03-'.$Ano2,
8=>'04-'.$Ano2,
9=>'05-'.$Ano2,
10=>'06-'.$Ano2,
11=>'07-'.$Ano2,
12=>'08-'.$Ano2,
13=>'09-'.$Ano2,
14=>'10-'.$Ano2);



	

$Sec_01_13 = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13');













// SQL generico Alumno INICIO


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . htmlentities($theValue) . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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




$add_SQL = '';
if (isset($_GET['CodigoCurso'])) { 
	$colname .= $_GET['CodigoCurso'];
	$add_SQL = sprintf(' AND AlumnoXCurso.CodigoCurso = %s ', GetSQLValueString($colname, "int"));
										  
	if ($_GET['CodigoCurso']=='Pre'		) $add_SQL .= ' AND Curso.NivelCurso >=11 AND Curso.NivelCurso <=14 ' ;
	if ($_GET['CodigoCurso']=='Pri'		) $add_SQL .= ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=26 ' ;
	if ($_GET['CodigoCurso']=='Pri123'	) $add_SQL .= ' AND Curso.NivelCurso >=21 AND Curso.NivelCurso <=23 ' ;
	if ($_GET['CodigoCurso']=='Pri456'	) $add_SQL .= ' AND Curso.NivelCurso >=24 AND Curso.NivelCurso <=26 ' ;
	if ($_GET['CodigoCurso']=='Bach'		) $add_SQL .= ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=45 ' ;
	if ($_GET['CodigoCurso']=='Bach123'	) $add_SQL .= ' AND Curso.NivelCurso >=31 AND Curso.NivelCurso <=33 ' ;
	if ($_GET['CodigoCurso']=='Bach45' or $CodigoCurso=='Bach45' ) $add_SQL .= ' AND Curso.NivelCurso >=44 AND Curso.NivelCurso <=45 ' ;
}

if (isset($_POST['CodigoCurso'])		) $add_SQL .= " AND AlumnoXCurso.CodigoCurso ='".$_POST['CodigoCurso']."' " ;


if (isset($_GET['CodigoAlumno'])) { $colname = $_GET['CodigoAlumno'];
									  $add_SQL .= sprintf(' AND AlumnoXCurso.CodigoAlumno = %s ', GetSQLValueString($colname, "int"));}

if (isset($_GET['Lapso']))
if ( strrpos($_GET['Lapso'] , "mp") > 0) 
									  $add_SQL .= " AND AlumnoXCurso.Tipo_Inscripcion  = 'Mp' " ;
	else
									  $add_SQL .= " AND AlumnoXCurso.Tipo_Inscripcion  <> 'Mp' " ;


if (isset($_GET['CodigoClave']))  { 
		$colname = $_GET['CodigoClave'];
		$add_SQL .= sprintf(' AND Alumno.CodigoClave = %s ', GetSQLValueString($colname, "text"));}

if (isset($_GET['CodigoPropietario']))  { 
		$colname = $_GET['CodigoPropietario'];
		$add_SQL .= sprintf(' AND Alumno.CodigoClave = %s ', GetSQLValueString($colname, "text"));}

if (isset($_GET['Orden'])){
if ($_GET['Orden']=='Cedula' or $_POST['Orden']=='Cedula' or $Orden == 'Cedula') 
		$add_SQL .= ' ORDER BY Alumno.Cedula_int ';
	elseif (isset($_GET['Desde']))
		$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	elseif (isset($_GET['ApellidosNombres']))
		$add_SQL .= ' ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	else
		$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
}
else {
	$add_SQL .= ' ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC ';
	}


if (isset($_GET['LIMIT'])) {
		$add_SQL .= ' LIMIT ' . $_GET['LIMIT']. ' , 1 '; }
									  
if (isset($_GET['Desde']) and isset($_GET['Cantidad'])) {
		$add_SQL .= ' LIMIT ' . $_GET['Desde']. ' , ' . $_GET['Cantidad']. ' '; }
	

$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Alumno , Curso
					WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
					AND AlumnoXCurso.Ano = '$AnoEscolar' 
					AND AlumnoXCurso.Status = 'Inscrito'
					$add_SQL ";
//echo $query_RS_Alumno;					
// SQL generico Alumno FIN 954 817 42 44

?>