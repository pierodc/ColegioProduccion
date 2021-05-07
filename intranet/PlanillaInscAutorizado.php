<?php 
$MM_authorizedUsers = "2";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO Representante (Creador, Nexo, Cedula, Apellidos, Nombres, TelHab, TelCel, TelTra, Email1, Email2, Direccion, Urbanizacion, Ciudad, CodPostal, Ocupacion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['Ocupacion'], "text"));

  //mysql_select_db($database_bd, $bd);
  $Result1 = $mysqli->query($insertSQL); //mysql_query($insertSQL, $bd) or die(mysql_error());

$CodigoAlumno = $_POST['CodigoAlumno'];
$CodigoRepresentante = $mysqli->insert_id; //mysql_insert_id();
$Nexo = $_POST['Nexo'];	
$SWrepre='0';
 
$sql_insert = "INSERT INTO RepresentanteXAlumno 
				(CodigoAlumno, CodigoRepresentante, Nexo, SW_Representante) 
				VALUES 
				('$CodigoAlumno', '$CodigoRepresentante', '$Nexo', '$SWrepre')";
$Result1 = $mysqli->query($sql_insert); //mysql_query($sql_insert, $bd) or die(mysql_error());

  $insertGoTo = "index.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE Representante SET Creador=%s, Nexo=%s, Cedula=%s, Apellidos=%s, Nombres=%s, TelHab=%s, TelCel=%s, TelTra=%s, Email1=%s, Email2=%s, Direccion=%s, Urbanizacion=%s, Ciudad=%s, CodPostal=%s, Ocupacion=%s WHERE CodigoRepresentante=%s",
                       GetSQLValueString($_POST['Creador'], "text"),
                       GetSQLValueString($_POST['Nexo'], "text"),
                       GetSQLValueString($_POST['Cedula'], "text"),
                       GetSQLValueString($_POST['Apellidos'], "text"),
                       GetSQLValueString($_POST['Nombres'], "text"),
                       GetSQLValueString($_POST['TelHab'], "text"),
                       GetSQLValueString($_POST['TelCel'], "text"),
                       GetSQLValueString($_POST['TelTra'], "text"),
                       GetSQLValueString($_POST['Email1'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['Direccion'], "text"),
                       GetSQLValueString($_POST['Urbanizacion'], "text"),
                       GetSQLValueString($_POST['Ciudad'], "text"),
                       GetSQLValueString($_POST['CodPostal'], "text"),
                       GetSQLValueString($_POST['Ocupacion'], "text"),
                       GetSQLValueString($_POST['CodigoRepresentante'], "int"));

  //mysql_select_db($database_bd, $bd);
  $Result1 = $mysqli->query($updateSQL); //mysql_query($updateSQL, $bd) or die(mysql_error());

  $updateGoTo = "index.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  header(sprintf("Location: %s", $updateGoTo));
}

//mysql_select_db($database_bd, $bd);
$query_Recordset1 = "SELECT * FROM Representante";
$Recordset1 = $mysqli->query($query_Recordset1); //
$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;

//$Recordset1 = mysql_query($query_Recordset1, $bd) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$Creador_RS_Repre = "0";
if (isset($_COOKIE['MM_Username'])) {
  $Creador_RS_Repre = $_COOKIE['MM_Username'] ;
}
$colname_RS_Repre = "0";
if (isset($_GET['CodigoRepresentante'])) {
  $colname_RS_Repre = $_GET['CodigoRepresentante'] ;
}
//mysql_select_db($database_bd, $bd);
$query_RS_Repre = sprintf("SELECT * FROM Representante WHERE CodigoRepresentante = '%s' AND Creador = '%s'", $colname_RS_Repre,$Creador_RS_Repre);
$RS_Repre = $mysqli->query($query_RS_Repre); //
$row_RS_Repre = $RS_Repre->fetch_assoc();
$totalRows_RS_Repre = $RS_Repre->num_rows;


