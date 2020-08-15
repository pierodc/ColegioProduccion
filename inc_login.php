<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=205772959553604";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
<tr>
<td width="150" align="center" nowrap ><a href="https://twitter.com/colegiosfa" class="twitter-follow-button" data-show-count="true" data-lang="es" data-size="medium" data-show-screen-name="true">Seguir a @colegiosfa</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
<td align="right" nowrap  class="mediumSmall"><div class="fb-like" data-href="https://www.facebook.com/pages/Colegio-San-Francisco-de-As%C3%ADs/37779616966" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div></td>
<td align="right" nowrap class="mediumSmall"><?php if (isset($_COOKIE['error']) and $_GET['error']=='login'){?><span class="MensajeDeError"><strong><font color="#990000">usuario o clave inv&aacute;lida&nbsp;</font></strong></span>
<?php }  ?>&nbsp;</td>
<?php if (isset($_COOKIE['MM_Username']) and $_COOKIE['MM_Username']>''){  ?>
<td width="25" align="right" nowrap class="mediumSmall"><span class="Tit_Blanco"><?php echo $MM_Username; ?>&nbsp;&nbsp;</span></td>
<td width="25" align="right" nowrap><a href="<?php echo $_SERVER['PHP_SELF']."?LogOut=1" ?>">Salir</a></td>
<?php } else {  ?>
<td align="right" nowrap class="mediumSmall">
<form name="form1" method="post" action=""><table border="0" cellpadding="0" cellspacing="0">
<tr>
<td nowrap="nowrap" class="mediumSmall">Email/Usuario:</td>
<td nowrap="nowrap" class="mediumSmall">
<input name="Usuario" type="text"  class="mediumMSmall" id="Usuario" value="<?php if(isset($_GET['Login'])) echo $_GET['Login']; ?>" size="15" /></td>
</tr>
<tr>
<td nowrap="nowrap" class="mediumSmall">Clave:</td>
<td nowrap="nowrap" class="mediumSmall">
<input name="Clave" type="password"  class="mediumMSmall" id="Clave" value="<?php if(isset($_GET['Psw'])) echo $_GET['Psw']; ?>" size="15" />
<input type="submit" name="button" id="button" value="Entrar"  class="mediumSmall" /></td>
</tr>
</table></form></td>
<?php if (!$_iPhone){ 
?><td width="150" align="center" valign="top" nowrap class="mediumSmall"><a href="intranet/RegistroUsuario.php">Reg&iacute;strese</a> para ingresar<br />
<a href="intranet/RecuperaClave.php">&iquest;Olvid&oacute; su clave?</a>
</td><?php }  } ?>
</table>