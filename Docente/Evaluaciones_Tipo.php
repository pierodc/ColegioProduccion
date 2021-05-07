<?php 
$MM_authorizedUsers = "docente,99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../inc_login_ck.php'); 

require_once('../Connections/bd.php'); 
require_once('../intranet/a/archivo/Variables.php');
require_once('../inc/rutinas.php'); 

$TituloPantalla = "INTRANET - Docente";
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


if(isset($_POST['Crear'])){
	$sql = "INSERT INTO ce_Tipo_Evaluacion
			(Orden, Nombre , Dificultad) VALUES
			('".$_POST['Orden']."','".$_POST['Nombre']."','".$_POST['Dificultad']."')";
	$mysqli->query($sql);
	}


if(isset($_GET['Elimina'])){
	$sql = "DELETE FROM ce_Tipo_Evaluacion
			WHERE Codigo = '".$_GET['Codigo']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self);
	}


/*
// Conectar

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
<meta name="viewport" content="width=device-width, initial-scale=1">
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
    <td align="center" valign="top"><form id="form1" name="form1" method="post" action=""><table width="90%" border="0" cellpadding="2">
        <tr>
          <td align="center" class="NombreCampo">No</td>
          <td align="center" class="NombreCampo">Orden</td>
          <td class="NombreCampo">Evaluaci&oacute;n</td>
          <td class="NombreCampo">Dificultad</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>

<?php 

$sql = "SELECT * FROM  ce_Tipo_Evaluacion";
$RS = $mysqli->query($sql);


// Ejecuta $sql y While
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>        
        
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="center"><?php echo ++$No ?></td>
          <td align="center"><?php echo $Orden ?></td>
          <td><?php echo $Nombre ?></td>
          <td align="Right"><?php echo $Dificultad ?></td>
          <td><a href="Evaluaciones_Tipo.php?Elimina=1&Codigo=<?php echo $Codigo  ; // ?>">Eliminar</a></td>
        </tr>
        
<?php } ?>        

        
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="center">&nbsp;</td>
          <td align="center">
          <input name="Orden" type="text" id="Orden" size="5" /></td>
          <td><input name="Nombre" type="text" id="Nombre" size="40" /></td>
          <td align="Right"><input name="Dificultad" type="text" id="Dificultad" size="8" /></td>
          <td>
            <input name="Crear" type="hidden" id="Crear" value="1" />
            <input type="submit" name="button" id="button" value="Submit" />
          </td>
        </tr>
        
    </table> </form>     &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>