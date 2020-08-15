<?php 
$MM_authorizedUsers = "91,Contable";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
require_once('../archivo/Variables.php');



$TituloPantalla = "Gastos";
$php_self .= '?'.$_SERVER['QUERY_STRING'];
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$Redirect = $_SERVER['PHP_SELF']."?Mes=$Mes&Ano=$Ano";
if(isset($_GET['Cuenta1']))
	$Redirect = $_SERVER['PHP_SELF']."?Cuenta1=".$_GET['Cuenta1'];
if(isset($_GET['Cuenta11']))
	$Redirect .= "&Cuenta11=".$_GET['Cuenta11'];
if(isset($_GET['Cuenta111']))
	$Redirect .= "&Cuenta111=".$_GET['Cuenta111'];


if(isset($_POST['UPDATE']) or isset($_POST['INSERT'])){
	extract($_POST);
	//echo $Cuenta123.'<br>';
	if($Cuenta123 > ""){
		$Cuenta123 = explode("::",$Cuenta123);
		if($Cuenta123[0] > ' ')
			$Cuenta1   = $Cuenta123[0];
		if($Cuenta123[1] > ' ')
			$Cuenta11  = $Cuenta123[1];
		if($Cuenta123[2] > ' ')
			$Cuenta111 = $Cuenta123[2];	}

//	echo $Cuenta123[0].' '.$Cuenta123[1].' '.$Cuenta123[2].'<br>';

	if($Cuenta1add > ''){
		$Cuenta1 = $Cuenta1add;
		$Cuenta1 = str_replace('_',' ',$Cuenta1);}
		
	if($Cuenta11add > ''){
		$Cuenta11 = $Cuenta11add;
		$Cuenta11 = str_replace('_',' ',$Cuenta11);}
		
	if($Cuenta111add > ''){
		$Cuenta111 = $Cuenta111add;
		$Cuenta111 = str_replace('_',' ',$Cuenta111);}

	$Monto = coma_punto($Monto);

}

if(isset($_POST['INSERT'])){
	$sql = "INSERT INTO Contabilidad (Fecha, Cuenta1, Cuenta11, Cuenta111, Descripcion, Monto, BeneficiarioNombre, BeneficiarioRif, MM_Username_db, FormaPago, Banco, Numero, Base_Exenta,Base_Imponible,Tasa_IVA,Monto_IVA,Porcentaje_Retencion) VALUES
			('$Fecha','$Cuenta1','$Cuenta11','$Cuenta111','$Descripcion','$Monto','$BeneficiarioNombre','$BeneficiarioRif','$MM_Username','$FormaPago','$Banco','$Numero','$Base_Exenta','$Base_Imponible','$Tasa_IVA','$Monto_IVA','$Porcentaje_Retencion')";
	//echo $sql.'<br>';
	$mysqli->query($sql);
}

/*
if(false and isset($_POST['UPDATE'])){
	$sql = "UPDATE Contabilidad SET 
			Fecha = '$Fecha', Cuenta1 = '$Cuenta1', Cuenta11 = '$Cuenta11', Cuenta111 = '$Cuenta111', 
			Descripcion = '$Descripcion', Monto = '$Monto', BeneficiarioNombre = '$BeneficiarioNombre', 
			BeneficiarioRif = '$BeneficiarioRif', MM_Username_db = '$MM_Username',
			FormaPago = '$FormaPago', Banco = '$Banco', Numero = '$Numero'
			WHERE Codigo = '$Codigo'";
	//echo $sql.'<br>';
	$mysqli->query($sql);		
	header("Location: ".$Redirect);
}


if(false and isset($_GET['Edita'])){
	$sql = "SELECT * FROM Contabilidad WHERE Codigo = '$_GET[Codigo]'";
	echo $sql.'<br>';
	$RS = $mysqli->query($sql);
	$row_Edita = $RS->fetch_assoc();
}*/
/*

// Ejecuta $sql
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

*/

//include_once("../../../inc/analyticstracking.php") 
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla;  ?></title>
<script type="text/javascript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function KW_simpleUpdateItems(d,o,n,fn) { //v3.0 By Paul Davis www.kaosweaver.com
  var i,s,l=MM_findObj(d),b,z=o.options[o.selectedIndex].value;
  l.length=0;l.options[0]=new Option('tbd','tbd');b=(z!='nill')?eval('KW_'+z+n):0;
  for(i=0;i<b.length;i++){s=b[i].split("|");l.options[i]=new Option(s[1],s[0]);}
  l.selectedIndex=0;if (!fn) return;eval(fn)
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>

