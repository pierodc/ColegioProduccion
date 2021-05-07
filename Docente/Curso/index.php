<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$TituloPagina   = "Lista Curso"; // <title>
$TituloPantalla = "Lista Curso"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/GetVar.php');

$Alumno = new Alumno($_id_Alumno);
$ContableMov = new ContableMov($_id_Alumno);
$AlumnoXCurso = new AlumnoXCurso();
$CodigoAlumnos = $AlumnoXCurso->view( $_id_Curso );
$Consulta = new Consulta();


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

	



<table>	
	<tbody>
		<tr>
			<td>
				<? Boton_Cursos($_id_Curso ); ?>
			</td>
			<? if($CodigoAlumnos->num_rows > 0)	{ ?>
			<td>	
			<a href="Curso_pdf.php" class="button" target="_blank">Imprimir</a>
			<button id="button1" class="button" onclick="CopyToClipboard('Emails')">Copiar Emails</button >
			</td>
			<? } ?>
		</tr>
	</tbody>
</table>	

<? if($CodigoAlumnos->num_rows > 0)	{ ?>
<table  class="sombra" >
<caption >Listado</caption>
<thead>
	 <tr>
		<th>No</th>
		<th>Codigo</th>
		<th>Alumno</th>
		<th>Asistencia</th>
		<!--th>Meses Pend</th-->
		<th>Circular</th>
		
	</tr>
</thead>	
<tbody>	
<?
	
while ( $row = $CodigoAlumnos->fetch_assoc() ){
	extract($row);
	$Alumno->id = $CodigoAlumno;
	$ContableMov->id_Alumno = $CodigoAlumno;
?>	
<tr class="hover <?php if($_id_Alumno == $CodigoAlumno) echo "seleccionado"; ?>" >
	<td><? echo ++$No ?></td>
	<td><? echo $CodigoAlumno; ?></td>
	<td><a href="<? echo $php_self . "?id_Alumno=" . $CodigoAlumno; ?>"><? echo $Alumno->Apellido() ." ". $Alumno->Nombre(); ?></a></td>
	<td align="center"><? Frame_Asistencia ($CodigoAlumno); ?></td>
	<td align="center"><?= $Consulta->Respuesta($CodigoAlumno , 1); ?></td>
	
	
	<!--td align="left"><? 
	
	foreach($ContableMov->PendienteXX() as $mes){
		echo $mes . " / ";
		
	} ?></td-->
	
	<? /*
	<td><? echo Edad_Dif($Alumno->FechaNac() , date("Y-m-d")); ?></td>
	<td>
	<?
	echo 'Al: '.TelLimpia($TelCel); 
	
	$arr = array('Padre','Madre');
	foreach ($arr as $value) {

		$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = '$value'
									AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
		//echo '<br>'.$query_RS_Repre.'<br>';
		$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
		$row_RS_Repre = mysql_fetch_assoc($RS_Repre);

		echo '  -  '.substr($value,0,1).' '.TelLimpia($row_RS_Repre['TelCel']);

	}
	 
	 ?>
	
	</td>
	*/ ?>
</tr>

<?
	$Emails .= $Alumno->Email().", ";
}
	
?>
</tbody>
</table>

<div class="subtitle">
	Emails para el Classroom:
</div>
<div id="Emails">
	<? echo $Emails; ?>
</div>

<button id="button1" class="button" onclick="CopyToClipboard('Emails')">Copiar Emails</button >


<? } ?>

<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>