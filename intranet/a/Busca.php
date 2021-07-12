<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
//header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPagina   = "Buscar"; // <title>
$TituloPantalla = "Buscando"; // Titulo contenido

$Alumno = new Alumno();
$Empleado = new Empleado();

$CodidoBuscando = 0;
if (isset($_POST['Buscar'])) {
	$Buscando = $_POST['Buscar'];
	$Alumnos = $Alumno->Buscar($Buscando);
	$Empleados = $Empleado->Buscar($Buscando);
 }
	

//require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?>
 
<!-- Trigger/Open The Modal -->
<div id="myXXXBtn">Open Modal</div>

<!-- The Modal -->
<div id="myModal" class="modal">
 
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Som<a href="index.php">e text in the M</a>odal..</p>
  </div>
  
</div>

   
<form action="" method="post">
    Buscar
    <input type="text" name="Buscar" value="<?= $_POST["Buscar"]; ?>">
    <input type="submit" name="submit" id="submit" value="Submit">
</form>

<div class="table">
<div class="tr">
   
   
   
    <span class="td">
    	<div class="table">
 <?  
	 foreach($Alumnos as $Al){
		 
	 $Alumno->id = $Al["CodigoAlumno"];
		if($Alumno->Inscrito( $AnoEscolar )) {
	  ?>
    	<div class="tr">
			<span class="td">
				<?
				echo $Alumno->id;
				?>
			 </span>
			<span class="td">
				<div id="myBtn">
				<?
				$Nombre = strtolower($Alumno->ApellidosNombres()); 
				$Nombre = str_replace($Buscando, "<b>".strtoupper($Buscando)."</b>", $Nombre);
				echo ucwords($Nombre);
				?>
				</div>
			 </span>
			<span class="td">
				<?
				if( $Alumno->Inscrito( $AnoEscolar ))
					echo $AnoEscolar;
				?>
			 </span>
		</div>	
			
			
    <? }} ?>  
    </div>
    </span>
    
    
    
    
    
    <span class="td">
    	<div class="table">
 <?  
	 foreach($Empleados as $Emp){
	 $Empleado->id = $Emp['CodigoEmpleado'];
	 if($Empleado->Status()) { 
	?>
    	<div class="tr">
			<span class="td">
				<?
				echo $Empleado->id;
				?>
			 </span>
			<span class="td">
				<?
		 
		 		$Nombre = strtolower($Empleado->ApellidosNombres()); 
				$Nombre = str_replace($Buscando, "<b>".strtoupper($Buscando)."</b>", $Nombre);
				echo ucwords($Nombre);
		 
				echo $Empleado->ApellidosNombres();
		 
		 
		 
				?>
			 </span>
			<span class="td">
				<?
				?>
			 </span>
		</div>	
			
			
    <? }} ?>  
    </div>
    </span>
    
       
    
    
    
    
    
    
    
    
    
    
   </div>
 </div>   
 
   
 <script> 
  // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
    </script>  
    