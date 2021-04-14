<?php
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE ContableMov 
		SET BancoOrigen=%s, CodigoCuenta=%s, CodigoPropietario=%s, Tipo=%s, Fecha=%s, FechaIngreso=%s, Referencia=%s, ReferenciaBanco=%s, Descripcion=%s, MontoDebe=%s, MontoHaber=%s, RegistradoPor=%s, Observaciones=%s, CiRifEmisor=%s  WHERE Codigo=%s",
		GetSQLValueString($_POST['BancoOrigen'], "text"),
		GetSQLValueString($_POST['CodigoCuenta'], "int"),
		GetSQLValueString($_POST['CodigoPropietario'], "int"),
		GetSQLValueString($_POST['Tipo'], "text"),
		GetSQLValueString($_POST['Fecha'], "date"),
		GetSQLValueString($_POST['FechaIngreso'], "date"),
		GetSQLValueString($_POST['Referencia']*1, "text"),
		GetSQLValueString($_POST['ReferenciaBanco'], "text"),
		GetSQLValueString($_POST['Descripcion'], "text"),
		GetSQLValueString($_POST['MontoDebe'], "double"),
		GetSQLValueString($_POST['MontoHaber'], "double"),
		GetSQLValueString($_POST['RegistradoPor'], "text"),
		GetSQLValueString($_POST['Observaciones'], "text"),
		GetSQLValueString($_POST['CiRifEmisor'], "text"),

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
$RS_Contable_Mov = $mysqli->query($sql); //
$row_RS_Contable_Mov = $RS_Contable_Mov->fetch_assoc();


//$RS_Contable_Mov = $mysqli->query($sql);
//$row_RS_Contable_Mov = $RS_Contable_Mov->fetch_assoc();


$sql = sprintf("UPDATE ContableMov 
				SET FechaContableModifica = CURRENT_TIMESTAMP
					WHERE Codigo = %s", GetSQLValueString($colname_RS_Contable_Mov, "int"));
$mysqli->query($sql);

$MontoHaber = $row_RS_Contable_Mov['MontoHaber'];
$Fecha = $row_RS_Contable_Mov['Fecha'];
$Tipo = $row_RS_Contable_Mov['Tipo'];
$CodigoCuenta = $row_RS_Contable_Mov['CodigoCuenta'];

/*
$RS_Contable_Mov = mysql_query($query_RS_Contable_Mov, $bd) or die(mysql_error());
$row_RS_Contable_Mov = mysql_fetch_assoc($RS_Contable_Mov);
$totalRows_RS_Contable_Mov = mysql_num_rows($RS_Contable_Mov);
*/

$Alumno = new Alumno($row_RS_Contable_Mov['CodigoPropietario']);


$query_RS_Banco_Mov_Disponible = "SELECT * FROM Contable_Imp_Todo 
									WHERE MontoHaber = $MontoHaber 
									AND CodigoCuenta = $CodigoCuenta 
									ORDER BY CodigoCuenta, Fecha DESC"; //echo $query_RS_Banco_Mov_Disponible;
$RS_Banco_Mov_Disponible = $mysqli->query($query_RS_Banco_Mov_Disponible); //
$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();
$totalRows_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->num_rows;


//$RS_Banco_Mov_Disponible = mysql_query($query_RS_Banco_Mov_Disponible, $bd) or die(mysql_error());
//$row_RS_Banco_Mov_Disponible = mysql_fetch_assoc($RS_Banco_Mov_Disponible);
//$totalRows_RS_Banco_Mov_Disponible = mysql_num_rows($RS_Banco_Mov_Disponible);



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

?><!doctype html>
<html lang="es">
	<head>
		<!-- Required meta tags -->
		<meta charset="ISO-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="Cobranza/common.css">
		<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

		<link href="http://<?= $_SERVER['HTTP_HOST']; ?>/estilos2.css" rel="stylesheet" type="text/css" />
	
<title>Administraci&oacute;n SFDA</title>

</head>

<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<p>&nbsp;</p><p>&nbsp;</p>
		</div>
	</div>
		<div class="row">
		<div class="col-md-10">
						Modifica Pago
		</div>
				<div class="col-md-2 text-right">
						<img src="../../../i/undo32.png" width="32" height="32" onclick="window.close()" />
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
			Alumno: <a href="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $Alumno->CodigoClave(); ?>" >
			<?php echo $Alumno->NombreApellidoCodigo(); ?></a>
			</div>
	</div>
		<div class="row">
		<div class="col-md-10">

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<table >


<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Fecha</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><?php echo substr( dddDDMMAAAA($row_RS_Contable_Mov['Fecha']) ,0,3); ?>:
<input name="Fecha" type="date" id="Fecha" value="<?php echo $row_RS_Contable_Mov['Fecha'] ?>" />
<?php //FechaFutura('Fecha', $row_RS_Contable_Mov['Fecha']);  ?></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Referencia</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><?php 
if($row_RS_Contable_Mov['CiRifEmisor']>''){
		echo $row_RS_Contable_Mov['CiRifEmisor'].'<br>';} ?>
<?php echo $row_RS_Contable_Mov['Referencia']; ?> ->
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
$RS_Banco_Mov_aux = $mysqli->query($query_RS_Banco_Mov_aux); //
$row_RS_Banco_Mov_aux = $RS_Banco_Mov_aux->fetch_assoc();
//$Conteo = $RS->num_rows;
	
	
//$RS_Banco_Mov_aux = mysql_query($query_RS_Banco_Mov_aux, $bd) or die(mysql_error());
//$row_RS_Banco_Mov_aux = mysql_fetch_assoc($RS_Banco_Mov_aux);
}

