<?php 
$MM_authorizedUsers = "91,99,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/proyecto/Models/Gasto.php');


$TituloPantalla = "Gastos";
$php_self .= '?'.$_SERVER['QUERY_STRING'];
$Redirect = $_SERVER['PHP_SELF']."?Codigo=".$_GET['Codigo'];

// Conectar
/*
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$Redirect = $_SERVER['PHP_SELF']."?Mes=$Mes&Ano=$Ano";
if(isset($_GET['Cuenta1']))
	$Redirect = $_SERVER['PHP_SELF']."?Cuenta1=".$_GET['Cuenta1'];
if(isset($_GET['Cuenta11']))
	$Redirect .= "&Cuenta11=".$_GET['Cuenta11'];
if(isset($_GET['Cuenta111']))
	$Redirect .= "&Cuenta111=".$_GET['Cuenta111'];

if(isset($_GET['Codigo']))

if(isset($_POST['UPDATE']) or isset($_POST['INSERT'])){
	//echo $Cuenta123.'<br>';

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


}*/


if(isset($_POST['UPDATE'])){
	extract($_POST);
	
	if($Cuenta123 > ""){
		$Cuenta123 = explode("::",$Cuenta123);
		if($Cuenta123[0] > ' ')
			$Cuenta1   = $Cuenta123[0];
		if($Cuenta123[1] > ' ')
			$Cuenta11  = $Cuenta123[1];
		if($Cuenta123[2] > ' ')
			$Cuenta111 = $Cuenta123[2];	}
	
	$Monto = coma_punto($Monto);
	
	$sql = "UPDATE Contabilidad SET 
			Fecha = '$Fecha', 
			Cuenta1 = '$Cuenta1', 
			Cuenta11 = '$Cuenta11', 
			Cuenta111 = '$Cuenta111', 
			Descripcion = '$Descripcion', 
			Monto = '$Monto',
			BeneficiarioNombre = '$BeneficiarioNombre', 
			BeneficiarioRif = '$BeneficiarioRif', 
			MM_Username_db = '$MM_Username',
			FormaPago = '$FormaPago', 
			CodigoCheque = '$CodigoCheque', 
			CodigoMovBanco = '$CodigoMovBanco', 
			Banco = '$Banco', 
			Numero = '$Numero'
			WHERE Codigo = '$Codigo'";
	//echo $sql.'<br>'.$Redirect.'<br>';
	$mysqli->query($sql);		
	header("Location: ".$Redirect."&Saved=1");
}


if(isset($_GET['Codigo'])){
	$sql_GASTO = "SELECT * FROM Contabilidad 
					WHERE Codigo = '$_GET[Codigo]'";
	$RS = $mysqli->query($sql_GASTO);
	$row_Edita = $RS->fetch_assoc();
	extract($row_Edita);
}



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
</script>

<link href="../../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="
if(FormaPago.selectedIndex==1 || FormaPago.selectedIndex==0 ) {
    BancoNumero.style.display='none';
    SelectCodigoCheque.style.display='none';
    SelectCodigoTransferencia.style.display='none';}
if(FormaPago.selectedIndex==2 ) {
    BancoNumero.style.display='Block';
    SelectCodigoCheque.style.display='Block';
    SelectCodigoTransferencia.style.display='none';}
if(FormaPago.selectedIndex==3 ) {
    BancoNumero.style.display='none';
    SelectCodigoCheque.style.display='none';
    SelectCodigoTransferencia.style.display='Block';}
">

<? 

//$Gasto = new Gasto($id_Gasto);
//$Gasto->Monto_Total();

	
	
if(true) { ?>

<form id="form1" name="form1" method="post" action=""><table width="100%" border="0">
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
    

<tr <?php if($_GET['Saved']=='1') echo ' bgcolor="#FFFFCC"'; ?>>
      
<td width="20" align="center" nowrap="nowrap" class="FondoCampo"><?php echo $Codigo ?><input name="UPDATE" type="hidden" value="UPDATE" /><input name="Codigo" type="hidden" value="<?php echo $Codigo?>" /></td>
          
          
<td width="90" align="center" nowrap="nowrap" class="FondoCampo"><input name="Fecha" type="date" id="textfield" value="<?php echo $row_Edita['Fecha'];  ?>"  /></td>
          
          
<td nowrap="nowrap" class="FondoCampo"><select name="Cuenta123" id="Cuenta123" >
<option value="" selected="selected">Seleccione...</option>
<?php 

$sql = "SELECT * FROM Contabilidad GROUP BY Cuenta1 ORDER BY Cuenta1";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	//extract($row);
	
	$sql_Cuenta1 = "SELECT * FROM Contabilidad 
					WHERE Cuenta1 = '".$row['Cuenta1']."'
					GROUP BY Cuenta11 
					ORDER BY Cuenta11";
	$RS_Cuenta1 = $mysqli->query($sql_Cuenta1);
	
	while($row_Cuenta1 = $RS_Cuenta1->fetch_assoc()){
	
		$sql_Cuenta11 = "SELECT * FROM Contabilidad 
						WHERE Cuenta11 = '".$row_Cuenta1['Cuenta11']."'
						GROUP BY Cuenta111 
						ORDER BY Cuenta111";
		$RS_Cuenta11 = $mysqli->query($sql_Cuenta11);
		while($row_Cuenta11 = $RS_Cuenta11->fetch_assoc()){
			if($Cuenta1Anterior <> $row['Cuenta1']){
				echo "<option value=\"\"></option>";
				echo "<option value=\"$Cuenta1::\">-- ".$row['Cuenta1']."</option>";}
			echo '<option value="'.
					$row['Cuenta1'].'::'.$row_Cuenta1['Cuenta11'].'::'.$row_Cuenta11['Cuenta111'].'::'.'"';
			if($row['Cuenta1'] == $row_Edita['Cuenta1'] 
				and $row_Cuenta1['Cuenta11'] == $row_Edita['Cuenta11'] 
				and $row_Cuenta11['Cuenta111'] == $row_Edita['Cuenta111'])	
				echo ' selected="selected" ';
			echo '>';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> '.$row_Cuenta1['Cuenta11'].' -->> '.$row_Cuenta11['Cuenta111'].
					"</option>\r\n"; 
			$Cuenta1Anterior = $row['Cuenta1'];		
		}
	}
 } 
 ?>
            </select></td>


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
</table></form><? } ?></body>
</html>