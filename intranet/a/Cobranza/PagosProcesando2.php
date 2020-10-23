<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$query_RS_ContableMov_Procesando = "SELECT * FROM ContableMov 
									WHERE CodigoPropietario = '$CodigoAlumno' 
									AND id_Banco > 0
									AND CodigoRecibo = 0 
									ORDER BY Fecha ASC, Codigo ASC";
$RS_ContableMov_Procesando = $mysqli->query($query_RS_ContableMov_Procesando);
$ContableMov_Procesando = $RS_ContableMov_Procesando->fetch_assoc();
$totalRows_RS_ContableMov_Procesando = $RS_ContableMov_Procesando->num_rows;

if ($totalRows_RS_ContableMov_Procesando > 0) {	



$date = new DateTime($ContableMov_Procesando['Fecha']);
$date->modify('-2 month');


if( $ContableMov_Procesando['Tipo'] == 1 or $ContableMov_Procesando['Tipo'] == 2  ){
	$query_en_Banco = "SELECT * FROM Contable_Imp_Todo 
						WHERE Referencia = '".$ContableMov_Procesando['Referencia']."'
						AND Fecha > '". $date->format( 'Y-m-d' )."' 
						AND (MontoHaber > 0)
						";
	$RS_en_Banco = $mysqli->query($query_en_Banco);
	$en_Banco = $RS_en_Banco->fetch_assoc();
}


?><table class="sombra">
	<tr>
		<td>
		<?= DDMMAAAA($ContableMov_Procesando['Fecha']) ?>
		</td>
		<td>
		<?= "Tipo:".$ContableMov_Procesando['Tipo'] ?>
		</td>
		<td>
		<? Campo_Edit ("ContableMov",$ContableMov_Procesando['Codigo'],"MontoHaber_Dolares");  ?>
		<? Campo_Edit ("ContableMov",$ContableMov_Procesando['Codigo'],"Cambio_Dolar"); ?>
		</td>
		<td>
		<?
		$Monto_Dolares_Pago =
			 $ContableMov_Procesando['MontoHaber_Dolares'] * $ContableMov_Procesando['Cambio_Dolar'];
		echo Fnum($Monto_Dolares_Pago);
		?>
		</td>

		<td>
		<? if($Monto_Dolares_Pago > 0){ ?>
		<a href="ProcesaPago_Dolares.php?Procesar_Codigo=<?= $ContableMov_Procesando['Codigo'] ?>&time=<?= time() ?>">Procesa Dolares <?= Fnum($ContableMov_Procesando['MontoHaber_Dolares']) ?></a>
		<? } ?>
		</td>
	</tr>
</table>

<?
}
?>