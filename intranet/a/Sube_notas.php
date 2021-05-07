<?php 
$SW_omite_trace = false;
require_once($_SERVER['DOCUMENT_ROOT'] . '/Config/Autoload.php'); 

if(isset($_GET['Eliminar']) and isset($_GET['archivo'])){
	if(file_exists('archivo/nota/'.$_GET['archivo']))
	unlink('archivo/nota/'.$_GET['archivo']);
	header("Location: ".$_SERVER['PHP_SELF']);
}
$Separador = $_POST['Separador'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<title><?php echo $TituloPantalla; ?></title>
<link href="../../estilos.css" rel="stylesheet" type="text/css" />
<link href="../../estilos2.css" rel="stylesheet" type="text/css" />
<title>Cargar Notas</title>
<script type="text/javascript">
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function KW_simpleUpdateItems(d,o,n,fn) { //v3.0 By Paul Davis www.kaosweaver.com
  var i,s,l=MM_findObj(d),b,z=o.options[o.selectedIndex].value;
  l.length=0;l.options[0]=new Option('tbd','tbd');b=(z!='nill')?eval('KW_'+z+n):0;
  for(i=0;i<b.length;i++){s=b[i].split("|");l.options[i]=new Option(s[1],s[0]);}
  l.selectedIndex=0;if (!fn) return;eval(fn)
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>
</head>

<body>
<form enctype="multipart/form-data" action="Sube_notas.php" method="post">
      <table width="600" border="0" align="center">
        <tr>
          <td colspan="2" class="subtitle">Enviar Archivo NOTAS</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Lapso</td>
          <td valign="top" class="FondoCampo"><select name="Lapso" id="Lapso">
            <option value="0">Auto</option>
            <option value="1">1ro</option>
            <option value="2"  selected="selected">2do</option>
            <option value="3" >3er</option>
          </select> <?= $AnoEscolar ?></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Nota</td>
          <td valign="top" class="FondoCampo"><label>
            <input name="nota" type="radio" value="7p" id="7" <?php if($_POST['nota']=='7p') echo 'checked="checked"'; ?> />
          70%</label>
          
            <label>
              <input name="nota" type="radio"  value="3p" <?php if($_POST['nota']=='3p') echo 'checked="checked"'; ?> />
              30%</label>
          
            <label>
            <input name="nota" type="radio" value="in" id="72"<?php if($_POST['nota']=='in') echo 'checked="checked"'; ?>  />
Inas</label>
            <label>
            <input name="nota" type="radio" value="BC" id="72"<?php if($_POST['nota']=='BC') echo 'checked="checked"'; ?>  />
B.Cond</label>


</td>
        </tr>
        <tr>
          <td class="NombreCampo">Curso</td>
          <td class="FondoCampo"><?php MenuCurso($_POST['CodigoCurso']," onchange=\"KW_simpleUpdateItems('materia',this,'_Data');\" "); ?></td>
        </tr>
        <tr>
          <td class="NombreCampo">Materia</td>
          <td class="FondoCampo"><select name="materia" id="materia" >
            <option value="0"> </option>
</select>
  <script language="JavaScript">
 
 <?php 
 
$query_RS_Cursos = "SELECT * FROM Curso WHERE SW_activo=1 AND NivelCurso>=31  ORDER BY Curso,Seccion";
$RS_Cursos =  $mysqli->query($query_RS_Cursos); // mysql_query($query_RS_Cursos, $bd) or die(mysql_error());
$row_RS_Cursos = $RS_Cursos->fetch_assoc();

do{
extract($row_RS_Cursos);	
	
echo " var KW_".$CodigoCurso."_Data = new Array();
	";	
	

$query_RS_Materias = "SELECT * FROM CursoMaterias WHERE CodigoMaterias = '".$CodigoMaterias."'"; 
$RS_Materias = $mysqli->query($query_RS_Materias); // mysql_query($query_RS_Materias, $bd) or die(mysql_error());
$row_RS_Materias = $RS_Materias->fetch_assoc();
	
	echo "KW_".$CodigoCurso."_Data[KW_".$CodigoCurso."_Data.length]=\"00|Todas\"
	";
	
	foreach (array('01','02','03','04','05','06','07','08','09','10','11','12','13') as $aux ){
	if($row_RS_Materias['Materia'.$aux] > "")
		echo "KW_".$CodigoCurso."_Data[KW_".$CodigoCurso."_Data.length]=\"$aux|".$row_RS_Materias['Materia'.$aux]."\"
	";
	
	}
echo "
";	
} while ($row_RS_Cursos = $RS_Cursos->fetch_assoc());
 
 ?>
 

 



</script>

</td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">&nbsp;</td>
          <td valign="top" class="FondoCampo"><p>Crear csv en Windows
              (por los saltos de linea)<br />
              Campos separados por&nbsp; &quot;,&quot;<br />
            Decimales indicado por &quot;.&quot;</p></td>
        </tr>
        <tr>
            <td valign="top" class="NombreCampo">Separador de nota</td>
            <td valign="top" class="FondoCampo"><select name="Separador" id="Separador">
                <option value=",">,</option>
                <option value=";"   selected="selected">;</option>
            </select></td>
        </tr>
        <tr>
          <td valign="top" class="NombreCampo">Archivo</td>
          <td valign="top" class="FondoCampo"><input name="userfile" type="file" /> 
          .csv Excel PC</td>
        </tr>
        <tr>
          <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
          <td><input type="submit" value="Enviar" /></td>
        </tr>
      </table>
    </form>
    
<table border="1" align="center">
<tr><td colspan="20"><?= $AnoEscolar; ?></td></tr>	

	<?php 

function NotaAUX($nota){
	echo "array pos $nota ".in_array($nota , array("A","B","C","D","E") )."<br>";
	if(in_array($nota , array("A","B","C","D","E") )){
		$nota;
		//echo " existe $nota ";
	}
	elseif($nota > 0 and $nota <= 20){
		$nota = round($nota*1,0);
		if ($nota > ''){ 
			$nota = substr('00'.$nota,-2);
		} 
		//else 
		//	$nota='';
	}
	return $nota;
}
	
//mysql_select_db($database_bd, $bd);


function CargarNotas($NombreArchivo,$AnoEscolar,$database_bd,$bd){ 
	
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";


	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);
	
	
	echo '<tr><td colspan="20">Ejecutando:  ';
	echo "NombreArchivo: " . $NombreArchivo."</td></tr>";
	$lineas = file( $NombreArchivo );
	//$lineas = explode(';;',$lineas);
	//$lineas = str_replace(";;", "\r\n", $lineas) ;
	
	//var_dump($lineas);
	
			$Lapso = substr($NombreArchivo,21,1);
			//echo "<br>Lapso: ".$Lapso;
			if (substr($NombreArchivo,23,1) == '3'){ $Lapso = $Lapso.'-30';}
			if (substr($NombreArchivo,23,1) == '7'){ $Lapso = $Lapso.'-70';}
			if (substr($NombreArchivo,23,1) == 'i'){ $Lapso = $Lapso.'i';  }
			if (substr($NombreArchivo,23,1) == 'B'){ $Lapso = $Lapso.'-BConduc';  }
			if( substr($NombreArchivo,26,1) == 'n')
				 $PosicionMateria = substr($NombreArchivo,26,3);
			else $PosicionMateria = '';

			$CodigoCurso = substr($NombreArchivo,18,2);
			
			//if($PosicionMateria=='')
			//	$sql = "UPDATE Nota SET $PosicionMateria = '01'";
			
				foreach ($lineas as $linea_num => $linea) { 
				?><tr class="FondoCampo" ><?
				echo "<td>". ++$f ."</td>";
				echo "<td>". $linea . PHP_EOL. "</td>";
				
					
					
					/*
					$linea = str_replace("\"", "", $linea) ; // Elimina las comillas "
					
					
					$tipo_Arch = substr_count($linea , ";");
					
					if($tipo_Arch > 7){
						//WIN
						$mas = 0; // para compensar la coma entre apellido y nombre
						$linea = str_replace(",", ".", $linea) ;
						$linea = str_replace(";", ",", $linea) ;
					}
					else{
						//MAC
						$mas = 1; // para compensar la coma entre apellido y nombre
						//$linea = str_replace(",", ";", $linea) ;
					}
					*/
					
					echo '<td colspan="15">'.substr($linea,0,100).'</td></tr><tr class="NombreCampo">';
					
					
					$parte = explode(";" , $linea);
					
					$CodigoAlumno = $parte[1];
					
					if(substr($NombreArchivo,23,1) == 'i'){
						$n01 = 1*($parte[3+$mas]);
						$n02 = 1*($parte[4+$mas]);
						$n03 = 1*($parte[5+$mas]);
						$n04 = 1*($parte[6+$mas]);
						$n05 = 1*($parte[7+$mas]);
						$n06 = 1*($parte[8+$mas]);
						$n07 = 1*($parte[9+$mas]);
						$n08 = 1*($parte[10+$mas]);
						$n09 = 1*($parte[11+$mas]);
						$n10 = 1*($parte[12+$mas]);
						$n11 = 1*($parte[13+$mas]);
						$n12 = 1*($parte[14+$mas]);
						$n13 = 1*($parte[15+$mas]);
						$n14 = 1*($parte[16+$mas]);
						$n15 = 1*($parte[17+$mas]);
						$n16 = 1*($parte[18+$mas]);
						$n18 = 1*($parte[19+$mas]);
						$n19 = 1*($parte[20+$mas]);
						$n20 = 1*($parte[21+$mas]);}
					else{
						$n01 = NotaAUX($parte[3+$mas]);
						$n02 = NotaAUX($parte[4+$mas]);
						$n03 = NotaAUX($parte[5+$mas]);
						$n04 = NotaAUX($parte[6+$mas]);
						$n05 = NotaAUX($parte[7+$mas]);
						$n06 = NotaAUX($parte[8+$mas]);
						$n07 = NotaAUX($parte[9+$mas]);
						$n08 = NotaAUX($parte[10+$mas]);
						$n09 = NotaAUX($parte[11+$mas]);
						$n10 = NotaAUX($parte[12+$mas]);
						$n11 = NotaAUX($parte[13+$mas]);
						$n12 = NotaAUX($parte[14+$mas]);
						$n13 = NotaAUX($parte[15+$mas]);
						$n14 = NotaAUX($parte[16+$mas]);
						$n15 = NotaAUX($parte[17+$mas]);
						$n16 = NotaAUX($parte[18+$mas]);
						$n18 = NotaAUX($parte[19+$mas]);
						$n19 = NotaAUX($parte[20+$mas]);
						$n20 = NotaAUX($parte[21+$mas]);}
						
					if($PosicionMateria!='')
						if		($n20>"") $Nota = $n20;
						elseif	($n19>"") $Nota = $n19;
						elseif	($n18>"") $Nota = $n18;
						elseif	($n17>"") $Nota = $n17;
						elseif	($n16>"") $Nota = $n16;
						elseif	($n15>"") $Nota = $n15;
						elseif	($n14>"") $Nota = $n14;
						elseif	($n13>"") $Nota = $n13;
						elseif	($n12>"") $Nota = $n12;
						elseif	($n11>"") $Nota = $n11;
						elseif	($n10>"") $Nota = $n10;
						elseif	($n09>"") $Nota = $n09;
						elseif	($n08>"") $Nota = $n08;
						elseif	($n07>"") $Nota = $n07;
						elseif	($n06>"") $Nota = $n06;
						elseif	($n05>"") $Nota = $n05;
						elseif	($n04>"") $Nota = $n04;
						elseif	($n03>"") $Nota = $n03;
						elseif	($n02>"") $Nota = $n02;
						elseif	($n01>"") $Nota = $n01;
						
				if($parte[0]>0 and $parte[0]<40  ){ //and $parte[1]>'0' and $parte[1]<'99999'
					
					// Una sola materia? SI -> 
					//			 Existe? SI -> UPDATE
					//  				 NO -> DELETE CREAR
					
					if($PosicionMateria!=''){ // UNA MATERIA
						
						$sql = "SELECT * FROM Nota 
								WHERE CodigoAlumno = '$CodigoAlumno' 
								AND Ano_Escolar = '$AnoEscolar' 
								AND Lapso='$Lapso'";
						//echo $sql."  6<br>";
						
						$RS =  $mysqli->query($sql); // mysql_query($sql, $bd) or die(mysql_error());
						$row = $RS->fetch_assoc();
						if($row['CodigoAlumno']!=''){ // EXISTE REGISTRO -> ACTUALIZAR
							$sql = "UPDATE Nota 
									SET $PosicionMateria = '$Nota' 
									WHERE CodigoAlumno = '$CodigoAlumno' 
									AND Ano_Escolar = '$AnoEscolar' 
									AND Lapso='$Lapso'";
								//echo $sql."  7<br>";
						}
						else {
							$sql = "INSERT INTO Nota 
									(CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, $PosicionMateria) VALUES 
									('$CodigoAlumno','$CodigoCurso','$AnoEscolar','$Lapso','$Nota')";
								//echo $sql."  8<br>";
						}
							$RS =  $mysqli->query($sql); // mysql_query($sql, $bd) or die(mysql_error());
							//echo '333  <br>';
							//echo $sql."  9<br>";
					} // FIN Una materia
					else {
						$sql = "DELETE FROM Nota 
								WHERE CodigoAlumno = '$CodigoAlumno' 
								AND Ano_Escolar = '$AnoEscolar' 
								AND Lapso = '$Lapso'";	
						$RS =  $mysqli->query($sql); // mysql_query($sql, $bd) or die(mysql_error());
						//echo $sql."<br>";
						$sql = "INSERT INTO Nota 
								(CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, 
								n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13) 
								VALUES
								('$CodigoAlumno','$CodigoCurso','$AnoEscolar','$Lapso',
								'$n01','$n02','$n03','$n04','$n05','$n06','$n07',
								'$n08','$n09','$n10','$n11','$n12','$n13')";
						$RS =  $mysqli->query($sql); // mysql_query($sql, $bd) or die(mysql_error());
						echo "<td>&nbsp;</td><td>$CodigoAlumno</td><td>$Lapso</td>
								<td>$n01</td><td>$n02</td><td>$n03</td><td>$n04</td><td>$n05</td>
								<td>$n06</td><td>$n07</td><td>$n08</td><td>$n09</td><td>$n10</td>
								<td>$n11</td><td>$n12</td><td>$n13</td></tr><tr><td colspan=20>$sql</td>";
						
						}
						
						// echo "CalcDefinitivaLapso $Lapso <br>";
						CalcDefinitivaLapso($CodigoAlumno, $Lapso, $CodigoCurso, $AnoEscolar, $database_bd, $bd);
						}
					
				echo "</tr>";
				echo "<tr><td colspan=9>".$sql."</td></tr>";
						
						} // FIN foreach Linea
			
	}


// Sube Archivo al servidor
if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {// and substr($_FILES['userfile']['tmp_name'] , -3) == "csv"
	$nota = $_POST['nota'];
	$CodigoCurso = $_POST['CodigoCurso'];
	if($_POST['materia']!='00')
		$PosicionMateria = '_n'.$_POST['materia'];
	
	
	if($_POST['Lapso'] > 0){
		$Lapso = $_POST['Lapso'];
		}
	else{
		if(date('n')=='11' or date('n')=='12' or date('n')=='1' or date('n')=='2') {$Lapso='1';  }
		if(date('n')=='3' or date('n')=='4' or date('n')=='5')   {$Lapso='2';  }
		if(date('n')=='6' or date('n')=='7')   {$Lapso='3';  }
	}
	$NombreArchivo = "archivo/nota/20" .$Ano1.'_'.$CodigoCurso.'_'.$Lapso.'_'.$nota . $PosicionMateria.".csv";
	
    copy($_FILES['userfile']['tmp_name'], $NombreArchivo );
	echo "<br>LLama Cargar Notas<br>";
	if($nota > "" and $CodigoCurso > "")
		CargarNotas($NombreArchivo,$AnoEscolar,$database_bd,$bd);
	
} else {
   // echo "Possible file upload attack. Filename: " . $_FILES['userfile']['name'];
}

?>
</table>  

<?php 
	
if (false and $gestor = opendir('archivo/nota/.') ) { 
	echo "Archivos:   <br>";
	while (false !== ($archivo = readdir($gestor))) {
		 if ($archivo != "." && $archivo != "..") { 
			echo ++$k.') Archivo: '.$archivo;
			echo "<a href=\"Sube_notas.php?Eliminar=1&archivo=$archivo\"> Eliminar</a>"."\n";
			echo "  <br>";
		 }
	}
closedir($gestor);
}
	?>

<?php include getenv('DOCUMENT_ROOT')."/inc/Footer_info.php"; ?>

</body>
</html>