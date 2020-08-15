<div class="container-fluid">
    <div class="row">
		<div class="col-md-2">
			Grupos: 
		</div>
		<div class="col-md-2">
			<?= str_replace(","," ",$MM_authorizedUsers); ?>
		</div>
	</div>
	
	 <div class="row">
		<div class="col-md-2">
			Usuarios:
		</div>
		
		<?php 
			$Grupos = explode("," , $MM_authorizedUsers);
			foreach ( $Grupos as $Grupo ){
				$sql = "SELECT * FROM Usuario 
						 WHERE Privilegios = '$Grupo'";
				$RS = $mysqli->query($sql);
				while ($row = $RS->fetch_assoc()) {
					extract($row);
					
					?>
					
		<div class="col-md-2">
			<? echo " $Usuario ($Privilegios)  "; ?>
		</div>
		
					
					
					<?
					
					
					
					//echo "<br>";
				}
			}
	  
	  ?>
		
	
	
	 </div>
	
	
</div>
 

 
 
 
 <table border="1" align="center" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Usuarios:</strong></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><?= $sql; ?></td>
    </tr>
    <tr>
      <td colspan="2"><?= $debug; ?></td>
    </tr>
  </tbody>
</table>
