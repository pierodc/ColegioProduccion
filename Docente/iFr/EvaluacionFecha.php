<?php 
require_once('../../Connections/bd.php'); 
require_once('../../intranet/a/archivo/Variables.php'); 
require_once('../../inc/rutinas.php'); 

//Codigo_Evaluacion
//Codigo_Curso
if(isset($_POST['Codigo'])){
	$sql_UPDATE = "UPDATE ce_Evaluacion_Fecha
					SET Fecha = '".$_POST['Fecha']."'
					WHERE Codigo = '".$_POST['Codigo']."'";
	$mysqli->query($sql_UPDATE);
//echo $sql_UPDATE;
	}

$sql = "SELECT * FROM ce_Evaluacion_Fecha
		WHERE Codigo_Evaluacion = '".$_GET['Codigo_Evaluacion']."'
		AND Codigo_Curso = '".$_GET['Codigo_Curso']."'";
$RS = $mysqli->query($sql);
if(!$row = $RS->fetch_assoc()){
	$sql_Insert = "INSERT INTO ce_Evaluacion_Fecha
					(Codigo_Evaluacion, Codigo_Curso)
					VALUES 
					('".$_GET['Codigo_Evaluacion']."', '".$_GET['Codigo_Curso']."')";
	$mysqli->query($sql_Insert);
//echo $sql_Insert;
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	}
//echo $sql;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Untitled Document</title>
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" <?php  
	
$sql_OtrasDelCurso = "SELECT * FROM ce_Evaluacion_Fecha
						WHERE Fecha = '".$row['Fecha']."'
						AND Codigo_Curso = '".$_GET['Codigo_Curso']."'";
$RS_OtrasDelCurso = $mysqli->query($sql_OtrasDelCurso);
$TotalPeso=0;

if ($row_OtrasDelCurso = $RS_OtrasDelCurso->fetch_assoc()) {
	$sql_Dificultad = "SELECT * FROM ce_Evaluacion_Fecha, ce_Evaluacion, ce_Tipo_Evaluacion
						 WHERE ce_Evaluacion_Fecha.Codigo_Evaluacion = ce_Evaluacion.Codigo
						 AND ce_Evaluacion.Tipo = ce_Tipo_Evaluacion.Nombre
						 AND ce_Evaluacion_Fecha.Fecha = '".$row['Fecha']."'
						 AND ce_Evaluacion_Fecha.Codigo_Curso = '".$_GET['Codigo_Curso']."'";
	$RS_Dificultad = $mysqli->query($sql_Dificultad);
	while ($row_Dificultad = $RS_Dificultad->fetch_assoc()) {
		$TotalPeso += $row_Dificultad['Dificultad'];
	}
}

	if($TotalPeso > 0)
		if($TotalPeso <= 50)
			echo 'bgcolor="#66FF99"';
		elseif($TotalPeso <= 100)
			echo 'bgcolor="#FF9900"';
		elseif($TotalPeso > 100)
			echo ' class=SW_Rojo';	
	// verde bgcolor="#66FF99"
	// naranja bgcolor="#FF9900"
	// rojo bgcolor="#FF3300"
	
	?>><form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
  <input name="Fecha" type="date" id="textfield" onchange="this.form.submit();" value="<?php echo $row['Fecha'] ?>" /><?php 
  
  if($row['Fecha'] > '2000-01-01'){
	  $Fecha = mktime(1,0,0,MesN($row['Fecha']),DiaN($row['Fecha']),AnoN($row['Fecha']));
	  $DiaSemana = date('N',$Fecha);
	  $DiasActivos = '  '.$_GET['DiasActivos'];
	  
	  if(strpos($DiasActivos , $DiaSemana) > 0)
	  	echo 'ok';
  }
//  		echo 'ok';
  
  
  //echo $TotalPeso;?>
  <input type="hidden" name="Codigo" id="Codigo" value="<?php echo $row['Codigo'] ?>" />
    </form></td>
  </tr>
</table>
</body>
</html>