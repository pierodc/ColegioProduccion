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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Alumno SET Urge_Celular=%s, Urge_BB=%s, Urge_Email=%s, Urge_Pref=%s, Urge_Cerca=%s, Urge_Observaciones=%s WHERE CodigoAlumno=%s",
                       GetSQLValueString($_POST['Urge_Celular'], "text"),
                       GetSQLValueString($_POST['Urge_BB'], "text"),
                       GetSQLValueString($_POST['Urge_Email'], "text"),
                       GetSQLValueString($_POST['Urge_Pref'], "text"),
                       GetSQLValueString(isset($_POST['Urge_Cerca']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Urge_Observaciones'], "text"),
                       GetSQLValueString($_POST['CodigoAlumno'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
}

$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoAlumno'])) {
  $colname_RS_Alumno = $_GET['CodigoAlumno'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = %s", GetSQLValueString($colname_RS_Alumno, "int"));
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
extract($row_RS_Alumno);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Datos Urgentes</title>
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="600" align="center">
    <tr valign="baseline">
      <td width="100" align="right" nowrap>CodigoAlumno:</td>
      <td><?php echo $row_RS_Alumno['CodigoAlumno']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Celular:</td>
      <td><span id="sprytextfield3">
      <input type="text" name="Urge_Celular" value="<?php echo $Urge_Celular; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Excede maximo number de characters.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">BB:</td>
      <td><span id="sprytextfield2">
      <input type="text" name="Urge_BB" value="<?php echo $Urge_BB; ?>" size="32" />
      <span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><span id="sprytextfield1">
      <input type="text" name="Urge_Email" value="<?php echo $Urge_Email; ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Prefiere:</td>
      <td>
          <input name="Urge_Pref" type="radio" id="Urge_Pref" value="BB" <?php if( $Urge_Pref=='BB') {echo "checked=\"checked\"" ;} ?> />
          BB
        <br />
          <input name="Urge_Pref" type="radio" id="Urge_Pref" value="Celuar" <?php if( $Urge_Pref=='Celuar') {echo "checked=\"checked\"" ;} ?> />
          Celular
        <br />
          <input name="Urge_Pref" type="radio" id="Urge_Pref" value="Email" <?php if( $Urge_Pref=='Email') {echo "checked=\"checked\"" ;} ?> />
          Email
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Cerca del Colegio:</td>
      <td><label>
      <input name="Urge_Cerca" type="checkbox" id="checkbox" <?php if( $Urge_Cerca=='1') {echo "checked=\"checked\"" ;} ?> />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap>Observaciones:</td>
      <td><textarea name="Urge_Observaciones" cols="20" rows="3"><?php echo htmlentities($row_RS_Alumno['Urge_Observaciones'], ENT_COMPAT, 'UTF-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Guardar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="CodigoAlumno" value="<?php echo $row_RS_Alumno['CodigoAlumno']; ?>">
</form>
<table border=0 align="center" cellspacing=0 style="background-color: #fff; padding: 5px;" width="600"  >
  <form action="http://groups.google.com/group/Colegio-sfda/boxsubscribe">
  <input type=hidden name="hl" value="es">
  <tr><td style="padding-left: 5px;"> Correo electrónico: <input type=text name=email value="<?php echo $Urge_Email; ?>" >
  <input type=submit name="sub" value="Suscribirse">
  </td></tr>
</form>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:8, maxChars:8, isRequired:false, validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {minChars:11, maxChars:11, validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_Alumno);
?>
