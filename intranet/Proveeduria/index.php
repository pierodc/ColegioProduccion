<?php 
$MM_authorizedUsers = "2,91,docente,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


if (isset($_COOKIE['MM_Username'])) {
  $MM_Username = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
}

if(isset($_GET["Usuario"]) and $_GET["Usuario"]>""){
	$MM_Username = $_GET["Usuario"];
	}

$Curso = new Curso($_GET['CodigoCurso']);
$Usuario = new Usuario($MM_Username);
//echo 'MM_Username '.$MM_Username . $Usuario->id;

$CambioParalelo = $Cambio_Paralelo;

?>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Colegio San Francisco de As&iacute;s</title>

<link rel="shortcut icon" href="/img/favicon.ico">
<link href="../../css/Level2_Arial_Text.css" rel="stylesheet" type="text/css">
<link href="../../estilos.css" rel="stylesheet" type="text/css">
<link href="../../estilos2.css" rel="stylesheet" type="text/css">
<style type="text/css">

</style>
</head>
<body bgcolor="e7e7e9" leftmargin="0" topmargin="20" marginwidth="0" marginheight="0"  >
<!-- ImageReady Slices (index.psd) -->
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
<tr>
		<td bgcolor="#FFF8E8">
			<img src="/img/index_01.jpg" width="31" height="191" alt=""></td>
		<td colspan="2" align="left" bgcolor="#0A1B69">
			<img src="/img/TitSol.jpg" width="197" height="191" alt=""><img src="/img/TituloAzul.jpg" width="766" height="191" alt="Colegio San Francisco de Asis"></td>
		<td bgcolor="#FFF8E8">
			<img src="/img/index_04.jpg" width="31" height="191" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
			<img src="/img/index_05.jpg" width="1025" height="7" alt=""></td>
	</tr>
	<tr>
		<td align="center" bgcolor="#F7F1E1">
			<img src="/img/index_06.jpg" width="31" height="68" alt=""></td>
		<td bgcolor="#F7F1E1">&nbsp;</td>
		<td align="center" bgcolor="#F7F1E1">&nbsp;</td>
  <td bgcolor="#FFF8E8">
			<img src="/img/index_09.jpg" width="31" height="68" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" align="center" bgcolor="#F7F1E1">
			<img src="/img/index_10.jpg" width="1025" height="6" alt=""></td>
	</tr>
	<tr>
		<td colspan="4" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
            <td colspan="2"><?php include('../../inc_login.php'); ?></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td width="31" bgcolor="#D1D0B4">&nbsp;</td>
            <td width="197" valign="top" bgcolor="#EBE4C8">
<?php include("../../inc_menu.php"); ?></td>
            <td rowspan="3" align="center" valign="top" class="box1">
