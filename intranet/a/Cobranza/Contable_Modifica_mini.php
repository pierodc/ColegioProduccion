<?php
$MM_authorizedUsers = "99,91,95,90";
if (isset($_POST["MM_update"])) {
	$SW_omite_trace = false;}
else{
	$SW_omite_trace = true;}
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE ContableMov 
		SET Referencia=%s WHERE Codigo=%s",
		GetSQLValueString($_POST['Referencia']*1, "text"),
		GetSQLValueString($_POST['Codigo'], "int"));

	//mysql_select_db($database_bd, $bd);
	$Result1 = $mysqli->query($updateSQL); //mysql_query($updateSQL, $bd) or die(mysql_error());

	$updateGoTo = "Contable_Modifica.php";
	if (isset($_SERVER['QUERY_STRING'])) {
		$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	//header(sprintf("Location: %s", $updateGoTo));
}

$colname_RS_Contable_Mov = "-1";
if (isset($_GET['Codigo'])) {
	$colname_RS_Contable_Mov = $_GET['Codigo'];
}
$sql = sprintf("SELECT * FROM ContableMov 
					WHERE Codigo = %s", GetSQLValueString($colname_RS_Contable_Mov, "int"));
$RS_Contable_Mov = $mysqli->query($sql);
$row_RS_Contable_Mov = $RS_Contable_Mov->fetch_assoc();
//$Conteo = $RS_Contable_Mov->num_rows;


//$RS_Contable_Mov = $mysqli->query($sql);
//$row_RS_Contable_Mov = $RS_Contable_Mov->fetch_assoc();

$ReferenciaActual = $row_RS_Contable_Mov['Referencia'];
$CodigoAlumno = $row_RS_Contable_Mov['CodigoPropietario'];

$MontoHaber = $row_RS_Contable_Mov['MontoHaber'];
$Fecha = $row_RS_Contable_Mov['Fecha'];
$Tipo = $row_RS_Contable_Mov['Tipo'];
$CodigoCuenta = $row_RS_Contable_Mov['CodigoCuenta'];


$Alumno = new Alumno($row_RS_Contable_Mov['CodigoPropietario']);


$query_RS_Banco_Mov_Disponible = "SELECT * FROM Contable_Imp_Todo 
									WHERE MontoHaber = $MontoHaber 
									AND CodigoCuenta = $CodigoCuenta 
									ORDER BY CodigoCuenta, Fecha DESC"; //echo $query_RS_Banco_Mov_Disponible;
$RS_Banco_Mov_Disponible = $mysqli->query($query_RS_Banco_Mov_Disponible);
$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();
$totalRows_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->num_rows;




$query_RS_Alumno_PPMM = "SELECT * FROM Representante 
						WHERE Nexo <> 'Autorizado' 
						AND Nexo <> 'ExAutorizado'
						AND Cedula > ''
						AND Creador = '".$Alumno->Creador()."'";
$RS = $mysqli->query($query_RS_Alumno_PPMM);
while ($row = $RS->fetch_assoc()) {
	$Representante[] =  $row;
	$Cedulas[] =  filter_var(str_replace("-","",$row['Cedula']),FILTER_SANITIZE_NUMBER_INT);
}
$Cedulas[] =  $row_RS_Contable_Mov['CiRifEmisor'];

?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0;
	margin-right: 0px;
	margin-bottom: 0;
}
</style>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<table >
<tr valign="baseline">

 <td>
 
 <?php 
		//echo $row_RS_Banco_Mov_Disponible['Referencia'] .' > '. $ReferenciaActual.'';
		if($row_RS_Banco_Mov_Disponible['Referencia'] == $ReferenciaActual and $row_RS_Banco_Mov_Disponible['Referencia'] > 0){
		//if($valido){ ?>
 <a href="Estado_de_Cuenta_Alumno.php?CodigoAlumno=<?php echo $CodigoAlumno; ?>" target="_blank" class="ListadoPar12Verde" >Facturar</a> 
<?php } ?>
 
 </td>   

  <td align="left" nowrap="nowrap" class="FondoCampo">
  <select name="Referencia" id="select">
    <?

$MontoHaber = $row_RS_Contable_Mov['MontoHaber'];
$Fecha = $row_RS_Contable_Mov['Fecha'];
$Tipo = $row_RS_Contable_Mov['Tipo'];


