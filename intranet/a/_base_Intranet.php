<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rotation.php'); 


$TituloPantalla = "TituloPantalla";




/*
$Variable = new Variable();
$Variable->view("nombrevar");
$Alumno = new Alumno($CodigoAlumno, $AnoEscolar);
$Compra = new Compra(["Codigo" => 1]);


if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
 onclick="this.disabled=true;this.form.submit();"
 
 <a href="delete.php?id=$res[id]"  onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a>
 
 
// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

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

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }

<input type="submit" name="Boton" id="Boton" value="Valor" onclick="this.disabled=true;this.form.submit();" />

*/
 
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><?php require_once('TitAdmin.php'); ?></td>
  </tr>
    <tr>
    <td align="left" valign="top"><?php 
   //$actual = $_GET['CodigoCurso'];
   //$extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   //Ir_a_Curso($actual,$extraOpcion); ?></td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="90%" border="0">
        <tr>
          <td class="NombreCampo">Titulo</td>
          <td class="NombreCampo">&nbsp;</td>
          <td class="NombreCampo">&nbsp;</td>
        </tr>
<?php 
//$RS = $mysqli->query($query_RS_Alumno);
//while ($row = $RS->fetch_assoc()) {
//	extract($row);
	
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td align="right"><a href="delete.php?id=$res[id]" onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a></td>
</tr>
<?php 	
	//}
?>
    </table>&nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>