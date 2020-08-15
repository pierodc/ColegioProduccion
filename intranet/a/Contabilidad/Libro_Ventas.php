<?php 
$MM_authorizedUsers = "91,99,admin,secreAcad,Contable";
require_once('../../../inc/Login_check.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
 
mysql_select_db($database_bd, $bd);

$TituloPantalla = "Libro de Ventas";

//echo $TituloPantalla;


// Activa Inspeccion
$Insp = false ;

if(isset($_POST['Control_Numero'])){
	
	$Factura_Numero_aux = $_POST['Factura_Numero'];
	$sql = "UPDATE Factura_Control 
			SET Factura_Numero = '".$_POST['Factura_Numero']."'
			WHERE Control_Numero = '".$_POST['Control_Numero']."'";
	mysql_query($sql, $bd);
	//echo $sql."<br>";
	
	$sql = "SELECT * FROM Factura_Control
			WHERE Control_Numero >= '".$_POST['Control_Numero']."'
			AND Factura_Numero > 0";
	$RS = $mysqli->query($sql);
	//echo $sql."<br>";
	
	
	if($_POST['Factura_Numero'] > 0)
		while ($row = $RS->fetch_assoc()) {
			extract($row);
			$sql = "UPDATE Factura_Control 
					SET Factura_Numero = '".$Factura_Numero_aux."'
					WHERE Control_Numero = '".$Control_Numero."'";
			$mysqli->query($sql);
			//echo $sql."<br>";
			$Factura_Numero_aux++;
		}
}



if(isset($_GET['Nula'])){
		$sql = "UPDATE Factura_Control 
				SET SW_Nula = '".$_GET['Nula']."'
				WHERE Control_Numero = '".$_GET['Control']."'";
		$mysqli->query($sql);
		//echo $sql."<br>";
			
	}


if(isset($_POST['Control'])){
	$Control = $_POST['Control'];
	header("Location: ".$auxPag."?Control=".$Control);}
elseif(isset($_POST['Control_Numero'])){
	$Control = $_POST['Control_Numero']+1;
	header("Location: ".$auxPag."?Control=".$Control);}
elseif(isset($_GET['Control'])){
	$Control_Numero_0 = $_GET['Control'];}
else{

	$sql = "SELECT * FROM Factura_Control 
			ORDER BY Factura_Numero DESC ";
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS_);
	$Control_Max = $row_['Control_Numero']-1;
	header("Location: ".$auxPag."?Control=".$Control_Max);
}





$Control_Numero_0 = $_GET['Control']-1;
$Control_Numero_1 = $Control_Numero_0 + 20;

$sql = "SELECT * FROM  Factura_Control
		WHERE Control_Numero >= '$Control_Numero_0'
		AND Control_Numero <= '$Control_Numero_1'
		ORDER BY Control_Numero";
//echo $sql.'<br>';		
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
//$totalRows_ = mysql_num_rows($RS_);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Libro de Ventas</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body <?php 
echo 'OnLoad="document.form'. $_GET['Control'] .'.Factura_Numero.focus();"'; ?>>
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="2"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="left"><form action="" method="POST">Control: 
      <input type="text" name="Control" size="8"> 
      <input type="submit" name="button" id="button" onclick="this.disabled=true;this.value='...';this.form.submit();"  value="ir a..." />
/ <a href="<? echo $php_self ."?Control="; echo $Control_Numero_0 - 15; ?>">15- << </a><? echo $Control_Numero_0; ?><a href="<? echo $php_self ."?Control="; echo $Control_Numero_0 + 15; ?>"> >> 15+ </a></form>
      </td>
    <td align="right"><span style="font-weight: bold"><a href="Libro_Ventas_out.php">excel</a>&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
 
 
<table width="100%" border="0" align="center" bordercolor="#333333">
  <tr valign="baseline">
      <td colspan="12" align="left" nowrap="nowrap" class="subtitle">Facturas</td>
  </tr>
  
<tr valign="baseline" <? $sw=ListaFondo($sw,$Verde);  ?> >
      <td align="center" nowrap="nowrap">No</td>
      <td align="center" nowrap="nowrap">Control</td>
      <td align="center" nowrap="nowrap">Factura</td>
      <td align="center" nowrap="nowrap">&nbsp;</td>
      <td align="center" nowrap="nowrap">Fecha</td>
      <td align="center" nowrap="nowrap">Rif</td>
      <td align="center" nowrap="nowrap">Nombre</td>
      <td align="center" nowrap="nowrap">Alumno</td>
      <td align="center" nowrap="nowrap">Base_Imp</td>
      <td align="center" nowrap="nowrap">Base_Exe</td>
      <td align="center" nowrap="nowrap">IVA</td>
      <td align="center" nowrap="nowrap">Total</td>
</tr>  
  
<?php 
			
while($row_ = mysql_fetch_assoc($RS_)){ 
extract($row_);

$sql_Recibo = "SELECT * FROM Recibo
			   WHERE NumeroFactura = '$Factura_Numero'";
//echo $sql_Recibo ;	
$RS_Recibo_ = mysql_query($sql_Recibo, $bd) or die(mysql_error());
$row_Recibo = mysql_fetch_assoc($RS_Recibo_);
$totalRows_Recibo = mysql_num_rows($RS_Recibo_);

if($Control_Numero == $_GET['Control'])	
	$Verde = true;	else $Verde = false;	
?>
<tr valign="baseline" <? $sw=ListaFondo($sw,$Verde);  ?> >
      <td align="right" nowrap="nowrap"><? echo ++$Ln; ?></td>
      <td align="center" nowrap="nowrap"><span class="ListadoNotasDef09"><? echo $Control_Numero; ?></span></td>
      <td align="center" nowrap="nowrap"><form action="Libro_Ventas.php?Control=<? echo $_GET['Control']; ?>" name="form<? echo $Control_Numero; ?>" method="POST">
      <input type="hidden" name="Control_Numero" value="<? echo $Control_Numero; ?>">
      <input type="text" name="Factura_Numero" size="8" value="<? echo $Factura_Numero; ?>">
      <input type="submit" name="button" id="button" value="G"  onclick="this.disabled=true;this.form.submit();" />
      </form></td>
      <td align="center" nowrap="nowrap">
      <?php if($SW_Nula) { ?>
      <a href="Libro_Ventas.php?Nula=0&Control=<? echo $Control_Numero; ?>">NULA</a>
      <?php }else{ ?>
      <a href="Libro_Ventas.php?Nula=1&Control=<? echo $Control_Numero; ?>">Anular</a>
      <?php } ?>
      </td>
      <td align="center" nowrap="nowrap"><? echo DDMMAAAA($row_Recibo['FechaImpFactura']); ?></td>
      <td align="right" nowrap="nowrap"><? echo $row_Recibo['Fac_Rif']; ?></td>
      <td align="left" nowrap="nowrap"><? echo $row_Recibo['Fac_Nombre']; ?></td>
      <td align="center" nowrap="nowrap"><? echo $row_Recibo['CodigoPropietario']; ?></td>
      <td align="right" nowrap="nowrap"><? echo Fnum($row_Recibo['Base_Imp']); ?></td>
      <td align="right" nowrap="nowrap"><? echo Fnum($row_Recibo['Base_Exe']); ?></td>
      <td align="right" nowrap="nowrap"><? echo Fnum($row_Recibo['Monto_IVA']); ?></td>
      <td align="right" nowrap="nowrap"><? echo Fnum($row_Recibo['Total']); ?></td>
</tr>

    <?php  } ?>
            
           
</table>
    </td>
  </tr>
</table>
</body>
</html>