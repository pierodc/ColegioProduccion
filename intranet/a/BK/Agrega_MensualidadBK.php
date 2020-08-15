<?php 
require_once('../../Connections/bd.php');
require_once('../../inc/rutinas.php');


$CodigoAlumno = "-1";
if (isset($_GET['CodigoAlumno'])) {
  $CodigoAlumno = $_GET['CodigoAlumno'];
}
mysql_select_db($database_bd, $bd);

// Busca las asignaciones del alumno
$query_RS_Asign_Alum = sprintf("SELECT * FROM AsignacionXAlumno, Asignacion 
								WHERE AsignacionXAlumno.Ano_Escolar = '$AnoEscolar' 
								AND AsignacionXAlumno.CodigoAlumno = %s 
								AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
								ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo", GetSQLValueString($CodigoAlumno, "int"));
$RS_Asign_Alum = mysql_query($query_RS_Asign_Alum, $bd) or die(mysql_error());
$row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum);
$totalRows_RS_Asign_Alum = mysql_num_rows($RS_Asign_Alum);
echo $query_RS_Asign_Alum.$totalRows_RS_Asign_Alum;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body <?php //echo 'onload="window.close()"'; ?>>
<?php 
mysql_select_db($database_bd, $bd);
$CodigoAlumno = $_GET['CodigoAlumno'];

?>
<p>&nbsp;</p>
<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td>Descripción</td>
    <td>Monto</td>
    <td>Descuento</td>
    <td>Total</td>
    <td>&nbsp;</td>
  </tr>
  
  <?php 
   $MontoMensualidad = 0;
  do { // para cada asignacion del alumno
  
 $MontoMensualidad =  $MontoMensualidad + $row_RS_Asign_Alum['Monto'] - $row_RS_Asign_Alum['Descuento'];
 

  
  ?>
  
  
    <tr>
      <td><?php echo $row_RS_Asign_Alum['Descripcion']; ?></td>
      <td align="right"><?php echo $row_RS_Asign_Alum['Monto']; ?></td>
      <td align="right"><?php echo $row_RS_Asign_Alum['Descuento']; ?></td>
      <td align="right"><?php $MontoAsignacion=0;  $MontoAsignacion=$row_RS_Asign_Alum['Monto']-$row_RS_Asign_Alum['Descuento']; echo $MontoAsignacion; ?>&nbsp;</td>
      <td>
<?php 

$ReferenciaMesAno = $_GET['Mes']."-".$_GET['Ano'];

$Referencia = $row_RS_Asign_Alum['Codigo'];

// Busca si la asignacion del mes existe
$query_RS_Factura = "SELECT * FROM ContableMov 
						WHERE CodigoPropietario = $CodigoAlumno 
						AND ReferenciaMesAno = '$ReferenciaMesAno' 
						AND Referencia = $Referencia"; 
$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
$totalRows_RS_Factura = mysql_num_rows($RS_Factura);
echo $query_RS_Factura.$totalRows_RS_Factura."<br>";

if($totalRows_RS_Factura==0){ // si no existe la asignacion entonces se crea
echo "generar<br>";
// Agrega una mensualidad de una asignacion
	if($_GET['Mes']=='09') 
		$add_sql = ' AND Asignacion.Num_Cuotas>=12 '; else $add_sql = '';
	$sql = "";
	$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe, SWiva) ";
	
	
	$sql.= "( SELECT 
	$CodigoAlumno,
	'".$_GET['Ano'].$_GET['Mes']."01',
	'".$_GET['Ano'].$_GET['Mes']."01',
	1,
	'".$MM_Username."', 
	'$Referencia' ,
	'".$_GET['Mes']."-".$_GET['Ano']."', 
	CONCAT( Asignacion.Descripcion, '')  , 
	(Asignacion.Monto - AsignacionXAlumno.Descuento),  
	Asignacion.SWiva 
	FROM  AsignacionXAlumno, Asignacion 
	WHERE AsignacionXAlumno.Ano_Escolar = '$AnoEscolar' 
	AND AsignacionXAlumno.CodigoAlumno = $CodigoAlumno 
	AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo 
	AND AsignacionXAlumno.CodigoAsignacion = $Referencia  
	$add_sql
	ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo )";   
	echo $sql;
	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());


}else{
echo "existe";
}
?>      
      </td>
    </tr>
    <?php } while ($row_RS_Asign_Alum = mysql_fetch_assoc($RS_Asign_Alum)); ?>
  <tr>
    <td>Fraccion Agosto</td>
    <td><?php echo $_GET['SWAgostoFraccionado']*$MontoFraccMensualidad; ?></td>
    <td></td>
    <td>&nbsp;</td>
    <td>
    
    <?php 

