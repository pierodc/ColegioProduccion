<?php require_once('../../Connections/bd.php'); ?><?php require_once('../../inc/rutinas.php'); ?><?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Contabilidad (Codigo, Cuenta1, Cuenta11, Cuenta111, Fecha, Descripcion, Monto) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Codigo'], "int"),
                       GetSQLValueString($_POST['Cuenta1'], "text"),
                       GetSQLValueString($_POST['Cuenta11'], "text"),
                       GetSQLValueString($_POST['Cuenta111'], "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Monto'], "double"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
}

if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['Eliminar']))) {
  $deleteSQL = sprintf("DELETE FROM Contabilidad WHERE Codigo=%s",
                       GetSQLValueString($_GET['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($deleteSQL, $bd) or die(mysql_error());
}

mysql_select_db($database_bd, $bd);
$query_RS_Gastos = "SELECT * FROM Contabilidad ORDER BY Cuenta1, Cuenta11, Cuenta111 ASC";
$RS_Gastos = mysql_query($query_RS_Gastos, $bd) or die(mysql_error());
$row_RS_Gastos = mysql_fetch_assoc($RS_Gastos);
$totalRows_RS_Gastos = mysql_num_rows($RS_Gastos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
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
-->
</style>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td><?php require_once('TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><div align="right" class="TituloPagina"> Registro de Gastos</div>    </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><ul id="MenuBar2" class="MenuBarHorizontal">
      <li><a class="MenuBarItemSubmenu MenuBarItemSubmenu" href="index.php">Inicio</a></li>
      <li><a href="ListaAlumnos.php">Alumnos</a></li>
      <li><a href="ListaCurso.php" class="MenuBarItemSubmenu">Cursos</a>
          <ul>
            <li><a href="ListaCurso.php?CodigoCurso=14">Listato</a></li>
            <li><a href="EstadisticaCursos.php">Estadistica</a></li>
            <li><a href="ListaGeneral.php">Todos</a></li>
          </ul>
      </li>
      <li><a href="Pagos_Conciliar.php" class="MenuBarItemSubmenu">Pagos</a>
          <ul>
            <li><a href="ListaAlumnos.php">por Alumnos</a></li>
            <li><a href="Sube_Arch_Banco.php" class="MenuBarItemSubmenu"> Banco</a>
              <ul>
                <li><a href="Busca_Banco.php">Buscar</a></li>
              </ul>
            </li>
            <li><a href="Pagos_Conciliar.php">Verificar Pagos</a></li>
            <li><a href="Asignaciones.php">Asignaciones</a></li>
          </ul>
      </li>
      <li><a href="Usuarios.php">Usuarios</a></li>
      <li><a href="Empleado_Lista.php">Empleados</a></li>
    </ul></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Cuenta 1:</td>
          <td class="FondoCampo"><input type="text" name="Cuenta1" value="<?php echo $_POST['Cuenta1'] ?>" size="20" /></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Cuenta 11:</td>
          <td class="FondoCampo"><input type="text" name="Cuenta11" value="<?php echo $_POST['Cuenta11'] ?>" size="20" /></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Cuenta 111:</td>
          <td class="FondoCampo"><input type="text" name="Cuenta111" value="<?php echo $_POST['Cuenta111'] ?>" size="20" /></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Fecha:</td>
          <td class="FondoCampo"><input name="Fecha" type="hidden" id="Fecha" value="<?php echo date('Y-m-d'); ?>" />
            <?php Fecha('Fecha', date('Y-m-d')) ?></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Descripcion:</td>
          <td class="FondoCampo"><input type="text" name="Descripcion" value="" size="32" /></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap="nowrap" class="NombreCampo">Monto:</td>
          <td class="FondoCampo"><input type="text" name="Monto" value="" size="10" /></td>
          </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right"><input type="hidden" name="MM_insert" value="form1" />
            <input type="hidden" name="Codigo" value="" /></td>
          <td><input type="submit" value="Guardar" /></td>
          </tr>
        </table>
    </form>
    
    <?php if ($totalRows_RS_Gastos > 0) { // Show if recordset not empty ?>
      <table width="100%" border="0">
        <tr>
          <td class="NombreCampoTopeWin">&nbsp;</td>
          <td colspan="2" class="NombreCampoTopeWin">Cuenta</td>
          <td class="NombreCampoTopeWin">&nbsp;</td>
          <td class="NombreCampoTopeWin">&nbsp;</td>
          <td class="NombreCampoTopeWin"><div align="center">Descripci&oacute;n</div></td>
          <td class="NombreCampoTopeWin"><div align="center">Fecha</div></td>
          <td class="NombreCampoTopeWin"><div align="center">Monto</div></td>
          <td class="NombreCampoTopeWin">&nbsp;</td>
          </tr><?php $Monto1 = $Monto2 = $Monto3 = 0; $Cuenta1 = $Cuenta11 = $Cuenta111 = "";  ?>
        <?php do { ?>
        <tr>
          <td class="ListadoInPar"><a href="Gastos_Registro.php?Eliminar=1&Codigo=<?php echo $row_RS_Gastos['Codigo'] ?>"><img src="../../img/b_drop.png" width="16" height="16" border="0" /></a></td>
          <td colspan="2" class="ListadoInPar"><?php if($Cuenta1!=$row_RS_Gastos['Cuenta1']) echo $row_RS_Gastos['Cuenta1']; ?></td>
          <td class="ListadoInPar"><?php if($Cuenta11!=$row_RS_Gastos['Cuenta11']) echo $row_RS_Gastos['Cuenta11']; ?></td>
          <td class="ListadoInPar"><?php if($Cuenta111!=$row_RS_Gastos['Cuenta111']) echo $row_RS_Gastos['Cuenta111']; ?></td>
          <td class="ListadoInPar"><div align="left"><?php echo $row_RS_Gastos['Descripcion'] ?></div></td>
          <td class="ListadoInPar"><div align="center"><?php echo DDMMAAAA($row_RS_Gastos['Fecha']); ?></div></td>
          <td class="ListadoInPar"><div align="right"><?php echo $row_RS_Gastos['Monto'] ?></div></td>
          <td class="ListadoInPar">&nbsp;</td>
          </tr>
        <?php 
			$Cuenta1   = $row_RS_Gastos['Cuenta1'];		  
			$Cuenta11  = $row_RS_Gastos['Cuenta11'];		  
			$Cuenta111 = $row_RS_Gastos['Cuenta111'];		  
			$Monto1 += $row_RS_Gastos['Monto'];
            $row_RS_Gastos = mysql_fetch_assoc($RS_Gastos) ; 
			
			if($Cuenta1!=$row_RS_Gastos['Cuenta1']) {
			?>
        <tr>
          <td class="ListadoInPar">&nbsp;</td>
          <td class="ListadoInPar"><div align="right"><span style="font-weight: bold">Total: </span></div></td>
          <td class="ListadoInPar"><div align="right"><span style="font-weight: bold"><?php echo $Monto1 ?></span></div></td>
          <td class="ListadoInPar">&nbsp;</td>
          <td class="ListadoInPar">&nbsp;</td>
          <td class="ListadoInPar">&nbsp;</td>
          <td class="ListadoInPar"></td>
          <td class="ListadoInPar"></td>
          <td class="ListadoInPar">&nbsp;</td>
          </tr>
        
        <?php $Monto1 = 0; } ?>
        <?php } while ($row_RS_Gastos); ?>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      <?php } // Show if recordset not empty ?><p>&nbsp;</p>    </td>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

</body>
</html>
<?php
mysql_free_result($RS_Gastos);
?>
