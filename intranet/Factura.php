<?php 
$MM_authorizedUsers = "";
require_once('../inc_login_ck.php'); 
require_once('../Connections/bd.php'); 
require_once('a/archivo/Variables.php'); 
require_once('../inc/rutinas.php'); 

mysql_select_db($database_bd, $bd);
// Busca ALUMNO
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);
extract($row_RS_Alumno);

// Busca RECIBO (seniat O no formal)
$colname_RS_Recibo = "-1";
if (isset($_GET['Codigo'])) {
  $colname_RS_Recibo = $_GET['Codigo'];
}
$query_RS_Recibo = sprintf("SELECT * FROM Recibo WHERE CodigoRecibo = %s", GetSQLValueString($colname_RS_Recibo, "int"));
$RS_Recibo = mysql_query($query_RS_Recibo, $bd) or die(mysql_error());
$row_RS_Recibo = mysql_fetch_assoc($RS_Recibo);
$totalRows_RS_Recibo = mysql_num_rows($RS_Recibo);

// Busca los CARGOS
$query_RS_Mov_Contable_debe = "SELECT * FROM ContableMov 
								WHERE CodigoPropietario = $CodigoAlumno 
								AND MontoDebe > 0 
								AND CodigoRecibo = ".$_GET['Codigo']." 
								ORDER BY CodigoRecibo ASC, Fecha ASC, Codigo ASC"; 
$RS_Mov_Contable_debe = mysql_query($query_RS_Mov_Contable_debe, $bd) or die(mysql_error());
$row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe);
$totalRows_RS_Mov_Contable_debe = mysql_num_rows($RS_Mov_Contable_debe);

do{
	
	
	echo "...";
	}while(false);

// Busca el PAGO
$query_RS_Mov_Contable_haber = "SELECT * FROM ContableMov, ContableCuenta 
								WHERE ContableMov.CodigoCuenta = ContableCuenta.CodigoCuenta 
								AND CodigoPropietario = $CodigoAlumno 
								AND MontoHaber > 0 
								AND CodigoRecibo = ".$_GET['Codigo'];
//echo $query_RS_Mov_Contable_haber;						
$RS_Mov_Contable_haber = mysql_query($query_RS_Mov_Contable_haber, $bd) or die(mysql_error());
$row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber);
$totalRows_RS_Mov_Contable_haber = mysql_num_rows($RS_Mov_Contable_haber);

if($row_RS_Mov_Contable_haber['CodigoReciboCliente']>0){
	$sql = "SELECT * FROM ReciboCliente
			WHERE Codigo = ".$row_RS_Mov_Contable_haber['CodigoReciboCliente'];
//			echo $sql;
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	$Fac_Rif = $row['RIF'];
	$Fac_Nombre = $row['Nombre'];
	$Fac_Direccion = $row['Direccion'];
	$Fac_Telefono = $row['Telefono'];
	}

$SW_Actualiza_Base = false;
if($row_RS_Recibo['NumeroFactura'] == 0){
	//Busca Num Max de Factura
	$sql = "SELECT MAX(NumeroFactura) AS NumFacMax FROM Recibo";
	$query = mysql_query($sql, $bd) or die(mysql_error());
	$row_query = mysql_fetch_assoc($query);
	$NumeroFacturaProx = $row_query['NumFacMax']+1;
	
	$sql = "SELECT MAX(Fac_Num_Control) AS NumControlMax FROM Recibo";
	$query = mysql_query($sql, $bd) or die(mysql_error());
	$row_query = mysql_fetch_assoc($query);
	$NumeroControlProx = $row_query['NumControlMax']+1;
	
	
	$sql = "UPDATE Recibo SET NumeroFactura = $NumeroFacturaProx, Fac_Num_Control = $NumeroControlProx, FechaImpFactura=NOW(), Fecha=NOW(), FacturaImpPor= '".$MM_Username."', ";
	$sql .= "Fac_Rif='$Fac_Rif', Fac_Nombre='$Fac_Nombre', Fac_Direccion='$Fac_Direccion', Fac_Telefono='$Fac_Telefono' ";
	$sql .= "WHERE CodigoRecibo = $colname_RS_Recibo";
	
	$query = mysql_query($sql, $bd) or die(mysql_error());
	$SW_Actualiza_Base = true;
	
	$RS_Recibo = mysql_query($query_RS_Recibo, $bd) or die(mysql_error());
	$row_RS_Recibo = mysql_fetch_assoc($RS_Recibo);
	$totalRows_RS_Recibo = mysql_num_rows($RS_Recibo);
}

