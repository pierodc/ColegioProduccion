<?php require_once('../../../Connections/bd.php');

mysql_select_db($database_bd, $bd);

$BlackBerry = strpos("    ".$_SERVER['HTTP_USER_AGENT'] , "BlackBerry");
if($BlackBerry>0){
$auxPag = str_replace(".php" , "_BB.php" , $_SERVER['PHP_SELF'] );
header("Location: ".$auxPag."?CodigoPropietario=".$_GET['CodigoPropietario']);
    exit;}

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "99,91,95,90";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../../Login.php?L=0";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

$MM_Username = $_SESSION['MM_Username'];

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 



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

// Activa Inspeccion
$Insp = false ;

//Elimina Mov 
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarMov']))) {
  $deleteSQL = sprintf("DELETE FROM ContableMov WHERE Codigo=%s",
                       GetSQLValueString($_GET['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($deleteSQL, $bd) or die(mysql_error());

header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']);
}


$editFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $insertSQL = sprintf("INSERT INTO ContableMov (Observaciones, SWValidado, SWCancelado, CodigoCuenta, CodigoPropietario, Tipo, Fecha, Referencia, ReferenciaOriginal, ReferenciaBanco, Descripcion, MontoDebe, MontoHaber, RegistradoPor, FechaIngreso, MontoDocOriginal) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Observaciones'], "text"),
                       GetSQLValueString($SWValidado, "int"),
                       GetSQLValueString('0', "int"),
                       GetSQLValueString($_POST['CodigoCuenta'], "int"),
                       GetSQLValueString($_POST['Proveedor'], "int"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['ReferenciaBanco'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['MontoDebe'], "double"),
                       GetSQLValueString($_POST['MontoHaber'], "double"),
					   GetSQLValueString($_POST['RegistradoPor'], "text"),
					   GetSQLValueString($_POST['FechaIngreso'], "text"),
					   GetSQLValueString($_POST['MontoDocOriginal'], "double"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
$mensaje = "";

}
// }// fin REFERENCIA unica




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Egreso de Caja</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
function ValidaForma() {
form1.BotonRecibo.disabled=true; 
form1.submit(); 
return false;
}
</script>

<style type="text/css">
a:link {
	color: #0000FF;
	text-decoration: none;
}
</style>

<style type="text/css">
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
</style>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="800" border="0" align="center">
  <tr>
    <td><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right">    <div align="right" class="TituloPagina"> Egreso General</div></td>
  </tr>
  <tr>
    <td align="left"><a href="../index.php"><img src="../../../img/home.png" alt="" width="25" height="27" border="0" /></a> - <a href="Diario_de_Caja.php">Diario de Caja</a></td>
    <td align="right"><span style="font-weight: bold">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
              <td colspan="9" align="left" nowrap="nowrap" class="subtitle">Egresos</td>
          </tr>
            <tr>
              <td colspan="2" nowrap="nowrap" class="FondoCampo"><input name="Fecha" type="hidden" id="Fecha" value="<?php echo date('Y-m-d') ?>" /></td>
              <td nowrap="nowrap" class="FondoCampo"><select name="Proveedor">
                <option value="0">Seleccione...</option>
                <?php 
$sql = "SELECT * FROM Proveedor WHERE SubCuenta01 >' '  GROUP BY SubCuenta01 ORDER BY SubCuenta01";
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_ = mysql_fetch_assoc($RS_);
	do {
		extract($row_RS_);
		echo '<option value="'.$SubCuenta01.'">'.$SubCuenta01.'</option>';
	} while ($row_RS_ = mysql_fetch_assoc($RS_));
			  ?>
              </select></td>
              <td nowrap="nowrap" class="FondoCampo">&nbsp;</td>
              <td nowrap="nowrap" class="FondoCampo"><input name="Observaciones" type="text" id="Observaciones" size="30" /></td>
              <td align="right" nowrap="nowrap" class="FondoCampo"><input type="text" name="MontoDebe" value="" size="8"   /></td>
              <td colspan="3" nowrap="nowrap" class="FondoCampo"><select name="Tipo" id="Tipo">
                
                <option value="3">Cheque</option>
                <option value="4" selected="selected">Efec</option>
              </select>
                <select name="CodigoCuenta" id="CodigoCuenta">
                  <option value="10">Caja</option>
                  <option value="1">Mercantil</option>
                  <option value="2">Provincial</option>
                  <?php  if ($_SESSION['MM_UserGroup']=='99'){  ?>
                  <option value="3">Venezuela</option>
                  <option value="4">V. de Cred.</option>
                  <?php } ?>
              </select>
              <input type="text" name="Referencia" value="" size="8"  /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap">&nbsp;</td>
              <td colspan="3" align="right" nowrap="nowrap">
                <input type="hidden" name="RegistradoPor" value="<?php echo $_SESSION['MM_Username']; ?>" />
                <input type="hidden" name="Descripcion" value="Egreso" />
                <input type="hidden" name="MontoHaber" value="" />
                <input type="hidden" name="FechaIngreso" value="<?php echo date('Y-m-d h:i:s'); ?>" />
                <input type="hidden" name="MM_insert" value="form1" /></td>
              <td colspan="4"><input type="submit" value="Guardar" onclick="this.disabled=true;this.form.submit();" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="9" align="right" nowrap="nowrap">                    </td>
          </tr>
        </table></form>
    </td>
  </tr>
</table>
</body>
</html>
