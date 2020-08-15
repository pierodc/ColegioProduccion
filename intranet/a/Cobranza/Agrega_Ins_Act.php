<?php require_once('../../../Connections/bd.php');  
require_once('../../../inc/rutinas.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body  <?php  echo 'onload="window.close()"'; ?>>
<?php 
// 

mysql_select_db($database_bd, $bd);

$CodigoAsignacion = $_GET['CodigoAsignacion'];	
$Descripcion = 'Ins. ' . $_GET['Descripcion'];


if(strpos("  ".$_GET['Descripcion'],"Nataci") > 0){
	$MontoDebe = 16800;
}else
	$MontoDebe = 11200;





$CodigoAlumno = $_GET['CodigoAlumno'];

echo $CodigoAsignacion.$Descripcion.$MontoDebe.$CodigoAlumno;
	
	$F_Ins = date('Y').'-10-5'; 

	$sql2 = "INSERT INTO ContableMov 
	(CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, Descripcion, MontoDebe, ReferenciaMesAno, SWiva) ";
	$sql2.= "( SELECT $CodigoAlumno, '$F_Ins', '$F_Ins', 1, 'sys', ";
	$sql2.= "'".$CodigoAsignacion."', '$Descripcion', '$MontoDebe'   ";
	$sql2.= ", '10-17' , '1' ";
	$sql2.= ") ";
	$sql2.= "";
	echo '<br>'.$sql2;
	$RS_sql = mysql_query($sql2, $bd) or die(mysql_error());

?>
</body>
</html>