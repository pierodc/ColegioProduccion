<?php require_once('../../Connections/bd.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "FormaRif")) {
  $updateSQL = sprintf("UPDATE Alumno SET Fac_Rif=%s, Fac_Nombre=%s, Fac_Direccion=%s, Fac_Telefono=%s WHERE CodigoClave=%s",
                       GetSQLValueString($_POST['Fac_Rif'], "text"),
                       GetSQLValueString($_POST['Fac_Nombre'], "text"),
                       GetSQLValueString($_POST['Fac_Direccion'], "text"),
                       GetSQLValueString($_POST['Fac_Telefono'], "text"),
                       GetSQLValueString($_POST['CodigoClave'], "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());

  $updateGoTo = "Estado_de_Cuenta_Alumno.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoPropietario'])) {
  $colname_RS_Alumno = $_GET['CodigoPropietario'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoClave = %s", GetSQLValueString($colname_RS_Alumno, "text"));
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="FormaRif" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td colspan="2" align="center" nowrap="nowrap">Datos facturaci&oacute;n</td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rif:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="Fac_Rif" value="<?php echo $row_RS_Alumno['Fac_Rif']; ?>" size="60" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">No valido</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="Fac_Nombre" value="<?php echo $row_RS_Alumno['Fac_Nombre']; ?>" size="60" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Direccion:</td>
      <td><span id="sprytextfield3">
        <input type="text" name="Fac_Direccion" value="<?php echo $row_RS_Alumno['Fac_Direccion']; ?>" size="60" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telefono:</td>
      <td><span id="sprytextfield4">
        <input type="text" name="Fac_Telefono" value="<?php echo $row_RS_Alumno['Fac_Telefono']; ?>" size="60" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Actualizar" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="FormaRif" />
  <input type="hidden" name="CodigoClave" value="<?php echo $row_RS_Alumno['CodigoClave']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"], minChars:7});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_Alumno);
?>
