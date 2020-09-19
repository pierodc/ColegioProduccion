<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 
//echo "aaaa";

$export_file = "xlsfile://tmp/example.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );

if($_GET["AnoEscolar"] > "")
	$AnoEscolar = $_GET["AnoEscolar"];

// Todos
$sql = "SELECT * FROM AlumnoXCurso , Alumno
		WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
		AND Ano = '$AnoEscolar'
		AND Tipo_Inscripcion  <> 'Mp'
		AND Status = 'Inscrito' 
		ORDER BY Alumno.Creador";

// Solo TD		
$sqlTD = "SELECT * FROM Alumno, AsignacionXAlumno, Asignacion , AlumnoXCurso, Curso 
		WHERE Alumno.CodigoAlumno = AsignacionXAlumno.CodigoAlumno 
		AND AsignacionXAlumno.Ano_Escolar ='$AnoEscolar'
		AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo
		AND (AsignacionXAlumno.CodigoAsignacion = 195 OR AsignacionXAlumno.CodigoAsignacion = 196)
		AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
		AND AlumnoXCurso.Ano = '$AnoEscolar' 
		AND AlumnoXCurso.Status = 'Inscrito'
		ORDER BY AsignacionXAlumno.CodigoAsignacion, Curso.NivelCurso, Curso.Seccion, 
				 Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2 ";
	
// Solo BACH	
$sqlBACH = "SELECT * FROM AlumnoXCurso , Alumno , Curso
		WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
		AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
		AND AlumnoXCurso.Ano = '$AnoEscolar'
		AND AlumnoXCurso.Tipo_Inscripcion   <> 'MP'
		AND AlumnoXCurso.Status = 'Inscrito' 
		AND Curso.NivelCurso >= 31
		ORDER BY Curso.NivelCurso, Curso.Seccion, 
				 Alumno.Apellidos, Alumno. Apellidos2, Alumno.Nombres, Alumno.Nombres2";
	
	
		 
//echo $sql;
		
		
$RS_AlumnoXCurso = $mysqli->query($sql);

?>
<table width="600" border="1">
  <tr>
    <td>Email<?php //echo $sql. $RS_AlumnoXCurso->num_rows; ?></td>
    <td>Nombre</td>
    <td>Apellido</td>
    <td>Curso</td>
    <td>CodigoAlumno</td>
    <td>Alumno</td>
    <td>Ano</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php 

while ($row_RS_AlumnoXCurso = $RS_AlumnoXCurso->fetch_assoc()) { 

	$sql = "SELECT * FROM Alumno WHERE
		CodigoAlumno = '".$row_RS_AlumnoXCurso['CodigoAlumno']."'";
	$RS_Alumno = $mysqli->query($sql);
	$row_RS_Alumno = $RS_Alumno->fetch_assoc();


	$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
						WHERE RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumno['CodigoAlumno']."' 
						AND RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante  
						AND (RepresentanteXAlumno.Nexo = 'Padre' OR RepresentanteXAlumno.Nexo = 'Madre')
						AND Representante.Email1 > ''";//AND RepresentanteXAlumno.SW_Representante = '1'
					
	$query_RS_Padre = "SELECT * FROM RepresentanteXAlumno, Representante 
				WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
				AND (RepresentanteXAlumno.Nexo = 'Padre' OR RepresentanteXAlumno.Nexo = 'Madre')
				AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_AlumnoXCurso['CodigoAlumno']."'";
	$RS_Padre = mysql_query($query_RS_Padre, $bd) or die(mysql_error());
	$row_RS_Padre = mysql_fetch_assoc($RS_Padre);
					
					
	
	

						
						
	//echo $query_RS_Repre;					
	$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
	while($row_RS_Repre = mysql_fetch_assoc($RS_Repre)){
	
		if(strpos($row_RS_Repre['Email1'],"@")){
?>
            <tr>
              <td><?php echo strtolower($row_RS_Repre['Email1']); ?></td>
              <td><?php echo Titulo( NoAcentos($row_RS_Repre['Nombres']) ); ?></td>
               <td><?php echo Titulo( NoAcentos($row_RS_Repre['Apellidos']) ); ?></td>
             
              <td>C:<?php echo NivelCurso($row_RS_AlumnoXCurso['CodigoCurso']);//.','.$row_RS_Alumno['CodigoAlumno'] 
			  
			  
				$sql_Hermanos = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
									WHERE Alumno.Creador = '".$row_RS_Alumno['Creador']."'
									AND Alumno.CodigoAlumno <> '".$row_RS_Alumno['CodigoAlumno']."'
									AND Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
									AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso 
									AND (AlumnoXCurso.Ano = '$AnoEscolar')
									AND AlumnoXCurso.Tipo_Inscripcion  <> 'Mp'
									AND AlumnoXCurso.Status = 'Inscrito' 
									ORDER BY Alumno.Creador";
				$RS_Hermanos = mysql_query($sql_Hermanos, $bd) or die(mysql_error());
				while($row_RS_Hermanos = mysql_fetch_assoc($RS_Hermanos)){
					echo "-".$row_RS_Hermanos['NivelCurso'];
				}
				
				
			  ?></td>
              
              <td><?php echo $row_RS_Alumno['CodigoAlumno'];//.','.$row_RS_Alumno['CodigoAlumno'] 
			  
				$RS_Hermanos = mysql_query($sql_Hermanos, $bd) or die(mysql_error());
				while($row_RS_Hermanos = mysql_fetch_assoc($RS_Hermanos)){
					echo "-".$row_RS_Hermanos['CodigoAlumno'];
				}
  
			  ?></td>
              <td><?php echo Titulo(NoAcentos($row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2'].' '.$row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2']));//.','.$row_RS_Alumno['CodigoAlumno'] ?></td>
              <td ><?php echo $AnoEscolar; ?></td>
              <td><?php echo $row_RS_Alumno['CodigoAsignacion']; ?></td>
              <td><?php echo $row_RS_Alumno['NivelCurso']; ?></td>
            </tr>
<?php 
		}
	}
}






$sql = "SELECT * FROM Empleado 
		WHERE SW_activo = '1' 
		AND Email > ''
		ORDER BY Apellidos, Nombres";
$RS_Empleados = $mysqli->query($sql);

while ($row = $RS_Empleados->fetch_assoc()){
	extract($row);
	
 ?>

<tr>
    <td><?= $Email ?> </td>
    <td><?= Titulo(NoAcentos($Nombres)) ?></td>
    <td><?= Titulo(NoAcentos($Apellidos)) ?></td>
    <td>Docente</td>
    <td><?= $CodigoEmpleado ?></td>
    <td>Docente</td>
    <td><?= $AnoEscolar ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<? } ?>

</table>