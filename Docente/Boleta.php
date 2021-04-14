<?php 
$MM_authorizedUsers = "Coordinador,docente,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
$TituloPagina   = "INTRANET"; // <title>
$TituloPantalla = "INTRANET"; // Titulo contenido

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Lapso = 1;
$Alumno = new Alumno($_GET["idAlumno"]);
$Curso = new Curso($_GET['CodigoCurso']);

//$SW_DocenteGuia = ;

require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
    
    <link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
<link href="/css/tabla.css" rel="stylesheet" type="text/css" />
	

<script>
$( "#Def_Mat2" ).load( "Boleta_nota_pri_pre.php?Promedio=34443",  function() {  alert( "Load was performed." ) });
</script>

<style>
table.position_fixed{
	position: fixed;
	left: 5px;
	box-shadow:5px 5px 5px grey;
	}
</style>

    
    
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? // require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<?  require_once($_SERVER['DOCUMENT_ROOT'] . "/Docente/Nav.php");  ?>
<? //require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
 
	
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>
    
    
    <td colspan="2" align="left" valign="top" width="150">
    <? //Boton_Cursos( $_GET['CodigoCurso'] ); ?>    
    
    <?php 
   $actual = $_GET['CodigoCurso'];
	if( $_GET['Lapso'] > 0)	{	
	   $Lapso = $_GET['Lapso'];
	}
   $extraOpcion = $_SERVER['PHP_SELF'] ."?Lapso=$Lapso&CodigoCurso=";
   Ir_a_Curso($actual,$extraOpcion,$MM_UserGroup,$MM_Username); ?></td>
   
   
    <td align="right" valign="top"><? if( true or $MM_UserGroup == "91" or $MM_UserGroup == "Coordinador" or $SW_DocenteGuia){ ?><a href="PDF/Boleta.php?CodigoCurso=<?= $actual?>&Lapso=<?= $Lapso ?>" target="_blank">Imprimir Boletas</a> | <a href="PDF/Boleta_Observaciones.php?CodigoCurso=<?= $actual?>" target="_blank">Observaciones</a> | 
      Lapso <? foreach (array(1,2,3) as $Lap) { ?>
      <a class="btn-sm <? 
		if ($Lapso <> $Lap) 
			echo "btn-light"; 
		else 
			echo "btn-primary"; 
			?>" href="<?= $php_self ?>?CodigoCurso=<?= $CodigoCurso ?>&Lapso=<?= $Lap ?>" role="button">
      <?= $Lap ?>
      </a>
      <? } ?><? } ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;&nbsp;</td>
    <td align="left" valign="top">
<? if(isset($_GET['CodigoCurso'])){ ?>    
      <table width="150" border="0" cellspacing="1" cellpadding="0" class="position_fixed">
      <caption class="RTitulo">Alumnos</caption>
  <tbody>
    
    <tr>
      <td class="NombreCampo">No</td>
      <td class="NombreCampo">Alumno</td>
    </tr>
<?


//echo $query_RS_Alumno;
$query_RS_Alumno = "SELECT * FROM AlumnoXCurso, Alumno 
					WHERE AlumnoXCurso.CodigoAlumno = Alumno.CodigoAlumno 
					AND AlumnoXCurso.Ano = '$AnoEscolar' 
					AND AlumnoXCurso.Status = 'Inscrito' 
					AND AlumnoXCurso.CodigoCurso = '".$_GET['CodigoCurso']."' 
					ORDER BY Alumno.Apellidos, Alumno.Apellidos2, Alumno.Nombres, Alumno.Nombres2 ASC";
//echo $query_RS_Alumno;			
$RS = $mysqli->query($query_RS_Alumno);
//$row = $RS->fetch_assoc();
while ($row = $RS->fetch_assoc()) {
	//extract($row);
?>    
    <tr <? 
	if($_GET['idAlumno'] == $row['CodigoAlumno']){
		$Verde = true;
		}
	else {
		$Verde = false;
		  }
	 ?>>
      <td <? ListaFondo($sw,$Verde); ?>><? echo ++$No; ?></td>
      <td nowrap="nowrap" <? $sw = ListaFondo($sw,$Verde); ?>><a href="<?= $_SERVER['PHP_SELF']."?Lapso=".$_GET['Lapso']."&CodigoCurso=".$_GET['CodigoCurso']."&idAlumno=".$row['CodigoAlumno'] ?>"><? echo $row['Apellidos'].' '.$row['Nombres']; ?></a></td>
    </tr>
<? } ?>    
  </tbody>
</table>
<? 
$Verde = false;
}

