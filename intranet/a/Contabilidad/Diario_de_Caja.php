<?php 
$MM_authorizedUsers = "99,91,95,90,Contable";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

$TituloPagina   = "Diario de Caja"; // <title>
$TituloPantalla = "Diario de Caja"; // Titulo contenido

//require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/fpdf.php');
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$ContableMov = new ContableMov();
$Alumno = new Alumno($CodigoAlumno);
$Caja = new Caja();

if(isset($_GET["delete"])){
	$Caja->delete($_GET["delete"]);
	header("location: ".$php_self);
}

//var_dump($_COOKIE);

if (isset($_GET['Tipo'])) {
	$Tipo_ = $_GET['Tipo'];
	setcookie("Tipo_",$Tipo_,0);
}
elseif(isset($_COOKIE["Tipo_"])){
	$Tipo_ = $_COOKIE["Tipo_"];
}
else {
	$Tipo_ = "";
}


if (isset($_POST['Fecha_'])) {
	$Fecha_ = $_POST['Fecha_'];
	setcookie("Fecha_",$Fecha_, time() + (3600 * 8));
}
elseif(isset($_COOKIE["Fecha_"])){
	$Fecha_ = $_COOKIE["Fecha_"];
}
else {
	$Fecha_ = date('Y-m-d');
}

if(isset($_POST["Observaciones"])){
	$Monto += (float)$_POST["Ingreso"] ;
	$Monto -= (float)$_POST["Egreso"];
	
	$Caja->add($_POST['Fecha'] , 9, $Monto , $MM_Username, $_POST['Observaciones'], true);
	//add($Fecha, $FormaDePago = "" , $Monto = "", $Usuario = "", $Observaciones = "", $add = false ){
}




require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
  <meta charset="ISO-8859-1">
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
 <div class="container-fluid">
 
 
<div class="row">
<div class="col-md-6">
 <form id="form1" name="form1" method="post" action="">
      <label>Fecha:
      </label>
      <label><input name="Fecha_" type="date" value="<?php echo $Fecha_ ?>" onchange="form.submit();" />
        <input type="submit" name="button" id="button" class="button" value="Buscar" />
      </label>
      <a href="Diario_de_Caja.php?Tipo=9">Cash</a> | <a href="Diario_de_Caja.php?Tipo=8">Zelle</a> | <a href="Diario_de_Caja.php?Tipo=all">Todo</a>
 </form>    
  </div>
</div> 


<div class="row subtitle">
	<div class="col-md-6">
	 extraordinario
	  </div>
</div>  

<form id="form1" name="form1" method="post" action="">
<div  class="table">
	<div class="tr">
	 <span class="td ">
		  <label>Fecha:</label>
		  <input name="Fecha" type="date" value="<?php echo $Fecha_ ?>" required />
		  <label>Motivo:</label>
		  <input name="Observaciones" type="text" value="" required />
		  <label>Egreso:</label>
		  <input name="Egreso" type="text" value="" />
		  <label>Ingreso:</label>
		  <input name="Ingreso" type="text" value="" />
		  
		  <input type="submit" name="button" id="button" class="button" value="G" />
	    
		</span>	
	  </div>
</div>   
</form> 
      
      
<div class="table">
 <div class="tr">
  <span class="td subtitle ">No</span>
  <span class="td subtitle ">Alumno</span>
	<span class="td subtitle center">Haber</span>
	<span class="td subtitle center">Debe</span>
	<span class="td subtitle center">SubTotal</span>
	<span class="td subtitle center">Forma</span>
	<span class="td subtitle center">Resp</span>
</div>
  
    
    
    
    
