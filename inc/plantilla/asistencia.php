<?php 
$SW_omite_trace = true;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

$id_user = $_SERVER['REMOTE_ADDR'];

$_CodigoAlumno = $_GET['CodigoAlumno'];
$Fecha = date('Y-m-d');
$Lote = "Dia";

$sql = "SELECT * FROM Asistencia
		WHERE id_Alumno = '$_CodigoAlumno'
		AND Fecha_Hora LIKE '$Fecha%'
		AND Lote = '$Lote'";
$RS = $mysqli->query($sql);
//echo $sql."<br>";

if( $RS->num_rows == 0 and isset($_GET['Asistente']) ){
	$sql = "INSERT INTO Asistencia
			(id_Alumno, id_user, Lote)
			VALUES
			('$_CodigoAlumno', '$id_user', '$Lote')";
	//echo $sql."<br>";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAlumno=".$_GET['CodigoAlumno']);
}
elseif($RS->num_rows > 0 and isset($_GET['Asistente'])){
	$sql = "DELETE FROM Asistencia
			WHERE id_Alumno = '$_CodigoAlumno'
			AND Fecha_Hora like '$Fecha%'
			AND Lote = '$Lote'";
	//echo $sql."<br>";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAlumno=".$_GET['CodigoAlumno']);
}

?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php //echo $Campo ?>
<? if($RS->num_rows == 0){ ?>
<a href="<? echo $php_self."?CodigoAlumno=".$_GET['CodigoAlumno']."&Asistente=1"; ?>">
<img src="../../i/accept_0.png" width="32" height="32" alt=""/></a>
<? }else{ ?>
<a href="<? echo $php_self."?CodigoAlumno=".$_GET['CodigoAlumno']."&Asistente=0"; ?>">
<img src="../../i/accept_1.png" width="32" height="32" alt=""/></a><? } ?>