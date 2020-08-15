<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Docente por Materia";

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

if(isset($_GET['Eliminar'])){
	$sql = "DELETE FROM Materias WHERE Codigo_Materia = '".$_GET['Codigo_Materia']."'";
	$mysqli->query($sql);		
	header("Location: ".$php_self . "?CodigoCurso=".$_GET['CodigoCurso']);
	}

if(isset($_POST['ActualizaHr'])){
	echo "<pre>";
	//print_r($_POST);
	echo "</pre>";
	
	if($_POST['MateriaCrear'] > '' ){ // Crear Nueva Materia
		$sql = "INSERT INTO Materias
				(Materia, CodigoMaterias)
				VALUES
				('".$_POST['MateriaCrear']."','".$_POST['CodigoMateria']."')";
		$mysqli->query($sql);		
		}
	
	
	foreach($_POST as $clave => $valor){
		$clave = explode('-' , $clave);
		
		if($clave[0] == 'Hr_Semanales'){
			$sql = "UPDATE Materias 
					SET Hr_Semanales = '$valor'
					WHERE Codigo_Materia = '$clave[1]'";
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
		}
	
	}

if(!isset($_GET['CodigoCurso']))
	header("Location: ".$php_self."?CodigoCurso=35");
$CodigoCurso = $_GET['CodigoCurso'];

$query_RS_Curso = "SELECT * FROM Curso WHERE CodigoCurso = '$CodigoCurso'";
$RS = $mysqli->query($query_RS_Curso);
$row_Curso = $RS->fetch_assoc();
$CodigoMaterias = $row_Curso['CodigoMaterias'];

$query_RS_Bloques = "SELECT * FROM HorarioBloques WHERE Grupo = '".$row_Curso['BloqueHorarioGrupo']."' ";
$RS = $mysqli->query($query_RS_Bloques);

$u_agent = $_SERVER['HTTP_USER_AGENT'];

if(strpos($u_agent,"iPhone"))
	$sw_phone = true;
else 	
	$sw_phone = false;
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width"/>
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
    <td align="center"><?php if(!$sw_phone) require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table border="0" cellpadding="2" width="100%">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><?php 
		  $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
		  Ir_a_Curso($CodigoCurso,$extraOpcion);?>
                  &nbsp;</td>
                <td align="right"><a href="Horario.php">Horarios</a></td>
              </tr>
          </table></td>
        </tr>
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
        <td class="NombreCampoBIG">Materia</td>
        <td class="NombreCampoBIG">Docente</td>
        <td nowrap="nowrap" class="NombreCampoBIG">Hr Sem</td>
        <td class="NombreCampoBIG">&nbsp;</td>
        </tr>
<?php while ($row = $RS->fetch_assoc()) {
	
	"MateriasXCurso WHERE
	CodigoCurso = 
	Codigo_Materia =
	";
	
	//extract($row); ?>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td><?php echo $row['Materia']; ?>&nbsp;</td>
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
        <td><label for="textfield"></label>
          <input name="Hr_Semanales-<?php echo $row['Codigo_Materia']; ?>" type="text" id="Hr_Semanales" value="<?php echo $row['Hr_Semanales'];?>" size="5" /></td>
        <td align="right"><a href="Profesor_Materia.php?CodigoCurso=<?php echo $CodigoCurso ?>&Eliminar=1&Codigo_Materia=<?php echo $row['Codigo_Materia'] ?>">Eliminar</a></td>
        </tr>
<?php } ?>
      <tr <?php echo $sw=ListaFondo($sw,$Verde);?>>
        <td>
          Crear:
            <input name="MateriaCrear" type="text" id="MateriaCrear" size="20" /></td>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center"><input name="ActualizaHr" type="hidden" value="1" />
          <input name="CodigoMateria" type="hidden" value="<?php echo $CodigoMaterias ?>" />
          <input name="CodigoCurso" type="hidden" value="<?php echo $CodigoCurso ?>" />
          <input type="submit" name="button" id="button" value="Submit" /></td>
      </tr>
    </table>
    </form></td>
  </tr>
</table>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>