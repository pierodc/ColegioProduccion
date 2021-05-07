<?php
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin,AsistDireccion,Contable,ce,provee,secreBach";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
$TituloPagina   = "INTRANET / SFA"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

$_var = new Variable();



// ACTUALIZA CAMBIO BCV
$Variable = new Variable();
$Var_Name = "Cambio_Dolar";
$Var = $Variable->view_row($Var_Name);
if( Dif_Tiempo($Var['Fecha_Modificacion']) > 90 ){
	$cambio_BCV = trim(coma_punto(cambio_BCV()));
	$Variable->edit($Var_Name, $cambio_BCV,"auto intran");
	$Var_Value = $cambio_BCV;
}
// FIN ACTUALIZA CAMBIO BCV

/*
$Variable->Nombre = "Cambio_Dolar";
$xxx = object_to_array($Variable);
var_dump($xxx);
*/

$query_RS_Asignacion = "SELECT * FROM Asignacion 
						WHERE (Periodo = 'M' or Periodo = 'X' or Periodo = 'E')
						AND Descripcion <> 'Actividades Extracurriculares' 
						AND Descripcion <> 'Escolaridad' 
						AND Descripcion <> 'Fracc Grad.'
						AND SWActiva = '1'
						ORDER BY Periodo DESC, Orden, Descripcion";
//echo $query_RS_Asignacion;					
/*$RS_Asignacion = mysql_query($query_RS_Asignacion, $bd) or die(mysql_error());
$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion);
$totalRows_RS_Asignacion = mysql_num_rows($RS_Asignacion);*/

$RS_Asignacion = $mysqli->query($query_RS_Asignacion);
$row_RS_Asignacion = $RS_Asignacion->fetch_assoc();
$totalRows_RS_Asignacion = $RS_Asignacion->num_rows;


/*

if (isset($_POST["CodigoRecibo"])) {
	$query_ = "SELECT * FROM Recibo, Alumno 
				WHERE Recibo.CodigoPropietario = Alumno.CodigoAlumno 
				AND CodigoRecibo = ". $_POST["CodigoRecibo"];
	//$RS_ = mysql_query($query_, $bd) or die(mysql_error());
	//$row_ = mysql_fetch_assoc($RS_);
	//$totalRows_ = mysql_num_rows($RS_);
	
	$RS_ = $mysqli->query($query_);
	$row_ = $RS_->fetch_assoc();
	$totalRows_ = $RS_->num_rows;

	
	
	if($totalRows_ > 0) {
		header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".$row_['CodigoClave']);
	}
}
*/

//include_once("/inc/analyticstracking.php") 
?><!doctype html>
<html lang="es">
  <head>
   <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>

<div class="container-fluid">
       <div class="row ">
    	 <div class="col-md-12 subtitle">
            <img src="/i/b.png" width="32" height="32" /> Buscar:
        </div>
       </div>
     <div class="row">
        <div class="col-md-3">
            <img src="/i/user.png" width="32" height="32" alt=""/> Alumno:
        </div>
        <div class="col-md-9">
            <form action="/intranet/a/ListaAlumnos.php" method="post" name="form3" id="form3">
                <input name="Buscar" type="text" id="Buscar" size="20" required />
                <input name="SWinscrito" type="checkbox" id="SWinscrito" value="1" checked="checked" />
                  Ins
                <input type="submit" name="Submit" value="Buscar" class="button" />
            </form>
        </div>
    </div>
    
    
    
    
  
<div class="row">	
	<div class="col-md-3">
		<img src="/i/administrator.png" width="32" height="32" /> Usuario:
	</div>
	<div class="col-md-9" >
		<form action="/intranet/a/Usuarios.php" method="post" name="form2" id="form2">
       		<input name="UsuarioBuscar" type="text" size="20" id="UsuarioBuscar" required />
		  	<input type="submit" name="Submit" value="Buscar" class="button" />
		</form>
	</div>
</div>



<div class="row">	
	<div class="col-md-3">
		<img src="/i/folder_explore.png" width="32" height="32" />Representante:
	</div>
	<div class="col-md-9" >
		<form id="form8" name="form8" method="post" action="/intranet/a/Lista/Representantes.php">
       		<input type="text" name="Buscar" id="Buscar" size="20" required />
			<input type="submit" name="Submit" id="Submit" value="Buscar" class="button" />
    	</form>
	</div>
