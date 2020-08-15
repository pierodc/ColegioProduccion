<?php 
require_once('../../Connections/bd.php'); 
require_once('../../inc/rutinas.php'); 
//$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 

$sql = "SELECT * FROM Curso 
		WHERE SW_activo = '1'
		ORDER BY NivelCurso, Seccion";
$RS = $mysqli->query($sql);
echo $sql.'<br>';
while ($row = $RS->fetch_assoc()) { // Para cada Curso

	$Descripcion = $row['NombreCompleto'];
	$Capacidad = $row['Capacidad_Max'];
	
	
	$sql = "INSERT INTO Aula 
			(Descripcion, Capacidad)
			values
			('$Descripcion', '$Capacidad')";
echo $sql.'<br>';
	$mysqli->query($sql);
	
	$CodAula = $mysqli->insert_id;
	
	$sql = "UPDATE Curso
			SET Codigo_Aula = '$CodAula' 
			WHERE CodigoCurso = '".$row['CodigoCurso']."'";
echo $sql.'<br>';
	$mysqli->query($sql);
echo '<br>';

}
?>
</body>
</html>