<?php 

require_once('../../../Connections/bd.php');
$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

$CodigoEmpleado = $_GET['CodigoEmpleado'];
$AnoMesDia = $_GET['AnoMesDia'];

$Fecha = str_replace("_","-",$AnoMesDia);



$Obs = $_GET['Obs'];

$MM_Username  = $_COOKIE['MM_Username'];
setcookie("MM_Username", $MM_Username, time()+3600 ,"/");


if(isset($_GET['Obs'])){ // Actualiza registro
	$Registrado_Por = $MM_Username ;
	$Obs = $_GET['Obs'];


	$sqlMarco = "SELECT * FROM Empleado_EntradaSalida
					WHERE Codigo_Empleado = '$CodigoEmpleado'
					AND Fecha = '".$Fecha."'";
	$RS_Marco = $mysqli->query($sqlMarco);
	
	//echo $sqlMarco."<br>";

	if($row_Marco = $RS_Marco->fetch_assoc()){
		$sql = "UPDATE Empleado_EntradaSalida 
				SET Obs='$Obs', 
				Registrado_Por = '$Registrado_Por',
				Fecha = '$Fecha',
				Hora = '12:00:00'
				WHERE Codigo = '".$row_Marco['Codigo']."'";
		} 
	else{
		$sql = "INSERT INTO Empleado_EntradaSalida 
				SET Obs='$Obs', 
				Registrado_Por = '$Registrado_Por' ,
				Fecha = '$Fecha' ,
				Hora = '12:00:00',
				Codigo_Empleado = '$CodigoEmpleado'
				";
		} 
	if($Obs == "X"){
		$sql = "DELETE FROM Empleado_EntradaSalida 
				WHERE Fecha = '$Fecha'  
				AND Codigo_Empleado = '$CodigoEmpleado'";
		
		}
	//echo "<br>".$sql."<br>";	
	$mysqli->query($sql);
	//echo "<H1> $Obs </h1><br>".$sql.""; 

}


$Hora = time();


$sqlMarco = "SELECT * FROM Empleado_EntradaSalida
				WHERE Codigo_Empleado = '$CodigoEmpleado'
				AND Fecha = '".$Fecha."'";
//echo $sqlMarco;				
$RS_Marco = $mysqli->query($sqlMarco);

$URL = "Asis_jq.php?CodigoEmpleado=$CodigoEmpleado&AnoMesDia=$AnoMesDia&Obs=" ;
$Coord = $CodigoEmpleado ."_". $AnoMesDia;
?>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style><div id="Espacio_<?php echo $Coord ?>"><?php 
// echo "$Hora<br>";

if($row_Marco = $RS_Marco->fetch_assoc()){
	
	if($row_Marco['SW_Consolidado'] == 0){ ?>
        <a href="#" id="X_Click_<?php echo $Coord ?>" title="Click para borrar"><?php 
        echo $row_Marco['Obs']; ?></a><?php }
	else {
		echo $row_Marco['Obs']; 
		}
	?><br>
	<a href="Asis_Nota.php?<? echo "CodigoEmpleado=$CodigoEmpleado&AnoMesDia=$AnoMesDia"; ?>" target="_blank" title="<?php echo $row_Marco['Nota']; ?>"><?php if($row_Marco['Nota'] > "") {echo substr($row_Marco['Nota'],0,8);}else{echo "n";}?></a>
	<?	
}
else{	
//echo $sql;	

 ?><table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" colspan="2"><a href="#" id="Asis_Click_<?php echo $Coord ?>" title="Asistió">Asistió</a></td>
    </tr><tr>
    <td align="center"><a href="#" id="FDesc_Click_<?php echo $Coord ?>" title="Faltó Descontar 100%">Desc</a></td>
    <td align="center"><a href="#" id="C_Click_<?php echo $Coord ?>" title="Faltó Pagó suplente">Supl</a></td>
    </tr><tr>
    <td align="center"><a href="#" id="D_Click_<?php echo $Coord ?>">Rep 1-3</a></td>
    <td align="center"><a href="#" id="E_Click_<?php echo $Coord ?>">Rep 4..</a></td>
  </tr>
</table><?php } 
//echo $AnoMesDia; 
?>
<script>
$(document).ready(function() {
	$("#Asis_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."Asist" ?>");
	});
	$("#FDesc_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."Falto" ?>");
	});
	$("#C_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."Suplente" ?>");
	});
	$("#D_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."R-13" ?>");
	});
	$("#E_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."R-4" ?>");
	});
	$("#X_Click_<?php echo $Coord ?>").on("click",function(e){
	    e.preventDefault();
		$("#Espacio_<?php echo $Coord ?>").load("<?php echo $URL."X" ?>");
	});
});
</script>
</div>