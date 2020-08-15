<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../inc_login_ck.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../archivo/Variables.php');
require_once('../../../inc/rutinas.php'); 

$TituloPantalla = "Telefonos";

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['Urge_Celular'])){
	$sql = "UPDATE Alumno 
			SET Urge_Celular = '".$_POST['Urge_Celular']."'
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
	$mysqli->query($sql);
	}


// Ejecuta $sql
$RS_Alumno = $mysqli->query($query_RS_Alumno);

//$row_RS_Alumnos = $RS->fetch_assoc();

/*



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

*/

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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

<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><?php require_once('../TitAdmin.php'); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top"><table width="800" border="0" cellpadding="5">
      <tr>
        <td colspan="2"><?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion); ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="20" class="NombreCampo">No</td>
        <td width="200" class="NombreCampo">Alumno</td>
        <td class="NombreCampo">Datos</td>
      </tr>
<?php 
while ($row_RS_Alumnos = $RS_Alumno->fetch_assoc()) {
	//extract($row_RS_Alumnos);
?>
      <tr <?php 
	  
	  if($_GET['CodigoAl'] == $row_RS_Alumnos['CodigoAlumno'])
	  	$Verde = true;
	  else
	  	$Verde = false;
	  
	  echo $sw=ListaFondo($sw,$Verde);?>>
        <td nowrap="nowrap"><a name="<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" id="codal"></a><?php echo ++$No; ?></td>
        <td nowrap="nowrap"><a href="../PlanillaImprimirADM.php?AnoEscolar=<?php echo $AnoEscolar; ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank"><span class="ListadoNotas"><b><?php Titulo( $row_RS_Alumnos['Apellidos']. " " .$row_RS_Alumnos['Apellidos2']); ?>,</b> <em><?php Titulo( $row_RS_Alumnos['Nombres']. " " .$row_RS_Alumnos['Nombres2']) ?></em></span></a></td>
        <td nowrap="nowrap">
          <form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']."?CodigoAl=".$row_RS_Alumnos['CodigoAlumno']."&CodigoCurso=".$_GET['CodigoCurso']."#".$row_RS_Alumnos['CodigoAlumno']; ?>">
            <input name="Urge_Celular" type="text" id="Urge_Celular" value="<?php echo $row_RS_Alumnos['Urge_Celular'] ; ?>" />
            <input name="CodigoAlumno" type="hidden" id="CodigoAlumno" value="<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" />
            <input type="submit" name="button" id="button" value="G" />
            <?php 
	
	$telefono = $row_RS_Alumnos['TelCel'];
	$telefono = str_replace ('.','',$telefono);
	$telefono = str_replace ('(','',$telefono);
	$telefono = str_replace (')','',$telefono);
	$telefono = str_replace (',','',$telefono);
	$telefono = str_replace ('-','',$telefono);
	$telefono = str_replace (' ','',$telefono);
	$telefono = str_replace ('/04',' . 04',$telefono);
	$telefono = str_replace ('/','',$telefono);
	
if($telefono>'' and strpos($todos_tel , ' '.$telefono))
	echo '<b>';
echo 'Al: '.$telefono; 
if($telefono>'' and strpos($todos_tel , $telefono))
	echo '</b>';
$todos_tel = ' aa  ' . $telefono . '   ';

$Creador = $row_RS_Alumnos['Creador'];

$arr = array('Padre','Madre');
foreach ($arr as $value) {

	$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
								WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
								AND RepresentanteXAlumno.Nexo = '$value'
								AND RepresentanteXAlumno.SW_Representante = '1'
								AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
	//echo '<br>'.$query_RS_Repre.'<br>';
	$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
	$row_RS_Repre = mysql_fetch_assoc($RS_Repre);

	$telefono = $row_RS_Repre['TelCel'];
	$telefono = str_replace ('.','',$telefono);
	$telefono = str_replace ('(','',$telefono);
	$telefono = str_replace (')','',$telefono);
	$telefono = str_replace (',','',$telefono);
	$telefono = str_replace ('-','',$telefono);
	$telefono = str_replace (' ','',$telefono);
	$telefono = str_replace ('/04',' . 04',$telefono);
	$telefono = str_replace ('/','',$telefono);
	
	
	if($telefono>'' and strpos($todos_tel , ' '.$telefono)) echo '<b>';
	
	echo '  -  '.substr($value,0,1).' '.$telefono;

	if($telefono>'' and strpos($todos_tel , $telefono)) echo '</b>';

	$todos_tel .= $todos_tel . '   ' . $telefono;
}

// luisyanes55@hotmail.com
		
		
		
		?>
          </form></td>
        </tr>
<?php }
?>
    </table>     </td>
  </tr>
  <tr>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>