<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');

$TituloPantalla = "Feriados Laborales";

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Calendario (Fecha, Descripcion, Feriado, NoLaboral) VALUES
			('".$_POST['Fecha']."', '".$_POST['Descripcion']."', 1 , 1)";
	$mysqli->query($sql);
}

// Ejecuta $sql
$sql = "SELECT * FROM Calendario ORDER BY Fecha DESC";

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body><form id="form1" name="form1" method="post" action="">
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php  require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="500" border="0" cellpadding="2">
      <tr>
        <td align="center" class="NombreCampo">Fecha</td>
        <td colspan="2" align="center" class="NombreCampo">Descripci&oacute;n</td>
      </tr>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td align="center">
          
          <input type="date" name="Fecha"  />
     </td>
        <td align="center">
          <input name="Descripcion" type="text" id="Descripcion" size="20" /></td>
        <td align="right"><input type="submit" name="button" id="button" value="Agregar" /></td>
      </tr>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
      </tr>
<?php 
// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td align="center" >&nbsp;<?php echo DDMMAAAA($Fecha); ?></td>
        <td>&nbsp;<?php echo $Descripcion; ?></td>
        <td align="right"><a href="../Procesa.php?EliminaGen=1&amp;Tabla=Calendario&amp;Clave=Codigo&amp;Valor=<?php echo $Codigo ?>" target="_blank">Eliminar</a></td>
      </tr>
<?php 
}
?>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>   </form>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html>