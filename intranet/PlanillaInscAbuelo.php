<?php 
$MM_authorizedUsers = "2";
require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Abuelos (Creador, Nexo, Nombres, Apellidos, LugarDeNacimiento, PaisDeNacimiento, Vive) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['LugarDeNacimiento'], "text"),
                       GetSQLValueString($_POST['PaisDeNacimiento'], "text"),
                       GetSQLValueString($_POST['Vive'], "text"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());

$CodigoAlumno = $_POST['CodigoAlumno'];
$CodigoRepresentante = mysql_insert_id();
$Nexo = $_POST['Nexo'];	
$SWrepre='0';
 
$sql_insert = "INSERT INTO RepresentanteXAlumno 
				(CodigoAlumno, CodigoRepresentante, Nexo, SW_Representante) 
				VALUES 
				('$CodigoAlumno', '$CodigoRepresentante', '$Nexo', '$SWrepre')";
$Result1 = mysql_query($sql_insert, $bd) or die(mysql_error());


  $insertGoTo = "index.php";
 /* if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Abuelos SET Creador=%s, Nexo=%s, Nombres=%s, Apellidos=%s, LugarDeNacimiento=%s, PaisDeNacimiento=%s, Vive=%s WHERE CodigoAbuelo=%s",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['LugarDeNacimiento'], "text"),
                       GetSQLValueString($_POST['PaisDeNacimiento'], "text"),
                       GetSQLValueString($_POST['Vive'], "text"),
                       GetSQLValueString($_POST['CodigoAbuelo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());

  $updateGoTo = "index.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

$Creador_RS_Abuelo = "0";
if (isset($_COOKIE['MM_Username'])) {
  $Creador_RS_Abuelo = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
}
$colname_RS_Abuelo = "0";
if (isset($_GET['CodigoRepresentante'])) {
  $colname_RS_Abuelo = (get_magic_quotes_gpc()) ? $_GET['CodigoRepresentante'] : addslashes($_GET['CodigoRepresentante']);
}
mysql_select_db($database_bd, $bd);
$query_RS_Abuelo = sprintf("SELECT * FROM Abuelos WHERE CodigoAbuelo = '%s' AND Creador = '%s'", $colname_RS_Abuelo,$Creador_RS_Abuelo);
$RS_Abuelo = mysql_query($query_RS_Abuelo, $bd) or die(mysql_error());
$row_RS_Abuelo = mysql_fetch_assoc($RS_Abuelo);
$totalRows_RS_Abuelo = mysql_num_rows($RS_Abuelo);

?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="google-site-verification" content="uCJ89hMiFA3PQcDx27Y2aAfIrDaon9rzD_jNGEEmc3w" />
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../n/CSS/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
<link href="../estilos2.css" rel="stylesheet" type="text/css">
<link href="../estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<!-- ImageReady Slices (index.psd) -->
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="../img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_04.jpg" width="31" height="191" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="../img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td>&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="../img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="../img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php include('../inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php $subDir = '../'; ?><?php include('../inc_menu.php'); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
            <p><img src="../img/b.gif" width="740" height="1"></p>
            <p class="Tit_Pagina">Datos de <?php echo $_GET[Nexo]; ?></p>
            




      <form method="post" name="form1" action=<?php echo $editFormAction; ?>>
        <table width="600" align="center">
        <tr valign="baseline">
          <td colspan="2" align="right" nowrap><div align="left" class="MensajeDeError"><strong>Indique los datos de: <?php echo $_GET[Nexo]; ?>
            </strong></div></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">
            <input name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno'] ?>" type="hidden" >
            <input name="Creador" type="hidden" id="Creador" value="<?php echo $_COOKIE['MM_Username']; ?>">
            <input name="Nexo" type="hidden" id="Nexo" value="<?php echo $_GET[Nexo]; ?>">
            <input name="CodigoAbuelo" type="hidden" id="CodigoAbuelo" value="<?php echo $row_RS_Abuelo['CodigoAbuelo'];   ?>">
            Vive</td><td class="FondoCampo">
              <input type="radio" name="Vive" value="Si" <?php if ($row_RS_Abuelo['Vive']=='Si') echo checked;  ?>>
              Si 
              <br>
              <input type="radio" name="Vive" value="No" <?php if ($row_RS_Abuelo['Vive']=='No') echo checked;  ?>>
              No -&gt;  igualmente favor completar</td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">Nombres:</td>
          <td class="FondoCampo"><input type="text" name="Nombres" value="<?php echo $row_RS_Abuelo['Nombres'];   ?>" size="20"></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">Apellidos:</td>
          <td class="FondoCampo"><input type="text" name="Apellidos" value="<?php echo $row_RS_Abuelo['Apellidos'];   ?>" size="20"></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">Lugar de Nacimiento:</td>
          <td class="FondoCampo"><input type="text" name="LugarDeNacimiento" value="<?php echo $row_RS_Abuelo['LugarDeNacimiento'];   ?>" size="20"></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">Pa&iacute;s de Nacimiento:</td>
          <td class="FondoCampo"><input type="text" name="PaisDeNacimiento" value="<?php echo $row_RS_Abuelo['PaisDeNacimiento'];   ?>" size="20"></td>
          </tr>
        <tr valign="baseline">
          <td colspan="2" align="right" nowrap><div align="center">
            <input type="submit" value="Guardar">
            <br>
            (si no guarda verifique datos faltantes en la planilla)<br>
            </div>            </td>
          </tr>
        </table>
      <?php if ($totalRows_RS_Abuelo == 1) { ?>
      <input type="hidden" name="MM_update" value="form1"><?php } else {  ?>
      <input type="hidden" name="MM_insert" value="form1"><?php }?>
  </form>
  
  
            </td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td valign="top" bgcolor="#EECCA6" class="medium">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
        </table>
		  <p>&nbsp;</p>
	    <p>&nbsp;</p></td>
  </tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF">
			<img src="../img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="../img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>
  
<?php
mysql_free_result($RS_Abuelo);
?>