/*
$query_Asignaciones =  "SELECT  AsignacionXAlumno.*, Asignacion.* FROM AsignacionXAlumno, Asignacion WHERE AsignacionXAlumno.CodigoAsignacion = Asignacion.Codigo AND CodigoAlumno = ".$CodigoAlumno. " ORDER BY Orden";
$Asignaciones = mysql_query($query_Asignaciones, $bd) or die(mysql_error());
$row_Asignaciones = mysql_fetch_assoc($Asignaciones);
$totalRows_Asignaciones = mysql_num_rows($Asignaciones);
*/
$BaseImponible = 0;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>RECIBO</title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" /></head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" <?php 
//echo ' onLoad="window.print();'; 
//if($MM_Username != "piero")
	//echo ' window.close()"'; ?>>

<table width="600" height="400" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" nowrap="nowrap"><p><strong><br />
              <br />
              </strong></p>
            <p><strong><br />
              </strong><br />          
            </p></td>
          <td align="left" nowrap="nowrap"><strong><br />
            <br />
            <br />
          </strong><br /></td>
          <td align="right" valign="top" nowrap="nowrap" ><br />
            <br />
            <br /></td>
        </tr>
        <tr>
          <td align="left" nowrap="nowrap"><strong> Cliente:</strong> <?php echo $Fac_Nombre; ?><br />
