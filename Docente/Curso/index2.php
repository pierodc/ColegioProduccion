<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$TituloPagina   = "Lista Curso"; // <title>
$TituloPantalla = "Lista Curso"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/GetVar.php');

$Alumno = new Alumno($_id_Alumno);

$AlumnoXCurso = new AlumnoXCurso();
$CodigoAlumnos = $AlumnoXCurso->view( $_id_Curso );


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>

<script>
function CopyToClipboard(containerid) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(containerid));
    range.select().createTextRange();
    document.execCommand("copy");
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(containerid));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    //alert("Text has been copied, now paste in the text-area")
  }
}
</script>   
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>



<? Boton_Cursos($_id_Curso ); ?>  
   

<? if($CodigoAlumnos->num_rows > 0)	{
	$i = 0; 
	
	$Titulos = array("No","Codigo","Alumno","Edad","Tel");
	$Matriz[] = $Titulos;
	?>


<table  class="sombra" >
<caption class="RTitulo">Listado</caption>
<thead>
	 <tr>
	 	<? foreach($Titulos as $Titulo){ ?>
			<th><?= $Titulo ?></th>
		<? } ?>
	</tr>
</thead>	
<tbody>	
<?
	//echo var_dump($Titulos);
	
while ( $row = $CodigoAlumnos->fetch_assoc() ){
	extract($row);
	$Alumno->id = $CodigoAlumno;
	
	$Contenido[] = $CodigoAlumno ;
	
	
?>	
<tr class="hover <?php if($_id_Alumno == $CodigoAlumno) echo "seleccionado"; ?>" >
	<td><? echo ++$No; $Contenido[] = $No; ?></td>
	<td><? echo $CodigoAlumno; ?></td>
	<td><a href="<? echo $php_self . "?id_Alumno=" . $CodigoAlumno; ?>"><? 
		echo $Alumno->Apellido() ." ". $Alumno->Nombre();
		$Contenido[] = $Alumno->Apellido() ." ". $Alumno->Nombre();
		?></a></td>
	<td><? 
		echo Edad_Dif($Alumno->FechaNac() , date("Y-m-d"));
		$Contenido[] = Edad_Dif($Alumno->FechaNac() , date("Y-m-d"));
		?></td>
	<td>
	<?
	$_Tel = "";
	$_Tel .= 'Al: '.TelLimpia($TelCel); 
	
	$arr = array('Padre','Madre');
	foreach ($arr as $value) {

		$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = '$value'
									AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
		//echo '<br>'.$query_RS_Repre.'<br>';
		$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
		$row_RS_Repre = mysql_fetch_assoc($RS_Repre);

		$_Tel .= '  -  '.substr($value,0,1).' '.TelLimpia($row_RS_Repre['TelCel']);

	}
	 
	echo $_Tel;
	$Contenido[] = $_Tel;
	$Matriz[] = $Contenido;
	unset($Contenido);
	 ?>
	
	</td>
	
</tr>

<?
	$Emails .= $Alumno->Email().", ";
}
	
?>
</tbody>
</table>

<? 
	echo "<pre>";	
	var_dump($Matriz);
	echo "</pre>";
	
	/*
<div class="subtitle">
	Emails para el Classroom:
</div>
<div id="Emails">
	<? echo $Emails; ?>
</div>

<button id="button1" class="button" onclick="CopyToClipboard('Emails')">Copiar Emails</button >
 */ ?>


<? } ?>

<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>