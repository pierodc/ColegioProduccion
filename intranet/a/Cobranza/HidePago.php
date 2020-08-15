<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<?php 

if (isset($_GET['SW_Postergado'])){
	require_once('../../../Connections/bd.php'); 
	require_once('../../../inc/rutinas.php'); 
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	$sql = "UPDATE ContableMov SET SW_Postergado = 1
			WHERE Codigo = '".$_GET['Codigo']."'";
	//echo $sql;		
	$RS = $mysqli->query($sql);
	echo "ok";
}
else{
	
	?>
    <a href="HidePago.php?SW_Postergado=1&Codigo=<?= $_GET['Codigo'] ?>" title="Click para ocultar" target="_self">
        <img src="../../../i/bullet_error.png" width="32" height="32" alt=""/>
    </a>   
	<?
	
	}



?>