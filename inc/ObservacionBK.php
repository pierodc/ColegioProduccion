<?php 
//$MM_authorizedUsers = "2,99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

//$Alumno = new Alumno($_GET['Codigo'] , $AnoEscolar);//
//$CodigoAlumno = $Alumno->id;
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Codigo = $_GET['Codigo'];
$Area = $_GET['Area'];

if(isset($_GET['Elimina']) and $_GET['Elimina'] > 0){
	
  $Elimina = $_GET['Elimina'];
  $Codigo_Propietario = $Codigo+100000;
  $sql = 'UPDATE Observaciones Set Codigo_Propietario='.$Codigo_Propietario.' WHERE Codigo_Observ = '.$Elimina ;
  //echo "<br><br><br>" . $sql;
  $Result = mysql_query($sql, $bd) or die(mysql_error());
  $GoTo = $php_self."?Area=".$Area."&Codigo=".$Codigo;
  header(sprintf("Location: %s", $GoTo));
	
	
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form8") and $_POST['Observacion'] > "") {
	//echo "INSERTAR";
	$insertSQL = sprintf("INSERT INTO Observaciones (Area, Codigo_Propietario, Observacion, Por) VALUES (%s, %s, %s, %s)",
					   GetSQLValueString($_GET['Area'], "text"),
					   GetSQLValueString($_GET['Codigo'], "int"),
					   GetSQLValueString($_POST['Observacion'], "text"),
					   GetSQLValueString($_COOKIE['MM_Username'], "text"));
	
	$Result1 = $mysqli->query($insertSQL); 
	//echo $insertSQL;
	
  
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body><form action="" method="post" name="form8" id="form8">
  <table width="100%" align="center">
<?php
$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE Codigo_Propietario = $Codigo 
						AND Area = '$Area'
						ORDER BY Fecha_Creacion DESC";
//echo $query_Observaciones;	  
//$Observaciones = $mysqli->query($query_Observaciones);

?>
<tr valign="baseline">
  <td colspan="2" align="right" valign="middle" nowrap="nowrap" class="NombreCampo">Observaci&oacute;n:</td>
  <td colspan="2" valign="middle" class="FondoCampo">
  		<input name="Observacion" type="text" value="" size="60" required="required" />
   		<input type="hidden" name="MM_insert" value="form8" />
   		<input type="submit" value="Guardar" /></td>
</tr>
<?php
if($Observaciones = $mysqli->query($query_Observaciones))	  
 while ($row_Observaciones = $Observaciones->fetch_assoc()) { ?>
  <tr valign="baseline">
    <td align="left" nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_Observaciones['Fecha_Creacion']) ?></td>
    <td align="left" nowrap="nowrap" class="FondoCampo"><?php echo $row_Observaciones['Por'] ?></td>
    <td align="left" class="FondoCampo"><?php echo $row_Observaciones['Observacion'] ?></td>
    <td align="right" class="FondoCampo"><a href="/inc/Observacion.php?Area=Empleado-BC&Codigo=<?php echo $_GET['Codigo'] ?>&Elimina=<?php echo $row_Observaciones['Codigo_Observ'] ?>"><img src="/i/bullet_delete.png" width="16" height="16" border="0" /></a></td>
  </tr>
<?php }  ?>
 </table>
</form></body>
</html>