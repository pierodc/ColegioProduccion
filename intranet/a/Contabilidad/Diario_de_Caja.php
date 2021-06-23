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


if (isset($_GET['Tipo'])) {
	$Tipo_ = $_GET['Tipo'];
	setcookie("Tipo_",$Tipo_,time()+3600);
}
elseif(isset($_COOKIE["Tipo_"])){
	$Tipo_ = $_COOKIE["Tipo_"];
}
else {
	$Tipo_ = "";
}


if (isset($_POST['Fecha_'])) {
	$Fecha_ = $_POST['Fecha_'];
	setcookie("Fecha",$Fecha_,time()+3600);
}
elseif(isset($_COOKIE["Fecha_"])){
	$Fecha_ = $_COOKIE["Fecha_"];
}
else {
	$Fecha_ = date('Y-m-d');
}

//echo $Fecha_;

//$Fecha_ = "2021-06-18";
$Resultado = $ContableMov->Diario($Fecha_,$Tipo_);


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
  
<div class="table">
 <div class="tr">
  <span class="td subtitle ">No</span>
  <span class="td subtitle ">Alumno</span>
  <span class="td subtitle center">Monto</span>
  <span class="td subtitle center">Forma Pago</span>
</div>
  
    
<? 
	foreach($Resultado as $res){
		$Alumno->id = $res['CodigoPropietario'];
		
		//Totales Usuario
		if ($ProcesadoPor_ante != $res['ProcesadoPor'] and $ProcesadoPor_ante > "" or $Resultado->num_rows == $i ){ ?>
		<!--div class="tr">
			<span class="td FondoCampo">TOTALES: <?= $ProcesadoPor_ante ?></span>
			<span class="td FondoCampo">&nbsp;</span>
			<span class="td FondoCampo">&nbsp;</span>
			<span class="td FondoCampo">&nbsp;</span>
		</div-->	
        
		<? foreach ($Total as $clave => $valor){ ?>
		<!--div class="tr">
			<span class="td FondoCampo">=></span>
			<span class="td FondoCampo"><? echo FormaDePago($clave) ?></span>
			<span class="td right FondoCampo"><? echo Fnum($valor) ?></span>
			<span class="td FondoCampo">&nbsp;</span>
		</div-->
		<? 
			$Caja->view($Fecha_ , $clave, $valor, $ProcesadoPor_ante);	

}  unset($Total);
		} 
		
		
		
		//TITULO Usuario
		if ($ProcesadoPor_ante != $res['ProcesadoPor']){ ?>
		<!--div class="tr">
		<span class="td NombreCampoTITULO">
			<? echo $res['ProcesadoPor']; ?>
		</span>
		<span class="td NombreCampoTITULO">&nbsp;</span>
		<span class="td NombreCampoTITULO">&nbsp;</span>
		<span class="td NombreCampoTITULO">&nbsp;</span>
		</div-->
		<? } 
		
		
		$ProcesadoPor_ante = $res['ProcesadoPor'];	
			
		
	?>
	       
	       
	       
	       
		       
<div class="tr">
    	<span class="td">
        <? echo ++$i; ?>
        </span>
    	<span class="td" title="<?= $res['ProcesadoPor'] ?>">
        <? echo $Alumno->NombreApellidoCodigo($res['CodigoPropietario']); ?>
        </span>
        <span class="td right">
        <? echo $res['MontoHaber_Dolares'];
			$Total[$res['Tipo']] += $res['MontoHaber_Dolares'];
			$GranTotal[$res['Tipo']] += $res['MontoHaber_Dolares'];
			?>
        </span>
		<span class="td center">
        <? echo FormaDePago($res['Tipo']); ?>
        </span>
</div>


<? 
	
	
	if ($ProcesadoPor_ante != $res['ProcesadoPor'] and $ProcesadoPor_ante > "" or $Resultado->num_rows == $i ){ ?>
		<!--div class="tr">
			<span class="td FondoCampo">TOTALES: <?= $ProcesadoPor_ante ?></span>
			<span class="td FondoCampo">&nbsp;</span>
			<span class="td FondoCampo">&nbsp;</span>
			<span class="td FondoCampo">&nbsp;</span>
		</div-->	
		<? foreach ($Total as $clave => $valor){ ?>
		<!--div class="tr">
			<span class="td FondoCampo">=></span>
			<span class="td FondoCampo"><? echo FormaDePago($clave) ?></span>
			<span class="td right FondoCampo"><? echo Fnum($valor) ?></span>
			<span class="td FondoCampo">&nbsp;</span>
		</div-->
		<? } $Caja->view($Fecha_ , $clave, $valor, $ProcesadoPor_ante);
			unset($Total);
		} 
		
	
	} 
					
?>
		<div class="tr">
			<span class="td NombreCampoTITULO">GRAN TOTALES</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
			<span class="td NombreCampoTITULO">&nbsp;</span>
		</div>	
		<? foreach ($GranTotal as $clave => $valor){ ?>
		<div class="tr">
			<span class="td">=></span>
			<span class="td"><? echo FormaDePago($clave) ?></span>
			<span class="td right"><? echo Fnum($valor) ?></span>
		</div>
		<? 
			$Caja->view($Fecha_ , $clave, $valor, "TOTAL");
												   }
	
	?> 
</div>

</div>

<iframe src="/inc/Observaciones.php?Area=DiarioDeCaja<?= $Fecha_ ?>" width="100%"></iframe>

<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php // require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>