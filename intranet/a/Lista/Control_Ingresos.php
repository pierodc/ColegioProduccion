<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$TituloPagina   = "Control Ingresos"; // <title>
$TituloPantalla = "Control Ingresos"; // Titulo contenido

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");


// Conectar
//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
if(isset($_GET['CodigoCurso']) and $_GET['CodigoCurso'] > '')
	$Curso = " AND AlumnoXCurso.CodigoCurso = '".$_GET['CodigoCurso']."' ";
	
$sql_Aceptados = "SELECT * FROM Alumno, AlumnoXCurso
				  WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno
				  $Curso
				  AND (AlumnoXCurso.Ano = '$AnoEscolarProx' OR AlumnoXCurso.Ano = '$AnoEscolar')
				   
				  AND (AlumnoXCurso.Status = 'Solicitando' OR AlumnoXCurso.Status = 'Aceptado')
				  ORDER BY AlumnoXCurso.Ano DESC,
				  		   Fecha_Registro DESC, 
						   Apellidos, Apellidos2, Nombres, Nombres2 ";  //Status_Proceso_Ins, 

//echo $sql_Aceptados;					  

$RS = $mysqli->query($sql_Aceptados);

 
require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>


    <table width="80%" border="0" cellpadding="5">
      <tr>
        <td colspan="6"><?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion); ?></td>
        <td colspan="6" align="right"><a href="Ingreso_Fechas_Citas.php">Fechas</a> | <a href="../PDF/Control_Ingreso.php" target="_blank">Listado</a></td>
      </tr>
      <tr>
        <td width="3" class="NombreCampo">No</td>
        <td width="4" class="NombreCampo">Cod</td>
        <td width="9" class="NombreCampo">Alumno</td>
        <td width="98" colspan="2" class="NombreCampo">&nbsp;</td>
        <td width="100" class="NombreCampo">Hno</td>
        <td class="NombreCampo">Ex Alu</td>
        <!--td class="NombreCampo">&nbsp;</td-->
        <td align="center" class="NombreCampo">Fecha</td>
        <td align="center" class="NombreCampo">&nbsp;</td>
        <td align="center" class="NombreCampo">&nbsp;</td>
        <td align="center" class="NombreCampo">&nbsp;</td>
      </tr>
