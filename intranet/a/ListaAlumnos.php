<?php
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable,secreBach";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$ContableMov = new ContableMov($CodigoAlumno=0);
$Consulta = new Consulta();



// Cambia Inscripcion_Condicional 
if (isset($_GET['Inscripcion_Condicional'])) {
	$query = "UPDATE Alumno SET 
				SWInsCondicional = '".$_GET['Inscripcion_Condicional']."' 
				WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'";
	$mysqli->query($query); }
// fin Cambia Inscripcion_Condicional


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if (isset($_POST['Buscar']) or isset($_GET['CodigoBuscar'])) {
	
	if(isset($_POST['Buscar']))
		$aux = explode(" ",strtolower ($_POST['Buscar']));
	else
		$aux = explode(" ",strtolower ($_GET['CodigoBuscar']));
			
	$query_RS_Alumnos  = "SELECT * FROM Alumno WHERE "; 
	
	
	if($aux[0]>0 and $aux[0]<99999){
		$query_RS_Alumnos .= " CodigoAlumno = '$aux[0]' ";
	}else{
		$query_RS_Alumnos .= " LOWER(CONCAT_WS('  ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[0]%'";
		
		
		
		if ($aux[1] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[1]%'";}
		
		if ($aux[2] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[2]%'";}
		
		if ($aux[3] != ""){
			$query_RS_Alumnos .= " AND LOWER(CONCAT_WS(' ',CodigoAlumno,Nombres,Nombres2,Apellidos,Apellidos2,SMS_Caja)) LIKE '%$aux[3]%'";}
		
		$query_RS_Alumnos .= "   ORDER BY Creador, Apellidos, Apellidos2, Nombres, Nombres2";
	}
	
	//echo "<br><br><br><br><br>".$query_RS_Alumnos;
	
	$RS_Alumnos = $mysqli->query($query_RS_Alumnos);
	$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();
	$totalRows_RS_Alumnos = $RS_Alumnos->num_rows;

	
	/*
	$RS_Alumnos = mysql_query($query_RS_Alumnos, $bd) or die(mysql_error());
	$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);
	$totalRows_RS_Alumnos = mysql_num_rows($RS_Alumnos);*/
} 



$colname_RS_Alumno = "-1";
if (isset($_GET['CodigoClave'])) {
  $colname_RS_Alumno = $_GET['CodigoClave'];
}
$query_RS_Alumno = sprintf("SELECT * FROM Alumno WHERE CodigoAlumno = %s", GetSQLValueString($colname_RS_Alumno, "text"));
$RS_Alumnos = $mysqli->query($query_RS_Alumnos);
$row_RS_Alumnos = $RS_Alumnos->fetch_assoc();
$totalRows_RS_Alumnos = $RS_Alumnos->num_rows;
/*
$RS_Alumno = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumno = mysql_fetch_assoc($RS_Alumno);
$totalRows_RS_Alumno = mysql_num_rows($RS_Alumno);*/


$query_RS_Cursos = "SELECT * FROM Curso ORDER BY Curso.NivelMencion, Curso.Curso, Curso.Seccion";
$RS_Cursos = $mysqli->query($query_RS_Alumnos);
$row_RS_Cursos = $RS_Cursos->fetch_assoc();
$totalRows_RS_Cursos = $RS_Cursos->num_rows;
/*
$RS_Cursos = mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = mysql_fetch_assoc($RS_Cursos);
$totalRows_RS_Cursos = mysql_num_rows($RS_Cursos);*/



require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
    
    <script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

    
  <meta charset="ISO-8859-1">
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>

<div class="container-fluid">
  <div class="row">
    <?php //require_once($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/TitAdmin.php'); ?>
  </div>

  <div class="row">
    <form action="<?= php_self(); ?>" method="post" name="form3" id="form3">
        <input name="SWinscrito" type="checkbox" id="SWinscrito" value="1" <?php if($_POST['SWinscrito'] == 1 or !isset($_POST['Buscar'])  ) echo 'checked="checked"'; ?> />Inscrito 
        <input name="Buscar" type="text" id="Buscar" value="<?php echo $_POST['Buscar']; ?>" />
        <input type="submit" name="Submit" value="Buscar" />
    </form>
	
  </div>

<div class="row subtitle">
	Listado de Alumnos
</div>

<?php 
if($MM_Username = "piero" and false){
$sql = $query_RS_Alumnos;
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
  $Alumno = new Alumno($row['CodigoAlumno'], $AnoEscolar);
    if ($Alumno->Inscrito() or !isset($_POST['SWinscrito']) or  isset($_GET['Buscar'])){
	 ?>
     <div class="row">
        <div class="col-lg-4 NombreCampoBIG"> 
          <?= "(" . $Alumno->Codigo() . ") "; ?>
		  <?= $Alumno->NombresApellidos(); ?>
        </div>
        <div class="col-lg-8 NombreCampoBIG">
        CAJA - Estado de Cuenta - Planilla de Inscripción
        </div>
     </div>
     <div class="row">
        <div class="col-lg-4">  
          <? foreach($Alumno->HistStatus() as $Status){
			   echo $Status['Ano']." ".$Status['Status']."<br>"; 
		  } ?>
        </div>
        <div class="col-lg-4">  
          Funciones
        </div>
        <div class="col-lg-4">  
          Fotos
        </div>
     </div>
<? }}} ?>

  <div class="row">
    <div class="col-lg-12">

			
			<?php if ($totalRows_RS_Alumnos > 0) { // Show if recordset not empty ?>

<table width="" border="0" cellpadding="3" cellspacing="0">
<?php 
$SWinscrito = $_POST['SWinscrito'] . $_GET['SWinscrito'];

do { 

$Alumno = new Alumno($row_RS_Alumnos['CodigoAlumno'], $AnoEscolar);

$ContableMov->id = $row_RS_Alumnos['CodigoAlumno'];
	
$sqlStatus = "SELECT * FROM AlumnoXCurso
				WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
				AND Ano = '$AnoEscolar'
				AND Status = 'Inscrito'";
$RS_Status = $mysqli->query($sqlStatus);
//$row = $RS_Status->fetch_assoc();

if ($SWinscrito == 1 and $row = $RS_Status->fetch_assoc() 
		or ($aux[0] > 0 and $aux[0] < 9999)
		or $SWinscrito == "") {

if($CodigoAlumnoAnterior != $row_RS_Alumnos['CodigoAlumno']){

	

	
	
	
		$sql = "SELECT * FROM AlumnoXCurso 
				WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
				AND Ano='".$AnoEscolarProx."' ";
		$RS_sql = $mysqli->query($sql);
		//$row_RS_Alumnos = $RS_sql->fetch_assoc();
		$totalRows_RS = $RS_sql->num_rows;

	
	
	/*
		$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
		$totalRows_RS = mysql_num_rows($RS_sql);*/
		//echo $sql.'<br>';	
		
		if($totalRows_RS == 0){
			$sql = "SELECT * FROM AlumnoXCurso 
					WHERE CodigoAlumno='".$row_RS_Alumnos['CodigoAlumno']."' 
					AND Ano='".$AnoEscolar."' 
					AND Status = 'Inscrito'";
			
			$RS_sql = $mysqli->query($sql);
			$row_ = $RS_sql->fetch_assoc();
			$totalRows_RS = $RS_sql->num_rows;
			/*
			$RS_sql = 	mysql_query($sql, $bd) or die(mysql_error());
			$row_ = mysql_fetch_assoc($RS_sql);
			$totalRows_RS = mysql_num_rows($RS_sql);*/
		//echo $sql.'<br>';	
			
			
			
			
			if($totalRows_RS == 1){
				$aux_Status = "Aceptado";
				$CodigoCurso = CodigoCursoProx($row_['CodigoCurso']);
			}else{
				$aux_Status = "Solicitando";
				$CodigoCurso = 44;
				}
						
			
				$sql = sprintf("INSERT INTO AlumnoXCurso (CodigoAlumno, Ano, CodigoCurso, Status, Status_por ) 
								VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString($row_RS_Alumnos['CodigoAlumno'], "text"),
							   GetSQLValueString($AnoEscolarProx, "text"),
							   GetSQLValueString($CodigoCurso, "text"),
							   GetSQLValueString($aux_Status, "text"),
							   GetSQLValueString($MM_Username, "text"));
				$mysqli->query($sql);
				//$Result1 = mysql_query($sql, $bd) or die(mysql_error());
		//echo $sql.'<br>';	
				  
			}	
	
	
	
	
	
	
	
	
	
	
	
	$CodigoCurso = $row['CodigoCurso'];
?>

<tr>
<td align="left" valign="top" nowrap="nowrap" class="NombreCampoBIG"><?php echo ++$K ?>&nbsp;</td>
<td colspan="2" align="left" valign="top" nowrap="nowrap" class="NombreCampoBIG"><a href="PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">(<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>) <strong> <?php echo $row_RS_Alumnos['Apellidos'].' '. $row_RS_Alumnos['Apellidos2'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $row_RS_Alumnos['Nombres'].' '. $row_RS_Alumnos['Nombres2']; ?></strong></a>
</td>
<td colspan="7" align="right" valign="top" nowrap="nowrap" width="80%" <?php if($Creador_AlumnoAnterior != $row_RS_Alumnos['Creador']) echo ' class="NombreCampoBIG"'; ?>>&nbsp;<?php echo $row_RS_Alumnos['Creador'] ; ?></td>
</tr>



                  
<tr>
    <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
    <td align="left" valign="top" nowrap="nowrap">
      <a href="PlanillaAlumno.php?CodigoAlumno=<?= $row_RS_Alumnos['CodigoAlumno']?>">Planilla</a><br />
      <?php 
    if ($MM_Username=="piero"){ echo ".";?>
      <a href="Procesa.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>&EliminaAlumno=1" target="_blank">Eliminar</a>
<?php echo ".";} ?>
<?php if (($MM_UserGroup=='99' or $MM_UserGroup=='91' or $MM_UserGroup=='95' or $MM_UserGroup=='secre') and $row_RS_Alumnos['Status'] == 'Solicitando'){ ?>
      <a href="ListaAlumnos.php?Aceptar=1&amp;CodigoClave=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>"><?php echo $row_RS_Alumnos['Status'] ?> ACEPTAR</a>
      <?php } ?>
      
      <? /* ?>
      <br />
      <a href="ListaAlumnos.php?Inscripcion_Condicional=<?php if($row_RS_Alumnos['SWInsCondicional']==1) echo '2'; else echo '1';  ?>&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>">Ins Cond. = <?php echo $row_RS_Alumnos['SWInsCondicional']; ?></a>
      <? */ ?>
      <br />
      <a href="PDF/Carnet.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank"> Carnet</a> | <a href="../PDF/Carnet.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank">Carnet Repre</a>| <a href="Academico/Nota_Certificada.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">Nota Certif.</a>|<br>
      
      
<a href="/intranet/PDF/Boleta.php?CodigoPropietario=<?= $row_RS_Alumnos['CodigoClave']; ?>" target="_blank">Boleta Bach</a>|
       
       
 <a href="/intranet/PDF/Boleta_Pr.php?CodigoCurso=<?= $CodigoCurso-2 ?>&idAlumno=<?= $row_RS_Alumnos['CodigoClave']; ?>&AnoEscolar=<?= $AnoEscolarAnte ?>" target="_blank">Boleta PriPre</a>
        
        
        </td>
    <td align="left" valign="top"><p>Constancia de:
      <?php 
		
$Pendiente = $ContableMov->Pendiente();
		
		
if($Pendiente['resumen']['MontoDebe_Dolares'] > 20){	  
	
	  echo "<br><p title=\"";
	  foreach( $Pendiente['resumen']['MesAno'] as $MesAno ){
	  		echo " > " . $MesAno ;
	  }
	  echo "\">Pedir solvencia $".$Pendiente['resumen']['MontoDebe_Dolares']."</p>";
	
	}else{ 
		
	$sql = "SELECT * FROM AlumnoXCurso 
			WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."' 
			AND Ano = '$AnoEscolarProx'
			AND (Status = 'Inscrito' OR Status = 'Aceptado')";
	//echo $sql;
	
	
	$RS_ = $mysqli->query($query_RS_Alumnos);
	$row_Prox = $RS_->fetch_assoc();
	
	
	/*
	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_Prox = mysql_fetch_assoc($RS_);
	*/
	
		?>
      <form name="form" id="form">
        <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('window.open()',this,0)">
          
          <option value="">Seleccione...</option>
          <?php if($row_Prox['Codigo'] > 0){ ?>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Inscrito">Inscrito Prox</option>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=PreInscrito">PRE-Insc</option>
          <?php } ?>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=InscritoActual">Inscrito Actual</option>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Estudio">Estudio</option>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=BuenaConducta">BuenaConducta</option>
          <option value="../Constancia.php?CodigoClave=<?php echo $row_RS_Alumnos['CodigoClave']; ?>&ConstanciaDe=Retiro">Retiro</option>
          </select>
        </form>      
      <p>
          <?php 
	}
	?>
          <br />
          <a href="../PlanillaInscripcion_pdf.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_blank"> Planilla Inscr</a></p>
      </td>
    <td align="center" nowrap="nowrap">
  <a href="Cobranza/Estado_de_Cuenta_Alumno.php?CodigoPropietario=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" target="_self"><img src="../../i/cash_register.png" width="32" height="32" alt=""/>
   
    <img src="<?php echo $Alumno->Foto("","h") ?>" width="100" height="100"  border="0" /> </a>
     <p>Consulta: <? echo $Consulta->Respuesta($row_RS_Alumnos['CodigoAlumno'] , 1) ?>
      </p>
      <!--a href="Sube_Foto.php?Tipo=Alumno&Codigo=<?php //echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank"><br />
      Subir Foto</a--></td><?php
	 
	$Familia = array('p','m','a1','a2','a3');
    
    foreach($Familia as $id){

		?>  
		<td align="center"><?php 
		
		$Ruta = Foto($row_RS_Alumnos['CodigoAlumno'], $id , 300 , "H");
		//if(file_exists($Ruta)){           
			//$Ruta = RutaFotoURL($row_RS_Alumnos['CodigoAlumno'].$id , 300);
		?><img src="<?php echo $Alumno->Foto($id,"h") ?>" alt="" height="100" border="0" /><?php //}
		
		
		//echo $Ruta.'<br>';
		
		
		$Ruta = '../Foto_Repre/'. $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg';
		if (file_exists($Ruta)) { 
			$Actualizar = 'Escanear';
		?><img src="<?php echo $Ruta ?>" alt="" height="100" border="0" /><?php 
		}
	
		//echo $Ruta.'<br>';
		
		
		$Ruta = '../Foto_Repre/x_'. $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg';
		if (file_exists($Ruta)) { 
			$Actualizar = 'Escanear';
			?><img src="<?php echo $Ruta ?>" alt="" height="100" border="0" /><?php 
		}
		
		//}
		
		//echo $Ruta.'<br>';
		
		
	  //echo $Ruta.'---<br>';
		
		
		
		//$Ruta = '../Foto_Repre/'. $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg';
		$Actualizar = 'Cambiar';
		
		
		if(file_exists($Ruta)){
			?>
            <a href="Procesa.php?ActualizaFoto=1&Foto=<?php echo $row_RS_Alumnos['CodigoAlumno'].$id.'.jpg' ?>" target="_blank"><?php echo $Actualizar ?></a>
			<?php } ?>
           <br>
           <?
		
		
		if($id == "p")
			$nexo = "Padre";
		elseif($id == "m")
			$nexo = "Madre";
		else
			$nexo = "";
		$query_RS_Repre = "SELECT * FROM RepresentanteXAlumno , Representante 
									WHERE RepresentanteXAlumno.CodigoRepresentante = Representante.CodigoRepresentante
									AND RepresentanteXAlumno.Nexo = '$nexo'
									AND RepresentanteXAlumno.CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'";
		//echo '<br>'.$query_RS_Repre.'<br>';
		$RS_Repre = $mysqli->query($query_RS_Repre); //
		$row_RS_Repre = $RS_Repre->fetch_assoc();

		$Cel = "58" . substr(TelLimpia($row_RS_Repre['TelCel']) , 1 , 10);
		echo ' '.substr($value,0,1);
		echo "<a href='https://api.whatsapp.com/send/?phone=$Cel&text=Estimado+Sr.+Representante+Le+contacto+de+la+direccin+para+enviarle+el +link+de+la+circular+que+no+le+llego+por+el+email+" . $row_RS_Repre['Email1'].
			"+puede+ingresar+por+el+siguiente+enlace".
			"+https://colegiosanfrancisco.com/intranet/Consulta/Consulta.php?CodigoAlumno=".$Alumno->CodigoClave()."' target='_blank'>";
		echo TelLimpia($row_RS_Repre['TelCel']);
		echo '</a>';
		echo "<br>" . $row_RS_Repre['Email1'];

			
			
			?>
            </td><?php 
		
    
    } ?>
    
    
    
    
    
    
    <td rowspan="2" align="center"><?php 
    $sql = "SELECT * FROM  Alumno, AlumnoXCurso 
			WHERE Alumno.CodigoAlumno = AlumnoXCurso.CodigoAlumno 
			AND Alumno.Creador = '".$row_RS_Alumnos['Creador']."' 
			AND Alumno.CodigoAlumno <> '".$row_RS_Alumnos['CodigoAlumno']."' 
			AND (Alumno.Nombres <> '".$row_RS_Alumnos['Nombres']."' AND Alumno.Nombres2 <> '".$row_RS_Alumnos['Nombres2']."')
			AND (AlumnoXCurso.Ano = '$AnoEscolar' OR AlumnoXCurso.Ano = '$AnoEscolarProx') 
			GROUP BY AlumnoXCurso.CodigoAlumno";

	
	$RS_ = $mysqli->query($sql);
	$row_ = $RS_->fetch_assoc();
	$totalRows_RS_ = $RS_->num_rows;

	/*
    $RS_ = mysql_query($sql, $bd) or die(mysql_error());
    $row_ = mysql_fetch_assoc($RS_);
    $totalRows_RS_ = mysql_num_rows($RS_);
	*/
	
    if ($totalRows_RS_>0){
		do {
			$nombreFoto = '../../'. $AnoEscolar.'/'.$row_['CodigoAlumno'].'.jpg';
			if (!file_exists($nombreFoto)) { 
				$nombreFoto = '../../'. $AnoEscolarAnte.'/150/'.$row_['CodigoAlumno'].'.jpg';}
			?><img src="<?php echo $nombreFoto ?>" alt="" width="30" height="30" border="0" /><br><?php echo $row_['CodigoAlumno']; ?><br><?php
		} while ($row_ = $RS_->fetch_assoc()); 	
    }
    ?></td>
</tr>



<tr>
  <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
  <td colspan="2" align="left" valign="top" nowrap="nowrap"><iframe width="300" height="60" src="http://www.colegiosanfrancisco.com/intranet/a/Academico/iFr/Status.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" frameborder="1" id="SWframe"></iframe></td>
  <td colspan="6" align="center" valign="top" nowrap="nowrap"><iframe width="500" height="60" src="http://www.colegiosanfrancisco.com/intranet/a/Observacion.php?Area=Lista&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoClave']; ?>" frameborder="1" id="SWframe2"></iframe></td>
  </tr>
                  
                  <?php 
				  
				  }
				  $CodigoAlumnoAnterior = $row_RS_Alumnos['CodigoAlumno'];
				  $Creador_AlumnoAnterior = $row_RS_Alumnos['Creador'];
				  
}  


				  } while ($row_RS_Alumnos = $RS_Alumnos->fetch_assoc()); ?>
                </table>
                
                 
                
        <?php } ?>
    </div></td>
  </tr>
</table>

    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12"><?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>
</div>
  </div>
</div>

</body>

</html>