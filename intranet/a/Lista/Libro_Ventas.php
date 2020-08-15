<?php require_once('../../Connections/bd.php'); 
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
	
  $logoutGoTo = "../../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "99, 91, admin";
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

$MM_restrictGoTo = "../../Login.php?L=0";
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
?>
<?php
require_once('../../inc/rutinas.php');
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

$Recibos_FechaHasta = "";
if ($_POST['FechaHasta'] > "1") {
  $Recibos_FechaHasta = $_POST['FechaHasta'];
$Recibos_FechaHasta = " AND Fecha <= '".$_POST['FechaHasta']."' ";
}

$colname_RS_Recibos = "-1";
if (isset($_POST['Fecha'])) {
  $colname_RS_Recibos = $_POST['Fecha'];
mysql_select_db($database_bd, $bd);
$query_RS_Recibos = sprintf("SELECT * FROM Recibo WHERE Fecha >= %s $Recibos_FechaHasta ORDER BY Fecha ASC", GetSQLValueString($colname_RS_Recibos, "date"));
//echo $query_RS_Recibos;
$RS_Recibos = mysql_query($query_RS_Recibos, $bd) or die(mysql_error());
$row_RS_Recibos = mysql_fetch_assoc($RS_Recibos);
$totalRows_RS_Recibos = mysql_num_rows($RS_Recibos);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Libro Vantas</title>
</head>

<body>
<form name="form1" method="post" action="">
  <label>
  Buscar Facturas fechas <br />
  desde
  <input name="Fecha" type="text" id="Fecha" value="<?php echo $_POST['Fecha']; ?>">
  </label>
  <label>  &quot;AAAA-MM-DD&quot;<br />
  hasta
  <input name="FechaHasta" type="text" id="FechaHasta" value="<?php echo $_POST['FechaHasta']; ?>" />
  &quot;AAAA-MM-DD&quot;<br />
  </label>
  <p>Salida para<br />
    <label>
      <input name="Salida" type="radio" id="Salida_0" value="Excel" checked="checked" />
      Excel</label>
    <br />
    <label>
      <input type="radio" name="Salida" value="Impresora" id="Salida_1" />
      Impresora</label>
    <br />
  </p>
  <label><br /> 
  <input type="submit" name="button" id="button" value="Buscar">
  </label>
</form><?php if ($totalRows_RS_Recibos > 0){ ?><br><br>
<?php if ($_POST['Salida'] == "Excel"){ ?>
<table border="1" cellpadding="2" cellspacing="0">
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">Fecha</td>
    <td nowrap="nowrap">Rif</td>
    <td nowrap="nowrap">Nombre</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">N. Fac.</td>
    <td nowrap="nowrap">N. Control</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">B. Excent</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">B. Imponible</td>
    <td nowrap="nowrap">Alic</td>
    <td nowrap="nowrap">IVA</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">Total</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td nowrap="nowrap">&nbsp;</td>
      <td nowrap="nowrap"><?php echo DDMMAAAA($row_RS_Recibos['Fecha']); ?></td>
      <td nowrap="nowrap"><?php echo $row_RS_Recibos['Fac_Rif']; ?></td>
      <td nowrap="nowrap"><?php echo ucwords(strtolower($row_RS_Recibos['Fac_Nombre'])); ?></td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap"><?php echo $row_RS_Recibos['NumeroFactura']; ?></td>
      <td align="right" nowrap="nowrap"><?php echo $row_RS_Recibos['Fac_Num_Control']; ?></td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">01-Reg</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">0</td>
      <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Base_Exe']); $Excento+=$row_RS_Recibos['Base_Exe'];?></td>
      <td align="right" nowrap="nowrap">0</td>
      <td align="right" nowrap="nowrap">0</td>
      <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Base_Imp']); $Imponible+=$row_RS_Recibos['Base_Imp'];?></td>
      <td align="right" nowrap="nowrap">12%</td>
      <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Monto_IVA']); $Iva+=$row_RS_Recibos['Monto_IVA']; ?></td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Total']); $Total+=$row_RS_Recibos['Total'];?></td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
      <td align="right" nowrap="nowrap">&nbsp;</td>
    </tr>
    <?php } while ($row_RS_Recibos = mysql_fetch_assoc($RS_Recibos)); ?>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Excento); ?></td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Imponible); ?></td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Iva); ?></td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Total); ?></td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
  </tr>
</table><?php }else{ ?>
<table border="1" cellpadding="2" cellspacing="0">
  <tr>
    <td nowrap="nowrap">Fecha</td>
    <td nowrap="nowrap">Rif</td>
    <td nowrap="nowrap">Nombre</td>
    <td nowrap="nowrap">N. Fac.</td>
    <td nowrap="nowrap">N. Control</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">B. Excent</td>
    <td nowrap="nowrap">B. Imponible</td>
    <td nowrap="nowrap">Alic</td>
    <td nowrap="nowrap">IVA</td>
    <td nowrap="nowrap">Total</td>
  </tr>
  <?php do { ?>
  <tr>
    <td nowrap="nowrap"><?php echo DDMMAAAA($row_RS_Recibos['Fecha']); ?></td>
    <td nowrap="nowrap"><?php echo $row_RS_Recibos['Fac_Rif']; ?></td>
    <td nowrap="nowrap"><?php echo ucwords(strtolower($row_RS_Recibos['Fac_Nombre'])); ?></td>
    <td align="right" nowrap="nowrap"><?php echo $row_RS_Recibos['NumeroFactura']; ?></td>
    <td align="right" nowrap="nowrap"><?php echo $row_RS_Recibos['Fac_Num_Control']; ?></td>
    <td align="right" nowrap="nowrap">01-Reg</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Base_Exe']); $Excento+=$row_RS_Recibos['Base_Exe'];?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Base_Imp']); $Imponible+=$row_RS_Recibos['Base_Imp'];?></td>
    <td align="right" nowrap="nowrap">12%</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Monto_IVA']); $Iva+=$row_RS_Recibos['Monto_IVA']; ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Recibos['Total']); $Total+=$row_RS_Recibos['Total'];?></td>
    </tr>
  <?php } while ($row_RS_Recibos = mysql_fetch_assoc($RS_Recibos)); ?>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Excento); ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Imponible); ?></td>
    <td align="right" nowrap="nowrap">&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Iva); ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($Total); ?></td>
  </tr>
</table>
<?php }} ?>
</body>
</html><?php if ($totalRows_RS_Recibos > 0){ ?>
<?php
mysql_free_result($RS_Recibos);
?><?php } ?>
