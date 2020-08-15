<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Estadistica Nomina";

$sql = "SELECT * FROM Empleado_Pago, Empleado
		WHERE Empleado_Pago.Codigo_Empleado = Empleado.CodigoEmpleado
		AND Empleado_Pago.Concepto = '+SueldoBase'
		AND Empleado_Pago.Codigo_Quincena >= '2013 09 1'
		AND Empleado_Pago.Codigo_Quincena <= '2014 07 2'
		ORDER BY Empleado_Pago.Codigo_Quincena, Empleado.Pagina";

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
    <td align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="900" border="0" cellpadding="2">
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="left">Quincena</td>
          <td align="right">&nbsp;</td>
          <td align="right">Sueldo Base</td>
        </tr>

<?php 
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Codigo_Mes_Anterior = $Codigo_Mes;	 
$Codigo_Quincena_Anterior = $Codigo_Quincena;
$Pagina_Anterior = $row['Pagina'];

do {
	extract($row);

 	if($Pagina_Anterior != $Pagina){
?>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="left"><?php echo $Pagina_Anterior ?>&nbsp;</td>
          <td align="right"><?php echo Fnum($MontoTotal[$Codigo_Quincena_Anterior][$Pagina_Anterior]); ?></td>
        </tr>
<?php 
		} 
		
		
	// Total quincena
 	if($Codigo_Quincena_Anterior != $Codigo_Quincena and $Codigo_Quincena_Anterior > ''){
?>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="left"><?php echo $Codigo_Quincena_Anterior ?>&nbsp;</td>
          <td align="right"><?php echo Fnum($MontoTotal[$Codigo_Quincena_Anterior][0]); ?></td>
        </tr>
<?php 
		} 
		
		

	$Codigo_Mes = substr($Codigo_Quincena,0,7);
	$MontoTotal[$Codigo_Quincena][0] += $Monto;
	$MontoTotal[$Codigo_Quincena][$Pagina] += $Monto;

	$Pagina_Anterior = $Pagina;
	$Codigo_Mes_Anterior = $Codigo_Mes;	 
	$Codigo_Quincena_Anterior = $Codigo_Quincena;
} while ($row = $RS->fetch_assoc()); ?>


        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="left"><?php echo $Pagina_Anterior ?>&nbsp;</td>
          <td align="right"><?php echo Fnum($MontoTotal[$Codigo_Quincena_Anterior][$Pagina_Anterior]); ?></td>
        </tr>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td align="left"><?php echo $Codigo_Quincena_Anterior ?>&nbsp;</td>
          <td align="right"><?php echo Fnum($MontoTotal[$Codigo_Quincena_Anterior][0]); ?></td>
        </tr>



    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>