?>
	<option value="<?php echo $row_RS_Contable_Mov['Referencia']; ?>">No Cambiar -> <?php echo DDMM($row_RS_Banco_Mov_aux['Fecha']) .' '.$row_RS_Contable_Mov['Referencia'].' '.$row_RS_Banco_Mov_aux['Descripcion']; ?></option>
	<?php
echo '<option value=""> . </option>';
							
do { 

$DIf_Fechas = dateDif( $row_RS_Banco_Mov_Disponible['Fecha'] , $row_RS_Contable_Mov['Fecha'] )*1;
if ( $DIf_Fechas > 5) // mas de 5 dias en el pasado 
break;

if($DIf_Fechas > -5){


$sql = "SELECT * FROM ContableMov WHERE Referencia = '". $row_RS_Banco_Mov_Disponible['Referencia']."'";
$RS_sql = $mysqli->query($sql); //
$row_RS_sql = $RS_sql->fetch_assoc();
$totalRows_RS_sql = $RS_sql->num_rows;
	
	
//$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
//$row_RS_sql = mysql_fetch_assoc($RS_sql);
//$totalRows_RS_sql = mysql_num_rows($RS_sql);

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

echo '<option value="' . $row_RS_Banco_Mov_Disponible['Referencia'] . '"';

$Selected = false;
foreach($Cedulas as $Ced){
  if (($Ced > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$Ced )) or 
      ($CiRifEmisor > ' ' and  strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$CiRifEmisor ))){
    $Selected = true;
  }
}
if($Selected) {
  echo ' selected="selected" ';
}
echo '>';
?> 
	 



  	<?php 

echo DDMM($row_RS_Banco_Mov_Disponible['Fecha']).' ';

if($Diferencia == 0) {
  echo ' ---- > '; }
else {
  echo '(Dif: '.$Diferencia.') '; }

echo $row_RS_Banco_Mov_Disponible['Descripcion']; 
echo '  Ref:' . $row_RS_Banco_Mov_Disponible['Referencia']; 

foreach($Cedulas as $Ced){
  if (($Ced > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$Ced )) or 
     ($CiRifEmisor > ' ' and strpos($row_RS_Banco_Mov_Disponible['Descripcion'],$CiRifEmisor )))
  echo " <<< ---  ";
}
if (strpos($row_RS_Banco_Mov_Disponible['Descripcion'],"CH" )){
  echo " * OJO CHEQUE * ";}

?>
</option>
<? 

$SignoDiferenciaAnterior = Signo($Diferencia);

} // if($Diferencia < 45){ 
else break;

} // if( $totalRows_RS_sql == 0 ) {


} // if($DIf_Fechas > -5){
} while ($row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc());
$rows = $RS_Banco_Mov_Disponible->num_rows;
if($rows > 0) {
	
$RS_Banco_Mov_Disponible = $mysqli->query($query_RS_Banco_Mov_Disponible); //
//$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();
	
//mysql_data_seek($RS_Banco_Mov_Disponible, 0);
	
$row_RS_Banco_Mov_Disponible = $RS_Banco_Mov_Disponible->fetch_assoc();
}
?>
	</select>