<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />



</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
          <td  nowrap="nowrap"><?php 
		$addVars = '';
		Ir_a_AnoMes($Mes, $Ano, $addVars);
 ?>&nbsp;</td>
          <td nowrap="nowrap"><a href="Gasto_Resumen.php">Resumen</a></td>
          <td nowrap="nowrap">&nbsp;</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td nowrap="nowrap">&nbsp;</td>
          <td  nowrap="nowrap">&nbsp;</td>
          <td align="right"  nowrap="nowrap"><a href="Gastos_Cuenta_Contable.php">Cuentas Contables</a></td>
          </tr>
</table>

<form id="form1" name="form1" method="post" action="Gastos.php">
    <table width="100%"  border="0">
    
    <tr>
<td><img src="../../../../img/b.gif" width="15" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="120" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="120" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="120" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="50" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="50" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="20" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="20" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="20" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="20" height="1" alt=""/></td>
</tr>
    
        
        <tr>
          <td nowrap="nowrap" class="subtitle">&nbsp;</td>
          <td nowrap="nowrap" class="subtitle"><a href="<?php echo $php_self ?>&Orden=Fecha" class="subtitle">Fecha</a></td>
          <td nowrap="nowrap" class="subtitle"><a href="<?php echo $php_self ?>&Orden=Cuenta1" class="subtitle">Cuenta</a></td>
          <td nowrap="nowrap" class="subtitle"><a href="<?php echo $php_self ?>&Orden=Cuenta1,Cuenta11" class="subtitle">Sub Cue</a></td>
          <td nowrap="nowrap" class="subtitle"><a href="<?php echo $php_self ?>&Orden=Cuenta1,Cuenta11,Cuenta111" class="subtitle">Sub Cue 2</a></td>
          <td nowrap="nowrap" class="subtitle">A favor de</td>
          <td nowrap="nowrap" class="subtitle">Rif</td>
          <td nowrap="nowrap" class="subtitle"><a href="<?php echo $php_self ?>&Orden=Descripcion" class="subtitle">Descripci&oacute;n</a></td>
          <td nowrap="nowrap" class="subtitle">Base Ex</td>
          <td nowrap="nowrap" class="subtitle">Base Imp</td>
          <td nowrap="nowrap" class="subtitle">% IVA</td>
          <td nowrap="nowrap" class="subtitle">IVA</td>
          <td nowrap="nowrap" class="subtitle">Ret %</td>
          <td nowrap="nowrap" class="subtitle"> Total</td>
          <td colspan="4" nowrap="nowrap" class="subtitle">&nbsp;</td>
        </tr>
        <tr>
          <td rowspan="2" align="center" valign="middle" class="FondoCampo"><?php 

if($row_Edita['Codigo'] > 0){
	echo $row_Edita['Codigo'];
	?><input name="Codigo" type="hidden" value="<?php echo $row_Edita['Codigo']?>" />
            <input name="UPDATE" type="hidden" value="UPDATE" /><?php 
	}  
else{	
	$sql = "SELECT max(Codigo) as CodigoMax FROM Contabilidad ";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	echo $row['CodigoMax']+1;
	?><input name="INSERT" type="hidden" value="INSERT" /><?php   
}
		  
		  ?>)</td>
          <td rowspan="2" align="center" valign="middle" class="FondoCampo"><label for="BeneficiarioNombre"></label>
            <input name="Fecha" type="date" id="textfield" value="<?php 
			if(isset($_POST['Fecha'])) 
				echo $_POST['Fecha']; 
			elseif($row_Edita['Fecha'] > '2000-01-01')
				echo $row_Edita['Fecha'];
			else	
				echo date('Y-m-d'); ?>" width="20" /></td>
          <td colspan="3" valign="top" class="FondoCampo">
  <select name="Cuenta123" id="Cuenta123" >
  <option value="" selected="selected">Seleccione...</option>
    <?php 
