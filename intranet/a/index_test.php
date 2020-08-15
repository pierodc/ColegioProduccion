<?php
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,admin,AsistDireccion,Contable,ce";
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');


$TituloPantalla ="INTRANET";
//mysql_select_db($database_bd, $bd);
$query_RS_Cursos = "SELECT * FROM Curso 
					WHERE SW_activo=1 
					ORDER BY NivelMencion ASC, Curso.Curso, Curso.Seccion";
//$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
//$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
//$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);

$RS_Cursos = $mysqli->query($query_RS_Cursos);
$row_RS_Cursos = $RS_Cursos->fetch_assoc();
$totalRows_RS_Cursos = $RS_Cursos->num_rows;


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




if (isset($_POST["CodigoRecibo"])) {
	$query_ = "SELECT * FROM Recibo, Alumno 
				WHERE Recibo.CodigoPropietario = Alumno.CodigoAlumno 
				AND CodigoRecibo = ". $_POST["CodigoRecibo"];
	/*$RS_ = mysql_query($query_, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS_);
	$totalRows_ = mysql_num_rows($RS_);*/
	
	$RS_ = $mysqli->query($query_);
	$row_ = $RS_->fetch_assoc();
	$totalRows_ = $RS_->num_rows;

	
	
	if($totalRows_ > 0) {
		header("Location: Estado_de_Cuenta_Alumno.php?CodigoPropietario=".$row_['CodigoClave']);
	}
}
//include_once("/inc/analyticstracking.php") 
?><!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="Cobranza/common.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.2.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
 
<title>Administraci&oacute;n SFDA</title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<?php $ToRoot = "../../../../";?>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<script src="/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />

<script src="/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="/SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<script src="/SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="/SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />


