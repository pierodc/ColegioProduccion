<div id="UltimosPagos"><?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
//header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

//echo $CodigoAlumno;
$sql = "SELECT * FROM ContableMov 
			WHERE CodigoPropietario = '$CodigoAlumno' 
			AND (MontoHaber > 0 
			OR MontoHaber_Dolares > 0 ) 
			AND CodigoRecibo <> 0 
			ORDER BY Fecha DESC, Codigo DESC, Codigo ASC";

$RS = $mysqli->query($sql);

	

											

if ($RS->num_rows > 0) { // Show if recordset not empty 


?><table class="sombra">
<tr>
  <td  colspan="8" class="subtitle">Últimos Pagos</td>
</tr>

<? while ($row = $RS->fetch_assoc() and $No++ < 10) { 
		extract($row);
?>
	<tr <? $sw=ListaFondo($sw,$Verde);  ?>>
	  <td width="100" nowrap="nowrap" >&nbsp;<?= DDMMAAAA($Fecha); ?></td>
	  <td width="100" nowrap="nowrap" >&nbsp;<?= FormaDePago($Tipo); ?></td>
	  <td width="300" nowrap="nowrap" >&nbsp;<? 
	
			echo $BancoOrigen; 
			echo " -> "; 
			if($CodigoCuenta == 1) {
				echo "Merc";}
			if($CodigoCuenta == 2) {
				echo "Prov";}


									 ?></td>
	  <td width="300" nowrap="nowrap" >&nbsp;<?= $Referencia; ?></td>
	  <td width="300" nowrap="nowrap" >&nbsp;<?= $Observaciones; ?></td>
	  <td width="49" align="right" nowrap="nowrap" >&nbsp;<?= Fnum($MontoHaber_Dolares); ?></td>
	  <td width="49" align="right" nowrap="nowrap" >&nbsp;<?= Fnum($MontoHaber); ?></td>
	  <td width="49" align="right" nowrap="nowrap" >&nbsp;<?= substr($RegistradoPor,0,strpos($RegistradoPor."@","@")) ; ?></td>
	</tr>

<? } ?>

</table>
<?php } // Show if recordset not empty ?><br>
</div>