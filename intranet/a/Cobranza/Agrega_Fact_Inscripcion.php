<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

// Activa INSERT y DELETE
$SW_activo = true;
$Tiempo = 500; 
if( $MM_Username == 'piero')
	$Tiempo = 500; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body <?php if(($MM_Username!='piero' or false) and !isset($_GET['bot_EliminarMov']) and !isset($_GET['bot_Prioridad']) and !isset($_GET['Prioridad'])){ ?> onload="setTimeout('window.close()',<?php echo $Tiempo ?>)" <?php } ?>>
<?php 
mysql_select_db($database_bd, $bd);

if(isset($_GET['CodigoAlumno'])){
	$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Curso 
						WHERE AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
						AND (AlumnoXCurso.Ano = '$AnoEscolar' )
						AND AlumnoXCurso.CodigoAlumno = '".$_GET['CodigoAlumno']."'
						GROUP BY AlumnoXCurso.CodigoAlumno
						ORDER BY  AlumnoXCurso.Ano DESC ";
}
//echo $query_RS_Alumno;
$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
//$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);


while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)) { // Para cada alumno
$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];


// Busca si existe la Inscripcion 
$_sql = "SELECT * FROM ContableMov WHERE 
			CodigoPropietario = '$CodigoAlumno' AND 
			ReferenciaMesAno = 'Ins ".substr($AnoEscolar,0,4)."' AND 
			Descripcion = 'Matrícula' ";
$_RS = mysql_query($_sql, $bd) or die(mysql_error());
$_row_RS = mysql_fetch_assoc($_RS);
$_totalRows = mysql_num_rows($_RS);

// Busca datos del curso 
$RS_Aux = mysql_query("SELECT CodigoCurso FROM AlumnoXCurso WHERE 
						CodigoAlumno = '$CodigoAlumno' AND 
						Ano = '$AnoEscolar'", $bd);						
$row_Aux = mysql_fetch_assoc($RS_Aux);
$CodigoCurso  = $row_Aux['CodigoCurso'];

$RS_Aux =  mysql_query("SELECT NivelCurso, NivelMencion, NombreCompleto 
						FROM Curso 
						WHERE CodigoCurso = '$CodigoCurso' ", $bd);
$row_Aux = mysql_fetch_assoc($RS_Aux);
	$NivelCurso  = $row_Aux['NivelCurso'];
	$NivelMencion  = $row_Aux['NivelMencion'];

echo '<br>'.$row_Aux['NombreCompleto'].'<br>';

if( $_totalRows == 0 ){ // CREA FACTURAS DE LA INSCRIPCION

		$Monto = 0;
			$F_Ins = substr($AnoEscolar,0,4).'-08-31'; 
			
			$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, MontoDebe_Dolares) ";
			$sql.= " VALUES ";
			
			
			$sql_aux = "SELECT * FROM Asignacion 
						WHERE SWActiva = '1'
						AND (NivelCurso LIKE '%$NivelCurso%' OR NivelCurso = '00')
						AND Periodo = 'I'
						
						ORDER BY Orden"; // AND Descripcion = 'Matrícula'
						
			echo 'Busca Conceptos de la ins: '.$sql_aux;
			$RS_Aux =  mysql_query($sql_aux, $bd);
			$row_Aux = mysql_fetch_assoc($RS_Aux);
			$totalRows_RS_Aux = mysql_num_rows($RS_Aux);
			
			if($totalRows_RS_Aux > 0){
				$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaValor, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, MontoDebe_Dolares, SWValidado) ";
				$sql.= " VALUES <br>";
				do {
					
					$sql.= " ($CodigoAlumno, '$F_Ins', '$F_Ins', '$MM_Username', ".$row_Aux['Codigo'].", 'Ins ".substr($AnoInscribiendo,2,2)."','".$row_Aux['Descripcion']."', '".$row_Aux['Monto']."', '".$row_Aux['Monto_Dolares']."', '1')<br>,";
					$Monto += $row_Aux['Monto']*1;
					
				} while ($row_Aux = mysql_fetch_assoc($RS_Aux));
			}
			echo $sql."<br>";
			echo 'total '.$Monto;		
			echo "<br><br>";
			$sql = str_replace('<br>','',$sql);
			$sql = substr($sql,0, strlen($sql)-1);
			// DESACTIVAR LA LINEA SIGUIENTE SI NO SE QUIERE CREAR LAS FACTURAS AL INSCRIBIR
			if($SW_activo)
				$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
			

			//ELIMINA Sociedad de padres de hermanos menores
			$PrincipalFamilia  = $row_RS_Alumnos['PrincipalFamilia'];
			if($PrincipalFamilia=='0' and !isset($_GET['CodigoAlumno'])){
				$sql = "DELETE From ContableMov  
						WHERE CodigoPropietario = $CodigoAlumno 
						AND ReferenciaMesAno = 'Ins ".substr($AnoInscribiendo,0,4)."' 
						AND Descripcion LIKE '%Sociedad de Padres%'";
				echo $sql."<br>";
				if($SW_activo)
					$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
			}
		
		} // fin CREA FACTURAS DE LA INSCRIPCION

			
			
		// Agrega AsignacionesXAlumno mensuales del curso
		$sql = "SELECT * FROM AsignacionXAlumno, Asignacion 
				WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo
				AND Asignacion.Descripcion LIKE '%Escolaridad%'
				AND CodigoAlumno='$CodigoAlumno'  
				AND Ano_Escolar='$AnoEscolar'";
		$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
		$totalRows_RS_sql = mysql_num_rows($RS_sql);
		echo $sql."<br>$totalRows_RS_sql<br>";
			
		if($totalRows_RS_sql == 0){ // CREAR Asignaciones Esc y Act extracurri

					$sql_aux = "SELECT * FROM Asignacion 
								WHERE  SWActiva = '1'
								AND ( NivelCurso LIKE '%$NivelCurso%' OR 
								  NivelCurso = '00')
								AND Periodo = 'MF' 
								ORDER BY Orden";
					echo $sql_aux.'<br>';
					$RS_Aux =  mysql_query($sql_aux, $bd);
					$row_Aux = mysql_fetch_assoc($RS_Aux);

					$sql = "INSERT INTO AsignacionXAlumno (CodigoAlumno, CodigoAsignacion, Descuento, Ano_Escolar) ";
					$sql.= " VALUES ";
					do {
						$sql.= " ($CodigoAlumno, '".$row_Aux['Codigo']."', 0 , '$AnoEscolar'),";
					} while ($row_Aux = mysql_fetch_assoc($RS_Aux));
				
				$sql = substr($sql,0, strlen($sql)-1);
				echo $sql."<br><br>";
				if($SW_activo)
					$RS_sql = mysql_query($sql, $bd) or die(mysql_error()); 
			}
	
} 

?>
</body>
</html>