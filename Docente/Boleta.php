<?php 
// area docente
$MM_authorizedUsers = "Coordinador,docente,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "Formato Boleta";

$CodigoCurso = $_GET['CodigoCurso'];
$Lapso = $_GET['Lapso'];

if ( $CodigoCurso == "" or $Lapso == "" ){  //and $MM_UserGroup <> 'docente'
	
	if($CodigoCurso == ''){
		$CodigoCurso = 15;
		}
		
	if($Lapso == ''){
		$Lapso = $Lapso_Actual;	}
	
	//setcookie("CodigoCurso",$CodigoCurso,time()+99999999);
	//setcookie("Lapso",$Lapso,time()+99999999);

	header("Location: ".$_SERVER['PHP_SELF']."?CodigoCurso=".$CodigoCurso."&Lapso=".$Lapso);
}


$idAlumno = $_GET['idAlumno'];


$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];
$Curso->Ano = $AnoEscolar;
$Listado = $Curso->ListaCurso();
$NivelCurso = $Curso->NivelCurso();

$DocenteGuia = $Curso->DocenteGuia();
$DocenteEspecialista= $Curso->DocenteEspecialista();



//echo "DocenteGuia " . $DocenteGuia . " usuario  $MM_Username <br>";

if($DocenteGuia == $MM_Username){
	//echo "DOC GUIA";
	$SW_DocenteGuia = true;
	}
	else {
	//echo "no GUIA";
	//$SW_DocenteGuia = true;
	}
//echo "DocenteEspecialista " . var_dump($DocenteEspecialista) . "<br>";

$Alumno = new Alumno($_GET['idAlumno']);


/*
while($row = mysqli_fetch_assoc($Listado)){
	echo ++$No.' '.$row['Nombres'] . '<br>';
	}
*/


	

/*
if(!TieneAcceso($Acceso_US,"")){
	header("Location: ".$_SERVER['HTTP_REFERER']);
	}
*/
/*
 onclick="this.disabled=true;this.form.submit();"
 
 <a href="delete.php?id=$res[id]"  onClick="return confirm('Esta seguro que desea eliminar?')">eliminar</a>
 
 
// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();
$Conteo = $RS->num_rows;

// Ejecuta $sql y While
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);
    echo "<br>";
}

$RS->data_seek(0);

if(isset($_POST['button'])){
	$sql = "INSERT INTO Table (Codigo) VALUES
			('".$_POST['Codigo']."')";
	$mysqli->query($sql);
}

$sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }

<input type="submit" name="Boton" id="Boton" value="Valor" onclick="this.disabled=true;this.form.submit();" />
*/
 if(isset($_GET['CodigoEdita'])){
	$sql = "SELECT * FROM Boleta_Indicadores
			WHERE Codigo = '".$_GET['CodigoEdita']."'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	}

 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="/estilos.css" rel="stylesheet" type="text/css" />
<link href="/estilos2.css" rel="stylesheet" type="text/css" />
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
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" align="center"><?php require_once('TituloPag.php'); ?></td>
  </tr>
    <tr>
    <td colspan="2" align="left" valign="top" width="150"><?php 
   $actual = $_GET['CodigoCurso'];
   $Lapso = $_GET['Lapso'];
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
		}else {$Verde = false;}
	$sw=ListaFondo($sw,$Verde); ?>>
      <td><? echo ++$No; ?></td>
      <td nowrap="nowrap"><a href="<?= $_SERVER['PHP_SELF']."?Lapso=".$_GET['Lapso']."&CodigoCurso=".$_GET['CodigoCurso']."&idAlumno=".$row['CodigoAlumno'] ?>"><? echo $row['Apellidos'].' '.$row['Nombres']; ?></a></td>
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
	  <table width="100%">
	    
	      <tr>
	        <td scope="col" class="RTitulo">&nbsp;<?= $Alumno->NombresApellidos(); ?> </td>
	        <td scope="col" align="right">&nbsp;<a href="PDF/Boleta.php?Lapso=<?= $_GET['Lapso'] ?>&CodigoCurso=<?= $_GET['CodigoCurso'] ?>&idAlumno=<?= $_GET['idAlumno']; ?>">Boleta</a></td>
	        </tr>
	    </table>
	</td>
</tr> 
      
<?php 

if(isset($_GET['idAlumno'])){
	
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
	$MM_UserGroup == "91" or $MM_UserGroup == "Coordinador"){ 
	
	
	
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
		   
		   ?>" scrolling="no" frameborder="0" height="25" width="250" seamless="seamless"></iframe><? 
		   
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
         <? if($SW_DocenteGuia or $MM_UserGroup == 91 or $MM_UserGroup == "Coordinador"){ ?>
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

<?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>