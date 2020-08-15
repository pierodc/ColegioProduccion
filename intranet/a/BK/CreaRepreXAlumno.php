<?php require_once('../../Connections/bd.php'); ?>
<?php require_once('../../inc/rutinas.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php 
$query_RS_Alumno = "SELECT * FROM Alumno 
					WHERE Creador > ' '
					ORDER BY CodigoAlumno";
$RS_Alumnos = mysql_query($query_RS_Alumno, $bd) or die(mysql_error());
$row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos);

$sql_insert = "INSERT INTO RepresentanteXAlumno (CodigoAlumno, CodigoRepresentante, Nexo, SW_Representante) VALUES ";

do{
	
	
	extract($row_RS_Alumnos);	
	echo ++$No.') ';
	echo $Creador.' ';
	
/*	$sql = "SELECT * FROM Representante 
			WHERE Creador = '$Creador'
			AND Nexo <> 'ExAutorizado'
			ORDER BY CodigoRepresentante";
*/
	$sql = "SELECT * FROM Abuelos 
			WHERE Creador = '$Creador'
			ORDER BY CodigoAbuelo";

	$RS_ = mysql_query($sql, $bd) or die(mysql_error());
	$row_RS_ = mysql_fetch_assoc($RS_);
	$totalRows_RS_ = mysql_num_rows($RS_);
	if($totalRows_RS_>0){
		
		
		do{
			
			/*if(strpos(' '.strtolower($row_RS_['SWrepre']) ,'s') >=1 )
				 $SWrepre='1';
			else*/
				 $SWrepre='0';
			
			$sql_insert .= "('".$CodigoAlumno."', 
							'".$row_RS_['CodigoAbuelo']."', 
							'".$row_RS_['Nexo']."', 
							'".$SWrepre."'),";
			
		}while($row_RS_ = mysql_fetch_assoc($RS_));
		
		
	}

	echo '<br>';
	
	
	
}while($row_RS_Alumnos = mysql_fetch_assoc($RS_Alumnos));

$sql_insert = substr($sql_insert,0, strlen($sql_insert)-1);
$RS_ = mysql_query($sql_insert, $bd) or die(mysql_error());

// echo $sql_insert;	

?>
</body>
</html>