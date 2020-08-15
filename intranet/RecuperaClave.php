<?php 
$MM_authorizedUsers = "";
require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 

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
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../n/images/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="../n/images/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="../n/images/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../n/images/index_04.jpg" width="31" height="191" alt=""></td>
  </tr>
	<tr>
		<td colspan="4">
			<img src="../n/images/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="../n/images/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="765" height="67">
          <param name="movie" value="../n/flash/botonera-principal.swf">
          <param name="quality" value="high">
          <embed src="../n/flash/botonera-principal.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="765" height="67"></embed>
	    </object></td>
  <td bgcolor="#FFF8E8">
			<img src="../n/images/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="../n/images/index_10.jpg" width="1025" height="6" alt=""></td>
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
            
<img src="../img/b.gif" width="740" height="1"><br>
            
<p class="Tit_Pagina">Recuperar Clave</p>
            



<span class="MensajeDeError"><strong>
	<?php
$colname_Recordset1 = "0";
if (isset($_POST['UsuarioLost'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['UsuarioLost'] : addslashes($_POST['UsuarioLost']);
  $colname_Recordset1 = strtolower($colname_Recordset1);
}
$query_Recordset1 = sprintf("SELECT * FROM Usuario WHERE Usuario = '%s'", $colname_Recordset1);

$Recordset1 = $mysqli->query($query_Recordset1);
$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;
if($totalRows_Recordset1 == 1){
	$Email = $row_Recordset1['Email'];
	$Usuario =  $row_Recordset1['Usuario'];
	$Clave = $row_Recordset1['Clave'];
	}


/*
if($totalRows_Recordset1 == 0){
	$query_Recordset1 = sprintf("SELECT * FROM Empleado WHERE Email = '%s' or Usuario = '%s'", $colname_Recordset1);
	$Recordset1 = $mysqli->query($query_Recordset1);
	$row_Recordset1 = $Recordset1->fetch_assoc();
	$totalRows_Recordset1 = $Recordset1->num_rows;
	if($totalRows_Recordset1 == 1){
		$Email = $row_Recordset1['Email'];
		$Usuario =  $row_Recordset1['Usuario'];
		$Clave = $row_Recordset1['Clave'];
	}

	}
*/



if (isset($_POST['UsuarioLost']) and ($totalRows_Recordset1==1) ) {
$para  =  $Email; // . ', '; // note la coma 
//$para .= 'colegio@sanfrancisco.e12.ve';

// asunto
$asunto = 'Clave del Colegio San Francisco de A.';
// mensaje
$mensaje = '
<html>
<head>
  <title>Clave del Colegio</title>
</head>
<body>
  <p>Su nombre de usuario es: '.$Usuario.'</p>
  <p>Su Clave: '.$Clave.'</p>
</body>
</html>
';

// Para enviar correo HTML, la cabecera Content-type debe definirse
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Cabeceras adicionales
//$cabeceras .= 'To: María <maria@example.com>, Kelly <kelly@example.com>' . "\r\n";
$cabeceras .= 'From:Colegio San Francisco de A.<colegio@sanfrancisco.e12.ve>' . "\r\n";
//$cabeceras .= 'Cc:colegiosanfrancisco.e12.ve' . "\r\n";
//$cabeceras .= 'Bcc:colegio@sanfrancisco.e12.ve' . "\r\n";
// Enviarlo
mail($para, $asunto, $mensaje, $cabeceras); 
}




?>
	</strong></span>
	<?php if (isset($_POST['UsuarioLost']) and ($totalRows_Recordset1==0) ) {?><p align="center" class="MensajeDeError"><strong>El nombre de usuario / Email no existe</strong></p>
      <p align="center" class="TextosSimples12"><strong><a href="RegistroUsuario.php">Registrese</a> o Vuelva al <a href="../index.php">Home</a> </strong></p>
      <?php }?>
	<?php if (isset($_POST['UsuarioLost']) and ($totalRows_Recordset1==1) ) {?>
      <p align="center" class="MensajeDeError"><strong>La clave fue enviada a su correo
      </strong></p>
      <p align="center"><span class="TextosSimples12"><strong> Vuelva al <a href="../index.php">Home</a></strong></span></p>
      <?php }?>
	<?php if (!isset($_POST['UsuarioLost'])) {?>
      <form name="form1" method="post" action="">
        <table width="300" border="0" align="center">
          <tr>
            <td colspan="2" class="subtitle"><div align="center">Ingrese su direcci&oacute;n de Email </div></td>
            </tr>
          <tr>
            <td class="NombreCampo">Email</td>
            <td class="FondoCampo"><input name="UsuarioLost" type="text" id="Usuario" size="80">              </td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
              <p>
                <input type="submit" name="Submit" value="Enviar">
                <br>
                Si no le llega la clave a la bandeja de entrada, <br>
                b&uacute;sque en la carpeta de correo no deseado (SPAM) </p>
              </div></td>
            </tr>
        </table>
      </form><?php } ?>


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
			<img src="../n/images/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../n/images/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="../n/images/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
</body>
</html>