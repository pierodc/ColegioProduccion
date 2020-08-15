<?php 

$MM_authorizedUsers = "91,admin";
require_once('../../../inc/Login_check.php'); 
require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

mysql_select_db($database_bd, $bd);

$TituloPantalla = "Libro de Ventas";


// Activa Inspeccion
$Insp = false ;

// Anula Factura
if(isset($_GET['Nula'])){
	$sql = "UPDATE Recibo SET 
			SW_Nula = '$_GET[Nula]'
			WHERE CodigoRecibo = '$_GET[CodigoRecibo]'";
	$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());
}

//echo $_POST['G'];

// Actualiza Num Control
if(isset($_POST['G']) or false){ 
	$CodigoRecibo = $_POST['CodigoRecibo'];
	$ControlNuevo = $_POST['Fac_Num_Control'];
	$FacturaNueva = $_POST['NumeroFactura'];
	
	
	if($_POST['G'] == 'todo'){
		$sql = "UPDATE Recibo SET 
				Fac_Num_Control = '$ControlNuevo',
				NumeroFactura = '$FacturaNueva'
				WHERE CodigoRecibo = '$CodigoRecibo'";
		$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());}
	else{
		$sql = "SELECT * FROM Recibo
				WHERE CodigoRecibo = '$CodigoRecibo'";
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		$row_ = mysql_fetch_assoc($RS_);
		$NumeroFacturaActual = $row_['NumeroFactura'];
		$NumeroControlActual = $row_['Fac_Num_Control'];
		$FechaImpFactura     = $row_['FechaImpFactura'];

		$sql = "SELECT * FROM Recibo
				WHERE FechaImpFactura >= '$FechaImpFactura'
				AND SW_Nula <> '1'
				ORDER BY FechaImpFactura";
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		}
		
		
	if($_POST['G'] == 'Fecha'){
		$FechaImpFacturaNueva = $_POST['FechaImpFactura'].' 00:00:00';
		$sql = "UPDATE Recibo SET 
				FechaImpFactura = '$FechaImpFacturaNueva'
				WHERE CodigoRecibo = '$_POST[CodigoRecibo]'";
		//echo $sql.'<br>';		
		$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());
	}
	
	if($_POST['G'] == 'fac'){
		 while ($row_ = mysql_fetch_assoc($RS_)){
			$sql = "UPDATE Recibo SET 
					NumeroFactura = '$FacturaNueva'
					WHERE CodigoRecibo = '$row_[CodigoRecibo]'";
			$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());
			$FacturaNueva++;
		}
	}
	
	if($_POST['G'] == 'con'){
		 while ($row_ = mysql_fetch_assoc($RS_)){
			$sql = "UPDATE Recibo SET 
					Fac_Num_Control = '$ControlNuevo'
					WHERE CodigoRecibo = '$row_[CodigoRecibo]'";
			$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());
			$ControlNuevo++;
		}
	}
	
	if(false){
		
	
		$sql = "SELECT * FROM Recibo
				WHERE NumeroFactura >= '$NumeroFacturaActual'
				ORDER BY NumeroFactura";
		$RS_ = mysql_query($sql, $bd) or die(mysql_error());
		$row_ = mysql_fetch_assoc($RS_);
		
		/*$NumeroFacturaNueva = $_GET['NumeroFactura'];
		if($row_['NumeroFactura'] != $NumeroFacturaNueva){
			$sql = "UPDATE Recibo SET 
					NumeroFactura = '$NumeroFacturaNueva'
					WHERE CodigoRecibo = '$row_[CodigoRecibo]'";
			$RS_UPDATE = mysql_query($sql, $bd) or die(mysql_error());
		}*/
		
	
	}
}




if(isset($_GET['Fecha'])){
	$Fecha = $_GET['Fecha'];}
else{
	$Fecha = date('Y-m-d');
	header("Location: ".$auxPag."?Fecha=".$Fecha);
}

//echo $auxPag;

if(isset($_POST['Fecha'])){
	$Fecha = $_POST['Fecha'];
	header("Location: ".$auxPag."?Fecha=".$Fecha);
	
	}



//		AND NumeroFactura > 0

$FechaDia = date('Y-m-d 00:00:00' , mktime(0,0,0,substr($Fecha,5,2),substr($Fecha,8,2),substr($Fecha,0,4)));
$FechaDiaSig = date('Y-m-d 00:00:00' ,mktime(0,0,0,substr($Fecha,5,2),substr($Fecha,8,2)+1,substr($Fecha,0,4)));


$sql = "SELECT * 
		FROM  Recibo 
		WHERE FechaImpFactura >= '$FechaDia'
		AND FechaImpFactura < '$FechaDiaSig'
		ORDER BY FechaImpFactura";
//echo $sql.'<br>';		
$RS_ = mysql_query($sql, $bd) or die(mysql_error());
//$row_ = mysql_fetch_assoc($RS_);
$totalRows_ = mysql_num_rows($RS_);
//echo $totalRows_;

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
$aux = $_GET['form']+1;
echo 'OnLoad="document.form'. $aux .'.Fac_Num_Control.focus();"'; ?>>
<table width="100%" border="0" align="center">
  <tr>
    <td colspan="2"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
  <tr>
    <td align="left">
<?php Ir_a_Dia($Fecha, $addVars) ?></td>
    <td align="right"><span style="font-weight: bold"><a href="Libro_Ventas_out.php">excel</a>&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#333333">
          <tr valign="baseline">
              <td colspan="5" align="left" nowrap="nowrap" class="subtitle">Movimientos Banco</td>
          </tr>
          <tr valign="baseline">
            <td colspan="5" align="left">
