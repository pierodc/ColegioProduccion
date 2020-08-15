<?php 
$MM_authorizedUsers = "91,admin";
require_once('../../../inc_login_ck.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 


if(isset($_POST['Buscar'])) {
	
	$Buscar = $_POST['Buscar'];
	$FechaInicio = $_POST['FechaInicio'];
	
	$sql = "SELECT * 
			FROM  Contable_Imp_Todo 
			WHERE Descripcion LIKE  '%$Buscar%'
			AND Fecha >= '$FechaInicio'
			ORDER BY Fecha DESC";
	}
	
else{
	if(!isset($_GET['Mes']) or $_GET['Mes'] == "" ) {
		header("Location: ".$auxPag."?Cuenta=".$_GET['Cuenta']."&Mes=".date('m')."&Ano=".date('Y'));
	}
	
	if(!isset($_GET['Cuenta'])){
		header("Location: ".$auxPag."?Cuenta=1&Mes=".$_GET['Mes']."&Ano=".$_GET['Ano']);
	}


	// Activa Inspeccion
	$Insp = false ;
	
	if($_GET['Cuenta'] > 0){
		$Cuenta = 'AND CodigoCuenta = '.$_GET['Cuenta'];}
	//AND MontoDebe <> 0
	
	$sql = "SELECT * 
			FROM  Contable_Imp_Todo 
			WHERE Fecha >=  '$Fecha_Inicio_Mes'
			AND Fecha <=  '$Fecha_Fin_Mes'
			$Cuenta
			ORDER BY Fecha, Referencia";
}

echo $sql;

$RS_ = $mysqli->query($sql);
$row_ = $RS_->fetch_assoc();

$TituloPantalla = "Conciliacion Bancaria";




?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body >
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="2"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="left"><a href="../index.php"><img src="../../../img/home.png" alt="" width="25" height="27" border="0" /></a> - <a href="Banco_Concilia.php">Egresos Banco</a> | <a href="Banco_Cheques.php">Chequeras</a> | <a href="Banco_Cheques_Crear.php">Crear Chequera</a></td>
    <td align="right"><span style="font-weight: bold">&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
  <table width="100%" border="0" cellpadding="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
            <td align="left"><form name="form" id="form">
              <span class="RTitulo">Movimientos Banco</span>
              <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)">
                <option value="<?php php_self(); ?>">Seleccione Banco...</option>
                <option value="<?php php_self(); ?>?Cuenta=1" <?php if ($_GET['Cuenta']==1) echo ' selected="selected"'; ?>>Mercantil</option>
                <option value="<?php php_self(); ?>?Cuenta=2" <?php if ($_GET['Cuenta']==2) echo ' selected="selected"'; ?>>Provincial</option>
              <option value="<?php php_self(); ?>?Cuenta=5" <?php if ($_GET['Cuenta']==5) echo ' selected="selected"'; ?>>Activo</option>
              </select>
            </form></td>
            <td align="left"><form id="form1" name="form1" method="post" action="">
              <input type="text" name="Buscar" id="Buscar" />
              Fecha inicial
              <input type="date" name="FechaInicio" id="textfield" value="<?php echo "20".$Ano1. date("-m-d") ?>" />
<input type="submit" />
              <input type="hidden" name="Cuenta" value="<?php echo $_GET['Cuenta'] ?>" />
            </form></td>
            <td align="right"><?php 
			$addVars = "&Cuenta=".$_GET['Cuenta'];
			Ir_a_AnoMes($Mes, $Ano, $addVars); ?></td>
          </tr>
            <tr>
              <td colspan="3" nowrap="nowrap" >
              <table width="100%" border="0" cellpadding="0">