<link href="/SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<div class="container-fluid">
  <div class="row">
    <?php require_once($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/TitAdmin.php'); ?>
  </div>

  <div class="row">
    <div class="col-lg-6">
    <table width="100%" class="table">
  <tr>
    <td colspan="3" class="subtitle"><img src="/i/google_custom_search.png" width="32" height="32" /> Buscar</td>
    </tr>
  <tr>
    <td width="36"><img src="/i/estudiantes.jpeg" width="35" height="36" /></td>
    <td width="150" nowrap="nowrap">Alumno:</td>
   <td valign="middle"><form action="/intranet/a/ListaAlumnos.php" method="post" name="form3" id="form3">
       
      <input name="Buscar" type="text" id="Buscar" size="20" />
      <input name="SWinscrito" type="checkbox" id="SWinscrito" value="1" checked="checked" />
      Ins
  <input type="submit" name="Submit" value="Buscar" />
    </form></td>
  </tr>
  <tr>
    <td width="36"><img src="/i/administrator.png" width="32" height="32" /></td>
    <td width="150" nowrap="nowrap">Usuario:</td>
    <td valign="middle"><form action="/intranet/a/Usuarios.php" method="post" name="form2" id="form2">
       
      <input name="UsuarioBuscar" type="text" size="20" id="UsuarioBuscar" />
      <input type="submit" name="Submit" value="Buscar" />
    </form></td>
  </tr>
  <tr>
    <td width="36"><img src="/i/folder_explore.png" width="32" height="32" /></td>
    <td width="150" nowrap="nowrap">Represen:</td>
    <td valign="middle"><form id="form8" name="form8" method="post" action="/intranet/a/Lista/Representantes.php">
       
        <input type="text" name="Buscar" id="Buscar" size="20" />
     
      
        <input type="submit" name="Submit" id="Submit" value="Buscar" />
    
    </form></td>
  </tr>
</table>
    </div>
    <div class="col-lg-6">
 <table width="100%"   class="table">
  <tr>
    <td colspan="2" class="subtitle"><img src="/i/printer.png" alt="" width="32" height="32" /> Reportes</td>
    </tr>
  <tr>
    <td width="32"><img src="/i/report_user.png" width="32" height="32" /></td>
    <td nowrap="nowrap"><a href="Lista/Curso_pdf.php">Listas de Cursos</a></td>
    </tr>
  <tr>
    <td width="32"><img src="/i/printer.png" width="32" height="32" /></td>
    <td nowrap="nowrap"><form id="form6" name="form11" method="post" action="/intranet/a/ir_a.php" target="_blank">
      <select name="Destino" id="select2">
        <option value="0">Selecione...</option>
        <option value="/intranet/a/PDF/Carnet.php">Carnet</option>
        <option value="/intranet/a/Lista/Representantes_Empresa.php">Representantes Empresa</option>
        <option value="/intranet/a/PDF/BoletaPrePrim.php?Nivel=Preescolar">Boleta Preescolar</option>
        <option value="/intranet/a/PDF/BoletaPrePrim.php?Nivel=Primaria">Boleta Primaria</option>
        <option value="/intranet/a/Lista/Asamblea.php?Todo=1">Lista Familias</option>
        <option value="/intranet/a/Lista/Asamblea_x_Curso.php?Conv=1&Asis=1&Apro=0">Asistencia Asamblea x Curso</option>
        <option value="/intranet/a/PDF/Rifa.php">Rifa</option>        </select>
      &nbsp; Curso:
      <?php MenuCurso(0,'',$mysqli); ?>
      <input type="submit" name="button4" id="button4" value="-&gt;&gt; Ir..." />
    </form></td>
    </tr>
  <tr>
    <td width="32">&nbsp;</td>
    <td nowrap="nowrap">&nbsp;</td>
    </tr>
</table>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
    <table width="100%" class="table">
  <tr>
    <td colspan="2" class="subtitle"><img src="/i/cash_register.png" width="32" height="32" /> Administraci&oacute;n Caja</td>
    </tr>
  <tr>
    <td width="32"><img src="/i/application_view_list.png" width="32" height="32" /></td>
    <td><form name="form1" id="form5">
      Pagos x Curso
      :
      <select name="menu3" onchange="MM_jumpMenu('parent',this,0)">
        <option value="">Seleccione...</option>
        <?php
do {  
?>
        <option value="/intranet/a/Cobranza/ListaCurso_Pagos.php?CodigoCurso=<?php echo $row_RS_Cursos['CodigoCurso']?>"><?php echo $row_RS_Cursos['NombreCompleto']?></option>
        <?php
} while ($row_RS_Cursos = $RS_Cursos->fetch_assoc() );//$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos)

//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();
$rows = $RS_Cursos->num_rows;

  //$rows = mysql_num_rows($RS_Cursos);
  if($rows > 0) {
	  $RS_Cursos = $mysqli->query($query_RS_Cursos);
	  $row_RS_Cursos = $RS_Cursos->fetch_assoc();
	  
      //mysql_data_seek($RS_Cursos, 0);
	  //$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
  }
?>
      </select>
    </form></td>
  </tr>
  <tr>
    <td width="32"><img src="/i/mail.png" width="32" height="32" /></td>
    <td><form name="form1" id="form1">
      Email de Cobro
      <select name="menu1" onchange="MM_jumpMenu('parent',this,0)">
        <option value="">Seleccione...</option>
        <?php
do {  
?>
        <option value="/intranet/a/Cobranza/Aviso_de_Cobro_Email.php?CodigoCurso=<?php echo $row_RS_Cursos['CodigoCurso']?>"><?php echo $row_RS_Cursos['NombreCompleto']?></option>
        <?php
} while ($row_RS_Cursos = $RS_Cursos->fetch_assoc() );//$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos)

//$RS = $mysqli->query($sql);
//$row = $RS->fetch_assoc();
$rows = $RS_Cursos->num_rows;
  if($rows > 0) {
	  $RS_Cursos = $mysqli->query($query_RS_Cursos);
	  $row_RS_Cursos = $RS_Cursos->fetch_assoc();
  }
?>
      </select>
    </form></td>
  </tr>
  <tr>
    <td width="32"><img src="/i/book_go.png" width="32" height="32" /></td>
    <td><a href="Contabilidad/Egreso_de_Caja.php">Egresos</a></td>
  </tr>
  <tr>
    <td width="32"><img src="/i/book_edit.png" width="32" height="32" /></td>
    <td><a href="Contabilidad/Diario_de_Caja.php">Diario de Caja</a></td>
  </tr>
</table>
    </div>
    <div class="col-lg-6">
    <table width="100%" class="table">
  <tr>
    <td colspan="2" class="subtitle"><img src="/i/book_edit.png" width="32" height="32" /> Contabilidad</td>
    </tr>
  <tr>
    <td width="32"><img src="/i/document_prepare.png" width="32" height="32" /></td>
    <td><a href="Contabilidad/Banco_Concilia.php">Conciliaci&oacute;n Bancaria</a></td>
  </tr>
  <tr>
    <td width="32"><img src="/i/cheque.png" width="32" height="32" /></td>
    <td><a href="Contabilidad/Banco_Cheques.php">Cheques</a></td>
  </tr>
  <tr>
    <td width="32"><img src="/i/book_spelling.png" width="32" height="32" /></td>
    <td><a href="Contabilidad/Libro_Ventas.php">Libro de Ventas</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="Contabilidad/Retencion_IVA.php">Retenciones</a></td>
  </tr>
  <tr>
    <td><img src="/i/to_do_list_cheked_1.png" width="32" height="32" /></td>
    <td><form id="form4" name="form4" method="post" action="">
      Pagos 
      x Asignaci&oacute;n:
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

/*
  $rows = mysql_num_rows($RS_Asignacion);
  if($rows > 0) {
      mysql_data_seek($RS_Asignacion, 0);
	  $row_RS_Asignacion = mysql_fetch_assoc($RS_Asignacion);
  }*/
?>
        </select>
      </form></td>
  </tr>
    </table>
    </div>
  </div>


  <div class="row">
    <div class="col-lg-6">
    <table width="100%" class="table">
      <tr>
        <td colspan="2" class="subtitle"><img src="/i/user_Abuelo.png" width="32" height="32" /> Academico</td>
        </tr>
      <tr>
        <td width="32"><img src="/i/report_user.png" alt="" width="32" height="32" /></td>
        <td><form id="form7" name="form11" method="post" action="ir_a.php" target="_blank">
          Reporte:
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
  <input type="submit" name="button5" id="button5" value="Ir..." />
        </form></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="/Docente">Planificaci&oacute;n</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="Academico/PlanilllasMinisterio.php">Resumen Final</a></td>
      </tr>
      <tr>
        <td><img src="/i/newspaper_add.png" width="32" height="32" /></td>
        <td><a href="Exalumno.php">Ingreso de Exalumno</a></td>
      </tr>
      <tr>
        <td width="32"><img src="/i/vcard_add.png" alt="" width="32" height="32" /></td>
        <td><a href="Lista/Control_Ingresos.php?CodigoCurso=15">Proceso Nuevos Ingresos</a></td>
      </tr>
    </table>
    </div>
    <div class="col-lg-6">
    <table width="100%" class="table">
      <tr>
        <td colspan="2" class="subtitle"><img src="/i/user_Padre.png" width="32" height="32" /> N&oacute;mina</td>
        </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="Empleado/Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank">Asistencia Emplados</a> - <a href="Empleado/PDF/Asistencia_General.php?Inicio=<?php echo date('Y-m'); ?>" target="_blank">PDF</a> - <a href="http://www.colegiosanfrancisco.com/Asistencia.php">Hoy</a></td>
      </tr>
      <tr>
        <td width="32"><img src="/i/email_to_friend.png" width="32" height="32" /></td>
        <td><a href="http://eepurl.com/ZwalX">Nueva Lista de Correos (en a?o colocar 2015-2016)</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div>
  </div>
  

  <div class="row">
    <div class="col-lg-6">
    <table width="100%" class="table">
      <tr>
        <td colspan="2" class="subtitle">&nbsp;</td>
        </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="Fotos.php">Albumes</a></td>
      </tr>
      <tr>
        <td width="32"><img src="/i/application_view_detail.png" width="32" height="32" /></td>
        <td><a href="Lista/Asamblea.php">Lista Asistencia Asamblea</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><p>
          <?php 
		  if($MM_UserGroup == '91' or $MM_UserGroup == '95' ) { ?>
          <br />
          Piero:</p>
          <p><a href="Lista/Email_Excel.php">Lista Excel Email Repres</a></p>
          <p> <a href="Deposito_Crear.php">Dep&oacute;sito</a> | <a href="PDF/Nota_Certificada.php">NotaCertificada</a> | <a href="Variables_Sistema.php">Variables</a> | <a href="Grupo_Acceso.php">Grupo Acceso</a> | <a href="Configuracion/Contrato.php">Contratos</a> | <a href="Cobranza/Pagos72.php?MontoObj=72000">72000</a> | <a href="Cobranza/Pagos72.php?MontoObj=36000">36000</a> | <a href="Cobranza/Pagos72.php?MontoObj=18000">18000</a></p>
          <form id="form9" name="form9" method="post" action="Actualiza_Creador.php">
            <table border="1" cellpadding="2" cellspacing="2">
              <tbody>
                <tr>
                  <td colspan="2"><label>Cambio de Usuario </label></td>
                  </tr>
                <tr>
                  <td nowrap="nowrap">Anterior</td>
                  <td nowrap="nowrap"><input name="Anterior" type="text" id="Anterior" size="50" /></td>
                  </tr>
                <tr>
                  <td nowrap="nowrap">Cambiar por</td>
                  <td nowrap="nowrap"><input name="Nuevo" type="text" id="Nuevo" size="50" /></td>
                  </tr>
                <tr>
                  <td colspan="2" align="center"><input type="submit" name="button2" id="button2" value="Submit" /></td>
                  </tr>
              </tbody>
          </table>
          </form>
          <p><a href="Agrega_Factura_x_Curso.php">Agrega Fact Curso</a></p>
          
          <p>
            <?php 
		  echo $_SERVER['HTTP_USER_AGENT']; ?>
          </p>
          <?php } ?></td>
      </tr>
    </table>
    </div>
    <div class="col-lg-6">
    <table width="100%" class="table">
      <tr>
        <td colspan="2" class="subtitle">&nbsp;</td>
        </tr>
      <tr>
        <td width="32"><img src="/i/calendar_edit.png" width="32" height="32" /></td>
        <td><a href="Academico/Horario.php">Horarios</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="Lista/Datos_Seguro_xls.php">Lista Seguro</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><a href="/ScriptCam-master/demo1.php">foto</a></td>
      </tr>
      <tr>
        <td width="32">&nbsp;</td>
        <td><? if($MM_UserGroup == '91' ) { ?>
Piero:
  <?php //require_once('/Login_jq.php'); 
?>
  <? } ?></td>
      </tr>
    </table>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">  ...</div>
  </div>
</div>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</body>

</html>