else{ echo "<h3>Seleccione el curso</h3>";} ?>


      </td>
    <td align="center" valign="top">
    <? if(isset($_GET['idAlumno'])){  ?>
    <table width="90%" border="0" cellspacing="0" cellpadding="10">
     
<tr>
	<td colspan="4">
	  <table width="90%">
	    
	      <tr>
	        <td scope="col" class="RTitulo">&nbsp;<?= $Alumno->NombresApellidos(); ?> </td>
	        <td scope="col" align="right">&nbsp;<a href="PDF/Boleta.php?Lapso=<?= $_GET['Lapso'] ?>&CodigoCurso=<?= $_GET['CodigoCurso'] ?>&idAlumno=<?= $_GET['idAlumno']; ?>" target="_blank">Boleta</a></td>
	        </tr>
	    </table>
	</td>
</tr> 
      
<?php 

if(isset($_GET['idAlumno'])){
	$idAlumno = $_GET['idAlumno'];
	if($Curso->NivelCurso() >= "21"){
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE Ano = '$AnoEscolar'
				AND Lapso = '$Lapso'
				AND (NivelCurso = '".$Curso->NivelCurso()."' OR (NivelCurso = '21' AND Dimen_o_Indic = 'D')) 
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";
	}
	else{
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE Ano = '$AnoEscolar'
				AND Lapso = '$Lapso'
				AND NivelCurso = '".$Curso->NivelCurso()."'  
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";
	} //AND Dimen_o_Indic = 'I'
	
		
//echo $sql;

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
extract($row);
$sw_continua = true;
do { 
	


if($Dimen_o_Indic_Ante != $Dimen_o_Indic){	
?>
        <tr>
           <td colspan="4">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4" class="NombreCampoTITULO"><? echo $Dimen_o_Indic=="I"?"Indicador":"Dimensión"; ?></td>
        </tr>
<?php } 

$Materia_Grupo_array = str_replace(" ","_",NoAcentos($Materia_Grupo));

if($SW_DocenteGuia or 
	$DocenteEspecialista[$Materia_Grupo_array] == $MM_Username or
	$MM_UserGroup == "91" or $MM_UserGroup == "docente" or $MM_UserGroup == "Coordinador"){ 
	
	
	
if($Materia_Grupo_Ante != $Materia_Grupo){ 
$Sumatoria = $cuenta = 0;
?>         
         <tr>
           <td colspan="4">&nbsp;<? //$DocenteEspecialista[$Materia_Grupo] ." ". $MM_Username ?></td>
          </tr>
         <tr>
           <td colspan="4" class="NombreCampo"><?= $Orden_Grupo ?>) <?= $Materia_Grupo ?></td>
         </tr>
<? } ?> 

        
         <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
           <td width="30">&nbsp;<?= $Orden; ?></td>
           <td><?= $Descripcion ?></td>
           <td width="20"></td>
           <td width="100" align="right">
           <? 
		   
		   if($EscalaNota > "") { 
		   
		   ?><iframe src="iFr/Boleta_nota_pri_pre.php?<? 
		   echo "CodigoAlumno=".$idAlumno;
		   echo "&Codigo_Indicador=".$Codigo;
		   echo "&EscalaNota=$EscalaNota" ;
		   echo "&Lapso=".$_GET['Lapso'];
		    //echo "&No=" . ++$EscalaNota ;
		   
		   ?>" scrolling="no" frameborder="0" height="25" width="250" seamless></iframe><? 
		   
			$sql_nota = "SELECT * FROM Boleta_Nota 
						WHERE CodigoAlumno = '".$_GET['idAlumno']."'
						AND Codigo_Indicador = '".$Codigo."'";
			//echo $sql_nota;			
			$RS_nota = $mysqli->query($sql_nota);
			if($row_nota = $RS_nota->fetch_assoc()){
				$Nota = $row_nota['Nota'];
				//echo $Nota;
				if($Nota > "1" and $Nota <= "20"){
					
					$Sumatoria += $Nota;
					$cuenta++;
					}
			}

		   
		   } ?></td>
          </tr>
<?php 
} //if($MM_Username == $DocenteGuia )

$Materia_Grupo_Ante = $Materia_Grupo;
$Dimen_o_Indic_Ante = $Dimen_o_Indic;

if($row = $RS->fetch_assoc()){
	$sw_continua = true;
	extract($row);}
else{
	$sw_continua = false;}


if($Materia_Grupo_Ante != $Materia_Grupo and $cuenta > 0 and $EscalaNota == "A"){ 
?>         
         
         <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
           <td align="right">&nbsp;</td>
           <td align="right">&nbsp;</td>
           <td colspan="2" align="right">
           <h5><div id="Def_Mat<? echo $II++//echo $Materia_Grupo ?>"><?= $Materia_Grupo_Ante ?>: <? 
		   
		   $Promedio_Materia = round($Sumatoria/$cuenta,0);
		   echo $Promedio_Materia; 
		   $Suma_Lapso += $Promedio_Materia;
		   $Cuenta_Lapso++;
		   
		   ?>&nbsp;&nbsp;</div></h5></td>
         </tr>
<? }


} while ($sw_continua);

if($Cuenta_Lapso > 0){ 
?>         
         
         <tr <?php $sw=ListaFondo($sw,$Verde); ?>>
           <td align="right">&nbsp;</td>
           <td align="right">&nbsp;</td>
           <td colspan="2" align="right">
           <h5><div id="Def_Mat<? echo $II++//echo $Materia_Grupo ?>">DEFINITIVA del Lapso: <? 
		   
		   $Promedio_Lapso = round($Suma_Lapso/$Cuenta_Lapso,0);
		   echo $Promedio_Lapso; 
		   
		   ?>&nbsp;&nbsp;</div></h5></td>
         </tr>
<? }




} ?>
         <? if($SW_DocenteGuia or $MM_UserGroup == "91" or $MM_UserGroup == "docente" or $MM_UserGroup == "Coordinador"){ ?>
        <tr><td colspan="4">
        
        <iframe src="Observacion.php?idAlumno=<?php echo $_GET['idAlumno']. "&Lapso=".$_GET['Lapso']. "&Ano=$AnoEscolar"; ?>" width="100%" height="300"></iframe></td></tr><? } ?>
     </table>
     <? } ?>
     </td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="top">&nbsp;</td>
  </tr>
</table>	
	
	
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php //require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>