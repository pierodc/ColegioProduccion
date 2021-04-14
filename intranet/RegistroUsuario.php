<?php 
$MM_authorizedUsers = "";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="RegistroUsuario.php?error=UsExiste";
  $loginUsername = $_POST['Usuario'];
  $LoginRS__query = "SELECT Usuario FROM Usuario WHERE Usuario='" . $loginUsername . "'";
  mysql_select_db($database_bd, $bd);
  $LoginRS=mysql_query($LoginRS__query, $bd) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}


// SUMATORIA DE CAMPOR ESTADISTICOS
$ActividadesExtra = "Desea Act. Extra: ".$_POST['SWactSI'].$_POST['SWactNO'];
$ActividadesExtra.= ": ".$_POST['Act1'].", ".$_POST['Act2'].", ".$_POST['Act3'].", ";
$ActividadesExtra.= $_POST['Act4'].", ".$_POST['Act5'].", ".$_POST['Act6'].", ";
$ActividadesExtra.= $_POST['Act7'].", ".$_POST['Act8'].", ".$_POST['Act9'].", ";
$ActividadesExtra.= $_POST['Act10'].", ".$_POST['Act11'].", ".$_POST['Act12'].", ".$_POST['Act13'];

$ComoLlego = "Lleg&oacute; por: ".$_POST['ck1']." ".$_POST['ck2'];
if($_POST['ck3']>""){ $ComoLlego .= " Familiar: ". $_POST['FamQuien']." Estudia: ".$_POST['FamQuienEst']; }
if($_POST['ck4']>""){ $ComoLlego .= " Amigo: ". $_POST['AmiQuien']." Estudia: ".$_POST['AmiQuienEst']; }
if($_POST['ck5']>""){ $ComoLlego .= " Otro: ". $_POST['Otro']; }
  

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO Usuario (Usuario, Clave, Nombres, Apellidos, Telefonos, Email, Privilegios, FechaCreacion, IPcreacion, ComoLlego, ActividadesExtra) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Nombres'])), "text"),
                       GetSQLValueString(ucwords(strtolower($_POST['Apellidos'])), "text"),
                       GetSQLValueString($_POST['Telefonos'], "text"),
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Privilegios'], "text"),
                       GetSQLValueString($_POST['FechaCreacion'], "date"),
                       GetSQLValueString($_POST['IPCreacion'], "text"),
                       GetSQLValueString($ComoLlego, "text"),
                       GetSQLValueString($ActividadesExtra, "text"));

  //mysql_select_db($database_bd, $bd);
  //$Result1 = mysql_query($insertSQL, $bd) or die(mysql_error());
	$Result1 = $mysqli->query($insertSQL);
	
	
  $insertGoTo = "../index.php?registroOK=1";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="google-site-verification" content="uCJ89hMiFA3PQcDx27Y2aAfIrDaon9rzD_jNGEEmc3w" />
