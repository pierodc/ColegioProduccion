<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
$TituloPagina   = "Monvimientos Banco"; // <title>
$TituloPantalla = "Monvimientos Banco"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$id = 1;
$Banco = new Banco($id);
$Movimientos = $Banco->view_all_Haber();


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
	
	<link href="/css/estilosFinal.css" rel="stylesheet" type="text/css" />
	
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
<article>
	<h2>Movimientos</h2>

	<table>
		<tbody>
			<tr>
				<th scope="col">Fecha</th>
				<th scope="col">Tipo</th>
				<th scope="col">Referencia</th>
				<th scope="col">Descripcion</th>
				<th scope="col">Haber</th>
			</tr>

	<? foreach($Movimientos as $Mov){ ?>
			<tr>
				<td><?=	DDMMAAAA($Mov["Fecha"]) ?></td>
				<td><?=	$Mov["Tipo"] ?></td>
				<td><?=	$Mov["Referencia"] ?></td>
				<td><?=	$Mov["Descripcion"] ?></td>
				<td><?=	Fnum($Mov["Haber"]) ?></td>
			</tr>

	<? } ?>
		</tbody>
	</table>
</article>	
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>