<?php 
if( $row_RS_Contable_Mov['Referencia']!=$row_RS_Contable_Mov['ReferenciaOriginal']){
echo "<br>Ref Original: ".$row_RS_Contable_Mov['ReferenciaOriginal'];
} ?></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo"><a href="Contable_Modifica_iFr.php?CodigoAlumno=<?php echo $Alumno->Codigo(); ?>&MontoHaber=<?php echo $row_RS_Contable_Mov['MontoHaber']; ?>" target="Movs">Monto</a></td>
<td align="left" nowrap="nowrap" class="FondoCampo"><input type="text" name="MontoHaber" value="<?php echo $row_RS_Contable_Mov['MontoHaber']; ?>" size="15" /></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Tipo</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><label>
	<select name="Tipo" id="Tipo">
		<option>Seleccione...</option>
		<option value="1" <?php if ($row_RS_Contable_Mov['Tipo']==1) echo "SELECTED"; ?>>Deposito</option>
		<option value="2" <?php if ($row_RS_Contable_Mov['Tipo']==2) echo "SELECTED"; ?>>Transferencia</option>
		<option value="3" <?php if ($row_RS_Contable_Mov['Tipo']==3) echo "SELECTED"; ?>>Cheque</option>
		<option value="4" <?php if ($row_RS_Contable_Mov['Tipo']==4) echo "SELECTED"; ?>>Efectivo</option>
      <option value="5" <?php if ($row_RS_Contable_Mov['Tipo']==6) echo "SELECTED"; ?>>Ajuste</option>   
      <option value="6" <?php if ($row_RS_Contable_Mov['Tipo']==6) echo "SELECTED"; ?>>T. Debito</option>  
      <option value="7" <?php if ($row_RS_Contable_Mov['Tipo']==7) echo "SELECTED"; ?>>T. Credito</option>      
        
        
        </select>
</label></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">En</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><select name="CodigoCuenta" id="CodigoCuenta">
<option>Seleccione...</option>
<option value="1" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==1) echo "SELECTED"; ?>>Mercantil</option>
<option value="2" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==2) echo "SELECTED"; ?>>Provincial</option>
<?php  //if ($_SESSION['MM_UserGroup']=='99'){  ?>
<option value="3" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==3) echo "SELECTED"; ?>>Venezuela</option>
<option value="4" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==4) echo "SELECTED"; ?>>V. de Cred.</option>
 <option value="5" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==5) echo "SELECTED"; ?>>Activo</option>
<option value="10" <?php if ($row_RS_Contable_Mov['CodigoCuenta']==10) echo "SELECTED"; ?>>Caja</option>
<?php //} ?>
</select></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Banco Cheque</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><input name="ReferenciaBanco" type="text" id="ReferenciaBanco" value="<?php echo $row_RS_Contable_Mov['ReferenciaBanco']; ?>" size="20" /></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Observaciones</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><label>
<input name="Observaciones" type="text" id="Observaciones"  value="<?php echo $row_RS_Contable_Mov['Observaciones']; ?>" size="20" />
</label></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">Banco Origen</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><input name="BancoOrigen" type="text" id="BancoOrigen"  value="<?php echo $row_RS_Contable_Mov['BancoOrigen']; ?>" size="20" /></td>
</tr>
<tr valign="baseline">
<td align="right" nowrap="nowrap" class="NombreCampo">CiRifEmisor</td>
<td align="left" nowrap="nowrap" class="FondoCampo"><input name="CiRifEmisor" type="text" id="CiRifEmisor"  value="<?php echo $row_RS_Contable_Mov['CiRifEmisor']; ?>" size="20" /></td>
</tr>
<tr valign="baseline">
<td colspan="2" align="right" nowrap="nowrap"><input type="submit" name="submit" id="submit" value="Submit">
  <input name="Codigo" type="hidden" id="Codigo" value="<?php echo $row_RS_Contable_Mov['Codigo']; ?>" />
<input type="hidden" name="CodigoPropietario" value="<?php echo $row_RS_Contable_Mov['CodigoPropietario']; ?>" />
<input type="hidden" name="RegistradoPor" value="<?php echo $row_RS_Contable_Mov['RegistradoPor']; ?>" />
<input type="hidden" name="Descripcion" value="<?php echo $row_RS_Contable_Mov['Descripcion']; ?>" />
<input type="hidden" name="MontoDebe" value="<?php echo $row_RS_Contable_Mov['MontoDebe']; ?>" />
<input type="hidden" name="FechaIngreso" value="<?php echo $row_RS_Contable_Mov['FechaIngreso']; ?>" />
<input type="hidden" name="MM_update" value="form1" /></td>
</tr>
<tr valign="baseline">
  <td colspan="2" align="right" nowrap="nowrap"><a href="../Email/index.php?CodigoAlumno=<?= $Alumno->Codigo(); ?>&CodigoPago=<?= $row_RS_Contable_Mov['Codigo']; ?>&Email=Pagos_a_Provincial" target="_blank">Email Pago a Prov</a></td>
</tr>
</table>
</form>
	
			</div>
	</div>
	 
		<div class="row">
		<div class="col-md-12">
			<div>
