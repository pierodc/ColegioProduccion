<?
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
$Cursos = new Curso;


require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 


?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<table>
  <tbody>
    <tr>
      <th scope="col">Curso</th>
      <th scope="col">Envia</th>
    </tr>
<? 

foreach ($Cursos->view_all() as $Clave => $Valor){
	/*
	$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Alumno , Curso
					WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
					AND AlumnoXCurso.Ano = '$AnoEscolar' 
					AND AlumnoXCurso.Status = 'Inscrito'
					AND AlumnoXCurso.CodigoCurso =  '".$Valor['CodigoCurso']."'";
	//echo $query_RS_Alumno;
	$RS_Alumno = $mysqli->query($query_RS_Alumno);
	while ($row_RS_Alumno = $RS_Alumno->fetch_assoc()) {
		ActulizaEdoCuentaDolar($row_RS_Alumno['CodigoAlumno'] , $CambioDolar);
		$DeudaCurso += $row_RS_Alumno['Deuda_Actual'];
	}
	*/
	
	
	?>
	   <tr>
      <th scope="row">
      <? echo $Valor['NombreCompleto']; ?><br>
      <? //echo $Cambio_Dolar . $DeudaCurso; $DeudaCurso = 0; ?>
      </th>
      <td><iframe src="Aviso_de_Cobro_Email.php?porCurso=1&<?php echo "CodigoCurso=".$Valor['CodigoCurso']; ?>" width="200" height="65" scrolling="no" frameborder="0" seamless></iframe></td>
    </tr>
<?
	
	}

 ?>
  </tbody>
</table>

	
</body>
</html>