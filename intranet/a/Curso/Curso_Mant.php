<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Mantenimiento Cursos";

if(!TieneAcceso($Acceso_US,"all;Academico")){
	//header("Location: ".$_SERVER['HTTP_REFERER']);
	}



// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
$sql = "SELECT *  FROM Curso 
		ORDER BY NivelCurso,Seccion ASC";
$RS = $mysqli->query($sql);

/*

// Ejecuta $sql

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

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="2">
        <tr>
          <td>&nbsp;</td>
        </tr>
<tr>
  <td><table width="90%" border="0" align="center">
    <tr>
      <td align="center" class="NombreCampo">&nbsp;</td>
      <td align="center" class="NombreCampo">Activo</td>
      <td align="center" class="NombreCampo">Curso</td>
      <td align="center" class="NombreCampo">Curso</td>
      <td align="center" class="NombreCampo">Seccion</td>
      <td align="center" class="NombreCampo">Cupo Disp</td>
      <td align="center" class="NombreCampo">Boleta</td>
      <td align="center" class="NombreCampo">Materias</td>
      </tr>
    <?php while ($row = $RS->fetch_assoc()){ 
	extract($row);
	?>
      <tr align="center" <?php $sw=ListaFondo($sw,$Verde); ?>>
        <td><?php echo ++$No ?>&nbsp;</td>
        <td><?php  
		
$ClaveCampo = 'CodigoCurso';
$ClaveValor = $CodigoCurso;
$Tabla = 'Curso';
if($MM_Username == "piero"){
	Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_activo',$SW_activo); 
}
		
		?></td>
        <td><?php echo Curso($CodigoCurso); ?></td>
        <td><?php echo $Curso; ?></td>
        <td><?php echo $Seccion; ?></td>
        <td><?php 
Frame_SW ($ClaveCampo,$ClaveValor,$Tabla,'SW_CupoDisp',$SW_CupoDisp); 
		?>&nbsp;</td>
        <td><a href="Boleta_Estructura.php">Indicadores</a></td>
        <td><a href="Materias.php?Curso=<?php echo $CodigoMaterias; ?>" target="_blank">Materias</a></td>
        </tr>
      <?php } ?>
  </table></td>
</tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>