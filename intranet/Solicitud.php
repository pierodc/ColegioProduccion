<?php 
$MM_authorizedUsers = "2";
require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('../inc/rutinas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$CodigoAlumno = $_POST['CodigoAlumno'];
	$sql_insert = "INSERT INTO Solicitud 
					(CodigoAlumno, Tipo, Descripcion, Departamento, UsuarioSolicitante) 
					VALUES 
					('$CodigoAlumno', '$Tipo', '$Descripcion', '$Departamento', '$MM_Username')";
	$mysqli->query($sql_insert);
}


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
            <p><img src="../img/b.gif" width="740" height="1"></p>
            <p class="Tit_Pagina">Solicitud de Documentos</p>
            




      <form method="post" name="form1" action=<?php echo $editFormAction; ?>>
        <table width="600" align="center">
        
<?php 
$sql = "SELECT * FROM Solicitud
		WHERE CodigoAlumno = '$CodigoAlumno'";
$RS = $mysqli->query($sql);
if($row = $RS->fetch_assoc() and false){
do{
	extract($row);
?>        
        <tr valign="baseline">
          <td colspan="2" nowrap class="subtitle"><strong>Documnetos en Proceso</strong></td>
          </tr>
        <tr valign="baseline">
          <td colspan="2" nowrap class="FondoCampo"><strong>Documento</strong></td>
          </tr>
<?php } while ($row = $RS->fetch_assoc()); ?>          
          
        <tr valign="baseline">
          <td colspan="2" nowrap>&nbsp;</td>
        </tr>
          
<?php } ?>        
        <tr valign="baseline">
          <td colspan="2" nowrap class="subtitle"><strong>Solicitud de Documentos</strong></td>
          </tr>
        <tr valign="baseline">
          <td width="50%" align="right" nowrap class="NombreCampo">
            <input name="CodigoAlumno" value="<?php echo $CodigoAlumno ?>" type="hidden" >
            <input name="Creador" type="hidden" id="Creador" value="<?php echo $_COOKIE['MM_Username']; ?>">
            Documento a Solicitar</td><td width="50%" class="FondoCampo">
            <select name="Documento" id="Documento">
<option value="0">Seleccione...</option>
<?php 
$sql = "SELECT * FROM Solicitud
		WHERE CodigoAlumno = '0'
		AND SW_Status = '1'
		ORDER BY PagoCodigo";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	if($Tipo == "--"){
		echo "<option>-----</option>";
		echo "\n\r";
	}
	echo "<option value=\"$Descripcion\">$Descripcion</option>";
	echo "\n\r";
}
?>           
 </select></td>
          </tr>
        <tr valign="baseline">
          <td align="right" nowrap class="NombreCampo">Si no esta en la lista indiquelo aqu&iacute;:</td>
          <td class="FondoCampo"><input type="text" name="otroDoc" id="otroDoc"></td>
          </tr>
        <tr valign="baseline">
          <td colspan="2" align="right" nowrap><div align="center">
            <input type="submit" value="Solicitar">
            <input type="hidden" name="MM_insert" value="form1">
          </div></td>
        </tr>
        </table>
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
<!-- End ImageReady Slices -->
</body>
</html>