<?php if( $_GET['Cuenta']>0 ){ ?>

<tr>
  <td align="center" nowrap="nowrap" class="NombreCampo" >Fecha</td>
  <td align="center" nowrap="nowrap" class="NombreCampo" >T</td>
  <td nowrap="nowrap" class="NombreCampo" >Referencia</td>
  <td nowrap="nowrap" class="NombreCampo" >Descripcion</td>
  <td align="center" nowrap="nowrap" class="NombreCampo" >Debe</td>
  <td colspan="2" align="center"  nowrap="nowrap" class="NombreCampo">Haber</td>
  </tr>
<tr>
  <td nowrap="nowrap" class="FondoCampo" ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td nowrap="nowrap" class="FondoCampo" ><img src="../../../img/b.gif" alt="" width="20" height="1" /></td>
  <td nowrap="nowrap" class="FondoCampo" ><img src="../../../img/b.gif" alt="" width="100" height="1" /></td>
  <td nowrap="nowrap" class="FondoCampo" ><img src="../../../img/b.gif" alt="" width="450" height="1" /></td>
  <td nowrap="nowrap" class="FondoCampo" ><img src="../../../img/b.gif" alt="" width="80" height="1" /></td>
  <td align="right"  nowrap="nowrap" class="FondoCampo"><img src="../../../img/b.gif" width="80" height="1" /></td>
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
	$SaldoEnBanco += $MontoHaber - $MontoDebe;
	
		if($MontoDebe <> 0 or $CodigoCuenta == 5){ //
		?>
		
		
		<tr>
<td colspan="3" nowrap="nowrap"  <?php $sw=ListaFondo($sw,$Verde); ?>>
<iframe src="Banco_Concilia_iFr.php?Codigo=<?php echo $Codigo ?>" width="100%" height="27" frameborder="0" scrolling="no"></iframe>
</td>
		</tr>
		
		
		<?php } 
	
	} while($row_ = $RS_->fetch_assoc()); ?>
                    
                    
            
<?php 

$sql = "SELECT * FROM Cheque WHERE 
			Cuenta = '".$_GET['Cuenta']."' AND
			SW_Pagado = '0' AND
			Monto > 0 
			ORDER BY NumCheque";

$_RS = $mysqli->query($sql);
$_row_RS = $_RS->fetch_assoc();

?>
            <tr valign="baseline">
              <td colspan="3" align="right" nowrap="nowrap"><table border="0" align="center" cellpadding="0">
                 <tr>
                   <td colspan="5" class="NombreCampoBIG">Cheques sin cobrar</td>
                 </tr>
                 <tr>
                  <td align="center" class="NombreCampo">Num Ch</td>
                  <td align="center" class="NombreCampo">Fecha</td>
                  <td class="NombreCampo">A Favor de</td>
                  <td align="right" class="NombreCampo">Monto</td>
                  <td align="right" class="NombreCampo">suma</td>
                </tr>
              
               <?php 
if($_row_RS)
do{
extract($_row_RS);?>
                <tr>
                  <td width="38" align="center" class="FondoCampo">&nbsp;<?php echo $NumCheque; ?></td>
                  <td width="40" align="center" class="FondoCampo"><?php echo DDMMAAAA($Fecha); ?></td>
                  <td width="200" class="FondoCampo">&nbsp;<?php echo $FavorDe; ?></td>
                  <td width="59" align="right" class="FondoCampo">&nbsp;<?php 
				  echo Fnum($Monto); 
				  $Saldo -= $Monto; 
				  $MontoPorCobrar += $Monto;
				  ?></td>
                  <td width="59" align="right" class="FondoCampo">&nbsp;<?php echo Fnum($MontoPorCobrar); ?></td>
                </tr>
<?php } while ($_row_RS = $_RS->fetch_assoc());?>
             
              
              </table></td>
            </tr>
            
            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap" class="NombreCampo">Saldo en Banco</td>
              <td width="120" align="right" nowrap="nowrap" class="FondoCampo">&nbsp;<?php echo Fnum($SaldoEnBanco); ?></td>
            </tr>



            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap" class="NombreCampo">Cheques por cobrar</td>
              <td align="right" nowrap="nowrap" class="FondoCampo">- <?php echo Fnum($MontoPorCobrar);?></td>
            </tr>
            <tr valign="baseline">
              <td colspan="2" align="right" nowrap="nowrap" class="NombreCampoBIG">Saldo Disponible</td>
              <td align="right" nowrap="nowrap" class="nav">&nbsp;<?php echo Fnum($Saldo); ?></td>
            </tr>
<?php } ?>
            
        </table>
    </td>
  </tr>
</table>
<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>