//$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
//$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
//$totalRows_RS_Repre = mysql_num_rows($RS_Repre);
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
<style type="text/css">
.style1 {color: #0000FF}
</style>
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
            <p class="Tit_Pagina">Datos Persona Autorizada</p>
            
      <form name="form1" method="post" action="<?php echo $editFormAction; ?>">
      <p>&nbsp;</p>
      <table width="80%"  border="0" align="center">
        <tr>
          <td colspan="4" class="subtitle">Datos Personales
              
              <input name="CodigoRepresentante" type="hidden" value="<?php echo $_GET[CodigoRepresentante]; ?>">
              <input name="CodigoAlumno" value="<?php echo $_GET['CodigoAlumno'] ?>" type="hidden" ></td>
        </tr>
        <tr>
          <td class="NombreCampo"><input name="Creador" type="hidden" id="Creador" value="<?php echo $_COOKIE['MM_Username']; ?>">
            Apellidos                </td>
          <td class="FondoCampo"><span id="sprytextfield1">
            <input name="Apellidos" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Apellidos']; ?>" >
            <span class="textfieldRequiredMsg">Requerido</span></span></td>
          <td class="NombreCampo"><input name="Nexo" type="hidden" id="Nexo" value="<?php if($_GET['Nexo']!='Autorizado') echo $_GET['Nexo']; else echo "Autorizado"; ?>">
            Nexo</td>
          <td class="FondoCampo"><?php  if($_GET['Nexo']=='Autorizado') { ?><span id="sprytextfield3"><input name="Ocupacion" type="text" class="TextosSimples" id="Ocupacion" value="<?php echo $row_RS_Repre['Ocupacion']; ?>" size="20"><span class="textfieldRequiredMsg">Requerido</span></span>
            <?php } else { ?><input name="Ocupacion" type="hidden" value="<?php echo $_GET['Nexo']; ?>"><?php echo $_GET['Nexo']; ?><?php } ?>
            </td>
        </tr>
        <tr>
          <td class="NombreCampo">Nombres</td>
          <td nowrap class="FondoCampo"><span id="sprytextfield2">
            <input name="Nombres" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Nombres']; ?>" >
            <span class="textfieldRequiredMsg">Requerido</span></span></td>
          <td class="NombreCampo">C&eacute;dula</td>
          <td class="FondoCampo"><span id="sprytextfield4">
            <input name="Cedula" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Cedula']; ?>" >
            <span class="textfieldRequiredMsg">Requerido</span></span></td>
        </tr>
        <tr>
          <td colspan="4" class="subtitle">Informaci&oacute;n de Contacto</td>
        </tr>
        <tr>
          <td class="NombreCampo">Tel&eacute;fono Habitaci&oacute;n</td>
          <td class="FondoCampo"><span id="sprytextfield5">
          <input name="TelHab" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelHab']; ?>" >
<span class="textfieldMinCharsMsg">Invalido</span><span class="textfieldMaxCharsMsg">Inv&aacute;lido</span></span></td>
          <td class="NombreCampo">Email principal </td>
          <td class="FondoCampo"><span id="sprytextfield8">
          <input name="Email1" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Email1']; ?>" >
          <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
        </tr>
        <tr>
          <td class="NombreCampo">Tel&eacute;fono Celular</td>
          <td class="FondoCampo"><span id="sprytextfield6">
          <input name="TelCel" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelCel']; ?>" >
          <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldMinCharsMsg">Inv&aacute;lido</span></span></td>
          <td class="NombreCampo">Email secundario </td>
          <td class="FondoCampo"><span id="sprytextfield9">
          <input name="Email2" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Email2']; ?>" >
          <span class="textfieldInvalidFormatMsg">Inv&aacute;lido</span></span></td>
        </tr>
        <tr>
          <td class="NombreCampo">Tel&eacute;fono Trabajo</td>
          <td class="FondoCampo"><span id="sprytextfield7">
          <input name="TelTra" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['TelTra']; ?>" >
          <span class="textfieldMinCharsMsg">Minimum number of characters not met.</span> <span class="textfieldMaxCharsMsg">Inválido</span></span></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="NombreCampo">Direcci&oacute;n</td>
          <td class="FondoCampo"><span id="sprytextarea1">
            <textarea name="Direccion" cols="30" rows="4" class="TextosSimples"><?php echo $row_RS_Repre['Direccion']; ?></textarea>
            <span class="textareaRequiredMsg">Requerido</span></span></td>
          <td colspan="2"><table width="100%"  border="0">
              <tr>
                <td class="NombreCampo">Urbanizaci&oacute;n</td>
                <td class="FondoCampo"><span id="sprytextfield10">
                  <input name="Urbanizacion" type="text" class="TextosSimples" size="20" value="<?php echo $row_RS_Repre['Urbanizacion']; ?>" >
                  <span class="textfieldRequiredMsg">Requerido</span></span></td>
              </tr>
              <tr>
                <td class="NombreCampo">Ciudad</td>
                <td class="FondoCampo"><span id="sprytextfield11">
                  <input name="Ciudad" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['Ciudad']; ?>" >
                  <span class="textfieldRequiredMsg">Requerido</span></span></td>
              </tr>
              <tr>
                <td class="NombreCampo">Cod Postal</td>
                <td class="FondoCampo"><input name="CodPostal" type="text" class="TextosSimples"  size="20" value="<?php echo $row_RS_Repre['CodPostal']; ?>" ></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" value="Guardar"></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <p>
        <?php if ($totalRows_RS_Repre == 1) { ?>
        <input type="hidden" name="MM_update" value="form1">
        <?php } else {  ?>
        <input type="hidden" name="MM_insert" value="form1">
        <?php }?>
</p>      </form>

        <script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["change"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {minChars:7, maxChars:20, validateOn:["change"], isRequired:false});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {minChars:11, validateOn:["change"], isRequired:false});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {isRequired:false, minChars:7, maxChars:20, validateOn:["change"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "email", {isRequired:false, validateOn:["blur", "change"]});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "email", {isRequired:false, validateOn:["blur", "change"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["change"]});
var sprytextfield10 = new Spry.Widget.ValidationTextField("sprytextfield10", "none", {validateOn:["change"]});
var sprytextfield11 = new Spry.Widget.ValidationTextField("sprytextfield11", "none", {validateOn:["change"]});
//-->
        </script>
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