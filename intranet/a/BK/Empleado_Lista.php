<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad";
require_once('../../inc_login_ck.php'); 

require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 



mysql_select_db($database_bd, $bd);
$query_RS_Empleados = "SELECT * FROM Empleado ORDER BY SW_activo DESC, Apellidos, Nombres ASC";
$RS_Empleados = mysql_query($query_RS_Empleados, $bd) or die(mysql_error());
$row_RS_Empleados = mysql_fetch_assoc($RS_Empleados);
$totalRows_RS_Empleados = mysql_num_rows($RS_Empleados);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/PlantillaAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
 
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administraci&oacute;n SFDA</title>
<!-- InstanceEndEditable -->
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
a:link {
	color: #0000FF;
	text-decoration: none;
}
-->
</style>

<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-family: "Times New Roman", Times, serif;
	color: #000066;
}
.style3 {font-size: 12px}
a:visited {
	color: #0000FF;
	text-decoration: none;
}
a:hover {
	color: #CCCC00;
	text-decoration: underline;
}
a:active {
	color: #FF0000;
	text-decoration: none;
}
-->
</style>
<link href="../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" align="center">
  <tr>
    <td width="50%" align="left" nowrap="nowrap">
      <table width="300" border="0">
        <tr>
          <td nowrap="nowrap" bgcolor="#FFFF99"><p align="center" class="style1"><span class="style3">COLEGIO</span><br />
  Colegio San Francisco de As&iacute;s<br />
  <span class="style3">Los Palos Grandes</span> </p>
          </td>
        </tr>
      </table>
      </div>
    <div align="left"></div></td>
    <td width="50%" align="right"><span class="Boton"><?php echo $_SESSION['MM_Username'] ?> <a href="<?php echo $logoutAction ?>">Salir</a></span></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><!-- InstanceBeginEditable name="Titulo" -->
    <div align="right" class="TituloPagina"> Empleados</div>
    <!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><ul id="MenuBar2" class="MenuBarHorizontal">
      <li><a class="MenuBarItemSubmenu MenuBarItemSubmenu" href="index.php">Inicio</a></li>
      <li><a href="ListaAlumnos.php">Alumnos</a></li>
      <li><a href="ListaCurso.php" class="MenuBarItemSubmenu">Cursos</a>
          <ul>
            <li><a href="ListaCurso.php?CodigoCurso=14">Listato</a></li>
            <li><a href="EstadisticaCursos.php">Estadistica</a></li>
            <li><a href="ListaGeneral.php">Todos</a></li>
          </ul>
      </li>
      <li><a href="Pagos_Conciliar.php" class="MenuBarItemSubmenu">Pagos</a>
          <ul>
            <li><a href="ListaAlumnos.php">por Alumnos</a></li>
            <li><a href="Sube_Arch_Banco.php" class="MenuBarItemSubmenu"> Banco</a>
              <ul>
                <li><a href="Busca_Banco.php">Buscar</a></li>
              </ul>
            </li>
            <li><a href="Pagos_Conciliar.php">Verificar Pagos</a></li>
            <li><a href="Asignaciones.php">Asignaciones</a></li>
          </ul>
      </li>
      <li><a href="Usuarios.php">Usuarios</a></li>
      <li><a href="Empleado_Lista.php">Empleados</a></li>
    </ul></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><!-- InstanceBeginEditable name="Contenido" -->
      <a href="Empleado_Edita_Lista.php">Lista</a>
      <table width="100%" border="0">
        <tr>
          <td nowrap="nowrap" class="NombreCampoTopeWin">Apellidos, Nombres</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">F Nac</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">T Hab</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">T Cel</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">T Otro</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">Email</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">&nbsp;</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">&nbsp;</td>
          <td nowrap="nowrap" class="NombreCampoTopeWin">Sueldo Base</td>
        </tr>
        <?php do { ?>
          <tr>
            <td nowrap="nowrap" class="FondoCampo"><a href="Empleado_Edita.php?CodigoEmpleado=<?php echo $row_RS_Empleados['CodigoEmpleado']; ?>"><?php echo $row_RS_Empleados['Apellidos']; ?>, <?php echo $row_RS_Empleados['Nombres']; ?></a></td>
            <td nowrap="nowrap" class="FondoCampo"><?php echo DDMMAAAA($row_RS_Empleados['FechaNac']); ?></td>
            <td class="FondoCampo"><?php echo $row_RS_Empleados['TelefonoHab']; ?></td>
            <td class="FondoCampo"><?php echo $row_RS_Empleados['TelefonoCel']; ?></td>
            <td class="FondoCampo"><?php echo $row_RS_Empleados['TelefonoOtro']; ?></td>
            <td class="FondoCampo"><?php echo $row_RS_Empleados['Email']; ?></td>
            <td class="FondoCampo"><a href="Empleado_Recibo.php?CodigoEmpleado=<?php echo $row_RS_Empleados['CodigoEmpleado'] ?>&c1=Utilidades&t1=<?php echo $row_RS_Empleados['MesesLaborados'] ?>&c2=Aguinaldo&t2=<?php echo $row_RS_Empleados['MesesLaborados'] ?>" target="_blank">Recibo</a></td>
            <td class="FondoCampo">&nbsp;</td>
            <td align="right" class="FondoCampo"><div align="right"><?php echo $row_RS_Empleados['SueldoBase']; ?></div></td>
          </tr>
          <?php } while ($row_RS_Empleados = mysql_fetch_assoc($RS_Empleados)); ?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
    <!-- InstanceEndEditable --></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"../SpryAssets/SpryMenuBarDownHover.gif", imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>

</body>

<!-- InstanceEnd --></html>
<?php
mysql_free_result($RS_Empleados);
?>