</div>


    
<div class="row">	
	<div class="col-md-3">
		<img src="/i/folder_explore.png" width="32" height="32" />Empleado:
	</div>
	<div class="col-md-9" >
		<form id="form8" name="form8" method="post" action="/intranet/a/Empleado/Lista.php">
       		<input type="text" name="Buscar" id="Buscar" size="20" required />
			<input type="submit" name="Submit" id="Submit" value="Buscar" class="button" />
    	</form>
	</div>
</div>
        




<?  if($MM_Username == "piero") { ?>
<div class="row ">
    	 <div class="col-md-12 subtitle">
            <img src="/i/b.png" width="32" height="32" /> TEST no usar esta seccion:
        </div>
       </div>
     
       
        
       
       
       <div class="row">
        <div class="col-md-3">
            <img src="/i/user.png" width="32" height="32" alt=""/> test:
        </div>
        <div class="col-md-9">
        
        </div>
    </div>
    
    <form action="/intranet/a/Busca.php" method="post" name="form3" id="form3">
                
          <label>Enter your email</label>
		  
                <input type="text" placeholder=" "/>
				
               <div class="field">
                <input type="text" placeholder=" "/>
				<label>Enter your email</label>
		</div>
                
                <!--input type="submit" name="Submit" value="Buscar" class="button" /-->
            </form>

   <? } ?>     
    
    
    
 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
    
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" /> Reportes
      </div>
  </div>
  
  
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/report_user.png" width="32" height="32" />
		<a href="Lista/Curso_pdf.php">Listas de Cursos</a>
	</div>
</div>
  
  
  
  
  
 
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/printer.png" width="32" height="32" /> Reporte:
	</div>
	<div class="col-md-9" >
		<form id="form6" name="form11" method="post" action="/intranet/a/ir_a.php" target="_blank">
          <select name="Destino" id="select2">
            <option value="0">Selecione...</option>
            <option value="/intranet/a/PDF/Carnet.php">Carnet</option>
            <option value="/intranet/a/Lista/Representantes_Empresa.php">Representantes Empresa</option>
            <option value="/intranet/a/PDF/BoletaPrePrim.php?Nivel=Preescolar">Boleta Preescolar</option>
            <option value="/intranet/a/PDF/BoletaPrePrim.php?Nivel=Primaria">Boleta Primaria</option>
            <option value="/intranet/a/Lista/Asamblea.php?Todo=1">Lista Familias</option>
            <option value="/intranet/a/Lista/Asamblea_x_Curso.php?Conv=1&Asis=1&Apro=0">Asistencia Asamblea x Curso</option>
            <option value="/intranet/a/PDF/Rifa.php">Rifa</option>        
          </select>
      &nbsp; Curso:
      <?php MenuCurso(0,'',$mysqli); ?>
      <input type="submit" name="button4" id="button4" value="-&gt;&gt; Ir..." class="button" />
    </form>
	</div>
</div>
  
<div class="row">	
	<div class="col-md-3">
		<img src="/i/application_view_detail.png" width="32" height="32" />
		<a href="Lista/Asamblea.php">Lista Asistencia Asamblea</a>
	</div>
  </div>
  



 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
  
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" />Contabilidad
      </div>
  </div>
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/book_edit.png" width="32" height="32" />
		<a href="Contabilidad/Diario_de_Caja.php">Diario de Caja</a>
	</div>
  </div>
  
 
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/book_spelling.png" width="32" height="32" />
		<a href="Contabilidad/Libro_Ventas.php">Libro de Ventas</a>
	</div>
  </div>
  
  
  <div class="row">	
	<div class="col-md-2">
		<img src="/i/to_do_list_cheked_1.png" width="32" height="32" />
		Pagos x Asignaci&oacute;n:
	</div>
  	<div class="col-md-2">
		<img src="/i/b.png" alt="" width="64" height="32" />
        Pantalla-&gt;
	</div>
	<div class="col-md-6" >
		<form id="form4" name="form4" method="post" action="">
      <select name="menu2" onchange="MM_jumpMenu('parent',this,0)">
        <option value="">Seleccione...</option>
        <?php
