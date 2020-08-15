<?php 
$MM_authorizedUsers = "91";
require_once('../../../../inc_login_ck.php'); 

require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

//mysql_select_db($database_bd, $bd);
$sql = "SELECT * FROM Empleado WHERE SW_activo = '1' ORDER BY FechaIngreso ASC";
$RS = $mysqli->query($sql);

require_once '../../../../inc/xls/excel.php';
$export_file = "xlsfile://tmp/Empleados.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );

$FechaObj = date('Y').'-09-30'; //Para calculo de antiguedad

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Lista Curso para Excel</title>
</head>

<body><table width="600" border="1">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr><?php 

while ($row = $RS->fetch_assoc()) { 
	
	extract($row);
	$SueldoBase = $SueldoBase*2;
  	
  ?>
    <tr>
      <td colspan="7"><?php echo Titulo(sinAcento($Apellidos.' '.$Apellido2.' '.$Nombres.' '.$Nombre2)); ?></td>
      <td><?php if($CedulaLetra == "V") echo "X"; ?></td>
      <td><?php if($CedulaLetra == "E") echo "X"; ?></td>
      <td colspan="3"><?php echo $Cedula; ?></td>
      <td><?php echo DiaN($FechaNac); ?></td>
      <td><?php echo MesN($FechaNac); ?></td>
      <td><?php echo AnoN($FechaNac); ?></td>
      <td colspan="7"><?php echo $Dir1.' '.$Dir2.' '.$Dir3; ?></td>
      <td colspan="3"><?php echo $NumRegistro; ?></td>
      <td><?php echo DiaN($FechaIngresoIVSS); ?></td>
      <td><?php echo MesN($FechaIngresoIVSS); ?></td>
      <td><?php echo AnoN($FechaIngresoIVSS); ?></td>
      <td><?php echo DiaN($FechRetiroIVSS); ?></td>
      <td><?php echo MesN($FechRetiroIVSS); ?></td>
      <td><?php echo AnoN($FechRetiroIVSS); ?></td>
      <td colspan="2"><?php echo $SueldoDiario; ?></td>
      <td colspan="2"><?php echo $Semanal; ?></td>
      <td colspan="3"><?php echo $SueldoBase; ?></td>
      <td colspan="3"><?php echo $CotizacionTrabajador; ?></td>
      <td colspan="3"><?php echo $CotizacionEmpleador; ?></td>
      <td colspan="3"><?php echo $TotalAportes; ?></td>
      <td colspan="3"><?php echo $rpe; ?></td>
      <td colspan="3"><?php echo $rpe; ?></td>
      <td colspan="3"><?php echo $rpe; ?></td>
      <td colspan="4"><?php echo $Ocupacion; ?></td>
      <td colspan="4"><?php echo $Otro; ?></td>
    </tr>
    
    <?php } ?>
</table>
</body>
</html>