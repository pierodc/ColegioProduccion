

<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<ul id="MenuBar1" class="MenuBarHorizontal">
  <li><a class="MenuBarItemSubmenu" href="#">Intranet</a>
      <ul>
        <li><a href="../intranet/index.php">Planilla de Inscripci&oacute;n</a></li>
    </ul>
  </li>
</ul>
<?php if ($_SESSION['MM_UserGroup']=='99'){ ?>
<ul id="MenuBar2" class="MenuBarHorizontal">
  <li><a class="MenuBarItemSubmenu" href="#">Buscar</a>
      <ul>
        <li><a href="../intranet/a/ListaAlumnos.php">Alumno</a></li>
        <li><a href="../intranet/a/ListaCurso.php" class="MenuBarItemSubmenu">Curso</a>
          <ul>
            <li><a href="../intranet/a/EstadisticaCursos.php">Estadisticas</a></li>
          </ul>
        </li>
        <li><a href="../intranet/a/Usuarios.php">Usuario</a></li>
    </ul>
  </li>
</ul>
<?php } ?><script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
