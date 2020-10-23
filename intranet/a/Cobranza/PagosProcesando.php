<div id="PagosProcesando"><?php 
/*
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
*/
//header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Banco = new Banco($id);
	
$query_RS_ContableMov_Procesando = "SELECT * FROM ContableMov 
									WHERE CodigoPropietario = '$CodigoAlumno' 
									AND (MontoHaber > 0 or MontoHaber_Dolares > 0  )
									
									AND CodigoRecibo = 0 
									ORDER BY Fecha ASC, Codigo ASC"; //AND id_Banco < 1
											
echo $Insp ?  $query_RS_ContableMov_Procesando." (11)<br>" : "";

$RS_ContableMov_Procesando = $mysqli->query($query_RS_ContableMov_Procesando);
$row_RS_ContableMov_Procesando = $RS_ContableMov_Procesando->fetch_assoc();
$totalRows_RS_ContableMov_Procesando = $RS_ContableMov_Procesando->num_rows;


$totalRows_RS_ContableMov_Procesando = $RS_ContableMov_Procesando->num_rows;

if ($totalRows_RS_ContableMov_Procesando > 0) { // Show if recordset not empty 


?><table >
     <caption>Pagos Procesando | <a href="Recibo_Crea_Cliente.php?CodigoAlumno=<?php echo $CodigoAlumno ?>&amp;CodigoPropietario=<?php echo $_GET['CodigoPropietario'] ?>">crea Nombre</a></caption>
      
<!--tr>
<td align="center" class="NombreCampoTopeWin">&nbsp;</td>
<td width="90%" colspan="2" align="center" class="NombreCampoTopeWin">Resumen</td>
<td align="center" nowrap="nowrap" class="NombreCampoTopeWin"> Banco</td>
<td width="10%" align="center" class="NombreCampoTopeWin"><strong>Un solo click</strong><?php $formi=20; ?></td>
</tr-->
<?php 
do { 

$query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo 
						WHERE Referencia = '".$row_RS_ContableMov_Procesando['Referencia']."'
						AND MontoHaber > 0";										
$RS_del_Banco = $mysqli->query($query_RS_del_Banco);
$row_RS_del_Banco = $RS_del_Banco->fetch_assoc();
$totalRows_RS_del_Banco = $RS_del_Banco->num_rows;
$MontoEnBanco = $row_RS_del_Banco['MontoHaber'];

$MontoUsado = 0;
$query = "SELECT SUM(MontoHaber) AS MontoUsado 
			FROM ContableMov 
			WHERE Referencia = '".$row_RS_ContableMov_Procesando['Referencia']."'";
$RS = $mysqli->query($query);
$row_RS = $RS->fetch_assoc();
$MontoUsado = $row_RS['MontoUsado'];

$MontoIngresado = $row_RS_ContableMov_Procesando['MontoHaber'];

$SWAbonoUsado = false;
if( $row_RS_ContableMov_Procesando['Referencia']>" ") {
	$query = "SELECT * FROM ContableMov 
				WHERE CodigoRecibo <> 0 
				AND Referencia = '".$row_RS_ContableMov_Procesando['Referencia']."' 
				AND ( ReferenciaBanco = '".$row_RS_ContableMov_Procesando['ReferenciaBanco']."' 
				OR Tipo = '".$row_RS_ContableMov_Procesando['Tipo']."')";
	$RS = $mysqli->query($query);
	$row_RS = $RS->fetch_assoc();
	$totalRows_RS = $RS->num_rows;
	if ($totalRows_RS > 0){
		$SWAbonoUsado = true;}
}



?>
<tr>
  <td  ></td>
  <td colspan="2" bgcolor="#FFFFFF">
  
  <table class="sombra" >
  
    <tr>
    <td>&nbsp;</td>
  <td align="left">
    <strong>Origen</strong></td>
  <td align="left"><?php 


$MontoRestante = $MontoEnBanco - $MontoUsado;
if( $MontoEnBanco >= $MontoUsado or 
$row_RS_ContableMov_Procesando['Tipo']==3 or 
$row_RS_ContableMov_Procesando['Tipo']==4 or 
$row_RS_ContableMov_Procesando['Tipo']==5 or 
$row_RS_ContableMov_Procesando['Tipo']==6 or 
$row_RS_ContableMov_Procesando['Tipo']==7 or 
$row_RS_ContableMov_Procesando['Tipo']==8 or 
$row_RS_ContableMov_Procesando['Tipo']==9 or 
$row_RS_ContableMov_Procesando['Tipo']==10 ) {
	$Color = "Verde";		
	$valido = true; } 
else { 
	$Color = "Rojo";		
	$valido = false; } 

if($row_RS_ContableMov_Procesando['Tipo'] == 1 or $row_RS_ContableMov_Procesando['Tipo'] == 2){
	$MontoUsado = $MontoUsado - $MontoIngresado; }


$query_RS_del_Banco = "SELECT * FROM Contable_Imp_Todo 
						WHERE Referencia = '".$row_RS_ContableMov_Procesando['Referencia']."'
						AND (MontoHaber > 0)";
$RS_del_Banco = $mysqli->query($query_RS_del_Banco);
$row_RS_del_Banco = $RS_del_Banco->fetch_assoc();

if(strpos("  ".$row_RS_del_Banco['Descripcion'],"DEPCH"))
	echo "";
echo "";
if($row_RS_del_Banco['Fecha'] <> $row_RS_ContableMov_Procesando['Fecha'])	
	echo " <b>".DDMMAAAA($row_RS_del_Banco['Fecha'])."</b>";
else
	echo " ".DDMMAAAA($row_RS_del_Banco['Fecha'])." ";
echo " ".$row_RS_del_Banco['Descripcion']." "; // Desc Banco

if( $Privilegios == 91 ){
	
?>	<a href="Contable_Modifica.php?Codigo=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" target="_blank"><?php echo "Ref: ".$row_RS_ContableMov_Procesando['Referencia'] ?></a> | <? 
	
		if($MM_Username == "piero"){
?>	<a href="Concilia.php?id=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" target="_blank">TEST</a><? 
								   }
		
}
	  ?></td>
  <td align="right">&nbsp;<?php echo Fnum($MontoEnBanco); ?></td>
  <td align="right">&nbsp;</td>
  </tr>
  
  
  
  <?php if ($MontoUsado > 0) {?>
  <tr>
  <td>&nbsp;</td>
  <td>Usado</td>
  <td>&nbsp;</td>
  <td align="right"><?php echo Fnum($MontoUsado) ?>Monto Bs<br>
      $</td>
  <td align="right">&nbsp;</td>
  </tr>
  <?php } ?>
  
  
  <tr bgcolor="#FFFFFF">
    <td><?php 


if ( $row_RS_ContableMov['MontoAbono'] < 1 or $MM_Username=="piero") { ?>
  <iframe src="Procesa.php?bot_EliminarMov=1&Codigo=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" seamless width="25" height="25" frameborder="0" ></iframe>
  <?php }


if ($row_RS_ContableMov_Procesando['Fecha']==date('Y-m-d')){ 
?><img src="http://<?= $_SERVER['SERVER_NAME'] ?>/i/calculator_error.png" width="32" height="32" border="0" align="middle" /><?php 
} 


?></td>
  <td><strong>Actual</strong></td>
  <td>
    
         
           
<table class="sombra" >
          <tbody>
              <tr>
                  <td colspan="4"><?php 

if($row_RS_del_Banco['Fecha'] <> $row_RS_ContableMov_Procesando['Fecha'])	
	echo "<b>".DDMMAAAA($row_RS_ContableMov_Procesando['Fecha'])."</b> "; 
else
	echo "".DDMMAAAA($row_RS_ContableMov_Procesando['Fecha'])." "; 	

echo FormaDePago($row_RS_ContableMov_Procesando['Tipo']).' '.$row_RS_ContableMov_Procesando['Tipo'];

echo Banco ($row_RS_ContableMov_Procesando['CodigoCuenta']);

$Banco_row = $Banco->view($row_RS_ContableMov_Procesando['id_Banco']);
echo $Banco_row['Referencia'];	
	
 ?>&nbsp;</td>
                  </tr>
              <tr>
                  <td nowrap="nowrap">Moneda&nbsp;</td>
                  <td nowrap="nowrap">Monto $&nbsp;</td>
                  <td nowrap="nowrap">Cambio&nbsp;</td>
                  <td nowrap="nowrap">&nbsp;</td>
                  </tr>
              <tr>
                  <td rowspan="2" valign="top"><? echo $row_RS_ContableMov_Procesando['SW_Moneda'] ?></td>
                  <td valign="top"><? Campo_Edit ("ContableMov",$row_RS_ContableMov_Procesando['Codigo'],"MontoHaber_Dolares");  ?>&nbsp;</td>
                  <td valign="top"><? Campo_Edit ("ContableMov",$row_RS_ContableMov_Procesando['Codigo'],"Cambio_Dolar"); ?>&nbsp;</td>
                   <td valign="top"><?
	
				 
				  ?>
                       <? 
	
	
	$Monto_Dolares_Pago = $row_RS_ContableMov_Procesando['MontoHaber_Dolares'] * $row_RS_ContableMov_Procesando['Cambio_Dolar'];
	
	  if($Monto_Dolares_Pago > 0){ ?>
                       <a href="ProcesaPago_Dolares.php?Procesar_Codigo=<?= $row_RS_ContableMov_Procesando['Codigo'] ?>&time=<?= time() ?>" class="button" >Procesa $ <?= Fnum($row_RS_ContableMov_Procesando['MontoHaber_Dolares']) ?></a>
                       <? } 
				 ?> 
                   </td>
                  </tr>
              <tr>
                  <td colspan="3" align="right">&nbsp;Bs.<?
					  
echo Fnum($Monto_Dolares_Pago);
					  
					  ?></td>
                  </tr>
          </tbody>
</table>
      
      
      </td>
  <td ><strong><?php 
	 
echo "Bs ". Fnum($MontoIngresado); 
if($row_RS_ContableMov_Procesando['Cambio_Dolar'] > 0)	
	echo "<br>$ " . Fnum($MontoIngresado / $row_RS_ContableMov_Procesando['Cambio_Dolar']);	
$SumaDePagos += $MontoIngresado;
	
?></strong></td>
  <td align="right"><form id="form_divide<?= ++$forma; ?>" name="form_divide" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>">
    
    <input name="Divide_Pago" type="hidden" value="Divide_Pago" />	
    <input name="Codigo" type="hidden" value="<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" />	
    <input type="text" name="Monto_divide" value="" size="10"  onfocus="this.value=<?php echo $MontoRestante*-1; ?>"  /><button type="submit" class="btn btn-info btn-sm"  onclick="this.disabled=true;this.form.submit();">
							Divide
						</button>
  </form></td>
  </tr>
  
  <tr><td colspan="5" align="center" bgcolor="#FFDFAD" ><?
	  
	   if($row_RS_ContableMov_Procesando['Observaciones'] > "")
					echo "<b>".substr($row_RS_ContableMov_Procesando['Observaciones'],0,100)."</b>";
	
	  
	  ?></td></tr>
  
  <?php if ($MontoRestante <> 0  and $MontoIngresado <> -$MontoRestante) {?>
  <tr>
  <td>&nbsp;</td>
  <td>Sobrante</td>
  <td>&nbsp;</td>
  <td align="right">
    &nbsp;
    <?php 
if ($row_RS_ContableMov_Procesando['Tipo']==1 or $row_RS_ContableMov_Procesando['Tipo']==2){ 
	echo Fnum(round($MontoRestante,2)); }?>
    
  </td>
  <td align="right">&nbsp;</td>
  </tr>
    <?php } ?>
    <tr>
    <td><? 
	
	if (!$row_RS_ContableMov_Procesando['SW_Postergado']){
	
	 ?><iframe src="HidePago.php?Codigo=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" seamless width="40" height="30" scrolling="no" frameborder="0"></iframe> <? 
	 
	 } else { echo "."; } ?></td>
    <td colspan="3"><iframe src="Contable_Modifica_mini.php?Codigo=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>" height="25" width="100%" seamless scrolling="no" frameborder="0"></iframe>
    </td>
    <td align="right"><a href="../Email/index.php?CodigoAlumno=<?= $Alumno->Codigo(); ?>&CodigoPago=<?= $row_RS_ContableMov_Procesando['Codigo']; ?>&Email=Pagos_a_Provincial" target="_blank">Email 
      Pago a Prov</a></td>
    </tr>

</table></td>
  <td align="center" nowrap="nowrap" class="FondoCampo<?php echo $Color; ?>"><strong>
  <?php if ($valido and ($row_RS_ContableMov_Procesando['Tipo']==1 or $row_RS_ContableMov_Procesando['Tipo']==2)){ ?>
  <img src="../../../i/accept.png" width="32" height="32" alt=""/>
  <?php } else { ?>
  <img src="../../../i/cancel.png" width="32" height="32" alt=""/>
  <?php  } ?>
  </strong></td>
  <td align="left" valign="middle"   <?php if ($SWAbonoUsado){echo "bgcolor=\"#FFFF00\""; } ?>  <?php if (!$SWAbonoUsado) echo ' class="FondoCampo"'; ?> >
 
 
 
    
  <form id="form9" name="form<?php echo $formi++; ?>" method="post" action="Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>&Codigo=<?php echo $row_RS_ContableMov_Procesando['Codigo']; ?>&Recibo=<?php echo $row_RS_ContableMov_Procesando['CodigoRecibo']; ?>">
    <p><input name="hora" type="hidden" value="<?php echo $Hora; ?>" />
      <?php 

if(strpos($row_RS_del_Banco['Descripcion'],"CH")>0){
echo "Cheque";

$Dif = strtotime(date('Y-m-d'))-strtotime($row_RS_del_Banco['Fecha']);
$Dif = $Dif/(3600*24);

echo " (".$Dif.")";

}



if(strpos($row_RS_del_Banco['Descripcion'],"CH")>0 and $Dif>6 or strpos($row_RS_del_Banco['Descripcion'],"CH")==0 or $MM_Username == "piero")	

							
if ($row_RS_ContableMov_Procesando['MontoHaber'] <= $saldo ) { //or $row_RS_ContableMov_Procesando['MontoHaber']>100000


?>
      
      <?php 

if ($Facturacion_Activa and $valido and false ){  //  and $MM_Username == "piero"
	echo $Dif; // Dias cuando cheque	
	$Value = "PROCESAR ";
	if ($row_RS_ContableMov_Procesando['MontoHaber'] == $saldo) { 
		$Color = "success ";} 
	else{
		$Color = "primary ";}	
		$Value .= Fnum($MontoIngresado);
		?>
        
<button type="submit" class="btn btn-<?= $Color ?> btn-sm"  onclick="this.disabled=true;this.form.submit();"> <?= $Value ?></button>
        
      
      <?php } else { ?>
      Forma de Pago no válida
      <?php } 

} 
	elseif($row_RS_ContableMov_Procesando['MontoHaber_Dolares'] < 1) { 
	
	echo "Monto superior a la deuda pendiente";

} ?>
      <?php echo substr($row_RS_ContableMov_Procesando['RegistradoPor'],0,15); ?><br>
      
      </p>
  </form>
  <?php //} ?>
  <?php if ($SWAbonoUsado){ ?>
  <font color="#FF0000"><strong><img src="../../../i/exclamation.png" width="32" height="32" alt=""/> Parcial</strong></font>
  <?php } ?>
  <?php if($Tipo == 7 ) {?>
    <img src="../../../i/creditcards.png" width="32" height="32" alt=""/>
    <?php } elseif($Tipo == 6 ) { ?>
    <img src="../../../i/card_debit.png" width="32" height="32" alt=""/>
    <?php } ?></td>
</tr>
<!--tr>
  <td colspan="5" class="NombreCampoTopeWin"><img src="../../../i/b.png" width="1" height="4" alt=""/></td>
  </tr-->
<?php } while ($row_RS_ContableMov_Procesando = $RS_ContableMov_Procesando->fetch_assoc()); ?>

<tr><td>&nbsp;</td><td align="right">&nbsp;<?= Fnum($SumaDePagos) ?></td>
  <td align="right">&nbsp;<?= Fnum($SumaDePagos - $saldo) ?></td>
  <td>&nbsp;</td><td>&nbsp;</td></tr>
</table>
<?php } // Show if recordset not empty ?><br>

<script>
$(document).ready(function() {
	$("#ActualizaPagos").on("click",function(e){
	    e.preventDefault();
		$("#PagosProcesando").load("Cobranza/PagosProcesando.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>");
	});

});
</script>
</div>