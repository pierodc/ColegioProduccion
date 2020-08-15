<?php 
$MM_authorizedUsers = "docente,99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../inc_login_ck.php'); 

require_once('../Connections/bd.php'); 
require_once('../intranet/a/archivo/Variables.php');
require_once('../inc/rutinas.php'); 

$TituloPantalla = "Planificación";
$CodigoAsignatura = $_GET['CodigoAsignatura'];
//$TiposEvaluacion = array("Taller","Prueba Corta","Ensayo","Exposición","Dictado","Dramatización","Interrogatorio","Mapa Conceptual","Debate","Actividades en Clases","Rasgos");

$sql = "SELECT * FROM ce_Tipo_Evaluacion
		ORDER BY Orden, Nombre";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	$TiposEvaluacion[$j++] = $row['Nombre'] ;
}


if(isset($_GET['CodigoObjetivo'])){
	$sql = "INSERT INTO ce_Planificacion
			(Lapso, Grupo, CodigoAsignatura, CodigoObjetivo) VALUES
			('".$_GET['Lapso']."', '".$_GET['Grupo']."', '".$_GET['CodigoAsignatura']."', '".$_GET['CodigoObjetivo']."')";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	}


if(isset($_GET['TipoEvaluacion'])){
	if($_GET['TipoEvaluacion'] == 'Rasgos')
		$Ponderacion = 10;
	$sql = "INSERT INTO ce_Evaluacion
			(Lapso, Grupo, CodigoAsignatura, Tipo, Ponderacion) VALUES
			('".$_GET['Lapso']."', '".$_GET['Grupo']."', '".$_GET['CodigoAsignatura']."', '".$_GET['TipoEvaluacion']."', '$Ponderacion')";
	//echo $sql;
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	}



if(isset($_GET['Elimina'])){
	$sql = "DELETE FROM ce_Planificacion
			WHERE Codigo = '".$_GET['Codigo']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	}
	

if(isset($_GET['EliminaEval'])){
	$sql = "DELETE FROM ce_Evaluacion
			WHERE Codigo = '".$_GET['CodigoEvaluacion']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	// Eliminar Fechas Evalua
	}



if(isset($_GET['EliminaGrupo'])){
	$sql = "DELETE FROM ce_Planificacion
			WHERE Codigo = '".$_GET['Codigo']."'";
	$mysqli->query($sql);
	$sql = "DELETE FROM ce_Evaluacion
			WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
			AND Lapso = '".$_GET['Lapso']."'
			AND Grupo = '".$_GET['Grupo']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoAsignatura=".$CodigoAsignatura);
	// Eliminar Fechas Evalua
	}


$sql = "SELECT * FROM ce_Asignatura
		WHERE Codigo = '".$_GET['CodigoAsignatura']."'"; // WHERE del mismo prof
$RS = $mysqli->query($sql);
$row_Curso = $RS->fetch_assoc();

$NivelCurso = $row_Curso['NivelCurso'];

$sql2 = "SELECT * FROM Materias
		WHERE Codigo_ce_Asignatura = '".$_GET['CodigoAsignatura']."'";
$RS2 = $mysqli->query($sql2);
if($row2 = $RS2->fetch_assoc())
	$CodigoNombre = $row2['Codigo_Materia'];

$sql2 = "SELECT * FROM Horario
		WHERE Descripcion = '$CodigoNombre'";
//echo $sql.'<br>';
$RS2 = $mysqli->query($sql2);
while ($row2 = $RS2->fetch_assoc()) {
	$DiaActivo[$row2['CodigoCurso']][$row2['Dia_Semana']] = true;
	//echo $row['CodigoCurso'].' '.$row['Dia_Semana'].'<br>';
}



/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


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

echo $sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  lang="es">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Language" content="es">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" />
<script src="../jquery/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('TituloPag.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="90%" border="0" cellpadding="2">
        <tr>
          <td colspan="6" class="NombreCampoTITULO"><?php echo $row_Curso['Nombre']." - ".NombreNivelCurso($row_Curso['NivelCurso']) ?>&nbsp;</td>
        </tr>
<?php 
$Lapsos = array(1,2,3);
foreach ($Lapsos as $Lapso){ 
$Grupo = 0; ?>        
<tr>
      <td colspan="6" class="NombreCampoBIG">Lapso: <?php echo $Lapso; ?></td>
</tr>
<tr>
  <td class="NombreCampo">No</td>
  <td class="NombreCampo">Semana</td>
  <td class="NombreCampo">Objetivos</td>
  <td class="NombreCampo">Estrategia<br />
    ense&ntilde;anza</td>
  <td colspan="2" class="NombreCampo">Evaluaci&oacute;n</td>
  </tr>		

<?php 

$sql = "SELECT * FROM ce_Planificacion
		WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
		AND Lapso = '$Lapso'
		GROUP BY Grupo
		ORDER BY Grupo"; 
$RS_Grupo = $mysqli->query($sql);
while($row_Grupo = $RS_Grupo->fetch_assoc()){
	$Grupo = $row_Grupo['Grupo'];

?>
<tr <?php $sw=ListaFondo($sw,$Verde);  ?>>
  <td valign="top"><?php echo $Grupo; ?>&nbsp;</td>
  <td valign="top"><label for="Semana"></label>
    <input name="Semana" type="text" id="Semana" size="4" /></td>
  <td valign="top">
   
<?php 
        $sql = "SELECT ce_Planificacion.*, ce_Objetivo.*, ce_Planificacion.Codigo AS Codigo_ce_Planificacion FROM ce_Planificacion, ce_Objetivo
				WHERE ce_Planificacion.CodigoObjetivo = ce_Objetivo.Codigo
				AND ce_Planificacion.CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
				AND ce_Planificacion.Lapso = '$Lapso'
				AND ce_Planificacion.Grupo = '$Grupo'
				ORDER BY ce_Planificacion.Lapso, ce_Planificacion.Codigo"; // WHERE del mismo prof
        $RS = $mysqli->query($sql);
		if($RS->num_rows > 0){
			?><table width="100%" border="0" cellpadding="0" cellspacing="2"><?php
			while($row = $RS->fetch_assoc()){
				extract($row);
				?><tr><?php
					?><td><?php echo $Numero; ?></td><?php
					?><td><div title="<?php echo substr($Objetivo,0,200); ?>"><?php 
					
					echo substr($Objetivo,0,50); 
					
					if($CodigoObjetivo == 0){ 
						require("iFr/Objetivo.php"); 
						}
					
					
					?></div></td><?php
					?><td align="right"><a href="Planificacion.php?CodigoAsignatura=<?php 
					
					echo $_GET['CodigoAsignatura'];
					
					if($RS->num_rows > 1)
						echo '&Elimina=1'; 
					if($RS->num_rows == 1) 
						echo '&EliminaGrupo=1&Grupo='.$Grupo.'&Lapso='.$Lapso;
					?>&Codigo=<?php echo $Codigo_ce_Planificacion ?>">Eliminar</a></td><?php
				?></tr><?
			} 
			?></table><?php
		} ?>
        
<?php if($CodigoObjetivo != 0){ ?>        
<form name="form" id="form">
    <select name="CodigoObjetivo" id="CodigoObjetivo" onchange="MM_jumpMenu('parent',this,0)">
    <option value="0">Agrega Objetivo...</option>
    <?php 
    $Base = "Planificacion.php?CodigoAsignatura=".$_GET['CodigoAsignatura']."&Lapso=$Lapso&Grupo=$Grupo&CodigoObjetivo=";
    $sql = "SELECT * FROM ce_Objetivo
    		WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
    		AND Contenido > ''";
    $RS = $mysqli->query($sql);
    while ($row = $RS->fetch_assoc()) {
		extract($row);
		$sqlaux = "SELECT * FROM ce_Planificacion
		WHERE CodigoObjetivo = '".$Codigo."'";
		//echo $sqlaux;			
		$RSaux = $mysqli->query($sqlaux);
		if (!$row = $RSaux->fetch_assoc()) { ?>
			<option value="<?php echo $Base.$Codigo ?>"><?php echo $Numero.' '.substr($Objetivo,0,50); ?></option>
		<?php }
	} ?>
    </select>
</form><?php } ?>
          </td>
  <td valign="top">&nbsp;</td>
          <td colspan="2" valign="top"><?php
		   
	$Base = "Planificacion.php?CodigoAsignatura=".$_GET['CodigoAsignatura']."&Lapso=$Lapso&Grupo=$Grupo&EliminaEval=1&CodigoEvaluacion=";
	$sql_Eval = "SELECT * FROM ce_Evaluacion
				 WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
				 AND Lapso = '$Lapso'
				 AND Grupo = '$Grupo'
				 ORDER BY Codigo";
    $RS_Eval = $mysqli->query($sql_Eval);
	
    if ($row_Eval = $RS_Eval->fetch_assoc()) {
		?><table width="100%" border="0" cellspacing="0" cellpadding="0"><?
			do {
				extract($row_Eval);
			?><tr>
            <td width="100"><? echo $Tipo; ?></td>
            <td align="right"><? echo '<a href="'.$Base.$Codigo.'">(x)</a>'; ?></td>
            <td align="right" nowrap="nowrap"><?php require("iFr/Evaluacion.php"); ?></td>
		</tr><?
			} while($row_Eval = $RS_Eval->fetch_assoc());
		?></table><?
	}
	
?><form name="form" id="form">
  <select name="Evaluacion" id="Evaluacion" onchange="MM_jumpMenu('parent',this,0)">
    <option value="0">Agrega Evaluacion...</option>
    <?php 
    $BaseEval = "Planificacion.php?CodigoAsignatura=".$_GET['CodigoAsignatura']."&Lapso=$Lapso&Grupo=$Grupo&TipoEvaluacion=";
		//extract($row2);
	foreach($TiposEvaluacion as $Tipo){ ?>
		<option value="<?php echo $BaseEval.$Tipo ?>"><?php echo $Tipo; ?></option>
	<?php } ?>
    </select>
</form>
          
          
          </td>
        </tr>
<?php } ?>        
        
        
       

<tr <?php $sw=ListaFondo($sw,$Verde);  ?>>
  <td colspan="2" valign="top"><?php echo ++$Grupo; ?></td>
  <td colspan="4" valign="top">
    <form name="form" id="form">
      <select name="CodigoObjetivo" id="CodigoObjetivo" onchange="MM_jumpMenu('parent',this,0)">
        <option value="0">Agrega Objetivo...</option>
        <?php 
    $Base = "Planificacion.php?CodigoAsignatura=".$_GET['CodigoAsignatura']."&Lapso=$Lapso&Grupo=$Grupo&CodigoObjetivo=";
    $sql = "SELECT * FROM ce_Objetivo
    		WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
    		AND Contenido > ''";
    $RS = $mysqli->query($sql);
    while ($row = $RS->fetch_assoc()) {
		extract($row);
		$sqlaux = "SELECT * FROM ce_Planificacion
					WHERE CodigoObjetivo = '".$Codigo."'";
		$RSaux = $mysqli->query($sqlaux);
		if (!$row = $RSaux->fetch_assoc()) { ?>
        <option value="<?php echo $Base.$Codigo ?>"><?php echo $Numero.' '.substr($Objetivo,0,50); ?></option>
        <?php }
	} ?>
        <option value="<?php echo $Base.'0' ?>">Otro</option>
        
        </select>
      </form>
  </td>
  </tr>
<tr >
  <td colspan="2" valign="top">&nbsp;</td>
  <td colspan="2" valign="top">&nbsp;</td>
    <td align="left" valign="middle" class="BoletaNota">Total <?php echo $Lapso ?>&deg; Lapso</td>
    <td align="right" valign="middle"><table width="50" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><div id="Total<?php echo $Lapso ?>"><?php 

$sql_Total = "SELECT SUM(Ponderacion) AS Total FROM ce_Evaluacion
				WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
				AND Lapso = '$Lapso'";
//echo $sql_Total;
$RS_Total = $mysqli->query($sql_Total);
$row_Total = $RS_Total->fetch_assoc();
	  
if($row_Total['Total'] > 100)
	echo '<p class=SW_Rojo>';
  
if($row_Total['Total'] < 100)
	echo '<p class=SW_Amarillo>';
  
if($row_Total['Total'] == 100)
	echo '<p class=SW_Verde>';

echo round($row_Total['Total'],0).'%';  

echo '</p>';
  ?></div></td>
        </tr>
      </table></td>
</tr>
<tr >
  <td colspan="6" valign="top"><table border="0" align="center">
    <tr>
      <td width="150" colspan="2" class="NombreCampo">Evaluaci&oacute;n</td>
      <?php 
$sql_Curso = "SELECT * FROM Curso
			   WHERE NivelCurso = '$NivelCurso'
			   AND SW_activo = '1'";
$RS_Curso = $mysqli->query($sql_Curso);
while ($row_Curso = $RS_Curso->fetch_assoc()) { ?>
      <td width="170" align="center" class="NombreCampo"><?php echo $row_Curso['NombreCompleto'] ?><br /><?php 
	  
	  
	if($DiaActivo[$row_Curso['CodigoCurso']][1]){
		echo "L ";}
	if($DiaActivo[$row_Curso['CodigoCurso']][2]){
		echo "M ";}
	if($DiaActivo[$row_Curso['CodigoCurso']][3]){
		echo "X ";}
	if($DiaActivo[$row_Curso['CodigoCurso']][4]){
		echo "J ";}
	if($DiaActivo[$row_Curso['CodigoCurso']][5]){
		echo "V ";}
	  
	  ?></td>
      
  <?php } ?>    
      </tr>
    
    
    
    <?php 
$sql_Evaluacion = "SELECT * FROM ce_Evaluacion
			   WHERE CodigoAsignatura = '".$_GET['CodigoAsignatura']."'
			   AND Lapso = '$Lapso'
			   ORDER BY Grupo, Codigo";
$RS_Evaluacion = $mysqli->query($sql_Evaluacion);
while ($row_Evaluacion = $RS_Evaluacion->fetch_assoc()) { ?>
    <tr <?php  $sw=ListaFondo($sw,$Verde);?> >
      <td width="20">&nbsp;<?php echo $row_Evaluacion['Grupo'] ?></td>
      <td><?php echo $row_Evaluacion['Tipo'] ?></td>
  <?php       
$RS_Curso = $mysqli->query($sql_Curso);
while ($row_Curso = $RS_Curso->fetch_assoc()) { 

	$DiasActivos = '';
	if($DiaActivo[$row_Curso['CodigoCurso']][1]){
		$DiasActivos .=  "1";}
	if($DiaActivo[$row_Curso['CodigoCurso']][2]){
		$DiasActivos .=  "2";}
	if($DiaActivo[$row_Curso['CodigoCurso']][3]){
		$DiasActivos .=  "3";}
	if($DiaActivo[$row_Curso['CodigoCurso']][4]){
		$DiasActivos .=  "4";}
	if($DiaActivo[$row_Curso['CodigoCurso']][5]){
		$DiasActivos .=  "5";}


?>
      <td align="center"><iframe src="iFr/EvaluacionFecha.php?Codigo_Evaluacion=<?php echo $row_Evaluacion['Codigo'] ?>&Codigo_Curso=<?php echo $row_Curso['CodigoCurso'] ?>&DiasActivos=<?php echo $DiasActivos ?>" width="100%"  height="23" frameborder="0" align="middle"></iframe></td>
      <?php } ?>   
      </tr>
    
  <?php } ?>   
    
    </table></td>
</tr>
<tr >
  <td colspan="6" valign="top">&nbsp;</td>
</tr>
    
        <?php } ?>
        
    </table>      
    &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>