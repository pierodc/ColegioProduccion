<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$TituloPagina   = "Lista Curso"; // <title>
$TituloPantalla = "Lista Curso"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


$Alumno = new Alumno($CodigoAlumno);
$AlumnoXCurso = new AlumnoXCurso();

$CodigoAlumnos = $AlumnoXCurso->view($CodigoCurso = $_GET[CodigoCurso] , $Sort = "");


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
<style>
DIV.table 
{
    display:table;
}
DIV.tr:hover {	background-color: #EFEFEF;
}
DIV.tr
{
    display:table-row;
	/*background-color: #F5F5F5;*/
}
DIV.tr:nth-child(even) {
	background-color: #F5F5F5;
}	
DIV.tr:nth-child(odd) {
	background-color: #DBDBDB;
}	   
DIV.tr:hover {	background-color: #FFF3CC;
}	   
	   
SPAN.td
{
    display:table-cell;
}
.verde{
   background: #C6FFC6;
}	   
</style> 
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

<div class="subtitle">
	Curso
</div>
    <div class="row">
		<div class="col-md-12">
			<? Ir_a_Curso($_GET[CodigoCurso] , "index.php?CodigoCurso=" ); ?>  
        </div>
	</div>


<? if($CodigoAlumnos->num_rows > 0)	{ ?>

<div class="subtitle">
	Listado
</div>

<div class="table">


 <div class="tr CampoNombre">
	<span class="td CampoNombre">No</span>
	<span class="td CampoNombre">Codigo</span>
	<span class="td CampoNombre">Alumno</span>
</div>
	
	
<?
	
while ( $row = $CodigoAlumnos->fetch_assoc() )
{
	extract($row);
	$Alumno->id = $CodigoAlumno;
	
?>	
<div class="tr">
	<span class="td"><? echo ++$No ?></span>
	<span class="td"><? echo $CodigoAlumno; ?></span>
	<span class="td"><? echo $Alumno->Apellido() ." ". $Alumno->Nombre(); ?></span>
</div>

<?
	$Emails .= $Alumno->Email().", ";
	
	
}
	
?>
		
</div>


<div class="subtitle">
	Emails para el Classroom:
</div>
<div id="Emails">
	<? echo $Emails; ?>
</div>

<button id="button1" class="button" onclick="CopyToClipboard('Emails')">Copiar Emails</button>

<? } ?>


<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>