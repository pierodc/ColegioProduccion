<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
//require_once('../../../inc/xls/excel.php'); 
//echo "<pre>";
//var_dump($_POST);

//$MM_authorizedUsers = "91;admin;Contable";
//require_once(',,/,,/,,/inc/Login_check,php'); 

function Decimal($Num , $Punto){	
	if($Punto == "coma")
		$Num = str_replace(".",",",$Num);
	echo $Num;
}

$Ano = date('Y');

$Recibos_FechaHasta = "";
if ($_POST['FechaHasta'] > "1") {
	$Recibos_FechaHasta = $_POST['FechaHasta'];
	$Recibos_FechaHasta = " AND Fecha <= '".$_POST['FechaHasta']."' ";
}




$colname_RS_Recibos = "-1";
//if (isset($_POST['Fecha'])) {
if (isset($_POST['MesAno'])) {
	
		
	$MesAno = $_POST['MesAno'];
	
	$query_RS_Control = "SELECT * FROM Recibo
							WHERE Recibo.Fecha >= '".$MesAno."-01' 
							AND Recibo.Fecha <= '".$MesAno."-31' 
							AND NumeroFactura > 0 
							ORDER BY Recibo.Fecha, NumeroFactura";
	//echo "1) ".$query_RS_Control.'<br>';					
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$NumeroFactura_0 = $row['NumeroFactura'];
	//echo "2) ".$NumeroFactura_0.'<br>';
	
	
	$query_RS_Control = "SELECT * FROM Recibo
							WHERE Recibo.Fecha >= '".$MesAno."-01' 
							AND Recibo.Fecha <= '".$MesAno."-31'  
							AND NumeroFactura > 0
							ORDER BY NumeroFactura DESC";
	//echo "3) ".$query_RS_Control.'<br>';						
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$NumeroFactura_1 = $row['NumeroFactura'];
	//echo "4) ".$NumeroFactura_1.'<br>';
	
	
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Factura_Numero >= $NumeroFactura_0
							AND Factura_Numero <= $NumeroFactura_1 
							ORDER BY Control_Numero";
		
	$query_RS_Control_xx = "SELECT * FROM Factura_Control
							WHERE Factura_Numero = $NumeroFactura_0
							ORDER BY Control_Numero ASC";
							
							
	//echo "5) ".$query_RS_Control.'<br>';					
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$Control_Numero_0 = $row['Control_Numero'];
	
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Factura_Numero = $NumeroFactura_1
							ORDER BY Control_Numero DESC";
	//echo "6) ".$query_RS_Control.'<br>';					
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$Control_Numero_1 = $row['Control_Numero'];
	
	
	
	$Control_Numero_0 = $_POST['ControlInicial'];
	$Control_Numero_1 = $_POST['ControlFinal'];
							
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Control_Numero >= $Control_Numero_0
							AND Control_Numero <= $Control_Numero_1 
							ORDER BY Control_Numero";
							
	
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Factura_Numero >= $NumeroFactura_0
							AND Factura_Numero <= $NumeroFactura_1 
							ORDER BY Control_Numero";
	
	
	
	
	//echo "7) ".$query_RS_Control.'<br>';					
							
	$RS = $mysqli->query($query_RS_Control);
	//echo $query_RS_Control;
}
//


if ($_POST['Salida'] == "Excel"){
	
require_once('../../../inc/xls/excel.php'); 
$export_file = "xlsfile://tmp/example.xls";
header ("Expires: Mon; 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " , gmdate("D;d M YH:i:s") , " GMT");
header ("Cache-Control: no-cache; must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=\"" , basename($export_file) , "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );


header('Content-Disposition: attachment; filename=LibroVentas.csv'); 

/*
header('Content-Type: application/octetstream');  
header('Pragma: public'); 
*/

}

else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1,0 Transitional//EN" "http://www,w3,org/TR/xhtml1/DTD/xhtml1-transitional,dtd">
<html xmlns="http://www,w3,org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Libro Vantas</title>
</head>

<body><form name="form1" method="post" action="">
  <p>
    Mes
    :
    <input name="MesAno" type="month" id="MesAno" />
    <br />
    <label for="select">Decimal</label>
    <select name="Decimal" id="Decimal">
      <option value="coma">Coma</option>
      <option value="punto">Punto</option>
    </select>
<br /> 
    <input name="Salida" type="radio" id="Salida_0" value="Excel" checked="checked" />
    Excel
    <br /> 
    <input type="submit" name="button" id="button" value="Buscar">
    
   

 
  </p>
 
 
  <!--p>
    <label for="ControlInicial">Control inicial:</label>
    <input type="text" name="ControlInicial" id="ControlInicial" />
  </p>
  <p>
    <label for="ControlFinal">Control Final:</label>
    <input type="text" name="ControlFinal" id="ControlFinal" />
    <br />

  </p-->
</form><br><br>
</table>

</body>
</html>
<?php } 

 if (isset($_POST['button'])){ 
  
  $Punto = $_POST['Decimal'];
  
  while ($row = $RS->fetch_assoc()) { 
  
	$query_RS_Recibo = "SELECT * FROM Recibo
						WHERE Fac_Num_Control = '".$row['Control_Numero']."'";
	
	$query_RS_Recibo = "SELECT * FROM Recibo
						WHERE NumeroFactura = '".$row['Factura_Numero']."'";
						
						
	//echo $query_RS_Recibo;						
	$RS_Factura = $mysqli->query($query_RS_Recibo);
	$row_RS_Recibos = $RS_Factura->fetch_assoc();


    if ($row['SW_Nula'] == '0')
	 	$SW_Nula = true;
	else
	 	$SW_Nula = false;


	print ';';
	if($row_RS_Recibos['Fecha'] > "2016-01-01")
		print DDMMAAAA($row_RS_Recibos['Fecha']).';';
	else
		print DDMMAAAA("0000-00-00").';';
		
	if($SW_Nula) 
		print $row_RS_Recibos['Fac_Rif'].';';
	else 
		print ';';
	if($SW_Nula) 
		print utf8_encode(ucwords(sinAcento(strtolower($row_RS_Recibos['Fac_Nombre'])) )) .';'; 
	else 
		print 'NULA;';
	print ';;;;';
	
	print $row['Factura_Numero'].';';
	print $row['Control_Numero'].';';
	print ';;';
	print '01-Reg;';
	print ';';
	if($SW_Nula) {
			print Decimal($row_RS_Recibos['Base_Exe']+$row_RS_Recibos['Base_Imp']+$row_RS_Recibos['Monto_IVA'],$Punto).';'; }
	else 
			print '0;';		
	print '0;';
	if($SW_Nula) {
			print Decimal($row_RS_Recibos['Base_Exe'],$Punto).';'; $Excento+=$row_RS_Recibos['Base_Exe'];}
		else 
			print '0;';		
	print '0;';	
	print '0;';


if($SW_Nula) {
		print Decimal($row_RS_Recibos['Base_Imp'],$Punto).';'; $Imponible+=$row_RS_Recibos['Base_Imp'];}
	else 
		print '0;';		
	
	print '12%;';
	
if($SW_Nula) {
		print Decimal($row_RS_Recibos['Monto_IVA'],$Punto).';'; $Iva+=$row_RS_Recibos['Monto_IVA'];}
	else 
		print '0;';		
	
print ";0;8%;0;0;22%;0;0;0;;;;;;;;;;;;;;;;;;;";
print "\n";	
  
	  }} ?>