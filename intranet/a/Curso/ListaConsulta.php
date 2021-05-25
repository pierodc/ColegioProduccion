<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
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

$Resultado = $Consulta->Resultado(1);
Matriz_tabla($Resultado);


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>

   
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>


<?
	
$CodigoAlumnos = $Consulta->Lista(1);
/*
	while ( $Res = $Resultado->fetch_assoc() ){
	$Alumno->id = $Res["CodigoAlumno"];
	echo $Alumno->id." ". $Alumno->ApellidoNombre() ." ". $Alumno->Curso();
	echo ".<br>";
}
*/
	
	
	
if($CodigoAlumnos->num_rows > 0)	{ ?>
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
	<td><? echo $Alumno->ApellidosNombres() ." "; ?></td>
	<td><? 
	if($CreadorAnterior != $Creador){
		echo $Creador; 
		$Num_Familia++;
		$Num_Respuesta[$Consulta->Respuesta($CodigoAlumno , 1)]++;
		}
	$CreadorAnterior = $Creador;
		?></td>
	<td><?= $Consulta->Respuesta($CodigoAlumno , 1); ?></td>
	 
	<td>
	
	</td>
	
</tr>

<?
	$Emails .= $Alumno->Email().", ";
}
	
?>
</tbody>
</table>



<table>
<tr>
<?
	

echo "<tr><td>" .  "Num_Poblacion: " . 425 . " </td></tr> ";		
echo "<tr><td>" .  "Participaron_Familia: " . $Num_Familia . " </td></tr> ";	
foreach($Num_Respuesta as $clave => $valor)	{
	echo "<tr><td>" . $clave . " " . $valor . " </td></tr> ";
}
	?>
	
	
</table>


<? } ?>

<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>