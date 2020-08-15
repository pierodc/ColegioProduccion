<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

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
 
$Meses = array('2016-08','2016-09','2016-10','2016-11','2016-12',
			   '2017-01','2017-02','2017-03','2017-04',
			   '2017-05','2017-06','2017-07','2017-08');
 
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

</head>
<body>
<table  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><a href="../index.php">Inicio</a></td>
    <td align="center"><a href="Gastos.php">Gastos</a></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="top"><table width="100%" border="0" cellpadding="2">

<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>Cuenta 1</td>
  <td>Cuenta 11</td>
  <td>Cuenta 111</td>
<?php foreach($Meses as $Mes) {?>
  <td align="center" nowrap="nowrap"><?php echo $Mes ?></td>
<?php } ?>
  <td align="center">Total&nbsp;</td>
</tr>

<?php 
$sql = "SELECT * FROM Contabilidad WHERE
		Fecha >= '2015-09-01' AND
		Fecha <= '2016-08-31'
		GROUP BY Cuenta1, Cuenta11, Cuenta111
		ORDER BY Cuenta1, Cuenta11, Cuenta111";

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);
do {
	?>
	<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
	<td><a href="Gastos.php?Cuenta1=<?php echo $Cuenta1; ?>"><?php 
	
	if($Cuenta1Anterior <> $Cuenta1)
		echo $Cuenta1;
	
	?></a>&nbsp;</td>
	<td><a href="Gastos.php?Cuenta1=<?php echo $Cuenta1; ?>&Cuenta11=<?php echo $Cuenta11; ?>"><?php 
	
	if($Cuenta11Anterior <> $Cuenta11)
		echo $Cuenta11;
	
	?></a>&nbsp;</td>
	<td><a href="Gastos.php?Cuenta1=<?php echo $Cuenta1; ?>&Cuenta11=<?php echo $Cuenta11; ?>&Cuenta111=<?php echo $Cuenta111; ?>"><?php echo $Cuenta111 ?></a>&nbsp;</td>
	<?php foreach($Meses as $Mes) {?>
	<td align="right"><?php 
	  
	  
		$Fecha_Inicio_Mes = $Mes."-01";
		$Fecha_Fin_Mes    = $Mes."-31";
		
		$sql_suma = "SELECT SUM(Monto) AS SubTotal FROM Contabilidad WHERE
					Fecha >= '$Fecha_Inicio_Mes' AND
					Fecha <= '$Fecha_Fin_Mes' AND
					Cuenta1 = '$Cuenta1' AND
					Cuenta11 = '$Cuenta11' AND
					Cuenta111 = '$Cuenta111' ";
		$RS_suma = $mysqli->query($sql_suma);
		$row_suma = $RS_suma->fetch_assoc();
		
		$SubTotal = $row_suma['SubTotal'];
		
?><a href="Gastos.php?Cuenta1=<?php echo $Cuenta1; ?>&Cuenta11=<?php echo $Cuenta11; ?>&Cuenta111=<?php echo $Cuenta111; ?>&Mes=<?php echo $Mes ?>"><?
		echo Fnum($SubTotal);
?></a><?		
		$TotalAno += $SubTotal;
		$TotalMes[$Mes] += $SubTotal;
		$Total[$Cuenta1] += $SubTotal;
	  
	  ?></td>
	<?php } ?>
	<td align="right"><?php 
	
	echo Fnum($TotalAno); 
	$TotalAno=0;  
	
	?>&nbsp;</td>
	<td>&nbsp;</td>
	</tr>
	<?php 
	
	$Cuenta1Anterior = $Cuenta1;		
	$Cuenta11Anterior = $Cuenta11;		
	
	if($row = $RS->fetch_assoc())
		extract($row);
	
	if($Cuenta1Anterior <> $Cuenta1 and $Cuenta1Anterior > ' ' or !$row){
		?><tr><td colspan="17" align="right" class="promo" ><?php echo $Cuenta1Anterior.' = '.Fnum($Total[$Cuenta1Anterior]); ?>&nbsp;</td></tr><?php 	
	}
	
	
}while ($row); ?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
<?php foreach($Meses as $Mes) {?>
  <td align="right"><?php echo Fnum($TotalMes[$Mes]); ?>&nbsp;</td>
<?php } ?>
  <td align="right">&nbsp;</td>
</tr>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>