<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body <?php //echo 'onload="window.close()"'; ?>>
<?php 


//$row_RS_Alumno['SWAgostoFraccionado'];
$_Mes = $_GET['Mes'];
$_Ano = $_GET['Ano'];
$FechaValor = $_GET['Ano'].$_GET['Mes']."01";
$CodigoAsignacion = $_GET['CodigoAsignacion'];
mysql_select_db($database_bd, $bd);

if(isset($_GET['CodigoAlumno'])){
	$query_RS_Alumno = "SELECT * FROM Alumno, AlumnoXCurso, Curso 
						WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
						AND AlumnoXCurso.CodigoCurso = Curso.CodigoCurso
						AND AlumnoXCurso.Ano = '$AnoEscolar' 
						AND Alumno.CodigoAlumno = '".$_GET['CodigoAlumno']."'
						ORDER BY AlumnoXCurso.Ano DESC ";
}

echo $query_RS_Alumno;

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

// Busca la Aasignacione
$query_RS_Asignacion = "SELECT * FROM Asignacion 
						WHERE Codigo = '$CodigoAsignacion'";
echo $query_RS_Factura.' = '.$totalRows_RS_Factura."<br>";						
$RS_Asignacion = mysql_query($query_RS_Asignacion, $bd) or die(mysql_error());
$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion);
$Descripcion = $row_RS_Asignacion['Descripcion'];
$Monto = $row_RS_Asignacion['Monto']; 
$Monto_Dolares = $row_RS_Asignacion['Monto_Dolares']; 	
$SWiva = $row_RS_Asignacion['SWiva'];
if($SWiva == 1)
	$P_IVA = 12;

do{
	$CodigoAlumno = $row_RS_Alumno['CodigoAlumno'];
	$FactorDescuento = round( 1-( $row_RS_Alumno['Descuentos'] / 100) , 2);	
		
			$ReferenciaMesAno = $_Mes."-".$_Ano;
			$Referencia = $row_RS_Asignacion['Codigo'];
			
			// Busca si la asignacion del mes existe
			$query_RS_Factura = "SELECT * FROM ContableMov 
								 WHERE CodigoPropietario = $CodigoAlumno 
								 AND ReferenciaMesAno = '$ReferenciaMesAno' 
								 AND Referencia = '$Referencia'"; 
			$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
			$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
			$totalRows_RS_Factura = mysql_num_rows($RS_Factura);
			echo $query_RS_Factura. ' = ' .$totalRows_RS_Factura."<br>";
		    
			
			if($totalRows_RS_Factura == 0){ // si no existe la asignacion entonces se crea
				echo "generar<br>";
				// Agrega una mensualidad de una asignacion
				
				$MontoConDescuento = round( $Monto * $FactorDescuento , 2) ; 
				
				$sql = "";
				$sql = "INSERT INTO ContableMov 
				(CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, MontoDebe_Dolares, SWiva, P_IVA, Cambio_Dolar) VALUES ";
				
				
				$sql.= "(  
				$CodigoAlumno,
				'$FechaValor',
				'$FechaValor',
				1,
				'".$MM_Username."', 
				'$Referencia' ,
				'".$_Mes."-".$_Ano."', 
				
				'$Descripcion' , 
			
				$MontoConDescuento,
				
				$Monto_Dolares, 
				
				'$SWiva', '$P_IVA' , '$Cambio_Dolar' )";   
				echo $sql." ( $FactorDescuento )<br><br>";
				
				$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
			}
			
			else{
				echo "existe<br><br>";
			}
		
		
	

} while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno));

mysql_free_result($RS_Asign_Alum);

mysql_free_result($RS_Factura);
?></body>
</html>
