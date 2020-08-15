<?php 
$MM_authorizedUsers = "docente,99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../inc_login_ck.php'); 

require_once('../Connections/bd.php'); 
require_once('../intranet/a/archivo/Variables.php');
require_once('../inc/rutinas.php'); 

$TituloPantalla = "Asignaturas";

if(isset($_POST['Crear'])){
	$sql = "INSERT INTO ce_Asignatura
			(Nombre , NivelCurso) VALUES
			('".$_POST['Nombre']."', '".$_POST['NivelCurso']."')";
	$mysqli->query($sql);
	}
	
if(isset($_GET['Elimina'])){
	$sql = "DELETE FROM ce_Asignatura
			WHERE Codigo = '".$_GET['Codigo']."'";
	//$mysqli->query($sql);
	header("Location: ".$php_self);
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../estilos.css" rel="stylesheet" type="text/css" />
<link href="../estilos2.css" rel="stylesheet" type="text/css" />
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
          <td colspan="3" class="NombreCampo">&nbsp;</td>
        </tr>
        <tr <?php $sw=ListaFondo($sw,$Verde);  ?>>
          <td colspan="3"><form id="form1" name="form1" method="post" action="">
            Asignatura
            <input type="text" name="Nombre" id="Nombre" /> 
            Nivel Curso
            <select name="NivelCurso" id="NivelCurso">
              <option value="0">Seleccione ...</option>
            <?php 
			$sql = "SELECT * FROM Curso 
					WHERE SW_activo = '1'
					AND NivelCurso >= '30'
					GROUP BY NivelCurso ORDER BY NivelCurso";
			$RS = $mysqli->query($sql);
			while ($row = $RS->fetch_assoc()) {
				extract($row);
			?>
              <option value="<?php echo $NivelCurso ?>"><?php echo $Curso." - ".$NombrePlanDeEstudio; ?></option>
            <?php } ?>
            </select> 
            GrupoDividido
            <select name="GrupoDividido" id="select">
              <option value="1">No</option>
              <option value="2">1/2 Gr</option>
              <option value="4">1/4 Gr</option>
            </select>
            <input type="submit" name="Crear" id="Crear" value="Crear" />
            <input type="hidden" name="Crear" id="Crear" />
          </form></td>
        </tr>
        
		<?php 
        $sql = "SELECT * FROM ce_Asignatura ORDER BY NivelCurso, Nombre"; // WHERE del mismo prof
        $RS = $mysqli->query($sql);
		if($RS)
        while ($row = $RS->fetch_assoc()) {
            extract($row);
			if($NivelCursoAnterior != $NivelCurso) {
        ?>
        <tr >
          <td colspan="3" class="NombreCampoBIG"><?php echo $NivelCurso ?></td>
        </tr><?php } ?>
        <tr <?php $sw = ListaFondo($sw,$Verde);  ?>>
          <td>&nbsp;<a href="Objetivos.php?CodigoAsignatura=<?php echo $Codigo ?>"><?php echo $Nombre." " ?></a></td>
          <td><a href="Planificacion.php?CodigoAsignatura=<?php echo $Codigo ?>">Planificacion</a></td>
          <td align="right"><a href="Asignatura.php?Codigo=<?php echo $Codigo  ; //Elimina=Asignatura& ?>">Eliminar</a></td>
        </tr>
        <?php 
		
		$NivelCursoAnterior = $NivelCurso; 
		} ?>
        
        
    </table>      &nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>