<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin,AsistDireccion,Contable,ce,provee,secreBach";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
$TituloPagina   = "INTRANET / SFA"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

//$_var = new Variable();

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
//header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


//$Alumno = new Alumno($CodigoAlumno);


//require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
   <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
  <meta charset="UTF-8">
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>

   
<div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div>
            ffff
            	<!-- CONTENIDO -->
           
            </div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>