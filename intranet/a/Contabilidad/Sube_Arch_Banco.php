<?php
$MM_authorizedUsers = "99,91,95,90";
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 
$TituloPantalla ="Archivos Banco";

function LimpiaStr($str){
	$CharValidos = array('','0','1','2','3','4','5','6','7','8','9','.','/',';',' ','*');
	$Letras = " qwertyuioplkjhgfdsazxcvbnmñ QWERTYUIOPLKJHGFDSAZXCVBNMÑ ";
	$Resultado = "";
	
	for ($i = 0 ; $i < 50 ; $i++){
		if($str[$i]>"" and (array_search($str[$i] , $CharValidos) or strpos($Letras , $str[$i]))){
			//echo "-".$str[$i]."-|";
			$Resultado .= $str[$i];
			}
		}
	return $Resultado;
}



// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name']) and $_POST["banco"]>'') {
	$NombreBanco = $_POST["banco"];
	$NombreArchivo = $_SERVER['DOCUMENT_ROOT'] ."/archivo/".$NombreBanco."/".date('Y_m_d_h_i_s').".txt";
    //echo $NombreArchivo;
	copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
	
	
	$lineas = file($_SERVER['DOCUMENT_ROOT'] .'/intranet/a/archivo/Variables_Privadas.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lineas as $linea) {
		//echo "Linea: ". ++$LinNum ."<br>";
		if(strpos($linea,"=")){
			//echo "  ";
			$Var = explode(" = ",$linea);
			
			$Valor = $Var[1];
			$Valor = str_replace('"','',$Valor); // elimina  "
			$Valor = str_replace(';','',$Valor); // elimina ;
			
			$Nombres = explode('"',$Var[0]);
			$Nombre = $Nombres[1];
			
			$FechaBanco[$Nombre] = $Valor;
			//echo $Nombre.' = '.$Valor.'<br>';
		}
	}
	
//echo "NombreBanco ".$NombreBanco;
//echo "<br><br><br>";	
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
	
	
} elseif(is_uploaded_file($_FILES['userfile']['tmp_name'])) {
    echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}






require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/BeforeHTML.php" );
?><!doctype html>
<html lang="es">
  <head>
	<? require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Head.php");  ?>
    <title><?php echo $TituloPag; ?></title>
</head>
<body <? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Body_tag.php");  ?>>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/NavBar.php");  ?>
<? require_once($_SERVER['DOCUMENT_ROOT'] . "/intranet/a/_Template/Header.php"); ?>
   
    <form enctype="multipart/form-data" action="Sube_Arch_Banco.php" method="post">
          <table width="600" border="0" align="center">
            <tr>
              <td colspan="2" class="subtitle">Enviar Archivo</td>
              <td align="right" class="subtitle"><a href="Banco_Consulta.php">Buscar</a></td>
              </tr>
            <tr>
              <td valign="top" class="NombreCampo">Banco</td>
              <td colspan="2" valign="top" class="FondoCampo"><label>
                <input name="banco" type="radio" id="banco_0" value="merc" />
                Mercantil <?php echo round((time()-$FechaBanco["merc"]) / 3600 , 2 ) ?></label>
                <br />
                <label>
                  <input type="radio" name="banco" value="prov" id="banco_1" />
                  Provincial <?php echo round((time()-$FechaBanco["prov"]) / 3600 , 2 ) ?>
                </label>
                <br />
                <label>
                  <input type="radio" name="banco" value="acti" id="banco_2" />
                  Activo <?php echo round((time()-$FechaBanco["acti"]) / 3600 , 2 ) ?>
                </label>
                  
                  </td>
              </tr>
            <tr>
              <td valign="top" class="NombreCampo">Archivo</td>
              <td colspan="2" valign="top" class="FondoCampo"><input name="userfile" type="file" /></td>
              </tr>
            <tr>
              <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
                <a href="../Busca_Banco.php">Buscar</a></td>
              <td colspan="2"><input type="submit" value="Enviar" /></td>
              </tr>
            </table>
          </form>
   
     
