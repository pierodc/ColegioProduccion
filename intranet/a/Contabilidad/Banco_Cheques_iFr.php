<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

$editFormAction = $php_self."?No=".$_GET['No']."&Codigo=".$_GET['Codigo'];

if ((isset($_POST["Codigo"]))) {
	if($_POST['FavorDe']=='nulo' or $_POST['FavorDe']=='NULO'){
		$Monto = 0;}
	else {
		$Monto = $_POST['Monto'];}
	
$Monto = coma_punto($_POST['Monto']);
$FavorDe = Titulo_Mm($_POST['FavorDe']);
if($_POST['FavorDe'] == 'nulo'){
	$FavorDe = $_POST['FavorDe'];
	$Monto = '';}
	//echo $FavorDe;
  $updateSQL = sprintf("UPDATE Cheque SET Fecha=%s, FavorDe=%s, ConceptoDe=%s, Monto=%s WHERE Codigo=%s",
                       GetSQLValueString(DMtoAMD($_POST['Fecha']), "date"),
                       GetSQLValueString($FavorDe, "text"),
                       GetSQLValueString($_POST['ConceptoDe'], "text"),
                       GetSQLValueString($Monto, "double"),
                       GetSQLValueString($_POST['Codigo'], "int"));
	$mysqli->query($updateSQL);

if($_POST['CodigoContabilidad'] > ""){
	$CodigoCheque = $_POST['Codigo'];
	$CodigoContabilidad = $_POST['CodigoContabilidad'];
	$CodigoContabilidadAnterior = $_POST['CodigoContabilidadAnterior'];

	$updateSQL = "UPDATE Cheque SET 
				  CodigoContabilidad = '$CodigoContabilidad'
				  WHERE Codigo = '$CodigoCheque'";
	//echo $updateSQL.'<br>';			  		  
	$mysqli->query($updateSQL) or die(mysql_error());

	$updateSQL = "UPDATE Contabilidad SET 
				  CodigoCheque = '0' , FormaPago=''
				  WHERE Codigo = '$CodigoContabilidadAnterior'";	
	//echo $updateSQL.'<br>';		  		  
	$mysqli->query($updateSQL) or die(mysql_error());
	
	$updateSQL = "UPDATE Contabilidad SET 
				  CodigoCheque = '$CodigoCheque' , FormaPago='Ch'
				  WHERE Codigo = '$CodigoContabilidad'";	
	//echo $updateSQL.'<br>';			  		  
	$mysqli->query($updateSQL) or die(mysql_error());
	
	
	
	}	
	//?No=<?php echo ++$No >&Codigo=< echo $Codigo 
header("Location: ".$php_self."?Saved=1&No=".$_GET['No']."&Codigo=".$_GET['Codigo']);

}


?><!doctype html>
<html lang="en">
<head>
<meta charset="ISO-8859-1">
<title>Untitled Document</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="../../../jquery/development-bundle/themes/base/jquery.ui.all.css">
<script src="../../../jquery/development-bundle/jquery-1.10.2.js"></script>
<script src="../../../jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../../jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../../jquery/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../../jquery/development-bundle/ui/jquery.ui.menu.js"></script>
<script src="../../../jquery/development-bundle/ui/jquery.ui.autocomplete.js"></script>
<link rel="stylesheet" href="../../../jquery/development-bundle/demos/demos.css">

<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
	<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
	</style>
	<script>
	$(function() {
		var availableTags = [
		<?php 
		
		
		$sql = "SELECT * FROM Empleado
				WHERE SW_activo = 1
				ORDER BY Apellidos, Apellido2";
		$RS = $mysqli->query($sql);
		while ($row = $RS->fetch_assoc()) {
			extract($row);
			echo "\"".$Nombres.' '.$Nombre2.' '.$Apellidos.' '."\"".',';
			echo "";
		}
		
		?>
			""
		];
		$( "#tags" ).autocomplete({
			source: availableTags
		});
	});
	</script>

</head>
<?php 

if(isset($_GET['Codigo']) ){
	$sql = "SELECT * 
			FROM Cheque 
			WHERE Codigo = '".$_GET['Codigo']."'";	
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	extract($row_);
}


$sql = "SELECT * FROM Contable_Imp_Todo WHERE
		CodigoCuenta = '$Cuenta' AND
		ChNum = '$NumCheque'";
$_RS = $mysqli->query($sql);
$_row_RS = $_RS->fetch_assoc();


//$FavorDe = strtolower($FavorDe);
?>
<body><form method="post" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" cellpadding="0" <?php if($_GET['Saved']=='1') echo ' bgcolor="#FFFFCC"'; ?> >


