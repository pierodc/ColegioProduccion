<?php 


if(strpos($_POST['Destino'],'?') > 0 )
	$Separa = '&';
else
	$Separa = '?';


$Destino = $_POST['Destino'].$Separa;


if($_POST['CodigoCurso'] > "")
	$Destino .= "&CodigoCurso=".$_POST['CodigoCurso'];


if(isset($_POST['AnoEscolar']))
	$Destino .= "&AnoEscolar=".$_POST['AnoEscolar'];

header("Location: ".$Destino);




?>