<link rel="shortcut icon" href="../img/favicon.ico">
<link href="../n/CSS/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<style type="text/css">
.style1 {color: #0000FF}
</style>
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../estilos2.css" rel="stylesheet" type="text/css">
<link href="../estilos.css" rel="stylesheet" type="text/css">
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
			<img src="/img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="/img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="/img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="/img/index_04.jpg" width="31" height="191" alt=""></td>
  </tr>
	<tr>
		<td colspan="4">
			<img src="/img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td>&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="/img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="/img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php //include('../inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php $subDir = '../'; ?><?php include('../inc_menu.php'); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
            
<img src="../img/b.gif" width="740" height="1"><br>
            
            




    
<p class="Tit_Pagina">Registro de usuario</p>
      <?php if ($_GET['error']=='UsExiste'){?>
<p align="center">
  <span class="MensajeDeError"><strong>El usuario ya existe intente otro nombre de usuario o<br> 
    si es usuario registrado <a href="../index.php">ingrese</a></strong></span> 
</p>  
<?php } ?>
<form method="POST" name="form" action="<?php echo $editFormAction; ?>">
  <table width="600" align="center">
    <tr valign="baseline">
      <td colspan="4" align="right" nowrap class="subtitle"><div align="left">Registro de Representante 
        <input type="hidden" name="FechaCreacion" id="hiddenField" value="<?php echo date('Y-m-d H:i:s'); ?>">
        <input type="hidden" name="IPCreacion" id="hiddenField2" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
        </div></td>
      </tr>
    <tr valign="baseline">
      <td  nowrap class="NombreCampo">
        Email</td>
      <td nowrap class="FondoCampo"><span id="sprytextfield6">
      <input type="text" name="Usuario" class="TextosSimples" value="" size="20">
      <span class="textfieldRequiredMsg">Requerido</span><span class="textfieldInvalidFormatMsg">Formato Inv&aacute;lido</span></span></td>
      <td class="NombreCampo">Clave</td>
      <td class="FondoCampo"><span id="sprytextfield7">
      <input name="Clave" type="text" class="TextosSimples" value="" size="20"><span class="textfieldRequiredMsg">Requerido</span><span class="textfieldMinCharsMsg">M&iacute;nimo 4 caracteres</span></span></td>
      </tr>
    <tr valign="baseline">
      <td class="NombreCampo">Apellidos</td>
      <td class="FondoCampo"><span id="sprytextfield4">
        <input name="Apellidos" type="text" class="TextosSimples" id="Apellidos" value="" size="20">
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td class="NombreCampo">Nombres</td>
      <td class="FondoCampo"><span id="sprytextfield3">
        <input name="Nombres" type="text" class="TextosSimples" id="Nombres" size="20">
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      </tr>
    <tr valign="baseline">
      <td class="NombreCampo">Tel&eacute;fono</td>
      <td class="FondoCampo"><span id="sprytextfield5">
        <input name="Telefonos" type="text" class="TextosSimples" id="Telefonos" value="" size="20">
        <span class="textfieldRequiredMsg">Requerido</span></span></td>
      <td class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
      </tr>
    <tr valign="baseline">
      <td colspan="4" align="right" nowrap class="subtitle"><div align="left">Otra informaci&oacute;n</div></td>
      </tr>
    <tr valign="baseline">
      <td colspan="4" class="NombreCampo"><div align="left">&iquest;C&oacute;mo se enter&oacute;
        del colegio?</div>
        <table width="100%" border="0">
          <tr>
            <td nowrap  class="FondoCampo">
              <span id="sprycheckbox2"><span class="checkboxRequiredMsg">Seleccione<br></span>
                <input name="ck1" type="checkbox" id="ck1" value="Pag Amarillas">
                Paginas Amarillas<br>
                <input name="ck2" type="checkbox" id="ck2" value="Internet">
                Internet
                <br>
                <input name="ck3" type="checkbox" id="ck3" value="Familiar">
                Familiar: Especifique: -- &gt;&gt;&gt; <br>
                <input name="ck4" type="checkbox" id="ck4" value="Amigo">
                Amigo: Especifique: -- &gt;&gt;&gt;<br>
                <input name="ck5" type="checkbox" id="ck5" value="Otro">
                Otro: Especifique
                : --&gt;&gt;&gt;                </span></label></td>
            <td align="left" valign="bottom" nowrap class="FondoCampo"  >
              &iquest;Qui&eacute;n?
              <input name="FamQuien" type="text" class="TextosSimples" id="FamQuien" size="15">
              &iquest;Estudia aqu&iacute;?
              <input name="FamQuienEst" type="text" class="TextosSimples" id="FamQuienEst" size="3">
              <br>
              &iquest;Qui&eacute;n?
              <input name="AmiQuien" type="text" class="TextosSimples" id="AmiQuien" size="15">
  &iquest;Estudia aqu&iacute;?
  <input name="AmiQuienEst" type="text" class="TextosSimples" id="textfield5" size="3">
  <br>
              <input name="Otro" type="text" class="TextosSimples" id="Otro" size="25"></td>
            </tr>
          </table><br>
        <div align="left">
          &iquest;Le interesan las actividades extracurriculares? </div></td>
      </tr>
    <tr valign="baseline">
      <td class="NombreCampo">Indique</td>
      <td colspan="3" class="FondoCampo">
        <label>
          <input name="SWactSI" type="checkbox" id="SWactSI" value="Si">
          SI
  <input name="SWactNO" type="checkbox" id="SWactNO" value="No">
          NO </label>
      </td>
      </tr>
    <tr valign="baseline">
      <td class="NombreCampo">&iquest;Cuales?</td>
      <td nowrap class="FondoCampo">
        <input name="Act1" type="checkbox" id="Act1" value="Italiano">
        Italiano (todos los niveles)<br>
        <input name="Act2" type="checkbox" id="Act2" value="Ingles">
        Ingles (todos los niveles)<br>
        <input name="Act3" type="checkbox" id="Act3" value="Matem&aacute;ticas">
        Matem&aacute;ticas<br>
        <input name="Act4" type="checkbox" id="Act4" value="Castellano">
        Castellano<br>
        <input name="Act5" type="checkbox" id="Act5" value="Tareas">
        Tareas Dirigidas<br>
        <input name="Act6" type="checkbox" id="Act6" value="Comedor">
        Comedor</label></td>
      <td nowrap class="FondoCampo"><input name="Act7" type="checkbox" id="Act7" value="Ajedrez">
        Ajedrez<br>
        <input name="Act8" type="checkbox" id="Act8" value="Pintura">
        Pintura<br>
        <input name="Act9" type="checkbox" id="Act9" value="Karate">
        Karate<br>
        <input name="Act10" type="checkbox" id="Act10" value="Danza">
        Danza<br>
        
        <input name="Act11" type="checkbox" id="Act11" value="Futbol">
        Futbol<br>
        <input name="Act12" type="checkbox" id="Act12" value="Computaci&oacute;n">
        Computaci&oacute;n<br>
        <input name="Act13" type="checkbox" id="Act13" value="Tennis">
        Tennis</td>
      <td class="FondoCampo">&nbsp;</td>
      </tr>
    <tr valign="baseline">
      <td class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
      <td class="NombreCampo">&nbsp;</td>
      <td class="FondoCampo">&nbsp;</td>
      </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap>&nbsp;</td>
      <td colspan="2"><input type="submit" value="Ingresar"></td>
      </tr>
    </table>
  <input type="hidden" name="Privilegios" value="2">
  <input type="hidden" name="MM_insert" value="form">
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("Usuario", "email", {validateOn:["blur", "change"], hint:"nombre@correo.com"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("Clave", "none", {minChars:4, validateOn:["blur", "change"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {validateOn:["blur", "change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {validateOn:["blur", "change"]});
var sprycheckbox2 = new Spry.Widget.ValidationCheckbox("sprycheckbox2", {validateOn:["blur", "change"]});
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sprycheckbox1", {validateOn:["blur", "change"], isRequired:false, minSelections:1, maxSelections:1});
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
			<img src="/img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="/img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="/img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
<script type="text/javascript">
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "email", {hint:"nombre@gmail.com", validateOn:["blur", "change"]});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {minChars:4});
</script>
</body>
</html>