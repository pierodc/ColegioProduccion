<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
//require_once('inc_login_ck.php'); 

require_once('Connections/bd.php'); 
require_once('intranet/a/archivo/Variables.php');
require_once('inc/rutinas.php'); 

$CodEmp = $_GET['CodEmp'];
$Mes = '11';
$Ano = '2014';
$Quincena = '1';
$CodigoQuincena = "$Ano $Mes $Quincena";
$Desde_IP = $_SERVER['SERVER_ADDR'];


$TituloPantalla = "Recibo de Pago";

$sql = "SELECT * FROM Empleado WHERE md5 = '$CodEmp'";
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);

$sql = "INSERT INTO Empleado_Vista_Recibo 
		(Codigo_Empleado, Descripcion, Desde_IP, FechaHora) 
		VALUES 
		('$CodigoEmpleado', '$CodigoQuincena', '$Desde_IP', CURRENT_TIMESTAMP)";

//echo $sql;		
$mysqli->query($sql);



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

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<link href="estilos2.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" border="0" cellpadding="2">
        <tr>
          <td colspan="4"><img src="img/NombreCol.jpg" width="266" height="61" /></td>
        </tr>
        <tr>
          <td colspan="4">&nbsp;
            <table width="100%" border="0" cellpadding="2" >
              <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
                <td>C&eacute;dula</td>
                <td>Apellidos y Nombres</td>
                <td>Cargo</td>
              </tr>
              <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
                <td><?php echo $Cedula; ?></td>
                <td><?php echo $Nombres.' '.$Nombre2.' '.$Apellidos.' '.$Apellido2; ?></td>
                <td>&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
          <td>&nbsp;</td>
          <td width="20%" align="center">Deducci&oacute;n</td>
          <td width="20%" align="center">Pago</td>
          <td width="20%" align="center">Total</td>
        </tr>
<?php 
$sql = "SELECT * FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Codigo_Quincena = '$CodigoQuincena'
		ORDER BY Concepto";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>&nbsp;<?php echo $Concepto; ?></td>

<?php 
if($Monto > 0){
	$MontoSuma = $Monto;
	$MontoResta = "";
	}
if($Monto < 0){
	$MontoSuma = "";
	$MontoResta = $Monto;
	}
$SubTotal+=$Monto;
?>
  <td align="right">&nbsp;<?php echo Fnum($MontoResta);  ?></td>
  <td align="right">&nbsp;<?php echo Fnum($MontoSuma);  ?></td>
  <td align="right">&nbsp;</td>
</tr>
<?php 	
	
} 




$sql = "SELECT * FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Mes = '$Mes'
		AND Ano = '$Ano'
		AND Quincena = '$Quincena'
		ORDER BY Tipo";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	
		if($Tipo == 'PR') {
			$Desc = 'Prestamo Bs.'.Fnum($Monto).' ';
			$Monto = +$Monto;}
		if($Tipo == 'PP') {
			$Desc = 'Pago a cuenta de prestamo ';
			$Monto = -$Monto;}
		if($Tipo == 'AU') {
			$Desc = 'Ausencia(s) ';
			$Monto = -$Monto;}
		if($Tipo == 'DE') {
			$Desc = 'Deducción ';
			$Monto = -$Monto;}
		if($Tipo == 'AQ') {
			$Desc = 'Adelanto de Quincena ';
			$Monto = -$Monto;}
		if($Tipo == 'BO') {
			$Desc = 'Bonificación ';
			$Monto = +$Monto;}
		if($Tipo == 'RE') {
			$Desc = 'Reintegro ';
			$Monto = +$Monto;}
		if($Tipo == 'PA') {
			$Desc = 'Pago ';
			$Monto = +$Monto;}

	
if($Monto > 0){
	$MontoSuma = $Monto;
	$MontoResta = "";
	}
if($Monto < 0){
	$MontoSuma = "";
	$MontoResta = $Monto;
	}
$SubTotal+=$Monto;
	
	
	
?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td>&nbsp;<?php echo $Desc.$Descripcion; ?></td>
  <td align="right">&nbsp;<?php echo Fnum($MontoResta);  ?></td>
  <td align="right">&nbsp;<?php echo Fnum($MontoSuma);  ?></td>
  <td align="right">&nbsp;</td>
</tr>
<?php } ?>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td colspan="4" align="right">Total: &nbsp;<?php echo Fnum($SubTotal); ?></td>
  </tr>
</table>
</body>
</html>