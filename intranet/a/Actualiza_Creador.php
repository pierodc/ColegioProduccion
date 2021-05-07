<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>
  <?php 

$Anterior = $_POST['Anterior'];
$Nuevo =  $_POST['Nuevo'];

$md5Nuevo = substr( md5($Nuevo) , 0 , 16);

//mysql_select_db($database_bd, $bd);

$query1 = "UPDATE Abuelos 		SET CodigoCreador = '$md5Nuevo' 	WHERE Creador = '$Anterior'"; 
$query2 = "UPDATE Abuelos 		SET Creador = '$Nuevo'          	WHERE Creador = '$Anterior'"; 

$query3 = "UPDATE Alumno 		SET CodigoCreador = '$md5Nuevo' 	WHERE Creador = '$Anterior'";
$query4 = "UPDATE Alumno		SET Creador = '$Nuevo'          	WHERE Creador = '$Anterior'"; 

$query5 = "UPDATE Usuario		SET CodigoCreador = '$md5Nuevo' 	WHERE Usuario = '$Anterior'"; 
$query6 = "UPDATE Usuario		SET Usuario = '$Nuevo'          	WHERE Usuario = '$Anterior'"; 

$query7 = "UPDATE Representante SET CodigoCreador = '$md5Nuevo' 	WHERE Creador = '$Anterior'"; 
$query8 = "UPDATE Representante SET Creador = '$Nuevo'          	WHERE Creador = '$Anterior'"; 


echo $query1.' == '; echo $mysqli->query($query1);  echo '<br>'; // mysql_query($query1, $bd) or die(mysql_error());
echo $query2.' == '; echo $mysqli->query($query2);  echo '<br>'; // mysql_query($query2, $bd) or die(mysql_error()); echo '<br>';
echo $query3.' == '; echo $mysqli->query($query3);  echo '<br>'; // mysql_query($query3, $bd) or die(mysql_error()); echo '<br>';
echo $query4.' == '; echo $mysqli->query($query4);  echo '<br>'; // mysql_query($query4, $bd) or die(mysql_error()); echo '<br>';
echo $query5.' == '; echo $mysqli->query($query5);  echo '<br>'; // mysql_query($query5, $bd) or die(mysql_error()); echo '<br>';
echo $query6.' == '; echo $mysqli->query($query6);  echo '<br>'; // mysql_query($query6, $bd) or die(mysql_error()); echo '<br>';
echo $query7.' == '; echo $mysqli->query($query7);  echo '<br>'; // mysql_query($query7, $bd) or die(mysql_error()); echo '<br>';
echo $query8.' == '; echo $mysqli->query($query8);  echo '<br>'; // mysql_query($query8, $bd) or die(mysql_error()); echo '<br>';

?>
</p>
<p><a href="index.php">REGRESAR</a></p>
</body>
</html>