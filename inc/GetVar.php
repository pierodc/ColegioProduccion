<?
if(isset($_GET["id_Alumno"])){
	setcookie("id_Alumno",$_GET["id_Alumno"]);
	header("Location: ".$_SERVER['PHP_SELF']);
}
else{
	$_id_Alumno = $_COOKIE["id_Alumno"];
}

if(isset($_GET["id_Curso"])){
	setcookie("id_Curso",$_GET["id_Curso"]);
	header("Location: ".$_SERVER['PHP_SELF']);
}
else{
	$_id_Curso = $_COOKIE["id_Curso"];
}

?>