<strong>Direcci&oacute;n:</strong> <?php echo $Fac_Direccion; ?></td>
          <td align="left" nowrap="nowrap"><strong>RIF: </strong><?php echo $Fac_Rif; ?><br />
          <strong>Tel&eacute;fono:</strong> <?php echo $Fac_Telefono; ?></td>
          <td align="right" valign="top" nowrap="nowrap" ><strong>Factura No.</strong> <?php echo substr("0000000".$row_RS_Recibo['NumeroFactura'], -6) ; ?><br />
            <strong>Fecha:</strong> <?php echo date( "d-m-Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y"))); ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" ><strong>Alumno:</span></strong> <?php echo $row_RS_Alumno['Apellidos']." ".$row_RS_Alumno['Apellidos2'].", ".$row_RS_Alumno['Nombres']." ".$row_RS_Alumno['Nombres2']; ?>&nbsp;(<?php echo $row_RS_Alumno['CodigoAlumno'] ?>)</td>
              <td colspan="2" align="right" ><strong>Curso:</span></strong> <?php echo Curso($row_RS_Alumno['CodigoCurso']); ?></td>
            </tr>
            <tr>
              <td ><strong>Concepto</strong></span></td>
              <td >&nbsp;</td>
              <td width="100" align="center" ><strong>IVA</strong></span></td>
              <td width="100" align="right" ><strong>Monto</strong></span></td>
            </tr>
            
                <?php 
  $total=0; if($totalRows_RS_Mov_Contable_debe > 10 ){$Mini="Mini";}
  do { ?>
                  <tr>
                    <td width="270" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo $row_RS_Mov_Contable_debe['Descripcion']; ?></td>
                  <td  nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo  Mes_Ano ($row_RS_Mov_Contable_debe['ReferenciaMesAno']);  ?></td>
                  <td width="100" align="center" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				
				echo $row_RS_Mov_Contable_debe['SWiva'] == 1? "12%" : "(E)" ; ?></td>
                  <td width="100" align="right" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				$auxMontoNeto = round($row_RS_Mov_Contable_debe['MontoDebe']- $row_RS_Mov_Contable_debe['MontoAbono'] , 2);
				$totMontoNeto += $auxMontoNeto;

				$porcentajeIVA = $row_RS_Mov_Contable_debe['SWiva'] == 1? 0.12 : 0 ; 
				
				$auxMontoBase = round($auxMontoNeto / (1 + $porcentajeIVA) , 2);
				$totMontoBase += $auxMontoBase;
				
				$BaseImponible +=  $row_RS_Mov_Contable_debe['SWiva'] == 1? $auxMontoBase : 0 ;
				
				$auxMontoIVA = round($auxMontoBase * $row_RS_Mov_Contable_debe['SWiva'] * $porcentajeIVA , 2);
				$totMontoIVA += $auxMontoIVA;
				
				echo Fnum($auxMontoBase); 
				$total+=$auxMonto; 
				
				
				?></td>
                </tr>
<?php } while ($row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe)); 	?>
                <?php 	  
		mysql_data_seek($RS_Mov_Contable_debe, 0);
	    $row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe); ?>

                
           
            <tr>
              <td colspan="2"  align="right" >Base Exenta BsF 
              <?php 
			  $BaseExenta = $totMontoBase - $BaseImponible;
			  echo Fnum($BaseExenta); ?></td>
              <td width="100" align="right" >Sub Total</td>
              <td width="100" align="right" ><?php echo Fnum($totMontoBase); ?></td>
        </tr>
            <tr>
              <td colspan="2" align="right" >Base Imponible BsF <?php echo Fnum($BaseImponible); ?></td>
              <td align="right">IVA 12%</td>
              <td align="right" ><?php echo Fnum($totMontoIVA); ?></td>
            </tr>
            <tr>
              <td colspan="2" align="left" >Forma de Pago: CONTADO</td>
              <td align="right" ><strong>Total Bs.</strong></strong></td>
              <td align="right" ><?php echo Fnum($totMontoNeto); ?></td>
            </tr>
    </table></td>
  </tr>

  <tr valign="bottom">
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">

      
            <?php do { ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==4){ ?>
                <tr>
                  <td nowrap="nowrap" class="ReciboRenglon">Pagado en Efectivo: Monto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?></td>
                  <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
                  Firma</td>
                </tr>
<?php } ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==3){ ?>
                <tr>
                  <td nowrap="nowrap" class="ReciboRenglon"> Cheque:Banco: <?php echo $row_RS_Mov_Contable_haber['ReferenciaBanco'] ?>N&uacute;m: <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?> Mto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?></td>
                  <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
                    Firma</td>
                </tr>
<?php } ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==1 or $row_RS_Mov_Contable_haber['Tipo']==2){ ?>
              <tr>
              <td nowrap="nowrap" class="ReciboRenglon"><?php echo FormaDePago($row_RS_Mov_Contable_haber['Tipo']); ?> / Banco: 
              <?php 
			
			if( $row_RS_Mov_Contable_haber['CodigoCuenta']==1){ echo "Mercantil";}
			elseif ( $row_RS_Mov_Contable_haber['CodigoCuenta']==2){ echo "Provincial";}
			
			
			?>              <br />
              N&uacute;m: <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?> / Mto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?> / <?php echo DDMMAAAA($row_RS_Mov_Contable_haber['Fecha']); ?></td>
            <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
              Firma</td>
          </tr>
<?php } ?>
<?php } while ($row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber)); ?>
            <?php mysql_data_seek($RS_Mov_Contable_haber, 0);
	  $row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber); ?>
        
</table></td>
  </tr>
</table>




<p>&nbsp;</p>
<p>&nbsp;<?php 

