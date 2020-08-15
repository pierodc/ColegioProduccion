<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
//require_once('../../../inc/xls/excel.php'); 



//$MM_authorizedUsers = "91;admin;Contable";
//require_once(',,/,,/,,/inc/Login_check,php'); 

$Recibos_FechaHasta = "";
if ($_POST['FechaHasta'] > "1") {
	$Recibos_FechaHasta = $_POST['FechaHasta'];
	$Recibos_FechaHasta = " AND Fecha <= '".$_POST['FechaHasta']."' ";
}

$colname_RS_Recibos = "-1";
//if (isset($_POST['Fecha'])) {
if (isset($_POST['Mes']) or isset($_POST['ControlInicial'])) {
	
	/*
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Control_Numero >= '".$_POST['ControlDesde']."' 
							AND Control_Numero <= '".$_POST['ControlHasta']."' 
							ORDER BY Control_Numero";
	*/
	
	$Mes = substr("0".$_POST['Mes'],-2);
	$MesProx = $_POST['Mes']+1;
	$MesProx = substr("0".$MesProx,-2);
	
	
	$query_RS_Control = "SELECT * FROM Recibo
							WHERE Recibo.Fecha >= '2016-".$Mes."-01' 
							AND Recibo.Fecha < '2016-".$MesProx."-01' 
							AND NumeroFactura > 0 
							ORDER BY Recibo.Fecha, NumeroFactura";
	//echo $query_RS_Control.'<br>';					
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$NumeroFactura_0 = $row['NumeroFactura'];
	//echo $NumeroFactura_0.'<br>';
	
	
	$query_RS_Control = "SELECT * FROM Recibo
							WHERE Recibo.Fecha >= '2016-".$Mes."-01' 
							AND Recibo.Fecha < '2016-".$MesProx."-01'  
							AND NumeroFactura > 0
							ORDER BY Recibo.Fecha, NumeroFactura DESC";
	//echo $query_RS_Control.'<br>';						
	$RS = $mysqli->query($query_RS_Control);
	$row = $RS->fetch_assoc();
	$NumeroFactura_1 = $row['NumeroFactura'];
	//echo $NumeroFactura_1.'<br>';
	
	
	
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Factura_Numero >= $NumeroFactura_0
							AND Factura_Numero >= $NumeroFactura_1 
							ORDER BY Factura_Numero";
	
	
	
	$Control_Numero_0 = $_POST['ControlInicial'];
	$Control_Numero_1 = $_POST['ControlFinal'];						
	$query_RS_Control = "SELECT * FROM Factura_Control
							WHERE Control_Numero >= $Control_Numero_0
							AND Control_Numero <= $Control_Numero_1 
							ORDER BY Control_Numero";
							
	
	
	//echo $query_RS_Control.'<br>';					
							
	$RS = $mysqli->query($query_RS_Control);
	//echo $query_RS_Control;
}


if ($_POST['Salida'] == "Excel"){
	
require_once('../../../inc/xls/excel.php'); 
$export_file = "xlsfile://tmp/example,xls";
header ("Expires: Mon; 26 Jul 1997 05:00:00 GMT");
//header ("Last-Modified: " , gmdate("D;d M YH:i:s") , " GMT");
header ("Cache-Control: no-cache; must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
//header ("Content-Disposition: attachment; filename=\"" , basename($export_file) , "\"" );
header ("Content-Description: PHP/INTERBASE Generated Data" );



/*
header('Content-Type: application/octetstream');  
header('Content-Disposition: attachment; filename=LibroVentas,csv'); 
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
    <!--  <label>
  Buscar Facturas fechas <br />
  desde
  <input name="Fecha" type="date" id="Fecha" value="<?php 
  if(isset($_POST['Fecha']))
  	echo $_POST['Fecha'];
  else
  	echo date('Y-m-d'); ?>">
  </label>
  <label>&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp;&nbsp; hasta
    <input name="FechaHasta" type="date" id="FechaHasta" value="<?php 
  if(isset($_POST['FechaHasta']))
  	echo $_POST['FechaHasta']; 
  else
  	echo date('Y-m-d');?>" />
    <br />
  </label>
  -->
    Mes de: 
    
    <label for="Mes">Select:</label>
    <select name="Mes" id="Mes">
      <option value="0">Seleccione...</option>
      
      <?php 
	
foreach	($MesNom as $clave => $valor) {
	
	echo '<option value="'.$clave.'">'.$valor.'</option>';
	
	}
	
	
	?>
      
    </select>
  <br />
    <label>
      <input name="Salida" type="radio" id="Salida_0" value="Excel" checked="checked" />
      Excel</label>
  </p>
  <p>
    <label for="ControlInicial">Control inicial:</label>
    <input type="text" name="ControlInicial" id="ControlInicial" />
  </p>
  <p>
    <label for="ControlFinal">Control Final:</label>
    <input type="text" name="ControlFinal" id="textfield2" />
    <br />
    <label><br /> 
      <input type="submit" name="button" id="button" value="Buscar">
    </label>
  </p>
</form><br><br>
</table>

</body>
</html>
<?php } 

 if (isset($_POST['ControlInicial'])){ 
  
  
  while ($row = $RS->fetch_assoc()) { 
  
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
	print DDMMAAAA($row_RS_Recibos['Fecha']).';';
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
			print ($row_RS_Recibos['Base_Exe']+$row_RS_Recibos['Base_Imp']+$row_RS_Recibos['Monto_IVA']).';'; }
	else 
			print '0,00;';		
	print '0,00;';
	if($SW_Nula) {
			print ($row_RS_Recibos['Base_Exe']).';'; $Excento+=$row_RS_Recibos['Base_Exe'];}
		else 
			print '0,00;';		
	print '0,00;';	
	print '0,00;';


if($SW_Nula) {
		print ($row_RS_Recibos['Base_Imp']).';'; $Imponible+=$row_RS_Recibos['Base_Imp'];}
	else 
		print '0,00;';		
	
	print '12%;';
	
if($SW_Nula) {
		print ($row_RS_Recibos['Monto_IVA']).';'; $Iva+=$row_RS_Recibos['Monto_IVA'];}
	else 
		print '0,00;';		
	
print ";0,00;8%;0,00;0,00;22%;0,00;0;00;;;;;;;;;;;;;;;;;;;";
print "\n";	
  
	  }} ?>