<?php 
$MM_authorizedUsers = "91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "Formato Boleta";

$CodigoCurso = $_GET['CodigoCurso'];
$Lapso = $_GET['Lapso'];

if ( $CodigoCurso == "" or $Lapso == "" ){  //and $MM_UserGroup <> 'docente'
	
	if($CodigoCurso == ''){
		$CodigoCurso = 15;
		}
		
	if($Lapso == ''){
		$Lapso = $Lapso_Actual;	}
	
	//setcookie("CodigoCurso",$CodigoCurso,time()+99999999);
	//setcookie("Lapso",$Lapso,time()+99999999);

	header("Location: ".$_SERVER['PHP_SELF']."?CodigoCurso=".$CodigoCurso."&Lapso=".$Lapso);
}



$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];
$Curso->Ano = $AnoEscolar;
$Listado = $Curso->ListaCurso();
//echo " <br><b>NivelCurso:</b> ".$Curso->NivelCurso();
$NivelCurso = $Curso->NivelCurso();
/*
while($row = mysqli_fetch_assoc($Listado)){
	echo ++$No.' '.$row['Nombres'] . '<br>';
	}
*/

if(isset($_GET['CrearAnoNuevo'])){
	
	
	$sql = "SELECT * FROM Boleta_Indicadores
			WHERE NivelCurso = '".$Curso->NivelCurso()."'
			AND Ano = '$AnoEscolarAnte'
			ORDER BY Lapso, Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";
	//echo $sql."<br>";
	$RS = $mysqli->query($sql);
	while ($row = $RS->fetch_assoc()) {
		
		extract($row);
		$sqlInsert = "INSERT INTO Boleta_Indicadores 
		( NivelCurso, Lapso, Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden, Descripcion, EscalaNota, Responsable, Ano) 
		VALUES 
		( '$NivelCurso','$Lapso','$Dimen_o_Indic','$Orden_Grupo','$Materia_Grupo','$Orden','$Descripcion','$EscalaNota','$Responsable', '$AnoEscolar') 
		";
		//$mysqli->query($sqlInsert);
		//echo $sqlInsert."<br>";
		
		
		}


	header("Location: ".$php_self."?CodigoCurso=".$_GET['CodigoCurso']);
	
	}



if(isset($_GET['CodigoEdita']) and isset($_POST['submit'])){
	extract($_POST);
	$sql = "UPDATE Boleta_Indicadores SET 
			Dimen_o_Indic = '$Dimen_o_Indic', 
			Orden_Grupo = '$Orden_Grupo', 
			Materia_Grupo = '$Materia_Grupo', 
			Orden = '$Orden', 
			Descripcion = '$Descripcion', 
			EscalaNota = '$EscalaNota', 
			Responsable = '$Responsable'
			WHERE Codigo = '$Codigo'";
	$mysqli->query($sql);
	//echo $sql;
	header("Location: ".$php_self."?CodigoCurso=".$_GET['CodigoCurso']);
}
else
if(isset($_POST['submit'])){
	extract($_POST);
	$sql = "INSERT INTO Boleta_Indicadores 
	( NivelCurso, Lapso, Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden, Descripcion, EscalaNota, Responsable, Ano) 
	VALUES 
	( '$NivelCurso','$Lapso','$Dimen_o_Indic','$Orden_Grupo','$Materia_Grupo','$Orden','$Descripcion','$EscalaNota','$Responsable', '$AnoEscolar') 
	";
	$mysqli->query($sql);
	echo $sql;
	}
	
if(isset($_GET['delete'])){
	$sql = "DELETE FROM Boleta_Indicadores WHERE Codigo = '".$_GET['delete']."'";
	//echo $sql;
	$mysqli->query($sql);
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoCurso=".$_GET['CodigoCurso']);
}
/*
if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
 onclick="this.disabled=true;this.form.submit();"
 
 <a href="delete.php?id=$res[id]"  onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a>
 
 
// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }

<input type="submit" name="Boton" id="Boton" value="Valor" onclick="this.disabled=true;this.form.submit();" />
*/
 if(isset($_GET['CodigoEdita'])){
	$sql = "SELECT * FROM Boleta_Indicadores
			WHERE Codigo = '".$_GET['CodigoEdita']."'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	}

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><?php require_once('../TitAdmin.php'); ?></td>
  </tr>
    <tr>
    <td align="left" valign="top"><?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion); ?></td>
    <td align="center" valign="top">
    
    Lapso <? foreach (array(1,2,3) as $Lap) { ?>
      <a class="btn-sm <? 
		if ($Lapso <> $Lap) 
			echo "btn-light"; 
		else 
			echo "btn-primary"; 
			?>" href="<?= $php_self ?>?CodigoCurso=<?= $CodigoCurso ?>&Lapso=<?= $Lap ?>" role="button">
      <?= $Lap ?>
      </a>
      <? } ?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top"><table width="90%" border="0">
        <tr>
          <td colspan="6" class="subtitle">Ingreso de conceptos</td>
        </tr>
