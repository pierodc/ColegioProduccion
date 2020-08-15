<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');


// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['CodigoEmpleado'])){
	extract($_POST);
	$TelefonoHab = TelLimpia($TelefonoHab);
	$TelefonoCel = TelLimpia($TelefonoCel);
	
	
	$sql = "UPDATE Empleado
			SET 
			Apellidos = '$Apellidos',
			Apellido2 = '$Apellido2',
			Nombres = '$Nombres',
			Nombre2 = '$Nombre2',
			TelefonoHab = '$TelefonoHab',
			TelefonoCel = '$TelefonoCel',
			PaisNacimiento = '$PaisNacimiento',
			EdoNacimiento = '$EdoNacimiento',
			CiudadNacimiento = '$CiudadNacimiento',
			EdoCivil = '$EdoCivil',
			Sexo = '$Sexo'
			WHERE CodigoEmpleado = '$CodigoEmpleado'";
	$mysqli->query($sql);
	}

/*

*/

// Ejecuta $sql
$sql = "SELECT * FROM Empleado WHERE SW_activo = '1' ORDER BY Apellidos, Apellido2, Nombres, Nombre2";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();

// Ejecuta $sql y While
$RS = $mysqli->query($sql);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ="Empleados"; ?></title>
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
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="90%" border="1">
      <tr>
        <td colspan="3">&nbsp;Empleados</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="Apellidos2" type="text" value="Apellido1" size="15"  class="CampoEntrada"/>
          <input name="Apellido" type="text" value="Apellido2" size="15"  class="CampoEntrada"/>
          <input name="Nombres2" type="text" value="Nombre1" size="15"  class="CampoEntrada"/>
          <input name="Nombre" type="text" value="Nombre2" size="15"  class="CampoEntrada"/>
          <input name="TelefonoHab2" type="text" value="TelefonoHab" size="17"  class="CampoEntrada"/>
          <input name="TelefonoCel2" type="text" value="TelefonoCel" size="17"  class="CampoEntrada"/>
          <input name="PaisNacimiento2" type="text" value="PaisNacimiento" size="15"  class="CampoEntrada"/>
          <input name="EdoNacimiento2" type="text" value="EdoNacimiento" size="15"  class="CampoEntrada"/>
          <input name="CiudadNacimiento2" type="text" value="CiudadNacimiento" size="15"  class="CampoEntrada"/>
          <input name="EdoCivil2" type="text" value="EdoCivil" size="4"  class="CampoEntrada"/>
          <input name="Sexo2" type="text" value="Sexo" size="4"  class="CampoEntrada"/><br />
          <input name="Sexo2" type="text" value="Email" size="50"  class="CampoEntrada"/></td>
        <td>&nbsp;</td>
      </tr>
<?php 
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>      
      <tr <?php 
	  if($_GET['Linea']==$i)
	  	$Verde = true; else $Verde = false;
	  $sw=ListaFondo($sw,$Verde); ?>>
        <td width="5%" align="right">&nbsp;<?php echo ++$i; ?>)<a name="<?php echo $i ?>" id="<?php echo $i ?>"></a></td>
        <td width="78%"><form id="form1" name="form1" method="post" action="../?Linea=<?php echo $i; ?>#<?php echo $i; ?>">
<input name="CodigoEmpleado" type="hidden" id="hiddenField" value="<?php echo $CodigoEmpleado; ?>" />
<input name="Apellidos" type="text" value="<?php echo $Apellidos; ?>" size="15"  class="CampoEntrada"/>
<input name="Apellido2" type="text" value="<?php echo $Apellido2; ?>" size="15"  class="CampoEntrada"/>
<input name="Nombres" type="text" value="<?php echo $Nombres; ?>" size="15"  class="CampoEntrada"/>
<input name="Nombre2" type="text" value="<?php echo $Nombre2; ?>" size="15"  class="CampoEntrada"/>
<input name="TelefonoHab" type="text" value="<?php echo TelFormat($TelefonoHab); ?>" size="17"  class="CampoEntrada"/>
<input name="TelefonoCel" type="text" value="<?php echo TelFormat($TelefonoCel); ?>" size="17"  class="CampoEntrada"/>
<input name="PaisNacimiento" type="text" value="<?php echo $PaisNacimiento; ?>" size="15"  class="CampoEntrada"/>
<input name="EdoNacimiento" type="text" value="<?php echo $EdoNacimiento; ?>" size="15"  class="CampoEntrada"/>
<input name="CiudadNacimiento" type="text" value="<?php echo $CiudadNacimiento; ?>" size="15"  class="CampoEntrada"/>
<input name="EdoCivil" type="text" value="<?php echo $EdoCivil; ?>" size="4"  class="CampoEntrada"/>
<input name="Sexo" type="text" value="<?php echo $Sexo; ?>" size="4"  class="CampoEntrada"/><br />
<input name="Email" type="text" value="<?php echo $Email; ?>" size="50"  class="CampoEntrada"/>
<input type="submit" name="button" id="button" value="Submit" />
        </form></td>
        <td width="17%">&nbsp;</td>
      </tr>
<?php } ?>      
      <tr>
        <td colspan="3">fin</td>
      </tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>