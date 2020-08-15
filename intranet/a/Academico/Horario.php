<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Horario";
$Cedula = $_GET['Cedula'];
/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
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
if(isset($_POST['ActualizaHr'])){
	echo "<pre>";
	//print_r($_POST);
	echo "</pre>";
	
	foreach($_POST as $clave => $valor){
		$clave = explode('-' , $clave);
		
		if($clave[0] == 'Hr_Semanales'){
			$sql = "UPDATE Materias 
					SET Hr_Semanales = '$valor'
					WHERE Codigo_Materia = '$clave[1]'";
			$mysqli->query($sql);		
			}
		
		if($clave[0] == 'Docente'){
			
			$sql = "DELETE FROM DocenteXCurso WHERE
					CodigoCurso = '$clave[1]' AND
					Codigo_Materia = '$clave[2]'";
			$mysqli->query($sql);		
			$sql = "INSERT INTO DocenteXCurso 
					(CodigoCurso, Codigo_Materia, CedulaProf)
					VALUES
					('$clave[1]', '$clave[2]', '$valor')";
			$mysqli->query($sql);		
			
			$sqlHorario = "UPDATE Horario SET 
							Cedula_Prof = '$valor'
							WHERE
							Descripcion = '$clave[2]'";
			//echo $sqlHorario.'<br>';
			$mysqli->query($sqlHorario);		
			}
			
		if($clave[0] == 'Codigo_ce_Asignatura'){
			$sqlHorario = "UPDATE Materias SET 
							Codigo_ce_Asignatura = '$valor'
							WHERE
							Codigo_Materia = '$clave[2]'";
			//echo $sqlHorario.'<br>';
			$mysqli->query($sqlHorario);		
			
			}
			
			
			
		}
		
	
	}

if(!isset($_GET['CodigoCurso']))
	header("Location: ".$php_self."?CodigoCurso=35");
$CodigoCurso = $_GET['CodigoCurso'];

$query_RS_Curso = "SELECT * FROM Curso WHERE CodigoCurso = '$CodigoCurso'";
$RS = $mysqli->query($query_RS_Curso);
$row_Curso = $RS->fetch_assoc();
$CodigoMaterias = $row_Curso['CodigoMaterias'];
$NivelCurso = $row_Curso['NivelCurso'];


if($_POST["CrearBloque"] > " "){
	$NombreMateria = $_POST["CrearBloque"];
	$sqlHorario = "INSERT INTO Materias 
					(CodigoMaterias, NivelCurso, Materia)
					VALUES
					('".$CodigoMaterias."','".$NivelCurso."','".$NombreMateria."')";
	echo $sqlHorario.'<br>';
	$mysqli->query($sqlHorario);		
	
	
	}

if(isset($_GET['EliminaMateria'])){
	$sql = "DELETE FROM Materias WHERE
			Codigo_Materia = '".$_GET['Codigo_Materia']."'";
	$mysqli->query($sql);
	header("Location: ".$php_self."?CodigoCurso=".$_GET['CodigoCurso']);
		
	}



$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '".$row_Curso['BloqueHorarioGrupo']."' ";
$RS = $mysqli->query($query_RS_Bloques);
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
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
    <td align="center"><?php require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="100%" border="0" cellpadding="2">
        <tr>
          <td colspan="7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><?php 
		  $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
		  Ir_a_Curso($CodigoCurso,$extraOpcion);?>&nbsp;</td>
                <td valign="top"><form id="form2" name="form2" method="post" action="">
                  <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('self',this,0)">
                    <option value="0">Profesor...</option>
                    <?php 

$query_RS_Prof = "SELECT * FROM Empleado 
					WHERE (TipoDocente LIKE '%Prof%' 
					OR TipoDocente LIKE '%Doc%' 
					OR CargoCorto LIKE '%Doc%' 
					OR  TipoDocente LIKE '%Maestra%' ) 
					AND SW_activo='1'  
					ORDER BY Apellidos, Nombres";
$RSProf = $mysqli->query($query_RS_Prof);

