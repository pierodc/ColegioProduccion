<?php 
require_once('../../../Connections/bd.php');
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$CodigoEmpleado = $_GET['CodigoEmpleado'];
$AnoMesDia = $_GET['AnoMesDia'];
$Fecha = str_replace("_","-",$AnoMesDia);

if(isset($_POST['Nota'])){ // Actualiza registro
	$Nota = $_POST['Nota'];
	$sql = "UPDATE Empleado_EntradaSalida 
			SET Nota='$Nota' 
			WHERE Codigo_Empleado = '$CodigoEmpleado'
			AND Fecha = '".$Fecha."'";
	//echo $sql;
	$mysqli->query($sql);
	
}

$sqlMarco = "SELECT * FROM Empleado_EntradaSalida
					WHERE Codigo_Empleado = '$CodigoEmpleado'
					AND Fecha = '".$Fecha."'";
//echo $sqlMarco;					
$RS_Marco = $mysqli->query($sqlMarco);
$row_Marco = $RS_Marco->fetch_assoc();	

?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body <?php if(isset($_POST['Nota'])){echo 'onLoad="window.close();"';} ?> onLoad="Nota.focus()">
<form id="form1" name="form1" method="post">
  <input name="Nota" type="text" id="Nota" size="30" value="<?php echo $row_Marco['Nota']; ?>">
  <input type="submit" name="submit" id="submit" value="G">
Cerrar al guardar
</form>
</body>
</html>