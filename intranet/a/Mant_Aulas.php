<?php 
$MM_authorizedUsers = "91,95,AsistDireccion";
require_once('../../inc_login_ck.php'); 
require_once('../../Connections/bd.php'); 
require_once('archivo/Variables.php'); 
require_once('../../inc/rutinas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['Update'])){

foreach ($_POST as $clave => $valor) {
	if(strpos($clave , '-') > 0){
		$Campo = explode("-",$clave);
		$sql = "UPDATE Aula SET $Campo[1] = '$valor' WHERE Codigo = '$Campo[0]'";
		//echo $sql.'<br>';
		$mysqli->query($sql);
		}
}	
	}

$TituloPantalla ="Aulas";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php
	require_once('TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><form id="form1" name="form1" method="post" action="">
<table width="1000" border="0" align="center" cellpadding="5" cellspacing="5">
  <tr>
    <td width="600"><table width="600" border="0" align="center" cellpadding="3">
  <tr>
    <td align="center" nowrap="nowrap" class="NombreCampo">PLANO&nbsp;</td>
    <td align="center" nowrap="nowrap" class="NombreCampo">Descripcion<br />
      (Curso Actual)<br />
      <?php echo $AnoEscolar ?></td>
    <td align="center" nowrap="nowrap" class="NombreCampo">Capacidad&nbsp;</td>
    <td align="center" nowrap="nowrap" class="NombreCampo">Inscritos<br />
      <?php echo $AnoEscolar ?></td>
    <td align="center" nowrap="nowrap" class="NombreCampo">Curso&nbsp;Actual</td>
    <td align="center" nowrap="nowrap" class="NombreCampo">Curso Prox A&ntilde;o</td>
    <td align="center" nowrap="nowrap" class="NombreCampoBIG">&nbsp;</td>
  </tr>
<?php 

$sql_Aula = "SELECT * FROM Aula ORDER BY Codigo";
$RS_Aula = $mysqli->query($sql_Aula);

while ($row = $RS_Aula->fetch_assoc()) {
	extract($row);
?>
  <tr <?php $sw = ListaFondo($sw,''); ?>>
    <td align="center"><?php if($MM_Username=='piero') { ?><input name="<?php echo "$Codigo"; ?>-Ref" type="text" value="<?php echo "$Ref" ?>" size="5" /><?php }else{echo "$Ref";} ?></td>
    <td><input name="<?php echo "$Codigo"; ?>-Descripcion" type="text" value="<?php echo "$Descripcion"; ?>" size="20" /></td>
    <td align="center"><input name="<?php echo "$Codigo"; ?>-Capacidad" type="text" value="<?php echo "$Capacidad"; ?>" size="5" />
   </td>
    <td align="center"><?php 

	$sql = "SELECT * FROM `AlumnoXCurso` 
			WHERE CodigoCurso = '$CodigoCurso' 
			AND Ano = '$AnoEscolar' 
			AND Status = 'Inscrito' 
			AND Tipo_Inscripcion = 'Rg'";
	$RS_Contar = $mysqli->query($sql);
	echo $RS_Contar->num_rows;
		
	
	?>&nbsp;</td>
    <td align="center"><?php 
	$NombreSelect =  "$Codigo"."-CodigoCurso";
	$CursosUbicados .= ' '.$CodigoCurso;
	SelectMenuCurso($NombreSelect,$CodigoCurso,'');
	?>&nbsp;</td>
    <td align="center"><?php 
	$NombreSelect =  "$Codigo"."-CodigoCursoProxAno";
	SelectMenuCurso($NombreSelect,$CodigoCursoProxAno,'');
	?>&nbsp;</td>
    <td align="center"><?php if($SW_CupoDisp=='1'){ ?><a href="Procesa.php?t=Curso&cam=SW_CupoDisp&val=1&obj=CodigoCurso&valobj=<?php echo $CodigoCurso ?>" target="_blank"><img src="../../i/bullet_red.png" width="18" height="18" /></a><?php } else { ?>
      <a href="Procesa.php?t=Curso&cam=SW_CupoDisp&val=0&obj=CodigoCurso&valobj=<?php echo $CodigoCurso ?>" target="_blank"><img src="../../i/accept.png" width="18" height="18" /></a><?php } ?>
    </td>
  </tr>
<?php 
}
?>
  <tr>
    <td colspan="7" align="right"><input type="hidden" name="Update" id="Update" />      <input type="submit" name="button" id="button" value="Submit" /></td>
    </tr>
</table></td>
    <td valign="top" nowrap="nowrap"><?php 
	echo '<br>';
	?><span class="MensajeDeError"><?php 
	
	$sql_Curso = "SELECT * FROM Curso WHERE SW_activo = '1' ORDER BY NivelCurso, Seccion";
	$RS_Curso = $mysqli->query($sql_Curso);
	while ($row = $RS_Curso->fetch_assoc()) {
		if(!strpos($CursosUbicados , $row['CodigoCurso']))
			echo 'UBICAR '.Curso($row['CodigoCurso']).'<br>' ;
		if(substr_count($CursosUbicados , $row['CodigoCurso']) > 1)
			echo 'DUPLICADO '.Curso($row['CodigoCurso']).' <br>' ;
			
	}
		
	?></span></td>
  </tr>
</table>
 
</form></td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>