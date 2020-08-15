<?php 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 
$MM_authorizedUsers = "91,admin";
require_once('../../../inc/Login_check.php'); 

mysql_select_db($database_bd, $bd);

if(!isset($_GET['MesAno'])){
	header("Location: ".$auxPag."?Cuenta=".$_GET['Cuenta']."&MesAno=".date('Y-m'));
}

// Activa Inspeccion
$Insp = false ;

if($_GET['Cuenta']>0){
	$Cuenta = 'AND CodigoCuenta = '.$_GET['Cuenta'];}
//AND MontoDebe <> 0
$sql = "SELECT * 
		FROM  Contable_Imp_Todo 
		WHERE Fecha >=  '".$_GET['MesAno']."-01'
		AND Fecha <=  '".$_GET['MesAno']."-31'
		$Cuenta
		ORDER BY Fecha, Referencia";
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
$row_ = mysql_fetch_assoc($RS_);
$totalRows_ = mysql_num_rows($RS_);


if ((isset($_POST["MM_update"]))) {
	
  $updateSQL = sprintf("UPDATE Contable_Imp_Todo SET Descripcion=%s WHERE Codigo=%s",
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Codigo'], "int"));

  mysql_select_db($database_bd, $bd);
  $Result1 = mysql_query($updateSQL, $bd) or die(mysql_error());

	header("Location: ".$auxPag."?Cuenta=".$_GET['Cuenta']."&MesAno=".date('Y-m'));

}

$TituloPantalla = "Conciliacion Bancaria";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>

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
    <td align="left"><a href="../index.php"><img src="../../../img/home.png" alt="" width="25" height="27" border="0" /></a> - <a href="Banco_Concilia.php">Egresos Banco</a> | <a href="Banco_Cheques.php">Chequeras</a> | <a href="Banco_Cheques_Crear.php">Crear Chequera</a></td>
    <td align="right"><span style="font-weight: bold">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
              <td colspan="2" align="left" nowrap="nowrap" class="subtitle">Movimientos Banco</td>
          </tr>
          <tr valign="baseline">
            <td colspan="2" align="left">
<form name="form" id="form">
<select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
    <option value="<?php php_self(); ?>">Banco...</option>
    <option value="<?php php_self(); ?>?Cuenta=1" <?php if ($_GET['Cuenta']==1) echo ' selected="selected"'; ?>>Mercantil</option>
    <option value="<?php php_self(); ?>?Cuenta=2" <?php if ($_GET['Cuenta']==2) echo ' selected="selected"'; ?>>Provincial</option>
</select>
</form></td>
          </tr>
          
            <tr>
              <td colspan="2" nowrap="nowrap" class="subtitle">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td nowrap="nowrap" >&nbsp;<input name="CodigoCuenta" type="text" id="CodigoCuenta" disabled="disabled" value="cuenta" size="4" />                    
                    <input name="Fecha" type="text" id="Fecha" disabled="disabled" value="Fecha" size="12" />
                    <input name="Tipo" type="text" disabled="disabled" id="Tipo" value="Tipo" size="2" />
                    <input name="Referencia" type="text" disabled="disabled" id="Referencia" value="Referencia" size="15" />
                    <input name="Descripcion" type="text" id="Descripcion" value="Descripcion" size="30" />
                    <input name="ChNum" disabled="disabled" type="text" id="ChNum" value="ChNum" size="6" /></td>
                    <td width="30">
                    <input name="ChNum" disabled="disabled" type="text" id="ChNum" value="Debe" size="8" />
                    </td>
                    <td width="30">
                    <input name="ChNum" disabled="disabled" type="text" id="ChNum" value="Haber" size="8" />
                    </td>
                    <td width="30">
                    <input name="ChNum" disabled="disabled" type="text" id="ChNum" value="Saldo" size="12" />
                    </td>
                  <td width="10" align="right"><input type="submit" name="G" id="G" value="G" /></td>
                </tr>
              </table>
              </td>
            </tr>
          
            <?php 
			if( $_GET['Cuenta']>0 )
			do{ 
			extract($row_);
			$MontoDebe  = abs($MontoDebe);
			$MontoHaber = abs($MontoHaber);
			$Saldo += $MontoHaber - $MontoDebe;

			if($MontoDebe <> 0 ){ //
			?>
            <tr>
              <td colspan="2" nowrap="nowrap" class="FondoCampo">
              <form id="form1" name="form1" method="post" action="">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td nowrap="nowrap" >&nbsp;<input name="CodigoCuenta" type="text" id="CodigoCuenta" disabled="disabled" value="<?php 
				  // CUENTA
				  if($CodigoCuenta==1)
				  	echo 'Mer';
				  elseif($CodigoCuenta==2)
				  	echo 'Pro';
				  ?>" size="4" />                    
                    <input name="Fecha" type="text" id="Fecha" disabled="disabled" value="<?php echo DDMMAAAA($Fecha); ?>" size="12" />
                    <input name="Tipo" type="text" disabled="disabled" id="Tipo" value="<?php echo $Tipo; ?>" size="2" />
                    <input name="Referencia" type="text" disabled="disabled" id="Referencia" value="<?php echo $Referencia; ?>" size="15" />
                    <input name="Descripcion" type="text" id="Descripcion" value="<?php 
					$Alerta = '';
					if($ChNum > '000000' and (
					$Tipo == 'RT' or
					$Tipo == 'CH' or
					$Tipo == 'CA')){
						$sql = "SELECT * 
								FROM Cheque 
								WHERE NumCheque =  '".$ChNum."'
								AND Cuenta = '".$CodigoCuenta."' ";
						$RS_cheque = mysql_query($sql, $bd) or die(mysql_error());
						$row_cheque = mysql_fetch_assoc($RS_cheque);
						echo $row_cheque['FavorDe'].' / '.$row_cheque['ConceptoDe'];
						}
					elseif($Descripcion == "PAGO A PROVEEDORES EN LINEA"){
						
						
						$MontoDebe = $MontoDebe*1;
						$sql = "SELECT * 
								FROM Empleado 
								WHERE MontoUltimoPago =  '".$MontoDebe."'
								AND FormaDePago = 'T'
								AND SW_activo = '1' 
								ORDER BY NumCuenta , NumCuentaA ";
						$RS_Empleado = mysql_query($sql, $bd) or die(mysql_error());
						$row_Empleado = mysql_fetch_assoc($RS_Empleado);
						do{
							echo $row_Empleado['Apellidos'].' '.$row_Empleado['Nombres']." *";
						}while($row_Empleado = mysql_fetch_assoc($RS_Empleado));
						$Alerta = '*';
						
						}	
					else{
						echo $Descripcion;}
					
					
					 ?>" size="50" /><?php echo $Alerta; ?>
                  <input name="ChNum" disabled="disabled" type="text" id="ChNum" value="<?php echo $ChNum; ?>" size="6" />
                  <input name="Codigo" type="hidden" value="<?php echo $Codigo  ?>" size="8" />
                  <input name="MM_update" type="hidden" value="1" size="8" /></td>
                    <td width="70" align="right" nowrap="nowrap">
                    <input name="ChNum" disabled="disabled" type="hidden" id="ChNum" value="<?php echo $MontoDebe  ?>" size="8" />
                    <?php 
					echo Fnum($MontoDebe).'&nbsp;';  ?>
                  </td>
                    <td width="70" align="right" nowrap="nowrap">
                    <input name="ChNum" disabled="disabled" type="hidden" id="ChNum" value="<?php  echo $MontoHaber ?>" size="8" /><?php 
					echo Fnum($MontoHaber).'&nbsp;'; ?>
                    </td>
                    <td width="70" align="right" nowrap="nowrap">
                    <?php 
					 echo Fnum($Saldo).'&nbsp;';
					 ?>
                     <input name="ChNum" disabled="disabled" type="hidden" id="ChNum" value="<?php  echo $Saldo; ?>" size="12" />
                    </td>
                  <td width="10" align="right"><input type="submit" name="G" id="G" value="G" /></td>
                </tr>
              </table>
              </form>
              </td>
            </tr>
            <?php } 
			
					} while($row_ = mysql_fetch_assoc($RS_)); ?>
                    
                    
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Saldo en Banco</td>
              <td width="120" align="right" nowrap="nowrap">&nbsp;<?php echo Fnum($Saldo); ?></td>
            </tr>
            
<?php 

$sql = "SELECT * FROM Cheque WHERE 
			Cuenta = '".$_GET['Cuenta']."' AND
			SW_Pagado = '0' AND
			Monto > 0 
			ORDER BY NumCheque";
$_RS = mysql_query($sql, $bd) or die(mysql_error());
$_row_RS = mysql_fetch_assoc($_RS);
$_totalRows_RS = mysql_num_rows($_RS);

?>            
            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap"><table border="0" cellspacing="0" cellpadding="0">
               
               <?php 
if($_totalRows_RS>0)
do{
extract($_row_RS);?>
                <tr>
                  <td width="80">&nbsp;<?php echo $NumCheque; ?></td>
                  <td width="200">&nbsp;<?php echo $FavorDe; ?></td>
                  <td width="120" align="right">&nbsp;<?php echo Fnum($Monto); $Saldo -= $Monto; ?></td>
                  <td width="120">&nbsp;</td>
                </tr>
<?php } while ($_row_RS = mysql_fetch_assoc($_RS));?>            
              
              
              </table></td>
            </tr>
            



            <tr valign="baseline">
              <td align="right" nowrap="nowrap">Saldo Disponible</td>
              <td align="right" nowrap="nowrap">&nbsp;<?php echo Fnum($Saldo); ?></td>
            </tr>

            
            
            <tr valign="baseline">
              <td colspan="2"  align="right" nowrap="nowrap">                    </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</body>
</html>
