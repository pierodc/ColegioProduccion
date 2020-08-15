<div id="Obj_Otro_<?php echo $Codigo_ce_Planificacion ?>"><?php 
$MM_authorizedUsers = "";

if(file_exists('../inc_login_ck.php')){
//	require_once('../inc_login_ck.php'); 
	require_once('../Connections/bd.php'); 
	require_once('../intranet/a/archivo/Variables.php');
	require_once('../inc/rutinas.php'); }
elseif(file_exists('../../inc_login_ck.php')){
//	require_once('../../inc_login_ck.php'); 
	require_once('../../Connections/bd.php'); 
	require_once('../../intranet/a/archivo/Variables.php');
	require_once('../../inc/rutinas.php'); }


if(isset($_POST['Codigo_ce_Planificacion'])){
	$sql = "UPDATE ce_Planificacion
			SET Descripcion = '".$_POST['Descripcion']."'
			WHERE Codigo = '".$_POST['Codigo_ce_Planificacion']."'";
	//echo $sql;		
	$Codigo_ce_Planificacion = $_POST['Codigo_ce_Planificacion'];
	$mysqli->query($sql);
	//header("Location: ".$php_self."?Codigo=".$Codigo.'&Saved=1');
	}


$sql = "SELECT * FROM ce_Planificacion
		WHERE Codigo = '".$Codigo_ce_Planificacion."'"; // WHERE del mismo prof
$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);

?><link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<?php

if(isset($_GET['Saved']) and $row_Total['Total'] <= 100) 
	echo ' bgcolor="#FFFFCC"';
elseif(isset($_GET['Saved']) and $row_Total['Total'] > 100) 
	echo ' bgcolor="#FF0000"';

?>

<form name="formulario" id="form_P_<?php echo $Codigo; ?>" >
<input name="Codigo_ce_Planificacion" type="hidden" value="<?php echo $Codigo_ce_Planificacion ?>" size="15" />
<input name="Descripcion" type="text" value="<?php echo $Descripcion ?>" size="30" />
<input type="submit" name="button" id="button" value="G" />
</form>
<script>
$(document).ready(function() {
	$("#form_P_<?php echo $Codigo_ce_Planificacion; ?>").on("submit", function(e){
		e.preventDefault();
		$.post("iFr/Objetivo.php", $("#form_P_<?php echo $Codigo_ce_Planificacion; ?>").serialize(), function(respuesta){
			$("#Obj_Otro_<?php echo $Codigo_ce_Planificacion ?>").html(respuesta);
		});	
	});
});
</script></div>