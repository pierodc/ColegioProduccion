<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 


$CodigoEmpleado = $_GET['CodigoEmpleado'];

$query_RS_Empleados = "SELECT * FROM Empleado 
						WHERE CodigoEmpleado = '$CodigoEmpleado' 
						";//ORDER BY $add_Orden
//echo $query_RS_Empleados;
$RS_Empleados = $mysqli->query($query_RS_Empleados);
$totalRows_RS_Empleados = $RS_Empleados->num_rows;



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Administraci&oacute;n SFDA</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0">
<?php while ($row = $RS_Empleados->fetch_assoc()) { 
	extract($row);

?>
  <tr>
    <td colspan="9"><?php echo $Apellidos .' '. $Nombres.' '. DDMMAAAA($FechaIngreso) ?> .</td>
    <td colspan="3" align="center">Descuentos</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Sueldo</td>
    <td align="center">SueldoBase_1</td>
    <td align="center">SueldoBase_2</td>
    <td align="center">SueldoBase_3</td>
    <td align="center">HrAcad</td>
    <td align="center">BsHrAcad</td>
    <td align="center">HrAdmi</td>
    <td align="center">BsHrAdmi</td>
    <td align="center">Total Base</td>
    <td align="center">ivss</td>
    <td align="center">LH</td>
    <td align="center">spf</td>
    <td align="center">Neto</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>Actual</td>
    <td align="center"><?php echo Fnum($SueldoBase_1) ?></td>
    <td align="center"><?php echo Fnum($SueldoBase_2) ?></td>
    <td align="center"><?php echo Fnum($SueldoBase_3) ?></td>
    <td align="center"><?php echo $HrAcad ?></td>
    <td align="center"><?php echo $BsHrAcad ?></td>
    <td align="center"><?php echo $HrAdmi ?></td>
    <td align="center"><?php echo $BsHrAdmi ?></td>
    <td align="center"><?php 
	$TotalBase = $SueldoBase_1 + $SueldoBase_2 + $SueldoBase_3 + 2*$HrAcad*$BsHrAcad + 2*$HrAdmi*$BsHrAdmi;
	echo Fnum($TotalBase) ?></td>
    <td align="center"><?php echo Fnum($SW_ivss*.04*$TotalBase); ?></td>
    <td align="center"><?php echo Fnum($SW_lph*.01*$TotalBase); ?></td>
    <td align="center"><?php echo Fnum($SW_spf*.005*$TotalBase); ?></td>
    <td align="center"><strong><?php 
	
$Neto = $TotalBase - round(($SW_ivss*.04*$TotalBase + $SW_lph*.01*$TotalBase + $SW_spf*.005*$TotalBase),2);	
	echo Fnum($Neto); $NetoActual=$Neto; ?></strong></td>
    <td align="center">Actual</td>
    
    <?php 

$sql = "SELECT *  FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Codigo_Quincena = '2014 09 2'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	$Depositado += $row_pago['Monto'];
    }


?>    
  </tr>
  <tr>
    <td nowrap="nowrap">Anterior</td>
    <td align="center"><?php echo Fnum($SueldoBase_1_prox) ?></td>
    <td align="center"><?php echo Fnum($SueldoBase_2_prox) ?></td>
    <td align="center"><?php echo Fnum($SueldoBase_3_prox) ?></td>
    <td align="center"><?php echo $HrAcad_prox ?></td>
    <td align="center"><?php echo $BsHrAcad_prox ?></td>
    <td align="center"><?php echo $HrAdmi_prox ?></td>
    <td align="center"><?php echo $BsHrAdmi_prox ?></td>
    <td align="center"><?php 
	$TotalBase = $SueldoBase_1_prox + $SueldoBase_2_prox + $SueldoBase_3_prox + 2*$HrAcad_prox*$BsHrAcad_prox + 2*$HrAdmi_prox*$BsHrAdmi_prox;
	echo Fnum($TotalBase) ?></td>
    <td align="center"><?php echo Fnum($SW_ivss*.04*$TotalBase); ?></td>
    <td align="center"><?php echo Fnum($SW_lph*.01*$TotalBase); ?></td>
    <td align="center"><?php echo Fnum($SW_spf*.005*$TotalBase); ?></td>
    <td align="center"><strong>
      <?php 
	
$Neto = $TotalBase - round(($SW_ivss*.04*$TotalBase + $SW_lph*.01*$TotalBase + $SW_spf*.005*$TotalBase),2);	
	echo Fnum($Neto); $NetoAnterior=$Neto; ?>
    </strong></td>
    <td align="center">Anterior</td>
  </tr>
  <tr>
    <td colspan="14" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">&nbsp;</td>
    <td align="center">Abonos Adic</td>
    <td align="center">Deducc</td>
    <td align="center">Depositado</td>
    <td align="center">Actual</td>
    <td align="center">Dif</td>
    <td colspan="8" rowspan="7" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap">2da Sep</td>
    <td align="right"><?php 
	
