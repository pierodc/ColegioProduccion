<?
$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

if(isset($_GET['Agregar'])){
	$id_inventario = $_GET['Agregar'];
	$sql ="INSERT INTO ShopCart
			(id_user,id_inventario) VALUES
			(1,'$id_inventario')";
	$mysqli->query($sql);
}


$sql = "SELECT * FROM ShopCart
		WHERE id_user = 1";
$RS = $mysqli->query($sql);
while ($row = $RS->fetch_assoc()) {
	//extract($row);
	var_dump($row);
	echo "<br>";
}


?>