<?php
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
?><?php require_once('../../Connections/bd.php'); ?><?php require_once('../../inc/rutinas.php'); ?>
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



$colname_RS_Alumnos = "-1";
if (isset($_GET['CodigoCurso'])) {
  $colname_RS_Alumnos = (get_magic_quotes_gpc()) ? $_GET['CodigoCurso'] : addslashes($_GET['CodigoCurso']);
$query_RS_Alumnos =  sprintf("SELECT * FROM Alumno WHERE Alumno.CodigoCurso = %s AND Alumno.SWInscrito = 1 ORDER BY Alumno.Apellidos, Alumno.Apellidos2", $colname_RS_Alumnos);

}else{

if (isset($_GET['CodigoAsignacion'])) {
  $colname_RS_Alumnos = (get_magic_quotes_gpc()) ? $_GET['CodigoAsignacion'] : addslashes($_GET['CodigoAsignacion']);
}
$query_RS_Alumnos = sprintf("SELECT * FROM Alumno, AsignacionXAlumno, Curso WHERE Alumno.CodigoCurso = Curso.CodigoCurso AND Alumno.SWInscrito = 1 AND AsignacionXAlumno.CodigoAsignacion = %s AND Alumno.CodigoAlumno = AsignacionXAlumno.CodigoAlumno AND AsignacionXAlumno.Ano_Escolar='2010-2011' ORDER BY Curso.NivelMencion, Curso.Curso, Curso.Seccion, Alumno.Apellidos, Alumno.Apellidos2", $colname_RS_Alumnos);
}


mysql_select_db($database_bd, $bd);
$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);

$colname_RS_Asignacion = "-1";
if (isset($_GET['CodigoAsignacion'])) {
  $colname_RS_Asignacion = $_GET['CodigoAsignacion'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Asignacion = sprintf("SELECT * FROM Asignacion WHERE Codigo = %s", GetSQLValueString($colname_RS_Asignacion, "int"));
$RS_Asignacion = mysql_query($query_RS_Asignacion, $bd) or die(mysql_error());
$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion);
$totalRows_RS_Asignacion = mysql_num_rows($RS_Asignacion);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Lista: <?php echo $row_RS_Asignacion['Descripcion']; ?></title>
</head>

<body  onLoad="window.print()">
<table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#666666">
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
        <td align="center" nowrap><span class="style1"><span class="style3">COLEGIO</span><br />
            <strong>Colegio San Francisco de As&iacute;s</strong><br />
<span class="style3">Los Palos Grandes</span></span></td>
        </tr>
      <tr>
        <td align="center"><strong>
          <?php 
	if (isset($_GET['CodigoCurso'])) {
	NombreCurso($row_RS_Alumnos['CodigoCurso'],$row_RS_Alumnos['CodigoCurso']);
	}else{
	echo $row_RS_Asignacion['Descripcion']; 
	}
	 ?>
          (<?php echo date('d-m-Y') ?>)        </strong></td> 
        </tr>
    </table>    </td>
    <td rowspan="2" align="center"><br /></td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="1">No</td>
    <td width="1" align="center">C&oacute;d</td>
    <td width="1"><strong>Apellidos, </strong>Nombres</td>
  </tr>
        <?php do { ?>
        <?php if ($totalRows_RS_Alumnos > 0) { // Show if recordset not empty ?>
  <tr>
    <td rowspan="2" nowrap="nowrap"><?php echo ++$i; ?></td>
    <td rowspan="2" align="center" nowrap="nowrap"><?php echo $row_RS_Alumnos['CodigoAlumno']; ?></td>
    <td valign="bottom" nowrap="nowrap"><b><?php Titulo( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2']); ?>,</b> <em><?php Titulo( $row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']) ?>
      <br>
    </em></td>
    <td width="5" rowspan="2" nowrap><br>
      <?php 
	if (isset($_GET['CodigoAsignacion'])) {
	NombreCurso($row_RS_Alumnos['CodigoCurso'],$row_RS_Alumnos['CodigoCurso']);
	}else{
	?>
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="../fotAl_mini80/<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>.jpg" width="53" height="80" /></td>
          <td><img src="../Foto_Repre/<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>p.jpg" alt="" width="53" height="80" /></td>
          <td><img src="../Foto_Repre/<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>m.jpg" alt="" width="53" height="80" /></td>
        </tr>
      </table>
      <?php
	}
	
	
mysql_select_db($database_bd, $bd);
$query_RS_Representante = "SELECT * FROM Representante WHERE Creador = '".$row_RS_Alumnos['Creador']."'";
$RS_Representante = mysql_query($query_RS_Representante, $bd) or die(mysql_error());
$row_RS_Representante = mysql_fetch_assoc($RS_Representante);
$totalRows_RS_Representante = mysql_num_rows($RS_Representante);

	?>     </td>
    <td colspan="11" rowspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <?php do { ?><tr>
        <td width="100" nowrap="nowrap" class="ReciboRenglonMini"><?php echo $row_RS_Representante['Nexo'] ?></td>
        <td width="100" nowrap="nowrap" class="ReciboRenglonMini"><?php echo $row_RS_Representante['Cedula'] ?></td>
        <td nowrap="nowrap" class="ReciboRenglon"><strong><?php echo $row_RS_Representante['Apellidos'] ?>,</strong> <?php echo $row_RS_Representante['Nombres'] ?></td>
        <td nowrap="nowrap" class="ReciboRenglonMini"><?php echo $row_RS_Representante['TelHab'] ?>-<?php echo $row_RS_Representante['TelCel'] ?>-<?php echo $row_RS_Representante['TelTra'] ?></td>
        </tr><?php } while ($row_RS_Representante = mysql_fetch_assoc($RS_Representante)); ?>
    </table></td>
    </tr>
  <tr>
    <td valign="top"><span class="ReciboRenglonMini">Alergias: <?php echo $row_RS_Alumnos['AlergicoA']; ?><br />
Enf:<?php echo $row_RS_Alumnos['Enfermedades']; ?></span><br />
<span class="ReciboRenglonMini">Trat. Med.:<?php echo $row_RS_Alumnos['TratamientoMed']; ?></span></td>
  </tr>
        <?php } // Show if recordset not empty ?>
<?php } while ($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html><?php
mysql_free_result($RS_Asignacion);

mysql_free_result($RS_Representante);
?>
