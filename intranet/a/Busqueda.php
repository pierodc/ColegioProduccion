<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$TituloPagina   = "INTRANET"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


//$Alumno = new Alumno($CodigoAlumno);

if(isset($_POST['Buscar'])){
	$aux = explode(" ",strtolower ($_POST['Buscar']));
		
$query_RS_Alumnos  = "SELECT * FROM Alumno WHERE "; 
	
$CamposBusqueda = "CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2";	
	
	if( $aux[0] > 0 and $aux[0] < 999999 ){
		$query_RS_Alumnos .= " CodigoAlumno = '$aux[0]' ";
	}else{
		$query_RS_Alumnos .= " LOWER(CONCAT_WS(' ',$CamposBusqueda)) LIKE '%$aux[0]%'";
		if ($aux[1] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',$CamposBusqueda)) LIKE '%$aux[1]%'";}
		if ($aux[2] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',$CamposBusqueda)) LIKE '%$aux[2]%'";}
		if ($aux[3] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',$CamposBusqueda)) LIKE '%$aux[3]%'";}
		$query_RS_Alumnos .= "   ORDER BY Apellidos, Apellidos2, Nombres, Nombres2";
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
    <div class="row">
		<div class="col-md-12">
			<div>
            
            	<!-- CONTENIDO -->
           
            </div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>