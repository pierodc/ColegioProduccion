<?php require_once('../../../Connections/bd.php'); ?>
<?php

  mysql_select_db($database_bd, $bd);


$test=false;
$sql = "UPDATE Alumno SET 
  			SWInsCondicional='0',
			SW_Planilla_Impresa='0'"; 

if ((isset($_GET['InicioIns'])) && ($_GET['InicioIns'] == "1")) {
	$Result1 = mysql_query($sql, $bd) or die(mysql_error()); 
}

if($AnoEscolarProx <> $AnoEscolar){
	// Busca los alumnos Inscritos omitiendo 5to año
	$sql2 = "SELECT * FROM AlumnoXCurso WHERE 
				Ano = '$AnoEscolar' AND
				Status = 'Inscrito' AND
				Tipo_Inscripcion = 'Rg' AND
				(CodigoCurso < 43 or
				CodigoCurso > 44)";
	$RS_2 = mysql_query($sql2, $bd) or die(mysql_error());
	$row_RS_2 = mysql_fetch_assoc($RS_2);
	do{
		// Elimina si existe
		$sql3 = "DELETE FROM AlumnoXCurso WHERE
					CodigoAlumno='$row_RS_2[CodigoAlumno]' AND 
					Ano = '$AnoEscolarProx'";
		echo '<br>';			
		echo ++$No.') '.$sql3.'<br>';			
		
//ACTIVAR LA SIGUIENTE LINEA
		//mysql_query($sql3, $bd) or die(mysql_error());
		
		// CREAR
			echo 'Crear<br>';
			$sql_Curso = "SELECT * FROM Curso WHERE
							CodigoCurso='$row_RS_2[CodigoCurso]'";
			$RS_Curso = mysql_query($sql_Curso, $bd) or die(mysql_error());
			$row_RS_Curso = mysql_fetch_assoc($RS_Curso);
			$CodigoCursoProxAno = $row_RS_Curso['CodigoCursoProxAno'];
			
			$sql_Crear = "INSERT INTO AlumnoXCurso 
						(CodigoAlumno, CodigoCurso, Ano, Status, Tipo_Inscripcion, Planilla)
						VALUES
						('$row_RS_2[CodigoAlumno]', '$CodigoCursoProxAno', '$AnoEscolarProx','Aceptado','Rg','Resumen') 
						 ";
			echo $sql_Crear.'<br>';			 
	
//ACTIVAR LA SIGUIENTE LINEA
			//$RS_Crear = mysql_query($sql_Crear, $bd) or die(mysql_error());
			
			
	
	}while ($row_RS_2 = mysql_fetch_assoc($RS_2));
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
        <p><a href="index.php?InicioIns=1">Apertura de inscripciones - Diciembre</a> OJO Respaldar BD</p>
        
        <p><?php echo $sql; ?></p>
</body>
</html>
<?php

?>