<?php 
while ($row_RS_Alumnos = $RS->fetch_assoc()) {
	//extract($row_RS_Alumnos);

$Alumno = new Alumno($row_RS_Alumnos['CodigoAlumno']);

if ($Alumno->Status($AnoEscolarAnte) != "Inscrito"){

	if($CodigoNivelCurso != $row_RS_Alumnos['NivelCurso']){
?>
      <tr >
        <td colspan="2" nowrap="nowrap" class="NombreCampoBIG"><?php echo $row_RS_Alumnos['SW_CupoDisp']; ?></td>
        <td colspan="10" nowrap="nowrap" class="NombreCampoBIG"><?php echo Curso($row_RS_Alumnos['CodigoCurso']); ?></td>
        </tr>
 <?php 
 $No_Curso = 0;
 }
 $CodigoNivelCurso = $row_RS_Alumnos['NivelCurso']; 
 
 
$sql_EnCursoActual = "SELECT * FROM AlumnoXCurso
					  WHERE Ano = '$AnoEscolar'
					  AND CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
					  AND Status = 'Inscrito'";
					  
$RS_EnCursoActual = $mysqli->query($sql_EnCursoActual);
$totalRow_EnCurso = $RS_EnCursoActual->num_rows;
 //echo $sql_EnCursoActual.' '.$totalRow_EnCurso.' <br>';

if(substr($row_RS_Alumnos['Creador'],0,2) != "x_" and $totalRow_EnCurso == 0 ){ //



/*
?>       
	 <tr><td colspan="11"  class="subtitle"><?php echo date("W" , strtotime($row_RS_Alumnos['Fecha_Registro'])); ?></td></tr>
	<?php 
*/


if ($Ano_Ante <> $row_RS_Alumnos['Ano']) {
	 ?>       
	 <tr><td colspan="12" class="<?php if ( $row_RS_Alumnos['Ano'] == $AnoEscolarProx ) echo "SW_Verde"; else echo "SW_Amarillo"; ?>" >A�o <?php echo $row_RS_Alumnos['Ano']; ?></td></tr>
	<?php 
}
$Ano_Ante = $row_RS_Alumnos['Ano'];


if($Fecha_Registro_Ante <> date("W" , strtotime($row_RS_Alumnos['Fecha_Registro']))){
	 ?>       
	 <tr><td colspan="12">Semana <?php echo date("W" , strtotime($row_RS_Alumnos['Fecha_Registro'])); ?></td></tr>
	<?php 
}
$Fecha_Registro_Ante = date("W" , strtotime($row_RS_Alumnos['Fecha_Registro']));
?>


     <tr <?php $sw = ListaFondo($sw,$Verde); ?>>
        <td nowrap="nowrap">&nbsp;<?php echo ++$No; ?></td>
        <!--td nowrap="nowrap">&nbsp;<?php echo ++$No_Curso; ?></td-->
        <td nowrap="nowrap">
          <?php echo $row_RS_Alumnos['CodigoAlumno']; ?>
        </td>
        <td nowrap="nowrap"><a href="../PlanillaImprimirADM.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank">
        <span class="ListadoNotas"><b>
          <?php echo $Alumno->Apellidos(); ?>
          ,</b> <em>
          <?php echo $Alumno->Nombres(); ?>
          </em></span></a></td>
        <td nowrap="nowrap"> 
		  <img src="<?php echo $Alumno->Foto("","h") ?>"   height="40" />
          <img src="<?php echo $Alumno->Foto("p","h") ?>" alt="" height="40" border="0" />
          <img src="<?php echo $Alumno->Foto("m","h") ?>" alt="" height="40" border="0" />
          
          </td>
        <td align="center" nowrap="nowrap"><a href="../Procesa.php?EliminaAlumno=1&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" target="_blank"><img src="../../../img/b_drop.png" width="16" height="16" /></a></td>
        <td align="center" nowrap="nowrap"><?php if($row_RS_Alumnos['HermanoCursando'] == "Si"){
			echo '<span class="SW_Verde">';}
			echo $row_RS_Alumnos['HermanoCursando'].'</span>';
			 ?></td>
        <td align="center" nowrap="nowrap"><?php if($row_RS_Alumnos['HijoDeExalumno'] == "Si"){
			echo '<span class="SW_Verde">';}
			echo $row_RS_Alumnos['HijoDeExalumno'].'</span>';
			 ?></td>
        <!-- td align="left" nowrap="nowrap"><?php 
		
$sql_Reinscrito = "SELECT * FROM AlumnoXCurso
					  WHERE CodigoAlumno = '".$row_RS_Alumnos['CodigoAlumno']."'
					  AND Ano = '$AnoEscolarProx' 
					  AND Status = 'Solicitando'";
$RS_Reinscrito = $mysqli->query($sql_Reinscrito);
if($row_RS = $RS_Reinscrito->fetch_assoc()){
	echo "";}
	
echo $totalRow_EnCurso;

		
 ?></td-->
        <td align="left" nowrap="nowrap"><?php echo DDMMAAAA($row_RS_Alumnos['Fecha_Registro']) ?></td>
        <td align="left" nowrap="nowrap"><iframe src="Status_iFr.php?CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno']; ?>" width="600" height="40" frameborder="0" scrolling="auto"></iframe></td>
        <td align="right" nowrap="nowrap"><?php 

$CodigoAlumno = $row_RS_Alumnos['CodigoAlumno'];		
$query_Observaciones = "SELECT * FROM Observaciones 
						WHERE CodigoAlumno = $CodigoAlumno 
						AND Area = 'SolCupo'
						ORDER BY Fecha DESC, Hora DESC";
$Observaciones = $mysqli->query($query_Observaciones);
$row_Observaciones = $Observaciones->fetch_assoc();

		?><a href="../Observacion.php?Area=SolCupo&CodigoAlumno=<?php echo $row_RS_Alumnos['CodigoAlumno'] ?>" target="_blank" title="<?php echo substr($row_Observaciones['Observacion'],0,50); ?>">Obser</a> <?php 

$totalRows_Observaciones = $Observaciones->num_rows;
if($totalRows_Observaciones > 0)
	echo " ($totalRows_Observaciones)";		
		?></td>
      </tr>
<?php }}} ?>
    </table>    
    
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>