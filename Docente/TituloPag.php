<?php 
	$MM_Username  = $_COOKIE['MM_Username'];
	$MM_UserGroup  = $_COOKIE['MM_UserGroup'];
?><table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="50%" align="left"><img src="http://www.colegiosanfrancisco.com/img/NombreCol_az.jpg" width="221" height="50" longdesc="Colegio San Fco de Asis"></td>
    <td width="50%" align="right"><?php echo $MM_Username." ".$MM_UserGroup."<br>". $Acceso_US ;
	 ?><br><a href="<?php echo $_SERVER['../intranet/a/PHP_SELF']; ?>?LogOut=1">Salir</a></td>
  </tr>
  <tr>
    <td colspan="2"><div align="right" class="TituloPagina"><?php echo $TituloPantalla; ?></div></td>
  </tr>
  <tr>
    <td align="left" colspan="2">
    <?php  //require_once('../intranet/a/menu_intranet_a.php'); ?>
    <a href="index.php">Inicio</a> - <a href="../CambioClave.php">Cambiar Clave</a> - <a href="Boleta.php">Boletas</a></td>
  </tr>
</table>