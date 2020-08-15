<?php 
require_once("../../../Connections/bd.php"); 
require_once("../archivo/Variables.php"); 
require_once("../../../inc/rutinas.php"); 
require_once "../../../xls/excel.php";

$export_file = "xlsfile://tmp/example.xls";
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

?>
<table width="600" border="1">
  <tr>
    <td colspan="3" rowspan="2" align="center" valign="middle"><h3>Colegio San Francisco de As&iacute;s</h3></td>
    <td rowspan="3" align="center"><?php echo "Ac 1"; ?></td>
    <td rowspan="3" align="center"><?php echo "Tl 1"; ?></td>
    <td rowspan="3" align="center"><?php echo "Q 1"; ?></td>
    <td rowspan="3" align="center"><?php echo "Ex 1"; ?></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center"></td>
    <td rowspan="3" align="center">&nbsp;</td>
    <td align="center">=<?php echo $SI ?>(P5 < 1 ;"Falta";"")</td>
  </tr>
  <tr>
    <td>=<?php echo $SI ?>(P5 < 1 ; 1-P4 ; "")</td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle"><h2>Curso: <?php echo Curso($row_RS_Alumno['CodigoCurso']); ?></h2></td>
    <td align="center">Sobre 20</td>
  </tr>
<?php if ($_GET['Promedio']==1){ ?>
  <tr>
    <td>No.</td>
    <td>Cod.</td>
    <td>Alumno</td>
    <td align="center">70%</td>
    <td align="center">15%</td>
    <td align="center">10%</td>
    <td align="center">5%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">0%</td>
    <td align="center">=<?php echo $SUMA ?>(D5:O5)</td>
  </tr>
<?php } ?>
<?php do { 
extract($row_RS_Alumno);
?>

<?php if ($_GET['Promedio']==1){ ?>
    <tr>
      <td><?php echo ++$i; ?></td>
      <td><?php echo $CodigoAlumno; ?></td>
      <td><?php echo trim($Apellidos.' '.substr($Apellidos2,0,1)). ', '. trim($Nombres.' '.substr($Nombres2,0,1)); ?></td>
      <td align="center"><?php if($i==1) echo 20; ?></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"><?php 
	  $j=$i+5;	  
	  echo "=$SI($CONTAR(D".$j.":O".$j.")>0; (D".$j."*D$5+E".$j."*E$5+F".$j."*F$5+G".$j."*G$5+H".$j."*H$5+I".$j."*I$5+J".$j."*J$5+K".$j."*K$5+L".$j."*L$5+M".$j."*M$5+N".$j."*N$5+O".$j."*O$5)/1;".'""'.")";
	  ?></td>      
    </tr>
<?php }else{ ?> 
    <tr>
      <td><?php echo ++$i; ?></td>
      <td><?php echo $CodigoAlumno; ?></td>
      <td><?php echo trim($Apellidos.' '.substr($Apellidos2,0,1)). ', '. trim($Nombres.' '.substr($Nombres2,0,1)); ?></td>
      <td align="center"><?php echo $Sexo; ?></td>
      <td align="center"><?php echo DDMMAAAA($FechaNac); ?></td>
      <td align="center"><?php echo ucwords(strtolower($Localidad)); ?></td>
      <td align="center"><?php echo ucwords(strtolower($EntidadCorta.' '.$LocalidadPais)); ?></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
    </tr>
<?php } ?>   
    <?php } while ($row_RS_Alumno = mysql_fetch_assoc($RS_Alumno)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($RS_Alumno);
?>
