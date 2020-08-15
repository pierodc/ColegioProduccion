<?php 
$MM_authorizedUsers = "99,91,95,90,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$Fecha_RS_Recibos = "-1";
if (isset($_POST['Fecha'])) {
  $Fecha_RS_Recibos = $_POST['Fecha'];
}else{
  $Fecha_RS_Recibos = date('Y-m-d');
}

mysql_select_db($database_bd, $bd);
$query_RS_Recibos = "SELECT * FROM Recibo, ContableMov, Alumno 
						WHERE Recibo.CodigoRecibo = ContableMov.CodigoRecibo 
						AND Recibo.CodigoPropietario = Alumno.CodigoAlumno 
						AND ContableMov.MontoHaber > 0 
						AND Recibo.Fecha = '$Fecha_RS_Recibos' 
						ORDER BY Recibo.NumeroFactura, Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, ContableMov.ReferenciaOriginal ASC";
$RS_Recibos = mysql_query($query_RS_Recibos, $bd) or die(mysql_error());
$row_RS_Recibos = mysql_fetch_assoc($RS_Recibos);
$totalRows_RS_Recibos = mysql_num_rows($RS_Recibos);



$query_RS_Ing_Efectivo_Anterior = "SELECT * FROM ContableMov 
									WHERE Tipo = '4'  
									AND Fecha > '2016-10-15'
									AND Fecha < '$Fecha_RS_Recibos'  
									AND MontoHaber <> 0  ";
//echo $query_RS_Ing_Efectivo_Anterior.'<br>';
$RS_Ing_Efectivo_Anterior = mysql_query($query_RS_Ing_Efectivo_Anterior, $bd) or die(mysql_error());
//echo "Ingresos <br>";
while($row_RS_Ing_Efectivo_Anterior = mysql_fetch_assoc($RS_Ing_Efectivo_Anterior)){
	$Total_Ing_Efectivo_Anterior += $row_RS_Ing_Efectivo_Anterior['MontoHaber'];
	//echo $row_RS_Ing_Efectivo_Anterior['MontoHaber'].' <br> ';
	}
//echo "= $Total_Ing_Efectivo_Anterior<br>";
	
$query_RS_Egr_Efectivo_Anterior = "SELECT * FROM ContableMov 
									WHERE Tipo = '4'
									AND Fecha > '2016-10-15'
									AND Fecha < '$Fecha_RS_Recibos'  
									AND MontoDebe <> 0  ";
/*
$query_RS_Egr_Efectivo_Anterior1 = "SELECT SUM(MontoDebe) AS Salidas, SUM(MontoHaber) AS Entradas 
									FROM ContableMov 
									WHERE Tipo = '4'
									AND Fecha > '2016-10-15'
									AND Fecha < '$Fecha_RS_Recibos'  
									AND MontoDebe <> 0  ";
$RS_Egr_Efectivo_Anterior1 = mysql_query($query_RS_Egr_Efectivo_Anterior1, $bd) or die(mysql_error());
$row_RS_Egr_Efectivo_Anterior1 = mysql_fetch_assoc($RS_Egr_Efectivo_Anterior1);

echo $query_RS_Egr_Efectivo_Anterior1.'<br>';
echo '<br>'.'<br>'.$row_RS_Egr_Efectivo_Anterior1['Salidas'].'<br>'.'<br>';
echo '<br>'.'<br>'.$row_RS_Egr_Efectivo_Anterior1['Entradas'].'<br>'.'<br>';
*/

//echo $query_RS_Egr_Efectivo_Anterior.'<br>';
$RS_Egr_Efectivo_Anterior = mysql_query($query_RS_Egr_Efectivo_Anterior, $bd) or die(mysql_error());
//echo "Egresos <br>";
while($row_RS_Egr_Efectivo_Anterior = mysql_fetch_assoc($RS_Egr_Efectivo_Anterior)){
	$Total_Egr_Efectivo_Anterior += $row_RS_Egr_Efectivo_Anterior['MontoDebe'];
	//echo $row_RS_Egr_Efectivo_Anterior['MontoDebe'].' <br> ';
	}
//echo "= $Total_Egr_Efectivo_Anterior<br>";