if($_GET['SWAgostoFraccionado']!=0 and $_GET['Mes']!='09'){

// Busca si existe la fraccion de agosto de la mensualidad
$query_RS_Factura = "SELECT * FROM ContableMov WHERE CodigoPropietario = $CodigoAlumno AND ReferenciaMesAno = '$ReferenciaMesAno' AND Referencia = 'FrA'"; //echo $query_RS_Factura;
$RS_Factura = mysql_query($query_RS_Factura, $bd) or die(mysql_error());
$row_RS_Factura = mysql_fetch_assoc($RS_Factura);
$totalRows_RS_Factura = mysql_num_rows($RS_Factura);

if($totalRows_RS_Factura==0 and $_GET['SWAgostoFraccionado']!=0 and $_GET['Mes']!='09'){
echo "generar";
// Agrega fraccion de AGOSTO
	$MontoFraccMensualidad = round ($MontoMensualidad/10 , 2);
	$sql = "";
	$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe) ";
	$sql.= "VALUES ($CodigoAlumno, '".$_GET['Ano'].$_GET['Mes']."01', NOW(), '".$_GET['Ano'].$_GET['Mes']."01', 1, '".$_SESSION['MM_Username']."', ";
	$sql.= "'FrA' , '".$_GET['Mes']."-".$_GET['Ano']."', CONCAT( 'Fraccion de Agosto', ' ".$_GET['Mes']."-".$_GET['Ano']."')  , $MontoFraccMensualidad )"; //echo '<br><br>'.$sql;
	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
}}
	
	?>
    
    </td>
  </tr>
    
</table>
<p>&nbsp;</p>
<p>
  <?php 

// Agrega una mensualidad


//if (isset($_GET['CodigoAlumno'])) {
//	$sql = "";
//	$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe,  SWiva) ";
//	$sql.= "( SELECT $CodigoAlumno, '".$_GET['Ano'].$_GET['Mes']."01', NOW(), '".$_GET['Ano'].$_GET['Mes']."01', 1, '".$_SESSION['MM_Username']."', ";
//	$sql.= "Asignacion.Codigo , '".$_GET['Mes']."-".$_GET['Ano']."', CONCAT( Asignacion.Descripcion, '')  , ";
//	$sql.= "(Asignacion.Monto - AsignacionXAlumno.Descuento) ,  Asignacion.SWiva ";
//	$sql.= "FROM  AsignacionXAlumno, Asignacion ";
//	$sql.= "WHERE (AsignacionXAlumno.CodigoAlumno = $CodigoAlumno AND AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo) ";
//	$sql.= "ORDER BY Asignacion.Orden, AsignacionXAlumno.Codigo )";  //echo $sql;
	// $RS_sql = mysql_query($sql, $bd) or die(mysql_error());
	
	
//if($_GET['SWAgostoFraccionado'] and $_GET['Mes']!='09'){ // Agrega fraccion de AGOSTO
//	$sql = "";
//	$sql = "INSERT INTO ContableMov (CodigoPropietario, Fecha, FechaIngreso, FechaValor, SWValidado, RegistradoPor, Referencia, ReferenciaMesAno, Descripcion, MontoDebe) ";
//	$sql.= "VALUES ($CodigoAlumno, '".$_GET['Ano'].$_GET['Mes']."01', NOW(), '".$_GET['Ano'].$_GET['Mes']."01', 1, '".$_SESSION['MM_Username']."', ";
//	$sql.= "'FrA' , '".$_GET['Mes']."-".$_GET['Ano']."', CONCAT( 'Fraccion de Agosto', ' ".$_GET['Mes']."-".$_GET['Ano']."')  , $MontoFraccMensualidad )"; //echo '<br><br>'.$sql;
//	$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
//}
//}

?>
</p>
</body>
</html>
<?php
mysql_free_result($RS_Asign_Alum);

mysql_free_result($RS_Factura);
?>
