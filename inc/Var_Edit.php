<?php 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 

//mysql_select_db($database_bd, $bd);


$Variable = new Variable();

$Var_Name = $_GET['Var_Name'];
$Var_Value = $Variable->view($Var_Name);

/* AGREGAR A MODELO
$Var = $Variable->view_row($Var_Name);
if( Dif_Tiempo($Var['Fecha_Modificacion']) > 0 ){
	$cambio_BCV = trim(coma_punto(cambio_BCV()));
	//echo $cambio_BCV;
	$Variable->edit($Var_Name, $cambio_BCV,"auto");
	$Var_Value = $cambio_BCV;
}
*/


if (isset($_POST['Var_Name'])) {
	$Var_Value = coma_punto($_POST['Var_Value']);
	$Var_Descripcion = $_POST['Var_Descripcion'];
	$Descripcion = $MM_Username;
	$Variable->edit($Var_Name, $Var_Value,$Descripcion);
	
}


?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.FondoCampoVerde {
	background-color: #33FF66;
	padding: 3px;
	font-size: 10px;
	color: #000000;
}
</style>



<form action="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $php_self . "?Var_Name=" . $Var_Name ?>" method="post">
<table width="" border="0" align="left" cellpadding="0" cellspacing="0">
    <tr>
      <td align="right" <?php if (isset($_POST['Var_Value'])) { ?> class="FondoCampoVerde"<?php } ?>>
      <? //echo $Var_Name; ?>
       <input name="Var_Name" type="hidden" value="<? echo $Var_Name; ?>" id="Var_Name">
       <input name="Var_Value" type="text" value="<? echo $Var_Value; ?>" id="Var_Value" size="15">
       <input name="Var_Descripcion" type="hidden" value="<? echo $Var_Descripcion; ?>" id="Var_Descripcion" >
       <input name="Fecha_Modificacion" type="hidden" value="<? echo $Fecha_Modificacion; ?>" id="Fecha_Modificacion" >
       <input type="submit" name="G" class="button" id="button" value="G" onClick="this.value='..'"  />
      </td>
    </tr>
</table>
</form>

