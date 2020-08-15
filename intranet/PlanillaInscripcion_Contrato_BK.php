<?php 


$pdf->AddPage();
LetraGdeBlk($pdf);
$pdf->Cell(200 , $Ln1 , 'U.E. Colegio San Francisco de Asís' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'INSCRITO EN EL MPPE CÓDIGO S0934D1507' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Los Palos Grandes, Municipio Chacao del Estado Miranda' , 0 , 1 , 'C'); 
$pdf->Cell(200 , $Ln1 , 'Contrato de Prestación de Servicios Educativos ' , 0 , 1 , 'C'); 

$pdf->SetFont('Arial','',9);
$i=1;$j=2;
$Fecha_Nac = substr($row_RS_Alumno['FechaNac'], 8, 2).'-'.substr($row_RS_Alumno['FechaNac'], 5, 2).'-'.substr($row_RS_Alumno['FechaNac'],0,4) ;

$pdf->MultiCell(200, 3.2 ,"Entre ________________________, venezolano, mayor de edad, de este domicilio, identificado con la cédula de identidad No. V-________________, en su carácter de representante de la Unidad Educativa COLEGIO SAN FRANCISCO DE ASÍS, inscrito ante el Ministerio de Educación y Deportes bajo el No. S0934D1507, ubicado en la calle 7 entre 4ta. Y 5ta. Av. de la Urbanización Los Palos Grandes, Caracas, en lo adelante y a los efectos de este contrato LA INSTITUCIÓN, por una parte; y, por la otra, $rep_Nombres[$i] / $rep_Nombres[$j], de nacionalidad $rep_Nacionalidad[$i] / $rep_Nacionalidad[$j], mayor de edad, de este domicilio, identificado con la cédula de identidad No. $rep_Cedula[$i]/$rep_Cedula[$j], en lo adelante EL REPRESENTANTE LEGAL, actuando en su carácter de ________/________ del menor $Apellidos $Nombres, de nacionalidad $Nacionalidad, nacido en  $Localidad, el día $Fecha_Nac, en lo adelante EL ESTUDIANTE, se ha convenido en celebrar como en efecto se celebra el presente CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCATIVOS, el cual se regirá por las siguientes cláusulas:
    Cláusula Primera : LA INSTITUCION es una empresa de carácter privado no subsidiada por un ente oficial, ni de la administración pública central ni descentralizada, que presta servicios de instrucción, atención, educación y cuidado en general a estudiantes que así lo soliciten, prestando sus servicios durante los días hábiles en el calendario educativo que a tal efecto decrete el Ministerio del P.P. para la Educación, en el turno indicado y en las condiciones del presente contrato. En virtud a lo anterior, LA INSTITUCION se compromete a brindar a EL ESTUDIANTE una educación de calidad, garantizar el adecuado mantenimiento de su planta física, garantizar la dotación de los insumos necesarios para su buen funcionamiento, así como garantizar la contratación de personal capacitado, poseedor de valores éticos y morales. 
    Cláusula Segunda : Forman parte integrante del presente contrato las estipulaciones contenidas en el mismo, el Manual de Convivencia Escolar de LA INSTITUCION, el cual se encuentra publicado en la página web www.sanfrancisco.e12.ve, el cual declaran conocer y aceptar y, las declaraciones e informaciones contenidas en las solicitudes firmadas por EL REPRESENTANTE LEGAL de EL ESTUDIANTE y los anexos incorporados en el expediente correspondiente; todo lo cual EL REPRESENTANTE LEGAL declara expresamente conocer y estar conforme con los mismos. 
    Cláusula Tercera: La vigencia del presente contrato es por el término de un año fijo escolar, entendiendo por tal el que se inicia el 16 de septiembre de $Ano1prox y culmina el 31 de julio de $Ano2prox. 
    Cláusula Cuarta: El presente contrato se perfecciona una vez que EL REPRESENTANTE LEGAL suscriba el registro de EL ESTUDIANTE y cancele total o parcialmente el monto correspondiente de la matrícula o inscripción, útiles escolares o materiales, Seguro Escolar, Servicio de Ambulancia, cuota anual de la Comité de Padres y Representantes, actividades extracurriculares y mensualidades. 
    Cláusula Quinta: Se entiende como \"Actividades Extracurriculares\", optativas, aquellas que están fuera del pensum de estudio exigido por el Ministerio del Poder Popular para la Educación. Asimismo, comprende las horas de clases impartidas en las distintas materias, adicionales a las exigidas por el mismo Ministerio. En Educación Inicial, Educación Primaria, Educación Media General comprende las clases de Inglés, Italiano y Computación. En Educación Media General comprende horas adicionales de matemáticas, castellano, sociales, curso de cultura e idioma italiano, inglés impartido a través de academias especializadas con grupos de reducidos número de alumnos, Horas de orientación. Además incluye en todos los niveles las conmemoraciones y participación en distintas actividades que forman parte de la idiosincracia de LA INSTITUCIÓN. Estas Actividades Extracurriculares son optativas.
    Cláusula Sexta: LA INSTITUCION se compromete a prestar sus servicios a EL ESTUDIANTE, empleando para ello todos sus conocimientos y dedicación para el mayor éxito de las funciones que le son encomendadas; y, por su parte, EL REPRESENTANTE LEGAL se obliga a cumplir y hacer cumplir a EL ESTUDIANTE, todas y cada una de las estipulaciones del presente contrato, así como El Manual de Convivencia Escolar de LA INSTITUCIÓN. Asimismo, EL REPRESENTANTE LEGAL como contraprestación al servicio que se obliga impartir LA INSTITUCIÓN, pagará a ésta los derechos de matrícula, escolaridad y actividades extracurriculares correspondientes al año escolar anteriormente definido, que incluyen el pago de doce (12) cuotas mensuales y consecutivas, las cuales deberán ser canceladas durante los primeros cinco (5) días de cada mes. El retraso en el pago puede generar intereses de mora. 
	Cláusula Séptima: EL REPRESENTANTE LEGAL y LA INSTITUCION están obligados a cumplir y hacer cumplir lo que establece la normativa legal vigente en cuanto a establecer las acciones necesarias para mantener el equilibrio esperado en la salud física y mental de EL ESTUDIANTE. Asimismo, EL REPRESENTANTE LEGAL  deberá asistir a todas las citaciones y reuniones que LA INSTITUCIÓN establezca a fin de que se logre la comunicación necesaria, asertiva y oportuna para lograr el desarrollo integral de EL ESTUDIANTE. En estas reuniones y/o citaciones tanto EL REPRESENTANTE LEGAL  como  LA INSTITUCION deberán cumplir con los acuerdos que se generen en ellas y en oportunidades, cuando la situación lo amerite, EL ESTUDIANTE será parte importante en el cumplimiento de lo acordado, por lo que el mismo deberá ser incluido en dichas acciones académico-administrativas.
    Cláusula Octava: EL REPRESENTANTE LEGAL declara expresamente aceptar los montos fijados como derechos de escolaridad para el año escolar, los cuales podrán ser objeto de ajustes por variación de los costos, tales como incremento en la remuneración del personal, aumentos de los servicios públicos, bonos, cualquier otro tipo de beneficio, aumentos de equipos, insumos, y/ o acuerdos de Contratación Magisterial, siempre y cuando sean permitidos legalmente. Queda entendido que en caso de ajustes de los derechos de la escolaridad, LA INSTITUCION deberá notificar por escrito a EL REPRESENTANTE LEGAL con por lo menos treinta (30) días de anticipación, la cual se hará mediante circular enviada a través de EL ESTUDIANTE. En caso de operar aumentos y EL REPRESENTANTE LEGAL hubiere cancelado mensualidades por adelantado o aquellas correspondientes al período vacacional, una vez se practique la debida notificación se deberá pagar la diferencia respectiva. 
    Cláusula Novena: La falta de pago de una o más mensualidades o cuotas por parte de EL REPRESENTANTE LEGAL, se considerará como imposibilidad en sustentar la educación privada de su representado o EL ESTUDIANTE, por lo que LA INSTITUCION coadyuvará en la búsqueda y consecución de un cupo en una institución de carácter público para éste. 
    Cláusula Décima: En caso de resolución anticipada del presente contrato o en el caso de que EL ESTUDIANTE sea retirado, EL REPRESENTANTE LEGAL estará obligado a cancelar hasta la mensualidad correspondiente a la fecha del retiro , y no tendrá derecho al reembolso o reintegro bajo ningún concepto ni por ninguna causa de lo pagado por concepto de matrícula, escolaridad, renovación de inscripción, seguro escolar, mensualidades y material. EL REPRESENTANTE LEGAL libera a LA INSTITUCIÓN de cualquier responsabilidad legal relacionada con el retiro de EL ESTUDIANTE, motivado por el incumplimiento de este contrato tanto de EL REPRESENTANTE LEGAL como de EL ESTUDIANTE. 
    Cláusula Décimoprimera: EL REPRESENTANTE LEGAL podrá reservar la inscripción de EL ESTUDIANTE antes de la finalización del año escolar, llenando a tal efecto la planilla correspondiente y cancelando una parte de la misma. El pago que resultare pendiente será cancelado por EL REPRESENTANTE LEGAL en el transcurso del mes de julio. En caso que quedare pendiente parte del pago del año escolar inmediato anterior, la misma deberá ser pagada antes del primero (1ero) de septiembre del nuevo año escolar. 
    Cláusula Décimosegunda: La Ley Orgánica para la Protección del Niño y del Adolescente establece: 
    Artículo 54.- Los padres, representantes o responsables tienen la obligación inmediata de garantizar la educación de los niños y adolescentes . 
    Artículo 53 .- Todos los niños y adolescentes tienen derecho a la educación. Asimismo, tienen derecho a ser inscritos y recibir educación en una escuela, plantel o instituto oficial de carácter gratuito y cercano a su residencia. 
    Artículo 365. - La obligación alimentaria comprende todo lo relativo al sustento, vestido, habitación, educación, cultura, asistencia y atención médica, medicinas, recreación y deportes, requeridos por el niño y el adolescente. 
    Artículo 366 .- La obligación alimentaria es un efecto de la filiación legal o judicialmente establecida, que corresponde al padre y a la madre respecto a sus hijos que no hayan alcanzado la mayoridad. Esta obligación subsiste aun cuando exista privación o extinción de la patria potestad, o no se tenga la guarda del hijo, a cuyo efecto se fijará expresamente por el juez el monto que debe pagarse por tal concepto, en la oportunidad que se dicte la sentencia de privación o extinción de la patria potestad, o se dicte alguna de las medidas contempladas en el artículo 360 de esta Ley. 
    Artículo 223 .- El obligado alimentario que incumpla injustificadamente, será sancionado con multa de uno (1) a diez (10) meses de ingreso. 
    Por su parte, la Constitución de la República Bolivariana de Venezuela, en su artículo 103 consagra: Toda persona tiene derecho a una educación integral, de calidad, permanente, en igualdad de condiciones y oportunidades, sin más limitaciones que las derivadas de sus aptitudes, vocación y aspiraciones. La educación es obligatoria en todos sus niveles, desde el maternal, hasta el nivel medio diversificado. La impartida por el Estado es gratuita hasta el pregrado universitario. 
    En virtud a lo antes expuesto, queda expresamente establecido que EL REPRESENTANTE LEGAL por voluntad propia inscribe a EL ESTUDIANTE en LA INSTITUCIÓN , la cual como se estableció anteriormente, es una institución privada y no gratuita, por lo que se compromete a cancelar puntualmente las cuotas establecidas. Todo retraso en los pagos genera intereses de mora a razón de 1% mensual.
    Cláusula Décimotercera: Queda expresamente convenido que LA INSTITUCION no es responsable por daños sufridos por los alumnos durante su permanencia en sus instalaciones, ocasionados por terremotos, explosiones, inundaciones y/ o cualquier otra circunstancia de fuerza mayor o caso fortuito. 
    Cláusula Décimocuarta: LA INSTITUCION se obliga a mantener vigente una póliza de seguro de accidentes personales, por lo que, en caso de ocurrir algún siniestro , EL REPRESENTANTE LEGAL aceptará y estará conforme con el monto de la cobertura y condiciones de la póliza suscrita, así como la indemnización que acuerde la compañía de seguro y en consecuencia, libera de toda responsabilidad a LA INSTITUCION por cualquier excedente del monto cubierto, así como de otro daño que hubiere podido sufrir, ni por lucro cesante o daños emergentes. 
    Cláusula Décimoquinta: Si en el momento de la inscripción EL REPRESENTANTE LEGAL no solicitó la inscripción en cualquiera de las asignaciones o servicios prestados en el colegio, ésta no podrá realizarla hasta después de iniciarse el mes de enero del año escolar en curso. 
    Cláusula Décimosexta: Queda expresamente convenido que en caso de que EL ESTUDIANTE llegare a contraer una enfermedad contagiosa, EL REPRESENTANTE LEGAL deberá abstenerse de enviarlo a LA INSTITUCIÓN, debiendo en todo caso, enviar una comunicación escrita con la constancia médica correspondiente. 
    Cláusula Décimoséptima: Toda solicitud de constancia de estudios y/o algún otro documento, de ser procedente, será tramitada en un lapso mínimo de tres (3) días hábiles contados a partir de la fecha efectiva de su solicitud. 
    Cláusula Décimoctava: EL REPRESENTANTE LEGAL no podrá enviar para retirar de LA INSTITUCIÓN a EL ESTUDIANTE, a una persona que no haya sido autorizada previamente por EL REPRESENTANTE LEGAL por escrito. 
    Cláusula Décimonovena: En caso de ocurrir hechos que menoscaben la integridad material de LA INSTITUCIÓN, EL REPRESENTANTE LEGAL se compromete a cubrir los gastos de reposición de aquellos bienes que hayan sufrido daños, causados por EL ESTUDIANTE. 
    Cláusula Vigésima: Queda expresamente convenido que LA INSTITUCIÓN presta como servicios complementarios y/o actividades extracurriculares, servicio de comedor, clases de danza, computación, kárate, futbolito, pintura, ajedrez, por lo que en caso de ser contratados por EL REPRESENTANTE LEGAL para EL ESTUDIANTE, los mismos deberán ser cancelados aparte y de forma adicional a las mensualidades. 
    Cláusula Vigésimaprimera: Queda expresamente convenido que LA INSTITUCIÓN no presta servicio de transporte escolar, por lo que no se hace responsable por la forma en que EL ESTUDIANTE llega y/o se retira de LA INSTITUCIÓN. 
    Cláusula Vigésimasegunda: EL REPRESENTANTE LEGAL  queda enterado que las actividades tales como: educación física, recreo, culturales y demás propias del colegio se realizan también en una cancha múltiple ubicada a una quinta de por medio a las instalaciones del colegio y por lo tanto autoriza al colegio para trasladar a su representado a la misma. Además, autoriza a su representado a participar en las salidas para la iglesia de Santa Eduvigis, comparsas y demás actividades que organice el colegio según la programación del año escolar.
	Cláusula Vigésimatercera:  Por medio del presente documento EL REPRESENTANTE LEGAL declara Si ____ / No ____ autorizar a EL ESTUDIANTE para que al finalizar las actividades escolares salga de LA INSTITUCION por sus propios medios. 
    Ambas partes  declaran expresamente formalizar la inscripción de acuerdo a la información suministrada por el representante en la planilla de inscripción anexa al presente contrato.
    Se hacen dos ejemplares de un mismo tenor y a un solo efecto, en Caracas a los $hoy_dia días del mes $hoy_mes de $hoy_ano. ",0,'J');


$pdf->SetDrawColor(0);

$pdf->Cell(200 , $Ln2*2 , 'Firmo en señal de haber leído y estar conforme en todas y cada una de sus partes' , 0 , 1 , 'L'); 
foreach ($Padres as $Padre){
LetraTit($pdf);
$pdf->Cell(200 , $Ln2*2 , $Padre.' / Autorizado' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(70 , $Ln2+1 , 'Nombre' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'Cédula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 
$pdf->Cell(70 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1.2 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1.2 , '' , $borde2 , 1 , 'L'); 
}


$pdf->Ln(1);
$pdf->Cell(200 , $Ln2*1.5 , 'AUTORIZACIÓN' , '' , 1 , 'C'); 
$pdf->MultiCell(200 , $Ln2*1.5 , 'Yo: _________________________________________ Autorizo a mi hijo(a) a retirarse del plantel por sus propios medios luego de terminar las actividades escolares. ' , 0 , 'J'); 
$pdf->Cell(70 , $Ln2+1 , 'Fecha' , $borde1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2+1 , 'Cédula de Ident. No.' , $borde1 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2+1 , 'Firma' , $borde1 , 1 , 'L'); 

$pdf->Cell(70 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*1 , '' , $borde2 , 0 , 'L'); 
$pdf->Cell(80 , $Ln2*1 , '' , $borde2 , 1 , 'L'); 

/*
$pdf->SetFont('Arial','B',10);
$pdf->Ln(1);
$pdf->Cell(200 , $Ln2 , '' , 'T' , 1 , 'C'); 
$pdf->Cell(80 , $Ln2*1.3 , 'Actividades en la tarde:' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(20 , $Ln2*1.5 , 'Comedor' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Tareas' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Futbol' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Danza' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Compu' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Pint' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Otra' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(20 , $Ln2*1.5 , '_______________' , 0 , 0 , 'L');
*/

$pdf->SetFont('Arial','B',10);
$pdf->Ln(1);
$pdf->Cell(200 , $Ln2 , '' , '' , 1 , 'C'); 
$pdf->Cell(80 , $Ln2*1.2 , 'Documentos que se anexan a la planilla (Copia): ' , 0 , 1 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(20 , $Ln2*1.5 , 'Part. Nac.' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Alum' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Padre' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Madre' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'CI Autoriz' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Fotos Al.' , 0 , 0 , 'R'); $pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Ln(1);
$pdf->Ln($Ln2*2);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(48 , $Ln2*1.5 , 'Comprobante de Pago:' , 0 , 0 , 'L'); 
LetraGdeBlk($pdf);
$pdf->Cell(18 , $Ln2*1.5 , 'Depósito' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Transf.' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(18 , $Ln2*1.5 , 'Cheque' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
if($row_RS_Alumno['Deuda_Actual']>0){
$pdf->Cell(55 , $Ln2*1.5 , 'Solvencia '.$row_RS_Alumno['Deuda_Actual'].'' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2*1.5 , '' , 1 , 0 , 'L'); 
$pdf->Cell(23 , $Ln2*1.5 , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] , 0 , 1 , 'R'); }
else
$pdf->Cell(83 , $Ln2*1.5 , 'Cod: '.$row_RS_Alumno['CodigoAlumno'] , 0 , 1 , 'R'); 


$pdf->Ln(2);
LetraPeq($pdf);
$pdf->Cell(50 , $Ln2*2 , 'Banco:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Fecha:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Núm:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Monto:' , 1 , 0 , 'L'); 
$pdf->Ln($Ln2*2);
$pdf->Cell(100 , $Ln2*2 , 'Recibido por: nombre:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Firma:' , 1 , 0 , 'L'); 
$pdf->Cell(50 , $Ln2*2 , 'Fecha:' , 1 , 0 , 'L'); 
//$pdf->Ln($Ln2*2+3);
/*
LetraPeq($pdf);
$pdf->Cell(60 , $Ln2 , '¿Recibe las circulares via email? ' , 0 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'si' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(8 , $Ln2 , 'no' , 0 , 0 , 'R'); 
$pdf->Cell(5 , $Ln2 , '' , 1 , 0 , 'L'); 
$pdf->Cell(60 , $Ln2 , '  E-mail: _____________________________________ ' , 0 , 0 , 'L'); 
*/

?>