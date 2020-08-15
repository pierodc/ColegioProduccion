<? 
$MM_authorizedUsers = "2,91,provee";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
if (isset($_COOKIE['MM_Username'])) {
  $MM_Username = (get_magic_quotes_gpc()) ? $_COOKIE['MM_Username'] : addslashes($_COOKIE['MM_Username']);
}

if(isset($_GET["Usuario"]) and $_GET["Usuario"] > ""){
	$MM_Username = $_GET["Usuario"];
	}

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$Usuario = new Usuario($MM_Username);
$Inventario = new Inventario($_GET['Agregar']);// Ubica el producto en inventario



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


if(isset($_GET['Cantidad']) and isset($_GET['id'])){
	$id = $_GET['id'];
	
	$sql = "SELECT * FROM ShopCart 
			WHERE id = '$id'";
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	
	$Cantidad = $row["Cantidad"]*1 + $_GET['Cantidad']*1;
	
	$sql = "UPDATE ShopCart 
			SET Cantidad = '$Cantidad'
			WHERE id = '$id'";
	
	$mysqli->query($sql);
}



$sql = "SELECT ShopCart.* , Inventario.* , ShopCart.id AS idshop FROM ShopCart , Inventario
				WHERE ShopCart.id_inventario = Inventario.id
				AND id_user = '$Usuario->id'
				ORDER BY Inventario.Cat1 DESC, Inventario.Nivel_Curso ASC";
$RS = $mysqli->query($sql);
		
?>

<link href="/estilos.css" rel="stylesheet" type="text/css" />

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
   <? if($RS->num_rows > 0){ ?>
   <table width="100%" border="0">
    
       <tbody>
        <tr class="subtitle">
            <th colspan="5" scope="col">PEDIDO</th>
        </tr>
        <tr class="NombreCampoTITULO">
            <th align="center" scope="col">Cant</th>
            <th scope="col">Descipci&oacute;n</th>
            <th align="center" scope="col"># </th>
            <th align="center" scope="col">&nbsp;</th>
            <th scope="col">&nbsp;</th>
        </tr>
        <? 
		while ($row = $RS->fetch_assoc()) {
			extract($row);
			?>
			<tr <?php $sw=ListaFondo($sw,$Verde); ?>>
				<td align="center">
				
				
				
				<?
					if($MM_UserGroup == 2 and !$SW_pagado){
						
					?>
				<a href="Carrito.php?id=<?= $idshop ?>&Cantidad=-1"><img src="../../i/delete.png" width="16" height="16" alt=""/></a>
				<?= $Cantidad ?>
		        <a href="Carrito.php?id=<?= $idshop ?>&Cantidad=1"><img src="../../i/add.png" width="16" height="16" alt=""/></a>
		        <?
					}
					elseif($MM_UserGroup == 91 or $MM_UserGroup == "provee"){
						
						Frame_SW ("id",$idshop,"ShopCart",'SW_pagado',$SW_pagado);
					}
					?>
		        
		        <?  ?>
		        </td>
				<td><?= $Descripcion ?>&nbsp;</td>
				<td align="right"><? echo $Precio*$Cantidad; $Total_Dolares += $Precio*$Cantidad; ?>&nbsp;</td>
				<td align="right"><?= Fnum($Precio*$Cambio_Paralelo*$Cantidad) ?></td>
				<td align="right">
				<? if(!$SW_pagado) { ?>
				<a href="Carrito.php?Eliminar=<?= $id ?>"><img src="/img/b_drop.png" width="16"  height="16"  alt="Eliminar"/></a>
				<?
 					}
				else{
					?>
					PAGADO
					<?
					}
					?>
				</td>
			</tr>
			<? 
		}
		
		if($Total_Dolares > 0){
		?>
		<tr>
			<td valign="middle"><img src="../../img/b.gif" width="1" height="32" alt=""/></td>
			<td align="right" class="BoletaNota"> Total &nbsp;</td>
			<td align="right" class="BoletaNota"><? echo Fnum($Total_Dolares); ?>&nbsp;</td>
			<td align="right" class="BoletaNota"><? echo Fnum($Total_Dolares * $Cambio_Paralelo); ?></td>
			<td align="right">&nbsp;</td>
		</tr>
		<? 
		}
  		?>
   
    </tbody>
</table>


<div>
	
	<p class="SW_Amarillo">Debe registrar el pago correspondiente al total indicado.</p>
	<p class="SW_Amarillo">Puede registrar el pago en las observaciones mas abajo</p>
	
	<p class="SW_Amarillo">El monto en Bss es v&aacute;lido por el dia <?= date("d-m-Y") ?>. Si hace el pago otro d&iacute;a debe verificar el monto actual.</p>
	
</div>


<? } ?>