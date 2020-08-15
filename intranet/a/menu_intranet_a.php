<?php 
$URLbase = 'http://www.colegiosanfrancisco.com/';
$URLadmin = 'http://www.colegiosanfrancisco.com/intranet/a/';



?><!--
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://www.colegiosanfrancisco.com/intranet/a/index.php">Intranet</a>
    </div>




<div>
<ul class="nav navbar-nav">


      <li><a href="<?php echo $URLadmin ?>index.php"><img src="<?php echo $URLbase ?>i/house.png" width="20" height="20" border="0"/></a></li>
      <li><a href="<?php echo $URLadmin ?>index.php" class="MenuBarItemSubmenu" >Inicio</a></li>
      <li><a href="<?php echo $URLadmin ?>ListaAlumnos.php">Alumnos</a></li>
      <li><a href="<?php echo $URLadmin ?>Lista/Curso_Mant.php" class="MenuBarItemSubmenu">Cursos</a>
          <ul>
            <li><a href="ListaCurso_Notas.php">Notas</a></li>
            <li><a href="<?php echo $URLadmin ?>PDF/Estadistica_Curso.php" target="_blank">Estad. Alumnos</a></li>
            <li><a href="Mant_Aulas.php">Aulas</a></li>
            <li><a href="<?php echo $URLadmin ?>Academico/Cursos_Mantenimiento.php">Docente Gu&iacute;a</a></li>
            <li><a href="Cursos_Mant_Prof.php">Prof Bach</a></li>
            <li><a href="Lista/Menu_Cursos_Excel.php">Lista Excel</a></li>
          </ul>
  </li>
  

      <li><a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo $URLadmin ?>Pagos_Conciliar.php" class="MenuBarItemSubmenu">Caja <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo $URLadmin ?>Sube_Arch_Banco.php"> Carga Banco</a></li>
          <li class="MenuBarItemSubmenu"><a href="<?php echo $URLadmin ?>Egreso_de_Caja.php">Egresos</a></li>
          <li class="MenuBarItemSubmenu"><a href="<?php echo $URLadmin ?>Contabilidad/Gastos.php">Gastos</a></li>
          <li><a href="<?php echo $URLadmin ?>Contabilidad/Banco_Busca.php">Buscar Banco</a> </li>
          <li><a href="<?php echo $URLadmin ?>Pagos_Conciliar.php">Verificar Pagos</a></li>
          <li><a href="<?php echo $URLadmin ?>Contabilidad/Asignaciones.php">Asignaciones</a></li>
          </ul>
</li>




      <li><a href="<?php echo $URLadmin ?>Usuarios.php">Usuarios</a></li>
      <li><a href="<?php echo $URLadmin ?>Empleado/index.php">Empleados</a>
        <ul>
          <li><a href="<?php echo $URLadmin ?>Empleado/Lista.php?Limit=0&CantEmpPantalla=5&TipoEmpleado=">Lista</a></li>
          <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_Pago.php?Ano=<?php echo date('Y'); ?>&Mes=<?php echo date('m'); ?>&Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>">Nomina de Pago</a>            
            <ul>
              <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_Pago.php?Ano=<?php echo date('Y'); ?>&Mes=<?php echo date('m'); ?>&Quincena=<?php if(date('d')<=15) echo '1ra'; else echo '2da'; ?>" target="_blank">Imprimir</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Nomina">Archivo TXT Nomina</a> </li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Pago_extra">Archivo TXT Pago_extra</a> </li>
            </ul>
          </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/BonoAlim_Lista.php">Bono Alim</a>            
            <ul>
              <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_BonoAlim.php?Ano=<?php echo date('Y'); ?>&Mes=<?php echo date('m'); ?>" target="_blank">Imprimir</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=BonoAlimentacion"> Archivo TXT</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=BonoAlimentacionExtra"> Archivo TXT Extra</a></li>
            </ul>
          </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_Fideicomiso.php">Fideicomiso</a>    
            <ul>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncrementoFide">Archivo Incremento TXT</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncrementoFideAnual">Archivo Incremento Anual TXT</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=AdelantoFide">Archivo Adelanto TXT</a></li>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncorporaFide">Archivo Incorpora TXT</a></li>
            </ul>
          </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=LPH">Ley P. Hab.
            </a>          
            <ul>
              <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=LPH">Archivo TXT</a></li>
            </ul>
          </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IVSS1312">I.V. S.S.</a>
            <ul>
          <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IVSS1312">Archivo 13-12</a></li>
          </ul>
          </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/Feriados.php">Feriados</a> </li>
          <li><a href="<?php echo $URLadmin ?>Empleado/Lista_Excel.php">Lista Excel</a> </li>
        </ul>
      </li>
  <ul>
  </ul>
  </ul>
    </div>






    <div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Page 1</a></li>
        <li><a href="#">Page 2</a></li>
        <li><a href="#">Page 3</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Page 1-1</a></li>
            <li><a href="#">Page 1-2</a></li>
            <li><a href="#">Page 1-3</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

-->

<ul id="MenuBar2" class="MenuBarHorizontal">



      <li><a href="<?php echo $URLadmin ?>index.php"><img src="<?php echo $URLbase ?>i/house.png" width="20" height="20" border="0"/></a></li>
      <li><a href="<?php echo $URLadmin ?>index.php" class="MenuBarItemSubmenu" >Inicio</a></li>
      <li><a href="<?php echo $URLadmin ?>ListaAlumnos.php">Alumnos</a></li>
      <li><a href="<?php echo $URLbase ?>Docente/index.php">Docentes</a></li>
      <li><a href="<?php echo $URLadmin ?>Curso/Curso_Mant.php" class="MenuBarItemSubmenu">Cursos</a>
          <ul>
            <li><a href="<?php echo $URLadmin ?>Curso/Boleta_Estructura.php">Boletas</a>
              <ul>
                <li><a href="<?php echo $URLadmin ?>Curso/Boleta_Estructura.php">Indicadores</a></li>
              </ul>
            </li>
            <li><a href="<?php echo $URLadmin ?>PDF/Estadistica_Curso.php" target="_blank">Estad. Alumnos</a>
              <ul>
                <li><a href="<?php echo $URLadmin ?>PDF/Estadistica_Curso.php?AnoEscolar=<?php echo $AnoEscolarAnte ?>" target="_blank"><?php echo $AnoEscolarAnte ?></a></li>
              </ul>
            </li>
            
            <li><a href="Mant_Aulas.php">Aulas</a></li>
            <li><a href="<?php echo $URLadmin ?>Academico/Cursos_Mantenimiento.php">Docente Gu&iacute;a</a></li>
            <li><a href="<?php echo $URLadmin ?>Academico/Cursos_Mant_Prof.php">Prof Bach</a></li>
            <li><a href="Lista/Menu_Cursos_Excel.php">Lista Excel</a></li>
          </ul>
    </li>
    <li></li>
      <li><a href="<?php echo $URLadmin ?>Usuarios.php">Usuarios</a></li>
      <li>
          <ul>
              <li></li>
   </ul>
      </li>
  <ul>
  </ul>
  </ul>
<script type="text/javascript">
<!--
var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgDown:"http://www.colegiosanfrancisco.com/SpryAssets/SpryMenuBarDownHover.gif", imgRight:"http://www.colegiosanfrancisco.com/SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
  &nbsp;&nbsp;&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'];
  if(isset($_SERVER['QUERY_STRING'])) echo '?'.$_SERVER['QUERY_STRING']; ?>"><img src="http://www.colegiosanfrancisco.com/img/Reload.png" width="31" height="27" /></a>