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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Deposito SET Numero=%s WHERE CodigoDeposito=%s",
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['CodigoDeposito'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
  	header("Location: ".$_SERVER['PHP_SELF']."?CodigoDeposito=". $_GET['CodigoDeposito']);

}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE ContableMov SET NumCuenta=%s WHERE Codigo=%s",
                       GetSQLValueString($_POST['NumCuenta'], "text"),
                       GetSQLValueString($_POST['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());
  	header("Location: ".$_SERVER['PHP_SELF']."?CodigoDeposito=". $_GET['CodigoDeposito']);
}

if (isset($_GET['NuevoDeposito'])) {
mysql_select_db($database_bd, $bd);
$query_RS = "INSERT Deposito Values ('','Mercantil','Nuevo_Num','')";
$RS = mysql_query($query_RS, $bd) or die(mysql_error());
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoDeposito=". mysql_insert_id());
}

if (isset($_GET['Agregar'])) {
mysql_select_db($database_bd, $bd);
$query_RS = "UPDATE ContableMov SET CodigoDeposito = ".$_GET["CodigoDeposito"]." WHERE Codigo = ".$_GET["Codigo"]." ";
$RS = mysql_query($query_RS, $bd) or die(mysql_error());
  	header("Location: ".$_SERVER['PHP_SELF']."?CodigoDeposito=". $_GET['CodigoDeposito']);
}

if (isset($_GET['Eliminar'])) {
mysql_select_db($database_bd, $bd);
$query_RS = "UPDATE ContableMov SET CodigoDeposito = 0 WHERE Codigo = ".$_GET["Codigo"]." ";
$RS = mysql_query($query_RS, $bd) or die(mysql_error());
  	header("Location: ".$_SERVER['PHP_SELF']."?CodigoDeposito=". $_GET['CodigoDeposito']);
}


mysql_select_db($database_bd, $bd);
$query_RS_Cheques_Caja = "SELECT * FROM ContableMov WHERE CodigoCuenta = 10 AND Tipo = 3 AND CodigoDeposito = 0 ORDER BY Fecha, Referencia DESC";
$RS_Cheques_Caja = mysql_query($query_RS_Cheques_Caja, $bd) or die(mysql_error());
$row_RS_Cheques_Caja = mysql_fetch_assoc($RS_Cheques_Caja);
$totalRows_RS_Cheques_Caja = mysql_num_rows($RS_Cheques_Caja);

mysql_select_db($database_bd, $bd);
$query_RS_Depositos_sw0 = "SELECT * FROM Deposito WHERE SW = 0 ORDER BY CodigoDeposito DESC";
$RS_Depositos_sw0 = mysql_query($query_RS_Depositos_sw0, $bd) or die(mysql_error());
$row_RS_Depositos_sw0 = mysql_fetch_assoc($RS_Depositos_sw0);
$totalRows_RS_Depositos_sw0 = mysql_num_rows($RS_Depositos_sw0);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" valign="top"><table width="420" border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td colspan="6" align="left" class="subtitle">Cheques en caja</td>
        </tr>
      <tr>
        <td align="center" class="NombreCampoTopeWin">Fecha</td>
        <td align="center" class="NombreCampoTopeWin">Banco</td>
        <td align="center" class="NombreCampoTopeWin">Cuenta</td>
        <td align="center" class="NombreCampoTopeWin">Ref</td>
        <td align="center" class="NombreCampoTopeWin">Monto</td>
        <td align="center" class="NombreCampoTopeWin">&nbsp;</td>
      </tr>
      <?php do { ?>
      <tr class="ListadoPar">
        <td nowrap="nowrap"><?php echo $row_RS_Cheques_Caja['Fecha']; ?></td>
        <td nowrap="nowrap"><?php echo $row_RS_Cheques_Caja['ReferenciaBanco']; ?></td>
        <td nowrap="nowrap">
          <form id="form2" name="form2" method="POST" action="<?php echo $editFormAction; ?>">
            <label>
            <input name="NumCuenta" type="text" id="NumCuenta" value="<?php echo $row_RS_Cheques_Caja['NumCuenta']; ?>" size="19" />
            </label>
                    <label>
                    <input type="submit" name="button" id="button" value="G" />
                    </label>
                    <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $row_RS_Cheques_Caja['Codigo']; ?>" />
                    <input type="hidden" name="MM_update" value="form2" />
          </form>          </td>
        <td align="right" nowrap="nowrap"><?php echo $row_RS_Cheques_Caja['Referencia']; ?></td>
        <td align="right" nowrap="nowrap"><?php // echo Fnum($row_RS_Cheques_Caja['MontoHaber']); ?>
          <?php 
$SQL = "SELECT SUM(MontoHaber) FROM ContableMov WHERE Referencia='".$row_RS_Cheques_Caja['Referencia']."' AND ReferenciaBanco='".$row_RS_Cheques_Caja['ReferenciaBanco']."' GROUP BY Referencia";
mysql_select_db($database_bd, $bd);
$Result1 = mysql_query($SQL, $bd) or die(mysql_error());	
$row = mysql_fetch_assoc($Result1);
echo $row['SUM(MontoHaber)'];	
		
		?>&nbsp;</td>
        <td align="right" nowrap="nowrap"><?php if(isset($_GET['CodigoDeposito'])) { ?><a href="Deposito_Crear.php?CodigoDeposito=<?php echo $_GET['CodigoDeposito']; ?>&Agregar=1&Codigo=<?php echo $row_RS_Cheques_Caja['Codigo']; ?>">-&gt;</a><?php } ?></td>
      </tr>
      <?php } while ($row_RS_Cheques_Caja = mysql_fetch_assoc($RS_Cheques_Caja)); ?>
    </table></td>
    <td width="50%" valign="top"><table width="420" border="1" align="center" cellpadding="3" cellspacing="0">
          <tr >
            <td colspan="6" nowrap="nowrap" class="subtitle"><form name="form" id="form">
                Ir al deposito &gt;&gt; 
                <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
              <option value="Deposito_Crear.php" <?php if (!(strcmp("Seleccione", $_GET['CodigoDeposito']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <?php
do {  
?>
                  <option value="Deposito_Crear.php?CodigoDeposito=<?php echo $row_RS_Depositos_sw0['CodigoDeposito']?>"<?php if (!(strcmp($row_RS_Depositos_sw0['CodigoDeposito'], $_GET['CodigoDeposito']))) {echo "selected=\"selected\""; $Referencia=$row_RS_Depositos_sw0['Numero'];} ?>><?php echo $row_RS_Depositos_sw0['Numero']?></option>
                  <?php
} while ($row_RS_Depositos_sw0 = mysql_fetch_assoc($RS_Depositos_sw0));
  $rows = mysql_num_rows($RS_Depositos_sw0);
  if($rows > 0) {
      mysql_data_seek($RS_Depositos_sw0, 0);
	  $row_RS_Depositos_sw0 = mysql_fetch_assoc($RS_Depositos_sw0);
  }
?>
                </select>
            </form></td>
          </tr>
          <tr>
            <td colspan="6" nowrap="nowrap"><a href="Deposito_Crear.php?NuevoDeposito=1">Nuevo deposito</a></td>
          </tr>
<?php if(isset($_GET['CodigoDeposito'])) {?>          
<tr>
            <td colspan="5" nowrap="nowrap"><form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
              <label> Modifica Num Depósito=
                <input name="Referencia" type="text" id="Referencia" value="<?php echo $Referencia; ?>" size="15" />
                <input name="CodigoDeposito" type="hidden" id="CodigoDeposito" value="<?php echo $_GET["CodigoDeposito"] ?>" />
              </label>
              <label>
                <input type="submit" name="G" id="G" value="G" />
              </label>
              <input type="hidden" name="MM_update2" value="form1" />
            </form></td>
            <td align="right" nowrap="nowrap"><a href="Deposito_Imprimir.php?CodigoDeposito=<?php echo $_GET['CodigoDeposito'] ?>" target="_blank">Imprimir</a></td>
          </tr>

          <tr>
            <td nowrap="nowrap" class="NombreCampoTopeWin">&nbsp;</td>
            <td nowrap="nowrap" class="NombreCampoTopeWin">Fecha</td>
            <td nowrap="nowrap" class="NombreCampoTopeWin">Banco</td>
            <td nowrap="nowrap" class="NombreCampoTopeWin">Num Cuenta</td>
            <td nowrap="nowrap" class="NombreCampoTopeWin">Ref</td>
            <td nowrap="nowrap" class="NombreCampoTopeWin">Monto</td>
          </tr>
          <?php 
$colname_RS_Cheques_Procesando = "-2";
if (isset($_GET['CodigoDeposito'])) {
  $colname_RS_Cheques_Procesando = $_GET['CodigoDeposito'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Cheques_Procesando = sprintf("SELECT * FROM ContableMov WHERE CodigoDeposito = %s AND ReferenciaBanco='Mercantil' GROUP BY Referencia ORDER BY ReferenciaBanco ASC", GetSQLValueString($colname_RS_Cheques_Procesando, "int"));
$RS_Cheques_Procesando = mysql_query($query_RS_Cheques_Procesando, $bd) or die(mysql_error());
$row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando);
$totalRows_RS_Cheques_Procesando = mysql_num_rows($RS_Cheques_Procesando);
		  if($totalRows_RS_Cheques_Procesando>0){ ?>
          <?php do { ?>
            <tr>
              <td nowrap="nowrap" class="ListadoPar"><a href="Deposito_Crear.php?CodigoDeposito=<?php echo $_GET['CodigoDeposito']; ?>&Eliminar=1&Codigo=<?php echo $row_RS_Cheques_Procesando['Codigo']; ?>">&lt;-</a></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['Fecha']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['ReferenciaBanco']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['NumCuenta']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['Referencia']; ?></td>
              <td align="right" nowrap="nowrap" class="ListadoPar"><?php 

$SQL = "SELECT SUM(MontoHaber) FROM ContableMov WHERE Referencia='".$row_RS_Cheques_Procesando['Referencia']."' GROUP BY Referencia";
mysql_select_db($database_bd, $bd);
$Result1 = mysql_query($SQL, $bd) or die(mysql_error());	
$row = mysql_fetch_assoc($Result1);
//echo $row['SUM(MontoHaber)'];	
		
		?><?php echo Fnum($row['SUM(MontoHaber)']); ?><?php $SubTotal1+=$row['SUM(MontoHaber)']; ?></td>
          </tr>
            <?php } while ($row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando)); ?>
          <tr>
            <td colspan="5" align="right" class="NombreCampo">Sub Total Ch. Banco Mercantil</td>
            <td align="right" class="RTitulo"><?php echo Fnum($SubTotal1); ?></td>
          </tr><?php } ?>
          <?php 
$colname_RS_Cheques_Procesando = "-2";
if (isset($_GET['CodigoDeposito'])) {
  $colname_RS_Cheques_Procesando = $_GET['CodigoDeposito'];
}
mysql_select_db($database_bd, $bd);
$query_RS_Cheques_Procesando = sprintf("SELECT * FROM ContableMov WHERE CodigoDeposito = %s AND ReferenciaBanco<>'Mercantil' GROUP BY Referencia ORDER BY ReferenciaBanco ASC", GetSQLValueString($colname_RS_Cheques_Procesando, "int"));
$RS_Cheques_Procesando = mysql_query($query_RS_Cheques_Procesando, $bd) or die(mysql_error());
$row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando);
$totalRows_RS_Cheques_Procesando = mysql_num_rows($RS_Cheques_Procesando);
		   if($totalRows_RS_Cheques_Procesando>0){  ?>
          <?php do { ?>
          <tr>
            <td nowrap="nowrap" class="ListadoPar"><a href="Deposito_Crear.php?CodigoDeposito=<?php echo $_GET['CodigoDeposito']; ?>&Eliminar=1&Codigo=<?php echo $row_RS_Cheques_Procesando['Codigo']; ?>">&lt;-</a></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['Fecha']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['ReferenciaBanco']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['NumCuenta']; ?></td>
              <td nowrap="nowrap" class="ListadoPar"><?php echo $row_RS_Cheques_Procesando['Referencia']; ?></td>
              <td align="right" nowrap="nowrap" class="ListadoPar">
              <?php 

$SQL = "SELECT SUM(MontoHaber) FROM ContableMov WHERE Referencia='".$row_RS_Cheques_Procesando['Referencia']."' GROUP BY Referencia";
mysql_select_db($database_bd, $bd);
$Result1 = mysql_query($SQL, $bd) or die(mysql_error());	
$row = mysql_fetch_assoc($Result1);
//echo $row['SUM(MontoHaber)'];	
		
		?>
              <?php echo Fnum($row['SUM(MontoHaber)']); ?><?php $SubTotal2+=$row['SUM(MontoHaber)']; ?>
              </td>
            </tr>
            <?php } while ($row_RS_Cheques_Procesando = mysql_fetch_assoc($RS_Cheques_Procesando)); ?>
          <tr>
            <td colspan="5" align="right" class="NombreCampo">Sub Total Ch. otros Bancos</td>
            <td align="right" class="RTitulo"><?php echo Fnum($SubTotal2); ?></td>
          </tr><?php } ?>
          <?php $GranTotal = $SubTotal1+$SubTotal2; 
		  if ($GranTotal>0){
		  ?>
          <tr>
            <td colspan="5" align="right" class="NombreCampo">Total Deposito</td>
            <td align="right" class="RTitulo"><?php echo Fnum($GranTotal); ?></td>
          </tr><?php }} ?>
            </table>
</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_Cheques_Caja);

//mysql_free_result($RS_Cheques_Procesando);

mysql_free_result($RS_Depositos_sw0);
?>
