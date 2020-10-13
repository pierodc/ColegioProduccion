<?php 
$MM_authorizedUsers = "99,91,95,90,Contable,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPagina   = "Ordenes"; // <title>
$TituloPantalla = "Ordenes"; // Titulo contenido

//echo "<br><br><br><br><br>";
//var_dump($_POST);

//$Curso = new Curso($_GET['CodigoCurso']);

$Usuario = new Usuario($Usuario = "");
$Alumno = new Alumno("");
$ShopCart = new ShopCart($id = "");

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
	<span class="td">Usuario</span>
	<span class="td">Pedido</span>
	<span class="td">Pagado</span>
	<span class="td">En Proceso</span>
	<span class="td"></span>
	<span class="td">Status</span>
	<span class="td">Alumnos</span>
</div>
 
 <? 
	
		 	
	 
	$sql = "SELECT * FROM ShopCart 
			GROUP BY id_user
			ORDER BY id";
	//echo $sql;
	 $RS = $mysqli->query($sql);
	
	while ($row = $RS->fetch_assoc()){
		extract($row);	
		/*$Fondo = "";
		if($_POST["id"] == $id) {
			$Fondo = "verde"; }*/
		$Usuario->id = $id_user; 
		$Usuario->Email = $Usuario->view()["Usuario"]; 
		
		?>

    <form class="tr FondoCampo" method="post" action="#<?= $id ?>">
       
        <span class="td <?= $Fondo ?>"><?= ++$Ln ; ?><a href="#" name="<?= $id ?>"></a></span>
        <span class="td <?= $Fondo ?>">
			<a href="/intranet/Proveeduria/index.php?Usuario=<?= $Usuario->view()["Usuario"]; ?>" target="_blank">
			   <?= $Usuario->view()["Usuario"]; ?>
            </a>
        </span>
        
        
        
		<span class="td"><?
				$pedido = $ShopCart->view_pedidos( 0 , $Usuario->id);
				if($pedido->num_rows > 0)
					echo $pedido->num_rows;
		?></span>
        <span class="td"><?
				$pagados = $ShopCart->view_pedidos(1 , $Usuario->id);
				if($pagados->num_rows > 0)
					echo $pagados->num_rows;
		?></span>
        <span class="td"><?
				
				$enProceso = $ShopCart->view_pedidos(11 , $Usuario->id);
				if($enProceso->num_rows > 0)
					echo $enProceso->num_rows;
		?></span>
       <span class="td"><?
				/*if($pedido->num_rows - $pagados->num_rows - $enProceso->num_rows > 0)
					echo $pedido->num_rows - $pagados->num_rows - $enProceso->num_rows;*/
		?></span>
       
       <span class="td"> <a href="PDF/pedido_Representante.php?Usuario=<?= $Usuario->view()["Usuario"]; ?>" target="_blank">Imprimir</a>
<?
				
		?></span>
       
        
        <span class="td <?= $Fondo ?>"><? 
		$Alumnos = $Usuario->Alumnos();
		
		//if(array_count_values($Alumnos) > 0)
		foreach($Alumnos as $id_alumno){
			$Alumno->id = $id_alumno;
			echo "<a href=\"/intranet/a/PlanillaImprimirADM.php?CodigoAlumno=". $Alumno->id ."\" target=\"_blank\">";
			echo $Alumno->NombreApellidoCodigo();
			echo " ";
			//echo '</span><span class="td">';
			echo $Alumno->Status($AnoEscolar);
			echo "</a> / ";
			
			
			
		} ?></span>
        
    </form>

   <? } ?>
   
   
   

   
</div>	   
   
   
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>