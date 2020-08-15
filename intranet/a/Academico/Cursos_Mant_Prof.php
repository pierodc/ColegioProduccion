<?php 
$MM_authorizedUsers = "91,95,AsistDireccion";
require_once('../../../inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

require_once('../../../Connections/bd.php'); 
require_once('../../../inc/rutinas.php'); 





mysql_select_db($database_bd, $bd);

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
	//$RS = mysql_query($sql, $bd) or die(mysql_error());
	
	foreach($_POST as $Variable => $Valor){
		$Var = explode("-" , $Variable);
		if($Var[0] == "Profesor"){
			$sql2 = "UPDATE CursoMaterias SET "	;
			$sql2 .= "Profesor$Var[2]  =  $Valor "; 
			$sql2 .= " WHERE CodigoMaterias = '$Var[1]'"	;
			//echo $sql2;
			$RS = mysql_query($sql2, $bd) or die(mysql_error());
			}
			
			}

	
	}


$query_CursoMaterias = "SELECT * FROM CursoMaterias";
$CursoMaterias = mysql_query($query_CursoMaterias, $bd) or die(mysql_error());
$row_CursoMaterias = mysql_fetch_assoc($CursoMaterias);
$totalRows_CursoMaterias = mysql_num_rows($CursoMaterias);

function Profesor_($bd, $nombre_campo ,$actual){ // AND CargoLargo LIKE '%pro%' // SW_activo=1 AND
	$sql = "SELECT * FROM Empleado 
			WHERE 
			 (TipoEmpleado LIKE '%1.%' OR TipoEmpleado LIKE '%2.%') 
			ORDER BY Apellidos, Nombres";
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
		echo "> ".$row_['Apellidos']." ".$row_['Nombres']."</option>
		";
	} while ($row_ = mysql_fetch_assoc($RS));
	echo '</select>';
}

function Maestra_($bd, $nombre_campo ,$actual){
	$sql = "SELECT * FROM Empleado WHERE SW_activo=1 ORDER BY Apellidos, Nombres";
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
</head>

<body>
<?php 
$mats = array("01","02","03","04","05","06","07","08","09","10","11","12","13");
do { ?>
   <form id="form1" name="form1" method="post" action=""> 
<table width="800" border="1" align="center" cellpadding="3">
<tr><td colspan="2" bgcolor="#CCCCCC"><?php echo $row_CursoMaterias['CodigoMaterias']; ?></td></tr>
    <?php foreach ($mats as $mat){ ?>
  <tr>
    <td><?php 
	echo $row_CursoMaterias['Materia'.$mat];
	?></td>
    <td><?php  
		 
		$nombre_campo = 'Profesor-'.$row_CursoMaterias['CodigoMaterias'].'-'.$mat;
		$actual = $row_CursoMaterias['Profesor'.$mat];
		Profesor_($bd, $nombre_campo ,$actual);
		echo '';
	  ?>&nbsp;</td>
  </tr>
<?php } ?>
<tr><td><input type="hidden" name="CodigoMaterias" id="hiddenField" value="<?php echo $row_CursoMaterias['CodigoMaterias']; ?>"/></td><td><input type="submit" name="button" id="button" value="Submit" /></td></tr>
</table>
</form><br>

<br>
<?php } while ($row_CursoMaterias = mysql_fetch_assoc($CursoMaterias)); ?>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>
<?php
mysql_free_result($CursoMaterias);
?>
