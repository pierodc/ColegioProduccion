<?
$MM_authorizedUsers = "";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
if (isset($_COOKIE['MM_Username'])) {
  $MM_Username = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
}

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Usuario = new Usuario($MM_Username);
$Inventario = new Inventario($_GET['Agregar']);



//echo $MM_Username;
$Producto_Agregar = $Inventario->view();
//echo $Producto_Agregar[Precio_Dolares];

if(isset($_GET['Agregar'])){
	$id_inventario = $_GET['Agregar'];
	
	$sql = "SELECT * FROM ShopCart 
			WHERE id_user = '$Usuario->id'
			AND id_inventario = '$id_inventario'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	
	if ($RS->num_rows == 0){
		$sql =" INSERT INTO ShopCart
				(id_user,id_inventario,Precio) VALUES
				($Usuario->id,'$id_inventario','".$Producto_Agregar[Precio_Dolares]."')";
		//echo $sql;
		$mysqli->query($sql);
	}
}

if(isset($_GET['Eliminar'])){
	$id_eliminar = $_GET['Eliminar'];
	$sql = "DELETE FROM ShopCart
			WHERE id_user = $Usuario->id
			AND id_inventario = '$id_eliminar'
			AND id_cart = 0";
	//echo $sql;
	$mysqli->query($sql);
}



?>

<link href="/estilos.css" rel="stylesheet" type="text/css" />

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"><table width="100%" border="0">
    <tbody>
        <tr class="subtitle">
            <th colspan="4" scope="col">PEDIDO</th>
        </tr>
        <tr class="NombreCampoTITULO">
            <th scope="col">&nbsp;</th>
            <th scope="col">Descipci&oacute;n</th>
            <th align="center" scope="col">#</th>
            <th scope="col">&nbsp;</th>
        </tr>
        <? 
		$sql = "SELECT * FROM ShopCart , Inventario
				WHERE ShopCart.id_inventario = Inventario.id
				AND id_user = '$Usuario->id'";
		$RS = $mysqli->query($sql);
		while ($row = $RS->fetch_assoc()) {
			extract($row);
			?>
			<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
				<td>&nbsp;</td>
				<td><?= $Descripcion ?>&nbsp;</td>
				<td align="right"><? echo $Precio; $Total += $Precio; ?>&nbsp;</td>
				<td align="right"><a href="Carrito.php?Eliminar=<?= $id ?>">Eliminar</a></td>
			</tr>
			<? 
		}
		
		if($Total > 0){
		?>
		<tr>
			<td>&nbsp;</td>
			<td align="right"> T &nbsp;</td>
			<td align="right"><? echo Fnum($Total); ?>&nbsp;</td>
			<td align="right">&nbsp;</td>
		</tr>
		<? 
		}
  		?>
   
    </tbody>
</table>