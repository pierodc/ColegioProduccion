<?php 
require_once('Connections/bd.php'); 
require_once('inc/rutinas.php'); 
mysql_select_db($database_bd, $bd);
$sql = "INSERT INTO RegistroActividadWeb (IP, Descripcion) VALUES ('".$_SERVER['REMOTE_ADDR']."','Publicaciones')";
$RS = mysql_query($sql, $bd) or die(mysql_error());

?><html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos2.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="http://www.colegiosanfrancisco.com/img/SFA.png" type="image/png" />
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
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
            <td colspan="2"><?php include('inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php include('inc_menu.php'); ?>            </td>
            <td rowspan="3" align="center" valign="top" class="box1"><p class="Tit_Pagina">Publicaciones</p>
              <p>&nbsp;</p>
              <p><a href="https://www.dropbox.com/sh/grtwrmc1f7qj15h/AACCIljCkWA6BaLT9ya1ekdBa?dl=0" target="_blank" class="Tit_Blanco"><img src="i/calendar_edit.png" width="32" height="32" border="0" align="absmiddle"> Planes de Evaluaci&oacute;n Bachillerato</a>
              </p>
              
              
              
              <p ><a href="https://www.dropbox.com/sh/yynociw21c5pmpj/AABnwLzKRbT3XiqXEVhGyq86a?dl=0" target="_blank" class="Tit_Blanco">Guías, Trabajos y Asignaciones</a></p>
              
              
              <p ><a href="https://www.dropbox.com/sh/3weknravy29zwk0/AADvAOw4Ba0z8NKjNT_1aFF3a?dl=0" target="_blank" class="Tit_Blanco">Calendarios</a></p>
              
              
              
              <?php if (1==2){ ?><p>              DESACTIVADO
                inicio
              </p>
              <table width="700" border="1">
                <tr>
                  <td colspan="3" class="Tit_Blanco">Listas de &uacute;tiles</td>
                </tr>
                <tr class="Tit_Blanco">
                  <td width="33%">Preescolar</td>
                  <td width="33%">Primaria</td>
                  <td width="33%">Bachillerato</td>
                </tr>
                <tr>
                  <td valign="top"><p><a href="Publicaciones/utiles20122013/1erNiv.doc">1er Nivel</a><br>
                    <a href="Publicaciones/utiles20122013/2doNiv.doc">2do Nivel</a><br>
                    <a href="Publicaciones/utiles20122013/3erNiv.doc">3er Nivel</a><br>
                    <a href="Publicaciones/utiles20122013/4toNivPrepa.doc">Preparatorio</a></p></td>
                  <td valign="top"><a href="Publicaciones/utiles20122013/1erGr.doc">1er Grado</a><br>
                    <a href="Publicaciones/utiles20122013/2doGr.doc">2do Grado</a><br>
                    <a href="Publicaciones/utiles20122013/3erGr.doc">3er Grado</a><br>
                    <a href="Publicaciones/utiles20122013/4toGr.doc">4to Grado</a><br>
                    <a href="Publicaciones/utiles20122013/5toGr.doc">5to Grado</a><br>
                  <a href="Publicaciones/utiles20122013/6toGr.doc">6to Grado</a></td>
                  <td valign="top"><a href="Publicaciones/utiles20122013/1erA.doc">1er A&ntilde;o</a><br>
                    <a href="Publicaciones/utiles20122013/2doA.doc">2do A&ntilde;o</a><br>
                    <a href="Publicaciones/utiles20122013/3erA.doc">3er A&ntilde;o</a><br>
                    <a href="Publicaciones/utiles20122013/4toA.doc">4to A&ntilde;o</a><br>
                  <a href="Publicaciones/utiles20122013/5toA.doc">5to A&ntilde;o</a></td>
                </tr>
            </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="700" border="1" align="center" cellpadding="3">
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">Plan de Evaluaci&oacute;n y Especificaciones 3er Lapso a&ntilde;o escolar 2011-2012</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">1er a&ntilde;o</td>
                </tr>
                <tr>
                  <td width="10%" nowrap class="Tit_Blanco">&nbsp;</td>
                  <td width="10%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_MAT.doc">Matem&aacute;tica</a></td>
                  <td width="10%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_CL.doc">Castellano</a></td>
                  <td width="10%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_HV.doc">Historia</a></td>
                  <td width="10%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_GG.doc">Geograf&iacute;a</a></td>
                  <td width="10%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_EN.doc">Est.Nat.</a></td>
                  <td width="5%" nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_IN.doc">Ingl&eacute;s</a></td>
                  <td width="5%" nowrap class="medium">Ed. Fam. y Ciud. </td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium">&nbsp;</td>
                  <td nowrap class="medium">&nbsp;</td>
                  <td nowrap class="medium">Ed. F&iacute;sica</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_INF.doc">Inform&aacute;tica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_NBO.doc">Noc.Bas.Ofic.</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/1a_iii_IT.doc">Italiano</a></td>
                  <td nowrap class="medium">Ed. Art&iacute;stica</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">2do a&ntilde;o</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_MAT.doc">Matem&aacute;tica</a></td>
                  <td nowrap class="medium">Ed. F&iacute;sica</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_HU.doc">H. Universal</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_HV.doc">H. Venezuela</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_BIO.doc">Biolog&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_IN.doc">Ingl&eacute;s</a></td>
                  <td nowrap class="medium">&nbsp;</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_ES.doc">E.Salud</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_CLa.doc">Castellano A</a></td>
                  <td nowrap class="medium">                  <a href="Publicaciones/20112012/iii/2aSeccionB_iii_CL.doc">Castellano B</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_INF.doc">Inform&aacute;tica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_CNT.doc">Contabilidad</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/2a_iii_IT.doc">Italiano</a></td>
                  <td nowrap class="medium">Ed. Art&iacute;stica</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">3er a&ntilde;o</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_MAT.doc">Matem&aacute;tica</a></td>
                  <td nowrap class="medium">Castellano</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_CatBol.doc">Cat. Bolivariana</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_GeoVzla.doc">Geograf&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_BIO.doc">Biolog&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_IN.doc">Ingl&eacute;s</a></td>
                  <td nowrap class="medium">&nbsp;</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_QUI.doc">Qu&iacute;mica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_FIS.doc">F&iacute;sica</a></td>
                  <td nowrap class="medium">Ed. F&iacute;sica</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_INF.doc">Inform&aacute;tica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_CNT.doc">Contabilidad</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/3a_iii_IT.doc">Italiano</a></td>
                  <td nowrap class="medium">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">4to a&ntilde;o</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_MAT.doc">Matem&aacute;tica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_CL.doc">Castellano</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_HCV.doc">Historia</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_PSC.doc">Psicolog&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_BIO.doc">Biolog&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_IN.doc">Ingl&eacute;s</a></td>
                  <td nowrap class="medium">&nbsp;</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium">Qu&iacute;mica</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_FIS.doc">F&iacute;sica</a></td>
                  <td nowrap class="medium">Ed. F&iacute;sica</td>
                  <td nowrap class="medium">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_IPM.doc">Pre-Militar</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/4a_iii_IT.doc">Italiano</a></td>
                  <td nowrap class="medium">Dibujo T&eacute;cnico</td>
                </tr>
                <tr>
                  <td colspan="8" nowrap class="Tit_Blanco">5to a&ntilde;o</td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_MAT.doc">Matem&aacute;tica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_CAS.doc">Castellano A</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_GeoEco.doc">Geograf&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_CsT.doc">Cs. Tierra</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_BIO.doc">Biolog&iacute;a</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_IN.doc">Ingl&eacute;s</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_FIS.doc">F&igrave;sica</a></td>
                </tr>
                <tr>
                  <td nowrap class="Tit_Blanco">&nbsp;</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_QUI.doc">Qu&iacute;mica</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5aSeccionB_iii_CL.doc">Castellano B</a></td>
                  <td nowrap class="medium">Ed. F&iacute;sica A</td>
                  <td nowrap class="medium">Ed. F&iacute;sica B</td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_IPM.doc">Pre-Militar</a></td>
                  <td nowrap class="medium"><a href="Publicaciones/20112012/iii/5a_iii_IT.doc">Italiano</a></td>
                  <td nowrap class="medium">&nbsp;</td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <table width="700" border="1">
                <tr>
                  <td colspan="5" class="Tit_Blanco">Evaluaciones 3er Lapso</td>
                </tr>
                <tr>
                  <td align="center"><a href="Publicaciones/1a_iii_exlapso.doc">1er a&ntilde;o (A y B)</a></td>
                  <td align="center"><a href="Publicaciones/2a_iii_exlapso.doc">2do a&ntilde;o (A y B)</a></td>
                  <td align="center"><a href="Publicaciones/3a_iii_exlapso.doc">3er a&ntilde;o (A y B)</a></td>
                  <td align="center"><a href="Publicaciones/4a_iii_exlapso.doc">4to a&ntilde;o (A y B)</a></td>
                  <td align="center"><a href="Publicaciones/5a_iii_exlapso.doc">5to a&ntilde;o (A y B</a>)</td>
                </tr>
              </table>
              <p class="Tit_Blanco">&nbsp;</p>
              <p align="center"><span class="Tit_Blanco"><a href="Publicaciones/ManualConvEsc.doc">Manual de convivencia escolar</a></span></p>
<p align="center">desactivado fin
  <?php } ?>
</p>
<p align="center">&nbsp;</p>
<p align="center">Los archivos que est&aacute;n en formato Word  para leerlos debe tener instalado el MS Office</p>
            <p align="center">Los archivos que est&aacute;n en formato PDF  para leerlos debe tener instalado el Adobe Reader</p>
<p align="center">Para las publicaciones de esta p&aacute;gina usamos<br>
  <a href="http://db.tt/aOXvegw4"><img src="i/Dropbox.png" width="135" height="34" border="0"></a><br>
Recomendamos abrir una cuenta
</p>
<p align="center">&nbsp;</p></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td bgcolor="#EECCA6" class="medium">&nbsp;<br>
              <strong class="Tit_Blanco">Calendario Escolar</strong><br>
&nbsp;            </td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td valign="top"><iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=200&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&amp;color=%23853104&amp;ctz=America%2FCaracas" style=" border-width:0 " width="197" height="200" frameborder="0" scrolling="no"></iframe></td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
        </table>
		  <p>&nbsp;</p>
	    <p>&nbsp;</p></td>
  </tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF">
			<img src="img/Pie1.jpg" width="1025" height="9" alt=""></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font></strong></td>
<td bgcolor="#0A1B69">
			<img src="img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
</body>
</html>