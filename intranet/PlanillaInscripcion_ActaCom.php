<?php 
$pdf->AddPage();
$pdf->Ln(10);

LetraTit($pdf);

$pdf->Cell(200 , $Ln1*2 , 'ACTA COMPROMISO' , 0 , 1 , 'C'); 
$pdf->Ln(5);


LetraGde($pdf);

$pdf->Cell(10);
$pdf->MultiCell(180, 5 ,"Con el fin de dar cumplimiento a lo pautado en los Art. 5, Art, 53, Art, 54, Art 55, Art. 57 y Art. 93 de La LOPNNA y al contenido del Convenio Educativo que se suscribe todos los a�os entre Padre, Madre, Representante o Responsable, alumno(a) y la Direcci�n de esta Unidad Educativa, el(la) alumno(a) $Nombres $Apellidos portador/a de la C�dula de Identidad No. $CedulaLetra $Cedula_int inscrita/o para el a�o escolar $AnoEscolarProx en el Colegio San Francisco de As�s, se compromete a cumplir responsablemente con lo pautado en el Manual de Convivencia Escolar, la LOPNNA y las indicaciones del Departamento de Orientaci�n.
Teniendo siempre presente lo consagrado en la LOPNNA, Art�culo 8, Inter�s Superior de Ni�os, Ni�as y Adolescentes, literal b) la necesidad de equilibrio entre los derechos y garant�as de los ni�os, ni�as y adolescentes y sus deberes, literal c) la necesidad de equilibrio entre las exigencias del bien com�n y los derechos y garant�as del ni�o, ni�a o adolescente y literal d) la necesidad de equilibrio entre los derechos de las personas y los derechos y garant�as del ni�o, ni�a o adolescente. 

La/el adolescente, $Nombres $Apellidos, se compromete a DAR CUMPLIMIENTO Y RESPETAR, todas y cada una de las Cl�usulas y Normas del Reglamento de Convivencia Escolar, incluyendo el uso correcto del uniforme, utilizar lenguaje respetuoso acorde a la urbanidad y buenas costumbres, asistir diaria y puntualmente a todas las clases pautadas para el a�o escolar en curso, cumplir con las asignaciones, presentar las evaluaciones y participar activamente de las actividades escolares, seg�n pauta la ley. 

Destacando la importancia pedag�gica de establecer el principio de responsabilidad para el adolescente y la corresponsabilidad de la familia y la escuela para alcanzar estos logros. Quienes suscriben esta Acta asumen el compromiso de actuaci�n corresponsable familia � escuela. El padre y la madre, asumen el compromiso de asistir puntualmente a todas las reuniones, y actos a los que sean convocados, cumplir con las indicaciones del Departamento de Orientaci�n, involucrarse en las actividades escolares, dotar a su representado(a) de los libros, �tiles y uniforme necesarios, velar por la asistencia y puntualidad de el (ella) a clases y el cumplimiento de los deberes tanto acad�micos como los referidos a una sana convivencia escolar.

La Coordinaci�n respectiva realizar� el seguimiento e informar� peri�dicamente de los resultados, y de no verse progreso el caso ser� remitido a la instancia correspondiente.

En Caracas a los $hoy_dia d�as del mes de $hoy_mes de $hoy_ano

Se ley� y conforme firman






",0,'J');


LetraTit($pdf);
$pdf->Cell(10);
$pdf->Cell(70 , 5 , 'Firma Alumno' , 'T' , 0 , 'C'); 
$pdf->Cell(40); 
$pdf->Cell(70 , 5 , 'Firma Representante' , 'T' , 1 , 'C'); 

$pdf->Ln(20);

$pdf->Cell(10);
$pdf->Cell(70 , 5 , 'Firma Orientadora' , 'T' , 0 , 'C'); 
$pdf->Cell(40); 
$pdf->Cell(70 , 5 , 'Firma Coordinadora' , 'T' , 1 , 'C'); 


?>