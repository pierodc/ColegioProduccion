<?php 
$Lapsos = array(
'1-70;1er Lapso 70%',
'1-30;1er Lapso 30%',
'1-Def;1er Lapso Def',
'1-BConduc;1er Lapso B.Cond.',
'1i;1er Lapso Inas.',
'0; ',
'2-70;2do Lapso 70%',
'2-30;2do Lapso 30%',
'2-Def;2do Lapso Def',
'2-BConduc;2do Lapso B.Cond.',
'2i;2do Lapso Inas.',
'0; ',
'3-70;3er Lapso 70%',
'3-30;3er Lapso 30%',
'3-Def;3er Lapso Def',
'3-BConduc;3er Lapso B.Cond.',
'3i;3er Lapso Inas.',
'0; ',
'Def;Definitiva',
'Def_Ministerio;Def_Ministerio',
'RevDef;Rev.Def.',
'DefMatP;Def.Mat.Pend.',
'Revision;Revisión',
'Equivalencia;Equivalencia',
'0; ',
'1mp;1er Momento Mat.Pend.',
'2mp;2do Momento Mat.Pend.',
'3mp;3er Momento Mat.Pend.',
'4mp;4to Momento Mat.Pend.'

);


//function oi($i){ return substr('0'.$i,-2);}

function EnLetras ($Nota){
	
	if($Nota == '10')
		return 'Diez';
	elseif($Nota == '11')
		return 'Once';
	elseif($Nota == '12')
		return 'Doce';
	elseif($Nota == '13')
		return 'Trece';
	elseif($Nota == '14')
		return 'Catorce';
	elseif($Nota == '15')
		return 'Quince';
	elseif($Nota == '16')
		return 'Dieciseis';
	elseif($Nota == '17')
		return 'Diecisiete';
	elseif($Nota == '18')
		return 'Dieciocho';
	elseif($Nota == '19')
		return 'Diecinueve';
	elseif($Nota == '20')
		return 'Veinte';
	elseif($Nota == '*')
		return '*  *  *';
	elseif($Nota == '--')
		return 'Cursadas';
	elseif($Nota == 'P')
		return 'Pendiente';
	elseif($Nota == '-')
		return 'Exonerada';
		
	}

function Posicion ($database_bd, $bd, $Campo, $Nota, $CodigoCurso, $Lapso, $AnoEscolar) {
	
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);

	
	
	if ($Nota > 0){
	//mysql_select_db($database_bd, $bd);
	$sql = "SELECT * FROM Nota 
				WHERE CodigoCurso = ".$CodigoCurso." 
				AND Ano_Escolar='$AnoEscolar' 
				AND Lapso = '$Lapso' 
				AND ".$Campo." >' ' 
				ORDER BY ".$Campo." DESC"; 
	//echo $query;			
	$RS = $mysqli->query($sql);
	$row = $RS->fetch_assoc();
	$totalRows = $RS->num_rows;

		/*
	$RS = mysql_query($query, $bd) or die(mysql_error());
	$row = mysql_fetch_assoc($RS);
	$totalRows = mysql_num_rows($RS);*/
	$Pos = 1;
	//echo $query.$totalRows.'<br>';
	if( $totalRows > 0 ){
		do {
		if($Nota == $row[$Campo]) {
			//echo $Pos.'<br>';
			return $Pos.'º';
			//mysql_free_result($RS);
			break;}
		$Pos = $Pos + 1;
		} while ($row = $RS->fetch_assoc());}	
	} 
	else { 
	return '*';}
}			


