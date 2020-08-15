<?php require_once('../../Connections/bd.php'); ?><?php require_once('../../inc/rutinas.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php 
mysql_select_db($database_bd, $bd);
// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
	$Ano = substr('20'.$_POST['Ano'],-4);
	$Mes = substr(''.$_POST['Mes'],-3);
	$Ano_Mes = $Ano.'_'.$Mes.'_';
	$NombreArchivo = "archivo/fideicomiso/".$Ano_Mes.date('Y_m_d_h_m_s').".txt";
    copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
}

if($NombreArchivo > '' ){
	$lineas = file($NombreArchivo);
	
	if($Mes=='' or $Ano==''){
		$Mes = date('m');
		$Ano = date('Y');}

	if(substr($lineas[0],0,2)=='01'){
		$Tipo = 51;
		$sql = "DELETE FROM Empleado_Deducciones WHERE Tipo='$Tipo' AND Mes='$Mes' AND Ano='$Ano'";
		mysql_query($sql, $bd) or die(mysql_error());}

	if(substr($lineas[0],0,2)=='05'){
		$Tipo = 55; 
		}
	
	
	foreach ($lineas as $linea_num => $linea) { 
		if($Tipo == 51){
			$Cedula= substr($linea,18,9)*1; 
			$Monto = round(substr($linea,-8)*1/100 , 2); }
			
		if($Tipo == 55){
			$Cedula= substr($linea,18,9)*1; 
			$Monto = round(substr($linea,27,14)*1/100 , 2); }
			
		
		$sql = "SELECT * From Empleado WHERE Cedula = '$Cedula' AND SW_activo=1";
		$RS = mysql_query($sql, $bd) or die(mysql_error());
		$row = mysql_fetch_assoc($RS);
		$CodigoEmpleado = $row['CodigoEmpleado'];

		if($Tipo == 55){
			$sql = "DELETE FROM Empleado_Deducciones 
					WHERE Tipo='$Tipo' AND Mes='$Mes' AND Ano='$Ano' AND Codigo_Empleado='$CodigoEmpleado'";
			mysql_query($sql, $bd) or die(mysql_error());}
		
		if($CodigoEmpleado==0){ 
			echo 'Registro erroneo, CI:'.$Cedula.' Monto:'.$Monto.'<br>'; }
		else{
			$sql = "INSERT INTO Empleado_Deducciones (Codigo_Empleado, Tipo, Mes, Ano, Monto) 
					VALUES ($CodigoEmpleado, $Tipo, '".$Mes."', '".$Ano."', $Monto) ";
			echo $sql.'<br>';
			echo mysql_query($sql, $bd) or die(mysql_error()); }
			
	}}
	
if(isset($_GET['CrearFide']) and $_GET['CrearFide']==1){
	
	$Nom_archivo = 'archivo/Fideicomiso.txt';
	// Abre el archivo para obtener el contenido existente
	$archivo = fopen($Nom_archivo, 'a+');

$sql = "SELECT * FROM Empleado_Deducciones , Empleado
				WHERE Empleado_Deducciones.Codigo_Empleado = Empleado.CodigoEmpleado 
				AND Empleado_Deducciones.Tipo = '55'
				AND Empleado_Deducciones.Fecha_Procesado='0000-00-00' ";	
echo $sql.'<br>';				
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_ = mysql_fetch_assoc($RS_);
//$totalRows_RS_ = mysql_num_rows($RS_);
do{
	extract($row_RS_);
	
	// Añade una nueva persona al archivo
	$actual = "05".date('dmY')."1059876";
	$actual .= $CedulaLetra.substr('0000000000'.$Cedula,-9);
	$AdelantoFC = substr('00000000000000'.round( $Monto*100),-14);
	$actual .= $AdelantoFC;
	$actual .= "200";
	$actual .= substr($NumCuenta,-10);
	$actual .= "0000\n";
	echo $actual.EmpleadoCI($Codigo_Empleado).'<br>';
	
	$Agregar.=$actual;
	
} while($row_RS_ = mysql_fetch_assoc($RS_));
	
	echo '<br>'.'<br>'.$Agregar;
	fwrite($archivo, $Agregar);
	fclose($archivo); 
		
}
	
?>
  
<form enctype="multipart/form-data" action="" method="post">
      <table width="600" border="1" align="center">
        <tr>
          <td colspan="2" class="subtitle">Enviar Archivo</td>
          <td align="right" class="subtitle">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Mes</td>
          <td colspan="2" valign="top" class="FondoCampo"><label for="Mes"></label>
          <input name="Mes" type="text" id="Mes" size="5" />
          <input name="Ano" type="text" id="Ano" size="5" />
          </td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Archivo</td>
          <td colspan="2" valign="top" class="FondoCampo"><input name="userfile" type="file" /></td>
        </tr>
        <tr>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
          <td colspan="2"><input type="submit" value="Enviar" /></td>
        </tr>
    </table>
    </form>
    <?php 
$sql = "SELECT * FROM Empleado_Deducciones 
				WHERE Tipo = '55'
				AND Fecha_Procesado='0000-00-00' ";	
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_RS_ = mysql_fetch_assoc($RS_);
$totalRows_RS_ = mysql_num_rows($RS_);
if($totalRows_RS_>0){
	?>
<table width="300" border="1" align="center">
<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
<?php do{ extract($row_RS_);?>      
      <tr>
        <td>&nbsp;<?php echo EmpleadoCI($Codigo_Empleado); ?></td>
        <td align="right">&nbsp;<?php echo Fnum($Monto); ?></td>
      </tr>
 <?php } while ($row_RS_ = mysql_fetch_assoc($RS_)); ?>     
      <tr>
        <td><a href="Sube_Fideicomiso.php?CrearFide=1">Crear Archivo</a></td>
        <td><a href="archivo/Fideicomiso.txt">Baja Archivo</a></td>
      </tr>
    </table><?php } ?>
</body>
</html>