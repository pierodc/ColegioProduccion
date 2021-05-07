<?php 
//$MM_authorizedUsers = "2,99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,provee";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$TituloPagina   = "Consulta"; // <title>
$TituloPantalla = "Consulta"; // Titulo contenido

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

if(strlen($_GET["CodigoAlumno"]) > 10 ){
	$CodigoAlumno = $_GET["CodigoAlumno"];
}
$Alumno = new Alumno($CodigoAlumno);


require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
  <meta charset="ISO-8859-1">
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
 <div class="container-fluid">
    <div class="row">
		<div class="col-md-12">
			<div>
             
           
                <h2> Luego de leer la Circular Informativa ¿Está Ud. de acuerdo con el contenido de la presente y apoya su ejecución?   </h2>
               
           		<iframe src="iFr_Voto.php?Canal=<?= $_GET['Canal'] ?>&CodigoAlumno=<?= $CodigoAlumno ?>" scrolling="no" frameborder="0" height="50" width="400" seamless></iframe>
           
           <p>Alumno: <? echo $Alumno->NombreApellido().""; ?><br>
                <br> </p>
            
            <hr>
            	<!-- CONTENIDO -->
                
           
                <p>Caracas, 04/05/2021</p>
                <p>Ciudadanos: Padres, Madres, Representantes y Responsables de la U.E. Colegio San Francisco de As&iacute;s.</p>
                <p>Presente.-                </p>
                <p>Como punto preliminar, reciban un cordial y afectuoso saludo, en la convicci&oacute;n que todos los integrantes de nuestra comunidad se encuentren en perfecto estado de salud, que es lo trascendental en este momento.                </p>
                <p>En esta ocasi&oacute;n, nos dirigimos a ustedes a los efectos de&nbsp;<strong><u>elevar a su consideraci&oacute;n y aprobaci&oacute;n</u></strong>, el acuerdo, que luego de una breve justificaci&oacute;n que expondremos m&aacute;s adelante, ha estimado la Direcci&oacute;n Acad&eacute;mica y Administrativa, como necesaria, apropiada y justa adoptar al personal que labora en nuestra Instituci&oacute;n. Confiados en que la misma ser&aacute; igualmente avalada y aprobada por los padres, madres, representantes y responsables de nuestro plantel, pasamos a exponer lo siguiente:                </p>
                <p>Como es de su conocimiento, en fecha&nbsp;<strong>13 de marzo del a&ntilde;o 2020</strong>, el Ejecutivo Nacional, en persona de su Presidente, dict&oacute; el&nbsp;<strong>Decreto</strong>, mediante el cual se declara&nbsp;<strong>&ldquo;ESTADO DE ALARMA PARA ATENDER LA EMERGENCIA SANITARIA DEL CORONAVIRUS (COVID 19)&rdquo;,</strong>&nbsp;publicado en la&nbsp;<strong>Gaceta Oficial</strong>&nbsp;de la Rep&uacute;blica Bolivariana de Venezuela&nbsp;<strong>N&ordm; 6.519</strong>&nbsp;Extraordinario. En dicho decreto, queda clara y di&aacute;fanamente expresado, en el art&iacute;culo 11 lo siguiente:                </p>
                <p>&ldquo;Se suspenden las actividades escolares y acad&eacute;micas en todo el territorio nacional a partir del d&iacute;a lunes 16 de marzo de 2020, a los fines de resguardar la salud de ni&ntilde;as, ni&ntilde;os y adolescentes, as&iacute; como de todo el personal docente, acad&eacute;mico y administrativo de los establecimientos de educaci&oacute;n p&uacute;blica y privada.&nbsp;<strong>Los Ministros y Ministras del Poder Popular con competencia en materia de educaci&oacute;n, en cualquiera de sus modalidades y niveles, deber&aacute;n coordinar</strong>&nbsp;con las instituciones educativas oficiales y privadas la&nbsp;<strong>reprogramaci&oacute;n de actividades acad&eacute;micas, as&iacute; como la implementaci&oacute;n de modalidades de educaci&oacute;n a distancia o no presencial, a los fines de dar cumplimiento a los programas educativos en todos los niveles</strong>. A tal efecto, quedan facultades para regular, mediante Resoluci&oacute;n, lo establecido en este aparte.&rdquo;</p>
                <p>Especificando de igual forma en las Disposiciones Finales, que el Decreto ser&aacute; prorrogable las veces que sea necesario y hasta que cese el riesgo de contagio, lo cual se encuentra en vigencia total en la actualidad. Aunado a ello, en fecha 14 de abril de 2021, el Ministro del Poder Popular para la Educaci&oacute;n, ratific&oacute;, en todas y cada una de sus partes, el contenido del art&iacute;culo 11 del Decreto de Alarma, anteriormente citado, y asegur&oacute; que durante la pandemia por el COVID-19, el Gobierno de la Rep&uacute;blica garantizar&iacute;a la educaci&oacute;n, a la vez de preservar el derecho a la salud y la vida, lo cual se logra a trav&eacute;s de la&nbsp;<strong><u>educaci&oacute;n a distancia</u></strong>, como una estrategia factible de garantizar el derecho a la educaci&oacute;n, preservando el derecho a la salud y el derecho a la vida en medio de una pandemia que azota a toda la humanidad, para lo cual se giraron las respectivas instrucciones y, as&iacute;, no paralizar el proceso educativo. De igual forma, enfatiz&oacute; y comunic&oacute; tanto a los planteles p&uacute;blicos, como a los privados, que&nbsp;<strong>la educaci&oacute;n a distancia involucra poner en pr&aacute;ctica todas las plataformas comunicacionales existentes</strong>&nbsp;al servicio de la educaci&oacute;n, en especial los medios digitales e impresos y redes sociales.                </p>
                <p>Sin embargo, la novedad a nivel mundial en educaci&oacute;n debe entenderse como un proceso que va m&aacute;s all&aacute; de dar clases por videoconferencia, la misma comprende que hoy el proceso educativo pasa por un entorno virtual. Profesores, de todos los niveles de la educaci&oacute;n, est&aacute;n siendo desafiados a dar sus clases en l&iacute;nea, logrando as&iacute;, que la educaci&oacute;n evolucione a la par de la tecnolog&iacute;a disponible y obliga a los planteles a repensar los modos en que transmitimos y construimos el conocimiento.                </p>
                <p>Muchas did&aacute;cticas, que pueden resultar exitosas, en el campo de la formaci&oacute;n presencial, no son necesariamente eficaces en lo virtual. En efecto, dise&ntilde;ar una clase virtual implica tener en cuenta las caracter&iacute;sticas propias del medio y las posibilidades que brinda. Se trata de un espacio interactivo, hipermedia, din&aacute;mico, estimulante y sobre todo instant&aacute;neo, que ofrece m&uacute;ltiples recursos digitales. Con estas consideraciones, se puede lograr una aut&eacute;ntica experiencia de aprendizaje mediada por la tecnolog&iacute;a.                </p>
                <p>En conclusi&oacute;n, la educaci&oacute;n en l&iacute;nea requiere de un gran trabajo previo de dise&ntilde;o instruccional de los contenidos, el cual involucra a todo el personal. Estos dise&ntilde;os de instrucci&oacute;n, de contenidos por niveles, son realizado por un equipo de expertos en las &aacute;reas disciplinares, como pedagogos, psic&oacute;logos educativos, especialistas en software, dise&ntilde;adores interactivos y gr&aacute;ficos, entre otros; quienes conjuntan sus conocimientos para lograr que una experiencia educativa en l&iacute;nea sea realmente significativa para los estudiantes.                </p>
                <p>Todo ello, porque que existen diferencias entre los&nbsp;<strong>entornos presenciales y los virtuales, debiendo ense&ntilde;ar a los docentes a trabajar en estos &uacute;ltimos</strong>&nbsp;-que necesitan una estructura y contenidos propios-, para que sepan c&oacute;mo llevar a la distancia sus grupos y c&oacute;mo llevar a cabo la socializaci&oacute;n dentro de un aula virtual. Nuestros maestros, han tenido que ingeniar formas e invertir tiempo, e incluso a veces dinero para disponer de megas y, as&iacute;, satisfacer las exigencias pedag&oacute;gicas propias del a&ntilde;o lectivo, atendiendo requerimientos, no solo de alumnos sino orientando a madres, padres y representantes.                </p>
                <p>El Colegio comparte plenamente la situaci&oacute;n que atraviesan los padres y representantes asociadas a esta pandemia, tanto es as&iacute;, que no hemos generado incremento alguno a la mensualidad, solidarios con nuestros padres, pero creemos que el esfuerzo que hacen nuestros docentes y personal en general debe ser honrado. Para ello, concertamos&nbsp;<strong>una asignaci&oacute;n m&iacute;nima mensual</strong>&nbsp;por parte de los padres, madres, representantes y responsables,&nbsp;<strong>&ldquo;De Apoyo Tecnol&oacute;gico&rdquo;</strong>&nbsp;al personal. Siendo el apoyo, equivalente a cinco (5$) d&oacute;lares, por cada estudiante, durante los meses de mayo, junio, julio y agosto, lo cual coadyuvar&aacute; en esos gastos y esfuerzos que, diariamente y con mucha probidad, bridan a la comunidad estudiantil del plantel.                </p>
                <p>Dejamos expresa constancia que esta asignaci&oacute;n que hemos acordado y que, hoy&nbsp;<strong>sometemos a su consulta</strong>, no por ser de car&aacute;cter obligatorio, implica un incremento en la escolaridad, pero si en la mensualidad del Colegio, siendo un aporte a favor de nuestros docentes, motivado en las explicaciones que anteceden y que, estamos seguros, ustedes apoyar&aacute;n y compartir&aacute;n. La misma ser&aacute; exigible al momento del pago de la mensualidad correspondiente a cada mes y para aquellos representantes que cancelaron por adelantado, el llamado es a apoyarnos todos como comunidad.                </p>
                <p>Al agradecer la prontitud de su respuesta quedamos siempre de ustedes.                </p>
                <p>Atentamente&nbsp;</p>
                <p>Direcci&oacute;n Acad&eacute;mica y Direcci&oacute;n Administrativa&nbsp;&nbsp;</p>
<br>
                <p>&nbsp;</p>
           <hr>
           
                <h2> Luego de leer la Circular Informativa ¿Está Ud. de acuerdo con el contenido de la presente y apoya su ejecución?   </h2>
               
           		<iframe src="iFr_Voto.php?Canal=<?= $_GET['Canal'] ?>&CodigoAlumno=<?= $CodigoAlumno ?>" scrolling="no" frameborder="0" height="50" width="400" seamless></iframe>
           
           <p>Alumno: <? echo $Alumno->NombreApellido().""; ?><br>
                <br> </p>
           
			</div>
		</div>
	</div>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>