<form id="form1" name="form1" method="post" action="">
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td nowrap="nowrap" class="NombreCampo">Dimensi&oacute;n / Indicador</td>
  <td nowrap="nowrap" class="FondoCampo"><select name="Dimen_o_Indic" id="Dimen_o_Indic">
    <option value="">Selec...</option>
    <option value="D" <? if($Dimen_o_Indic == "D") echo 'selected="selected"'; ?>>Dimensi&oacute;n</option>
    <option value="I" <? if($Dimen_o_Indic == "I") echo 'selected="selected"'; ?>>Indicador</option>
  </select></td>
  <td nowrap="nowrap" class="NombreCampo">Escala Nota</td>
  <td colspan="3" nowrap="nowrap" class="FondoCampo"><select name="EscalaNota" id="EscalaNota">
    <option value="">Selec</option>
    <option value="A" <? if($EscalaNota == "A") echo 'selected="selected"'; ?>>Literal</option>
    <option value="5" <? if($EscalaNota == "5") echo 'selected="selected"'; ?>>Escala 5</option>
  </select></td>
  </tr>
<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
  <td nowrap="nowrap" class="NombreCampo">Materia / Grupo</td>
  <td nowrap="nowrap" class="FondoCampo">
  <input name="Orden_Grupo" type="text" id="Orden_Grupo" value="<?= $Orden_Grupo ?>" size="5"  />
  <input name="Materia_Grupo" type="text" id="Materia_Grupo" value="<?= $Materia_Grupo ?>" /></td>
  <td nowrap="nowrap" class="NombreCampo">Descripci&oacute;n</td>
  <td colspan="3" nowrap="nowrap" class="FondoCampo">
  <input name="Orden" type="text" id="Orden" value="<?= $Orden ?>" size="5"  />    
  <input name="Descripcion" type="text" id="Descripcion" value="<?= $Descripcion ?>"  size="80" /></td>
  </tr>
  
  
<tr >
  <td nowrap="nowrap" class="NombreCampo">Responsable</td>
  <td nowrap="nowrap" class="FondoCampo"><select name="Responsable" id="Responsable">
    <option value="0">Selec...</option>
    <option value="D" <? if($Responsable == "D") echo 'selected="selected"'; ?>>Docente Gu&iacute;a</option>
    <option value="E" <? if($Responsable == "E") echo 'selected="selected"'; ?>>Especialista</option>
  </select></td>
  <td nowrap="nowrap" class="FondoCampo">&nbsp;</td>
  <td colspan="3" align="right" nowrap="nowrap" class="FondoCampo">
  <?php if(false){?>
  <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?= $Curso->NivelCurso(); ?>" />    
  <?php } ?>
  <input name="NivelCurso" type="hidden" id="NivelCurso" value="<?= $Curso->NivelCurso(); ?>" />    
  <input name="Codigo" type="hidden" id="Codigo" value="<?= $Codigo; ?>" />    
    <input type="submit" name="submit" id="submit" value="Submit" /></td>
  </tr>
   </form>
     </table>      


<? 

$sql = "SELECT * FROM Boleta_Indicadores
			WHERE NivelCurso = '".$Curso->NivelCurso()."'
			AND Lapso = '$Lapso'
			AND Ano = '$AnoEscolar'
			ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";

//echo $sql;

$RS = $mysqli->query($sql);


if ($RS->num_rows == 0) {
?>

      <p><a href="Boleta_Estructura.php?CrearAnoNuevo=1&CodigoCurso=<?= $_GET['CodigoCurso'] ?>">&nbsp;Importa del año pasado</a></p>
      
     <? } ?> 
     
     
     
      <table width="90%%" border="0" cellspacing="0" cellpadding="5">
       <tbody>
       
<?php 

if(!isset($_GET['CodigoEdita'])){
	while ($row = $RS->fetch_assoc()) {
	extract($row);

if($Dimen_o_Indic_Ante != $Dimen_o_Indic){	
?>
        <tr>
           <td colspan="7">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="7" class="NombreCampoTITULO"><? echo $Dimen_o_Indic=="I"?"Indicador":"Dimensión"; ?></td>
        </tr>
<?php } 
if($Materia_Grupo_Ante != $Materia_Grupo){
?>         
         <tr>
           <td colspan="7">&nbsp;</td>
          </tr>
         <tr>
           <td colspan="7" class="NombreCampo"><?= $Orden_Grupo ?>) <?= $Materia_Grupo?></td>
         </tr>
<? } ?>         
         <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
           <td width="30">&nbsp;<?= $Orden; ?></td>
           <td>&nbsp;<?= $Descripcion ?></td>
           <td width="20"><?= $Responsable ?></td>
           <td width="20"><?= $EscalaNota ?></td>
           
           <td width="10"><a href="Boleta_Estructura.php?CodigoCurso=<?= $Curso->id; ?>&Lapso=<?= $Lapso ?>&CodigoEdita=<?= $Codigo ?>"><img src="../../../img/b_edit.png" width="16" height="16" alt=""/></a></td>
           <td width="10">&nbsp;</td>
           
           <td width="20" align="right"> <a href="?CodigoCurso=<?= $Curso->id; ?>&delete=<?= $Codigo ?>" onClick="return confirm('Esta seguro que desea eliminar?')"><img src="../../../img/b_drop.png" width="16" height="16" alt=""/></a></td>
         </tr>

<?php 
$Materia_Grupo_Ante = $Materia_Grupo;
$Dimen_o_Indic_Ante = $Dimen_o_Indic;
} ?>   
      
         <? } ?>
       </tbody>
     </table>     &nbsp;</td>
  </tr>
  <tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>