while ($rowProf = $RSProf->fetch_assoc()) { ?>
                    <option value="Horario.php?CodigoCurso=<?php echo $CodigoCurso ?>&Cedula=<?php echo $rowProf['Cedula'] ?>" <?php 
					if($_GET['Cedula'] == $rowProf['Cedula'])
						echo 'selected="selected"'; ?> >
                      <?php 
          echo substr($rowProf['Apellidos'], 0, 12).' '.substr($rowProf['Apellido2'], 0, 1).' '.substr($rowProf['Nombres'], 0, 12).' '.substr($rowProf['Nombre2'], 0, 1) 
          ?>
                      </option>
                    <?php } ?>
                  </select>
                </form></td>
                <td align="right" valign="top"><a href="Profesor_Materia.php">Docente por materia</a></td>
                <td align="right" valign="top" nowrap="nowrap"><a href="../../../Horario_pdf.php?CodigoCurso=<?php echo $_GET['CodigoCurso'] ?>" target="_blank">Horario Curso <?php echo Curso($_GET['CodigoCurso']); ?></a><br>
                <a href="../../../Horario_pdf.php" target="_blank">Horario Todos</a></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2" width="10%" class="NombreCampo">Bloque</td>
          <td width="18%" align="center" class="NombreCampoBIG">Lunes</td>
          <td width="18%" align="center" class="NombreCampoBIG">Martes</td>
          <td width="18%" align="center" class="NombreCampoBIG">Mi&eacute;rcoles</td>
          <td width="18%" align="center" class="NombreCampoBIG">Jueves</td>
          <td width="18%" align="center" class="NombreCampoBIG">Viernes</td>
        </tr>
<?php 
while ($row_Bloques = $RS->fetch_assoc()) {
	extract($row_Bloques);
?>
        <tr <?php echo $sw=ListaFondo($sw,$Verde);  ?>>
          <td nowrap="nowrap"><?php echo ++$Bloque ?>&nbsp;</td>
          <td align="center" nowrap="nowrap"><?php echo $Descripcion ?>&nbsp;</td>
<?php for($i=1; $i<=5; $i++) {?>
	<td align="center" nowrap="nowrap"><?php 
    if($Tipo=='R'){
        echo "RECESO";}
    elseif($Tipo=='A'){
        echo "ALMUERZO";}
    else{
        $Dia = $i;
        $Variables = "CodigoCurso=$CodigoCurso&Dia=$Dia&Bloque=$Bloque&Cedula=$Cedula&CodigoMaterias=$CodigoMaterias";
        ?><iframe src="iFr/BloqueHr.php?<?php echo $Variables ?>" width="100%" height="70" frameborder="0" align="middle"  ></iframe><?php } ?>
	</td>
<?php } ?>
        </tr>
<?php } ?>
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
<?php 
$sql = "SELECT * FROM Materias 
		WHERE CodigoMaterias = '$CodigoMaterias' 
		ORDER BY Materia ASC";							
$RS = $mysqli->query($sql);
?>    
<form id="form1" name="form1" method="post" action="">
    <table width="400" border="0" cellpadding="3">
      <tr>
        <td rowspan="2" nowrap="nowrap" class="NombreCampoBIG">&nbsp;</td>
        <td rowspan="2" nowrap="nowrap" class="NombreCampoBIG">Nombre Bloque</td>
        <td rowspan="2" class="NombreCampoBIG">ce_Asignatura</td>
        <td rowspan="2" class="NombreCampoBIG">Docente</td>
        <td colspan="4" align="center" class="NombreCampoBIG">Horas</td>
        </tr>
      <tr>
        <td align="center" nowrap="nowrap" class="NombreCampoBIG"> Requeridas</td>
        <td align="center" nowrap="nowrap" class="NombreCampoBIG"> en Horario</td>
        <td align="center" nowrap="nowrap" class="NombreCampoBIG">Faltan</td>
        <td align="center" nowrap="nowrap" class="NombreCampoBIG">&nbsp;</td>
      </tr>