<img src="/img/b.gif" width="740" height="1"><br>
<table width="98%"  border="0" align="center" cellspacing="5" cellpadding="2">
  <tr>
    <td width="100%" colspan="2" align="center" class="NombreCampoBIG" ><p>Proveeduria</p>
        <p>La fecha estimada de proxima entrega es el 20 de octubre</p></td>
  </tr>
  
  
  <tr>
    <td width="50%" align="center"  class="ListadoNotasBC2">
      <? if (!isset($_GET["CodigoCurso"])) { ?>
       <p class="ConflictoHorario">Seleccione el curso</p>
       <? } ?>
       <p>
        Curso:  <? Ir_a_Curso($_GET['CodigoCurso'],$php_self."?CodigoCurso=", $MM_UserGroup ="" , $MM_Username="") ?></p></td>
    <td width="50%" align="center"  class="ListadoNotasBC2"><img src="../../img/shopping-cart-icon-vector-12712570.jpg" width="45" height="40" alt=""/></td>
  </tr>
  
  
  
  
  
  <tr>
    <td align="center" valign="top" >
       <? if (isset($_GET["CodigoCurso"]) and false) { ?>
        <table width="100%" border="0">
            <tbody>
                <tr class="subtitle">
                    <td colspan="5">Listado de productos</td>
                    </tr>
                   <tr class="NombreCampoTITULO">
                    <td>Categoria</td>
                    <td>Titulo</td>
                    <td align="right">P</td>
                    <td align="right">P</td>
                    <td>Solicitar</td>
                    
                </tr>
                <? 
	
				$NivelCurso = $Curso->NivelCurso;
				if($NivelCurso > ""){
				$sql = "SELECT * FROM Inventario 
						WHERE ( Nivel_Curso LIKE '%$NivelCurso%'
						OR Nivel_Curso LIKE '%00%' )
						AND Precio_Dolares > 0
						ORDER BY Nivel_Curso DESC
						";
		
				//echo $sql;		
				$RS = $mysqli->query($sql);
				while ($row = $RS->fetch_assoc()) {
				extract($row);
				?>
                   <? if($Cat1_Ante != $Cat1){ ?>
                  <tr><td colspan="5"><?= $Cat1 ?></td></tr>
                  <? } ?>
                  
                   <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
                    <td valign="middle" nowrap="nowrap"><? //$Cat1."-".$Cat2."-".$Cat3 ?>&nbsp;</td>
                    <td valign="middle"><?= $Descripcion ?>&nbsp;</td>
                    <td align="right" valign="middle" nowrap="nowrap"><?= Fnum($Precio_Dolares) ?>&nbsp;</td>
                    <td align="right" valign="middle" nowrap="nowrap"><?= Fnum($Precio_Dolares*$CambioParalelo) ?>&nbsp;</td>
                	<td align="right" valign="middle" nowrap="nowrap">&nbsp;<a href="Carrito.php?Agregar=<?= $id ?>" target="Carrito"><img src="../../i/bullet_add.png" width="32" height="32" alt=""/></a></td>
                  </tr>
                  
                  
                <? 
				$Cat1_Ante = $Cat1;
				} }?>
                
            </tbody>
        </table>
        <? } ?>
        </td>
    <td align="center" valign="top" ><iframe src="Carrito.php?Usuario=<?= $_GET["Usuario"] ?>" width="100%" height="400" id="Carrito"  name="Carrito" frameborder="0"></iframe></td>
  </tr>
  
  
  
  <tr>
    <td colspan="2" align="center">
		<iframe src="/inc/Observacion.php?Area=Proveeduria&Codigo=<?= $Usuario->id ?>" width="100%"></iframe>
		</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
<?php if (false){ ?>  
<?php } ?>
  
  <tr>
    <td colspan="2" align="center" class="TextosSimples">Si necesita asistencia con el uso del sistema, <br>
      env&iacute;e un email a: <a href="mailto:piero@sanfrancisco.e12.ve">piero@sanfrancisco.e12.ve</a> o <br>
       por Whatsapp  0414.303.44.44</td>
  </tr>
</table></td>
            <td width="31" bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#DBBE96">&nbsp;</td>
            <td valign="top" bgcolor="#EECCA6" class="medium">&nbsp;</td>
            <td bgcolor="#FFF8E8">&nbsp;</td>
          </tr>
          <tr>
            <td bgcolor="#FFF8E8">&nbsp;</td>
            <td valign="top">&nbsp;</td>
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
		<td colspan="4" align="center" bgcolor="#54587D">
			<p><img src="/img/Pie1.jpg" width="1025" height="9" alt=""></p></td>
	</tr>
	<tr>
		<td bgcolor="#0A1B69">
			<img src="/img/PieA.jpg" width="31" height="58" alt=""></td>
		<td colspan="2" align="center" bgcolor="#0A1B69"><strong class="medium"><font color="#FFFFFF">Todos los derechos reservados Colegio San Francisco de As&iacute;s &copy; 2010</font> </td>
<td align="right" bgcolor="#0A1B69">
			<img src="/img/PieB.jpg" width="31" height="58" alt=""></td>
	</tr>
</table>
<!-- End ImageReady Slices -->
<?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>
</html><?php  ?>