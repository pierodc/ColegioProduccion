<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php'); 

require_once('archivo/Variables.php');
require_once('../../inc/rutinas.php'); 

//$TituloPantalla = "TituloPantalla";

/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql


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


*/
 
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

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
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
<?php 


$sql = "SELECT *  FROM `ContableMov` WHERE `Cambio_Dolar` >= 2 AND `MontoHaber_Dolares` > 0  
		GROUP BY Fecha
		ORDER BY Fecha DESC";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	
	$sql_Insert = "INSERT INTO CambioDolar
					(Fecha, Monto)
					VALUES
					('$Fecha' , $Cambio_Dolar)";
	//$mysqli->query($sql_Insert);
    echo "$sql_Insert<br>";
}



/*
$Factura_Numero = 35212;

for ($i = 36328; $i <= 36765; $i++) {
	$sql = "UPDATE Factura_Control
			SET Factura_Numero = $Factura_Numero
			WHERE Control_Numero = $i";
	echo $sql."<br>";
	$mysqli->query($sql);
	$Factura_Numero++;
}
*/

/*
for ($i = 26000; $i <= 50000; $i++) {

$Busca = "SELECT * FROM Recibo WHERE Fac_Num_Control = $i";
$RS_Busca = $mysqli->query($Busca);
$row_Busca = $RS_Busca->fetch_assoc();
    $sql = "INSERT INTO Factura_Control 
    		SET Control_Numero = $i, Factura_Numero = '".$row_Busca['NumeroFactura']."' ";
    //$mysqli->query($sql);
    echo  ". ";
}
*/


/*
$sql = "SELECT * FROM Empleado ";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	
extract($row);
$sql_U = "UPDATE Empleado 
SET SueldoAnteriorDesglose = ".
"'SueldoBase 1 = $SueldoBase_1
SueldoBase 2 = $SueldoBase_2
SueldoBase 3 = $SueldoBase_3
HrAcad = $HrAcad  
HrAdmi = $HrAdmi 
Total Sueldo = $SueldoBase',
SueldoBase_anterior = $SueldoBase
WHERE CodigoEmpleado = $CodigoEmpleado";
	


$mysqli->query($sql_U);
	
    echo "<PRE>$sql_U</PRE><br>";
}
*/


?></body>
</html>