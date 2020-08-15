<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 
mysql_select_db($database_bd, $bd);
//AND FechaIngreso <'2011-06-03'

$query_RS_Empleados = "SELECT * FROM Empleado WHERE SW_activo=1 AND SW_Antiguedad=1 ORDER BY  Apellidos, Nombres $addSQL";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>

<table width="600" border="1" cellpadding="3" cellspacing="0">
  <tr>
    <td nowrap="nowrap">&nbsp;<?php 
$Nom_archivo = 'archivo/Fideicomiso.txt';
echo unlink($Nom_archivo).'ok';
$txt='';
?>
</td>
    <td nowrap="nowrap">Nombre&nbsp;</td>
    <td nowrap="nowrap">Fecha Ing</td>
    <td nowrap="nowrap">Sueldo <br />
    Base &nbsp;</td>
    <td nowrap="nowrap">Sueldo <br />
    Diario</td>
    <td nowrap="nowrap"><p>Tiempo <br />
      Lab<br />
      <?php $FechaObj = '2012-09-15'; echo $FechaObj; ?>
    </p></td>
    <td nowrap="nowrap">Dias <br />
    Bono</td>
    <td nowrap="nowrap"><p>Monto<br />
      Bono
    </p></td>
    <td nowrap="nowrap">Sueld<br />
      Dia<br />
      Int</td>
    <td nowrap="nowrap">Sep 11</td>
    <td nowrap="nowrap">Oct ...</td>
  </tr>
  <?php do{ 
  extract($row_RS_Empleados); ?>
  <tr>
    <td align="right" nowrap="nowrap">55<?php echo ++$i ?>&nbsp;</td>
    <td nowrap="nowrap"><?php echo $Apellidos. ' ' .$Nombres ?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php echo DDMMAAAA($FechaIngreso); ?></td>
    <td align="right" nowrap="nowrap"><?php echo Fnum($SueldoBase*2);  ?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php $SueldoDiario = round($SueldoBase/15 , 2); echo $SueldoDiario;  ?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php 
	
	//echo $Anos_Laorados; 

$AnosLaborados = Fecha_Meses_Laborados($FechaIngreso,$FechaObj); 

echo $AnosLaborados;

if($AnosLaborados>=1 and $AnosLaborados<=15) $AnosLaborados =  floor($AnosLaborados);
if($AnosLaborados>15) $AnosLaborados =  15;

echo " ( $AnosLaborados a)";
	?></td>
    <td align="right" nowrap="nowrap"><?php 
	
	$DiasBono = 6+$AnosLaborados;
	
		echo $DiasBono.' d';
		
		
	  ?></td>
    <td align="right" nowrap="nowrap"><?php 
	$MontoBono = round($DiasBono*$SueldoDiario , 2);
	echo Fnum($MontoBono); ?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php 
	
	$SueldoIntDia = round( ($SueldoBase*2*14 + $MontoBono)/365 ,2);
	
	echo Fnum($SueldoIntDia);
	
	?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php 
	$MontoSep = round($SueldoIntDia*2.5 , 2);
	$TotSep += $MontoSep;
	echo Fnum($MontoSep); ?>&nbsp;</td>
    <td align="right" nowrap="nowrap"><?php 
	$MontoOct = round($SueldoIntDia*5 , 2);
	$TotOct += $MontoOct;
	echo Fnum($MontoOct); ?>&nbsp;</td>
  </tr>
  <?php 
  
  
//  $Monto = substr('000000000000'.$MontoSep*100 , -14);
  
  $Monto = substr('000000000000'.$MontoOct*100 , -14);
  
$txt .= '01'.date('dmY').'1059876'.$CedulaLetra. substr('0000000000'.$Cedula,-9).$Monto.'
'; 
  
  } while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados));
  
  ?>
  <tr>
    <td>&nbsp;<?php echo $_SERVER['HTTP_ACCEPT_CHARSET']; ?></td>
    <td><?php echo date('mm:ss') ?>&nbsp;</td>
    <td>ii</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?php echo Fnum($TotSep); ?>&nbsp;</td>
    <td align="right"><?php echo Fnum($TotOct); ?>&nbsp;</td>
  </tr>
</table>
<?php  
	
	$Nom_archivo = 'archivo/Fideicomiso.txt';
	// Abre el archivo para obtener el contenido existente
	$archivo = fopen($Nom_archivo, 'w');
	fwrite($archivo, $txt);
	fclose($archivo); 


?> 
<a href="archivo/Fideicomiso.txt" target="_blank">Archivo</a>
</body>
</html>