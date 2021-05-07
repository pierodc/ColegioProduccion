<?
$URLadmin = 'http://www.colegiosanfrancisco.com/intranet/a/';

$AlumnoMenu = new Alumno($CodigoAlumno);

$MM_Username  = $_COOKIE['MM_Username'];
$MM_UserGroup  = $_COOKIE['MM_UserGroup'];



?>
<nav class="navbar navbar-default navbar-fixed-top NavegacionTop" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
             <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button><a class="navbar-brand" href="http://<? echo $_SERVER['HTTP_HOST']."/intranet/a"; ?>">INTRANET</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class=" nav navbar-nav ">
           
           <? if($AlumnoMenu->Codigo() > 0){ ?>
           <li class="dropdown"><a href="#" class="dropdown-toggle " data-toggle="dropdown"><div class="NavegacionTop"><?php echo $AlumnoMenu->id."-".$AlumnoMenu->NombreApellido(); ?><strong class="caret"></strong></div></a>
				<ul class="dropdown-menu">
					   <li class="dropdown-submenu"><a href="<?php echo $URLadmin ?>Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $AlumnoMenu->CodigoClave(); ?>">Edo De Cuenta</a></li>
					   <li class="divider"></li>
				</ul>
            </li>
            <? } ?>
            
           <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">RRHH<strong class="caret"></strong></a>
               <ul class="dropdown-menu">
                   <li class="dropdown-submenu"><a href="<?php echo $URLadmin ?>Empleado/Lista.php?Limit=0&CantEmpPantalla=5&TipoEmpleado=">Empleados</a></li>
                   <li class="divider"></li>
                   
                   
                   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Nomina" >Nomina de Pago</a></li>
                       
				   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Pago_extra">Archivo TXT Pago_extra</a></li>
				   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Pago_extra2">Archivo TXT Pago_extra 2</a></li>
				   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=Pago_extra_dolares">Pago Dolares</a></li>
                       
                   
                     <li class="divider"></li>
                   <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_BonoAlim.php?Ano=<?php echo date('Y'); ?>&Mes=<?php echo date('m'); ?>">Bono Alimentaci&oacute;n</a></li>
                   
                   <li class="divider"></li>
                   
                   <li><a href="<?php echo $URLadmin ?>Empleado/PDF/Nomina_Fideicomiso.php">Fideicomiso</a></li>
                       <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncrementoFide">Archivo Incremento TXT</a></li>
					   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncrementoFideAnual">Archivo Incremento Anual TXT</a></li>
					   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=AdelantoFide">Archivo Adelanto TXT</a></li>
					   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IncorporaFide">Archivo Incorpora TXT</a></li>
                        
                    
                    <li class="divider"></li>
                    
                    
                   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=LPH">Ley P. Hab. </a></li>
                       
                           <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=LPH">Archivo TXT</a>
                        
                    </li>
                    
                    <li class="divider"></li>
                    
                   <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IVSS1312">I.V. S.S.</a> </li>
                       
                           <li><a href="<?php echo $URLadmin ?>Empleado/Archivos_txt.php?ArchivoDe=IVSS1312">Archivo 13-12</a></li>
                       
                  
                    
                    <li class="divider"></li>
                    
                   <li><a href="<?php echo $URLadmin ?>Empleado/Feriados.php">Feriados</a></li>
                   <li><a href="<?php echo $URLadmin ?>Empleado/Lista_Excel.php">Lista Excel</a></li>
                   <li><a href="<?php echo $URLadmin ?>Empleado/excel/Lista_Email.php">Lista Email</a></li>
                   
                    <li class="divider"></li>
            
                      
					  <li><a href="<?php echo $URLadmin ?>Empleado/Asistencia_General.php">Asistencia</a> </li>
                            <li><a href="<?php echo $URLadmin ?>Empleado/Asistencia_Ausencias.php">Ausencias</a></li>
                        
                   
                                 
                </ul>
           </li>
            
            
            
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Caja<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo $URLadmin ?>Cobranza/Pagos_Conciliar.php">Concilia Pagos</a>
                  </li>
                <li><a href="<?php echo $URLadmin ?>Contabilidad/Sube_Arch_Banco.php">Carga Banco</a></li>
                <li class="divider"></li>
                <li>
                  <a href="<?php echo $URLadmin ?>Contabilidad/Asignaciones.php">Asignaciones</a></li>
                <li><a href="<?php echo $URLadmin ?>Variables_Sistema.php">Variables</a></li>
                <li><a href="<?php echo $URLadmin ?>Contabilidad/Sube_Arch_Banco.php"> Carga Banco</a></li>
				  <li ><a href="<?php echo $URLadmin ?>Egreso_de_Caja.php">Egresos</a></li>
				  <li ><a href="<?php echo $URLadmin ?>Contabilidad/Gastos.php">Gastos</a></li>
				  <li><a href="<?php echo $URLadmin ?>Contabilidad/Banco_Busca.php">Buscar Banco</a> </li>
				  <li><a href="<?php echo $URLadmin ?>Pagos_Conciliar.php">Verificar Pagos</a></li>
				  <li><a href="<?php echo $URLadmin ?>Contabilidad/Asignaciones.php">Asignaciones</a></li>
				  <li><a href="<?php echo $URLadmin ?>Cobranza/Lista_Solicitudes.php">Solicitudes</a></li>
          
                </ul>
            </li>
            
            
            
            
            
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Cursos<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo $URLadmin ?>Curso/index.php">Lista Curso</a>
                </li>
                <li>
                  <a href="<?php echo $URLadmin ?>Academico/Curso_Materias.php">Curso_Materias</a>
                </li>
               
               
               <li><a href="<?php echo $URLadmin ?>Curso/Boleta_Estructura.php">Boletas</a> </li>
              
                <li><a href="<?php echo $URLadmin ?>Curso/Boleta_Estructura.php">Indicadores</a></li>
             
           
            <li><a href="<?php echo $URLadmin ?>PDF/Estadistica_Curso.php" target="_blank">Estad. Alumnos</a> </li>
              
                <li><a href="<?php echo $URLadmin ?>PDF/Estadistica_Curso.php?AnoEscolar=<?php echo $AnoEscolarProx ?>" target="_blank">Estad. Alumnos<?php echo $AnoEscolarProx ?></a></li>
              
           
            
            <li><a href="Mant_Aulas.php">Aulas</a></li>
            <li><a href="<?php echo $URLadmin ?>Academico/Cursos_Mantenimiento.php">Docente Gu&iacute;a</a></li>
            <li><a href="<?php echo $URLadmin ?>Academico/Cursos_Mant_Prof.php">Prof Bach</a></li>
            <li><a href="Lista/Menu_Cursos_Excel.php">Lista Excel</a></li>
            </ul>
            </li>
            
            
            
           <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo $URLadmin ?>Usuarios.php">Buscar</a>
                </li>
			   </ul>
			</li>
           
           
           
            
           <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Proveduria<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo $URLadmin ?>Proveduria/Inventario.php">Inventario</a>
                </li>
                <li>
                  <a href="<?php echo $URLadmin ?>Proveduria/Ordenes.php">Ordenes</a>
                </li>
                <li><a href="/intranet/Proveeduria/">Vista Padre</a></li>
			   </ul>
			</li>
           
           
            
           <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Docente<strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="/Docente/index.php">Docente</a>
                </li>
			   </ul>
			</li>
           
           
           
           
           
           
           
           
           
           
        </ul>
        <form class="navbar-form navbar-right" role="search" method="post" action="http://<? echo $_SERVER['HTTP_HOST'] . "/intranet/a/ListaAlumnos.php"; ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="Buscar">
                <input name="SWinscrito" type="hidden" id="SWinscrito" value="1"  />
            </div> 
            <button type="submit" class="btn btn-default">
                Buscar
            </button>
        </form>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'] ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
            </li><li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= substr($MM_Username,0,3); ?>  <strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/index.php?LogOut=1">Salir <? echo session_id(); ?></a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

 
<div class="row">
    <div class="col-md-12">
       &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
       &nbsp;
    </div>
</div><div class="row">
    <div class="col-md-12">
       &nbsp;
    </div>
</div>


