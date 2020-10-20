<?php 
$MM_authorizedUsers = "99,91,95,Contable";
require_once( $_SERVER['DOCUMENT_ROOT'] . "/Config/Autoload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


//Cambia Nombre Factura
if (isset($_POST['CambiaNombreFactura']) and $_POST['CambiaNombreFactura']==1) {
		mysql_select_db($database_bd, $bd);
		$query = "UPDATE ContableMov 
					SET CodigoReciboCliente = '".$_POST['CodigoReciboCliente']."'
					WHERE Codigo = '".$_POST['Codigo']."' ";
		//echo $query;			
		$rs = mysql_query($query, $bd) or die(mysql_error()); 
		header("Location: ".$_SERVER['PHP_SELF']."?CodigoPropietario=".$_GET['CodigoPropietario']."&CodigoAlumno=".$_GET['CodigoAlumno']);}
//


/*$CodigoAlumno = $_GET['CodigoAlumno'];
mysql_select_db($database_bd, $bd);
$query_Alumno = "SELECT * FROM Alumno WHERE CodigoAlumno = $CodigoAlumno";
$Alumno = mysql_query($query_Alumno, $bd) or die(mysql_error());
$row_Alumno = mysql_fetch_assoc($Alumno);
*/
 
 $Alumno = new Alumno($_GET['CodigoPropietario']);
 
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo "H: " . $Alumno->NombreApellidoCodigo(); ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>
        <table width="100%" border="0">
            <tr>
              <td class="NombreCampo">
                <?php
// Busca todos los recibos
//$CodigoAlumno = $_GET['CodigoAlumno'];
mysql_select_db($database_bd, $bd);
$query_Recibos = "SELECT * FROM Recibo 
				  WHERE CodigoPropietario = '".$Alumno->Codigo() ."'
				  ORDER BY CodigoRecibo DESC";
				  //echo $query_Recibos;
$Recibos = mysql_query($query_Recibos, $bd) or die(mysql_error());
$row_Recibos = mysql_fetch_assoc($Recibos);
$totalRows_Recibos = mysql_num_rows($Recibos);
?>Fecha</td>
              <td colspan="2" align="center" class="NombreCampoTopeWin">Descripci&oacute;n</td>
              <td align="center" class="NombreCampoTopeWin">Ref</td>
              <td width="100" align="center" class="NombreCampoTopeWin">Pago</td>
              <td width="100" align="center" class="NombreCampoTopeWin">Abono</td>
              <td width="100" align="center" class="NombreCampoTopeWin">Saldo</td>
              <td width="49" align="center" class="NombreCampoTopeWin">Por</td>
            </tr>
            <?php if ($totalRows_Recibos>0){ ?>
            
            
            <?php  $saldo=0; $Par = true;  ?>
 <?php do { // RECIBOS ?>
             <tr>
              <td colspan="8" bgcolor="#0033FF"><img src="../../../img/b.gif" width="1" height="1" /></td>
            </tr>
			<tr >
              <?php //if ($Par) {$In = "In"; $Par=false;}else{$In = ""; $Par=true;} ?>
              <td colspan="3" class="Listado<?php echo $In; ?>Par"><b><?php echo DDMMAAAA($row_Recibos['Fecha'])." (" . $row_Recibos['Por'] . ")"; ?></b></td>
              <td align="center" class="Listado<?php echo $In; ?>Par"><a href="../../Recibo.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>" target="_blank">imprimir<br />Recibo <?php echo $row_Recibos['CodigoRecibo']; ?></a></td>
              <td colspan="4" align="center" nowrap="nowrap" class="Listado<?php echo $In; ?>Par"><b>
                <?php 
				$sql = "SELECT MAX(NumeroFactura) AS NumFacMax FROM Recibo";
				$query = mysql_query($sql, $bd) or die(mysql_error());
				$row_query = mysql_fetch_assoc($query);
				$NumFacMax = $row_query['NumFacMax'];
				
				$NumeroFactura = $row_Recibos['NumeroFactura']*1;
				
				$Fac_Rif = $row_Recibos['Fac_Rif'];

				
		   
		   // Busca los movimientos hijos del recibo
			$CodigoRecibo = $row_Recibos['CodigoRecibo'];
			mysql_select_db($database_bd, $bd);
			$query_Recibos_Hijos = "SELECT * FROM ContableMov 
									WHERE CodigoRecibo = $CodigoRecibo 
									ORDER BY MontoHaber_Dolares DESC,MontoHaber DESC,  Fecha ASC, Codigo ASC";//echo $query_Recibos;
			$Recibos_Hijos = mysql_query($query_Recibos_Hijos, $bd) or die(mysql_error());
			$row_Recibos_Hijos = mysql_fetch_assoc($Recibos_Hijos);
			$totalRows_Recibos_Hijos = mysql_num_rows($Recibos_Hijos);

		   
		   
				if (( $row_Recibos['NumeroFactura'] == 0 or $NumeroFactura == $NumFacMax ) and $Fac_Rif > "" ){ 
					
					//$CodigoRecibo
					
				} ?>
              </b>
                <?php if($row_Recibos['NumeroFactura']>0){
					  echo "Factura No.".$row_Recibos['NumeroFactura']." (" . $row_Recibos['FacturaImpPor'] . ")";  ?>
                <?php if ($MM_Username == "piero"){ ?>
                <br />
                <a href="Procesa.php?AnularFactura=1&NumeroFactura=<?php echo $row_Recibos['NumeroFactura']; ?>" target="_blank">Poner en cero</a> | 
                <?php } ?>
                 
                <?php }
				
				if ($MM_Username == "piero"){ ?>eeee
                <a href="Procesa_Reversa_Factura.php?Procesar_Codigo=<?php echo $row_Recibos['CodigoRecibo']; ?>" target="_blank">Reversar</a>
                <?php } echo ".." . $MM_Username.".."; ?>
              </b></td>
            </tr> 


<?php 

?>

<?php do { // Hijos del Recibo ?>
            
                      
            <tr >
              <?php if ($Par) {$In = "In"; $Par=false;}else{$In = ""; $Par=true;} ?>
              <td class="Listado<?php echo $In; ?>Par"><div align="center">
                <?php 
			  if ($MM_Username=="piero") { ?>
              <a href="Procesa.php?EliminarMov=1&amp;Codigo=<?php echo $row_Recibos_Hijos['Codigo']; ?>&amp;CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>" target="_blank"><img src="../../../img/b_drop.png" width="16" height="16" border="0" /></a>
              <?php } ?>
              </div></td>
              <td nowrap="nowrap" class="Listado<?php echo $In; ?>Par"><?php 
			  if($row_Recibos_Hijos['Descripcion'] != 'Abono a cuenta'){
			  	echo ''.$row_Recibos_Hijos['Descripcion'].'';}
			  else { 
			  	 if ($row_Recibos['NumeroFactura']==0) { ?>
                <form id="form3" name="form3" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&CodigoAlumno=<?php echo $_GET['CodigoAlumno']; ?>">
                  Facturar a: 
                  <input name="Codigo" type="hidden" value="<?php echo $row_Recibos_Hijos['Codigo']; ?>" />
                  <input name="CambiaNombreFactura" type="hidden" value="1" />
                  <select name="CodigoReciboCliente" id="CodigoReciboCliente"><?php 
				$sql = "SELECT * FROM ReciboCliente
						WHERE CodigoAlumno = '$CodigoAlumno'";
				$RS = mysql_query($sql, $bd) or die(mysql_error());
				$row = mysql_fetch_assoc($RS);
				$totalRows = mysql_num_rows($RS);
				
				
				
				if($totalRows >= 1){
				?>
                    <option value="0" <?php if($row_Recibos_Hijos['CodigoReciboCliente']==0) 
					echo 'selected="selected"'; ?>>Seleccione...</option>
                    <?php }
				do{
					extract($row);
					echo "<option value=\"$Codigo\"";
					if($row_Recibos_Hijos['CodigoReciboCliente'] == $row['Codigo']) 
					echo ' selected="selected" ';
					echo ">$Nombre</option>";
				} while($row = mysql_fetch_assoc($RS));
				
				  ?>
                  </select>
                  <input type="submit" name="BotonRecibo2" id="BotonRecibo2" value="Guardar" onclick="this.disabled=true;this.form.submit();" />
                </form>
                
                
                
                
              <?php } 
	else { echo "PAGO"; }}
	?> </td>
             
             
              <td nowrap="nowrap" class="Listado<?php echo $In; ?>Par"><? 
		  if ($row_Recibos_Hijos['CodigoReciboCliente'] > 0 and ($NumeroFactura == $NumFacMax or $NumeroFactura == 0)) { ?>
                <a href="../Contabilidad/PDF/Factura.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>" target="_blank">Imprimir Factura</a>
                <? } ?>&nbsp;</td>
                
                
              <td class="<?php 
				$MontoBancoAux='';
					// Ubica si esta en banco
					mysql_select_db($database_bd, $bd);
					$query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo 
										   WHERE Referencia = '".$row_Recibos_Hijos['Referencia']."'
										   ORDER BY Fecha DESC";
					$RS_del_Banco = mysql_query($query_RS_del_Banco, $bd) or die(mysql_error());
					$row_RS_del_Banco = mysql_fetch_assoc($RS_del_Banco);
					$totalRows_RS_del_Banco = mysql_num_rows($RS_del_Banco);

					if($row_Recibos_Hijos['MontoHaber'] <= $row_RS_del_Banco['MontoHaber'] and
					   $row_Recibos_Hijos['MontoHaber'] > 0) {
						
					if($row_Recibos_Hijos['MontoHaber']==$row_RS_del_Banco['MontoHaber']){	
						echo "FondoCampoVerde"; }
					elseif($row_Recibos_Hijos['MontoHaber']<=$row_RS_del_Banco['MontoHaber']){	
						echo "FondoCampoAmarillo"; 
					$MontoBancoAux=$row_RS_del_Banco['MontoHaber'];
					}
					
					 } 
					elseif ($row_Recibos_Hijos['MontoHaber']>0){ 
					
					if( $row_Recibos_Hijos['Tipo']==3) {
						echo "FondoCampoAzul";}
					elseif($row_Recibos_Hijos['Tipo']==4) {
						echo "FondoCampoNaranja";}
					elseif($row_Recibos_Hijos['MontoHaber']>0){
						echo "SW_Rojo"; }
					
					 } else{
					echo 'Listado' . $In . 'Par';
					}
				
				
				
				?>"><div align="center"><b><span class="Listado<?php echo $In; ?>Par"><b><?php 
				if ($row_Recibos_Hijos['ReferenciaMesAno']!=0)
					echo Mes(substr($row_Recibos_Hijos['ReferenciaMesAno'],0,2)).
							substr($row_Recibos_Hijos['ReferenciaMesAno'],2,3);  ?></b></span>
                <?php 
				if( $row_Recibos_Hijos['MontoHaber'] > 0 or $row_Recibos_Hijos['MontoHaber_Dolares'] > 0 ){
				
				echo FormaDePago($row_Recibos_Hijos['Tipo']);
				
				echo $row_Recibos_Hijos['ReferenciaBanco'].' ';
				echo $row_Recibos_Hijos['Referencia'].' '; 
				echo Fnum($row_Recibos_Hijos['MontoHaber']).' <br>'; 
				echo FNum($MontoBancoAux);
				
				///if($row_Recibos_Hijos['ReferenciaOriginal'] <> $row_Recibos_Hijos['Referencia']  ) 
				//	echo '<br>Ref. Orig. '. $row_Recibos_Hijos['ReferenciaOriginal'] ;
				}
				
				if($row_Recibos_Hijos['Referencia'] != $row_Recibos_Hijos['ReferenciaOriginal'] 
				    and $row_Recibos_Hijos['ReferenciaOriginal'] > 0 ){
					echo '  /  Orig: '.$row_Recibos_Hijos['ReferenciaOriginal'];}
				
				if($row_RS_del_Banco['Fecha']>"2000-01-01") echo '<br>'.DDMMAAAA($row_RS_del_Banco['Fecha']);
				echo ' '.$row_RS_del_Banco['Descripcion'];
				echo '<br>'.$row_Recibos_Hijos['Observaciones'];
				?>
              </b></div></td>
              
              
              
              <td align="right" nowrap="nowrap" class="Listado<?php echo $In; ?>Par"><b>
                <? 
				  if($row_Recibos_Hijos['MontoHaber_Dolares'] > 0 ){
		  			echo "$ ".$row_Recibos_Hijos['MontoHaber_Dolares'];
					echo " x ". $row_Recibos_Hijos['Cambio_Dolar'];
				  }
					elseif ($row_Recibos_Hijos['MontoHaber'] > 0 ){  
				  		echo "Bs " . Fnum($row_Recibos_Hijos['MontoHaber']);
				  }
				  ?>
              </b></td>
              
              
              
              
              <td align="right" class="Listado<?php echo $In; ?>Par"><b>
                <?php 
		  if( $row_Recibos_Hijos['SWValidado'] > 0 and 
			 ($row_Recibos_Hijos['MontoAbono'] > 0 or $row_Recibos_Hijos['MontoAbono_Dolares'] > 0) ) {
				echo Fnum($row_Recibos_Hijos['MontoAbono']);
				echo Fnum($row_Recibos_Hijos['MontoAbono_Dolares']);
				$Tot_Abono += $row_Recibos_Hijos['MontoAbono'];
			} 
				  ?>
              </b></td>
              
              
              
              <td align="right" class="Listado<?php echo $In; ?>Par"><b>
                <?php if($row_Recibos_Hijos['SWValidado'] > 0) {
					  
							$auxMonto = $row_Recibos_Hijos['MontoDebe']-$row_Recibos_Hijos['MontoAbono']; 
							echo " Bs ". Fnum($auxMonto);
					
					  		echo "/ $ ". Fnum($row_Recibos_Hijos['MontoDebe_Dolares']-$row_Recibos_Hijos['MontoAbono_Dolares']);
					  
					  		$Tot_Debe += $auxMonto;
						} ?>
              </b></td>
              
              
              
              
              <td align="right" class="Listado<?php echo $In; ?>Par"><div align="center"> <?php echo substr($row_Recibos_Hijos['RegistradoPor'],0,5); ?></div></td>
            </tr>


            
			
			
			  
   <?php			  
			  
			  } while ($row_Recibos_Hijos = mysql_fetch_assoc($Recibos_Hijos)); // Hijos del Recibo
			  
	?>	   
	<tr>
		<td>resumen</td>
		<td colspan="2"> </td>
		<td> </td>
		<td align="right" class="ListadoParAzul"><?= Fnum($Tot_Pago) ?>&nbsp;	</td>
		<td align="right" class="ListadoParAzul"><?= Fnum($Tot_Abono) ?> &nbsp;	</td>
		<td align="right" class="ListadoParAzul"><?= Fnum($Tot_Debe) ?>&nbsp;	</td>
		<td align="right" class="ListadoParAzul"><?= Fnum($Tot_Pago - $Tot_Debe) ?>&nbsp;	 </td>
	</tr>	
	<?	   
		   
	$Tot_Pago = $Tot_Abono = $Tot_Debe = $Diferencia = 0;
		   
	     } while ($row_Recibos = mysql_fetch_assoc($Recibos)); 
              
              
 } // fin SI Existen recibos if ($totalRows_Recibos>0) ?>
          </table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
