<?php 
$MM_authorizedUsers = "91,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 

// $FechaObjAntiguedad = "2017-09-30";

$export_file = "xlsfile://tmp/example.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );


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
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Lista Curso para Excel</title>
</head>

<body>
<table border="1">
  <tr>
    <td align="center">No</td>
    <td align="center">Cedula</td>
    <td align="center">&nbsp;</td>
    <td align="center">Apellidos</td>
    <td align="center">Apellidos</td>
    <td align="center">Nombres</td>
    <td colspan="3" align="center"><p>F NAc</p></td>
    <td>Email</td>
    <td>Sexo</td>
    <td>Edo Civil</td>
    <td colspan="2">Cel</td>
    <td colspan="2">Cuenta</td>
    <td>Tipo Empleado</td>
    <td>Tipo Docente</td>
    <td>Cargo Largo</td>
    <td>Cargo Corto</td>
    <td>Horas</td>
    <td>F. Ing</td>
    <td>A&ntilde;os<br />
    <?= DDMMAAAA($FechaObjAntiguedad); ?></td>
    <td>S. Base 1</td>
    <td>S. Base 2</td>
    <td>S. Base 3</td>
    <td>S. Base T</td>
    <td>S. Base anterior</td>
    <td>Haberes Fidei</td>
  </tr>
<?php 
$sql = "SELECT * FROM Empleado 
		WHERE SW_activo = '1'
		ORDER BY TipoEmpleado, TipoDocente, Apellidos, Apellido2, Nombres, Nombre2";
$RS = $mysqli->query($sql);
// Ejecuta $sql y While
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
  <tr>
    <td align="right"><?php echo ++$No; ?>&nbsp;</td>
    <td align="right"><?php echo strtoupper("$CedulaLetra"); ?></td>
    <td align="right"><?php echo strtoupper("$Cedula"); ?></td>
    <td><?php echo ucfirst("$Nombres $Nombre2"); ?></td>
    <td align="left"><?php echo ucfirst("$Apellidos"); ?></td>
    <td><?php echo ucfirst("$Apellido2"); ?></td>
    <td><?php echo strtolower($Nombres.$Apellidos)."@sanfrancisco.e12.ve"; ?></td>
    
    <td align="right"><?php echo $Cedula."sfa"; ?></td>
    <td><?php echo DiaN($FechaNac); ?></td>
    <td><?php echo MesN($FechaNac); ?></td>
    <td><?php echo AnoN($FechaNac); ?></td>
    <td><?php echo "$Email"; ?></td>
    <td><?php echo "$Sexo"; ?></td>
    <td><?php echo "$EdoCivil"; ?></td>
    <td><?php echo substr($TelefonoCel,0,4); ?></td>
    <td><?php echo substr($TelefonoCel,4,15); ?></td>
    <td><?php echo $NumCuentaA; ?></td>
    <td><?php echo $NumCuenta; ?></td>
    <td><?php echo "$TipoEmpleado"; ?></td>
    <td><?php echo "$TipoDocente"; ?></td>
    <td><?php echo "$CargoLargo"; ?></td>
    <td><?php echo "$CargoCorto"; ?></td>
    <td><?php echo "". $HrAcad +$HrAdmi ; ?></td>
    <td>&nbsp;<?php echo DDMMAA($FechaIngreso); ?></td>
    <td><?php echo Fecha_Meses_Laborados($FechaIngreso , $FechaObjAntiguedad); ?></td>
    <td><?php echo $SueldoBase_1 ?></td>
    <td><?php echo $SueldoBase_2 ?></td>
    <td><?php echo $SueldoBase_3 ?></td>
    <td><?php echo $SueldoBase ?></td>
    <td><?php echo $SueldoBase_anterior ?></td>
    <td><?php echo $Monto_Fidei_Depositado ?></td>
    
    <td><?php 
	
	$sql1 = "SELECT * FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado'
		AND Concepto LIKE '%+Fideicomiso%'
		AND Codigo_Quincena = '2018 09 5' 
		";
	$RS1 = $mysqli->query($sql1);
	// Ejecuta $sql y While
	if ($row1 = $RS1->fetch_assoc()){
		echo $row1['Concepto'];
		}
	
	 ?></td>
     <td><?php echo $row1['Monto'];
	 $Monto1 = $row1['Monto'];
	  ?></td>
    
   
    <td><?php 
	
	$sql1 = "SELECT * FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado'
		AND Concepto LIKE '%+Fideicomiso%'
		AND Codigo_Quincena = '2018 09' 
		";
	$RS1 = $mysqli->query($sql1);
	// Ejecuta $sql y While
	if ($row1 = $RS1->fetch_assoc()){
		echo $row1['Concepto'];
		}
	
	 ?></td>
     <td><?php echo $row1['Monto'];
	  $Monto2 = $row1['Monto'];
	
	  ?></td>
    
    <td><?php 
	$MontoTotal = round(($Monto1 + $Monto2) * .7  , 2);
	echo $MontoTotal;
	 ?></td>
    
    <? 
	
	$sql1 = "UPDATE Empleado SET Pago_extra = $MontoTotal WHERE CodigoEmpleado = $CodigoEmpleado"; 
	//$mysqli->query($sql1);
	
	
	?>
    
    
    
  </tr><?php } ?>
</table>
</body>
</html>