do {  
?>
        <option value="Contabilidad/Asignacion_Casillas.php?CodigoAsignacion=<?php echo $row_RS_Asignacion['Codigo'] ?>&Pagos=1"><?php echo $row_RS_Asignacion['Descripcion']?></option>
        <?php
} while ($row_RS_Asignacion = $RS_Asignacion->fetch_assoc()); //$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion));
$rows = $RS_Asignacion->num_rows;
  if($rows > 0) {
	  $RS_Asignacion = $mysqli->query($query_RS_Asignacion);
	  $row_RS_Asignacion = $RS_Asignacion->fetch_assoc();
  }

?>
        </select>
    </form>
   </div>
  </div>
  
   
  
  
   <div class="row">	
	<div class="col-md-2">
		<img src="/i/b.png" alt="" width="64" height="32" />
        
	</div>
	<div class="col-md-2">
		<img src="/i/b.png" alt="" width="64" height="32" />
        PDF-&gt;
	</div>
	<div class="col-md-6" >
		<form id="form4b" name="form4b" method="post" action="">
     
      <select name="menu2" onchange="MM_jumpMenu('parent',this,0)">
        <option value="">Seleccione...</option>
        <?php
do {  
?>
        <option value="Contabilidad/Asignacion_pdf.php?CodigoAsignacion=<?php echo $row_RS_Asignacion['Codigo'] ?>&Pagos=1"><?php echo $row_RS_Asignacion['Descripcion']?></option>
        <?php
} while ($row_RS_Asignacion = $RS_Asignacion->fetch_assoc()); //$row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion));
$rows = $RS_Asignacion->num_rows;
  if($rows > 0) {
	  $RS_Asignacion = $mysqli->query($query_RS_Asignacion);
	  $row_RS_Asignacion = $RS_Asignacion->fetch_assoc();
  }

?>
        </select>
    </form>
	</div>
  </div>
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/document_prepare.png" width="32" height="32" />
		<a href="Contabilidad/Banco_Concilia.php">Conciliaci&oacute;n Bancaria</a>
	</div>
  </div>
  
 
  
  

 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
 
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" /> Cobranza
      </div>
  </div>
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/application_view_list.png" width="32" height="32" /> Pagos x Curso
	</div>
	<div class="col-md-9" >
		<? Ir_a_Curso(0,"/intranet/a/Cobranza/ListaCurso_Pagos.php?CodigoCurso="); ?>
	</div>
  </div>
  

 <div class="row">	
	<div class="col-md-3">
		<img src="/i/mail.png" width="32" height="32" />
		 <a href="Cobranza/Aviso_Email.php">Aviso de Cobro </a>
	</div>
  </div>
  


 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
 
 
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" />Acad&eacute;mico
      </div>
  </div>
  
  <div class="row">	
	<div class="col-md-3">
		<img src="/i/report_user.png" alt="" width="32" height="32" /> Reporte
	</div>
    <div class="col-md-9">
		<form id="form7" name="form11" method="post" action="ir_a.php" target="_blank">
         
          <select name="Destino" id="Destino">
            <option value="0">Selecione...</option>
            <option value="Academico/Lista_Notas.php">Notas x Curso</option>
            <option value="Academico/ListaCurso_Datos_Ministerio.php">Datos Al Ministerio</option>
            <option value="Academico/ListaCurso_Grados.php">Datos Al Ministerio</option>
            <option value="Academico/PDF/Certificado_Primaria.php">Cert Primaria</option>
            <option value="Lista/Curso_Telefonos.php">Curso Telefonos</option>
          </select>
		  <?php MenuCurso(15,'',$mysqli); ?>
          <select name="AnoEscolar" id="AnoEscolar">
            <option value="" >A&ntilde;o Escolar</option>
            <option value="<?php echo $AnoEscolarAnte ?>"><?php echo $AnoEscolarAnte ?></option>
            <option value="<?php echo $AnoEscolar ?>" selected="selected"><?php echo $AnoEscolar ?></option>
          </select>
          <input type="submit" name="button5" id="button5" value="Ir..." class="button" />
        </form>
	</div>
  </div>
  
 

  <div class="row">	
	<div class="col-md-3">
		<img src="/i/vcard_add.png" alt="" width="32" height="32" />
        <a href="Lista/Control_Ingresos.php?CodigoCurso=15">Proceso Nuevos Ingresos</a>
	</div>
  </div>
 
 <div class="row">	
	<div class="col-md-3">
	<img src="/i/newspaper_add.png" width="32" height="32" />
    <a href="Exalumno.php">Ingreso de Exalumno</a>    
	</div>
  </div>
  
