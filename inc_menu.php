<p class="Menu_Niv_1">&nbsp;</p>
<p class="Menu_Niv_1"><a href="index.php" class="Menu_Link">Inicio</a></p>
<?php if (isset($_COOKIE['MM_Username'])){ 

	$Intranet = "http://www.colegiosanfrancisco.com/intranet/a/index.php";
	if($_COOKIE['Privilegios'] == '2')
 		$Intranet = "http://www.colegiosanfrancisco.com/intranet/index.php";
	if($_COOKIE['Privilegios'] == 'docente')
		$Intranet = "http://www.colegiosanfrancisco.com/Docente/index.php";




?>
<p class="Menu_Niv_1"><a href="<?php echo $Intranet ?>" class="Menu_Link">Intranet</a></p>
<?php } ?>
<p class="Menu_Niv_1"><a href="/Publicaciones.php" class="Menu_Link">Publicaciones</a></p>
<p class="Menu_Niv_2"><a href="/Descargas.php" class="Menu_Link">Listas de &uacute;tiles</a></p>
<p class="Menu_Niv_2"><a href="/Publicaciones.php" class="Menu_Link">Planes de Evaluaci&oacute;n</a></p>
<!--p class="Menu_Niv_2"><a href="/Horario.php" class="Menu_Link">Horarios de Clase</a></p-->
<p class="Menu_Niv_2"><a href="/Calendario.php" class="Menu_Link">Calendarios</a></p>
<p class="Menu_Niv_1"><a href="/Eventos.php" class="Menu_Link">Eventos</a></p>
<p class="Menu_Niv_1"><a href="https://www.google.com/a/sanfrancisco.e12.ve" class="Menu_Link">Correo Interno</a></p>