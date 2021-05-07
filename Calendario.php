<?php require_once('inc_login_ck.php'); ?>
<?php $self = $_SERVER['PHP_SELF']; ?>
<html>
<head>
<title>Colegio San Francisco de As&iacute;s</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
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
            <td rowspan="3" align="center" valign="top" class="box1"><p class="Tit_Pagina">Calendario</p>
              <p><a href="https://www.dropbox.com/sh/3weknravy29zwk0/AADvAOw4Ba0z8NKjNT_1aFF3a?dl=0" target="_blank" class="Tit_Blanco"></a>
                <?php if (!isset($_GET['Nivel']) and !isset($_GET['Curso']) and false) { ?>
              Descargar aqu&iacute; Calendarios</a>
                <?php } ?>
              </p>
              <table width="90%" border="1" cellspacing="0" cellpadding="3">
                <tr>
                  <td width="20%" colspan="2" align="center"><a href="<?php echo $self ?>?Nivel=Preescolar">Preescolar</a></td>
                  <td width="20%" colspan="2" align="center"><a href="<?php echo $self ?>?Nivel=Primaria">Primaria</a></td>
                  <td width="20%" colspan="2" align="center">Bachillerato</td>
                </tr>
                <tr>
                  <td width="15%" align="right" valign="top" nowrap>1er Nivel A<br>
                    2do Nivel A<br>
                    3er Nivel A<br>
                    Preparatorio A</td>
                  <td width="15%" align="right" valign="top" nowrap><br>
                    2do Nivel B<br>
                    3er Nivel B<br>
                    Preparatorio B</td>
                  <td width="15%" align="right" valign="top" nowrap>1er grado A<br>
2do grado A<br>
3er grado A<br>
4to grado A<br>
5to grado A</td>
                  <td width="15%" align="right" valign="top" nowrap>1er grado B<br>