$sql = "SELECT *  FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Quincena = '2' 
		AND Mes = '09' 
		AND Ano = '2014'
		AND Tipo = 'PA'";
$RSpago = $mysqli->query($sql);
$Depositado = 0;
while ($row_pago = $RSpago->fetch_assoc()) {
	
	echo $row_pago['Descripcion'].' '.$row_pago['Monto'];
	
	$Depositado += $row_pago['Monto'];
    }
	
	
	
	 ?></td>
    <td align="right"><?php 
	
$sql = "SELECT *  FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Quincena = '2' 
		AND Mes = '09' 
		AND Ano = '2014'
		AND Tipo = 'DE'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	
	echo $row_pago['Descripcion'].' '.$row_pago['Monto'];
	
	$Depositado -= $row_pago['Monto'];
    }
	
	
	
	 ?></td>
    <td align="right"><?php
	
	
$sql = "SELECT *  FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Codigo_Quincena = '2014 09 2'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	$Depositado += $row_pago['Monto'];
    }

	 echo Fnum($Depositado); ?></td>
    <td align="right"><?php echo Fnum($NetoActual) ?></td>
    <td align="right"><strong>
      <?php 
	$Dif = $NetoActual - $Depositado;
	$DifAcumulada += $Dif;
	echo Fnum($Dif) ?>
    </strong></td>
    <?php 
	
$Neto = $TotalBase - round(($SW_ivss*.04*$TotalBase + $SW_lph*.01*$TotalBase + $SW_spf*.005*$TotalBase),2);	
	
	?>
    <?php 


?>
  </tr>
  <tr>
    <td nowrap="nowrap">1ra Oct</td>
    <td align="right"><?php 
	
$sql = "SELECT *  FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Quincena = '1' 
		AND Mes = '10' 
		AND Ano = '2014'
		AND Tipo = 'PA'";
$RSpago = $mysqli->query($sql);
$Depositado = 0;
while ($row_pago = $RSpago->fetch_assoc()) {
	
	echo $row_pago['Descripcion'].' '.$row_pago['Monto'];
	
	$Depositado += $row_pago['Monto'];
    }
	
	
	
	 ?></td>
    <td align="right"><?php 
	
$sql = "SELECT *  FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Quincena = '1' 
		AND Mes = '10' 
		AND Ano = '2014'
		AND Tipo = 'DE'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	
	echo $row_pago['Descripcion'].' '.$row_pago['Monto'];
	
	$Depositado -= $row_pago['Monto'];
    }
	
	
	
	 ?></td>
    <td align="right"><?php 	

$sql = "SELECT *  FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Codigo_Quincena = '2014 10 1'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	$Depositado += $row_pago['Monto'];
    }

echo Fnum($Depositado); ?></td>
    <td align="right"><?php echo Fnum($NetoActual) ?></td>
    <td align="right"><strong>
      <?php 
	$Dif = $NetoActual-$Depositado;
	$DifAcumulada += $Dif;
	echo Fnum($Dif) ?>
    </strong></td>
    <?php 
	
$Neto = $TotalBase - round(($SW_ivss*.04*$TotalBase + $SW_lph*.01*$TotalBase + $SW_spf*.005*$TotalBase),2);	
	
	?>
  </tr>
  <tr>
    <td nowrap="nowrap">2da Oct</td>
    <td align="right"><?php 
	
$sql = "SELECT *  FROM Empleado_Deducciones 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Quincena = '2' 
		AND Mes = '10' 
		AND Ano = '2014'
		AND Tipo = 'PA'";
$RSpago = $mysqli->query($sql);
$Depositado = 0;
while ($row_pago = $RSpago->fetch_assoc()) {
	
	echo $row_pago['Descripcion'].' '.$row_pago['Monto'];
	
	$Depositado += $row_pago['Monto'];
    }
	
	
	
	 ?></td>
    <td align="right">&nbsp;</td>
    <td align="right"><?php 	

$sql = "SELECT *  FROM Empleado_Pago 
		WHERE Codigo_Empleado = '$CodigoEmpleado' 
		AND Codigo_Quincena = '2014 10 2'";
$RSpago = $mysqli->query($sql);
while ($row_pago = $RSpago->fetch_assoc()) {
	$Depositado += $row_pago['Monto'];
    }

echo Fnum($Depositado); ?></td>
    <td align="right"><?php echo Fnum($NetoActual) ?></td>
    <td align="right"><strong>
      <?php 
	$Dif = $NetoActual-$Depositado;
	$DifAcumulada += $Dif;
	echo Fnum($Dif) ?>
    </strong></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Monto retroactivo</td>
    <td align="right"><?php echo Fnum($DifAcumulada); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Monto Depositado el 6 nov</td>
    <td align="right"><?php echo Fnum($Pago_extra); ?></td>
  </tr>
  <tr>
    <td colspan="5" align="right">Diferencia</td>
    <td align="right"><?php echo Fnum($Pago_extra-$DifAcumulada); ?></td>
  </tr>
<?php } ?>  
</table>


<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>