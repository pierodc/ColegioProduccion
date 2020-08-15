<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin,AsistDireccion";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


/*
// Conectar

// Ejecuta $sql
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}


$RS->data_seek(0);

*/
$sql = "SELECT * FROM Curso WHERE SW_activo = 1 ORDER BY NivelCurso";
$RS = mysql_query($sql, $bd) or die(mysql_error());

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ="Lista Excel"; ?></title>
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
    <td align="center" valign="top"><table width="300">
  <tr class="NombreCampo">
    <td>Curso</td>
    <td align="center">Con Promedio</td>
    <td align="center">Sin Promedio</td>
  </tr>
<?php while($row = mysql_fetch_assoc($RS)) { 
extract($row);
if($NivelMencionAnterior != $NivelMencion){
?>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
<?php }?>    
  <tr <?php echo $sw=ListaFondo($sw,$Verde); ?>>
    <td>&nbsp;<?php echo $NombreCompleto; ?></td>
    <td align="center"><a href="Curso_Excel.php?Promedio=1&CodigoCurso=<?php echo $CodigoCurso; ?>" target="_blank"><img src="../../../i/application_view_detail.png" width="32" height="32" /></a></td>
    <td align="center"><a href="Curso_Excel.php?Promedio=0&CodigoCurso=<?php echo $CodigoCurso; ?>" target="_blank"><img src="../../../i/application_side_list.png" alt="" width="32" height="32" /></a></td>
  </tr>
<?php 
$NivelMencionAnterior = $NivelMencion;
} ?>
</table>
</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>