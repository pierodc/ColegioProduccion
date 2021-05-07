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

	
<? Boton_Cursos($_id_Curso ); ?>
	

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
	<td><a href="<? echo $php_self . "../../../Docente/Curso/?id_Alumno=" . $CodigoAlumno; ?>"><? echo $Alumno->Apellido() ." ". $Alumno->Nombre(); ?></a></td>
	<td align="center"><? Frame_Asistencia($CodigoAlumno); ?></td>
	<td align="center"><?= $Consulta->Respuesta($CodigoAlumno , 1); ?></td>
	
	
	<!--td align="left"><? 
	
	foreach($ContableMov->PendienteXX() as $mes){
		echo $mes . " / ";
		
	} 

	?></td-->
	
	 
	<!--td><? echo Edad_Dif($Alumno->FechaNac() , date("Y-m-d")); ?></td-->
	<td>
	<?
	//echo 'Al: '.TelLimpia($TelCel); 
	
	$arr = array('Padre','Madre');
	foreach ($arr as $value) {

		$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = '$value'
									AND RepresentanteXAlumno.CodigoAlumno = '".$CodigoAlumno."'";
		//echo '<br>'.$query_RS_Repre.'<br>';
		$RS_Repre = $mysqli->query($query_RS_Repre); //
		$row_RS_Repre = $RS_Repre->fetch_assoc();

		//$RS_Repre = mysql_query($query_RS_Repre, $bd) or die(mysql_error());
		//$row_RS_Repre = mysql_fetch_assoc($RS_Repre);
		$Cel = "58" . substr(TelLimpia($row_RS_Repre['TelCel']) , 1 , 10);
		echo '  <td>  '.substr($value,0,1).
			"<a href='https://api.whatsapp.com/send/?phone=$Cel&text=Estimado+Sr.+Representante+Le+contacto+de+la+direccion+para+enviarle+el +link+de+la+circular+que+no+le+llego+por+email+https://colegiosanfrancisco.com/intranet/Consulta/Consulta.php?CodigoAlumno=".$Alumno->CodigoClave()."&app_absent=0' target='_blank'>";
		echo TelLimpia($row_RS_Repre['TelCel']);
		echo '</a>';
		echo $row_RS_Repre['Email1'];
		echo "</td>";
		
		
		

	}
	 
	 ?>
	
	</td>
	
</tr>

<?
	$Emails .= $Alumno->Email().", ";
}
	
?>
</tbody>
</table>





<? } ?>

<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>