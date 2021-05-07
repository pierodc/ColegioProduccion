<?php 
$MM_authorizedUsers = "docente,99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../inc_login_ck.php'); 

require_once('../Connections/bd.php'); 
require_once('../intranet/a/archivo/Variables.php');
require_once('../inc/rutinas.php'); 

$sql = "SELECT * FROM ce_Asignatura
		WHERE Codigo = '".$_GET['CodigoAsignatura']."'"; // WHERE del mismo prof
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


$TituloPantalla = "Objetivos";
$CodigoAsignatura = $_GET['CodigoAsignatura'];

if(isset($_POST['CodigoAsignatura']) and isset($_POST['Crear']) ){
	$sql = "INSERT INTO ce_Objetivo
			(CodigoAsignatura, Orden, Numero, Objetivo, Contenido) VALUES
			('".$_POST['CodigoAsignatura']."', '".$_POST['Numero']."', '".$_POST['Numero']."', '".$_POST['Objetivo']."', '".$_POST['Contenido']."')";
	$mysqli->query($sql);
	}


if(isset($_POST['Codigo']) and isset($_POST['Modificar']) ){
	$sql = "UPDATE ce_Objetivo SET
			Orden = '".$_POST['Numero']."',
			Numero = '".$_POST['Numero']."',
			Objetivo = '".$_POST['Objetivo']."',
			Contenido = '".$_POST['Contenido']."'
			WHERE Codigo = '".$_POST['Codigo']."'";
	$mysqli->query($sql);
	}



if(isset($_GET['Elimina'])){
	$sql = "DELETE FROM ce_Objetivo
			WHERE Codigo = '".$_GET['Codigo']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	}


/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
$RS = $mysqli->query($sql);
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
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
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
    <td align="center"><?php require_once('TituloPag.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="90%" border="0" cellpadding="2">
        <tr>
          <td colspan="6" class="NombreCampoBIG"><?php echo $row['Nombre']." - ".NombreNivelCurso($row['NivelCurso']) ?>&nbsp;</td>
        </tr>
        <tr>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">Num</td>
          <td class="NombreCampo">Objetivo General / Espec&iacute;fico</td>
          <td class="NombreCampo">Contenido</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<form id="form1" name="form1" method="post" action="">
<tr <?php $sw=ListaFondo($sw,$Verde);  ?>>
  <td valign="top">&nbsp;</td>
  <td valign="top"><input name="Numero" type="text" id="Numero" size="8" /></td>
  <td valign="top"><textarea name="Objetivo" cols="100" rows="8" id="Objetivo"></textarea></td>
  <td valign="top"><textarea name="Contenido" cols="80" rows="8" id="Contenido"></textarea></td>
  <td align="center" valign="top">&nbsp;</td>
  <td align="right" valign="top"><input name="Crear" type="hidden" id="Crear" value="1" />
    <input name="CodigoAsignatura" type="hidden" id="CodigoAsignatura" value="<?php echo $CodigoAsignatura ?>" />	
    <input type="submit" name="button" id="button" value="Crear" /></td>
  </tr>
</form>
		<?php 
        $sql = "SELECT * FROM ce_Objetivo
				WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
				ORDER BY Orden, Numero"; // WHERE del mismo prof
        $RS = $mysqli->query($sql);
        if ($row = $RS->fetch_assoc()) 
		do {
            extract($row);
        ?>



<form id="form1" name="form1" method="post" action="">
  <tr <?php $sw=ListaFondo($sw,$Verde);  ?>>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input name="Numero" type="text" id="Numero" value="<?php echo $Numero ?>" size="8" /></td>
    <td valign="top"><textarea name="Objetivo" cols="100" rows="4" id=""><?php echo $Objetivo ?></textarea></td>
    <td valign="top"><textarea name="Contenido" cols="80" rows="4" id=""><?php echo $Contenido ?></textarea></td>
    <td align="center" valign="top">&nbsp;</td>
    <td align="right" valign="top"><input name="Codigo" type="hidden" id="Codigo" value="<?php echo $Codigo ?>" />
      <input name="Modificar" type="hidden" id="Modificar" value="1" />
      <input name="CodigoAsignatura" type="hidden" id="CodigoAsignatura" value="<?php echo $CodigoAsignatura ?>" />	
      <input type="submit" name="button" id="button" value="Guardar" />
      <a href="Objetivos.php?CodigoAsignatura=<?php echo $CodigoAsignatura ?>&Elimina=1&Codigo=<?php echo $Codigo ?>"><br />
      <br />
      Eliminar</a><br /></td>
    </tr>
</form>






        <?php }while ($row = $RS->fetch_assoc()) ; ?>
        
        
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>