2do grado B<br>
3er grado B<br>
4to grado B<br>
5to grado B</td>
                  <td width="15%" align="right" valign="top" nowrap><a href="<?php echo $self ?>?Curso=1aa">1er a&ntilde;o A</a><br>
                    <a href="<?php echo $self ?>?Curso=2aa">2do a&ntilde;o A</a><br>
                    <a href="<?php echo $self ?>?Curso=3aa">3er a&ntilde;o A</a><br>
                    <a href="<?php echo $self ?>?Curso=4aa">4to a&ntilde;o A</a><br>
                    <a href="<?php echo $self ?>?Curso=5aa">5to a&ntilde;o A</a></td>
				  <td width="15%" align="right" valign="top" nowrap><a href="<?php echo $self ?>?Curso=1ab">1er a&ntilde;o B</a><br>
                    <a href="<?php echo $self ?>?Curso=2ab">2do a&ntilde;o B</a><br>
                    <a href="<?php echo $self ?>?Curso=3ab">3er a&ntilde;o B</a><br>
                    <a href="<?php echo $self ?>?Curso=4ab">4to a&ntilde;o B</a><br>
                    <a href="<?php echo $self ?>?Curso=5ab">5to a&ntilde;o B</a></td>
                </tr>
              </table>
              <p>
                <?php if ($_GET['Nivel']=='Preescolar'){ ?>
                Haga click sobre los eventos para ver m&aacute;s detalles                  <br>
                    Ver leyenda 
                  m&aacute;s abajo</p>
              <iframe src="https://www.google.com/calendar/embed?title=Preescolar&height=600&wkst=1&bgcolor=%23FFFFFF&src=ct2id4qvurac9d9deduh1o0uds%40group.calendar.google.com&color=%230D7813&src=7ebf2rap0i6t119vbc7hbfeaqg%40group.calendar.google.com&color=%23B1440E&src=3b7ohvqbqku9ar91ourjm1pnvk%40group.calendar.google.com&color=%2328754E&src=8r4h10q7guqre2j1m59p2qiicc%40group.calendar.google.com&color=%235229A3&src=rtg0jkhp4gccg85k9n1q5n8ej0%40group.calendar.google.com&color=%234A716C&src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&color=%23853104&src=91qecfl4dg3ppi4tgfno3mrflk%40group.calendar.google.com&color=%238D6F47&src=2se0enm7jrffbce46c0j56tp3c%40group.calendar.google.com&color=%2388880E&ctz=America%2FCaracas" style=" border:solid 1px #777 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
              
              <?php } elseif ($_GET['Nivel']=='Primaria'){ ?>
              
              <iframe src="https://www.google.com/calendar/embed?title=Primaria&height=600&wkst=1&bgcolor=%23FFFFFF&src=app53kd83e6h4ra6s68angpki0%40group.calendar.google.com&color=%23856508&src=2fkqrs6ro1klgeqt0r3ojv7gac%40group.calendar.google.com&color=%238C500B&src=aaenm2nh91iibbipfo93ul4qq4%40group.calendar.google.com&color=%2342104A&src=b9phv2ovr29drhqaukej82csmg%40group.calendar.google.com&color=%232F6309&src=vp56ps69lnec9qh4phq76nu0qk%40group.calendar.google.com&color=%23113F47&src=fgrme4uugn8mshomn6en31b28g%40group.calendar.google.com&color=%235C1158&src=du0lb3dr1jre5ad1grctpkb52c%40group.calendar.google.com&color=%23060D5E&src=vpqlb2dabaqct1b5ot8fequh4c%40group.calendar.google.com&color=%23754916&src=061hu5olof8m8fsv8isqphp6fs%40group.calendar.google.com&color=%235B123B&src=5iib3cbldv0a76va51ht3g1pk4%40group.calendar.google.com&color=%23333333&src=hhtckupgv661ceak5j6gfc3cf4%40group.calendar.google.com&color=%23A32929&src=kqs473t8pp8n6rsm40g234dbu4%40group.calendar.google.com&color=%23AB8B00&src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&color=%23853104&ctz=America%2FCaracas" style=" border:solid 1px #777 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
              

			  <p>
  <?php } elseif (isset($_GET['Curso'])){ ?>
			    
			    
			    
			    
			    
			    
			    
  <?php 
$Curso = $_GET['Curso'];
switch ($Curso) {
    case '1aa':
        $cal = "8a70mtss2tfi4h2u0hlll6i9k4"; $Curso = "1er Año A";
		$cal_EV = "pjo52t8a6uejetlq8g5isbf3pk";
		break;
    case '1ab':
        $cal = "227ifadht99o3purjqmd21n324"; $Curso = "1er Año B";
		$cal_EV = "ga3cf7p17ufhdm59ri0681rdb8";
		break;
    case '2aa':
        $cal = "g9cd8o43idua8l23k0f5qfespc"; $Curso = "2do Año A";
		$cal_EV = "d1ueeame6dbomc0mkq75kkrulk";
		break;
    case '2ab':
        $cal = "afu8m5qfgmqqacbifqt1lter4c"; $Curso = "2do Año B";
		$cal_EV = "4r4qffmbdfrm1gm9u1d78kci00";
		break;
    case '3aa':
        $cal = "4j8sm30r659j5aie89oftrrcu8"; $Curso = "3er Año A";
		$cal_EV = "accq8tqnqtkg4v10c7vbtfcrho";
		break;
    case '3ab':
        $cal = "2ab2fkftcgs7rqa39gil0ntp5c"; $Curso = "3er Año B";
		$cal_EV = "kjde9o6ruej6o7ihb9etahm07c";
		break;
    case '4aa':
        $cal = "233f5bhsqmqhgjguus8rbiehuo"; $Curso = "4to Año A";
		$cal_EV = "lf9anohfh1976n85o91njnn8as";
		break;
    case '4ab':
        $cal = "7vflrhf6vgqs848glsjkdgrms8"; $Curso = "4to Año B";
		$cal_EV = "5a5ctlt4h733aeuqlcepu4pmeo";
		break;
    case '5aa':
        $cal = "m0fefffk7r0ugpvr2gqsc6pnbc"; $Curso = "5to Año A";
		$cal_EV = "ro4k3h1mu92aemuvqbjebjvt0g";
		break;
    case '5ab':
        $cal = "3h8k2tir4ib1i7lk0gppmg40mc"; $Curso = "5to Año B";
		$cal_EV = "cqvbl22gjo9f87ic7o343hkhk8";
		break;
    } 


?>               
		    
		      </p>
			  <p><a href="
https://calendar.google.com/calendar/ical/<?php echo $cal; ?>%40group.calendar.google.com/public/basic.ics">Conectarse con iCal<br>
		      <img src="i/calendar_link.png" width="32" height="32"></a></p>
			  <iframe src="https://www.google.com/calendar/embed?title=<?php echo $_GET['Nivel'].' '.$Curso ?>&height=600&wkst=1&bgcolor=%23FFFFFF&src=<?php 
			  echo $cal_EV ?>%40group.calendar.google.com&color=%23853104&src=<?php 
			  echo $cal ?>%40group.calendar.google.com&src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&color=%231B887A&ctz=America%2FCaracas" style=" border:solid 1px #777 " width="800" height="600" frameborder="0" scrolling="no"></iframe>
              
              
              <?php }else{ ?>
            <p align="left"></p>
            <?php } ?>
            <?php if (true){ ?>
            
            <table width="80%">
              <tr>
                <td colspan="2"><strong>Leyenda</strong> para entender los calendarios escolares (MATERIA - ACTIVIDAD - DETALLES)</td>
              </tr>
              <tr>
                <td width="50%" valign="top" class="NombreCampo">Materias</td>
                <td width="50%" valign="top" class="NombreCampo">Actividades Evaluativas</td>
              </tr>
              <tr>
                <td valign="top" class="FondoCampo"> BIO: Biología/Ciencias Biológicas. <br>
CB: Cátedra Bolivariana. <br>
CNT: Contabilidad.
CsT: <br>
Ciencias de la Tierra. <br>
CL: Castellano y Literatura. <br>
DT: Dibujo Técnico. <br>
EA: Educación Artística. <br>
EF: Educación Física. <br>
EFC: Educación Familiar y Ciudadana. <br>
EN: Estudios de la Naturaleza. <br>
ES: Educación para la Salud. <br>
FIS: Física. <br>
GEV: Geografía Económica de Venezuela. <br>
GG: Geografía General. <br>
GV: Geografía de Venezuela. <br>
HCV: Historia Contemporánea de Venezuela. <br>
HU: Historia Universal. <br>
HV: Historia de Venezuela. <br>
IN: Inglés. <br>
INF: Informática (Computación).<br>
IT: Italiano.<br>
IPM: Instrucción Pre Militar. <br>
MAT: Matemática. <br>
NBO: Nociones Básicas de Oficina. <br>
PSC: Psicología. <br>
QUI: Química. <br>
TE: Técnicas de Estudio. <br>
TT: Taller de Tesis. </td>
                <td valign="top" class="FondoCampo"><p>                  AL: Adaptación de lectura de obra <br>
                  AP: Actividad práctica. <br>
                  ANA: Análisis
                  <br>
                  Cart: Cartelera<br>
                  CC: Cuadro Comparativo<br>
                  CL: Control de lectura<br>
                  DB: Debate<br>
                  DF: Diagrama de flujo<br>
                  Dis: Discurso
                  <br>
                  DM: Dramatizaci&oacute;n<br>
                  Demos: Demostración<br>
                  EE: Ejercicio escrito.<br>
                  EQ: Esquema. <br>
                  Eny: Ensayo<br>
                  ESC: Escucha
                  <br>
                  EXP: Exposición<br>
                  FR: Foro<br>
                  Guía<br>
                  HB: Herbario<br>
                    HM: Hemeroteca<br>
                    INF: Informe<br>
                    INT: Interrogatorio<br>
                    LyC: Libro / Cuaderno
                    <br>
                    P: Prueba<br>
                    PC: Prueba corta. <br>
                    PR: Programa. <br>
                    PO: Prueba Oral<br>
                    Pro: Proyecto
                    <br>
                    PT: Presentación Teatral
                    <br>
                    Rally: Rally<br>
                    RC: Revisión de cuadernos.<br>
                    RV: Revista<br>
                    SI: Síntesis<br>
                    SM: Simulación<br>
                    Tall: Taller<br>
                    TR: Tarea<br>
                    TG: Trabajo en guía<br>
                    TGr: Trabajo gr&aacute;fico<br>
                    TI: Trabajo de investigación <br>
                    TP: Trabajo Práctico<br>
                    MC: Mapa conceptual<br>
                    MM: Mapa mental<br>
                    MQ: Maqueta<br>
                    MR: Mesa redonda<br>
                  </p>
                  <p><strong>Detalles:</strong><br>
                    Obj: Objetivo<br>
                Objs Objetivos</p></td>
              </tr>
            </table>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p><br>
            </p> 
<?php } ?>
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
            <td valign="top"><iframe src="https://www.google.com/calendar/embed?mode=AGENDA&showTitle=0&showNav=0&showPrint=0&showTabs=0&showCalendars=0&showTz=0&height=400&wkst=1&bgcolor=%23FFFFFF&src=4jbg2b5gv8s8msitgibfbhbkis%40group.calendar.google.com&color=%23853104&ctz=America%2FCaracas" style=" border-width:0 " width="197" height="400" frameborder="0" scrolling="no"></iframe></td>
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