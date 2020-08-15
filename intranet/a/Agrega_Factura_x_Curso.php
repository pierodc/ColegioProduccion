<?php 
require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Agrega Factura a un curso</title>
</head>

<body>
<?php 	 
mysql_select_db($database_bd, $bd);

$Insp = false;

$CodigoCurso = "-1";
if (isset($_POST['CodigoAsignacion'])) {
					
	$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);	
	echo " <br><br>$totalRows_RS_Alumnos ".$query_RS_Alumno." <br><br>";
		
	$CodigoAsignacion = $_POST['CodigoAsignacion'];
	
	$sql = "SELECT * FROM Asignacion WHERE Codigo = '$CodigoAsignacion'";
	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
	$row_RS_sql = mysql_fetch_assoc($RS_sql);
	$MontoDebe = $row_RS_sql['Monto'];
	$Descripcion = $row_RS_sql['Descripcion'];
		
	do {	
	$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];
	
	$_sql = "SELECT * FROM ContableMov 
				WHERE CodigoPropietario = ".$CodigoAlumno." 
				AND Referencia = '$CodigoAsignacion'
				AND Fecha >= '".$Ano1."-09-01'";
	$_RS = mysql_query($_sql, $bd) or die(mysql_error());
	$_row_RS = mysql_fetch_assoc($_RS);
	$_totalRows = mysql_num_rows($_RS); 
	echo "<br>$_totalRows ".$_sql.' ';
	if($_totalRows == 0 and !$Insp){
		
			$FechaIngreso = $Ano1.'-09-25';
			
			$sql2 = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, Descripcion, MontoDebe) VALUES ";
			$sql2.= "( $CodigoAlumno, '$FechaIngreso', '$FechaIngreso', 1, 'sys', ";
			$sql2.= "'".$CodigoAsignacion."', '$Descripcion', '$MontoDebe'   ";
			$sql2.= ") ";
			$sql2.= "";
			$RS_sql = mysql_query($sql2, $bd) or die(mysql_error());
			echo " <br>".$RS_sql.' '.$sql2 ;
		
		
		}
	} while($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos));
}


?>
<form id="form1" name="form1" method="post" action="">

  <p>&nbsp;  </p>
  <p>
    <select name="CodigoAsignacion" id="CodigoAsignacion">
      <option value="">Seleccione...</option>
      <?php
mysql_select_db($database_bd, $bd);
$query_RS_Asignaciones_Curso = "SELECT * FROM Asignacion WHERE Periodo = 'E' AND CodigoCurso = 0 AND SWActiva=1 ORDER BY Descripcion";
$RS_Asignaciones_Curso = mysql_query($query_RS_Asignaciones_Curso, $bd) or die(mysql_error());
$row_RS_Asignaciones_Curso = mysql_fetch_assoc($RS_Asignaciones_Curso);
$totalRows_RS_Asignaciones_Curso = mysql_num_rows($RS_Asignaciones_Curso);
					
do {  
?>
      <option value="<?php echo $row_RS_Asignaciones_Curso['Codigo']?>" <?php if($_POST['CodigoAsignacion']==$row_RS_Asignaciones_Curso['Codigo']) echo 'selected="selected"'; ?>><?php echo $row_RS_Asignaciones_Curso['Descripcion']?> <?php echo $row_RS_Asignaciones_Curso['Monto']?></option>
      <?php
} while ($row_RS_Asignaciones_Curso = mysql_fetch_assoc($RS_Asignaciones_Curso));
  $rows = mysql_num_rows($RS_Asignaciones_Curso);
  if($rows > 0) {
      mysql_data_seek($RS_Asignaciones_Curso, 0);
	  $row_RS_Asignaciones_Curso = mysql_fetch_assoc($RS_Asignaciones_Curso);
  }
?>
    </select>
    
    <?php 
$query_RS_Cursos = "SELECT * FROM Curso WHERE SW_activo = 1 ORDER BY NivelMencion, Curso.Curso, Curso.Seccion";
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);
?>          
    
    <select name="CodigoCurso">
      <option value="">Seleccione...</option>
      <?php 
do {  
?>
      <option value="<?php echo $row_RS_Cursos['CodigoCurso']?>" <?php if($_POST['CodigoCurso']==$row_RS_Cursos['CodigoCurso']) echo 'selected="selected"'; ?>>
      <?php
				  echo $row_RS_Cursos['NombreCompleto']?>
      </option>
      <?php 
} while ($row_RS_Cursos = mysql_fetch_assoc($RS_Cursos));
?>
    </select>
    <input type="submit" name="button" id="button" value="Submit" />
  </p>
  <p>&nbsp;</p>
</form>
</body>
</html>