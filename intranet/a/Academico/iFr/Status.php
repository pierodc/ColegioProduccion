<?php 
$MM_authorizedUsers = "99,91,95,90,secreAcad,secre,AsistDireccion,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 


	
?><link href="../../../../estilos2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style><?php 



if(	isset($_GET['NewStatus']) and ( $MM_UserGroup == "91" or $MM_UserGroup == "95" or $MM_UserGroup == "AsistDireccion")){
	
	
	$sql = "SELECT * FROM AlumnoXCurso WHERE Codigo = '".$_GET['Codigo']."'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	extract($row);
	$CodigoAlumno = $CodigoAlumno + 90000000;
	$sql = "INSERT INTO AlumnoXCurso (CodigoAlumno, CodigoCurso, Ano, Status, Status_Proceso_Ins, Status_por, Session_id, IP) VALUES
	('$CodigoAlumno', '$CodigoCurso', '$Ano', '$Status', '$Status_Proceso_Ins', '$Status_por', '$_Session_id', '$_IP')";
	
	//echo $sql;
	$mysqli->query($sql);
	
	
	if($_GET['NewStatus'] == "Inscrito"){
		$Fecha = " Fecha_Inscrito ";
	}elseif($_GET['NewStatus'] == "Retirado"){
		$Fecha = " Fecha_Retiro ";
	}elseif($_GET['NewStatus'] == "Aceptado"){
		$Fecha = " Fecha_Aceptado ";
	}else{
		$Fecha = " Fecha_Registro ";
	}
	
	$Fecha .= " = '".date("Y-m-d H:i:s")."', ";
	
	
	
	
	$sql = "UPDATE AlumnoXCurso
			SET Status = '".$_GET['NewStatus']."',
			$Fecha
			Status_por = '$MM_Username',
			Session_id = '$_Session_id',
			IP = '$_IP'
			
			WHERE Codigo = '".$_GET['Codigo']."'
			AND CodigoAlumno = '".$_GET['CodigoAlumno']."'";
	$mysqli->query($sql);
	//echo $sql;
}



$sql = "SELECT * FROM AlumnoXCurso 
		WHERE CodigoAlumno = '".$_GET['CodigoAlumno']."'
		ORDER BY Ano DESC";
$RS = $mysqli->query($sql);
?><table width="100%" border="0"><?php
while ($row = $RS->fetch_assoc()) {
	extract($row);
	if($Ano == $AnoEscolar)
		$Verde = true;
	else
		$Verde = false;
	?><tr <?php $sw=ListaFondo($sw,$Verde);?>><td nowrap="nowrap"><?php 
    echo "$Ano";
	?></td><td align="right" nowrap="nowrap"><?php 
	echo Curso($CodigoCurso);
	?></td>
<td align="right" nowrap="nowrap"><font color="#FF9900"> <?php 
	if($Verde and $Status == "Inscrito")
		echo '<B><font color="#009900">';
	
	elseif($Verde and $Status == "Aceptado")
		echo '<B><font color="#FF9900">';
	
	elseif($Verde and $Status == "Solicitando")
		echo '<B><font color="#000000">';
	else
		echo '<font color="#000000">';
		
	echo $Status;
	
	
	?></font></td>
    <td align="right" nowrap="nowrap"><?php //$Ano == $AnoEscolar or
	
	if(		(($Ano == $AnoEscolarProx or $Ano == $AnoEscolar) and strpos(' '.$Acceso_US , "all") )
		or
		 	($Ano == $AnoEscolarProx and strpos(' '.$Acceso_US , "Status")) ){
		
		$URLbase = "Status.php?Codigo=$Codigo&CodigoAlumno=$CodigoAlumno";
		if($Status == "Solicitando") {
		?><a href="<?= $URLbase ?>&NewStatus=Aceptado">Aceptar</a>
		<?php }
		if($Status == "Aceptado") {
		?><a href="<?= $URLbase ?>&NewStatus=Inscrito">Inscribir</a>
		<?php }
		if($Status == "Inscrito") {
		?><a href="<?= $URLbase ?>&NewStatus=Retirado">Retirar</a>
		<?php } 
		if($Status == "Retirado") {
		?><a href="<?= $URLbase ?>&NewStatus=Solicitando">Solicitar</a>
		<?php } 
		
	}
	?></td>
    
    <td align="right" nowrap="nowrap"><i><?php echo substr($Status_por,0,8) ?></i></td>
    <? if($MM_UserGroup == 91){ ?>
    <td align="right" nowrap="nowrap"><i><?php 
	if($Fecha_Inscrito > "0000-00-00")
		echo "I: ".DDMMAAAA($Fecha_Inscrito); 
	
	if($Fecha_Retiro > "0000-00-00")
		echo "R: ".DDMMAAAA($Fecha_Retiro) ;
	
	
	?></i></td>
    <? } ?>
</tr>
  <?php
}
?></table>