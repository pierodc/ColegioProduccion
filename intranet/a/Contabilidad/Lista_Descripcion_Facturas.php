<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
mysql_select_db($database_bd, $bd);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>

  <?php 
if(isset($_POST['Descripcion'])){
	$sql = "SELECT *  FROM ContableMov, Alumno, AlumnoXCurso, Curso WHERE 
			ContableMov.CodigoPropietario = Alumno.CodigoAlumno AND 
			Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno AND
			AlumnoXCurso.Ano = '$AnoEscolar' AND
			AlumnoXCurso.CodigoCurso = Curso.CodigoCurso AND
			ContableMov.Descripcion = '".$_POST['Descripcion']."'
			GROUP BY Alumno.CodigoAlumno 
			ORDER BY Curso.NivelCurso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2  ";
	//eko( $sql);
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
?><?php echo $_POST['Descripcion'] ?>
<table width="800">
  <tr>
    <td>&nbsp;No</td>
    <td>&nbsp;CodigoPropietario</td>
    <td>&nbsp;Apellidos</td>
    <td>&nbsp;MontoDebe</td>
    <td>&nbsp;SWCancelado</td>
    <td>&nbsp;</td>
  </tr>
<?php 	do{ 
		extract($row);

?>  
  <tr>
    <td>&nbsp;<?php echo ++$No ?></td>
    <td>&nbsp;<?php echo $CodigoPropietario ?></td>
    <td>&nbsp;<?php echo $Apellidos.' '.$Nombres ?></td>
    <td>&nbsp;<?php echo $MontoDebe ?></td>
    <td>&nbsp;<?php echo $SWCancelado ?></td>
    <td>&nbsp;<?php echo '' ?></td>
  </tr>
<?php }while ($row = mysql_fetch_assoc($RS));	?>
</table>
<?php } ?>
<p>&nbsp; </p>
<form id="form1" name="form1" method="post" action="">
  <label for="Descripcion"></label>
  <input name="Descripcion" type="text" id="Descripcion" value="<?php echo $_POST['Descripcion'] ?>" />
  <input type="submit" name="button" id="button" value="Buscar" />
</form>
</body>
</html>