function CalcDefinitivaLapso($CodigoAlumno, $Lapso, $CodigoCurso, $AnoEscolar, $database_bd, $bd){
	$hostname_bd = "localhost";
	$database_bd = "colegio_db";
	$username_bd = "colegio_colegio";
	$password_bd = "kepler1971";
	$mysqli = new mysqli($hostname_bd, $username_bd, $password_bd, $database_bd);


	$Lapso=substr($Lapso,0,1);
	
	if($Lapso!='R' and $Lapso!='D'){
	
		//mysql_select_db($database_bd, $bd);
		$query = "DELETE FROM Nota WHERE Ano_Escolar = '$AnoEscolar' AND Lapso = '$Lapso-Def' AND CodigoAlumno = '$CodigoAlumno'";
		$RS_ = $mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());
		
		$query_RS_Notas30 = "SELECT * FROM Nota WHERE Lapso = '$Lapso-30' AND Ano_Escolar = '$AnoEscolar' AND CodigoAlumno = '$CodigoAlumno'";
		$RS_Notas30 = $mysqli->query($query_RS_Notas30); //mysql_query($query_RS_Notas30, $bd) or die(mysql_error());
		$row_RS_Notas30 = $RS_Notas30->fetch_assoc();
		
		$query_RS_Notas70 = "SELECT * FROM Nota WHERE Lapso = '$Lapso-70' AND Ano_Escolar = '$AnoEscolar' AND CodigoAlumno = '$CodigoAlumno'";
		$RS_Notas70 = $mysqli->query($query_RS_Notas70); //mysql_query($query_RS_Notas70, $bd) or die(mysql_error());
		$row_RS_Notas70 = $RS_Notas70->fetch_assoc();
		
		$query_RS_Notas_BConduc = "SELECT * FROM Nota WHERE Lapso = '$Lapso-BConduc' AND Ano_Escolar = '$AnoEscolar'  AND CodigoAlumno = '$CodigoAlumno'";
		$RS_Notas_BConduc = $mysqli->query($query_RS_Notas_BConduc); //mysql_query($query_RS_Notas_BConduc, $bd) or die(mysql_error());
		$row_RS_Notas_BConduc = $RS_Notas_BConduc->fetch_assoc();
		
		foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Notas
			$n30 = $row_RS_Notas30['n'.$fila_x]; 
			$n70 = $row_RS_Notas70['n'.$fila_x]; 
			if($n30=='') 
				$n30 = $n70;
			$BConduc = $row_RS_Notas_BConduc['n'.$fila_x]*1;
			$promedio[$fila_x] = substr("00". round((int)$n30 * 0.3 + (int)$n70 * 0.7 + (int)$BConduc, 0), -2);
		}
		
		$query  = "INSERT INTO Nota (CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13) ";
		$query .= "VALUES ('$CodigoAlumno','$CodigoCurso', '$AnoEscolar', '$Lapso-Def', ";
		foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x)
			$query .= " '$promedio[$fila_x]',";
		$query .= "'') ";
		$RS_ = $mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());
		//echo $query;
	
	
		
	}
	
	
		// Calculo Def Año
		$totalRows_ = 0;
		foreach (array(1,2,3) as $Lapso){
			$query = "SELECT * FROM Nota WHERE Ano_Escolar = '$AnoEscolar' AND Lapso = '$Lapso-Def' AND CodigoAlumno = '$CodigoAlumno'";
			$RS_ = $mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());
			$row_ = $RS_->fetch_assoc();
			$totalRows_ += $RS_->num_rows;
			$Definitiva[$Lapso] = $row_;
		}
		// Revision Difinitiva
			$query = "SELECT * FROM Nota WHERE Ano_Escolar = '$AnoEscolar' AND Lapso = 'RevDef' AND CodigoAlumno = '$CodigoAlumno'";
			$RS_ =$mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());
			$row_ = $RS_->fetch_assoc();
			$RevDefinitiva[$Lapso] = $row_;


		$Divisor = 0;
		unset($promedio);
		$query = '';
		if($totalRows_ > 1){
			foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x) { // Notas
				
				if($RevDefinitiva[$Lapso]['n'.$fila_x] > ''){
					$promedio[$fila_x] = $RevDefinitiva[$Lapso]['n'.$fila_x];}
				else {
					if( $Definitiva[1]['n'.$fila_x] >='01' )
						$Divisor++; 
					if( $Definitiva[2]['n'.$fila_x] >='01' )
						$Divisor++; 
					if( $Definitiva[3]['n'.$fila_x] >='01' )
						$Divisor++; 
					if($Divisor>0)
						$promedio[$fila_x] = substr("00". round(($Definitiva[1]['n'.$fila_x]+$Definitiva[2]['n'.$fila_x]+$Definitiva[3]['n'.$fila_x])/$Divisor, 0), -2) ; 
					$Divisor = 0;
					
					}
				if($promedio[$fila_x]=='00') 
					$promedio[$fila_x]='';
			}
			
			
			$query = "DELETE FROM Nota WHERE Ano_Escolar = '$AnoEscolar' AND Lapso = 'Def' AND CodigoAlumno = '$CodigoAlumno'";
			//echo $query;
			$RS_ = $mysqli->query($query); //mysql_query($query, $bd) or die(mysql_error());

			
			$query  = "INSERT INTO Nota (CodigoAlumno, CodigoCurso, Ano_Escolar, Lapso, 
						n01, n02, n03, n04, n05, n06, n07, n08, n09, n10, n11, n12, n13) 
						VALUES ('$CodigoAlumno','$CodigoCurso', '$AnoEscolar', 'Def', ";
			foreach (array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12') as $fila_x){
				$query .= " '$promedio[$fila_x]',"; }
			$query .= "'') ";
			$RS_ = $mysqli->query($query); // mysql_query($query, $bd) or die(mysql_error());

				
			//echo $query;
		}
	
	
}



?>