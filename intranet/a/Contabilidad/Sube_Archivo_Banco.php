<?php 
//$MM_authorizedUsers = "99,91,95,90,secre,secreAcad,AsistDireccion,admin,Contable";
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc_login_ck.php'); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

$TituloPantalla ="Archivos Banco";
$banco = $_POST['banco'];
//$Transaccion = array();

function LimpiaStr($str){
	$CharValidos = array('','0','1','2','3','4','5','6','7','8','9','.','/',';',' ','*');
	$Letras = " qwertyuioplkjhgfdsazxcvbnmñ QWERTYUIOPLKJHGFDSAZXCVBNMÑ ";
	$Resultado = "";
	for ($i = 0 ; $i < 50 ; $i++){
		if($str[$i] > "" and (array_search($str[$i] , $CharValidos) or strpos($Letras , $str[$i]))){
			$Resultado .= $str[$i];
			}
		}
	return $Resultado;
}

// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name']) and $_POST[time] > '') {
	//$NombreBanco = $_POST[banco];
	$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] ."/archivo/".date('Y_m_d_h_i_s').".txt";
    //echo $NombreArchivo;
	
	
	$debug .= $_FILES['userfile']['name'] . "<br>";
	if (stripos($_FILES['userfile']['name'] , "EPORTE")){
		$NombreBanco = "prov" ;
	}
	elseif (stripos($_FILES['userfile']['name'] , "-".date(Y))){
		$NombreBanco = "merc" ;
	}
	elseif (stripos($_FILES['userfile']['name'] , "tmt ")){
		$NombreBanco = "bofa" ;
	}
	elseif (stripos($_FILES['userfile']['name'] , "hase1602")){
		$NombreBanco = "chase" ;
	}
	
	$debug .= $NombreBanco . "<br>";
	
	
	
	
	
	
	copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
	
	$lineas = file($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/archivo/Variables_Privadas.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		if(strpos($linea,"=")){
			$Var = explode(" = ",$linea);
			$Valor = $Var[1];
			$Valor = str_replace('"','',$Valor); // elimina  "
			$Valor = str_replace(';','',$Valor); // elimina ;
			$Nombres = explode('"',$Var[0]);
			$Nombre = $Nombres[1];
			$FechaBanco[$Nombre] = $Valor;
		}
	}

	
//echo "NombreBanco ".$NombreBanco;
//echo "<br><br><br>";	
// ACTUALIZA TIEMPO EN VAR PRIVADAS	
	$FechaBanco[$NombreBanco] = time();
	foreach ($FechaBanco as $clave => $Banco) {
		//echo '$FechaBanco["'.$clave.'"] = "'.$Banco.'";<br>';					
		$txt .= '$FechaBanco["'.$clave.'"] = "'.$Banco.'";
	';
	}
	//echo $txt;
	$txt = '<?php
	'.$txt.'?>';
	file_put_contents($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/archivo/Variables_Privadas.php',$txt);
// ACTUALIZA TIEMPO EN VAR PRIVADAS
	
} elseif(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}




/*
echo  "<br><br><br><br> ---- INICIO ---- <br><br>";
echo $NombreArchivo ."<br><br>";
echo "Banco: " . $NombreBanco ."<br><br>";
*/

