<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPagina   = "Inventario"; // <title>
$TituloPantalla = "Inventario"; // Titulo contenido
	

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
		header("Location: ".$php_self);
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
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
   
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
    
    
    <div class="row">
		<div class="col-md-12">
			<div>
            <?
	echo $resultado;
	?>
            </div>
		</div>
	</div>
    
    
  	<div class="row CampoNombre" <? $i=0; ?> >
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre"><a href="?Sort=Nivel_Curso">Nivel_Curso </a></div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre">Cat1</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre">Cat2</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre">Cat3</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre">Descripcion</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre"><a href="?Sort=Autor">Autor </a></div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre"><a href="?Sort=Editorial">Editorial </a></div>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<div class="CampoNombre">Costo_Dolares</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<div class="CampoNombre">Precio_Dolares</div>
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<?  ?>
		</div>
		
	</div>
	
	<? 
	
	if ($Sort > ""){
		$Sort = "$Sort , Nivel_Curso,";
	}
	 else{
		 $Sort = "Nivel_Curso,";
	 }
	
	$sql = "SELECT * FROM Inventario ORDER BY $Sort Cat1, Cat2, Cat3";
	$RS = $mysqli->query($sql);
	
	while ($row = $RS->fetch_assoc()){
		extract($row);	
		
		$sw = on_off($sw); // Color fondo
		
		
		if(isset($_GET['id']) and $_GET['id'] == $id){
			?>
			
	<form action="" method="post" name="form1" id="form1">
	<div class="row FondoCampo" <? $i=0; ?> >
	
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Nivel_Curso","t",$Nivel_Curso,$Largo=8,$extra="") ; ?><a href="#" name="<?= $id ?>"></a>	
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat1","t",$Cat1,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat2","t",$Cat2,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat3","t",$Cat3,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Descripcion","t",$Descripcion,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Autor","t",$Autor,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Editorial","t",$Editorial,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Costo_Dolares","n",$Costo_Dolares,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Precio_Dolares","n",$Precio_Dolares,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?  Campo("id","h",$id,$Largo=8,$extra="") ; Boton_Submit() ; ?>
		</div>
		
	</div>
	</form>
	
	
			<?
		}
		else{
	?>
	<div class="row <? FondoListado($sw , $Verde); ?>"  <? $i=0; ?> >
		
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Nivel_Curso; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?> ">
			<?= $Cat1; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Cat2; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Cat3; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Descripcion; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Autor; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Editorial; ?>&nbsp;
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Costo_Dolares; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= $Precio_Dolares; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<a href="Inventario.php?id=<?= $id; ?>#<?= $id; ?>">Editar</a> 
		</div>
		
	</div>
	<? } 
	
	} // while ?>
	
	
	<form action="#forma" method="post" name="form1" id="form1">
	<div class="row FondoCampo" <? $i=0; ?> >
	
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Nivel_Curso","t",$Nivel_Curso,$Largo=8,$extra="") ; ?><a href="#" name="forma"></a>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat1","t",$Cat1,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat2","t",$Valor,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Cat3","t",$Valor,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Descripcion","t",$Valor,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Autor","t",$Valor,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Editorial","t",$Valor,$Largo=25,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Costo_Dolares","n",$Valor,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Campo("Precio_Dolares","n",$Valor,$Largo=8,$extra="") ; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<? Boton_Submit() ; ?>
		</div>
		
	</div>
	</form>
	
	<div class="row CampoNombre"  <? $i=0; ?> >
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Nivel_Curso; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Cat1; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Cat2; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Cat3; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Descripcion; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Autor; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Editorial; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Costo_Dolares; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= Precio_Dolares; ?>
		</div>
		<div class="col-md-<?= $col[$i++] ?>">
			<?= id; ?>
		</div>
		
	</div>
	
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>