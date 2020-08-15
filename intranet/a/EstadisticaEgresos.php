<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php'); 

$TituloPantalla = "Estadistica Egresos";

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

$sql = "SELECT * FROM Contabilidad WHERE
		Fecha >= '$Fecha_Inicio_Mes' AND
		Fecha <= '$Fecha_Fin_Mes'
		GROUP BY Cuenta1, Cuenta11, Cuenta111
		ORDER BY Cuenta1, Cuenta11, Cuenta111";
 
	$sql_suma = "SELECT SUM(Monto) AS SubTotal FROM Contabilidad WHERE
				Fecha >= '$Fecha_Inicio_Mes' AND
				Fecha <= '$Fecha_Fin_Mes' AND
				Cuenta1 = '$Cuenta1' AND
				Cuenta11 = '$Cuenta11' AND
				Cuenta111 = '$Cuenta111' ";
	$RS_suma = $mysqli->query($sql_suma);
	$row_suma = $RS_suma->fetch_assoc();
	
	$SubTotal = $row_suma['SubTotal'];
 $Meses = array('2013-09','2013-10','2013-11','2013-12','2014-01','2014-02','2014-03','2014-04','2014-05','2014-06','2014-07','2014-08');
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
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

</head>
<body>
<table  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="2">
        <tr>
          <td class="NombreCampo">Titulo</td>
        </tr>

<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>Concepto</td>
<?php foreach($Meses as $Mes) {?>
  <td>&nbsp;</td>
<?php } ?>
</tr>

<?php 
//$RS = $mysqli->query($sql);
//while ($row = $RS->fetch_assoc()) {
//	extract($row);
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>Concepto</td>
<?php foreach($Meses as $Mes) {?>
  <td><?php echo $Mes; ?>&nbsp;</td>
<?php } ?>
</tr>
<?php 	
	
//} ?>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>