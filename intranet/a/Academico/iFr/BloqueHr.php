<?php 
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin";
require_once('../../../../inc_login_ck.php'); 

require_once('../../../../Connections/bd.php'); 
require_once('../../archivo/Variables.php');
require_once('../../../../inc/rutinas.php'); 

$TituloPantalla = "TituloPantalla";

/*
// Conectar
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

// Ejecuta $sql
$RS = $mysqli->query($query_RS_Alumno);

$RS = $mysqli->query($sql);
$row = $RS->fetch_assoc();


// Ejecuta $sql y While
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

echo $sw=ListaFondo($sw,$Verde); 

header("Location: ".$php_self."?CodigoPropietario=".$_GET['CodigoPropietario']);

if(Acceso($Acceso_US,$Reuqerido_Pag)){
	echo "$Acceso_US permitido en Reuqerido_Pag"; }


*/


extract($_GET);

if($delete == '1'){
	$sql = "DELETE FROM Horario WHERE Codigo_Bloque = '$Codigo_Bloque'";
	$mysqli->query($sql);
	$Variables = "CodigoCurso=$CodigoCurso&Dia=$Dia&Bloque=$Bloque&Cedula=$Cedula&CodigoMaterias=$CodigoMaterias";
	header("Location: ".$php_self."?".$Variables);
}
if($Agregar == '1'){
	
	$sql = "SELECT * FROM DocenteXCurso WHERE
			CodigoCurso = '$CodigoCurso' AND
			Codigo_Materia = '$Codigo_Materia'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	$Cedula_Prof = $row['CedulaProf'];
		
	$sql = "INSERT INTO Horario 
			(CodigoCurso, Dia_Semana, No_Bloque, Descripcion, Cedula_Prof) VALUES
			('$CodigoCurso', '$Dia', '$Bloque', '$Codigo_Materia', '$Cedula_Prof')";
	$mysqli->query($sql);
	
	$Variables = "CodigoCurso=$CodigoCurso&Dia=$Dia&Bloque=$Bloque&Cedula=$Cedula&CodigoMaterias=$CodigoMaterias";
	header("Location: ".$php_self."?".$Variables);
}
 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title><?php echo $TituloPantalla; ?></title>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php 

	$sql = "SELECT * FROM Horario, Materias 
			WHERE Horario.Descripcion=Materias.Codigo_Materia  
			AND Horario.CodigoCurso = '$CodigoCurso' 
			AND Horario.Dia_Semana = '$Dia' 
			AND Horario.No_Bloque = '$Bloque'
			ORDER BY Materias.Materia";
	$RS = $mysqli->query($sql);
	$num_rows = $RS->num_rows;
	if ($RS) 
		while ($row = $RS->fetch_assoc()) {
?>
  <tr>
    <td width="130" valign="top" <?php 
	
	$sqlMateria = "SELECT *  FROM DocenteXCurso 
					WHERE Codigo_Materia = '".$row['Codigo_Materia']."'
					AND CodigoCurso = '$CodigoCurso'";
	//echo $sqlMateria;
	$RS_Materia = $mysqli->query($sqlMateria);
	$row_Materia = $RS_Materia->fetch_assoc();
	
	$sqlProf = "SELECT * FROM Horario 
				WHERE Dia_Semana = '$Dia' 
				AND No_Bloque = '$Bloque'
				AND Cedula_Prof = '".$row_Materia['CedulaProf']."'
				AND Cedula_Prof > '0'
				AND CodigoCurso <> '$CodigoCurso'";
				
	$RSProf = $mysqli->query($sqlProf);
	$num_rows = $RSProf->num_rows;
	if($num_rows > 0){
		$row_Prof = $RSProf->fetch_assoc();
		if($row_Prof)
			$Conflicto = ' '.CursoSeccion($row_Prof['CodigoCurso']);
		}
		else 	
			$Conflicto = ' ';
		//echo 'class="ConflictoHorario"';
		 ?>><?php //echo $sqlMateria.' '.$sqlProf;?><?php echo $row['Materia']; ?></td>
    <td width="30" align="right" valign="top" nowrap="nowrap" <?php 
	
	$sqlMateria = "SELECT *  FROM DocenteXCurso 
					WHERE Codigo_Materia = '".$row['Codigo_Materia']."'
					AND CodigoCurso = '$CodigoCurso'";
	//echo $sqlMateria;
	$RS_Materia = $mysqli->query($sqlMateria);
	$row_Materia = $RS_Materia->fetch_assoc();
	
	$sqlProf = "SELECT * FROM Horario 
				WHERE Dia_Semana = '$Dia' 
				AND No_Bloque = '$Bloque'
				AND Cedula_Prof = '".$row_Materia['CedulaProf']."'
				AND Cedula_Prof > '0'
				AND CodigoCurso <> '$CodigoCurso'";
				
	$RSProf = $mysqli->query($sqlProf);
	$num_rows = $RSProf->num_rows;
	if($num_rows > 0){
		$row_Prof = $RSProf->fetch_assoc();
		if($row_Prof)
			$Conflicto = ''.CurSec($row_Prof['CodigoCurso']);
		}
		else 	
			$Conflicto = '';
		//echo 'class="ConflictoHorario"';
		 ?>><?php if ($Conflicto > '') { ?><span class="ConflictoHorario"><a href="../Horario.php?CodigoCurso=<?php echo $row_Prof['CodigoCurso'] ?>" target="_top" ><?php echo $Conflicto; ?></a></span><?php } ?></td>
    <td width="10" align="right" valign="top" nowrap="nowrap"><?php 
	
$Variables = "Codigo_Bloque=".$row['Codigo_Bloque']."&CodigoCurso=$CodigoCurso&Dia=$Dia&Bloque=$Bloque&Cedula=$Cedula&CodigoMaterias=$CodigoMaterias";
	
	echo '<a href="BloqueHr.php?delete=1&'.$Variables.'">x</a>'; ?>&nbsp;</td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="3" valign="top">
    <form name="form" id="form">
        <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('self',this,0)">
          <option value="">+</option>
		  <option value=""></option>
          <option value="" class="BoletaNota" >-- Por Asignar --</option>
<?php 
$Variables = "&Agregar=1&CodigoCurso=$CodigoCurso&Dia=$Dia&Bloque=$Bloque&Cedula=$Cedula&CodigoMaterias=$CodigoMaterias";

$sql = "SELECT * FROM Materias 
		WHERE CodigoMaterias = '$CodigoMaterias' 
		ORDER BY Materia ASC";	
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) { 
$sqlCONTAR = "SELECT * FROM Horario 
				WHERE CodigoCurso = '$CodigoCurso'
				AND Descripcion = '".$row['Codigo_Materia']."'";
$CantAsignada = $mysqli->query($sqlCONTAR);
$CantAsignada = $CantAsignada->num_rows;	
if($CantAsignada < $row['Hr_Semanales']){
	$Faltante = $row['Hr_Semanales'] - $CantAsignada ;
	if($Faltante > 0)
		$Faltante = " ( ".$Faltante." ) ";
	else
		$Faltante = '';	

?>         
	<option value="<?php echo $php_self ."?Codigo_Materia=".$row['Codigo_Materia'].$Variables; ?>"><?php echo $Faltante.$row['Materia'] ?></option><?php }
} 


