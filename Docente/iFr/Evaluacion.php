<div id="Ponderacion_<?php echo $Codigo; ?>"><?php 
$MM_authorizedUsers = "";

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/notas.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/xls/excel.php'); 


if(isset($_POST['Codigo'])){
	$sql = "UPDATE ce_Evaluacion
			SET Ponderacion = '".coma_punto($_POST['Ponderacion'])."'
			WHERE Codigo = '".$_POST['Codigo']."'";
	//echo $sql;		
	$Codigo = $_POST['Codigo'];
	//$Lapso = $_POST['Lapso'];
	//$CodigoAsignatura = $_POST['CodigoAsignatura'];
	$mysqli->query($sql);
	//header("Location: ".$php_self."?Codigo=".$Codigo.'&Saved=1');
	}

	
	
$sql_Total = "SELECT SUM(Ponderacion) AS Total FROM ce_Evaluacion
				WHERE CodigoAsignatura = '$CodigoAsignatura'
				AND Lapso = '$Lapso'";
$RS_Total = $mysqli->query($sql_Total);
$row_Total = $RS_Total->fetch_assoc();

$sql = "SELECT * FROM ce_Evaluacion
		WHERE Codigo = '".$Codigo."'"; // WHERE del mismo prof
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);

	  
	  if($row_Total['Total'] > 100)
		  $htmlTotal  = '<p class=SW_Rojo>';
		  
	  if($row_Total['Total'] < 100)
		  $htmlTotal  = '<p class=SW_Amarillo>';
		  
	  if($row_Total['Total'] == 100)
		  $htmlTotal  = '<p class=SW_Verde>';
		  
	  $htmlTotal .= round($row_Total['Total'],0).'%';
	  $htmlTotal .= '</p>';

?>

<form name="formulario" id="form_P_<?php echo $Codigo; ?>" >
   
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" >
<input name="Ponderacion" type="text" id="Ponderacion" value="<?php echo round($Ponderacion,0) ?>" size="3" onchange="this.form.submit();" />
%
<!--input name="CodigoAsignatura" type="hidden" value="<?php echo $CodigoAsignatura ?>" />
<input name="Lapso" type="hidden" value="<?php echo $Lapso ?>" / -->

<input name="Codigo" type="hidden" value="<?php echo $Codigo ?>" />
</td>
      <td align="center" ><?php 
if(isset($_POST['CodigoAsignatura'])){
?><div id="form_ok_<?php echo $Codigo; ?>">ok</div><?php } ?></td>
    </tr>
  </table>
  
</form>




<script>
$(document).ready(function() {
	$("#Total<?php echo $Lapso ?>").html("<?php echo $htmlTotal ?>");
	$("#form_ok_<?php echo $Codigo ?>").fadeOut( 1000 );
	$("#form_P_<?php echo $Codigo; ?>").on("submit", function(e){
		e.preventDefault();
		$.post("iFr/Evaluacion.php", $("#form_P_<?php echo $Codigo; ?>").serialize(), function(respuesta){
			$("#Ponderacion_<?php echo $Codigo; ?>").html(respuesta);
		});	
	});
});
</script></div>