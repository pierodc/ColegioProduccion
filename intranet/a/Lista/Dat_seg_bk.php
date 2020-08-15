<?php
$MM_authorizedUsers = "99,91,95,90,secreAcad,AsistDireccion";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php'); 
require_once('../../../inc/rutinas.php'); 
require_once '../../../xls/excel.php';

$export_file = "xlsfile://tmp/ListaSeguro.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );

$FechaObj = date('Y').'-09-30'; //Para calculo de antiguedad


echo $query_RS_Alumno;
mysql_select_db($database_bd, $bd);

$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table border="1">
<?php 
do {
extract($row_RS_Alumno);
?>
<tr>
        <td><?php 
        if(strlen($Cedula) > 8) { 
        	echo "M"; } 
        else 
        	echo $CedulaLetra; ?></td>
            
            
            
        <td><?php 
        	echo $Cedula;
        ?></td>
        <td><?php 
        	echo $CedulaMama; 
        ?></td>
        
        
        
        <td><?php echo strtoupper(NoAcentos($Apellidos)); ?></td>
        <td><?php echo strtoupper(NoAcentos($Apellidos2)); ?></td>
        <td><?php echo strtoupper(NoAcentos($Nombres)); ?></td>
        <td><?php echo strtoupper(NoAcentos($Nombres2)); ?></td>
        <td><?php echo DDMMAAAA($FechaNac) ?>&nbsp;</td>
        <td><?php echo Edad($FechaNac); ?></td>
        <td><?php echo $Sexo ?></td>
    </tr>
<?php } while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); ?>         
</table>
</body>
</html>