<table >
<?php foreach ($Representante as $row_RS_Alumno_PPMM)  { ?>
<tr>
    <td><?php echo $row_RS_Alumno_PPMM['Nexo'] ?>&nbsp;</td>
    <td><?php echo $row_RS_Alumno_PPMM['Apellidos'].", ".$row_RS_Alumno_PPMM['Nombres']; ?>&nbsp;</td>
    <td align="right">&nbsp;<?php 
    
    //echo $row_RS_Alumno_PPMM['Cedula']; 
    if(strlen($row_RS_Alumno_PPMM['Cedula']) > 3 ){
    
    $Cedulas[$j] = filter_var(str_replace("-","",$row_RS_Alumno_PPMM['Cedula']),FILTER_SANITIZE_NUMBER_INT);
    echo '<a href="Contable_Modifica_iFr.php?CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&Descripcion='.$Cedulas[$j].'" target="Movs">';
    
    echo $Cedulas[$j];
    echo '</a> ';
    $j++;
    }
    
     ?></td>
    <td align="right"><?php 
    
    $CiRifEmisor = filter_var(str_replace("-","",$row_RS_Contable_Mov['CiRifEmisor']),FILTER_SANITIZE_NUMBER_INT);	
    if( $CiRifEmisor == $row_RS_Alumno_PPMM['Cedula']){
    echo "*";
    }						
    ?>&nbsp;</td>
</tr>
<?php }?>


<tr>
<td>&nbsp;</td>
<td align="right">&nbsp;<?php echo $row_RS_Contable_Mov['BancoOrigen']; ?></td>
<td align="right"><?php 

echo '<a href="Contable_Modifica_iFr.php?CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&Descripcion='.$CiRifEmisor.'" target="Movs">';

echo $CiRifEmisor;
echo '</a> ';



?></td>
<td align="right">&nbsp;</td>
</tr>
</table>
						
						
						</div>
		</div>
	</div>
		<div class="row">
		<div class="col-md-12">
		<?php 
if(!isset($_POST['MM_update']) ){
	$sql = "SELECT Contable_Imp_Todo.*, ContableMov.*, Contable_Imp_Todo.Descripcion AS Descrip 
	FROM Contable_Imp_Todo, ContableMov 
	WHERE Contable_Imp_Todo.Referencia = ContableMov.Referencia 
	AND ContableMov.CodigoPropietario = '".$row_RS_Contable_Mov['CodigoPropietario']."' 
	AND Contable_Imp_Todo.Descripcion NOT LIKE '%INICIAL%'
	ORDER BY Contable_Imp_Todo.Fecha DESC";
	$RS_sql = $mysqli->query($sql); //
	//$row = $RS_sql->fetch_assoc();
	$totalRows_RS_sql = $RS_sql->num_rows;

	//echo $sql;
	//$RS_sql = mysql_query($sql, $bd) or die(mysql_error());
	//$totalRows_RS_sql = mysql_num_rows($RS_sql);
	if($totalRows_RS_sql>0){
		echo '<table border="0" cellpadding="3" width="100%">';
		while($row_RS_sql = $RS_sql->fetch_assoc()){
			echo '<tr ';
			echo $sw=ListaFondo($sw,$Verde);
			echo '><td nowrap="nowrap">'.DDMMAAAA($row_RS_sql['Fecha']).'</td>';
			
			echo '<td nowrap="nowrap">';
			
			//echo $row_RS_sql['Referencia'];
			
			echo '<a href="Contable_Modifica_iFr.php?CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&Referencia='.$row_RS_sql['Referencia'].'" target="Movs">';
			echo $row_RS_sql['Referencia'].'</a> ';
			
			
			echo '</td>';
			echo '<td nowrap="nowrap">';
			
						$Palabras_Omitir = "  TR/REC PAGOS A TERCEROS VIA INTERNET DEPOSITO ORDEN DE PAGO";
			$Palabras = str_word_count($row_RS_sql['Descrip'], 1, '0123456789/');
			foreach($Palabras as $Palabra){
												if(strpos($Palabras_Omitir,$Palabra)){
														echo $Palabra.' ';}
												else{
				echo '<a href="Contable_Modifica_iFr.php?CodigoAlumno='.$row_RS_Alumno['CodigoAlumno'].'&Descripcion='.$Palabra.'" target="Movs">';
				echo $Palabra.'</a> ';
				}}
			//echo $row_RS_sql['Referencia'];
			
			echo '</td>';
			echo '<td align="right" nowrap="nowrap">'.Fnum($row_RS_sql['MontoHaber']).'</td></tr>';
			
			$TotalHaberes += $row_RS_sql['MontoHaber'];
			
		}
		if($MM_Username == 'piero')
			echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>".Fnum($TotalHaberes)."</td></tr>";
			
		echo '</table>';}
		
}

?>	
				</div>
	</div>
		<div class="row">
		<div class="col-md-12">
		<iframe src="" align="right" width="100%" name="Movs" height="800" frameborder="0" ></iframe>
		</div>
	</div>
		
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>