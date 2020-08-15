<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,docente";
require_once('inc_login_ck.php'); 

require_once('Connections/bd.php'); 
require_once('intranet/a/archivo/Variables.php');
require_once('inc/rutinas.php'); 

$TituloPantalla = "Cambio de Clave";

if(isset($_POST['Clave2'])){
	if($_POST['Clave2'] != $_POST['Clave']){
		header("Location: ".$php_self."?Error=Clave no coincide");
	}
	else{
		$sql = "SELECT * FROM Usuario
				WHERE Usuario = '".$_POST['UsuarioCambiando']."'
				AND Clave = '".$_POST['ClaveActual']."'";
				//	echo $sql;
		$RS = $mysqli->query($sql);
		if($row = $RS->fetch_assoc()){ // Clave Actual ok	
			$sql = "UPDATE Usuario
					SET Clave = '".$_POST['Clave']."'
					WHERE Usuario = '".$_POST['UsuarioCambiando']."'";
				//	echo $sql;
			$RS = $mysqli->query($sql);
			header("Location: "."intranet");
			}
		else{ // Clave actual errada
			header("Location: ".$php_self."?Error=Clave Actual errada");
			}
	}
}

/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

echo $sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<link href="estilos2.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('Docente/TituloPag.php'); ?></td>
  </tr>
  <tr>
    <td align="center" class="subtitle">Cambio de Clave&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">      <form id="form1" name="form1" method="post" action="CambioClave.php">
<table width="900" border="0" cellpadding="2">
<?php if($_GET['Error'] == "Cambiar"){ ?>
<tr>
          <td colspan="2" align="center" class="MensajeDeError">Debe cambiar su clave</td>
</tr><?php }elseif($_GET['Error'] > " "){?>
        <tr>
          <td colspan="2" align="center" class="MensajeDeError"><?php echo $_GET['Error'] ?></td>
          </tr>
<?php } ?>
        <tr >
          <td width="50%" align="right" class="NombreCampo">Usuario</td>
          <td width="50%" class="FondoCampo"><?php echo $MM_Username; ?>
            <input name="UsuarioCambiando" type="hidden" id="hiddenField" value="<?php echo $MM_Username; ?>" /></td>
        </tr>
        <tr >
          <td align="right" class="NombreCampo">Clave Actual</td>
          <td class="FondoCampo"><label for="ClaveActual"></label>
            <input type="password" name="ClaveActual" id="ClaveActual" />
            <input type="hidden" name="ClaveActualhidden" id="ClaveActualhidden" /></td>
        </tr>
        <tr >
          <td align="right" class="NombreCampo">&nbsp;</td>
          <td class="FondoCampo">&nbsp;</td>
        </tr>
        <tr >
          <td align="right" class="NombreCampo">Clave nueva</td>
          <td class="FondoCampo"><label for="ClaveActual"></label>
            <span id="sprypassword1">
            <input type="password" name="Clave" id="Clave" />
            <span class="passwordRequiredMsg">A value is required.</span><span class="passwordMinCharsMsg">Minimo 6 caracteres.</span></span></td>
        </tr>
        <tr >
          <td align="right" class="NombreCampo">Verifica clave</td>
          <td class="FondoCampo"><span id="spryconfirm1">
            <input type="password" name="Clave2" id="Clave2" />
            <span class="confirmRequiredMsg">Requerido.</span><span class="confirmInvalidMsg">No coincide.</span></span></td>
        </tr>
        <tr >
          <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Enviar" /></td>
        </tr>
    </table>
    </form></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:6, validateOn:["change"]});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "Clave", {validateOn:["change"]});
</script>
</body>
</html>