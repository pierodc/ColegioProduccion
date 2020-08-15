<?php 
$MM_authorizedUsers = "91,95,AsistDireccion,secreAcad";
require_once('../../../inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 

$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);




//mysql_select_db($database_bd, $bd);

if (isset($_POST['CodigoMaterias'])){
	$sql = "UPDATE CursoMaterias SET 
			Profesor01 = '". $_POST['Profesor01']."', 
			Profesor02 = '". $_POST['Profesor02']."', 
			Profesor03 = '". $_POST['Profesor03']."', 
			Profesor04 = '". $_POST['Profesor04']."', 
			Profesor05 = '". $_POST['Profesor05']."', 
			Profesor06 = '". $_POST['Profesor06']."', 
			Profesor07 = '". $_POST['Profesor07']."', 
			Profesor08 = '". $_POST['Profesor08']."', 
			Profesor09 = '". $_POST['Profesor09']."', 
			Profesor10 = '". $_POST['Profesor10']."', 
			Profesor11 = '". $_POST['Profesor11']."', 
			Profesor12 = '". $_POST['Profesor12']."', 
			Profesor13 = '". $_POST['Profesor13']."'  
			WHERE CodigoMaterias = '".$_POST['CodigoMaterias']."'";
	//echo $sql;
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	}



if (isset($_POST['Cedula_Prof_Guia'])){
	//echo "<pre>";
	//var_dump($_POST);
	
	if($_POST['NombresMaterias'] > ""){
		$NombresMaterias = substr($_POST['NombresMaterias'],0,strlen($_POST['NombresMaterias'])-1);
		//echo $NombresMaterias."<br>";
		$Materias = explode(";" , $_POST['NombresMaterias']);
		//var_dump($Materias);	
		foreach($Materias as $Materia){
			if($Materia > ""){
				//echo "$Materia,". $_POST[$Materia].";<br>";
				$add_sql .= "$Materia,". $_POST[$Materia].";";
			}
		}
	$add_sql = ", Cedula_Prof_Esp = '".$add_sql."'";	
	//echo $add_sql."<br>";	
	}
	
	$sql = "UPDATE Curso SET 
			Cedula_Prof_Guia = '". $_POST['Cedula_Prof_Guia']."',
			Cedula_Prof_Aux = '". $_POST['Cedula_Aux1'].",". $_POST['Cedula_Aux2']."'
			$add_sql 
			WHERE CodigoCurso = '".$_POST['CodigoCurso']."'";
	//echo $sql;
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	}


$query_CursoMaterias = "SELECT * FROM CursoMaterias";
$CursoMaterias = mysql_query($query_CursoMaterias, $bd) or die(mysql_error());
$row_CursoMaterias = mysql_fetch_assoc($CursoMaterias);
$totalRows_CursoMaterias = mysql_num_rows($CursoMaterias);

function Profesor_($bd, $nombre_campo ,$actual){ // AND CargoLargo LIKE '%pro%' // SW_activo = 1 AND
	$sql = "SELECT * FROM Empleado 
			WHERE 
			 (TipoDocente LIKE '%pro%' OR CargoLargo LIKE '%pro%') 
			ORDER BY Apellidos, Nombres";  // (SW_activo = 1  or SW_activo = 0) 
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS);
	
	echo '
	<select name="'.$nombre_campo.'" id="select">
	<option value="0">Selecc</option>
	';
	do {
		echo '<option value="'.$row_['CodigoEmpleado'].'"';
		if($actual==$row_['CodigoEmpleado'])  
			echo ' selected="selected" ';
		echo ">$actual ".$row_['Apellidos']." ".$row_['Nombres']."</option>
		";
	} while ($row_ = mysql_fetch_assoc($RS));
	echo '</select>';
}