<?php if($NombreArchivo > "" and $NombreBanco > "" ){

$archivo = $NombreArchivo; 
//echo "archivo ".$archivo;
$lineas = file($archivo);

?>
          <table width="100%" border="0" align="center">
            <tr>
              <td colspan="10" class="subtitle">Procesamiento del Archivo</td>
              </tr>
            <tr>
              <td colspan="2" class="NombreCampoTopeWin">linea</td>
              <td class="NombreCampoTopeWin">Referencia</td>
              <td class="NombreCampoTopeWin">T</td>
              <td class="NombreCampoTopeWin">Descripcion</td>
              <td class="NombreCampoTopeWin">Ch N</td>
              <td class="NombreCampoTopeWin">MontoHaber</td>
              <td class="NombreCampoTopeWin">MontoDebe</td>
              <td class="NombreCampoTopeWin">ingres&oacute;</td>
              <td class="NombreCampoTopeWin">Usado</td>
              </tr>
            <?php 
$FechaInicial = "";
$FechaFinal = "";
$MesAnterior = 0;

foreach ($lineas as $linea_num => $linea) { 

if(isset($_GET["banco"])){ $NombreBanco = $_GET["banco"];}

if($NombreBanco=="merc"){ // MERCANTIL
	//echo $linea . "<br>";
	
	$linea = str_replace("VES" , "\"VES\"" ,  $linea) ;
	
	
	$linea = str_replace("\",\"", ";", $linea) ;
	
	
	$linea = str_replace(".", "", $linea) ;
	$linea = str_replace(",", ".", $linea) ;
	$linea = str_replace("\"", "", $linea) ;
	
	
	//echo $linea . "<br>";
	
	//echo $linea."<br>";
	$parte = explode(";", $linea);
	
	$Banco = 1;
	$Fecha = substr($parte[3],4,4).substr($parte[3],2,2).substr($parte[3],0,2);
	$Mes   = substr($parte[3],2,2);
	$Saldo = $parte[8]*1;
	$SaldoFinal = $SaldoMovAnterior;
	$FechaSaldoInicial = date('Y').$Mes.'01';
	$Referencia  = $parte[4]*1;
	$Descripcion = $parte[6]; 
	$Tipo        = $parte[5]; 
	
	if($Tipo=="SI") {
		$MontoHaber = $parte[7]*1; 
		$MontoDebe  = 0; 
	}
	
	if($Tipo=="RT") {
		$ChNum      = $Referencia;
		$MontoDebe  = $parte[7]*-1; 
		$MontoHaber = 0; 
	} else {$ChNum='';}
	
	if($Tipo=="ND") {
		$MontoDebe  = $parte[7]*-1; 
		$MontoHaber = 0; 
	}
	
	if($Tipo=="DP" or $Tipo=="NC") {
		$MontoDebe  = 0; 
		$MontoHaber = $parte[7]*1; 
	}
	
	//para nombre de archivo
	if($FechaInicial =="" and $Referencia > 0) {
		$FechaInicial = substr($parte[3],4,4)."_".substr($parte[3],2,2)."_".substr($parte[3],0,2);}
	$FechaFinal = substr($parte[3],2,2)."_".substr($parte[3],0,2);
	

	
} // fin MERCANTIL

if($NombreBanco=="prov"){ // PROVINCIAL
	$linea = str_replace("\"", "", $linea) ;
	$linea = str_replace(".", "", $linea) ;
	$linea = str_replace(",", "", $linea) ;
	$parte = explode(";", $linea);
	$parte[3] = (int)$parte[3];
	$parte[4] = (int)$parte[4];
	$parte[3] = $parte[3]/100;
	$parte[4] = $parte[4]/100;
	$Banco = 2;
	$Fecha = substr($parte[0],6,4).substr($parte[0],3,2).substr($parte[0],0,2);
	$Mes   = substr($parte[0],3,2);
	$Saldo = $parte[4]*1;
	$SaldoFinal = $Saldo;
	$FechaSaldoInicial = date('Y').$MesAnterior.'01';
	$Referencia  = (int)$parte[1];
	$Descripcion = $parte[2]; 
	$Tipo  = substr($parte[2],0,2); 
	$ChNum = substr((int)$parte[2], -6, 6);
	$monto = $parte[3]; 
	if($monto>=0) { 
		$MontoHaber = $monto*1; 
		$MontoDebe  = 0; }
	if($monto< 0) { 
		$MontoHaber = 0;
		$MontoDebe = $monto*-1; } 
	
	//para nombre de archivo
	if($FechaFinal =="" and $Referencia > 0) {
		$FechaFinal = substr($parte[0],3,2)."_".substr($parte[0],0,2);}
	$FechaInicial = substr($parte[0],6,4) ."_". substr($parte[0],3,2)."_".substr($parte[0],0,2);
} // fin PROVINCIAL

//echo "<pre>";





if($NombreBanco=="acti"){ // ACTIVO
	//echo "<br>inic: ".$linea;
	$linea = str_replace("\t", ";", $linea) ; // cambia coma decimal por punto
	//$linea = preg_replace('[^ A-Za-z0-9]', '', $linea);
	
	//$linea = str_replace("\",\"", ";", $linea) ; // CAMBIA SEPARATOS "," => ;
	$linea = str_replace(".", "", $linea) ; // elimina punto de millar
	$linea = str_replace(",", ".", $linea) ; // cambia coma decimal por punto
	$linea = str_replace("\"", "", $linea) ; // elimina punto de millar
	//$linea = str_replace("\"", "", $linea) ;  // elimina las doble comillas (posiblemento no requerido)
	//echo "<br>".$linea;
	//echo "<br>fin: ".$linea;
	//$linea = LimpiaStr($linea);
	//echo $linea;
	$parte = explode(";", $linea);
	/*
	0 13/06/2018;
	1 80753446;
	2 10;
	3 1001;
	4 Electron; 4221********3488;
	6 179055;
	7 5546925.31;
	8 0.00;
	9 0.53;
	No;No;N/A;0.00
	*/
	$Banco = 5;
	// dd/mm/aaaa
	// 01234567
	$Fecha = LimpiaStr($parte[0]);
	$Dia = substr($Fecha,0,2);
	$Mes = substr($Fecha,3,2);
	$Ano = substr($Fecha,6,4);
	$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
	
	$Lote = LimpiaStr($parte[2]);
	
	$Tipo = LimpiaStr($parte[3]); 
	
	$Descripcion = LimpiaStr($parte[4]." ".$parte[5]); 
	
	$Referencia  = LimpiaStr($parte[6]);
	
	
	$MontoHaber = LimpiaStr($parte[7]); 
	//$MontoHaber = preg_replace('[0-9]', '', $MontoHaber);
	
	$MontoDebe  = 0; 
	
	$Retencion = LimpiaStr($parte[8]);
	$Comision = LimpiaStr($parte[9]);
	
	//echo "<pre>Banco $Banco Fecha $Fecha Mes $Mes Referencia $Referencia Descripcion $Descripcion Lote $Lote Tipo $Tipo MontoHaber $MontoHaber MontoDebe $MontoDebe Retencion $Retencion Comision $Comision<br>";
	
		
	//para nombre de archivo
	if($FechaInicial == "" and $Referencia > 0) {
		$FechaInicial = substr($parte[3],4,4)."_".substr($parte[3],2,2)."_".substr($parte[3],0,2);}
	$FechaFinal = substr($parte[3],2,2)."_".substr($parte[3],0,2);
	

	
} // fin ACTIVO


//echo "ref ".$Referencia;
//	procesa fila omitiendo Titulo (p.e. provicial)
//echo strlen($Referencia);

if( ($NombreBanco=="acti" and strlen($Referencia) < 10) or $Referencia > 0

/*    or 
	($Descripcion == 'SALDO INICIAL') 
	and ( 
	substr($Fecha,-2)=='01' or
	substr($Fecha,-2)=='02' or
	substr($Fecha,-2)=='03' or
	substr($Fecha,-2)=='04' or
	substr($Fecha,-2)=='05' or
	substr($Fecha,-2)=='06' or
	substr($Fecha,-2)=='07' )*/
		) {
//echo "ref OK ".$Referencia;

if($MesAnterior > 0 and $MesAnterior != $Mes ){
	?><tr>
  <td colspan="2">&nbsp;Saldo Inicial Fecha <?php echo $FechaSaldoInicial; ?></td>
  <td colspan="2">Saldo <?php echo $SaldoFinal; ?></td>
  <td colspan="6">&nbsp;
  <?php 
// INGRESAR SALDO INICIAL
$sql = "DELETE FROM Contable_Imp_Todo 
		WHERE CodigoCuenta = '$Banco'
		AND Tipo = 'SI'
		AND Fecha = '$FechaSaldoInicial'";	
//echo $sql;  
$RS_ = $mysqli->query($sql);//mysql_query($sql, $bd) or die(mysql_error());
 
$sql = "INSERT INTO Contable_Imp_Todo 
			(CodigoCuenta, Fecha, Tipo, Referencia, Descripcion, MontoDebe, MontoHaber, ChNum) 
			VALUES 
			('$Banco','$FechaSaldoInicial','SI','0','Saldo Inicial','0','$SaldoFinal','')";
$RS = $mysqli->query($sql); // $RS_ = mysql_query($sql, $bd) or die(mysql_error());
//echo $sql;  
  
  ?>
  </td>
  </tr><?php 

	}



if($FechaAnterior != $Fecha){
?>
            <tr>
              <td colspan="10" class="NombreCampo">
			  <?php echo $Fecha; ?>
              </td>
            </tr>
              
<?php 
}
$FechaAnterior = $Fecha;


?>
<!--tr>
<td colspan="10" class="NombreCampo">
<?

$query_RS_Busca_Mov = "SELECT * FROM Contable_Imp_Todo 
						WHERE Referencia = '$Referencia'
						AND CodigoCuenta = '$Banco'
						AND Fecha = '$Fecha'
						AND MontoHaber = '$MontoHaber' 
						AND MontoDebe = '$MontoDebe'";
//echo $query_RS_Busca_Mov;	
	
$RS_Busca_Mov = $mysqli->query($query_RS_Busca_Mov);
$row_RS_Busca_Mov = $RS_Busca_Mov->fetch_assoc();
$totalRows_RS_Busca_Mov = $RS_Busca_Mov->num_rows;
	
	
//$RS_Busca_Mov = mysql_query($query_RS_Busca_Mov, $bd) or die(mysql_error());
//$row_RS_Busca_Mov = mysql_fetch_assoc($RS_Busca_Mov);
//$totalRows_RS_Busca_Mov = mysql_num_rows($RS_Busca_Mov);

if($totalRows_RS_Busca_Mov == 0){
	$query = "INSERT INTO Contable_Imp_Todo 
				(CodigoCuenta, Fecha, Tipo, Lote, Referencia, Descripcion, MontoDebe, MontoHaber, ChNum, Retencion, Comision) 
				VALUES 
				('$Banco','$Fecha','$Tipo','$Lote','$Referencia','$Descripcion','$MontoDebe','$MontoHaber','$ChNum','$Retencion','$Comision')";
	//$RS_query = mysql_query($query, $bd) or die(mysql_error());
	//echo " <br> $query ";
	$RS = $mysqli->query($query);
	$Codigo = $mysqli->insert_id;
	
	$SW_inserta = $Verde = true;
} else{
	$SW_inserta = $Verde = false;
	$Codigo = $row_RS_Busca_Mov['Codigo'];
} 
?>
</td>
</tr-->

            <tr>
              <td <?php ListaFondo($sw,$Verde); ?> colspan="2" align="center" ><?php echo $linea_num; ?> </td>
              <td align="center"  <?php ListaFondo($sw,$Verde); ?> ><?php echo $Lote ." ". $Referencia;   ?> </td>
              <td align="center" <?php ListaFondo($sw,$Verde); ?> ><?php echo $Tipo;   ?> </td>
              <td <?php ListaFondo($sw,$Verde); ?> ><?
              
			  if($MontoDebe <> 0){
			  ?>
<iframe src="Banco_Concilia_iFr.php?Codigo=<?php echo $Codigo ?>&import=1" width="100%" height="27" frameborder="0" scrolling="no"></iframe>
			  <?php 
			  }
			  else{
				echo $Descripcion;  
				  }
			  
			    ?></td>
              <td <?php ListaFondo($sw,$Verde); ?> ><?php echo $ChNum; ?> </td>
              <td align="right" <?php ListaFondo($sw,$Verde); ?> ><?php echo Fnum($MontoHaber); ?> </td>
              <td align="right" <?php ListaFondo($sw,$Verde); ?> ><?php echo Fnum($MontoDebe); ?> </td>
              <?php // Verifica si no exite e inserta la fila
?>
<td  <?php $sw = ListaFondo($sw,$Verde); ?> >
<?php 

?>
                </td>
              <td class="FondoCampo<?php if($totalRows_RS_Mov_Contable > 0) {echo "Verde";}?>"><?php echo $row_RS_Mov_Contable['Apellidos']; ?> <?php echo $row_RS_Mov_Contable['CodigoAlumno']; ?></td>
              </tr>
            <?php } // fin	no procesa fila con nombres
			
$MesAnterior = $Mes ;
$SaldoMovAnterior = $Saldo;		
			
} // fin FOREACH   


?>
            </table>
          <?php } 

// Cambiar nombre de archivo a fechas
if( isset($_POST["banco"])) {
//$ok = rename($NombreArchivo , $_SERVER['DOCUMENT_ROOT'] . "/archivo/$NombreBanco/".$FechaInicial."_al_".$FechaFinal.".txt" );
//echo "ok = ". $ok ;
//echo $FechaInicial."_al_".$FechaFinal.".txt";
}
?>      

<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer.php"); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/Footer_info.php"); ?>
</body>
</html>
<?php require_once($_SERVER['DOCUMENT_ROOT'] .  "/intranet/a/_Template/AfterHTML.php"); ?>