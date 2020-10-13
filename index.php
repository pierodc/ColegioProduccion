<?php 
$MM_authorizedUsers = "";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

if($_iPhone){
	header("Location: index_iphone.php"); }
//isset($_GET['LogOut']) or
if( isset($_GET['doLogout']) and $_GET['doLogout']='true'){
	setcookie("MM_Username",  '', time()-3600);
	setcookie("MM_UserGroup", '', time()-3600);
	
	unset($_SESSION['MM_Username']);
	unset($_SESSION['MM_UserGroup']);
	unset($_SESSION['PrevUrl']);
	header("Location: index.php?Login=".$_GET['Login']."&Psw=".$_GET['Psw']."");
}

?><html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta name="google-site-verification" content="3tZ1g5zh9pPNkKS9BNtKDuFPFrA_g_kGKvOLC-Qd9H0" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<link rel="shortcut icon" href="http://www.colegiosanfrancisco.com/img/SFA.png" type="image/png" />
<link href="css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<div id="fb-root"></div>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '205772959553604', // App ID
      channelUrl : '//www.colegiosanfrancisco.com', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/es_LA/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>



<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=205772959553604";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<!-- ImageReady Slices (index.psd) -->
<table width="1025" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="img/index_01.jpg" width="31" height="191" alt=""></td>
		<td bgcolor="#FFFFFF">
			<img src="img/TitSol.jpg" width="197" height="191" alt=""></td>
		<td bgcolor="#0A1B69">
			<img src="img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="img/index_04.jpg" width="31" height="191" alt=""></td>
  </tr>
	<tr>
		<td colspan="4">
			<img src="img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F3F3F3">&nbsp;</td>
		<td><? include("MenuHoriz.php"); ?></td>
  <td bgcolor="#FFF8E8">
			<img src="img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4">
			<img src="img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php 
			//include("Login_jq.php");  ?><?php
			include('inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php include('inc_menu.php'); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
<p>&nbsp;</p>
<p><strong>N&uacute;meros de tel&eacute;fono activos: <br>
0412.303.44.44<br>
0414.303.44.44<br>
<!-- (0212) 285.78.72 / 285.69.33 / 286.04.37 / 284.05.20  -->
</strong></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><a href="https://www.dropbox.com/s/1a3o9sbx8qzbyo7/PasosParaIngresarEnElProceso.pdf?dl=0" class="xbig" target="_blank">Correo institucional Alumno <br>
</a>Las cuentas las crea el servidor del colegio, <strong>no debe crearla</strong><br>
    Debe ingresar a la siguiente direcci&oacute;n:<br>
    <a href="http://correo.colegiosanfrancisco.com">correo.colegiosanfrancisco.com</a><br>
    Usuario: NombreApellido@ColegioSanFrancisco.com<br>
    Clave: DDMMAAAAsfa    (dia mes a&ntilde;o de naciemiento del alumno seguido de &quot;sfa&quot;)</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><a href="https://www.dropbox.com/s/1a3o9sbx8qzbyo7/PasosParaIngresarEnElProceso.pdf?dl=0" class="xbig" target="_blank">Proceso de Ingreso de Nuevos Alumnos</a><br>
Para solicitar cupo: debe registrarse y llenar los datos del alumno y la familia.         <br>
    En el trascurso de 5 d&iacute;as h&aacute;biles sera contactado.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td valign="top" bgcolor="#EECCA6" class="medium">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td align="center" valign="top"><a href="https://db.tt/JUlk6eM"><br>
            <img src="i/Dropbox.png" alt="" width="135" height="34" border="0"></a></td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td rowspan="4" bgcolor="#FFF8E8">&nbsp;</td>
            <td rowspan="4" align="center"></td>
            <td align="center">

           </td>
            <td width="31" rowspan="4" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <!--tr>
            <td align="center">&nbsp;<a class="twitter-timeline" width="300" height="300" href="https://twitter.com/colegiosfa" data-widget-id="329810306194866176">Tweets por @colegiosfa</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
          </tr-->
          <tr>
            <td align="center"></td>
          </tr>
          <tr>
            <td align="right">.</td>
          </tr>
        </table></td>
  </tr>
	<tr>
	  <td colspan="4" align="center" bgcolor="#FFFFFF"></td>
  </tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF">
			<img src="img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010<br>
		  Desarrollado por <a href="http://www.Kiberminio.com">Kiberminio.com</a> </font></strong></td>
<td bgcolor="#0A1B69"> 
			<img src="img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>