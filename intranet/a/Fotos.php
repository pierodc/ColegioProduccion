<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['CrearAlbum'])){
	$sql = "INSERT INTO Album
			(TituloAlbum, Fecha_OnLine, html)
			VALUES
			('".$_POST['TituloAlbum']."' , '".$_POST['Fecha_OnLine']."' , '".$_POST['html']."')";
	$RS = $mysqli->query($sql);
}


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Base</title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php $TituloPantalla ="Fotos";
	require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><form id="form1" name="form1" method="post" action="">
        <table width="80%" border="0" align="center">
          <tr>
            <td colspan="2" class="subtitle">Agregar Album de Fotos</td>
          </tr>
          <tr>
            <td valign="top" class="NombreCampo">Nombre Album</td>
            <td valign="top" class="FondoCampo"><label for="textfield"></label>
            <input type="text" name="TituloAlbum" id="textfield" /></td>
          </tr>
          <tr>
            <td valign="top" class="NombreCampo">Fecha</td>
            <td valign="top" class="FondoCampo"><label for="textfield2"></label>
            <input type="date" name="Fecha_OnLine" id="textfield2" /></td>
          </tr>
          <tr>
            <td valign="top" class="NombreCampo">HTML</td>
            <td valign="top" class="FondoCampo"><label for="textarea"></label>
            <textarea name="html" id="textarea" cols="45" rows="5"></textarea></td>
          </tr>
          <tr>
            <td><input type="hidden" name="CrearAlbum" id="CrearAlbum" /></td>
            <td><input type="submit" name="button" id="button" value="Guardar" /></td>
          </tr>
      </table>
    </form>      &nbsp;
    
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php 
		  
if($_GET['Codigo'] > 0){
	$sql = "SELECT * FROM Album WHERE Codigo = '".$_GET['Codigo']."'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
?>       
        <tr>
          <td align="center" class="NombreCampoBIG">&nbsp;<BR><?php echo ''.$TituloAlbum.'';?><BR>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><?php echo $html;?>&nbsp;</td>
        </tr>
        <tr>
          <td align="center"><div class="fb-comments" data-href="http://www.colegiosanfrancisco.com/intranet/Fotos.php?Codigo=<?php echo $_GET['Codigo'];?>" data-width="470" data-num-posts="10"></div></td>
        </tr>
<?php } ?>
        <tr>
          <td class="subtitle">Albumes</td>
        </tr>
        <?php 
// Ejecuta $sql y While
$sql = "SELECT * FROM Album ORDER BY Fecha_OnLine";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?><tr>
<td><a href="Fotos.php?Codigo=<?php echo $Codigo; ?>"><?php echo $TituloAlbum; ?></a>&nbsp; <a href="Procesa.php?EliminaGen=1&Tabla=Album&Clave=Codigo&Valor=<?php echo $Codigo; ?>" target="_blank" >Eliminar</a></td>
        </tr>
  <?php } ?>
   </table>
    
    </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>