</td>
          </tr>
          
            <tr>
              <td colspan="5" nowrap="nowrap">
              <table width="793" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr>
                  <td align="center" class="NombreCampo"><img src="../../../img/b.gif" width="42" height="1" /><br>Hora</td>
                  <td width="10" align="center" class="NombreCampo"><input name="Fecha" type="date" value="<?php echo $Fecha ?>" /></td>
                  <td width="100" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="101" height="1" /><br>
                  Rif
                  </td>
                  <td width="220" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="221" height="1" /><br>
                  Nombre
                  </td>
                  <td width="50" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="51" height="1" /><br>
                  Alum
                  </td>
                  <td width="70" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="71" height="1" /><br>
                  Total
                  </td>
                  <td width="60" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="65" height="1" /><br>
                  Cnt #
                  </td>
                  <td width="60" align="center" class="NombreCampo">
                  <img src="../../../img/b.gif" width="65" height="1" /><br>
                  Fac #
                  </td>
                  <td align="center" class="NombreCampo">&nbsp;</td>
                </tr>
              </table>
              </td>
            </tr><?php 
			
			while($row_ = mysql_fetch_assoc($RS_)){ 
			$Fac_Num_Control_Siguiente = $row_['Fac_Num_Control'];
			extract($row_);
			

           if (false and $Fac_Num_Control > 0 and $Fac_Num_Control != $Fac_Num_Control_Siguiente) { // NULOS 
				
				for($i = $Fac_Num_Control_Siguiente; $i < $Fac_Num_Control; $i++){
				
				?><tr>
                <td colspan="4" align="right" >&nbsp;
                <?php 
                
                echo 'Nulo';
                //$Fac_Num_Control_Siguiente++;
                ?>
                </td>
                <td align="right" >&nbsp;
                <?php 
                
                echo $i;
                
                ?>
                </td>
        	</tr><?php } } 




			$MontoDebe  = abs($MontoDebe);
			$MontoHaber = abs($MontoHaber);
			$Saldo += $MontoHaber - $MontoDebe;

			
			?><tr>
              <td colspan="5" nowrap="nowrap">
              <form id="form1" name="form<?php echo ++$form ?>" method="post" action="<?php 
			  echo php_self()."?CodigoRecibo=$CodigoRecibo&form=$form&Fecha=$Fecha#Cod$CodigoRecibo"; ?>">
                <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
                <tr  class="<?php 
			  if($_GET['CodigoRecibo']==$CodigoRecibo){
				  $focus = 0;
				  echo 'FondoCampoVerde';}
			  elseif($par) {
				  echo 'ListadoInPar';
				  $par=false;}
				else {
				  echo 'ListadoPar';
				  $par=true;} 
			  
			  ?>">
                  <td width="19" align="center" nowrap="nowrap"><input type="submit" name="G" id="G" value="todo" />
                  </td>
                  <td width="9" align="center" nowrap="nowrap"><img src="../../../img/b.gif" width="40" height="1" /><br><?php 
				  echo substr($FechaImpFactura,11,5);
				  //echo $FechaImpFactura;  ?></td>
                  <td width="100" align="right" nowrap="nowrap"><input name="FechaImpFactura" type="date" value="<?php echo substr($FechaImpFactura,0,10); ?>" size="8" />
                   <input type="submit" name="G" id="G" value="Fecha" /></td>
                  <td width="100" align="right" nowrap="nowrap">
                  <img src="../../../img/b.gif" width="100" height="1" /><br>
                  <?php echo $SW_Nula?'':$Fac_Rif;  ?>
                  </td>
                 
                 
                  <td align="center" nowrap="nowrap" width="60"><a href="Libro_Ventas.php?Fecha=<?php echo $_GET['Fecha'] ?>&Nula=<?php echo $SW_Nula?'0':'1'; ?>&CodigoRecibo=<?php echo $CodigoRecibo;  ?>"><?php echo $SW_Nula?'-0-':'&lt;- Anular -&gt;'; ?></a></td>
                  
                  
                  <td nowrap="nowrap" width="220" >
                    <img src="../../../img/b.gif" width="220" height="1" /><br>
                  <?php echo $SW_Nula?'Nula':substr($Fac_Nombre,0,30).' ('.$CodigoPropietario.')'; ?></td>
                  <td width="100" align="center" nowrap="nowrap"><input name="CodigoRecibo" type="hidden" value="<?php echo $CodigoRecibo; ?>"  />
                     <input name="Fac_Num_Control" type="text" value="<?php echo $Fac_Num_Control; ?>" size="8" />
                     <input type="submit" name="G" id="G" value="con" />
                   </td>
                  
                     
                     
                     
                  <td width="100" align="center" nowrap="nowrap">
                  <img src="../../../img/b.gif" width="60" height="1" /><br>
                  <input name="NumeroFactura" type="text" value="<?php echo $NumeroFactura; ?>" size="8" />
                  <input type="submit" name="G" id="G" value="fac" />
                  <?php //echo $NumeroFactura;  ?>
                  </td>
                  
                  
                  
                  <td width="100" align="right" nowrap="nowrap"><?php 
					 echo $SW_Nula?'':Fnum($Total);
					 ?></td>
                  </tr>
              </table>
              </form>
              </td>
            </tr>
            

    <?php  
			$Fac_Num_Control_Siguiente = $Fac_Num_Control+1;
			
					}  ?>
            <tr valign="baseline">
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="right" nowrap="nowrap">&nbsp;</td>
              <td align="right" nowrap="nowrap"><?php echo Fnum($Saldo); ?></td>
            </tr>
            <tr valign="baseline">
              <td colspan="5"  align="right" nowrap="nowrap">                    </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</body>
</html>