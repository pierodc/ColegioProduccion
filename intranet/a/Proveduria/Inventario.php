<?php 
$MM_authorizedUsers = "99,91,95,90,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPagina   = "Inventario"; // <title>
$TituloPantalla = "Inventario"; // Titulo contenido

//echo "<br><br><br><br><br>";
//var_dump($_POST);

$Curso = new Curso($_GET['CodigoCurso']);

if(isset($_POST["time"])){
	if(isset($_POST['id'])){ // UPDATE
	
		$sql = "UPDATE Inventario SET ";
		
		foreach($_POST as $clave => $valor) {
			//$resultado .= "$clave = $valor <br>";	

			if($clave != "id" and $clave != "time"){
				$sql .= " $clave = '$valor',"; 
			}
			elseif($clave == "id"){
				$sql .= " WHERE id = '$valor'";
				
			}
						
			
		}
		
		$sql = str_replace(", WHERE"," WHERE ",$sql);
		
		//$resultado .= $sql;
		
	}  // UPDATE
	else { // INSERT
		
		foreach($_POST as $clave => $valor) {
				//$resultado .= "$clave = $valor <br>";	
				
				if($clave != "id" and $clave != "time") {
					$Claves .= "$clave,";
					$Valores .= "'$valor',";
				}
			
			}
			$Claves = substr($Claves,0,strlen($Claves)-1);
			$Valores = substr($Valores,0,strlen($Valores)-1);
			$sql = "INSERT INTO Inventario ($Claves) VALUES ($Valores)";
			//$resultado .= $sql;
		}// INSERT
		
		
		$mysqli->query($sql);
		//header("Location: ".$php_self);
	} 
	
	
	$col = array(2,2,2,6 ,6,3,3, 2,9,1);
	
if(isset($_GET['Sort'])){
	$Sort = $_GET['Sort'];
	setcookie("Sort", $Sort, time()+3600 ,"/");
	header("Location: ".$php_self);
}
if($_COOKIE['Sort'] > ''){
		$Sort  = $_COOKIE['Sort'];
}
//echo "<br><br><br><br>".$Sort;
//$Alumno = new Alumno($CodigoAlumno);

require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
   <style>
DIV.table 
{
    display:table;
}
DIV.tr:hover {	background-color: #EFEFEF;
}
FORM.tr, DIV.tr
{
    display:table-row;
	/*background-color: #F5F5F5;*/
}
FORM.tr:nth-child(even) {
	background-color: #F5F5F5;
}	   
FORM.tr:hover {	background-color: #FFF3CC;
}	   
	   
SPAN.td
{
    display:table-cell;
}
.verde{
   background: #C6FFC6;
}	   
</style>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    
 <div  >   
<? Ir_a_Curso($_GET['CodigoCurso'],$php_self."?CodigoCurso=", $MM_UserGroup ="" , $MM_Username="") ?>    
	</div>
    
 <div class="table">
 <div class="tr CampoNombre">
	<span class="td">No</span>
	<span class="td">Nivel_Curso</span>
	<span class="td">Cat1</span>
	<span class="td">Cat2</span>
	<span class="td">Cat3</span>
	<span class="td">Descripcion</span>
	<span class="td">Autor</span>
	<span class="td">Editorial</span>
	<span class="td">Costo_Dolares</span>
	<span class="td">Precio_Dolares</span>
</div>
 
 <? 
	
	if ($Sort > ""){
		$Sort = "$Sort , Nivel_Curso,";
	}
	 else{
		 $Sort = "Nivel_Curso,";
	 }
	
	 if(isset($_GET["CodigoCurso"])){
		 $add_sql = "WHERE Nivel_Curso = '".$Curso->NivelCurso."'";
	 }
	 	
	 
	$sql = "SELECT * FROM Inventario 
			$add_sql
			ORDER BY $Sort Cat1, Cat2, Cat3";
	//echo $sql;
	 $RS = $mysqli->query($sql);
	
	while ($row = $RS->fetch_assoc()){
		extract($row);	
		$Fondo = "";
		if($_POST["id"] == $id) {
			$Fondo = "verde"; }
		?>

    <form class="tr FondoCampo" method="post" action="#<?= $id ?>">
       
        <span class="td <?= $Fondo ?>"><?= ++$Ln ; ?><a href="#" name="<?= $id ?>"></a></span>
        <span class="td <?= $Fondo ?>"><? Campo("Nivel_Curso","t",$Nivel_Curso,$Largo=4,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat1","t",$Cat1,$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat2","t",$Cat2,$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat3","t",$Cat3,$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Descripcion","t",$Descripcion,$Largo=50,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Autor","t",$Autor,$Largo=8,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Editorial","t",$Editorial,$Largo=8,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Costo_Dolares","n",$Costo_Dolares,$Largo=3,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Precio_Dolares","n",$Precio_Dolares,$Largo=3,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("id","h",$id,$Largo=8,$extra="") ; Boton_Submit() ; ?></span>
        
    </form>

   <? } ?>
   
   
   
   <form class="tr FondoCampo" method="post" action="#<? $id ?>">
        <span class="td <?= $Fondo ?>">Agregar</span>
        <span class="td <?= $Fondo ?>"><? Campo("Nivel_Curso","t",$Curso->NivelCurso,$Largo=4,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat1","t","",$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat2","t","",$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Cat3","t","",$Largo=5,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Descripcion","t","",$Largo=25,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Autor","t","",$Largo=8,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Editorial","t","",$Largo=8,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Costo_Dolares","n","",$Largo=3,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Precio_Dolares","n","",$Largo=3,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? Boton_Submit() ; ?></span>
    </form>
   
</div>	   
   
   
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>