<div class="row">	
	<div class="col-md-3">
		<img src="/i/align_left.png" width="32" height="32" />
        <a href="Academico/PlanilllasMinisterio.php">Resumen Final</a>
   </div>
  </div>
  






 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
 
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" /> RRHH
      </div>
  </div>
  
  <div class="row">	
	<div class="col-md-12">
		<img src="/i/clock_history_frame.png" alt="" width="32" height="32" />
        <a href="Empleado/Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank">Asistencia Mes</a>
		<img src="/i/b.png" width="32" height="32" alt=""/>
        <a href="Empleado/PDF/Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank">PDF</a> 
        <img src="/i/b.png" alt="" width="32" height="32" />
        <a href="http://www.colegiosanfrancisco.com/Asistencia.php">Hoy</a>
	</div>
  </div>








 <div class="row">
      <div class="col-md-12 ">
      		<img src="/i/b.png" alt="" width="32" height="32" />
      </div>
  </div>
 
 
 <?  if($MM_Username == "piero") { ?> 
  <div class="row">
      <div class="col-md-12 subtitle">
      		<img src="/i/b.png" alt="" width="32" height="32" />Ajustes
      </div>
  </div>
  
  <? if($MM_UserGroup == '91' or $MM_UserGroup == '95' ) { ?>
  <div class="row">	
	<div class="col-md-3">
    	<img src="/i/b.png" alt="" width="32" height="32" />
        Cambio BCV: &nbsp;<? $_var->form_edit("Cambio_Dolar"); ?>
	</div>
  </div>
  
   <form id="form9" name="form9" method="post" action="Actualiza_Creador.php">
   <div class="row">	
	<div class="col-md-3">
   		<img src="/i/b.png" alt="" width="32" height="32" />
        Cambio de Usuario
        
       </div>
  </div>
  <div class="row">	
	<div class="col-md-3">
    	 <img src="/i/b.png" alt="" width="63" height="32" />
         Anterior
     </div>   
     <div class="col-md-9"> 
        <input name="Anterior" type="text" id="Anterior" size="40" />
     </div>
   </div>  
  <div class="row">	
	<div class="col-md-3">
    	 <img src="/i/b.png" alt="" width="64" height="32" />
         Cambiar por
     </div>   
     <div class="col-md-9"> 
        <input name="Nuevo" type="text" id="Nuevo" size="40" />
        <input type="submit" name="button2" id="button2" value="Submit" class="button" />
     </div>
   </div>  
</form>
   
   
  <div class="row"> 
   <div class="col-md-3">
    	<img src="/i/b.png" alt="" width="32" height="32" />
        <a href="Grupo_Acceso.php">Grupo Acceso</a>
    </div>
  </div>
  <div class="row">	
	<div class="col-md-3">
    	<img src="/i/b.png" alt="" width="32" height="32" />
        <a href="Variables_Sistema.php">Variables</a>
	</div>
  </div>
  <div class="row">	
	<div class="col-md-3">
    	<img src="/i/b.png" alt="" width="32" height="32" />
        <a href="Agrega_Factura_x_Curso.php">Agrega Fact Curso</a>
	</div>
  </div>
  <div class="row">	
	<div class="col-md-3">
    	<img src="/i/b.png" alt="" width="32" height="32" />
        <a href="Lista/Email_Excel.php?AnoEscolar=<?= $AnoEscolar ?>">Email Repres <? $AnoEscolar ?> </a> | <a href="Lista/Email_Excel.php?AnoEscolar=<?= $AnoEscolarProx ?>"><?= $AnoEscolarProx ?> </a> 
	</div>
  </div>
  
  <div class="row">	
	<div class="col-md-3">
    	 <img src="/i/calendar_edit.png" width="32" height="32" />
        <a href="Academico/Horario.php">Horarios</a>
	</div>
  </div>
  <div class="row">	
	<div class="col-md-3">
    	 <img src="/i/b.png" width="32" height="32" />
      	 <a href="Lista/Datos_Seguro_xls.php">Lista Seguro</a>
	</div>
  </div>
  
  
  
   <? } ?>
  <div class="row">	
	<div class="col-md-3">
   		<img src="/i/b.png" alt="" width="32" height="32" />
        <a href="Fotos.php">Albumes</a>
	</div>
  </div>
  
 
<? } ?>



  
  </div>
  
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>