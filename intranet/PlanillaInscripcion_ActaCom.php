<?php 
$pdf->AddPage();
$pdf->Ln(10);

LetraTit($pdf);

$pdf->Cell(200 , $Ln1*2 , 'ACTA COMPROMISO' , 0 , 1 , 'C'); 
$pdf->Ln(5);


LetraGde($pdf);

$pdf->Cell(10);
$pdf->MultiCell(180, 5 ,"Con el fin de dar cumplimiento a lo pautado en los Art. 5, Art, 53, Art, 54, Art 55, Art. 57 y Art. 93 de La LOPNNA y al contenido del Convenio Educativo que se suscribe todos los años entre Padre, Madre, Representante o Responsable, alumno(a) y la Dirección de esta Unidad Educativa, el(la) alumno(a) $Nombres $Apellidos portador/a de la Cédula de Identidad No. $CedulaLetra $Cedula_int inscrita/o para el año escolar $AnoEscolarProx en el Colegio San Francisco de Asís, se compromete a cumplir responsablemente con lo pautado en el Manual de Convivencia Escolar, la LOPNNA y las indicaciones del Departamento de Orientación.
Teniendo siempre presente lo consagrado en la LOPNNA, Artículo 8, Interés Superior de Niños, Niñas y Adolescentes, literal b) la necesidad de equilibrio entre los derechos y garantías de los niños, niñas y adolescentes y sus deberes, literal c) la necesidad de equilibrio entre las exigencias del bien común y los derechos y garantías del niño, niña o adolescente y literal d) la necesidad de equilibrio entre los derechos de las personas y los derechos y garantías del niño, niña o adolescente. 

La/el adolescente, $Nombres $Apellidos, se compromete a DAR CUMPLIMIENTO Y RESPETAR, todas y cada una de las Cláusulas y Normas del Reglamento de Convivencia Escolar, incluyendo el uso correcto del uniforme, utilizar lenguaje respetuoso acorde a la urbanidad y buenas costumbres, asistir diaria y puntualmente a todas las clases pautadas para el año escolar en curso, cumplir con las asignaciones, presentar las evaluaciones y participar activamente de las actividades escolares, según pauta la ley. 

Destacando la importancia pedagógica de establecer el principio de responsabilidad para el adolescente y la corresponsabilidad de la familia y la escuela para alcanzar estos logros. Quienes suscriben esta Acta asumen el compromiso de actuación corresponsable familia – escuela. El padre y la madre, asumen el compromiso de asistir puntualmente a todas las reuniones, y actos a los que sean convocados, cumplir con las indicaciones del Departamento de Orientación, involucrarse en las actividades escolares, dotar a su representado(a) de los libros, útiles y uniforme necesarios, velar por la asistencia y puntualidad de el (ella) a clases y el cumplimiento de los deberes tanto académicos como los referidos a una sana convivencia escolar.

La Coordinación respectiva realizará el seguimiento e informará periódicamente de los resultados, y de no verse progreso el caso será remitido a la instancia correspondiente.

En Caracas a los $hoy_dia días del mes de $hoy_mes de $hoy_ano

Se leyó y conforme firman






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