$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
// Cuenta 1
while ($row = $RS->fetch_assoc()) {
	extract($row);
	$sql_Cuenta1 = "SELECT * FROM Contabilidad 
					WHERE Cuenta1 = '$Cuenta1'
					GROUP BY Cuenta11 
					ORDER BY Cuenta11";
	$RS_Cuenta1 = $mysqli->query($sql_Cuenta1);	
	// Cuenta 2
	while($row_Cuenta1 = $RS_Cuenta1->fetch_assoc()){
		$sql_Cuenta11 = "SELECT * FROM Contabilidad 
						WHERE Cuenta11 = '".$row_Cuenta1['Cuenta11']."'
						GROUP BY Cuenta111 
						ORDER BY Cuenta111";
		$RS_Cuenta11 = $mysqli->query($sql_Cuenta11);
		// Cuenta 3
		while($row_Cuenta11 = $RS_Cuenta11->fetch_assoc()){
			if($Cuenta1Anterior <> $Cuenta1){
				echo "<option value=\"\"></option>";
				echo "<option value=\"$Cuenta1::\">-- $Cuenta1</option>";}
			echo '<option value="'.
					$Cuenta1.'::'.$row_Cuenta1['Cuenta11'].'::'.$row_Cuenta11['Cuenta111'].'::'.'">'.
					'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$row_Cuenta1['Cuenta11'].' -->> '.$row_Cuenta11['Cuenta111'].
					"</option>\r\n"; 
			$Cuenta1Anterior = $Cuenta1;		
		}
	}
 } 
 ?>
</select></td><?php 

$BeneficiarioRif = $row_Edita['BeneficiarioRif'];
$BeneficiarioNombre = $row_Edita['BeneficiarioNombre'];

if(isset($_GET['Rif']))
	$BeneficiarioRif = $_GET['Rif'];

if(isset($_GET['Nombre']))
	$BeneficiarioNombre = $_GET['Nombre'];

$JavaCalc = ' onkeyup="Monto.value=Number(Base_Exenta.value)+
					   Number(Base_Imponible.value)*Number(Tasa_IVA.value)/100+
					   Number(Base_Imponible.value) ;
					   Monto_IVA.value=Number(Base_Imponible.value)*Number(Tasa_IVA.value)/100;
					   " ';
						


?>
          <td rowspan="2" valign="middle" class="FondoCampo"><input name="BeneficiarioNombre" type="text" id="textfield4" size="20" /></td>
          <td rowspan="2" valign="middle" class="FondoCampo"><input name="BeneficiarioRif" type="text" id="textfield5" size="15" /></td>
          <td rowspan="2" valign="middle" class="FondoCampo">
            <input name="Descripcion" type="text" id="textfield2" size="25" />          </td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Base_Exenta" type="text" id="Base_Exenta" size="10" align="right" <?= $JavaCalc ?> /></td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Base_Imponible" type="text" id="Base_Imponible" size="10" align="right" <?= $JavaCalc ?> /></td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Tasa_IVA" type="text" id="Tasa_IVA" size="5" align="right" <?= $JavaCalc ?> /></td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Monto_IVA" type="text" id="Monto_IVA" size="8" align="right" <?= $JavaCalc ?> /></td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Porcentaje_Retencion" type="text" id="Porcentaje_Retencion" size="5" align="right" /></td>
          <td rowspan="2" align="right" valign="middle" class="FondoCampo"><input name="Monto" type="text" id="Monto" size="12" align="right" /></td>
  
  <? if(false) { ?>        
  <? } ?> 
    
          <td colspan="4" rowspan="2" align="right" valign="middle" class="FondoCampo">
            <input type="submit" name="button" id="button" onclick="this.disabled=true;this.value='...';this.form.submit();"  value="Guardar" />          </td>
        </tr>
        <tr>
          <td valign="top" class="FondoCampo">
            <select name="Cuenta1" id="Cuenta1" onchange="KW_simpleUpdateItems('Cuenta11',this,'_Data');MM_showHideLayers('Cuenta11','','show');">
              <option value="<?php echo $row_Edita['Cuenta1'] ?>" selected="selected"><?php echo $row_Edita['Cuenta1'] ?></option>
              <?php 


$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
	echo '<option value="'.str_replace(' ','_',$Cuenta1).'">'.$Cuenta1.'</option>
';
	
 } 
 ?></select><br />
            <script language="JavaScript"><?php 
 // <select="kwTest" onChange="KW simpleUpdateItems('targetSelect',this,'kwData')">




