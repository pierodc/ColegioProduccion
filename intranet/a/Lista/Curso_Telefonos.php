<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
$TituloPagina   = "Telefonos"; // <title>
$TituloPantalla = "Telefonos"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

if(isset($_POST['WhatsappAlumno'])){
	$sql = "UPDATE Alumno 
			SET WhatsappAlumno = '".$_POST['WhatsappAlumno']."',
			WhatsappRepre = '".$_POST['WhatsappRepre']."'
			WHERE CodigoAlumno = '".$_POST['CodigoAlumno']."'";
	$mysqli->query($sql);
	}
//echo "<br><br><br>" . $sql;

// Ejecuta $sql
$RS_Alumno = $mysqli->query($query_RS_Alumno);

//$row_RS_Alumnos = $RS->fetch_assoc();


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
 
<?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion); ?>
 | 
 
 <a href="../Alumno/Excel/Email.php">email</a>
<table>
    <caption>Teléfonos</caption>
      
      <tr>
        <th width="20" class="NombreCampo">No</th>
        <th width="200" class="NombreCampo">Alumno</th>
        <th class="NombreCampo">WhatsappAlum | WhatsappRepre</th>
      </tr>
<?php 
while ($row_RS_Alumnos = $RS_Alumno->fetch_assoc()) {
	
	
	if($row_RS_Alumnos['Email'] > ""){
		//echo $row_RS_Alumnos['Email'].",";
		$Emails .= $row_RS_Alumnos['Email'].",";
	}
	else{
		$Emails .= $row_RS_Alumnos['Nombres'] . $row_RS_Alumnos['Apellidos'] . "@colegiosanfrancisco.com, ";
	}
	
	
	//$Emails .= $row_RS_Alumnos['Nombres'] . $row_RS_Alumnos['Apellidos'] . "@colegiosanfrancisco.com, ";
	
	
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
            <input name="WhatsappAlumno" type="text" id="WhatsappAlumno" value="<?php echo $row_RS_Alumnos['WhatsappAlumno'] ; ?>" />
            <input name="WhatsappRepre" type="text" id="WhatsappRepre" value="<?php echo $row_RS_Alumnos['WhatsappRepre'] ; ?>" />
            
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
	
if($telefono > '' and strpos($todos_tel , ' '.$telefono))
	echo '<b>';
echo 'Al: '.$telefono; 
if($telefono > '' and strpos($todos_tel , $telefono))
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

	if($telefono > '' and strpos($todos_tel , $telefono)) echo '</b>';

	$todos_tel .= $todos_tel . '   ' . $telefono;
}

// luisyanes55@hotmail.com
		
		
		
		?>
          </form></td>
        </tr>
<?php }
?>
   
   <tr><td colspan="3"><?= noAcentos($Emails) ?></td></tr>
   
</table>   
	


<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>
