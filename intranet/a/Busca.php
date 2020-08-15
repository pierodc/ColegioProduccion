<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
$TituloPagina   = "INTRANET"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


$Alumno = new Alumno();

if(isset($_POST["Buscar"])){
	
	$aux = explode(" ",strtolower ($_POST['Buscar']."     "));
	
	if(isset($_POST["Alumno"])){
		$sql  = "SELECT * FROM Alumno WHERE "; 
		$sql .= " CodigoAlumno = '$aux[0]' OR ";
		foreach($aux as $word){
			if($word > " ")
			  $sql .= "  LOWER(CONCAT_WS('  ',Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) 
						LIKE '$word%' AND";
		}
		$sql = substr($sql,0,strlen($sql)-3);
		$sql .= "   ORDER BY Creador, Apellidos, Apellidos2, Nombres, Nombres2";
		
		echo "<br><br><br>".$_POST['Buscar']."<br><br>".$sql."<br>";
		
		
		// Ejecuta $sql y While
		$RS = $mysqli->query($sql);
		while ($row = $RS->fetch_assoc()) {
			extract($row);
			$Alumnos[$i++] = $CodigoAlumno;
		}
		
		
		
	}
		
		
		
	
}

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
 <div class="container-fluid">
 <? foreach($Alumnos as $Alumno_id){
	 $Alumno->id = $Alumno_id;
	  ?>
    <div class="row">
		<div class="col-md-12">
			<div class="sombra">
			<?
            echo $Alumno->id;
			echo $Alumno->NombresApellidos();
            ?>
			</div>
		</div>
	</div>
    <? } ?>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>