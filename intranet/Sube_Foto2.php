<?php 
if(true){
$MM_authorizedUsers = "2,91,docente";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


if(isset($_POST['Tipo'])){
	$Tipo = $_POST['Tipo'];
	$Cedula = $_POST['Cedula'];
	$Codigo = $_POST['Codigo'];
	}
else{	
	$Tipo = $_GET['Tipo'];
	$Cedula = $_GET['Cedula'];
	$Codigo = $_GET['Codigo'];
	}
$Codigo = $CodigoAlumno;
	


$NombreArchivo = "../f/solicitando/".$Codigo.$Tipo.".jpg";

// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	
	copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
	header("Location: index.php");
} else {
   // echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}

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
  <?php if (isset($_GET['Tipo'])) { ?>
     
     <tr>
      <td width="50" align="center" class="NombreCampoTITULO" ></td>
  </tr>
  <tr>
    <td align="center"><form enctype="multipart/form-data" action="http://www.colegiosanfrancisco.com<?= $php_self."?CodigoPropietario=".$_GET['CodigoPropietario']; ?>" method="post"><table width="400" border="0">
        <tbody>
            <tr>
                <td colspan="2"class="NombreCampoTITULO" >Enviar Foto de <?= Nexo($_GET['Tipo']) ?></td>
                </tr>
            <tr>
                <td nowrap="nowrap" class="NombreCampo"><span>Archivo JPG</span></td>
                <td nowrap="nowrap" class="FondoCampo"><input name="userfile" type="file" />
          <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $Codigo; ?>" />
          <input name="Tipo" type="hidden" id="Tipo" value="<?php echo $_GET['Tipo']; ?>" /> 
          Solo archivos de imagen JPG
          <input type="hidden" name="MAX_FILE_SIZE" value="300000" /></td>
            </tr>
            <tr>
                <td class="FondoCampo">&nbsp;</td>
                <td class="FondoCampo"><input type="submit" value="Enviar" /></td>
            </tr>
        </tbody>
		</table></form></td>
  </tr>
  <? } ?>
  <tr>
    <td><table width="100%%" border="0" cellspacing="5" cellpadding="3">
        <tr>
            <td width="50%" align="center" valign="top" class="NombreCampoBIG">Foto Alumno</td>
            <td align="center" valign="top" class="NombreCampoBIG">Cedula Alumno</td>
        </tr>
        <tr>
            <td width="50%" align="center" valign="middle" class="FondoCampo<? if($Tipo == "") echo "Verde"; ?>"><?php 
			  $Tipo = '';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /> <br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
            <td align="center" valign="middle" class="FondoCampo<? if($Tipo == "ci") echo "Verde"; ?>"><?php 
			  $Tipo = 'ci';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /> <br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
        </tr>
        <tr>
            <td width="50%" align="center" valign="middle" class="NombreCampoBIG">Foto Padre</td>
            <td align="center" valign="middle" class="NombreCampoBIG">C&eacute;dula Padre</td>
        </tr>
        <tr>
            <td width="50%" align="center" valign="middle" class="FondoCampo<? if($Tipo == "p") echo "Verde"; ?>"><?php 
			  $Tipo = 'p';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /> <br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
            <td align="center" valign="middle" class="FondoCampo<? if($Tipo == "pci") echo "Verde"; ?>"><?php 
			  $Tipo = 'pci';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /><br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
        </tr>
        <tr>
            <td width="50%" align="center" valign="middle" class="NombreCampoBIG"> Foto Madre</td>
            <td align="center" valign="middle" class="NombreCampoBIG"> C&eacute;dula Madre</td>
        </tr>
        <tr>
            <td width="50%" align="center" valign="middle" class="FondoCampo<? if($Tipo == "m") echo "Verde"; ?>"><?php 
			  $Tipo = 'm';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /> <br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
            <td align="center" valign="middle" class="FondoCampo<? if($Tipo == "mci") echo "Verde"; ?>"><?php 
			  $Tipo = 'mci';
			  $foto = "../f/solicitando/".$Codigo.$Tipo.".jpg";
			  if(file_exists($foto)){ ?>
                <img src="<?php echo $foto; ?>" width="100"  /> <br />
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"><img src="../i/arrow_refresh_small.png" width="32" height="32" alt=""/>Cambiar</a>
                <?php }else{ ?>
                <a href="Sube_Foto.php?CodigoPropietario=<?= $_GET['CodigoPropietario'].'&Tipo='.$Tipo ?>"> <img src="../i/Folder-Add32.png" width="32" height="32" alt=""/><br />
                    Cargar</a>
                <?php } ?></td>
        </tr>
    </table></td>
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