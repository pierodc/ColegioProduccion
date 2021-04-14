<?php 
// area docente
$MM_authorizedUsers = "docente,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 

require_once($_SERVER['DOCUMENT_ROOT'] . '/Connections/bd.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/rutinas.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/archivo/Variables_Privadas.php');

$TituloPantalla = "Formato Boleta";

if(!isset($_GET['CodigoCurso']) and $MM_UserGroup<>'docente'){
	if($_COOKIE['CodigoCurso'] > ''){
		$CodigoCurso = $_COOKIE['CodigoCurso'];
	}else{
		$CodigoCurso = 15;
		}
	header("Location: ".$_SERVER['PHP_SELF']."?CodigoCurso=".$CodigoCurso);
}

$CodigoCurso = $_GET['CodigoCurso'];
$idAlumno = $_GET['idAlumno'];
setcookie("CodigoCurso",$CodigoCurso,time()+99999999);


$Curso = new Curso();
$Curso->id = $_GET['CodigoCurso'];
$Curso->Ano = $AnoEscolar;
$Listado = $Curso->ListaCurso();
$NivelCurso = $Curso->NivelCurso();

$DocenteGuia = $Curso->DocenteGuia();
$DocenteEspecialista= $Curso->DocenteEspecialista();

$Alumno = new Alumno($_GET['idAlumno']);


/*
while($row = mysqli_fetch_assoc($Listado)){
	echo ++$No.' '.$row['Nombres'] . '<br>';
	}
*/

if(isset($_GET['CodigoEdita']) and isset($_POST['submit'])){
	extract($_POST);
	$sql = "UPDATE Boleta_Indicadores SET 
			Dimen_o_Indic = '$Dimen_o_Indic', 
			Orden_Grupo = '$Orden_Grupo', 
			Materia_Grupo = '$Materia_Grupo', 
			Orden = '$Orden', 
			Descripcion = '$Descripcion', 
			EscalaNota = '$EscalaNota', 
			Responsable = '$Responsable'
			WHERE Codigo = '$Codigo'";
	//$mysqli->query($sql);
	//echo $sql;
	header("Location: ".$php_self."?CodigoCurso=".$_GET['CodigoCurso']);
}
else
if(isset($_POST['submit'])){
	extract($_POST);
	$sql = "INSERT INTO Boleta_Indicadores 
	( NivelCurso, Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden, Descripcion, EscalaNota, Responsable) 
	VALUES 
	( '$NivelCurso','$Dimen_o_Indic','$Orden_Grupo','$Materia_Grupo','$Orden','$Descripcion','$EscalaNota','$Responsable') 
	";
	//$mysqli->query($sql);
	echo $sql;
	}
	

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

</head>
<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center"><?php require_once('TituloPag.php'); ?></td>
  </tr>
    <tr>
    <td align="left" valign="top"><?php 
   $actual = $_GET['CodigoCurso'];
   $extraOpcion = $_SERVER['PHP_SELF'] .'?CodigoCurso=';
   Ir_a_Curso($actual,$extraOpcion,$MM_UserGroup,$MM_Username); ?></td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top">
<? if(isset($_GET['CodigoCurso'])){ ?>    
      <table width="150" border="0" cellspacing="1" cellpadding="0">
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
      <td nowrap="nowrap"><a href="<?= $_SERVER['PHP_SELF']."?CodigoCurso=".$_GET['CodigoCurso']."&idAlumno=".$row['CodigoAlumno'] ?>"><? echo $row['Apellidos'].' '.$row['Nombres']; ?></a></td>
    </tr>
<? } ?>    
  </tbody>
</table>
<? }else{ echo "<h3>Seleccione el curso</h3>";} ?>
      </td>
    <td align="center" valign="top">
    <? if(isset($_GET['idAlumno'])){ ?>
    <table width="90%%" border="0" cellspacing="0" cellpadding="10">
     
<tr>
	<td colspan="4" class="RTitulo">Alumno: <?= $Alumno->NombreApellido(); ?></td>
</tr> 
      
<?php 

if(isset($_GET['idAlumno'])){
	
	if($Curso->NivelCurso() >= "21"){
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE NivelCurso = '".$Curso->NivelCurso()."'
				OR Dimen_o_Indic = 'D'
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";}
	else{
		$sql = "SELECT * FROM Boleta_Indicadores
				WHERE NivelCurso = '".$Curso->NivelCurso()."'
				
				ORDER BY Dimen_o_Indic, Orden_Grupo, Materia_Grupo, Orden";} //AND Dimen_o_Indic = 'I'
	
		
		
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	extract($row);


if($Dimen_o_Indic_Ante != $Dimen_o_Indic){	
?>
        <tr>
           <td colspan="4">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="4" class="NombreCampoTITULO"><? echo $Dimen_o_Indic=="I"?"Indicador":"Dimensión"; ?></td>
        </tr>
<?php } 

if(true or $MM_Username == $DocenteGuia  or $MM_UserGroup == "docente"){ 
	/*
	//or in_array($MM_Username,$DocenteEspecialista)
	echo "<tr><td><pre><br>";
	echo "<b>$DocenteEspecialista[Musica]</b><br><br>";
	//var_dump($DocenteEspecialista);
	if(in_array($MM_Username,$DocenteEspecialista)) {
		echo "<br>" . $MM_Username ." in array " ;}
	echo "</td></tr>";
	*/
if($Materia_Grupo_Ante != $Materia_Grupo){ 
?>         
         <tr>
           <td colspan="4">&nbsp;</td>
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
           <? if($EscalaNota > "") {?><iframe src="iFr/Boleta_nota_pri_pre.php?<? 
		   echo "CodigoAlumno=".$idAlumno;
		   echo "&Codigo_Indicador=".$Codigo;
		   echo "&EscalaNota=$EscalaNota" ;
		    //echo "&No=" . ++$EscalaNota ;
		   
		   ?>" scrolling="no" frameborder="0" height="25" width="250"></iframe><? } ?></td>
          </tr>
<?php 
} //if($MM_Username == $DocenteGuia )


$Materia_Grupo_Ante = $Materia_Grupo;
$Dimen_o_Indic_Ante = $Dimen_o_Indic;
} 

} ?>
         
        <td colspan="4"><iframe src="Observacion.php?idAlumno=<?php echo $_GET['idAlumno']; ?>" width="100%" height="300"></iframe></td> 
     </table>
     <? } ?>
     </td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="top">&nbsp;</td>
  </tr>
</table>

<?php //include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>