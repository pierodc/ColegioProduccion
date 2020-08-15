<?php 
$MM_authorizedUsers = "91";
require_once('../../../../inc_login_ck.php'); 

require_once('../../../../Connections/bd.php'); 
require_once('../../../../inc/rutinas.php'); 
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

//mysql_select_db($database_bd, $bd);
$sql = "SELECT * FROM Empleado WHERE SW_activo = '1' ORDER BY Apellidos ASC";
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
      <td>CedulaLetra</td>
      <td>Cedula</td>
      <td>Apellidos</td>
      <td>Apellido2</td>
      <td>Nombres</td>
      <td>Nombre2</td>
      <td>Sexo</td>
      <td>EdoCivil</td>
      <td>FechaNac</td>
      <td>Nacionalidad</td>
      <td>PaisNacimiento</td>
      <td>EdoNacimiento</td>
      <td>CiudadNacimiento</td>
      <td>Email</td>
      <td>TelefonoHab</td>
      <td>TelefonoHab</td>
      <td>TelefonoCel</td>
      <td>TelefonoCel</td>
      <td>SueldoBase / mes</td>
      <td>SueldoBase / sem</td>
      <td>FechaIngreso</td>
      <td>Dir1</td>
      <td>Dir2</td>
      <td>Dir3</td>
      <td>Dir4</td>
      <td>TipoEmpleado</td>
      <td>TipoDocente</td>
    </tr>


<?php 

while ($row = $RS->fetch_assoc()) { 
  extract($row);
  
	//$SueldoBase = $SueldoBase*2;
  	
  ?>
    <tr>
      <td><?php echo $CedulaLetra; ?></td>
      <td><?php echo $Cedula; ?></td>
      <td><?php echo Titulo(sinAcento($Apellidos)); ?></td>
      <td><?php echo Titulo(sinAcento($Apellido2)); ?></td>
      <td><?php echo Titulo(sinAcento($Nombres)); ?></td>
      <td><?php echo Titulo(sinAcento($Nombre2)); ?></td>
      <td><?php echo $Sexo; ?></td>
      <td><?php echo $EdoCivil; ?></td>
      <td>&nbsp;<?php echo str_replace("-","/",DDMMAAAA($FechaNac)); ?></td>
      <td><?php echo $Nacionalidad; ?></td>
      <td><?php echo $PaisNacimiento; ?></td>
      <td><?php echo $EdoNacimiento; ?></td>
      <td><?php echo $CiudadNacimiento; ?></td>
      <td><?php echo $Email; ?></td>
      <td><?php echo substr($TelefonoHab,0,4); ?></td>
      <td><?php echo substr($TelefonoHab,4,7); ?></td>
      <td><?php echo substr($TelefonoCel,0,4); ?></td>
      <td><?php echo substr($TelefonoCel,4,7); ?></td>
      <td><?php echo number_format(round($SueldoBase*2 , 2), 2, ',', ''); ?></td>
      <td><?php echo number_format(round($SueldoBase*24/52,2), 2, ',', ''); ?></td>
      <td>&nbsp;&nbsp;<?php echo DDMMAAAA($FechaIngreso); ?></td>
      <td><?php echo $Dir1; ?></td>
      <td><?php echo $Dir2; ?></td>
      <td><?php echo $Dir3; ?></td>
      <td><?php echo $Dir4; ?></td>
      <td><?php echo $TipoEmpleado; ?></td>
      <td><?php echo $TipoDocente; ?></td>
    </tr>
    
    <?php } ?>
</table>
</body>
</html>