<? 
	
	// Transacciones de ContableMov
	$Resultado = $ContableMov->Diario($Fecha_,$Tipo_);
	foreach($Resultado as $res){
		$Alumno->id = $res['CodigoPropietario'];
		$Totales[$res['ProcesadoPor']][$res['Tipo']] += $res['MontoHaber_Dolares'];
		$Total[$res['Tipo']] += $res['MontoHaber_Dolares'];
		
?>
	       
		       
<div class="tr">
    	<span class="td">
        <? echo ++$i; ?>
        </span>
    	<span class="td" title="<?= $res['ProcesadoPor'] ?>">
        <? echo $Alumno->NombreApellidoCodigo($res['CodigoPropietario']); ?>
        </span>
        <span class="td right">
        <? echo $res['MontoHaber_Dolares']; ?>
        </span>
		<span class="td right">
        <? echo ""; ?>
        </span>
		<span class="td right">
        <?  $SubTotal1 += $res['MontoHaber_Dolares']; 
			echo Fnum($SubTotal1); ?>
        </span>
		<span class="td center">
        <? echo FormaDePago($res['Tipo']); ?>
        </span>
		<span class="td center">
        <? echo substr($res['ProcesadoPor'],0,6); ?>
        </span>
</div>


<? 
	} 	
	?>
					
	
					
									
													
																	
																					
																									
																													
																																				
					
	<div class="tr">
			<span class="td NombreCampoTITULO">Extraordinario</span>
			<span class="td NombreCampoTITULO">Descripcion</span>
			<span class="td NombreCampoTITULO center">Haber</span>
			<span class="td NombreCampoTITULO center">Debe</span>
			<span class="td NombreCampoTITULO center">SubTotal</span>
			<span class="td NombreCampoTITULO center">Forma</span>
			<span class="td NombreCampoTITULO center">Resp</span>
		</div>					
	<?		
	
	$Resultado = $Caja->view($Fecha_ , "9");
	foreach($Resultado as $res){
					
?>
	<div class="tr">
    	<span class="td">
        <? echo ++$i; ?>
        </span>
    	<span class="td">
        <? echo $res['Observaciones']; ?>
        </span>
        <span class="td right">
        <?  echo $res['Haber']; 
			$SubTotal += $res['Haber']; ?>
        </span>
		<span class="td right">
        <?  echo $res['Debe'];  
			$SubTotal += $res['Debe'];  ?>
        </span>
		<span class="td right">
        <? echo Fnum($SubTotal) ?>
        </span>
		<span class="td center">
        <? echo "" ?>
        </span>
		<span class="td center">
        <? echo substr($res['Usuario'],0,6); ?>
        <? if( $res['Fecha'] == date("Y-m-d") and $res['Usuario'] == $MM_Username or $MM_Username == "piero") { ?>
        <a href="?delete=<?= $res['id'] ?>" onclick="return confirm('Desea eliminar:  <?= $res['Observaciones'] ?>?');"><img src="/i/delete.png" width="16" height="16" alt=""/></a> 
        <? } ?>
        </span>
</div>
	
<?
	} 
	
	$Extraordinario[9] = $SubTotal;
	//$Total[9] += $SubTotal;
	//$Total[9] += $SubTotal;
	
	?>	











	
		<div class="tr">
			<span class="td NombreCampoTITULO">Sub Totales</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
		</div>	
 <? 
	
	$Totales["Extraordinario"] = $Extraordinario;
	$Totales["Total"] = $Total;
	
	$Totales["Total"][9] += $Totales["Extraordinario"][9];
	/*
	echo "<pre>Totales:<br>";
	var_dump($Totales);
	echo "</pre>";*/
	foreach ($Totales as $Usuario => $Valores){
	 ?>       
        <div class="tr">
			<span class="td NombreCampo"><? echo $Usuario; ?></span>
			<span class="td NombreCampo">&nbsp;</span>
			<span class="td NombreCampo">&nbsp;</span>
			<span class="td NombreCampo">&nbsp;</span>
			<span class="td NombreCampo">&nbsp;</span>
			<span class="td NombreCampo">&nbsp;</span>
			<span class="td NombreCampo">&nbsp;</span>
		</div>	
		
		<? foreach ($Valores as $FormaDePago => $Monto){ ?>
		<div class="tr">
			<span class="td ">&nbsp;</span>
			<span class="td ">&nbsp;</span>
			<span class="td ">&nbsp;</span>
			<span class="td "><? echo FormaDePago($FormaDePago); ?></span>
			<span class="td right"><? echo fnum($Monto); ?></span>
			<span class="td ">&nbsp;</span>
			<span class="td ">&nbsp;</span>
		</div>	
<? 			//echo "$Fecha_ , $FormaDePago, $Monto, $Usuario<br>";
			//if()											
			//$Caja->add($Fecha_ , $FormaDePago, $Monto, $Usuario);
			//add($Fecha, $FormaDePago = "" , $Monto = "", $Usuario = "", $Observaciones = "", $add = false ){									 
												}} ?>        
        
	
	
	
	
<div class="tr">
			<span class="td subtitle">Observaciones</span>
			<span class="td subtitle">&nbsp;.</span>
			<span class="td subtitle">&nbsp;.</span>
			<span class="td subtitle">&nbsp;.</span>
			<span class="td subtitle">&nbsp;.</span>
			<span class="td subtitle">&nbsp;.</span>
			<span class="td subtitle">&nbsp;.</span>
</div>

	
</div>
<iframe src="/inc/Observaciones.php?Area=DiarioDeCaja<?= $Fecha_ ?>" width="100%"></iframe>

</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>