?>         

<option value=""></option>
<option value="">-- Listo --</option><?php

$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) { 
$sqlCONTAR = "SELECT * FROM Horario 
				WHERE CodigoCurso = '$CodigoCurso'
				AND Descripcion = '".$row['Codigo_Materia']."'";
$CantAsignada = $mysqli->query($sqlCONTAR);
$CantAsignada = $CantAsignada->num_rows;	
if($CantAsignada >= $row['Hr_Semanales']){
	$Sobrante = $CantAsignada - $row['Hr_Semanales'];
	if($Sobrante > 0)
		$Sobrante = " ( +".$Sobrante." )";
	else
		$Sobrante = '';	
?>         
	<option value="<?php echo $php_self ."?Codigo_Materia=".$row['Codigo_Materia'].$Variables; ?>"><?php echo $row['Materia'].$Sobrante ?></option><?php }
} 



?>         
        </select>
        <?php 
		
if($_GET['Cedula'] > ""){
	$Cedula = $_GET['Cedula'];
	$Dia = $_GET['Dia'];
	$Bloque = $_GET['Bloque'];
	
	$sql = "SELECT * FROM Horario 
			WHERE Cedula_Prof = '$Cedula'
			AND Dia_Semana = '$Dia'
			AND No_Bloque = '$Bloque'";
	//echo $sql;
	$RS = $mysqli->query($sql);
	echo '<br>';
	while($row = $RS->fetch_assoc()){
		echo '<b><a href="../Horario.php?CodigoCurso='.$row['CodigoCurso'].'&Cedula='.$_GET['Cedula'].'" target="_blank">'.CurSec($row['CodigoCurso'])."</a>&nbsp;&nbsp;&nbsp;</b>";
	}
	}		
		
		?>
    </form></td>
  </tr>
</table>
</body>
</html>