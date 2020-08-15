<?php
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php 
$sql="SELECT * FROM Alumno , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar'  
		AND AlumnoXCurso.Tipo_Inscripcion  = 'Rg'
		AND AlumnoXCurso.Status = 'Inscrito' 
		ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2";
$RS = mysql_query($sql, $bd) or die(mysql_error());
$row = mysql_fetch_assoc($RS);

do{
	extract($row);
	if($Creador_Anterior != $Creador){
	
	
?>   <tr>
    <td colspan="5" bgcolor="#CCCCCC">Familia: <?php echo $CodigoFamilia ?></td>
    <td colspan="5" align="right" bgcolor="#CCCCCC">&nbsp;<?php echo $Creador ?></td>
    </tr>
<?php } ?> 
  <tr>
    <td nowrap="nowrap">&nbsp;<?php echo ++$k;1 ?></td>
    <td nowrap="nowrap">&nbsp;<?php echo $Apellidos .' '. $Apellidos2 .' '. $Nombres .' '. substr($Nombres2,0,1).' '. $CodigoAlumno ?></td>
    <td nowrap="nowrap">&nbsp;<?php 
				$nombreFoto = '../../../'. $AnoEscolar.'/'.$CodigoAlumno.'.jpg';
				if (!file_exists($nombreFoto)) { 
					$nombreFoto = '../../../'. $AnoEscolarAnte.'/'.$CodigoAlumno.'.jpg';
				}
				?><img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;<?php $nombreFoto = '../../Foto_Repre/'. $CodigoAlumno.'p.jpg';?>
    <img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;<?php $nombreFoto = '../../Foto_Repre/'. $CodigoAlumno.'m.jpg'; ?>
    <img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;<?php $nombreFoto = '../../Foto_Repre/'. $CodigoAlumno.'a1.jpg';?>
    <img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;<?php $nombreFoto = '../../Foto_Repre/'. $CodigoAlumno.'a2.jpg';?>
    <img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;<?php $nombreFoto = '../../Foto_Repre/'. $CodigoAlumno.'a3.jpg';?>
    <img src="<?php echo $nombreFoto ?>" alt="" width="100" height="150" border="0" /></td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
<?php 
$Creador_Anterior = strtolower($Creador);
}while ($row = mysql_fetch_assoc($RS));		  
?>  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>