if(false){
	$query_RS_Efectivo_Anterior = "SELECT * FROM ContableMov 
									WHERE Tipo = '4'
									AND Fecha > '2016-10-15'
									AND Fecha <= '$Fecha_RS_Recibos'  
									AND (MontoDebe <> 0  OR MontoHaber <> 0)
									ORDER BY Fecha , MontoDebe ";
	echo $query_RS_Efectivo_Anterior;								
	$RS_Efectivo_Anterior = mysql_query($query_RS_Efectivo_Anterior, $bd) or die(mysql_error());
	echo '<table border="1" width="600">';
	while($row_RS_Efectivo_Anterior = mysql_fetch_assoc($RS_Efectivo_Anterior)){
		extract($row_RS_Efectivo_Anterior);
		$SutTotal = $SutTotal + $MontoHaber - $MontoDebe;
		echo '<tr><td align="right" >'.$Fecha .
				'</td><td align="left">'. $Descripcion .
				'</td><td align="right">'. $MontoHaber .
				'</td><td align="right">'. $MontoDebe.
				'</td><td align="right">'.$SutTotal .'</td></tr>';
		}
	echo "</table>";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Diario de Caja</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td ><?php require_once($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/TitAdmin.php'); ?></td>
  </tr>
<tr>
<td >  
<table width="90%" border="0" align="center" cellpadding="3">
  <tr>
    <td colspan="14"><form id="form1" name="form1" method="post" action="">
      <label> <a href="../index.php"><img src="../../../img/home.png" width="25" height="27" border="0" /></a> Fecha:
<?php if(isset($_POST['Fecha'])) {
			$Fecha_aux = $_POST['Fecha'];}
		else{
			$Fecha_aux = date('Y-m-d');}
		?>
      </label>
      <label><input name="Fecha" type="date" value="<?php echo $Fecha_aux ?>" onchange="form.submit();" />
        <input type="submit" name="button" id="button" value="Buscar" />
      </label>
    </form></td>
  </tr>
  <tr class="BoletaMateria">
    <td align="center">No</td>
    <td align="center">Fac No</td>
    <td>(Cod) Alumno</td>
    <td width="80" align="center">Efectivo</td>
    <td width="80" align="center">otro</td>
    <td width="10" align="center">De</td>
    <td width="10" align="center">Tr</td>
    <td width="4" align="center">Ch</td>
    <td width="4" align="center">Tj</td>
    <td width="70" align="center">Fecha</td>
    <td width="85">Banco</td>
    <td width="65">Ref</td>
    <td >Reg</td>
    <td >Proc</td>
  </tr>
  <?php $Ref_anterior='xwz'; ?>
  <?php 
  do {  
  extract($row_RS_Recibos); 
  if($row_RS_Recibos['FechaCreacion'] == $Fecha_aux) $SW_DeHoy = true; else $SW_DeHoy = false;
  ?>
    <tr <?php $sw=ListaFondo($sw , $Verde) ;?>>
      <td align="center"><?= ++$No ?></td>
      <td align="center"><?php echo $NumeroFactura; ?></td>
      <td><?php 
	  if($CodigoPropietarioAnte != $CodigoPropietario){
	  	echo $CodigoPropietario.' '.$Apellidos.' '.$Nombres;}
	  
	   ?>&nbsp;</td>
      <td align="right"><?php  if($Tipo==4){ echo Fnum($MontoHaber); $Efectivo_Dia += $MontoHaber; } ?></td>
      <td align="right"><?php echo $Tipo!=4?Fnum($MontoHaber):""; ?></td>
      <td align="center" <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php if($Tipo==1 and $Ref_anterior<>$Referencia){
		echo "De";
		$Cant_De++;
	  }else{ echo'';}?></td>
      <td align="center" <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php  if($Tipo==2 and $Ref_anterior<>$Referencia){
        echo "Tr";
		$Cant_Tr++;
	  }else{ echo'';}?></td>
      <td align="center" <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php 
	  if($Tipo==3 and $Ref_anterior<>$Referencia){
        echo "Ch";
		$Cant_Ch++;
	  }else{ echo'';}
	  if($Tipo==1 ){$Monto_De+=$MontoHaber;}
	  if($Tipo==2 ){$Monto_Tr+=$MontoHaber;}
	  if($Tipo==3 ){$Monto_Ch+=$MontoHaber;}
	  if($Tipo==4 ){$Cant_Efec+=$MontoHaber;} ?></td>
      <td align="center" <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php 
	  if($Tipo==6 and $Ref_anterior<>$Referencia){
        echo "TD";
	  }
	  if($Tipo==7 and $Ref_anterior<>$Referencia){
        echo "TC";
	  }
	  ?></td>
          <td align="center" nowrap="nowrap" <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php echo DDMMAAAA($Fecha); ?></td>
<td <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php

if($Tipo==5){echo "Ajuste"; $Referencia='xyz';}

if($Ref_anterior == $Referencia){echo 'idem';} 
elseif($CodigoCuenta==1){echo "Merc";}
elseif($CodigoCuenta==2){echo "Prov";}
else{ echo $ReferenciaBanco;} 
?></td>
    <td <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php if( $Ref_anterior<>$Referencia and $Tipo<=3) { echo $Referencia; }elseif($Tipo<=3){ echo 'idem';} $Ref_anterior = $Referencia; ?></td>
    <td <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php echo $RegistradoPor=="auto"?"":substr($RegistradoPor,0,5);  ?></td>
    <td <?php if($MM_Username == $Por){echo'class="BoletaMateria"';} ?> <?php if(!$SW_DeHoy) echo 'class="Italic"'; ?>><?php echo $Por; ?>&nbsp;</td>
    </tr>
    <?php 
	$CodigoPropietarioAnte = $CodigoPropietario;
	} while ($row_RS_Recibos = mysql_fetch_assoc($RS_Recibos)); ?>
    <tr >
      <td colspan="14" align="center">&nbsp;</td>
    </tr>
</table>
<table width="600" border="0" align="center" cellpadding="3">
<?php 

if(  true){
  
  ?>
<tr>
  <td align="left" class="NombreCampoBIG" >Efectivo</td>
  <td align="right" class="NombreCampo" >Haber</td>
  <td align="right" class="NombreCampo">Debe</td>
  <td align="right" class="NombreCampo" >Saldo</td>
</tr>
<tr>
    <td align="right" class="NombreCampoBIG" > Anterior</td>
    <td align="right" class="ListadoPar" >
      <?php 
	$Total_Efectivo_Anterior = $Total_Ing_Efectivo_Anterior - $Total_Egr_Efectivo_Anterior;
	$SaldoEfectivo = $Total_Efectivo_Anterior;
	echo Fnum($Total_Efectivo_Anterior); ?>
    </td>
    <td align="right" class="ListadoPar">&nbsp;</td>
    <td align="right" class="ListadoPar" ><?php echo Fnum($SaldoEfectivo); ?></td>
  </tr>  
<tr>
    <td align="right" class="NombreCampoBIG" > del d&iacute;a</td>
    <td align="right" class="ListadoInPar" >
      <?php 
	$SaldoEfectivo += $Efectivo_Dia;
	echo Fnum($Efectivo_Dia);
	 ?>
    </td>
    <td align="right" class="ListadoInPar">&nbsp;</td>
    <td align="right" class="ListadoInPar" ><?php echo Fnum($SaldoEfectivo); ?></td>
  </tr>  
  <tr>
      <td colspan="4" class="NombreCampoBIG">Egresos</td>
  </tr><?php 
  
$query_RS_Recibos = "SELECT * FROM ContableMov 
					WHERE Tipo = '4'
					AND Descripcion <> 'Abono a cuenta'  
					AND Fecha = '$Fecha_RS_Recibos' 
					ORDER BY FechaIngreso ";
$RS_Recibos = mysql_query($query_RS_Recibos, $bd) or die(mysql_error());
 
  
  while ($row_RS_Recibos = mysql_fetch_assoc($RS_Recibos)){ 
  extract($row_RS_Recibos); ?>
  <tr <?php echo $sw=ListaFondo($sw,$Verde); ?>>
      <td  ><?php echo $Codigo.' '.$Observaciones; ?></td>
      <td align="right" ><?php echo Fnum($MontoHaber) ?></td>
      <td align="right"><?php echo Fnum($MontoDebe) ?></td>
      <td align="right"><?php $SaldoEfectivo = $SaldoEfectivo + $MontoHaber - $MontoDebe; echo Fnum($SaldoEfectivo); ?></td>
  </tr><?php  } } ?>
  <tr>
    <td align="left" colspan="3" class="NombreCampoBIG">Total Efectivo</td>
    <td align="right" nowrap="nowrap" class="nav"><?php echo Fnum($SaldoEfectivo);  ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right"><span class="BoletaNota">Cheques <?php echo "(".$Cant_Ch.") "; ?></span></td>
    <td align="right" ><span class="BoletaNota"><?php echo Fnum($Monto_Ch); ?></span></td>
  </tr>
  <tr>
    <td align="right" colspan="3"><span class="BoletaNota">Depositos <?php echo "(".$Cant_De.") "; ?></span></td>
    <td align="right" nowrap="nowrap" class="BoletaNota"><?php //echo Fnum($Monto_De); ?></td>
  </tr>
  <tr>
    <td colspan="3" align="right" ><span class="BoletaNota">Transferencias <?php echo "(".$Cant_Tr.") "; ?></span></td>
    <td align="right" ><span class="BoletaNota"><?php //echo Fnum($Monto_Tr); ?></span></td>
  </tr>
</table>

</td>
</tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_Recibos);
?>