$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1"; // BUSCA Cuenta1
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	//extract($row);
	$Descripcion = str_replace(' ','_',$row['Cuenta1']);
?>


var KW_<?php echo $Descripcion ?>_Data = new Array();
    KW_<?php echo $Descripcion ?>_Data[KW_<?php echo $Descripcion ?>_Data.length]="|Seleccione..."
<?php 
	 
	$sql_ = "SELECT * FROM Contabilidad WHERE Cuenta1 = '".$row['Cuenta1']."' GROUP BY Cuenta11 ORDER BY Cuenta11"; // Busca SubCuentas de la Cuenta 1
	mysql_select_db($database_bd, $bd);
	$RS_ = mysql_query($sql_, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS_);
	do{
		echo '    KW_'. $Descripcion .'_Data[KW_'. $Descripcion .'_Data.length]="'.$row_['Cuenta11'].'|'.$row_['Cuenta11'].'"'."\r\n";
	}while ($row_ = mysql_fetch_assoc($RS_));		  











$sql11 = "SELECT * FROM Contabilidad WHERE Cuenta1 = '".$row['Cuenta1']."' GROUP BY Cuenta11 ORDER BY Cuenta11"; // BUSCA Cuenta1
$RS11 = $mysqli->query($sql11);
while ($row11 = $RS11->fetch_assoc()) {
	//extract($row);
	$Descripcion = str_replace(' ','_',$row11['Cuenta11']);
	$sql_11 = "SELECT * FROM Contabilidad WHERE Cuenta11 = '".$row11['Cuenta11']."' and Cuenta111 > '' GROUP BY Cuenta111 ORDER BY Cuenta111"; // Busca SubCuentas de la Cuenta 1
	mysql_select_db($database_bd, $bd);
	$RS_11 = mysql_query($sql_11, $bd) or die(mysql_error());
	if($row_11 = mysql_fetch_assoc($RS_11)){
	
?>


     var KW_<?php echo $Descripcion ?>_Data = new Array();
         KW_<?php echo $Descripcion ?>_Data[KW_<?php echo $Descripcion ?>_Data.length]="|Seleccione..."
<?php 
	 
	do{
		echo '         KW_'. $Descripcion .'_Data[KW_'. $Descripcion .'_Data.length]="'.$row_11['Cuenta111'].'|'.$row_11['Cuenta111'].'"'."\r\n";
	}while ($row_11 = mysql_fetch_assoc($RS_11));		  

	}










}

}










?></script><input name="Cuenta1add" type="text" id="Cuenta1add" size="12" /></td>


          <td valign="top" class="FondoCampo"><select name="Cuenta11" id="Cuenta11" onchange="KW_simpleUpdateItems('Cuenta111',this,'_Data');MM_showHideLayers('Cuenta111','','show')">
              <option value="<?php echo $row_Edita['Cuenta11'] ?>" selected="selected"><?php echo $row_Edita['Cuenta11'] ?></option>
              </select>
            <br />
            <input name="Cuenta11add" type="text" id="Cuenta11add" size="12" /></td>
            
            
          <td valign="top" class="FondoCampo"><select name="Cuenta111" id="Cuenta111"  >
            <option value="<?php echo $row_Edita['Cuenta111'] ?>" selected="selected"><?php echo $row_Edita['Cuenta111'] ?></option>
            </select>
            <br />
            <input name="Cuenta111add" type="text" id="Cuenta111add" value="" size="12" /></td>
          </tr>