<tr <?php if($_GET['Saved']=='1') echo ' bgcolor="#FFFFCC"'; ?> ><td width="20" align="center"><?php echo $_GET['No'].')'; ?></td>
  <td align="center" nowrap="nowrap" ><input name="Fecha" type="<?php echo $FavorDe=='nulo'?'hidden':'text'; ?>" id="Fecha"  value="<?php 
     if($Fecha!='0000-00-00' and $Fecha!=''){
		  echo DDMM($Fecha);
		  } ?>" size="5"  <?php 
    if($Fecha=='0000-00-00' or $Fecha=='')
    echo 'onfocus="this.value=\''.date('d-m').'\'" '; ?> />
    <input type="hidden" name="Codigo" id="Codigo" value="<?php echo $Codigo; ?>" /></td>
  <td align="center" nowrap="nowrap" ><?php echo DDMMAAAA($_row_RS['Fecha']); ?>&nbsp;</td>
  <td align="center" nowrap="nowrap" ><?php echo $NumCheque; ?></td>
  <td nowrap="nowrap" ><input name="FavorDe" type="text" id="tags" value="<?php echo $FavorDe; ?>" size="45" /></td>
  <td nowrap="nowrap" ><input name="ConceptoDe" type="<?php echo $FavorDe=='nulo'?'hidden':'text'; ?>" id="ConceptoDe" value="<?php echo $ConceptoDe; ?>" size="45" /></td>
  <td nowrap="nowrap" >
  <?php if ($FavorDe!='nulo') {?>
  <input name="CodigoContabilidadAnterior" type="hidden" value="<?php echo $CodigoContabilidad ?>">
  <?php 
  
  
$sql_Gasto = "SELECT * 
			  FROM Contabilidad 
			  WHERE Monto = '".abs($Monto)."'
			  AND Fecha >= '$Fecha'
			  AND (CodigoCheque = '0' OR CodigoCheque = '$Codigo')
			  AND Monto > 0
			  ORDER BY Fecha DESC";	
$RS_Gasto = $mysqli->query($sql_Gasto);
if($RS_Gasto->num_rows > 0){

  ?>
    <select name="CodigoContabilidad" id="CodigoContabilidad">
      <option value="0"  >Seleccione...</option>

<?php 

	while($row_Gasto = $RS_Gasto->fetch_assoc()){
		
		echo '<option value="';
		echo $row_Gasto['Codigo'];
		echo '"';
		if($CodigoContabilidad == $row_Gasto['Codigo'])
			echo " selected ";
		echo '>'.$row_Gasto['Fecha'].' '.$row_Gasto['BeneficiarioNombre'];
		echo "</option>
";
		
	}


?>      
      
    </select><?php }}?></td>
  <td nowrap="nowrap" <?php 
$class = ''; 
  
if($_row_RS and abs($_row_RS['MontoDebe'])==abs($Monto)){
	$class = ' class="FondoCampoVerde"'; 
	if($SW_Pagado==0){
		$sql = "UPDATE Cheque SET SW_Pagado='1' WHERE Codigo='$Codigo'";
		$mysqli->query($sql);}
}
  
if($_totalRows_RS>0 and abs($_row_RS['MontoDebe']) != abs($Monto)){
	$class = ' class="FondoCampoRojo"'; }
  
$MontoEnBanco = abs($_row_RS['MontoDebe']);
$Monto = abs($Monto); //Monto Chequera
 
  ?>><?php 
  
  if ($Monto==0 or !$_row_RS or $MontoEnBanco!=$Monto)
		if($MontoEnBanco > 0)
			echo Fnum($MontoEnBanco) ." -> ";
  
  ?>&nbsp;</td>
  <td width="3" nowrap align="right" <?php  echo $class; ?> ><?php 
  
if($FavorDe <>'nulo'){
	if ($Monto==0 or !$_row_RS or $MontoEnBanco!=$Monto){ 
		//if($MontoEnBanco > 0)
			//echo Fnum($MontoEnBanco) ." -> ";
	
	?>
	<input name="Monto" type="<?php echo $FavorDe=='nulo'?'hidden':'text'; ?>" id="Monto" value="<?php echo $Monto>0?$Monto:''; ?>" size="12" <?php echo $MontoEnBanco!=0?'onclick="this.value='. $MontoEnBanco.'"':'' ; ?> />
	<?php } else { ?>
	
	<?php echo Fnum($Monto); 
	?><input name="Monto" type="hidden" id="Monto" value="<?php echo $Monto; ?>" size="12" /><?
	
	} 

}
?></td>
  <td width="1" align="right"><input type="submit" name="G" id="G" value="G"  onclick="this.disabled=true;this.value='...';this.form.submit();" /></td>
  <td width="2" align="right"><a href="PDF/Cheque.php?Codigo=<?php echo $Codigo ?>" target="_blank">Print</a></td>
</tr>




<tr>
  <td align="center"><img src="../../../img/b.gif" width="30" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="55" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="50" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="290" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="280" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td align="center" nowrap="nowrap" ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td align="center"  ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td align="center"><span><img src="../../../img/b.gif" alt="" width="30" height="1" /></span></td>
  <td align="center"><span><img src="../../../img/b.gif" alt="" width="30" height="1" /></span></td>
</tr>
</table>
</form>
</body>
</html>