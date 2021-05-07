<?php require_once('inc_login_ck.php'); ?>
<?php $self = $_SERVER['PHP_SELF']; ?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
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
            <td rowspan="3" align="center" valign="top" class="box1"><p class="Tit_Pagina">Horario de clases</p>
            <?php if(1==1) if (!isset($_GET['Nivel']) and !isset($_GET['CodigoCurso'])) { ?>
              <table width="200" border="1" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="20%" colspan="2" align="center">Bachillerato</td>
                </tr>
                <tr>
                  <td width="15%" align="center" valign="top" nowrap>
                    <a href="PDF/Horario.php?CodigoCurso=35" target="_blank">1er a&ntilde;o A</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=37" target="_blank">2do a&ntilde;o A</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=39" target="_blank">3er a&ntilde;o A</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=41" target="_blank">4to a&ntilde;o A</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=43" target="_blank">5to a&ntilde;o A</a></td>
				  <td width="15%" align="center" valign="top" nowrap>
                  	<a href="PDF/Horario.php?CodigoCurso=36" target="_blank">1er a&ntilde;o B</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=38" target="_blank">2do a&ntilde;o B</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=40" target="_blank">3er a&ntilde;o B</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=42" target="_blank">4to a&ntilde;o B</a><br>
                    <a href="PDF/Horario.php?CodigoCurso=44" target="_blank">5to a&ntilde;o B</a></td>
                </tr>
              </table>
              <?php }else{ include('Horario_Print.php'); } ?>
             
</td>
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
            <td valign="top"><iframe src="https://www.google.com/calendar/embed?mode=AGENDA&amp;showTitle=0&amp;showNav=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=400&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&amp;color=%23853104&amp;ctz=America%2FCaracas" style=" border-width:0 " width="197" height="400" frameborder="0" scrolling="no"></iframe></td>
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