<?php if(!isset($_GET['Edita'])){ ?>
        <tr>
          <td colspan="18" align="center" class="NombreCampo">&nbsp;</td>
        </tr>
        
        
        </table>
   
<table>

      
<tr>
<td><img src="../../../../img/b.gif" width="15" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="150" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="350" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="80" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="50" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="50" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
<td><img src="../../../../img/b.gif" width="100" height="1" alt=""/></td>
</tr>
    

<tr>
      
<td width="20" align="center" nowrap="nowrap" class="FondoCampo">0000</td>
          
          
<td width="90" align="center" nowrap="nowrap" class="FondoCampo">&nbsp;</td>
          
          
<td nowrap="nowrap" class="FondoCampo">&nbsp;</td>


      <td nowrap="nowrap">
            <input name="BeneficiarioRif" type="text" id="textfield5" value="<?php echo $BeneficiarioRif ?>" size="10" />
         </td>
        <td nowrap="nowrap"><input name="BeneficiarioNombre" type="text" id="textfield4" value="<?php echo $BeneficiarioNombre ?>" size="20" /></td>
      <td nowrap="nowrap"><input name="Descripcion" type="text" id="textfield2" value="<?php echo $Descripcion ?>" size="25" title="<?php echo $Descripcion ?>" /></td>
          
          
          
          
        <td align="right"><?= Fnum($Base_Exenta) ?></td>
        <td align="right"><?= Fnum($Base_Imponible) ?></td>
        <td align="right"><?= Fnum($Tasa_IVA) ?></td>
        <td align="right"><?= Fnum($Monto_IVA) ?></td>
        <td align="right"><?= Fnum($Porcentaje_Retencion) ?></td>
      <td align="right" nowrap="nowrap">
      		<? 
			if($Base_Exenta < 1 and $Base_Imponible<1){
			 ?>
      
      <input name="Monto" type="text" id="textfield3" value="<?php echo $Monto ?>" size="12" align="right" />
      
      <?php 
			}
			else{ echo Fnum($Monto);}
	  ?></td>
          <td align="center" nowrap="nowrap">&nbsp;<input type="submit" name="button" id="button" onclick="this.disabled=true;this.value='...';this.form.submit();"  value="G" />
          </td>
        </tr>
  
<?php //ORDER BY Cuenta1, Cuenta11, Cuenta111


if(isset($_GET['Orden'])){
	$Orden = $_GET['Orden'].',';
}


if(isset($_GET['Cuenta1'])){
	$sql = '';
	if(isset($_GET['Cuenta11']))
		$sql = " AND Cuenta11 = '".$_GET['Cuenta11']."' ";
	if(isset($_GET['Cuenta111']))
		$sql .= " AND Cuenta111 = '".$_GET['Cuenta111']."' ";


	$FechaObj = "AND FECHA >= '$Ano1-09-01' ";
	if(isset($_GET['Mes'])){
		$AnoMesObj = $_GET['Mes'];
		$FechaObj = "AND FECHA >= '$AnoMesObj-01' AND FECHA <= '$AnoMesObj-31' ";
		}
	$sql = "SELECT * FROM Contabilidad WHERE
		 	Cuenta1 = '".$_GET['Cuenta1']."' ".$sql." 
			$FechaObj
			ORDER BY Fecha, Cuenta1, Cuenta11, Cuenta111"; }
else{
	
	$sql = "SELECT * FROM Contabilidad WHERE
			Fecha >= '$Fecha_Inicio_Mes' AND
			Fecha <= '$Fecha_Fin_Mes'
			ORDER BY $Orden Codigo DESC";}
//echo $sql;		
$RS = $mysqli->query($sql);

while ($row = $RS->fetch_assoc()) {
	extract($row);

?>

        
<tr <?php  $sw = ListaFondo($sw,$Verde); ?>>
<td colspan="14" align="center"><iframe src="iFr/Gasto.php?Codigo=<?php echo $Codigo ?>" width="100%" height="45" frameborder="0" seamless="seamless" scrolling="no" ></iframe></td>
<td align="center"><a href="../Procesa.php?EliminaGen=1&amp;Tabla=Contabilidad&amp;Clave=Codigo&amp;Valor=<?php echo $Codigo ?>" target="_blank"><img src="../../../img/b_drop.png" width="16" height="16" /></a></td>
<td align="center">&nbsp;<a href="PDF/Retencion.php?Codigo=<?php echo $Codigo ?>">Ret</a></td>
<td align="center"><a href="PDF/Egreso_Comprobante.php?Codigo=<?php echo $Codigo ?>" target="_blank"><img src="../../../i/printer.png" width="20" height="20" /></a></td>
<td align="center"><?php echo substr(strtolower($MM_Username_db),0,3) ?>&nbsp;</td>
</tr>
<?php } ?>
        
        
        
        <!--tr <?php  $sw = ListaFondo($sw,$Verde); ?>>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" align="right">&nbsp;<?php echo Fnum($TotalMonto); ?></td>
          <td colspan="4" align="right">&nbsp;</td>
        </tr -->
<?php } ?>
    
</table>   
   
</form>
</body>
</html>