if($row_RS_Contable_Mov['Referencia'] > ""){					
	$query_RS_Banco_Mov_aux = " SELECT * FROM Contable_Imp_Todo 
													WHERE Referencia = ".$row_RS_Contable_Mov['Referencia']." 
													AND CodigoCuenta = $CodigoCuenta 
													AND MontoHaber = '$MontoHaber'
													ORDER BY CodigoCuenta, Fecha DESC"; //echo $query_RS_Banco_Mov_Disponible;
	$RS_Banco_Mov_aux = $mysqli->query($query_RS_Banco_Mov_aux);
	$row_RS_Banco_Mov_aux = $RS_Banco_Mov_aux->fetch_assoc();
	
	
}

?>
    <option value="<?php echo $row_RS_Contable_Mov['Referencia']; ?>"><?php echo $row_RS_Contable_Mov['Referencia'].' '.$row_RS_Banco_Mov_aux['Descripcion']; ?></option>
    <?php
	
	
echo '<option value="">-.-</option>';
							
do { 

$DIf_Fechas = dateDif( $row_RS_Banco_Mov_Disponible['Fecha'] , $row_RS_Contable_Mov['Fecha'] )*1;
if ( $DIf_Fechas > 5) // mas de 5 dias en el pasado 
	break;

if($DIf_Fechas > -5){


$sql = "SELECT * FROM ContableMov WHERE Referencia = '". $row_RS_Banco_Mov_Disponible['Referencia']."'";
$RS_sql = $mysqli->query($sql);
$row_RS_sql = $RS_sql->fetch_assoc();
$totalRows_RS_sql = $RS_sql->num_rows;


if( $totalRows_RS_sql == 0 ) {

$startDate = $row_RS_Banco_Mov_Disponible['Fecha'];
$endDate = $row_RS_Contable_Mov['Fecha'];
$Diferencia = dateDif($startDate, $endDate);

$TimeStam = dddDDMMAAAA($row_RS_Banco_Mov_Disponible['Fecha']);

++$Conteo;
$SignoDiferenciaActual = Signo($Diferencia);
if($SignoDiferenciaAnterior <> $SignoDiferenciaActual and $Conteo <> 1)
	echo '<option value=""> ........ </option>';


if ($Diferencia < 45) {

	
$Opcion_Referencia = $row_RS_Banco_Mov_Disponible['Referencia'];
$Selected = false;
	
	
foreach($Cedulas as $Ced){
  if (($Ced > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$Ced )) or 
      ($CiRifEmisor > ' ' and  strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$CiRifEmisor ))){
    $Selected = true;
  }
}	
	
	 $Localizado = false;
	foreach($Cedulas as $Ced){
	  if (($Ced > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$Ced )) or 
		 ($CiRifEmisor > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$CiRifEmisor ))
		 and !$Localizado){
		  //echo " <-";
		  $Localizado = true;}
	}


if($Privilegios == 91 or $Localizado)	{
	
	
	echo '<option value="' . $Opcion_Referencia . '"';
	if($Selected) {
	  echo ' selected="selected" ';
	}
	echo '>';

	echo DDMM($row_RS_Banco_Mov_Disponible['Fecha']).' ';

	if($Diferencia == 0) {
	  echo '-> '; }
	else {
	  echo '(Dif: '.$Diferencia.') '; }

	echo $row_RS_Banco_Mov_Disponible['Descripcion']; 
	echo '  Ref:' . $row_RS_Banco_Mov_Disponible['Referencia']; 

	if($Localizado){
		echo " <-";}

	if (strpos($row_RS_Banco_Mov_Disponible['Descripcion'],"CH" )){
	  echo " * OJO CHEQUE * ";}

	?>
	  </option>
	  <? 

}
	
	
	
	
$SignoDiferenciaAnterior = Signo($Diferencia);

} // if($Diferencia < 45){ 
else break;

} // if( $totalRows_RS_sql == 0 ) {


} // if($DIf_Fechas > -5){
} while ($row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc());
$rows = $RS_Banco_Mov_Disponible->num_rows;

if($rows > 0) {
	
	$RS_Banco_Mov_Disponible = $mysqli->query($query_RS_Banco_Mov_Disponible);
	//$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();

	//mysql_data_seek($RS_Banco_Mov_Disponible, 0);
	
	
	$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();
}
	  
	  
?>
    </select>
  <?php 
	
if( $row_RS_Contable_Mov['Referencia'] != $row_RS_Contable_Mov['ReferenciaOriginal']){
	echo "<br>Ref Original: ".$row_RS_Contable_Mov['ReferenciaOriginal'];
} 
	
	
	
	?></td>
  <td align="left" nowrap="nowrap" class="FondoCampo"><input type="submit" name="submit" id="submit" value="G">
    <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $row_RS_Contable_Mov['Codigo']; ?>" />
    <input type="hidden" name="MM_update" value="form1" /></td>
 
 

    
</tr>
</table>


</form>