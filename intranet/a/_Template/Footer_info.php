
 <table>
  <tbody>
   
  
       <tr>
      <td> <?php 
			$Grupos = explode("," , $MM_authorizedUsers);
			foreach ( $Grupos as $Grupo ){
				$sql = "SELECT * FROM Usuario 
						 WHERE Privilegios = '$Grupo'";
				$RS = $mysqli->query($sql);
				while ($row = $RS->fetch_assoc()) {
					extract($row);
					echo " $Usuario ($Privilegios)  "; 
				}
			}
					?></td>
      </tr>
   
    <tr>
      <td><strong>Usuarios:</strong>&nbsp;<?= str_replace(","," ",$MM_authorizedUsers); ?></td>
      </tr>
    <tr>
      <td><?= $sql; ?></td>
    </tr>
    <tr>
      <td><?= $debug; ?></td>
    </tr>
  </tbody>
</table>
