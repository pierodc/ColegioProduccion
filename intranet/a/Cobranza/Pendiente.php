<div id="Pendiente">

<?php 
//$MM_authorizedUsers = "99,91,95,90";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

//echo $_SERVER['DOCUMENT_ROOT'];
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


// Movimientos PENDIENTE
$colname_RS_ContableMov = "-1";
if (isset($_GET['CodigoPropietario'])) {
  $colname_RS_ContableMov = $_GET['CodigoPropietario'];
}



	
ActulizaEdoCuentaDolar($CodigoAlumno , $Cambio_Dolar); //




$query_RS_ContableMov = sprintf("SELECT * FROM ContableMov, Alumno WHERE 
									Alumno.CodigoAlumno = ContableMov.CodigoPropietario AND 
									Alumno.CodigoAlumno = $CodigoAlumno AND 
									ContableMov.SWCancelado = '0' AND
									(ContableMov.MontoDebe > 0 OR ContableMov.MontoDebe_Dolares > 0)
									ORDER BY SW_Prioridad DESC, MontoHaber DESC, ContableMov.Fecha ASC, ContableMov.Codigo ASC", GetSQLValueString($colname_RS_ContableMov, "text"));
echo $Insp ?  $query_RS_ContableMov." (8)<br>" : "";
$RS_ContableMov = $mysqli->query($query_RS_ContableMov);

$totalRows_RS_ContableMov = $RS_ContableMov->num_rows;


?>

<table border="1" class="hoverable" >
	<caption>Pendiente</caption>
      <tbody>
            <tr>
              <th>&nbsp;</th>
              <th>Prioridad</th>
              <th>Fecha Vence</th>
              <th>Descripci&oacute;n</th>
              <th>Divi</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
              <th width="50">Base</th>
              <th width="50">Iva <?= $P_IVA_2 ."%"; ?></th>
              <th width="50">Total</th>
              <th width="50">Abonos</th>
              <th width="23">Saldo Mes</th>
              <th width="25">Saldo Pend.</th>
            </tr>
            <?php  
			 $saldo=0; 
			
			 
			 $ReferenciaMesAno_Anterior = $row_RS_ContableMov['ReferenciaMesAno'] ;
			 if($row_RS_ContableMov = $RS_ContableMov->fetch_assoc())
			 do { 
			 	extract($row_RS_ContableMov);
				$NumMov++;
				$MontoDebe=$MontoDebe-$MontoAbono;
				
				if($row_RS_ContableMov['SWiva'] == 1) 
					$MontoIVA = round($MontoDebe*$P_IVA_2/100 , 2);
				else
					$MontoIVA = "";
				
				
				
				 if ($ReferenciaMesAno_Anterior <> $row_RS_ContableMov['ReferenciaMesAno']) {
					  if($In==''){
						  $In = "In";}
					  else{
						  $In = ""; }
				   }
			  //$Par = true;
			  
			//if ($totalRows_RS_ContableMov > 0) { // Show if recordset not empty ?>
        
        
<?php if($ReferenciaMesAno_Anterior <> $row_RS_ContableMov['ReferenciaMesAno'] 
			and $ReferenciaMesAno_Anterior > "") { ?>
<tr >
    <td colspan="13" align="center" <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
    <td align="right" <?php //echo $Etiqueta_Class ?>><div onclick="form1.MontoHaber.value='<?php echo $SaldoMes ?>';form_divide1.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide2.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide3.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide4.Monto_divide.value='<?php echo $SaldoMes ?>';"><?php echo Fnum($SaldoMes); ?></div></td>
    <td align="right" <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
</tr>            
<?php $SaldoMes = 0; } 
			
if($ReferenciaMesAno_Anterior > ""){		
?>
<tr >

  <?php 
  
if($row_RS_ContableMov['ReferenciaMesAno']=='0' or $row_RS_ContableMov['ReferenciaMesAno']==''){
	$Azul = 'Azul';}
else{
	$Azul = '';}
       
$Etiqueta_Class =  ' class="Listado'.$In.'Par'.$Azul.'"';
   
       ?>
  
  <td align="center" <?php //echo $Etiqueta_Class ?>><?php 
  if ( $row_RS_ContableMov['MontoAbono'] < 1 or $MM_Username=="piero") { 
  ?><iframe src="Procesa.php?bot_EliminarMov=1&Codigo=<?php echo $row_RS_ContableMov['Codigo']; ?>" seamless width="25" height="22" frameborder="0" ></iframe><?php } 
  //if($MM_Username == "piero"){ echo $row_RS_ContableMov['Codigo'];} ?></td>
  <td align="center" nowrap="nowrap" <?php //echo $Etiqueta_Class ?>><iframe src="Procesa.php?bot_PrioridadMov=<?php echo $row_RS_ContableMov['SW_Prioridad']; ?>&Codigo=<?php echo $row_RS_ContableMov['Codigo']; ?>" seamless width="25" height="22" frameborder="0" ></iframe><?php echo $row_RS_ContableMov['SW_Prioridad']; ?></td>
  <td align="center" nowrap="nowrap" <?php //echo $Etiqueta_Class ?>><?php echo date('d-m-Y', strtotime($row_RS_ContableMov['Fecha']));  ?>
  <?php //echo $row_RS_ContableMov['FechaIngreso'];  ?></td>
  <td <?php //echo $Etiqueta_Class ?>><?php 
  
  if($UltimoCodigoAsignacion3 == $row_RS_ContableMov['Referencia'])
  	echo "<B>";
  
  echo $row_RS_ContableMov['Descripcion']; 
  
  
   ?></td>
  <td <?php //echo $Etiqueta_Class ?>><?php echo  Mes_Ano ($row_RS_ContableMov['ReferenciaMesAno']);  ?></td>
  <td <?php //echo $Etiqueta_Class ?>><? 
	   
	$Total_Renglon = $row_RS_ContableMov['MontoDebe_Dolares'];
	echo Fnum($Total_Renglon); 
	
	if ($row_RS_ContableMov['MontoAbono_Dolares'] > 0){
		echo " - (". Fnum($row_RS_ContableMov['MontoAbono_Dolares']) . " = ". Fnum($row_RS_ContableMov['MontoDebe_Dolares'] - $row_RS_ContableMov['MontoAbono_Dolares']) ." )"; 
		
		$Total_Renglon = $row_RS_ContableMov['MontoDebe_Dolares'] - $row_RS_ContableMov['MontoAbono_Dolares'];

	}
	
	
	  ?></td>
  <td <?php //echo $Etiqueta_Class ?>><?  
	  
		 	$IVA_Dolares = round($Total_Renglon  *  $row_RS_ContableMov['SWiva'] * $P_IVA_2/100 ,2);
			echo ( $IVA_Dolares );
		
	$Total_Renglon += $IVA_Dolares;
	$SubTotal_Dolares += $Total_Renglon;
		  
	  
	  ?></td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?= Fnum($SubTotal_Dolares) ?></td>
  <td <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?= Fnum($MontoDebe); ?></td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?= Fnum($MontoIVA); ?></td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?= Fnum($MontoDebe+$MontoIVA)?></td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?php 
		if($row_RS_ContableMov['MontoAbono'] > 0) {
			$MontoAbonado = round($row_RS_ContableMov['MontoAbono']+($row_RS_ContableMov['SWiva']*$row_RS_ContableMov['MontoAbono']*($P_IVA_2)/100),2);
			echo "<".Fnum($MontoAbonado).">";} ?>
  <?php 
 /* 
if($row_RS_ContableMov['MontoHaber']>0) 
if($row_RS_ContableMov['SWValidado']=='1') {
echo $row_RS_ContableMov['MontoHaber'];}
else{
echo "(".$row_RS_ContableMov['MontoHaber'].")";}

*/ ?></td>
  <td align="right" <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
  <td align="right" <?php //echo $Etiqueta_Class ?>><?php
  
  // $saldo = round($saldo + $MontoDebe + $MontoIVA - $row_RS_ContableMov['MontoAbono'],2) ; 				
   //$SaldoMes += round( $MontoDebe + $MontoIVA - $row_RS_ContableMov['MontoAbono'],2) ;
   $saldo = round($saldo + $MontoDebe + $MontoIVA ,2) ; 				
   $SaldoMes += round( $MontoDebe + $MontoIVA ,2) ;
   
   ?>
    <div onClick="form1.MontoHaber.value='<?php echo $saldo ?>';form_divide1.Monto_divide.value='<?php echo $saldo ?>';form_divide2.Monto_divide.value='<?php echo $saldo ?>';form_divide3.Monto_divide.value='<?php echo $saldo ?>';form_divide4.Monto_divide.value='<?php echo $saldo ?>';">
      <?php   echo Fnum($saldo);  ?>
  </div></td>
</tr>
            <?php } ?>
            
            <?php //} // Show if recordset not empty ?>
            <?php 
		// if ($ReferenciaMesAno_Anterior <> $row_RS_ContableMov['ReferenciaMesAno']) {
		//	$ReferenciaMesAno_Anterior = $row_RS_ContableMov['ReferenciaMesAno'];}
			
			   
			
			$ReferenciaMesAno_Anterior = $row_RS_ContableMov['ReferenciaMesAno'] ;
			
			}  while ($row_RS_ContableMov = $RS_ContableMov->fetch_assoc());
			
			?>
<tr >
    <td colspan="13" align="center" <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
    <td align="right" <?php //echo $Etiqueta_Class ?>><div onclick="form1.MontoHaber.value='<?php echo $SaldoMes ?>';form_divide1.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide2.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide3.Monto_divide.value='<?php echo $SaldoMes ?>';form_divide4.Monto_divide.value='<?php echo $SaldoMes ?>';"><?php echo Fnum($SaldoMes); ?></div></td>
    <td align="right" <?php //echo $Etiqueta_Class ?>>&nbsp;</td>
</tr>   



            <tr>
              <td colspan="12" align="right">
                <?php 
			  
	$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno, Representante 
						WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
						AND RepresentanteXAlumno.SW_Representante = '1'
						AND (RepresentanteXAlumno.Nexo = 'Padre' OR RepresentanteXAlumno.Nexo = 'Madre')
						AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
	$RS_Repre = $mysqli->query($query_RS_Repre);
	$totalRows_RS_Repre = $RS_Repre->num_rows;
	$para = "";
	if($totalRows_RS_Repre > 0){
	while ($row_RS_Repre = $RS_Repre->fetch_assoc()) {
		if($row_RS_Repre['Email1']>' '){
			$para .= $row_RS_Repre['Email1'].',';
		}
	} }
			  
			  
			  ?>
              <a href="mailto:<?php echo $para; ?>?Subject=Mensaje de Caja" target="_blank">Email General</a>
                | <iframe src="Aviso_de_Cobro_Email.php?porAlumno=1&<?php echo "CodigoAlumno=".$CodigoAlumno; ?>" width="40" height="40" scrolling="no" frameborder="0" seamless></iframe> 
                | <iframe src="/intranet/a/sms_caja.php?SoloBot=1&CodigoAlumno=<?php echo $CodigoAlumno; ?>" width="40" height="40" frameborder="0"></iframe> |
<?php 
// Busca todos los recibos
$query_Recibos = "SELECT * FROM Recibo 
					WHERE CodigoPropietario = $CodigoAlumno 
					ORDER BY CodigoRecibo DESC";//echo $query_Recibos;
$Recibos = $mysqli->query($query_Recibos);
$row_Recibos = $Recibos->fetch_assoc();
$totalRows_Recibos = $Recibos->num_rows;
if(	$totalRows_Recibos>0) { ?>
                <a href="../Recibo.php<?php echo "?CodigoClave=".$_GET['CodigoPropietario']."&Codigo=".$row_Recibos['CodigoRecibo']; ?>" target="_blank">Imprimir &uacute;ltimo recibo</a> | 
                
                
                
                <?php  }?>
              </span></td>
              <td colspan="3" align="right" valign="top" nowrap="nowrap" bgcolor="#cccccc" class="MensajeDeError"><strong>Pendiente:</strong><strong> <?php echo Fnum($saldo);

// Actualiza Deuda_Actual en alumno			  
$sql = "UPDATE Alumno 
		SET Deuda_Actual='".$saldo."' 
		WHERE CodigoAlumno = ".$CodigoAlumno;
$mysqli->query($sql);			  
			  
			  ?></strong></td>
            </tr>
            
            </tbody>
          </table>



<script>
$(document).ready(function() {
	$("#ActualizaP").on("click",function(e){
	    e.preventDefault();
		$("#Pendiente").load("Cobranza/Pendiente.php?CodigoPropietario=<?php echo $_GET['CodigoPropietario']; ?>");
	});

});
</script>
</div>