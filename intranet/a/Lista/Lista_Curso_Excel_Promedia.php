<?php 


require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 



$NombreArch = CurSec($_GET['CodigoCurso']);

$export_file = "xlsfile://tmp/$NombreArch.xls";
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . basename($export_file) . "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );


$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Lista Curso para Excel</title>
</head>

<body>
<?php 




$SI = "IF";
$CONTAR = "COUNT";
$SUMA = "SUM";
$SEP = ",";
	

$SI = "SI";
$CONTAR = "CONTAR";
$SUMA = "SUMA";	
$SEP = ";";
	
?>
<table width="600" border="1">
  <tr>
    <td colspan="3" rowspan="2">Colegio San Francisco de As&iacute;s</td>
    <td rowspan="4"><?php echo "Act 1"; ?></td>
    <td rowspan="4"><?php echo "Act 2"; ?></td>
    <td rowspan="4"><?php echo "Act 3"; ?></td>
    <td rowspan="4"><?php echo "Act 4"; ?></td>
    <td rowspan="4"><?php echo "Act 5"; ?></td>
    <td rowspan="4"></td>
    <td rowspan="4"></td>
    <td rowspan="4"></td>
    <td rowspan="4"></td>
    <td rowspan="4"></td>
    <td rowspan="4"></td>
    <td rowspan="4">&nbsp;</td>
    <td>=<?php echo $SI.'(P5<1'.$SEP.'"Falta"'.$SEP.'"")' ; ?></td>
    <td>.</td>
  </tr>
  <tr>
    <td>=<?php echo $SI.'(P5<1'.$SEP.'1-P5'.$SEP.'"")'; ?></td>
    <td>.</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2">Curso: <?php echo Curso($row_RS_Alumno['CodigoCurso']); ?></td>
    <td>&nbsp;</td>
    <td>.</td>
  </tr>
  <tr>
    <td>Sobre 20</td>
    <td>.</td>
  </tr>
  <tr>
    <td>No.</td>
    <td>Cod.</td>
    <td>Alumno</td>
    <td>20%</td>
    <td>20%</td>
    <td>20%</td>
    <td>20%</td>
    <td>20%</td>
    <td>0%</td>
    <td>0%</td>
    <td>0%</td>
    <td>0%</td>
    <td>0%</td>
    <td>0%</td>
    <td>0%</td>
    <td>=<?php echo $SUMA.'(D5:O5)'; ?></td>
    <td></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo ++$i; ?></td>
      <td><?php echo $row_RS_Alumno['CodigoAlumno']; ?></td>
      <td><?php echo trim($row_RS_Alumno['Apellidos'].' '.$row_RS_Alumno['Apellidos2']). ', '. trim($row_RS_Alumno['Nombres'].' '.$row_RS_Alumno['Nombres2']); ?></td>
      <td><?php if($i==1) echo 20; ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?php 
	  $j=$i+5;	  
	  echo "=$SI($CONTAR(D".$j.":O".$j.")>0".$SEP."(D".$j."*D$5+E".$j."*E$5+F".$j."*F$5+G".$j."*G$5+H".$j."*H$5+I".$j."*I$5+J".$j."*J$5+K".$j."*K$5+L".$j."*L$5+M".$j."*M$5+N".$j."*N$5+O".$j."*O$5)/1".$SEP.'""'.")";
	  ?></td>      
      <td></td>
    </tr>
    <?php } while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($RS_Alumno);
?>
