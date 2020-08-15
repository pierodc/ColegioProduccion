<?php require_once('../../Connections/bd.php'); ?>
<?php require_once('../../inc/rutinas.php'); ?>
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

$colname_RS_Deposito = "-1";
if (isset($_GET['CodigoDeposito'])) {
  $colname_RS_Deposito = $_GET['CodigoDeposito'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Deposito = sprintf("SELECT * FROM Deposito WHERE CodigoDeposito = %s", GetSQLValueString($colname_RS_Deposito, "int"));
$RS_Deposito = mysql_query($query_RS_Deposito, $bd) or die(mysql_error());
$row_RS_Deposito = mysql_fetch_assoc($RS_Deposito);
$totalRows_RS_Deposito = mysql_num_rows($RS_Deposito);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td colspan="5" align="center" nowrap="nowrap"><strong>ANEXO a la planilla de Dep Num: <?php echo $row_RS_Deposito['Numero']; ?></strong><strong></strong></td>
  </tr>
  <tr>
    <td colspan="5" align="left" nowrap="nowrap">Titular: <strong>Colegio San Francisco de Asís</strong></td>
  </tr>
  <tr>
    <td colspan="5" align="left" nowrap="nowrap">Cuenta Corriente No.: <strong>0105 0079 66 8079 03718 3</strong></td>
  </tr>
  <tr>
    <td colspan="5" align="left" nowrap="nowrap">Fecha<strong>: <?php echo date('d/m/Y') ?></strong></td>
  </tr>
  <tr>
    <td align="center" nowrap="nowrap">No</td>
    <td align="center" nowrap="nowrap">Banco</td>
    <td align="center" nowrap="nowrap">Cuenta No.</td>
    <td align="center" nowrap="nowrap">Ref</td>
    <td align="center" nowrap="nowrap">Monto</td>
  </tr>
  <?php 
$colname_RS_Cheques_Procesando = "-1";
if (isset($_GET['CodigoDeposito'])) {
  $colname_RS_Cheques_Procesando = $_GET['CodigoDeposito'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Cheques_Procesando = sprintf("SELECT * FROM ContableMov WHERE CodigoDeposito = %s AND ReferenciaBanco='Mercantil' ORDER BY ReferenciaBanco ASC", GetSQLValueString($colname_RS_Cheques_Procesando, "int"));
$RS_Cheques_Procesando = mysql_query($query_RS_Cheques_Procesando, $bd) or die(mysql_error());
$row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando);
$totalRows_RS_Cheques_Procesando = mysql_num_rows($RS_Cheques_Procesando);
		  ?>
<?php if ($totalRows_RS_Cheques_Procesando > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr>
<td align="center" nowrap="nowrap"><?php echo ++$i; ?></td>
    <td nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['ReferenciaBanco']; ?></td>
    <td nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['NumCuenta']; ?></td>
    <td align="center" nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['Referencia']; ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Cheques_Procesando['MontoHaber']); ?>
        <?php $SubTotal1+=$row_RS_Cheques_Procesando['MontoHaber']; ?></td>
  </tr>
  <?php } while ($row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando)); ?>
  <tr>
    <td colspan="4" align="right"><strong>Banco Mercantil - Sub Total </strong></td>
    <td align="right"><strong><?php echo Fnum($SubTotal1); ?></strong></td>
  
</tr>
    <?php } // Show if recordset not empty ?>
  <?php 
$colname_RS_Cheques_Procesando = "-1";
if (isset($_GET['CodigoDeposito'])) {
  $colname_RS_Cheques_Procesando = $_GET['CodigoDeposito'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Cheques_Procesando = sprintf("SELECT * FROM ContableMov WHERE CodigoDeposito = %s AND ReferenciaBanco<>'Mercantil' ORDER BY ReferenciaBanco ASC", GetSQLValueString($colname_RS_Cheques_Procesando, "int"));
$RS_Cheques_Procesando = mysql_query($query_RS_Cheques_Procesando, $bd) or die(mysql_error());
$row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando);
$totalRows_RS_Cheques_Procesando = mysql_num_rows($RS_Cheques_Procesando);

		  ?>
<?php if ($totalRows_RS_Cheques_Procesando > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr>
    <td align="center" nowrap="nowrap"><?php echo ++$i; ?></td>
    <td nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['ReferenciaBanco']; ?></td>
    <td nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['NumCuenta']; ?></td>
    <td align="center" nowrap="nowrap"><?php echo $row_RS_Cheques_Procesando['Referencia']; ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($row_RS_Cheques_Procesando['MontoHaber']); ?>
        <?php $SubTotal2+=$row_RS_Cheques_Procesando['MontoHaber']; ?></td>
  </tr>
  <?php } while ($row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando)); ?>
    <?php } // Show if recordset not empty ?>
  <tr>
    <td colspan="4" align="right"><strong>otros bancos - Sub Total </strong></td>
    <td align="right"><strong><?php echo Fnum($SubTotal2); ?></strong></td>
  </tr>
  <tr>
    <td colspan="4" align="right"><strong>Total Deposito</strong></td>
    <td align="right"><strong><?php echo Fnum($SubTotal1+$SubTotal2); ?></strong></td>
  </tr>
</table>
</body>
</html>
<?php

mysql_free_result($RS_Cheques_Procesando);

mysql_free_result($RS_Deposito);

?>
