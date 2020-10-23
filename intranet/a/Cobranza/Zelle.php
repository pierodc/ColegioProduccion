<?php 
$MM_authorizedUsers = "99,91,95,90,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPagina   = "Zelle"; // <title>
$TituloPantalla = "Zelle"; // Titulo contenido
$Banco = new Banco();

if(isset($_POST["time"])){
	if(isset($_POST['id'])){ // UPDATE
		$sql = "UPDATE Banco SET "; // Convertir generico
		foreach($_POST as $clave => $valor) {
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
			$sql = "INSERT INTO Banco ($Claves) VALUES ($Valores)";
			//$resultado .= $sql;
		}// INSERT
		
		//echo "<br><br><br><br><br>".$sql;
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
    
<div>  
</div>
    
 <div class="table">
 <div class="tr CampoNombre">
	<span class="td">No</span>
	<span class="td" nowrap >Fecha</span>
	<span class="td">Referencia</span>
	<span class="td">Tipo</span>
	<span class="td">Descripcion</span>
	<span class="td">Haber</span>
	<span class="td">Debe</span>
    <span class="td">Propietario</span>
	<span class="td">Observaciones</span>
</div>
 
 <? 
	
	 
	$RS = $Banco->view_tipo($tipo = "ZLL"); // ZLL NC TR
	 
	 
	while ($row = $RS->fetch_assoc()){
		extract($row);	
		$Fondo = "";
		if($_POST["id"] == $id) {
			$Fondo = "verde"; }
		
		
		// Coloca propietario a los mov del Zelle
		// Activar en timpo de transicion
		/*
		$sql = "SELECT * FROM `ContableMov` 
				WHERE Observaciones LIKE '%$Referencia%'
				OR Referencia LIKE '%$Referencia%'";
		$RS2 = $mysqli->query($sql);
		$row2 = $RS2->fetch_assoc();
		$Conteo2 = $RS2->num_rows;
		if($Conteo2 > 0){
			$sql = "UPDATE Banco SET Propietario = '".$row2['CodigoPropietario']."'
					WHERE id = '$id'";
			$mysqli->query($sql);
		}
		else{$sql = "";}
		*/
		
		
		?>

    <form class="tr FondoCampo" method="post" action="#<?= $Ln ?>">
       
        <span class="td <?= $Fondo ?>"><?= ++$Ln ; ?><a href="#" name="<?= $Ln+5 ?>"></a></span>
        <span class="td <?= $Fondo ?>"><? echo DDMMAAAA($Fecha) ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo $Referencia ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo $Tipo ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo substr($Descripcion,0,80) ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo Fnum($Haber) ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo Fnum($Debe) ; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Propietario","t",$Propietario,$Largo=20,$extra="") ; echo $sql; ?></span>
        <span class="td <?= $Fondo ?>"><? Campo("Observaciones","t",$Observaciones,$Largo=20,$extra="") ; ?></span>
        <span class="td <?= $Fondo ?>"><? echo $Registro_Por ; ?></span>
        <span class="td <?= $Fondo ?>"><? 
		
		Campo("Registro_Por","h",$MM_Username,$Largo=8,$extra="") ; 
		Campo("id","h",$id,$Largo=8,$extra="") ; 
		
		Boton_Submit() ;
		
		$monto_usar = 100;
		$Banco->Usar($id, $monto_usar ,1);	
			
			?></span>
        
       
        
    </form>

   <? } ?>
   
   
   
   <!--form class="tr FondoCampo" method="post" action="#<? $id ?>">
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
    </form-->
   
</div>	   
   
   
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>