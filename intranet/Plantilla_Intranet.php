<?php 
if(true){
$MM_authorizedUsers = "2,91,docente";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

if($MM_UserGroup == 'docente')
	header("Location: "."http://www.colegiosanfrancisco.com/Docente/index.php");


?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Colegio San Francisco de As&iacute;s</title>

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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_01.jpg" width="31" height="191" alt=""></td>
		<td colspan="2" align="left" bgcolor="#0A1B69">
			<img src="../img/TitSol.jpg" width="197" height="191" alt=""><img src="../img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="../img/index_04.jpg" width="31" height="191" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
			<img src="../img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#F7F1E1">
			<img src="../img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F7F1E1">&nbsp;</td>
		<td align="center" bgcolor="#F7F1E1">&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="../img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
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
<img src="../img/b.gif" width="740" height="1"><br>
  
<p class="TituloPagina">&nbsp; Cargar Fotos</p>
<table width="98%"  border="0" align="center" cellspacing="5" cellpadding="2">
  <tr>
      <td width="50" align="center" >&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
<?php if (false){ ?>  
<?php } ?>
  
  <tr>
    <td align="center" class="TextosSimples">Si necesita asistencia con el uso del sistema, <br>
      env&iacute;e un email a: <a href="mailto:piero@sanfrancisco.e12.ve">piero@sanfrancisco.e12.ve</a> o <br>
       por Whatsapp  0414.303.44.44</td>
  </tr>
</table></td>
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
		<td colspan="4" align="center" bgcolor="#54587D">
			<p><img src="../img/Pie1.jpg" width="1025" height="9" alt=""></p></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="../img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font> </td>
<td align="right" bgcolor="#0A1B69">
			<img src="../img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
<?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html><?php } ?>