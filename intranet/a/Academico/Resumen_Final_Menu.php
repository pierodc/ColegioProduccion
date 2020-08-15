<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php'); 

mysql_select_db($database_bd, $bd);
$query_RS_Tit = "SELECT * FROM AlumnoXCurso, Alumno WHERE 
					AlumnoXCurso.FechaGrado = 'Julio20".$Ano2."' AND 
					AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno AND
					AlumnoXCurso.Tipo_Inscripcion = 'Rg' 
					ORDER BY AlumnoXCurso.CodigoCurso, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC";

$RS_Tit = mysql_query($query_RS_Tit, $bd) or die(mysql_error());
$row_RS_Tit = mysql_fetch_assoc($RS_Tit);
$totalRows_RS_Tit = mysql_num_rows($RS_Tit);

$query_RS_TitR = "SELECT * FROM AlumnoXCurso, Alumno WHERE 
					AlumnoXCurso.FechaGrado = 'Julio20".$Ano2."R' AND 
					AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					ORDER BY AlumnoXCurso.CodigoCurso, Alumno.CedulaLetra DESC, Alumno.Cedula_int ASC";
$RS_TitR = mysql_query($query_RS_TitR, $bd) or die(mysql_error());
$row_RS_TitR = mysql_fetch_assoc($RS_TitR);
$totalRows_RS_TitR = mysql_num_rows($RS_TitR);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>" target="_blank">Resumen Final Bachillerato</a> (Colocar &quot;N&quot; en las materias que no cursan los repitientes en la pantalla &quot;Revision de Definitiva&quot; o &quot;RevDef&quot;)</p>
<p><a href="PDF/Resumen_Final_Prim.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar ?>" target="_blank">Resumen Final Primaria (<?php echo $AnoEscolar; ?>)</a> / <a href="PDF/Resumen_Final_Prim.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a></p>
<p><a href="PDF/Resumen_Final_Pree.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar ?>" target="_blank">Resumen Final Preescolar (<?php echo $AnoEscolar; ?>)</a> / <a href="PDF/Resumen_Final_Pree.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank">(<?php echo $AnoEscolarAnte; ?>)</a></p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=Revision" target="_blank">Revision</a> (Colocar las notas en la pantalla Notas-Revision)</p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=MatPendiente&Momento=M01" target="_blank">Materia Pendiente Momento 1</a></p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=MatPendiente&Momento=M02" target="_blank">Materia Pendiente Momento 2</a></p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=MatPendiente&Momento=M03" target="_blank">Materia Pendiente Momento 3</a></p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=MatPendiente&Momento=M04" target="_blank">Materia Pendiente Momento 4</a></p>
<p><a href="PDF/Resumen_Final_Bach.php?CodigoCurso=&AnoEscolar=<?php echo $AnoEscolar; ?>&TipoEvaluacion=Equivalencia" target="_blank">Equivalencia</a></p>
<p><a href="Cursos_Mantenimiento.php">Profesores del curso</a></p>

<table width="800" border="1">
  <tr>
    <td width="50%" valign="top"><a href="PDF/Registro_Titulos.php">Registro de Titulos</a></td>
    <td width="50%" rowspan="2" valign="top"><a href="PDF/Titulo_Bachiller.php?Revision=1" target="_blank">T&iacute;tulos Bachiller - Revisi&oacute;n</a></td>
  </tr>
  <tr>
    <td valign="top"><a href="PDF/Titulo_Bachiller.php" target="_blank">T&iacute;tulos Bachiller</a></td>
  </tr>
  <tr>
    <td valign="top"><?php do { ?>
        <a href="PDF/Titulo_Bachiller.php?CodigoAlumno=<?php echo $row_RS_Tit['CodigoAlumno']; ?>" target="_blank">
		<?php echo ++$No.') '.$row_RS_Tit['Apellidos'].' '.$row_RS_Tit['Apellidos2'].' '.$row_RS_Tit['Nombres'].' '.$row_RS_Tit['Nombres2']; ?><br>
        </a>
<?php } while ($row_RS_Tit = mysql_fetch_assoc($RS_Tit)); ?></td>
    <td valign="top"><?php do { ?>
        <a href="PDF/Titulo_Bachiller.php?CodigoAlumno=<?php echo $row_RS_TitR['CodigoAlumno']; ?>&Revision=1" target="_blank"><?php echo $row_RS_TitR['Apellidos']; ?> <?php echo $row_RS_TitR['Apellidos2']; ?> <?php echo $row_RS_TitR['Nombres']; ?> <?php echo $row_RS_TitR['Nombres2']; ?></a><br>
    <?php } while ($row_RS_TitR = mysql_fetch_assoc($RS_TitR)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($RS_Tit);
?>
