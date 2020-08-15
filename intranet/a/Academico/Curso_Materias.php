<?php 
//$MM_authorizedUsers = "99,91,95,90,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Activa Inspeccion
$Insp = false ;
$CodigoMaterias = array('7','8','9','IV','V');

if (!isset($_GET['CodigoMateria'])){
	header("Location: ".$php_self."?CodigoMateria=7");
	}


?><!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Cobranza/common.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>

    <link href="http://<?= $_SERVER['HTTP_HOST']; ?>/estilos2.css" rel="stylesheet" type="text/css" />
	
    <title><?php echo $TituloPag; ?></title>
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" align="center">
        
       		 <?  foreach ($CodigoMaterias as $CodigoMateria){ ?>
               	<a class="btn-sm btn-<? if ($CodigoMateria <> $_GET['CodigoMateria']) echo "outline-"; ?>primary" href="<? echo "$php_self?CodigoMateria=$CodigoMateria" ?>" role="button"><?= $CodigoMateria ?></a>
            <? } ?>
        
        
		</div>
	</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    <div class="row">
		<div class="col-md-12">
			<div>
            <!-- CONTENIDO -->
            <form><table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <th scope="col">&nbsp;</th>
      <th colspan="4" scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th colspan="4" scope="col">&nbsp;</th>
      </tr>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">Materia01</th>
      <th scope="col">Ma01</th>
      <th scope="col">Mat01</th>
      <th scope="col">Materia_01</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">Materia01</th>
      <th scope="col">Ma01</th>
      <th scope="col">Mat01</th>
      <th scope="col">Materia_01</th>
    </tr>
    
<?

?>    
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
<?

?>    
  </tbody>
</table>
</form>
            </div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>