function Maestra_($bd, $nombre_campo ,$actual){  // 
	
	$sql = "SELECT * FROM Empleado WHERE TipoEmpleado LIKE '%2.%'  ORDER BY Apellidos, Nombres";// WHERE SW_activo = 1
	
	
	//echo $sql.'<br>';
	$RS = mysql_query($sql, $bd) or die(mysql_error());
	$row_ = mysql_fetch_assoc($RS);
	
	echo '<select name="'.$nombre_campo.'" id="select">
	';
	echo '       <option value="0">Selecc</option>
	';
	do {
	echo '       <option value="'.$row_['Cedula'].'"';
	
	if($actual==$row_['Cedula']) echo ' selected="selected" ';
	
	echo '>';
	echo $row_['Apellidos'].' '.$row_['Nombres'];
	echo '</option>
	';
	} while ($row_ = mysql_fetch_assoc($RS));
	
	echo '</select>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
<link href="../../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../../estilos2.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="3">

<?php 
$sql = 'SELECT * FROM Curso WHERE SW_activo=1 ORDER BY NivelMencion, Curso, Seccion'; 
$RS = $mysqli->query($sql);
//$RS = mysql_query($sql, $bd) or die(mysql_error());
//$row_Curso = mysql_fetch_assoc($RS);


$sql_Aula = "SELECT * FROM Aula ORDER BY Codigo";


while ($row_Curso = $RS->fetch_assoc()) {
	$Curso = new Curso();
	$Curso->id = $row_Curso['CodigoCurso'];

?> 
<form id="form2" name="form2" method="post" action=""> 
  <tr <?php $sw=ListaFondo($sw,$Verde); ?> >
    <td><?php echo $row_Curso['NombreCompleto']; ?>      <input type="hidden" name="CodigoCurso" id="hiddenField" value="<?php echo $row_Curso['CodigoCurso']; ?>"/></td>
    <td valign="top" nowrap="nowrap"><?php 
   	  $nombre_campo = 'Cedula_Prof_Guia';
	  $actual = $row_Curso['Cedula_Prof_Guia'];
   	Maestra_($bd, $nombre_campo ,$actual); ?><br>
    <?php 
   	  $nombre_campo = 'Cedula_Aux1';
	  $Cedula_Aux = $row_Curso['Cedula_Prof_Aux'];
	  $Cedula_Aux = explode(',', $row_Curso['Cedula_Prof_Aux'].',');
	  $actual = $Cedula_Aux[0];
   	Maestra_($bd, $nombre_campo ,$actual); ?><br>
    <?php 
   	  $nombre_campo = 'Cedula_Aux2';
	  $actual = $Cedula_Aux[1];
   	Maestra_($bd, $nombre_campo ,$actual); ?>
    </td>
    <td valign="top" nowrap="nowrap"><?
    
	$sql2 = "SELECT * FROM Boleta_Indicadores
			WHERE NivelCurso = '".$Curso->NivelCurso()."'
			AND Responsable = 'E'
			GROUP BY Orden_Grupo";
	$RS2 = $mysqli->query($sql2);
	$Materias = "";
	$NombresMaterias = "";
	
	while($row2 = $RS2->fetch_assoc()){
		//echo $row2['Materia_Grupo'].'<br>';
		$Materias[] = str_replace(" ","_",NoAcentos($row2['Materia_Grupo']));
		$NombresMaterias .= str_replace(" ","_",NoAcentos($row2['Materia_Grupo'])).";";
		}
			
	
	
	
	?></td>
    <td valign="top" nowrap="nowrap"><?
if($Materias[0] > ""){   
	//echo "<pre>";
	//echo $row_Curso['Cedula_Prof_Esp'].'<br>';
	//   mate,234234;cas,12332;ing,12312;
	$Cedula_Prof_Esp = explode(';', $row_Curso['Cedula_Prof_Esp']);
	//var_dump($Cedula_Prof_Esp);
	//   mate,234234;
	//   cas,12332;
	//   ing,12312;
	
	foreach($Cedula_Prof_Esp as $Mat_Ced){
		$Mat_Ced = explode(',', $Mat_Ced);
		//Maestra_($bd, $Mat_Ced[0] ,$Mat_Ced[1]);
		$Cedula_Materia[$Mat_Ced[0]] = $Mat_Ced[1]; 
		
		}
	
	echo "<table>";	
	foreach(	$Materias as $Materia){
		echo "<tr><td>$Materia</td><td>";
		Maestra_($bd, $Materia ,$Cedula_Materia[$Materia]);
		echo "</td></tr>";
		}
	echo "</table>";	
		
	
}
unset($Cedula_Materia);
//$Cedula_Aux = $row_Curso['Cedula_Prof_Esp'];

//$Cedula_Aux = explode(',', $row_Curso['Cedula_Prof_Aux'].',');
//$actual = $Cedula_Aux[0];
//Maestra_($bd, $nombre_campo ,$actual);
	
	
	?><input type="hidden" name="NombresMaterias" value="<?= $NombresMaterias ?>" /></td>
    <td width="162" align="right"><input type="submit" name="button2" id="button2" value="Submit" /></td>
  </tr>
</form> 
    <?php } //while ($row_Curso = $RS->fetch_assoc() );//$row_Curso = mysql_fetch_assoc($RS)); ?>
 </table>
</body>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</html>
<?php
mysql_free_result($CursoMaterias);
?>