if($SW_Actualiza_Base){
	$sql = "UPDATE Recibo SET Base_Imp = '$BaseImponible', Base_Exe = '$BaseExenta', Monto_IVA='$totMontoIVA' , Total='$totMontoNeto' ";
	$sql .= "WHERE CodigoRecibo = $colname_RS_Recibo";
	$query = mysql_query($sql, $bd) or die(mysql_error());
}
















 $totMontoBase=0;
 $totMontoBase=0; 
 $BaseExcenta = 0;
 $BaseImponible=0; 
 $totMontoIVA=0; 
 $totMontoNeto=0;   
 
 ?><br />&nbsp;<br />&nbsp;</p>
<p>&nbsp;</p>
<table width="600" height="395" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="left" nowrap="nowrap"><p><strong><br />
              <br />
              </strong></p>
            <p>&nbsp;</p>
            <p><strong><br />
              </strong><br />          
            </p></td>
          <td align="left" nowrap="nowrap"><strong><br />
            <br />
            <br />
          </strong><br /></td>
          <td align="right" valign="top" nowrap="nowrap" ><br />
            <br />
            <br /></td>
        </tr>
        <tr>
          <td align="left" nowrap="nowrap"><strong> Cliente:</strong> <?php echo Titulo($Fac_Nombre); ?><br />
