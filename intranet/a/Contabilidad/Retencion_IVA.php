<?php 
$MM_authorizedUsers = "91,99,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/clases/Gasto.php');

if(isset($_POST)){
	echo "<pre>";
	var_dump($_POST);
	echo "</pre>";
	}
	
	
	
	
?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



<title>Untitled Document</title>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div class="container">
<form id="form1" name="form1" method="post">
  <label for="textfield"></label>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>RIF:&nbsp;</td>
        <td><input type="text" name="textfield" id="textfield"></td>
      </tr>
      <tr>
        <td>Nombre Empresa:</td>
        <td>
        <input type="text" name="textfield2" id="textfield2"></td>
      </tr>
      <tr>
        <td>Factura: Fecha</td>
        <td><input type="date" name="textfield3" id="textfield3"></td>
      </tr>
      <tr>
        <td>Factura No</td>
        <td><input type="text" name="textfield4" id="textfield4"></td>
      </tr>
      <tr>
        <td>Control No</td>
        <td><input type="text" name="textfield5" id="textfield5"></td>
      </tr>
      <tr>
        <td>Base Imponible</td>
        <td><input type="text" name="textfield5" id="textfield5"></td>
      </tr>
      <tr>
        <td>Tasa IVA</td>
        <td><input type="text" name="textfield5" id="textfield5"></td>
      </tr>
      <tr>
        <td>Base Exenta</td>
        <td><input type="text" name="textfield5" id="textfield5"></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" name="submit" id="submit">
       </td>
      </tr>
    </tbody>
  </table>
</form> </div>
</body>
</html>