<?php while ($row = $RS->fetch_assoc()) {
	
	
	//extract($row); ?>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td nowrap="nowrap">&nbsp;</td>
        <td nowrap="nowrap"><?php echo $row['Materia']; ?></td>
        
        
        
        <td nowrap="nowrap">
        <select name="Codigo_ce_Asignatura-<?php echo $CodigoCurso ?>-<?php echo $row['Codigo_Materia'] ?>" id="Codigo_ce_Asignatura">
          <option value="0">Selecc..</option>
          <?php 
		  
$sql = "SELECT * FROM ce_Asignatura 
		WHERE NivelCurso = '$NivelCurso'
		ORDER BY Nombre";
$RS_ce_Asignatura = $mysqli->query($sql);

while ($row_ce_Asignatura = $RS_ce_Asignatura->fetch_assoc()) { ?>
          <option value="<?php echo $row_ce_Asignatura['Codigo'] ?>" 
		  <?php if($row_ce_Asignatura['Codigo'] == $row['Codigo_ce_Asignatura']) echo 'selected="selected"'; ?>>
		  
		  <?php echo $row_ce_Asignatura['Nombre']; ?></option>
          <?php } ?>
        </select></td>
        
        
        
        
        
        <td><select name="Docente-<?php echo $CodigoCurso ?>-<?php echo $row['Codigo_Materia'] ?>" id="Docente">
          <option value="0">Selecc..</option><?php 

$query_RS_Prof = "SELECT * FROM Empleado 
					WHERE (TipoDocente LIKE '%Prof%' 
					OR TipoDocente LIKE '%Doc%' 
					OR CargoCorto LIKE '%Doc%' 
					OR  TipoDocente LIKE '%Maestra%' ) 
					AND SW_activo='1'  
					ORDER BY Apellidos, Nombres";
$RSProf = $mysqli->query($query_RS_Prof);

$sql = "SELECT * FROM DocenteXCurso WHERE
		CodigoCurso = '$CodigoCurso' AND
		Codigo_Materia = '".$row['Codigo_Materia']."'";
$RSProfActual = $mysqli->query($sql);		
$rowRSProfActual = $RSProfActual->fetch_assoc();

while ($rowProf = $RSProf->fetch_assoc()) { ?>        
          <option value="<?php echo $rowProf['Cedula'] ?>" <?php 
		  if($rowRSProfActual['CedulaProf'] == $rowProf['Cedula']) 
			  echo 'selected="selected"'; ?>><?php echo substr($rowProf['Apellidos'], 0, 12).' '.substr($rowProf['Apellido2'], 0, 1).' '.substr($rowProf['Nombres'], 0, 12).' '.substr($rowProf['Nombre2'], 0, 1) ?></option><?php } ?>        
        </select></td>
        <td align="center"><?php  ?>&nbsp;
          <input name="Hr_Semanales-<?php echo $row['Codigo_Materia']; ?>" type="text" id="Hr_Semanales" value="<?php echo $row['Hr_Semanales'];?>" size="5" /></td>
        <td align="center"><?php 
		
$query_RS_Conteo_Horario = "SELECT * FROM Horario 
							WHERE Descripcion = '".$row['Codigo_Materia']."' 
							AND CodigoCurso = '$CodigoCurso'";
$RS_aux = $mysqli->query($query_RS_Conteo_Horario);
$HorasEnHorario = $RS_aux->num_rows;
echo $HorasEnHorario;	
		?>&nbsp;</td>
		<?php $Faltan = $row['Hr_Semanales']-$HorasEnHorario; ?>
        <td align="center" <?php 
		if($Faltan>0) 
			echo 'class="FondoCampoAmarillo"';
		if($Faltan<0) 
			echo 'class="FondoCampoRojo"';
									
									 ?>><?php echo $Faltan; ?>&nbsp;</td>
        <td align="center"><?php if ($MM_Username == 'piero' and $row['Hr_Semanales']==0 and $HorasEnHorario==0){ ?><a href="Horario.php?EliminaMateria=1&Codigo_Materia=<?php echo $row['Codigo_Materia']; ?>&CodigoCurso=<?php echo $_GET['CodigoCurso']; ?>"><img src="../../../img/b_drop.png" width="16" height="16" /></a><?php }?></td>
      </tr>
<?php } ?>
      <tr>
        <td colspan="4">Crear Bloque: 
          <input type="text" name="CrearBloque" id="CrearBloque" /></td>
        <td rowspan="2" align="center"><input name="ActualizaHr" type="hidden" value="1" />
          <input type="submit" name="button" id="button" value="Submit" /></td>
        <td colspan="3" rowspan="2" align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>