<strong>Direcci&oacute;n:</strong> <?php echo Titulo($Fac_Direccion); ?></td>
          <td align="left" nowrap="nowrap"><strong>RIF: </strong><?php echo $Fac_Rif; ?><br />
          <strong>Tel&eacute;fono:</strong> <?php echo $Fac_Telefono; ?></td>
          <td align="right" valign="top" nowrap="nowrap" ><br />
            <strong>Fecha:</strong><?php echo date( "d-m-Y", mktime(0, 0, 0, date("m")  , date("d"), date("Y"))); ?></td>
        </tr>
        <tr>
          <td align="left" nowrap="nowrap">&nbsp;</td>
          <td align="left" nowrap="nowrap">&nbsp;</td>
          <td align="right" valign="top" nowrap="nowrap" ><strong>Factura No.</strong> <?php echo substr("0000000".$row_RS_Recibo['NumeroFactura'], -6) ; ?></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" ><strong>Alumno:</span></strong> <?php echo $row_RS_Alumno['Apellidos']." ".$row_RS_Alumno['Apellidos2'].", ".$row_RS_Alumno['Nombres']." ".$row_RS_Alumno['Nombres2']; ?>&nbsp;(<?php echo $row_RS_Alumno['CodigoAlumno'] ?>)</td>
              <td colspan="2" align="right" ><strong>Curso:</span></strong> <?php echo Curso($row_RS_Alumno['CodigoCurso']); ?></td>
            </tr>
            <tr>
              <td ><strong>Concepto</strong></span></td>
              <td >&nbsp;</td>
              <td width="100" align="center" ><strong>IVA</strong></span></td>
              <td width="100" align="right" ><strong>Monto</strong></span></td>
            </tr>
            
                <?php 
  $total=0; if($totalRows_RS_Mov_Contable_debe > 8 ){$Mini="Mini";}
  do { ?>
                  <tr>
                    <td width="270" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo $row_RS_Mov_Contable_debe['Descripcion']; ?></td>
                  <td  nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php echo  Mes_Ano ($row_RS_Mov_Contable_debe['ReferenciaMesAno']);  ?></td>
                  <td width="100" align="center" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				
				echo $row_RS_Mov_Contable_debe['SWiva'] == 1? "12%" : "(E)" ; ?></td>
                  <td width="100" align="right" nowrap class="ReciboRenglon<?php echo $Mini ?>"><?php 
				
				$auxMontoNeto = round($row_RS_Mov_Contable_debe['MontoDebe']- $row_RS_Mov_Contable_debe['MontoAbono'] , 2);
				$totMontoNeto += $auxMontoNeto;

				$porcentajeIVA = $row_RS_Mov_Contable_debe['SWiva'] == 1? 0.12 : 0 ; 
				
				$auxMontoBase = round($auxMontoNeto / (1 + $porcentajeIVA) , 2);
				$totMontoBase += $auxMontoBase;
				
				$BaseImponible +=  $row_RS_Mov_Contable_debe['SWiva'] == 1? $auxMontoBase : 0 ;
				
				$auxMontoIVA = round($auxMontoBase * $row_RS_Mov_Contable_debe['SWiva'] * $porcentajeIVA , 2);
				$totMontoIVA += $auxMontoIVA;
				
				echo Fnum($auxMontoBase); 
				$total+=$auxMonto; 
				
				
				?></td>
                </tr>
<?php } while ($row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe)); 	?>
                <?php 	  
		mysql_data_seek($RS_Mov_Contable_debe, 0);
	    $row_RS_Mov_Contable_debe = mysql_fetch_assoc($RS_Mov_Contable_debe); ?>

                
           
            <tr>
              <td colspan="2"  align="right" >Base Exenta BsF
              <?php 
			  $BaseExenta = $totMontoBase - $BaseImponible;
			  echo Fnum($BaseExenta); ?></td>
              <td width="100" align="right" >Sub Total</td>
              <td width="100" align="right" ><?php echo Fnum($totMontoBase); ?></td>
        </tr>
            <tr>
              <td colspan="2" align="right" >Base Imponible BsF <?php echo Fnum($BaseImponible); ?></td>
              <td align="right">IVA 12%</td>
              <td align="right" ><?php echo Fnum($totMontoIVA); ?></td>
            </tr>
            <tr>
              <td colspan="2" align="left" >Forma de Pago: CONTADO</td>
              <td align="right" ><strong>Total Bs.</strong></strong></td>
              <td align="right" ><?php echo Fnum($totMontoNeto); ?></td>
            </tr>
    </table></td>
  </tr>

  <tr valign="bottom">
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">

      
            <?php do { ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==4){ ?>
                <tr>
                  <td nowrap="nowrap" class="ReciboRenglon">Pagado en Efectivo: Monto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?></td>
                  <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
                  Firma</td>
                </tr>
<?php } ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==3){ ?>
                <tr>
                  <td nowrap="nowrap" class="ReciboRenglon">Cheque:Banco: <?php echo $row_RS_Mov_Contable_haber['ReferenciaBanco'] ?> / N&uacute;m: <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?> / Mto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?></td>
                  <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
                  Firma</td>
                </tr>
<?php } ?>
<?php if ($row_RS_Mov_Contable_haber['Tipo']==1 or $row_RS_Mov_Contable_haber['Tipo']==2){ ?>
              <tr>
              <td nowrap="nowrap" class="ReciboRenglon"><?php echo FormaDePago($row_RS_Mov_Contable_haber['Tipo']); ?> / Banco: <?php 
			
			if( $row_RS_Mov_Contable_haber['CodigoCuenta']==1){ echo "Mercantil";}
			elseif ( $row_RS_Mov_Contable_haber['CodigoCuenta']==2){ echo "Provincial";}
			
			
			?>                <br />
              N&uacute;m: <?php echo $row_RS_Mov_Contable_haber['Referencia'] ?> / Mto: <?php echo Fnum($row_RS_Mov_Contable_haber['MontoHaber']); ?> / <?php echo DDMMAAAA($row_RS_Mov_Contable_haber['Fecha']); ?><br />
                <span class="ReciboRenglonMini"><?php echo $row_RS_Mov_Contable_haber['FechaIngreso']; ?></span></td>
            <td width="50" align="center" nowrap="nowrap" class="ReciboRenglon">_______________________<br />
              Firma</td>
          </tr>
<?php } ?>
<?php } while ($row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber)); ?>
            <?php mysql_data_seek($RS_Mov_Contable_haber, 0);
	  $row_RS_Mov_Contable_haber = mysql_fetch_assoc($RS_Mov_Contable_haber); ?>
        
</table></td>
  </tr>
</table>


</body>
</html>
<?php
mysql_free_result($RS_Recibo);

mysql_free_result($RS_Alumno);

mysql_free_result($RS_Mov_Contable_debe);

mysql_free_result($RS_Mov_Contable_haber);
?>