$Banco = new Banco();
if($NombreArchivo > "" and $NombreBanco > "" ){
	$archivo = $NombreArchivo; 
	$lineas = file($archivo);
	
	foreach ($lineas as $linea_num => $linea) { 
		$_Fecha = "";
		$_Ref = "";
		$_Tipo = "";
		$_Descripcion = "";
		$_Monto = "";
		$_Haber = $_Debe = "";
		
		if($NombreBanco == "merc" and stripos($linea , "0105")){ // MERCANTIL
			$linea = str_replace(".", "", $linea) ;
			$linea = str_replace("\",\"", ";", $linea) ;
			$linea = str_replace("\"", "", $linea) ;
			$linea = str_replace(",", ".", $linea) ;
			
			$parte = explode(";", $linea);
			
			//echo "<pre>";
			//var_dump($parte);
			//echo "</pre>";
			
			if($parte['5'] != "SI" and $parte['5'] != "SF" )
			$_Fecha = substr($parte['3'],4,4)."-".substr($parte['3'],2,2)."-".substr($parte['3'],0,2);
			$_Ref = $parte['4'];
			$_Tipo = $parte['5'];
			$_Descripcion = $parte['6'];
			$_Monto = $parte['7'];

			if($_Tipo == "NC" or $_Tipo == "DE"){
				$_Haber = $_Monto;
			}
			else{
				$_Debe = $_Monto;
			}
			
			$Cuenta_id = 1;
		}
		
		
		if($NombreBanco == "prov"){ // PROVINCIAL
			$linea = str_replace("\";\"", ";", $linea);
			$linea = str_replace("\"", "", $linea);
			$linea = str_replace(".", "", $linea) ;
			$linea = str_replace(",", ".", $linea) ;
			
			$parte = explode(";", $linea);
			
			//echo "<pre>";
			//var_dump($parte);
			//echo "</pre>";
			
			if($parte['1']*1 > 0){
				$_Fecha = substr($parte['0'],6,4)."-".substr($parte['0'],3,2)."-".substr($parte['0'],0,2);
				$_Ref = $parte['1']*1;
				$_Tipo = substr($parte['2'],0,5);
				$_Descripcion = $parte['2'];
				$_Monto = $parte['3'];
				
				if($_Monto > 0){
					$_Haber = $_Monto;
				}
				else{
					$_Debe = $_Monto*-1;
				}
				
				
			}
			$Cuenta_id = 2;
		}
		
		
		if($NombreBanco == "bofa"){ // BOFA
			$linea = str_replace(",\"", ";", $linea) ;
			$linea = str_replace(",", "", $linea) ;
			$linea = str_replace("\"", "", $linea);
			
			$parte = explode(";", $linea);
			
			//echo "<pre>";
			//var_dump($parte);
			//echo "</pre>";
		
			if(strpos($parte['1'],"Conf")){
				$_Fecha = substr($parte['0'],6,4)."-".substr($parte['0'],0,2)."-".substr($parte['0'],3,2);
				$_Ref = substr($parte['1'],-9);
				$_Tipo = "ZLL";
				$_Descripcion = $parte['1'] . $parte['2'];
				
				$_Monto = $parte['3'];
				
				if($_Monto > 0){
					$_Haber = $_Monto;
				}
				else{
					$_Debe = $_Monto*-1;
				}
				
				
			}
			$Cuenta_id = 50;
		}
		
			
		if($NombreBanco == "chase"){ // CHASE
			$linea = str_replace(", ", " ", $linea) ;
			$linea = str_replace("\"", "", $linea) ;
		
			$parte = explode(",", $linea);
			
			if($parte['0'] == "CREDIT"){
				$_Fecha = substr($parte['1'],6,4)."-".substr($parte['1'],0,2)."-".substr($parte['1'],3,2);
				$_Ref = substr($parte['2'],-12);
				$_Tipo = "ZLL";
				$_Descripcion = $parte['2'];
				$_Haber = $parte['3'];
				
			}
			$Cuenta_id = 51;
		}
		
		/* */
		//echo $linea . "<br>";
		//echo "<b>Fecha: $_Fecha <br>Ref: $_Ref <br>Tipo: $_Tipo <br>Descripcion: $_Descripcion <br>Monto: $_Monto </b><br><br>";
		
		
		if($_Fecha > "2000-01-01"){
			$Transaccion[++$i] = array("Cuenta_id"=>$Cuenta_id,
									   "Fecha"=>$_Fecha,
									   "Referencia"=>$_Ref,
									   "Tipo"=>$_Tipo,
									   "Descripcion"=>$_Descripcion,
									   "Haber"=>$_Haber,
									   "Debe"=>$_Debe);
			
			//echo "<b>ADD</b><br><br>";
			$id = $Banco->Existe($Transaccion[$i]);
			if($id > 0)
				$Transaccion[$i][id] = $id ;
			else
				$Transaccion[$i][id] = 0 ;
		}
		

	}
	
	
	
	
	
	
	
	
	
	
}

?><!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Head.php"); ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body>
<? require_once($_SERVER['DOCUMENT_ROOT'] . '/intranet/a/_Template/NavBar.php');  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
  
    		
            <form enctype="multipart/form-data" action="" method="post">
          <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
            <tr>
              <td class="subtitle">Enviar Archivo</td>
              <td align="right" class="subtitle"><a href="Banco_Consulta.php">Buscar</a></td>
              </tr>
            <tr>
                <td valign="top" class="NombreCampo">Archivo</td>
                <td  valign="top" class="FondoCampo"><input name="userfile" type="file" /></td>
            </tr>
            <tr>
              <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                <a href="../Busca_Banco.php">Buscar</a></td>
              <td ><input type="submit" value="Enviar" />
                  <input type="hidden" name="time" value="<?= date(); ?>" /></td>
              </tr>
            <tr>
                <td>&nbsp;</td>
                <td >&nbsp;</td>
            </tr>
            </table>
          </form>
           
         
      
	
<?
	$i = 1;	
	if(is_array($Transaccion))
	foreach($Transaccion as $num => $Tr){
		$i++;	
		$Verde = 0;
		
		$Banco = new Banco($Tr[id]);
		//var_dump($Tr);
		if($Tr[id] > 0){
			$Verde = 1;
		}
		
?>
	
	 <div class="row <?php $sw = FondoListado($sw,$Verde); ?>" >
		<div class="col-md-2">
			<?= ++$Ln . ") ". DDMMAAAA($Banco->p->Fecha) ?>
		</div>
		<div class="col-md-1">
			<?= $Banco->p->Referencia ?>
		</div>
		<div class="col-md-1">
			<?= $Banco->p->Tipo ?>
		</div>
		<div class="col-md-4" >
			<?= $Banco->p->Descripcion ?>
		</div>
		<div class="col-md-2" align="right">
			<?= Fnum($Banco->p->Haber) ?>&nbsp;
		</div>
		<div class="col-md-2" align="right">
			<?= Fnum($Banco->p->Debe) ?>&nbsp;
		</div>
	</div>
	
<? 
}
?>
	
	
	
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/AfterHTML.php"); ?>