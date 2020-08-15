<?php 
$MM_authorizedUsers = "99,91,95,90";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
// Activa Inspeccion
$Insp = false ;


//Elimina Mov 
if ((isset($_GET['Codigo'])) && ($_GET['Codigo'] != "") && (isset($_GET['EliminarMov']))) {
  $sql = sprintf("DELETE FROM ContableMov WHERE Codigo=%s",
                       GetSQLValueString($_GET['Codigo'], "int"));

 $mysqli->query($sql);

header("Location: ".$_SERVER['PHP_SELF']);
}


$editFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


/*
<option value="Egreso">Egreso</option>
<option value="Entrega">Entrega de Efectivo</option>
<option value="Ingreso">Ingreso</option>

*/
$MontoDebe = $MontoHaber = 0;

if($_POST['Descripcion'] == "Egreso" or $_POST['Descripcion'] == "Entrega")
	$MontoDebe  = coma_punto($_POST['Monto']);

if($_POST['Descripcion'] == "Ingreso" )
	$MontoHaber  = coma_punto($_POST['Monto']);

  $sql = sprintf("INSERT INTO ContableMov (Observaciones, SWValidado, SWCancelado, CodigoCuenta, CodigoPropietario, Tipo, Fecha, Referencia, ReferenciaOriginal, ReferenciaBanco, Descripcion, MontoDebe, MontoHaber, RegistradoPor, FechaIngreso, MontoDocOriginal) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Observaciones'].' / '.$_POST['Observaciones2'], "text"),
                       GetSQLValueString($SWValidado, "int"),
                       GetSQLValueString('0', "int"),
                       GetSQLValueString($_POST['CodigoCuenta'], "int"),
                       GetSQLValueString($_POST['Proveedor'], "int"),
                       GetSQLValueString($_POST['Tipo'], "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['Referencia'], "text"),
                       GetSQLValueString($_POST['ReferenciaBanco'], "text"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($MontoDebe, "double"),
                       GetSQLValueString($MontoHaber, "double"),
					   GetSQLValueString($_POST['RegistradoPor'], "text"),
					   GetSQLValueString($_POST['FechaIngreso'], "text"),
					   GetSQLValueString($_POST['MontoDocOriginal'], "double"));

$mysqli->query($sql);
$mensaje = "";

}
// }// fin REFERENCIA unica




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Egreso de Caja</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
function ValidaForma() {
form1.BotonRecibo.disabled=true; 
form1.submit(); 
return false;
}
</script>

<style type="text/css">
a:link {
	color: #0000FF;
	text-decoration: none;
}
</style>

<style type="text/css">
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
</style>
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="800" border="0" align="center">
  <tr>
    <td><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td colspan="2" align="right">    <div align="right" class="TituloPagina"> Egreso de Caja</div></td>
  </tr>
  <tr>
    <td align="left"><a href="../index.php"><img src="../../../img/home.png" alt="" width="25" height="27" border="0" /></a> - <a href="Diario_de_Caja.php">Diario de Caja</a></td>
    <td align="right"><span style="font-weight: bold">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
              <td colspan="11" align="left" nowrap="nowrap" class="subtitle">Egresos</td>
          </tr>
            
            <?php 
$Fecha_RS_Recibos = date('Y-m-d');			
$query_RS_Recibos = "SELECT * FROM ContableMov 
							WHERE Descripcion <> 'Abono a cuenta'  
							AND Fecha = '$Fecha_RS_Recibos'  
							AND Tipo = '4'  
							ORDER BY FechaIngreso ";
$RS_Recibos = $mysqli->query($query_RS_Recibos);
$row_RS_Recibos = $RS_Recibos->fetch_assoc();

							
$totalRows_RS_Recibos = $RS_Recibos->num_rows;
if(  $totalRows_RS_Recibos>0){
?>
    <tr >
              <td class="TituloLeftWindow">Fecha</td>
              <td class="TituloLeftWindow">Proveedor</td>
              <td class="TituloLeftWindow">Descripcion</td>
            <td class="TituloLeftWindow">Beneficiario</td>
            <td class="TituloLeftWindow">Concepto</td>
              <td class="TituloLeftWindow">Egreso</td>
              <td class="TituloLeftWindow">Ingreso</td>
              <td class="TituloLeftWindow">Cheque</td>
              <td class="TituloLeftWindow">&nbsp;</td>
              <td colspan="2" class="TituloLeftWindow">&nbsp;</td>
          </tr>
    <?php 
  do { 
  extract($row_RS_Recibos); ?>
  <tr <?php $sw = ListaFondo($sw,$Verde);?>>  
    <td align="center" nowrap="nowrap" >&nbsp;<?php echo DDMMAAAA($Fecha); ?></td>
            <td nowrap="nowrap" >
             <?php //ProveedorNombre($CodigoPropietario);  ?></td>
              <td nowrap="nowrap" ><?= $Descripcion; ?>&nbsp;</td>
              <td nowrap="nowrap" ><?php 
			  $Observaciones = explode(' / ',$Observaciones);
			  echo $Observaciones[0]; ?></td>
              <td nowrap="nowrap" ><?php echo $Observaciones[1];?>&nbsp;</td>
            <td align="right" nowrap="nowrap" >&nbsp;<?php 
			
			echo Fnum($MontoDebe); 
			$Total_MontoDebe += $MontoDebe;
				  
				  
				  ?></td>
            <td align="right" nowrap="nowrap" ><?php 
			
			echo Fnum($MontoHaber); 
			$Total_MontoHaber += $MontoHaber;
				  
				  
				  ?></td>
            <td align="right" nowrap="nowrap" >&nbsp;<?php echo $Tipo!=4?Fnum($MontoDebe):""; ?></td>
            <td nowrap="nowrap" >&nbsp;<?php if($CodigoCuenta==1){echo "Merc";}elseif($CodigoCuenta==2){echo "Prov";}elseif($CodigoCuenta==10){echo "Caja";}  ?>&nbsp;
            <?php echo $Referencia;//if( $Ref_anterior<>$Referencia and $Tipo<=3) { }elseif($Tipo<=3){ echo 'idem';} $Ref_anterior = $Referencia; ?><a href="../Egreso_Comprobante.php?Codigo=<?php echo $Codigo; ?>" target="_blank">comp</a></td>
            <td nowrap="nowrap" >&nbsp;<?php echo $RegistradoPor=="auto"?"":substr($RegistradoPor,0,5); ?></td>
            <td align="right" nowrap="nowrap" ><a href="Egreso_de_Caja.php<?php 
			  
			  echo '?Codigo='.$Codigo.'&EliminarMov=1';

			  
			  ?>"><img src="../../../img/b_drop.png" width="16" height="16" border="0" /></a></td>
          </tr>
    <?php  } while ($row_RS_Recibos = $RS_Recibos->fetch_assoc());  ?>
            <tr>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="2" align="right" nowrap="nowrap" bgcolor="#FFFFFF">&nbsp;</td>
              <td align="right" nowrap="nowrap" bgcolor="#FFFFFF"><strong>Total Bs. </strong></td>
              <td colspan="2" align="right" nowrap="nowrap" bgcolor="#FFFFFF"><strong><?php echo Fnum($Cant_Efec); ?></strong></td>
              <td nowrap="nowrap">&nbsp;</td>
              <td nowrap="nowrap">&nbsp;</td>
              <td colspan="2" nowrap="nowrap">&nbsp;</td>
            </tr>
            <tr>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td colspan="4" align="right" nowrap="nowrap">&nbsp;</td>
              <td colspan="2" align="right" nowrap="nowrap">&nbsp;</td>
              <td colspan="4" nowrap="nowrap">&nbsp;</td>
            </tr><?php } ?>
                <tr >
              <td nowrap="nowrap" class="TituloLeftWindow">&nbsp;</td>
              <td nowrap="nowrap" class="TituloLeftWindow">Proveedor</td>
              <td nowrap="nowrap" class="TituloLeftWindow">Descripcion</td>
              <td nowrap="nowrap" class="TituloLeftWindow">Beneficiario</td>
              <td nowrap="nowrap" class="TituloLeftWindow">Concepto</td>
              <td colspan="2" nowrap="nowrap" class="TituloLeftWindow">Monto</td>
              <td nowrap="nowrap" class="TituloLeftWindow">Forma</td>
              <td nowrap="nowrap" class="TituloLeftWindow">&nbsp;</td>
              <td colspan="2" nowrap="nowrap" class="TituloLeftWindow">&nbsp;</td>
            </tr>

            <tr>
              <td nowrap="nowrap" class="FondoCampo"><input name="Fecha" type="hidden" id="FechaNac" value="<?php echo date('Y-m-d') ?>" />
              <?php //FechaFutura('Fecha', date('Y-m-d')) ?></td>
              <td nowrap="nowrap" class="FondoCampo"><select name="Proveedor">
                <option value="0">Seleccione...</option>
                <?php 
				/*
$sql = 'SELECT * FROM Proveedor ORDER BY Nombre';
$RS_ = $mysqli->query($sql);
$row_RS_ = $RS_->fetch_assoc();

	do {
		extract($row_RS_);
		echo '<option value="'.$Codigo.'">'.$Nombre.'</option>';
	} while ($row_RS_ = $RS_->fetch_assoc());
			 */ ?>
              </select></td>
              <td nowrap="nowrap" class="FondoCampo"><select name="Descripcion" id="Descripcion">
                <option value="Egreso">Egreso</option>
                <!--option value="Entrega">Entrega de Efectivo</option-->
                <option value="Ingreso">Ingreso</option>
              </select></td>
              <td nowrap="nowrap" class="FondoCampo"><input name="Observaciones" type="text" id="Observaciones" size="50" /></td>
              <td nowrap="nowrap" class="FondoCampo"><input name="Observaciones2" type="text" id="Observaciones2" size="25" /></td>
              <td colspan="2" align="right" nowrap="nowrap" class="FondoCampo"><input type="text" name="Monto" value="" size="8"   /></td>
              <td colspan="4" nowrap="nowrap" class="FondoCampo"><select name="Tipo" id="Tipo">
                
                <option value="3">Cheque</option>
                <option value="4" selected="selected">Efec</option>
              </select>
                <select name="CodigoCuenta" id="CodigoCuenta">
                  <option value="10">Caja</option>
                  <option value="1">Mercantil</option>
                  <option value="2">Provincial</option>
                  <?php  if ($_SESSION['MM_UserGroup']=='99'){  ?>
                  <option value="3">Venezuela</option>
                  <option value="4">V. de Cred.</option>
                  <?php } ?>
              </select>
              <input type="text" name="Referencia" value="" size="8"  /></td>
            </tr>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td colspan="4" align="right" nowrap="nowrap">
                <input type="hidden" name="RegistradoPor" value="<?php echo $MM_Username; ?>" />
                <input type="hidden" name="MontoHaber" value="" />
                <input type="hidden" name="FechaIngreso" value="<?php echo date('Y-m-d h:i:s'); ?>" />
                <input type="hidden" name="MM_insert" value="form1" /></td>
              <td colspan="6"><input type="submit" value="Guardar" onclick="this.disabled=true;this.form.submit();" /></td>
            </tr>
            <tr valign="baseline">
              <td colspan="11" align="right" nowrap="nowrap">                    </td>
          </tr>
        </table></form>
    </td>
  </tr>
</table>
</body>
</html>
<?php
?>
