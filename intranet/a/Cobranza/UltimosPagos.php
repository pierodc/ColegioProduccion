<?php 

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
<caption>Últimos Pagos</caption>


<? while ($row = $RS->fetch_assoc() and $No++ < 10) { 
		extract($row);
?>
	<tr <? $sw=ListaFondo($sw,$Verde);  ?>>
	  <td nowrap="nowrap" >&nbsp;<?= DDMMAAAA($Fecha); ?></td>
	  <td nowrap="nowrap" >&nbsp;<?= FormaDePago($Tipo); ?></td>
	  <td nowrap="nowrap" >&nbsp;<? 
	
			echo $BancoOrigen; 
			echo " -> "; 
			if($CodigoCuenta == 1) {
				echo "Merc";}
			if($CodigoCuenta == 2) {
				echo "Prov";}


									 ?></td>
	  <td nowrap="nowrap" >&nbsp;<?= $Referencia; ?></td>
	  <td  >&nbsp;<?= $Observaciones; ?></td>
	  <td  align="right" nowrap="nowrap" >&nbsp;<?= Fnum($MontoHaber_Dolares); ?></td>
	  <td  align="right" nowrap="nowrap" >&nbsp;<?= Fnum($MontoHaber); ?></td>
	  <td  align="right" nowrap="nowrap" >&nbsp;<?= substr($RegistradoPor,0,strpos($RegistradoPor."@","@")) ; ?></td>
	</tr>

<? } ?>

</table>
<?php } // Show if recordset not empty ?><br>
