<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ReciboCliente (CodigoAlumno, RIF, Nombre, Direccion, Telefono) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CodigoAlumno'], "int"),
                       GetSQLValueString($_POST['RIF'], "text"),
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Telefono'], "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".$_GET['CodigoPropietario']);

}

$sql = "SELECT Alumno.CodigoClave, Alumno.CodigoCreador, Representante.* 
		FROM Alumno, Representante
		WHERE Alumno.CodigoClave = '".$_GET['CodigoPropietario']."'
		AND Alumno.Creador = Representante.Creador";
//echo $sql;		
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
//echo $row['Apellidos'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><?php echo $_GET['CodigoAlumno']; ?></td>
    </tr>
   <tr valign="baseline">
      <td nowrap="nowrap" align="right">RIF:</td>
      <td><input type="text" name="RIF" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="Nombre" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Direccion:</td>
      <td><input type="text" name="Direccion" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><input type="text" name="Telefono" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Crear" /></td>
    </tr>
  </table>
  <input type="hidden" name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>